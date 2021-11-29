<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('documento');
            $table->foreignId('postulacion_id')->constrained('postulacions')->onDelete('cascade');
            $table->foreignId('detalleDoc_id')->constrained('detalle_docs')->onDelete('cascade');
           // $table->foreignId('revisionDoc_id')->constrained('documentos')->onDelete('cascade')->nullable();
            $table->integer('revisionDoc_id')->unsigned()->nullable();
            $table->foreign('revisionDoc_id')->references('id')->on('documentos')->onDelete('cascade');
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
        Schema::dropIfExists('documentos');
    }
}
