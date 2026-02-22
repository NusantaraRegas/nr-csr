<?php

namespace Tests\Feature;

use App\Http\Controllers\APIController;
use App\Services\PaymentReceiverService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ApiResponseContractTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useSqliteInMemory();
        $this->prepareContractTables();

        config()->set('data_receiver.legacy_options.enabled', true);
        config()->set('data_receiver.legacy_options.phase', 'phase1');
        config()->set('data_receiver.legacy_options.disabled_status', 410);
        config()->set('data_receiver.legacy_options.log_channel', 'stack');
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

    public function test_data_receiver_returns_standard_success_envelope()
    {
        $this->app->instance(PaymentReceiverService::class, new class extends PaymentReceiverService
        {
            public function fetchReceiverNames($userId = '1211'): array
            {
                return ['Receiver A', 'Receiver B'];
            }
        });

        $response = $this->getJson('/api/dataReceiver');

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('message', 'Data receiver berhasil ditampilkan');
        $response->assertJsonPath('data.receivers.0.name', 'Receiver A');
        $response->assertJsonPath('data.receivers.0.value', 'Receiver A');
        $response->assertJsonPath('data.receivers.0.label', 'Receiver A');
        $response->assertJsonPath('errors', null);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'receivers',
            ],
            'errors',
            'meta',
        ]);
    }

    public function test_data_receiver_failure_returns_standard_error_envelope()
    {
        $this->app->instance(PaymentReceiverService::class, new class extends PaymentReceiverService
        {
            public function fetchReceiverNames($userId = '1211'): array
            {
                throw new \RuntimeException('Simulated receiver upstream failure.');
            }
        });

        $response = $this->getJson('/api/dataReceiver');

        $response->assertStatus(502);
        $response->assertJsonPath('success', false);
        $response->assertJsonPath('meta.code', 'DATA_RECEIVER_FETCH_FAILED');
        $response->assertJsonStructure([
            'success',
            'message',
            'data',
            'errors',
            'meta',
        ]);
    }

    public function test_legacy_data_receiver_options_route_returns_html_options()
    {
        $this->app->instance(PaymentReceiverService::class, new class extends PaymentReceiverService
        {
            public function fetchReceiverNames($userId = '1211'): array
            {
                return ['Receiver A', 'Receiver B'];
            }
        });

        $response = $this->get('/legacy/dataReceiver/options');

        $response->assertStatus(200);
        $response->assertSee('<option></option>', false);
        $response->assertSee('<option value="Receiver A">Receiver A</option>', false);
        $response->assertHeader('Content-Type', 'text/html; charset=UTF-8');
        $response->assertHeader('Deprecation', 'true');
        $response->assertHeader('X-Legacy-Endpoint', 'deprecated');
    }

    public function test_legacy_data_receiver_options_phase1_emits_usage_warning_log()
    {
        $this->app->instance(PaymentReceiverService::class, new class extends PaymentReceiverService
        {
            public function fetchReceiverNames($userId = '1211'): array
            {
                return ['Receiver A'];
            }
        });

        Log::shouldReceive('channel')->with('stack')->andReturnSelf()->atLeast()->once();
        Log::shouldReceive('warning')->withArgs(function ($event, array $context) {
            return $event === 'legacy.data_receiver_options.deprecated_access'
                && data_get($context, 'endpoint') === '/legacy/dataReceiver/options'
                && data_get($context, 'phase') === 'phase1'
                && data_get($context, 'successor') === '/api/dataReceiver';
        })->once();

        $response = $this->get('/legacy/dataReceiver/options');

        $response->assertStatus(200);
    }

    public function test_legacy_data_receiver_options_phase2_returns_deterministic_error_contract()
    {
        config()->set('data_receiver.legacy_options.phase', 'phase2');

        $response = $this->getJson('/legacy/dataReceiver/options');

        $response->assertStatus(410);
        $response->assertJsonPath('success', false);
        $response->assertJsonPath('meta.code', 'LEGACY_DATA_RECEIVER_OPTIONS_DECOMMISSIONED');
        $response->assertJsonPath('errors.endpoint', '/legacy/dataReceiver/options');
        $response->assertJsonPath('errors.successor', '/api/dataReceiver');
        $response->assertHeader('X-Legacy-Endpoint', 'disabled');
    }

    public function test_legacy_data_receiver_options_can_be_disabled_by_feature_flag()
    {
        config()->set('data_receiver.legacy_options.enabled', false);

        $response = $this->getJson('/legacy/dataReceiver/options');

        $response->assertStatus(410);
        $response->assertJsonPath('meta.code', 'LEGACY_DATA_RECEIVER_OPTIONS_DECOMMISSIONED');
        $response->assertHeader('X-Legacy-Endpoint', 'disabled');
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

    public function test_api_controller_data_provinsi_uses_standard_success_envelope_when_reactivated()
    {
        $response = app(APIController::class)->dataProvinsi();
        $payload = $response->getData(true);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($payload['success']);
        $this->assertSame('Data provinsi berhasil ditampilkan', $payload['message']);
        $this->assertSame('Jawa Barat', data_get($payload, 'data.0.provinsi'));
        $this->assertNull($payload['errors']);
        $this->assertArrayHasKey('meta', $payload);
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
