<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ApiResponseContractTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useSqliteInMemory();
        $this->prepareContractTables();
    }

    public function test_data_provinsi_returns_standard_success_envelope()
    {
        $response = $this->getJson('/api/dataProvinsi');

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('message', 'Data provinsi berhasil ditampilkan');
        $response->assertJsonPath('data.0.provinsi', 'Jawa Barat');
        $response->assertJsonPath('errors', null);
        $response->assertJsonStructure([
            'success',
            'message',
            'data',
            'errors',
            'meta',
        ]);
    }

    public function test_update_status_returns_standard_success_envelope()
    {
        $response = $this->postJson('/api/updateStatus', [
            'pembayaran_id' => 1,
            'pr_id' => 'PR-001',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('message', 'Data berhasil diubah');
        $response->assertJsonPath('data.pr_id', 'PR-001');
        $response->assertJsonPath('data.pembayaran_id', 1);
    }

    public function test_data_kecamatan_validation_error_uses_standard_error_envelope()
    {
        $response = $this->postJson('/api/dataKecamatan', []);

        $response->assertStatus(422);
        $response->assertJsonPath('success', false);
        $response->assertJsonPath('meta.code', 'VALIDATION_ERROR');
        $response->assertJsonStructure([
            'success',
            'message',
            'data',
            'errors',
            'meta',
        ]);
    }

    public function test_health_dependencies_requires_token_when_configured()
    {
        config()->set('health.auth.token', 'secret-health-token');

        $response = $this->getJson('/api/health/dependencies');

        $response->assertStatus(401);
        $response->assertJsonPath('success', false);
        $response->assertJsonPath('meta.code', 'UNAUTHORIZED');
    }

    public function test_data_kabupaten_unhandled_exception_uses_standard_error_envelope()
    {
        $response = $this->getJson('/api/dataKabupaten/Jawa%20Barat');

        $response->assertStatus(500);
        $response->assertJsonPath('success', false);
        $response->assertJsonPath('meta.code', 'INTERNAL_SERVER_ERROR');
    }

    private function useSqliteInMemory()
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');

        DB::purge('sqlite');
        DB::reconnect('sqlite');
    }

    private function prepareContractTables()
    {
        Schema::dropIfExists('tbl_provinsi');
        Schema::dropIfExists('tbl_pembayaran');

        Schema::create('tbl_provinsi', function (Blueprint $table) {
            $table->increments('id_provinsi');
            $table->string('provinsi')->nullable();
        });

        Schema::create('tbl_pembayaran', function (Blueprint $table) {
            $table->increments('id_pembayaran');
            $table->string('pr_id')->nullable();
        });

        DB::table('tbl_provinsi')->insert([
            'id_provinsi' => 1,
            'provinsi' => 'Jawa Barat',
        ]);

        DB::table('tbl_pembayaran')->insert([
            'id_pembayaran' => 1,
            'pr_id' => null,
        ]);
    }
}
