<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityUploadHardeningTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useSqliteInMemory();
        $this->prepareKelayakanTables();
        $this->seedKelayakan();
    }

    public function test_store_dokumen_accepts_valid_pdf_and_uses_safe_filename()
    {
        Storage::fake('attachment');

        $response = $this
            ->withSession($this->authenticatedUserSession())
            ->post('/proposal/storeDokumen', [
                'kelayakanID' => encrypt(1),
                'nama' => 'Surat Pengantar dan Proposal',
                'lampiran' => UploadedFile::fake()->create('proposal.pdf', 256, 'application/pdf'),
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('suksesDetail');

        $saved = DB::table('tbl_lampiran')->first();
        $this->assertNotNull($saved);

        $storedFile = $saved->lampiran ?? $saved->LAMPIRAN ?? null;
        if ($storedFile === null) {
            $files = Storage::disk('attachment')->allFiles();
            $this->assertCount(1, $files);
            $storedFile = $files[0];
        }

        $this->assertRegExp('/^[a-z0-9-]+-\d{14}-[a-f0-9]{8}\.pdf$/', basename($storedFile));
        Storage::disk('attachment')->assertExists($storedFile);
    }

    public function test_store_dokumen_rejects_spoofed_pdf_extension()
    {
        Storage::fake('attachment');

        $response = $this
            ->withSession($this->authenticatedUserSession())
            ->post('/proposal/storeDokumen', [
                'kelayakanID' => encrypt(1),
                'nama' => 'Surat Pengantar dan Proposal',
                'lampiran' => UploadedFile::fake()->create('spoofed.pdf', 128, 'text/plain'),
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('lampiran');
        $this->assertSame(0, DB::table('tbl_lampiran')->count());
    }

    public function test_store_dokumen_rejects_forbidden_file_type()
    {
        Storage::fake('attachment');

        $response = $this
            ->withSession($this->authenticatedUserSession())
            ->post('/proposal/storeDokumen', [
                'kelayakanID' => encrypt(1),
                'nama' => 'Surat Pengantar dan Proposal',
                'lampiran' => UploadedFile::fake()->create('shell.php', 32, 'text/x-php'),
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('lampiran');
        $this->assertSame(0, DB::table('tbl_lampiran')->count());
    }

    public function test_store_dokumen_rejects_oversized_upload()
    {
        Storage::fake('attachment');

        $response = $this
            ->withSession($this->authenticatedUserSession())
            ->post('/proposal/storeDokumen', [
                'kelayakanID' => encrypt(1),
                'nama' => 'Surat Pengantar dan Proposal',
                'lampiran' => UploadedFile::fake()->create('too-large.pdf', 6145, 'application/pdf'),
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('lampiran');
        $this->assertSame(0, DB::table('tbl_lampiran')->count());
    }

    private function useSqliteInMemory()
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');

        DB::purge('sqlite');
        DB::reconnect('sqlite');
    }

    private function prepareKelayakanTables()
    {
        Schema::dropIfExists('tbl_lampiran');
        Schema::dropIfExists('tbl_kelayakan');

        Schema::create('tbl_kelayakan', function (Blueprint $table) {
            $table->increments('id_kelayakan');
            $table->string('no_agenda')->nullable();
        });

        Schema::create('tbl_lampiran', function (Blueprint $table) {
            $table->increments('id_lampiran');
            $table->unsignedInteger('id_kelayakan')->nullable();
            $table->string('no_agenda')->nullable();
            $table->string('nama')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('upload_by')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamp('upload_date')->nullable();
        });
    }

    private function seedKelayakan()
    {
        DB::table('tbl_kelayakan')->insert([
            'id_kelayakan' => 1,
            'no_agenda' => 'AGD-001',
        ]);
    }

    private function authenticatedUserSession()
    {
        return [
            'user' => (object) [
                'id_user' => 1,
                'username' => 'security.tester',
                'role' => 'Inputer',
            ],
        ];
    }
}
