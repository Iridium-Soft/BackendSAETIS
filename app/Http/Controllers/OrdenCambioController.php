<?php

namespace App\Http\Controllers;

use App\Models\OrdenCambio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
