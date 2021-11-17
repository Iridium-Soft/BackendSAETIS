<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHitoPlanificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hito_planificacions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->date('fechaIni')->nullable();
            $table->date('fechaFin')->nullable();
            $table->integer('porcentajeCobro')->nullable();
            $table ->string('entregables')->nullable();
            $table->integer('planificacion_id')->unsigned()->nullable();
            $table->foreign('planificacion_id')->references('id')->on('planificacions')->onDelete('cascade');
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
        Schema::dropIfExists('hito_planificacions');
    }
}
