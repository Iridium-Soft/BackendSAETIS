<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservacionProp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observacion_props', function (Blueprint $table) {

            $table->integer('ord_cambio_id')->unsigned()->nullable();
            $table->integer('obs_propuesta_id')->unsigned()->nullable();
            $table->foreign('ord_cambio_id')->references('id')->on('orden_cambios')->onDelete('cascade');
            $table->foreign('obs_propuesta_id')->references('id')->on('observacion_propuestas')->onDelete('cascade');
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
        Schema::dropIfExists('observacion_props');
    }
}
