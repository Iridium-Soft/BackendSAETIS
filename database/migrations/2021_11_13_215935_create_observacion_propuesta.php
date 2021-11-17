<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservacionPropuesta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observacion_propuestas', function (Blueprint $table) {
            $table->id();
            $table->string('nombreDoc');
            $table->string('seccionDoc')->nullable();
            $table->text('descripcion');
            $table->integer('ordenCambio_id')->unsigned()->nullable();
            $table->foreign('ordenCambio_id')->references('id')->on('orden_cambios')->onDelete('cascade');
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
        Schema::dropIfExists('observacion_propuestas');
    }
}
