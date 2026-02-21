<?php

namespace Tests\Feature;

use App\Http\Controllers\PekerjaanController;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TransactionBoundaryRollbackTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useSqliteInMemory();
        $this->preparePekerjaanTables();
    }

    public function test_store_lampiran_rolls_back_when_second_write_fails()
    {
        Storage::fake('attachment');

        session([
            'user' => (object) [
                'id_user' => 1,
                'username' => 'rollback.tester',
                'role' => 'Inputer',
            ],
        ]);

        $file = UploadedFile::fake()->create('rollback-proof.pdf', 128, 'application/pdf');
        $request = Request::create('/fake-store-lampiran', 'POST', [
            'pekerjaanID' => encrypt(1),
            'namaDokumen' => 'Lampiran Uji',
        ], [], [
            'lampiran' => $file,
        ]);

        // Intentionally no tbl_log_pekerjaan table to force failure on second write.
        $response = app(PekerjaanController::class)->storeLampiran($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame(0, DB::table('tbl_lampiran_pekerjaan')->count());
    }

    private function useSqliteInMemory()
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');

        DB::purge('sqlite');
        DB::reconnect('sqlite');
    }

    private function preparePekerjaanTables()
    {
        Schema::dropIfExists('tbl_lampiran_pekerjaan');
        Schema::dropIfExists('tbl_pekerjaan');

        Schema::create('tbl_pekerjaan', function (Blueprint $table) {
            $table->increments('pekerjaan_id');
            $table->string('kak')->nullable();
        });

        Schema::create('tbl_lampiran_pekerjaan', function (Blueprint $table) {
            $table->increments('lampiran_id');
            $table->unsignedInteger('pekerjaan_id');
            $table->string('nama_file')->nullable();
            $table->string('nama_dokumen')->nullable();
            $table->string('file')->nullable();
            $table->integer('size')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->string('upload_by')->nullable();
            $table->string('upload_date')->nullable();
        });

        DB::table('tbl_pekerjaan')->insert([
            'pekerjaan_id' => 1,
            'kak' => null,
        ]);
    }
}
