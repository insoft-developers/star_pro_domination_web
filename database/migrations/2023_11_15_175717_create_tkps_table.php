<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTkpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tkps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('judul');
            $table->integer('id_kelas');
            $table->integer('id_active');
            $table->integer('is_repeated');
            $table->integer('is_skipped');
            $table->integer('time_limit');
            $table->integer('target_score');
            $table->string('warna_soal');
            $table->string('warna_tulisan');
            $table->string('short_name');
            $table->string('warna_jawaban');
            $table->string('warna_tulisan_jawaban');
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
        Schema::dropIfExists('tkps');
    }
}
