<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePliegoEspecificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pliego_especificacions', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->text('titulo');
            $table->string('documento');
            $table->boolean('publica')->default(false);
            $table->foreignId('convocatoria_id')->constrained('convocatorias')->onDelete('cascade');
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
        Schema::dropIfExists('pliego_especificacions');
    }
}
