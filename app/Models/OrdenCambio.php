<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCambio extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo' ,
        'fechaEmContrato' ,
        'fechaFirma' ,
        'lugar',
        'estado'

    ];
}
