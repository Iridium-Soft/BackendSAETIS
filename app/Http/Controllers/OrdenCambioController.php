<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Functions\FunctionRegisterOrdenCambio;
use App\Models\OrdenCambio;
use Illuminate\Http\Request;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ordenCambio = new OrdenCambio();
        $ordenCambio-> grupoempresa_id = $request->grupoempresa_id;
        $ordenCambio-> postulacion_id = $request->postulacion_id;
        $ordenCambio-> nombre = $request->nombre;
        $ordenCambio-> cod_orden_cambio = $request->cod_orden_cambio;
        $ordenCambio-> fecha_entrega = $request->fecha_entrega;
        $ordenCambio-> lugar_entrega = $request->lugar_entrega;
        $ordenCambio-> fecha_emision = $request->fecha_emision;
        $ordenCambio->save();
        $funcionSave = new FunctionRegisterOrdenCambio();
        $funcionSave::registrarEvaluaciones($request->evaluaion);
        $funcionSave::registrarObservaciones($request->observacion);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
