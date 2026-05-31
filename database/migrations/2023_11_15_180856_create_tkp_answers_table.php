<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTkpAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tkp_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_session');
            $table->integer('id_user');
            $table->integer('id_soal');
            $table->string('no_soal');
            $table->string('jawaban_user');
            $table->string('waktu_selesai');
            $table->integer('status_jawaban');
            $table->integer('score');
            $table->integer('init_time');
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
        Schema::dropIfExists('tkp_answers');
    }
}
