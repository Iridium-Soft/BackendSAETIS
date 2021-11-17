<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacionConf extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo' ,
        'fechaEmDocumento' ,
        'fechaFirma' ,
        'lugar',
        'estado'
    ];
}
