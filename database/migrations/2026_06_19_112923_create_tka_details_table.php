<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTkaDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tka_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tka_id');
            $table->string('no_soal');
            $table->string('soal');
            $table->string('gambar_soal')->nullable();
            $table->string('soal_bawah')->nullable();
            $table->integer('score');
            $table->integer('is_active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tka_details');
    }
}
