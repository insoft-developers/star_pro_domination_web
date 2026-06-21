<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldIntoTkaDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tka_details', function (Blueprint $table) {
            $table->string('gambar_a')->nullable()->after('soal_bawah');
            $table->string('gambar_b')->nullable()->after('gambar_a');
            $table->string('gambar_c')->nullable()->after('gambar_b');
            $table->string('gambar_d')->nullable()->after('gambar_c');
            $table->string('gambar_e')->nullable()->after('gambar_d');
            $table->string('jawaban_a')->nullable()->after('gambar_e');
            $table->string('jawaban_b')->nullable()->after('jawaban_a');
            $table->string('jawaban_c')->nullable()->after('jawaban_b');
            $table->string('jawaban_d')->nullable()->after('jawaban_c');
            $table->string('jawaban_e')->nullable()->after('jawaban_d');
            $table->string('kunci_jawaban')->nullable()->after('jawaban_e');
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
