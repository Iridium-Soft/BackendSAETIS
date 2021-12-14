<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalificacionNotificacionConformidad extends Model
{
    use HasFactory;
    protected $fillable = [
        'puntajeObtenido',
        'campoEvaluable_id',
        'ordenDeCambio_id',
        'notificacionConformidad_id'
    ];
}
