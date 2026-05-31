<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTkpDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tkp_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_tkp');
            $table->string('no_soal');
            $table->string('soal');
            $table->string('gambar_soal');
            $table->string('jawaban_a');
            $table->string('gambar_a');
            $table->string('jawaban_b');
            $table->string('gambar_b');
            $table->string('jawaban_c');
            $table->string('gambar_c');
            $table->string('jawaban_d');
            $table->string('gambar_d');
            $table->string('jawaban_e');
            $table->string('gambar_e');
            $table->integer('score_a');
            $table->integer('score_b');
            $table->integer('score_c');
            $table->integer('score_d');
            $table->integer('score_e');
            $table->integer('is_active');
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
        Schema::dropIfExists('tkp_details');
    }
}
