<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'parteA',
        'boletaDeGarantia',
        'cartaDePresentacion',
        'constitucion',
        'parteB',
        'convocatoria_id',
        'grupoEmpresa_id'
    ];

}
