<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservacionProp extends Model
{
    use HasFactory;
    protected $fillable = [
        'ord_cambio_id' ,
        'obs_propuesta_id' ,
    ];
}
