<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNrCsrTablesPart7 extends Migration
{
    public function up()
    {
        Schema::create('NR_CSR.TBL_WILAYAH', function (Blueprint $table) {
                    $table->increments('ID_WILAYAH');
                    $table->string('PROVINCE', 50)->nullable();
                    $table->string('CITY', 50)->nullable();
                    $table->string('CITY_NAME', 50)->nullable();
                    $table->string('SUB_DISTRICT', 50)->nullable();
                    $table->string('VILLAGE', 50)->nullable();
                    $table->string('POSTAL_CODE', 5)->nullable();
                });
    }

    public function down()
    {
        Schema::dropIfExists('NR_CSR.TBL_WILAYAH');
    }
}
