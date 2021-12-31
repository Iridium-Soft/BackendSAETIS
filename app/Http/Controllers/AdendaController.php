<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Functions\ModeloAdenda;
use App\Models\Adenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adenda  $adenda
     * @return \Illuminate\Http\Response
     */
    public function show(Adenda $adenda)
    {
        //
    }
    public function showDetallesAdenda($fileID)
    {
        $path = base_path(). "/storage/app/public/{$fileID}";
        $image = base64_encode(file_get_contents($path));
        return "data:@file/pdf;base64,{$image}";
    }
    public function estadoAdenda(Request $request,$id)
    {

        if (DB::table('adendas')->where('id', $id)->exists()) {
            $respuesta = "Adenda publicada previamente";
            $adenda = DB::table('adendas')->where('id', $id)->first();
            if($adenda->estado==false) {
                $flight = Adenda::find($id);
                $flight->estado = true;
                $flight->save();
                $respuesta = "Adenda publicada exitosamente";
            }
        }
        else{
            $respuesta="Adenda no encontrada";
        }
        return response()->json(['mensaje' => $respuesta]);
    }

    public function generarAD(Request $request, $id)
    {
        $modelo = new ModeloAdenda();
        $modelo ->crearAdenda($id);
        $salida = shell_exec('C:\xampp\htdocs\BackendSAETIS\Back\BackendSAETIS\public\execAD.bat');
        $adenda = Adenda::find($id);
        $path = $this->storeDocument();
        $adenda->documento = $path;
        $adenda->save();
        return $adenda;
    }


    public function storeDocument(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        $length = 20;
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $contents = Storage::disk('generado')->get('adenda.pdf');
        $imageName = "{$randomString}.pdf";
        Storage::disk('public')->put($imageName, $contents);
        return $imageName;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Adenda  $adenda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Adenda $adenda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adenda  $adenda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adenda $adenda)
    {
        //
    }
}
