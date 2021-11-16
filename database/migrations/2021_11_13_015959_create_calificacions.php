<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalificacions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificacions', function (Blueprint $table) {
            $table->id();
            $table->integer('puntajeObtenido')->nullable();;
            $table->integer('campoEvaluable_id')->unsigned()->nullable();
            $table->foreign('campoEvaluable_id')->references('id')->on('campo_evaluables')->onDelete('cascade');
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
        Schema::dropIfExists('calificacions');
    }
}
