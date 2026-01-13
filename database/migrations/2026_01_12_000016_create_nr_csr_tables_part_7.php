<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNrCsrTablesPart7 extends Migration
{
    public function up()
    {
        Schema::create('nr_csr.tbl_wilayah', function (Blueprint $table) {
                    $table->increments('id_wilayah');
                    $table->string('province', 50)->nullable();
                    $table->string('city', 50)->nullable();
                    $table->string('city_name', 50)->nullable();
                    $table->string('sub_district', 50)->nullable();
                    $table->string('village', 50)->nullable();
                    $table->string('postal_code', 5)->nullable();
                });
    }

    public function down()
    {
        Schema::dropIfExists('nr_csr.tbl_wilayah');
    }
}
