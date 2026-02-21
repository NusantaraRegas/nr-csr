<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PriorityTwoCriticalPathTransitionsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useSqliteInMemory();
        $this->prepareProposalLifecycleTables();
        $this->prepareApprovalTransitionTables();
    }

    public function test_store_sub_proposal_creates_lifecycle_record()
    {
        $response = $this
            ->withSession($this->authenticatedSession('Inputer'))
            ->post('/proposal/storeSubProposal', [
                'noAgenda' => 'AGD-100',
                'namaKetua' => 'Ketua Uji',
                'namaLembaga' => 'Lembaga Uji',
                'alamat' => 'Jl. Uji No. 1',
                'provinsi' => 'Jawa Barat',
                'kabupaten' => 'Bandung',
                'kambing' => 1,
                'hargaKambing' => '1.500.000',
                'sapi' => 0,
                'hargaSapi' => '0',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('sukses');

        $this->assertDatabaseHas('tbl_sub_proposal', [
            'no_agenda' => 'AGD-100',
            'nama_lembaga' => 'Lembaga Uji',
            'subtotal' => 1665000,
        ]);
    }

    public function test_update_sub_proposal_updates_lifecycle_fields()
    {
        DB::table('tbl_sub_proposal')->insert([
            'id_sub_proposal' => 10,
            'no_agenda' => 'AGD-200',
            'no_sub_agenda' => 'AGD-200.1',
            'nama_ketua' => 'Ketua Lama',
            'nama_lembaga' => 'Lembaga Lama',
            'kambing' => 1,
            'harga_kambing' => 1000000,
            'sapi' => 0,
            'harga_sapi' => 0,
            'total' => 1000000,
            'fee' => 100000,
            'ppn' => 10000,
            'subtotal' => 1110000,
            'alamat' => 'Alamat Lama',
            'provinsi' => 'Jawa Barat',
            'kabupaten' => 'Bandung',
        ]);

        $response = $this
            ->withSession($this->authenticatedSession('Inputer'))
            ->post('/proposal/editSubProposal', [
                'proposalID' => encrypt(10),
                'noAgenda' => 'AGD-200',
                'namaKetua' => 'Ketua Baru',
                'namaLembaga' => 'Lembaga Baru',
                'alamat' => 'Alamat Baru',
                'provinsi' => 'DKI Jakarta',
                'kabupaten' => 'Jakarta Selatan',
                'kambing' => 2,
                'hargaKambing' => '2.000.000',
                'sapi' => 1,
                'hargaSapi' => '12.000.000',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('sukses');

        $this->assertDatabaseHas('tbl_sub_proposal', [
            'id_sub_proposal' => 10,
            'nama_ketua' => 'Ketua Baru',
            'nama_lembaga' => 'Lembaga Baru',
            'subtotal' => 17760000,
        ]);
    }

    public function test_delete_sub_proposal_removes_lifecycle_record()
    {
        DB::table('tbl_sub_proposal')->insert([
            'id_sub_proposal' => 25,
            'no_agenda' => 'AGD-300',
            'no_sub_agenda' => 'AGD-300.1',
            'nama_ketua' => 'Ketua Hapus',
            'nama_lembaga' => 'Lembaga Hapus',
            'alamat' => 'Alamat Hapus',
            'provinsi' => 'Banten',
            'kabupaten' => 'Serang',
        ]);

        $token = 'delete-subproposal-token';
        $response = $this
            ->withSession(array_merge($this->authenticatedSession('Inputer'), ['_token' => $token]))
            ->delete('/proposal/deleteSubProposal/' . encrypt(25), [
                '_token' => $token,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('sukses');
        $this->assertDatabaseMissing('tbl_sub_proposal', ['id_sub_proposal' => 25]);
    }

    public function test_delete_sub_proposal_route_blocks_get_method()
    {
        $response = $this
            ->withSession($this->authenticatedSession('Inputer'))
            ->get('/proposal/deleteSubProposal/' . encrypt(11));

        $response->assertStatus(405);
    }

    public function test_delete_sub_proposal_route_blocks_missing_csrf_token()
    {
        $this->app['env'] = 'local';

        $response = $this
            ->withSession($this->authenticatedSession('Inputer'))
            ->delete('/proposal/deleteSubProposal/' . encrypt(11));

        $response->assertStatus(419);
    }

    public function test_delete_sub_proposal_route_blocks_unauthorized_role()
    {
        $token = 'forbidden-delete-subproposal-token';

        $response = $this
            ->withSession(array_merge($this->authenticatedSession('Approver 1'), ['_token' => $token]))
            ->delete('/proposal/deleteSubProposal/' . encrypt(11), [
                '_token' => $token,
            ]);

        $response->assertStatus(403);
    }

    public function test_approve_evaluator_moves_status_to_approved_1()
    {
        $response = $this
            ->withSession($this->authenticatedSession('Inputer'))
            ->get('/tasklist/approveEvaluator/1/CatatanEvaluator');

        $response->assertStatus(302);
        $response->assertSessionHas('berhasil');

        $this->assertDatabaseHas('tbl_evaluasi', [
            'id_evaluasi' => 1,
            'status' => 'Approved 1',
            'catatan2' => 'CatatanEvaluator',
        ]);
    }

    public function test_approve_kadep_moves_status_to_supplied_transition()
    {
        $response = $this
            ->withSession($this->authenticatedSession('Inputer'))
            ->get('/tasklist/approveKadep/1/CatatanKadep/Approved%202');

        $response->assertStatus(302);
        $response->assertSessionHas('berhasil');

        $this->assertDatabaseHas('tbl_evaluasi', [
            'id_evaluasi' => 1,
            'status' => 'Approved 2',
            'ket_kadin1' => 'CatatanKadep',
        ]);
    }

    public function test_approve_kadiv_rejected_updates_evaluasi_and_kelayakan_status()
    {
        $session = $this->authenticatedSession('Manager');
        $session['user']->username = 'manager.approver';

        $response = $this
            ->withSession($session)
            ->get('/tasklist/approveKadiv/1/CatatanKadiv/Rejected');

        $response->assertStatus(302);
        $response->assertSessionHas('berhasil');

        $this->assertDatabaseHas('tbl_evaluasi', [
            'id_evaluasi' => 1,
            'status' => 'Rejected',
            'ket_kadiv' => 'CatatanKadiv',
            'reject_by' => 'manager.approver',
        ]);

        $this->assertDatabaseHas('tbl_kelayakan', [
            'no_agenda' => 'AGD-APP-001',
            'status' => 'Rejected',
        ]);
    }

    private function useSqliteInMemory()
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');

        DB::purge('sqlite');
        DB::reconnect('sqlite');
    }

    private function prepareProposalLifecycleTables()
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

    private function prepareApprovalTransitionTables()
    {
        Schema::dropIfExists('v_evaluasi');
        Schema::dropIfExists('tbl_evaluasi');
        Schema::dropIfExists('tbl_user');
        Schema::dropIfExists('tbl_kelayakan');

        Schema::create('tbl_user', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('username')->nullable();
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
            $table->string('role')->nullable();
        });

        Schema::create('tbl_evaluasi', function (Blueprint $table) {
            $table->increments('id_evaluasi');
            $table->string('no_agenda')->nullable();
            $table->string('status')->nullable();
            $table->text('catatan2')->nullable();
            $table->date('approve_date')->nullable();
            $table->text('ket_kadin1')->nullable();
            $table->date('approve_kadep')->nullable();
            $table->text('ket_kadiv')->nullable();
            $table->date('approve_kadiv')->nullable();
            $table->date('reject_date')->nullable();
            $table->string('reject_by')->nullable();
        });

        Schema::create('tbl_kelayakan', function (Blueprint $table) {
            $table->increments('id_kelayakan');
            $table->string('no_agenda')->nullable();
            $table->string('status')->nullable();
        });

        Schema::create('v_evaluasi', function (Blueprint $table) {
            $table->integer('id_evaluasi');
            $table->string('no_agenda')->nullable();
            $table->string('pengirim')->nullable();
            $table->string('tgl_terima')->nullable();
            $table->string('asal_surat')->nullable();
            $table->string('no_surat')->nullable();
            $table->string('tgl_surat')->nullable();
            $table->string('sektor_bantuan')->nullable();
            $table->string('perihal')->nullable();
            $table->integer('nilai_pengajuan')->nullable();
            $table->integer('nilai_bantuan')->nullable();
            $table->string('evaluator1')->nullable();
            $table->string('evaluator2')->nullable();
            $table->string('kadep')->nullable();
            $table->string('kadiv')->nullable();
            $table->string('status')->nullable();
        });

        DB::table('tbl_user')->insert([
            [
                'id_user' => 1,
                'username' => 'evaluator.one',
                'nama' => 'Evaluator One',
                'email' => 'eval1@example.test',
                'role' => 'Inputer',
            ],
            [
                'id_user' => 2,
                'username' => 'evaluator.two',
                'nama' => 'Evaluator Two',
                'email' => 'eval2@example.test',
                'role' => 'Inputer',
            ],
            [
                'id_user' => 3,
                'username' => 'kadep.user',
                'nama' => 'Kadep User',
                'email' => 'kadep@example.test',
                'role' => 'Supervisor 1',
            ],
            [
                'id_user' => 4,
                'username' => 'manager.user',
                'nama' => 'Manager User',
                'email' => 'manager@example.test',
                'role' => 'Manager',
            ],
        ]);

        DB::table('tbl_evaluasi')->insert([
            'id_evaluasi' => 1,
            'no_agenda' => 'AGD-APP-001',
            'status' => 'Forward',
        ]);

        DB::table('tbl_kelayakan')->insert([
            'id_kelayakan' => 1,
            'no_agenda' => 'AGD-APP-001',
            'status' => 'Approved 2',
        ]);

        DB::table('v_evaluasi')->insert([
            'id_evaluasi' => 1,
            'no_agenda' => 'AGD-APP-001',
            'pengirim' => 'Pengirim Uji',
            'tgl_terima' => '2026-02-21',
            'asal_surat' => 'Jakarta',
            'no_surat' => '001/NR/II/2026',
            'tgl_surat' => '2026-02-20',
            'sektor_bantuan' => 'Pendidikan',
            'perihal' => 'Bantuan Pendidikan',
            'nilai_pengajuan' => 10000000,
            'nilai_bantuan' => 9000000,
            'evaluator1' => 'evaluator.one',
            'evaluator2' => 'evaluator.two',
            'kadep' => 'kadep.user',
            'kadiv' => 'manager.user',
            'status' => 'Forward',
        ]);
    }

    private function authenticatedSession($role)
    {
        return [
            'user' => (object) [
                'id_user' => 99,
                'username' => 'critical.path.user',
                'nama' => 'Critical Path User',
                'email' => 'critical-path@example.test',
                'role' => $role,
                'id_perusahaan' => 1,
                'perusahaan' => 'PT Nusantara Regas',
            ],
        ];
    }
}
