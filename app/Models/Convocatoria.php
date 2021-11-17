<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convocatoria extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo' ,
        'titulo' ,
        'descripcion',
        'consultorEnc',
        'fechaLimRec' ,
        'fechaIniDur',
        'fechaFinDur' ,
        'documento',
        'publica'
    ];




}
