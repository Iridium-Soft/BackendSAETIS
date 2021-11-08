<?php

namespace App\Models\responses;

use Illuminate\Database\Eloquent\Model;

class Postulaciones
{
    var $nombre= "muereteAndy";
    var $joto= true;


    function aniadir(Model $modelo) {
        $arrdeModelos = Arr::add($modelo);
        return $arrdeModelos;
    }
}
