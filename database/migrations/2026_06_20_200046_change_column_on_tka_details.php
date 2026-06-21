<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnOnTkaDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tka_details', function (Blueprint $table) {
            $table->longText('soal')->change();
            $table->text('jawaban_a')->change()->nullable();
            $table->text('jawaban_b')->change()->nullable();
            $table->text('jawaban_c')->change()->nullable();
            $table->text('jawaban_d')->change()->nullable();
            $table->text('jawaban_e')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tka_details', function (Blueprint $table) {
            //
        });
    }
}
