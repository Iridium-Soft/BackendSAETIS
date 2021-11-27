<?php

namespace App\Http\Controllers;

use App\Models\DetalleDoc;
use App\Models\ObservacionPropuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObservacionPropuestaController extends Controller
{
    public function aniadirObs(Request $request){
        $detDoc=DetalleDoc::where('id', $request->idDoc)->get()->first();
        $observacion= new ObservacionPropuesta();
        $observacion->seccionDoc=$request->seccion;
        $observacion->descripcion=$request->descripcion;
        $observacion->documento_id=$detDoc->id;
        $observacion->save();

        return($observacion);
    }

    public function eliminarObs($id){

        if (DB::table('observacion_propuestas')->where('id', $id)->exists()) {
            DB::table('observacion_propuestas')->whereId($id)->delete();
            $respuesta="Se ha eliminado exitosamente";
        }
        else{
            $respuesta="Se ha eliminado previamente";
        }

        return response()->json(['mensaje' => $respuesta]);
    }

    public function showDocs($fileID){
        $path = base_path(). "/storage/app/public/{$fileID}";
        $image = base64_encode(file_get_contents($path));

        return "data:@file/pdf;base64,{$image}";
    }
}