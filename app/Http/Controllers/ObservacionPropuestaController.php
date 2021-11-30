<?php

namespace App\Http\Controllers;

use App\Models\DetalleDoc;
use App\Models\Documento;
use App\Models\ObservacionPropuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObservacionPropuestaController extends Controller
{
    public function aniadirObs(Request $request){
        $detDoc=Documento::where('id', $request->idDoc)->first();
        $observacion= new ObservacionPropuesta();
        $observacion->seccionDoc=$request->seccion;
        $observacion->descripcion=$request->descripcion;
        $observacion-> revisado=$request->revisado;
        $observacion->corregido=$request->corregido;
        $observacion->documento_id=$detDoc->id;
        $observacion->save();

        return($observacion);
    }
    public function aniadirArrObs(Request $request){
        $respuesta="Observaciones guardadas exitosamente";
        $tam=$request->collect()->count();
        for($i=0; $i<$tam; $i++){
            $id= $request->input("{$i}.idObservacion");
                    $flight = ObservacionPropuesta::find($id);
                    $flight->correccion = $request->input("{$i}.correccion");
                    $flight->revisado = $request->input("{$i}.revisado");
                    $flight->corregido = $request->input("{$i}.corregido");
                    $flight->save();
        }
        return response()->json(['mensaje' => $respuesta]);
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

        return ($image);
    }
}
