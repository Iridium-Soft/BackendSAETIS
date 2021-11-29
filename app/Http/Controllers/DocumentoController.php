<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\GrupoEmpresa;
use App\Models\Postulacion;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{

    public function index(Request $request)
    {
        $grupoEmpresa = GrupoEmpresa::find($request->id);
        $postulacion  = Postulacion::where('grupoempresa_id', $grupoEmpresa->id)->first();
        $documento=  collect();
        $documento->parteA=$postulacion->parteA;
        $documento->boletaDeGarantia=$postulacion->boletaDeGarantia;
        $documento->cartaDePresentacion=$postulacion->cartaDePresentacion;
        $documento->constitucion=$postulacion->constitucion;
        $documento->parteB=$postulacion->parteB;
        return $documento;
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
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function show(Documento $documento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function edit(Documento $documento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documento $documento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Documento $documento)
    {
        //
    }
}
