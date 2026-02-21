<?php

namespace Tests\Feature;

use App\Actions\Pembayaran\StorePembayaranAction;
use App\Actions\Pembayaran\UpdatePembayaranAction;
use Mockery;
use Tests\TestCase;

class PriorityOneMaintainabilityFlowsTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_dashboard_post_annual_requires_tahun()
    {
        $response = $this
            ->from('/dashboard')
            ->withSession($this->baseSession())
            ->post('/dashboard/postDashboardAnnual', []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['tahun']);
        $response->assertRedirect('/dashboard');
    }

    public function test_dashboard_post_annual_redirects_to_encrypted_annual_route()
    {
        $response = $this
            ->withSession($this->baseSession())
            ->post('/dashboard/postDashboardAnnual', [
                'tahun' => '2025',
            ]);

        $response->assertStatus(302);
        $this->assertStringContainsString('/dashboard/dashboardAnnual/', $response->headers->get('Location'));
    }

    public function test_api_post_payment_request_annual_requires_tahun_when_wilayah_filter_is_not_used()
    {
        $response = $this
            ->from('/report/listRealisasiAll')
            ->withSession($this->baseSession())
            ->post('/report/postPaymentRequestAnnual', []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['tahun']);
    }

    public function test_api_post_payment_request_annual_requires_wilayah_fields_when_filter_is_used()
    {
        $response = $this
            ->from('/report/listRealisasiAll')
            ->withSession($this->baseSession())
            ->post('/report/postPaymentRequestAnnual', [
                'checkBookWilayah' => '1',
                'tahun' => '2025',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['provinsi', 'kabupaten']);
    }

    public function test_api_post_payment_request_annual_redirects_to_annual_route_without_wilayah_filter()
    {
        $response = $this
            ->withSession($this->baseSession())
            ->post('/report/postPaymentRequestAnnual', [
                'tahun' => '2025',
            ]);

        $response->assertRedirect('/report/listRealisasiAllAnnual/2025');
    }

    public function test_api_post_payment_request_annual_redirects_to_provinsi_route_for_all_kabupaten()
    {
        $response = $this
            ->withSession($this->baseSession())
            ->post('/report/postPaymentRequestAnnual', [
                'checkBookWilayah' => '1',
                'tahun' => '2025',
                'provinsi' => 'JABAR',
                'kabupaten' => 'Semua Kabupaten/Kota',
            ]);

        $response->assertRedirect('/report/listPaymentRequestProvinsi/2025/JABAR');
    }

    public function test_api_post_payment_request_annual_redirects_to_kabupaten_route_for_specific_kabupaten()
    {
        $response = $this
            ->withSession($this->baseSession())
            ->post('/report/postPaymentRequestAnnual', [
                'checkBookWilayah' => '1',
                'tahun' => '2025',
                'provinsi' => 'JABAR',
                'kabupaten' => 'BANDUNG',
            ]);

        $response->assertRedirect('/report/listPaymentRequestProvinsi/2025/JABAR/BANDUNG');
    }

    public function test_kelayakan_cari_periode_requires_required_dates()
    {
        $response = $this
            ->from('/report/LaporanKelayakan')
            ->withSession($this->baseSession())
            ->post('/report/cariPeriode', [
                'tanggal2' => '2025-01-31',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['tanggal1']);
    }

    public function test_kelayakan_cari_periode_redirects_without_filters()
    {
        $response = $this
            ->withSession($this->baseSession())
            ->post('/report/cariPeriode', [
                'tanggal1' => '2025-01-01',
                'tanggal2' => '2025-01-31',
            ]);

        $response->assertRedirect('/report/dataPeriode/2025-01-01/2025-01-31');
    }

    public function test_kelayakan_cari_periode_redirects_to_provinsi_sdgs_jenis_when_all_filters_enabled()
    {
        $response = $this
            ->withSession($this->baseSession())
            ->post('/report/cariPeriode', [
                'tanggal1' => '2025-01-01',
                'tanggal2' => '2025-01-31',
                'checkBookWilayah' => '1',
                'checkBookPilar' => '1',
                'checkBookJenis' => '1',
                'provinsi' => 'JABAR',
                'kabupaten' => 'BANDUNG',
                'pilar' => 'Sosial',
                'gols' => '1',
                'jenis' => 'Donasi',
            ]);

        $location = $response->headers->get('Location');
        $path = parse_url($location, PHP_URL_PATH);

        $response->assertStatus(302);
        $this->assertStringContainsString('/report/dataProvinsiSDGsJenis/2025-01-01/2025-01-31/JABAR/', $path);
        $this->assertStringEndsWith('/Sosial/1/Donasi', $path);
    }

    public function test_kelayakan_cari_bulan_requires_fields()
    {
        $response = $this
            ->from('/report/LaporanKelayakan')
            ->withSession($this->baseSession())
            ->post('/report/cariBulan', [
                'bulan' => '1',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['tahun']);
    }

    public function test_kelayakan_cari_bulan_redirects_to_month_route()
    {
        $response = $this
            ->withSession($this->baseSession())
            ->post('/report/cariBulan', [
                'bulan' => '1',
                'tahun' => '2025',
            ]);

        $response->assertRedirect('/report/dataBulan/1/2025');
    }

    public function test_kelayakan_cari_tahun_requires_field()
    {
        $response = $this
            ->from('/report/LaporanKelayakan')
            ->withSession($this->baseSession())
            ->post('/report/cariTahun', []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['tahun']);
    }

    public function test_kelayakan_cari_tahun_redirects_to_year_route()
    {
        $response = $this
            ->withSession($this->baseSession())
            ->post('/report/cariTahun', [
                'tahun' => '2025',
            ]);

        $response->assertRedirect('/report/dataTahun/2025');
    }

    public function test_pembayaran_store_requires_deskripsi_and_does_not_execute_action()
    {
        $mock = Mockery::mock(StorePembayaranAction::class);
        $mock->shouldNotReceive('execute');
        $this->app->instance(StorePembayaranAction::class, $mock);

        $response = $this
            ->from('/payment/form')
            ->withSession($this->baseSession())
            ->post('/payment/storePembayaran', [
                'kelayakanID' => encrypt(1),
                'termin' => 'Termin 1',
                'metode' => 'Popay',
                'jumlahPembayaranAsli' => '1000',
                'fee' => '5',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['deskripsi']);
    }

    public function test_pembayaran_store_executes_action_on_valid_payload()
    {
        $mock = Mockery::mock(StorePembayaranAction::class);
        $mock->shouldReceive('execute')
            ->once()
            ->andReturn(redirect('/payment/mock-store-ok'));
        $this->app->instance(StorePembayaranAction::class, $mock);

        $response = $this
            ->withSession($this->baseSession())
            ->post('/payment/storePembayaran', [
                'kelayakanID' => encrypt(1),
                'deskripsi' => 'Pembayaran termin pertama',
                'termin' => 'Termin 1',
                'metode' => 'Popay',
                'jumlahPembayaranAsli' => '1000',
                'fee' => '5',
            ]);

        $response->assertRedirect('/payment/mock-store-ok');
    }

    public function test_pembayaran_update_requires_deskripsi_and_does_not_execute_action()
    {
        $mock = Mockery::mock(UpdatePembayaranAction::class);
        $mock->shouldNotReceive('execute');
        $this->app->instance(UpdatePembayaranAction::class, $mock);

        $response = $this
            ->from('/payment/form')
            ->withSession($this->baseSession())
            ->post('/payment/updatePembayaran', [
                'pembayaranID' => encrypt(1),
                'termin' => 'Termin 1',
                'metode' => 'Popay',
                'jumlahPembayaranAsli' => '1000',
                'fee' => '5',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['deskripsi']);
    }

    public function test_pembayaran_update_executes_action_on_valid_payload()
    {
        $mock = Mockery::mock(UpdatePembayaranAction::class);
        $mock->shouldReceive('execute')
            ->once()
            ->andReturn(redirect('/payment/mock-update-ok'));
        $this->app->instance(UpdatePembayaranAction::class, $mock);

        $response = $this
            ->withSession($this->baseSession())
            ->post('/payment/updatePembayaran', [
                'pembayaranID' => encrypt(1),
                'deskripsi' => 'Update pembayaran termin pertama',
                'termin' => 'Termin 1',
                'metode' => 'Popay',
                'jumlahPembayaranAsli' => '1000',
                'fee' => '5',
            ]);

        $response->assertRedirect('/payment/mock-update-ok');
    }

    private function baseSession()
    {
        return [
            'user' => (object) [
                'role' => 'Admin',
                'username' => 'tester',
                'id_perusahaan' => 1,
                'perusahaan' => 'PT Nusantara Regas',
            ],
        ];
    }
}
