<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Functions\ModeloContrato;
use App\Models\Contrato;
use App\Models\Postulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContratoController extends Controller
{

    public function estadoContrato(Request $request,$id)
    {
        if (Contrato::find($id)) {
            $respuesta = "Contrato publicado publicado previamente";
            $contra = Contrato::find($id);
            if ($contra->estado==false) {
                $contra->estado = true;
                $contra->save();
                $respuesta = "Contrato publicado exitosamente";
                $postulacion = Postulacion::find($contra->postulacion_id);
                $postulacion->estado_id = 11;
                $postulacion ->save();
            }
        }
        else{
            $respuesta="contrato no encontrado";
        }
        return response()->json(['mensaje' => $respuesta]);
    }

    public function showDetallesContrato($fileID)
    {
        $path = base_path(). "/storage/app/public/{$fileID}";
        $image = base64_encode(file_get_contents($path));
        return "data:@file/pdf;base64,{$image}";
    }

    public function generarCN(Request $request, $id)
    {
        $modelo = new ModeloContrato();
        $modelo ->crearContrato($id);
        $salida = shell_exec('C:\xampp\htdocs\BackendSAETIS\Back\BackendSAETIS\public\execCN.bat');
        $contrato = Contrato::find($id);
        $path = $this->storeDocument();
        $contrato->documento = $path;
        $contrato->save();
        return $contrato;
    }


    public function storeDocument(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        $length = 20;
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $contents = Storage::disk('generado')->get('contrato.pdf');
        $imageName = "{$randomString}.pdf";
        Storage::disk('public')->put($imageName, $contents);
        return $imageName;
    }


}
