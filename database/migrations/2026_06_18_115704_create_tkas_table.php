<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTkasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tkas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('judul');
            $table->string('id_kelas');
            $table->integer('is_active')->nullable();
            $table->integer('is_skipped')->nullable();
            $table->integer('is_repeated')->nullable();
            $table->integer('target_score')->nullable();
            $table->integer('time_limit')->nullable();
            $table->string('warna_soal')->nullable();
            $table->string('warna_tulisan')->nullable();
            $table->string('warna_jawaban')->nullable();
            $table->string('warna_tulisan_jawaban')->nullable();
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
        Schema::dropIfExists('tkas');
    }
}
