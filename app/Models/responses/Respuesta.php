<?php

namespace App\Models\responses;

class Respuesta
{
    var $nombreGP;
    var $documentos;

    public function __construct($nombreGP,$documentos){
        $this->nombreGP = $nombreGP;
        $this->documentos = $documentos;
    }
}
