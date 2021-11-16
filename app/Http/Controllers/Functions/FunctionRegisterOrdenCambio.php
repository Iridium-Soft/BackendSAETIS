<?php

namespace App\Http\Controllers\Functions;

use App\Models\Calificacion;
use App\Models\ObservacionPropuesta;
use Illuminate\Support\Facades\Log;

class FunctionRegisterOrdenCambio
{
    static function formResponse($register){

    }

    static function registrarEvaluaciones($evaluaciones, $idOrd){
        $tam =  $evaluaciones->collect('evaluacion')->count();

        for($i=0; $i<$tam; $i++){
            $calificacion = new Calificacion();
            $calificacion->puntajeObtenido = $evaluaciones->input("evaluacion.{$i}.puntuacion");
            $calificacion->campoEvaluable_id = $evaluaciones->input("evaluacion.{$i}.evaluacion_id");
            $calificacion->ordenCambio_id=$idOrd;
            $calificacion->save();
        }

    }

    static function registrarObservaciones($observaciones, $idOrd){
        $tam =  $observaciones->collect('observacion')->count();
        for($i=0; $i<$tam; $i++){
            $observacion = new ObservacionPropuesta();
            $observacion->nombreDoc = $observaciones->input("observacion.{$i}.documento");
            $observacion->seccionDoc = $observaciones->input("observacion.{$i}.seccion");
            $observacion->descripcion = $observaciones->input("observacion.{$i}.descripcion");
            $observacion->ordenCambio_id = $idOrd;
            $observacion->save();
        }
    }
}
