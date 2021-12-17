<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostulacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulacions', function (Blueprint $table) {
            $table->id();
            $table->string('parteA')->nullable();
            $table->string('boletaDeGarantia')->nullable();
            $table->string('cartaDePresentacion')->nullable();
            $table->string('constitucion')->nullable();
            $table->string('parteB')->nullable();
            $table->foreignId('convocatoria_id')->constrained('convocatorias')->onDelete('cascade');
            $table->foreignId('grupoEmpresa_id')->nullable()->constrained('grupo_empresas')->onDelete('cascade');
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
        Schema::dropIfExists('postulacions');
    }
}
