<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservacionPropuesta extends Model
{
    use HasFactory;
    protected $fillable=[
        'nombreDoc' ,
        'seccionDoc' ,
        'descripcion',
        'documento_id'
    ];
}
