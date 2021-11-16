<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenCambiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_cambios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->Date('fechaEmContrato');
            $table->Datetime('fechaFirma')->nullable();
            $table->string('lugar');
            $table->boolean('estado');
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
        Schema::dropIfExists('orden_cambios');
    }
}
