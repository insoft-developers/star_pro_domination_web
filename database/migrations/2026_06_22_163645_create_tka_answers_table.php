<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTkaAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tka_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('session_id');
            $table->integer('user_id');
            $table->integer('soal_id');
            $table->string('no_soal');
            $table->string('jawaban_user')->nullable();
            $table->string('waktu_selesai')->nullable();
            $table->string('status_jawaban')->nullable();
            $table->string('hasil_jawaban')->nullable();
            $table->integer('score')->nullable();
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
        Schema::dropIfExists('tka_answers');
    }
}
