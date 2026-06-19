<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTkaDetailAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tka_detail_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tka_detail_id');
            $table->string('prefix');
            $table->string('image')->nullable();
            $table->string('answer_option_text')->nullable();
            $table->integer('answer_key')->nullable();
            $table->string('answer_text_key')->nullable();
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
        Schema::dropIfExists('tka_detail_answers');
    }
}
