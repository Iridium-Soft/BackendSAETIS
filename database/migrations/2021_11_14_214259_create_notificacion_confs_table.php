<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionConfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacion_confs', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->Date('fechaEmDocumento');
            $table->Datetime('fechaFirma')->nullable();
            $table->string('lugar');
            $table->boolean('estado')->default(false);
            $table->string('documento')->nullable();
            $table->integer('postulacion_id')->unsigned()->nullable();
            $table->foreign('postulacion_id')->references('id')->on('postulacions')->onDelete('cascade');
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
        Schema::dropIfExists('notificacion_confs');
    }
}
