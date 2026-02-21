<?php

namespace Tests\Feature;

use App\Http\Controllers\TasklistController;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Tests\TestCase;

class SecuritySqlInjectionRegressionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useSqliteInMemory();
        $this->prepareEvaluasiTable();
    }

    public function test_todo_query_keeps_malicious_username_as_plain_value()
    {
        DB::table('V_EVALUASI')->insert([
            ['EVALUATOR1' => 'alice', 'EVALUATOR2' => 'bob', 'STATUS' => 'Survei'],
            ['EVALUATOR1' => 'carol', 'EVALUATOR2' => 'dave', 'STATUS' => 'Survei'],
        ]);

        session([
            'user' => (object) [
                'username' => "alice' OR '1'='1",
                'role' => 'Inputer',
            ],
        ]);

        $result = app(TasklistController::class)->todo();

        $this->assertInstanceOf(View::class, $result);
        $this->assertSame(0, $result->getData()['jumlahData']);
        $this->assertCount(0, $result->getData()['dataEvaluasi']);
    }

    private function useSqliteInMemory()
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');

        DB::purge('sqlite');
        DB::reconnect('sqlite');
    }

    private function prepareEvaluasiTable()
    {
        Schema::dropIfExists('V_EVALUASI');

        Schema::create('V_EVALUASI', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('EVALUATOR1')->nullable();
            $table->string('EVALUATOR2')->nullable();
            $table->string('STATUS')->nullable();
        });
    }
}
