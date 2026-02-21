<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProposalModulePilotExtractionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useSqliteInMemory();
        $this->prepareSubProposalTable();
    }

    public function test_store_sub_proposal_pilot_flow_keeps_existing_calculation_behavior()
    {
        $response = $this
            ->withSession($this->authenticatedSession('Inputer'))
            ->post('/proposal/storeSubProposal', [
                'noAgenda' => 'AGD-PILOT-001',
                'namaKetua' => 'Ketua Pilot',
                'namaLembaga' => 'Lembaga Pilot',
                'alamat' => 'Jl. Pilot No. 1',
                'provinsi' => 'Jawa Barat',
                'kabupaten' => 'Bandung',
                'kambing' => 2,
                'hargaKambing' => '1.000.000',
                'sapi' => 1,
                'hargaSapi' => '10.000.000',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('sukses');

        $this->assertDatabaseHas('tbl_sub_proposal', [
            'no_agenda' => 'AGD-PILOT-001',
            'nama_lembaga' => 'Lembaga Pilot',
            'subtotal' => 13320000,
        ]);
    }

    public function test_store_sub_proposal_pilot_flow_preserves_duplicate_guard()
    {
        DB::table('tbl_sub_proposal')->insert([
            'id_sub_proposal' => 11,
            'no_agenda' => 'AGD-PILOT-002',
            'no_sub_agenda' => 'AGD-PILOT-002.1',
            'nama_ketua' => 'Ketua Existing',
            'nama_lembaga' => 'Lembaga Existing',
            'alamat' => 'Alamat Existing',
            'provinsi' => 'Banten',
            'kabupaten' => 'Serang',
        ]);

        $response = $this
            ->withSession($this->authenticatedSession('Inputer'))
            ->post('/proposal/storeSubProposal', [
                'noAgenda' => 'AGD-PILOT-002',
                'namaKetua' => 'Ketua Existing',
                'namaLembaga' => 'Lembaga Existing',
                'alamat' => 'Alamat Existing',
                'provinsi' => 'Banten',
                'kabupaten' => 'Serang',
                'kambing' => 0,
                'hargaKambing' => '0',
                'sapi' => 0,
                'hargaSapi' => '0',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('gagal');

        $count = DB::table('tbl_sub_proposal')
            ->where('no_agenda', 'AGD-PILOT-002')
            ->where('nama_lembaga', 'Lembaga Existing')
            ->count();

        $this->assertSame(1, (int) $count);
    }

    private function useSqliteInMemory()
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');

        DB::purge('sqlite');
        DB::reconnect('sqlite');
    }

    private function prepareSubProposalTable()
    {
        Schema::dropIfExists('tbl_sub_proposal');

        Schema::create('tbl_sub_proposal', function (Blueprint $table) {
            $table->increments('id_sub_proposal');
            $table->string('no_agenda')->nullable();
            $table->string('no_sub_agenda')->nullable();
            $table->string('nama_ketua')->nullable();
            $table->string('nama_lembaga')->nullable();
            $table->integer('kambing')->default(0);
            $table->integer('harga_kambing')->default(0);
            $table->integer('sapi')->default(0);
            $table->integer('harga_sapi')->default(0);
            $table->integer('total')->default(0);
            $table->integer('fee')->default(0);
            $table->integer('ppn')->default(0);
            $table->integer('subtotal')->default(0);
            $table->text('alamat')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
        });
    }

    private function authenticatedSession($role)
    {
        return [
            'user' => (object) [
                'id_user' => 99,
                'username' => 'pilot.user',
                'nama' => 'Pilot User',
                'email' => 'pilot@example.test',
                'role' => $role,
                'id_perusahaan' => 1,
                'perusahaan' => 'PT Nusantara Regas',
            ],
        ];
    }
}
