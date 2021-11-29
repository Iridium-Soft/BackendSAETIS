<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservacionPropuesta extends Model
{
    use HasFactory;
    protected $fillable=[
        'seccionDoc' ,
        'descripcion',
        'revisado',
        'corregido',
        'documento_id'
    ];
}
