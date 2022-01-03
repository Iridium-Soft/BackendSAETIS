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
            $table->text('lugar');
            $table->boolean('estado')->default(false);
            $table->string('documento')->nullable();
            $table->foreignId('postulacion_id')->constrained('postulacions')->onDelete('cascade');
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
