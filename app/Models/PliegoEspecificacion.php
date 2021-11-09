<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PliegoEspecificacion extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo' ,
        'titulo' ,
        'documento',
        'publica'
    ];
    protected $table="convocatoria_id";
}
