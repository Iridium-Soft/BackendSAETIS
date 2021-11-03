<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvocatoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convocatorias', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->text('titulo');
            $table->text('descripcion');
            $table->string('consultorEnc');
            $table->date('fechaLimRec');
            $table->date('fechaIniDur');
            $table->date('fechaFinDur');
            $table->string('documento');
            $table->boolean('publica')->default(false);
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
        Schema::dropIfExists('convocatorias');
    }
}
