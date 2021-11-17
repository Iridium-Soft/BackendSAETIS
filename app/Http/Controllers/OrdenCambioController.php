<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Functions\FunctionRegisterOrdenCambio;
use App\Http\Controllers\Functions\ModeloOrdenDeCambio;
use App\Models\OrdenCambio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrdenCambioController extends Controller
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

    public function getDatosNecesarios(Request $request){
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ordenCambio = new OrdenCambio();
        $ordenCambio-> postulacion_id = $request->postulacion_id;
        $ordenCambio-> estado = false;
        $ordenCambio-> codigo = $request->cod_orden_cambio;
        $ordenCambio-> fechaFirma = $request->fecha_entrega;
        $ordenCambio-> lugar = $request->lugar_entrega;
        $ordenCambio-> fechaEmContrato = $request->fecha_emision;
        $idOrden = $ordenCambio->save();
        $funcionSave = new FunctionRegisterOrdenCambio();
        $funcionSave::registrarEvaluaciones($request, $idOrden);
        $funcionSave::registrarObservaciones($request, $idOrden);
        $this -> generarOC($ordenCambio->id);
    }

    public function generarOC($id_OrdenCambio)
    {
        $modelo = new ModeloOrdenDeCambio();
        $modelo ->crearOrden($id_OrdenCambio);
        $salida = shell_exec('C:\xampp\htdocs\BackendSAETIS\Back\BackendSAETIS\public\execOC.bat');
       $ordenCambio = OrdenCambio::find($id_OrdenCambio);
       $path = $this->storeDocument();
        $ordenCambio->documento = $path;
        $ordenCambio->save();
        return $ordenCambio;
    }

    public function storeDocument(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        $length = 20;
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $contents = Storage::disk('generado')->get('ordenCambio.pdf');
        $imageName = "{$randomString}.pdf";
        Storage::disk('public')->put($imageName, $contents);
        return $imageName;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrdenCambio  $ordenCambio
     * @return \Illuminate\Http\Response
     */
    public function show(OrdenCambio $ordenCambio)
    {
        //
    }
    public function showDetallesOrden($fileID)
    {
        $path = base_path(). "/storage/app/public/{$fileID}";
        $image = base64_encode(file_get_contents($path));

        return "data:@file/pdf;base64,{$image}";
    }
    public function estadoOrdenC(Request $request,$id)
    {
        if (DB::table('orden_cambios')->where('id', $id)->exists()) {
            $respuesta = "se ha publicado previamente";
            $orden = DB::table('orden_cambios')->where('id', $id)->first();
            if ($orden->estado==false) {
                $flight = OrdenCambio::find($id);
                $flight->estado = true;
                $flight->save();
                $respuesta = "se ha publicado exitosamente";
            }
        }
        else{
            $respuesta="no existe la orden de cambio";
        }
        return response()->json(['mensaje' => $respuesta]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrdenCambio  $ordenCambio
     * @return \Illuminate\Http\Response
     */
    public function edit(OrdenCambio $ordenCambio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\OrdenCambio  $ordenCambio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrdenCambio $ordenCambio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrdenCambio  $ordenCambio
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrdenCambio $ordenCambio)
    {
        //
    }
}
