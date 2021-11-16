<?php

namespace App\Http\Controllers\Functions;

use App\Models\Calificacion;
use App\Models\ObservacionPropuesta;

class FunctionRegisterOrdenCambio
{
    static function formResponse($register){

    }

    static function registrarEvaluaciones($evaluaciones){
        $tam =  $evaluaciones->collect('evaluacion')->count();
        for($i=0; $i<$tam; $i++){
            $calificacion = new Calificacion();
            $calificacion->punajeObtenido = $evaluaciones->input("evaluacion.{$i}.punajeObtenido");
            $calificacion->campoEvaluable_id = $evaluaciones->input("evaluacion.{$i}.evaluacion_id");
            $calificacion->save();
        }
    }

    static function registrarObservaciones($observaciones){
        $tam =  $observaciones->collect('observacion')->count();
        for($i=0; $i<$tam; $i++){
            $observacion = new ObservacionPropuesta();
            $observacion->punajeObtenido = $observaciones->input("observacion.{$i}.punajeObtenido");
            $observacion->campoEvaluable_id = $observaciones->input("observacion.{$i}.evaluacion_id");
            $observacion->save();
        }
    }
}
