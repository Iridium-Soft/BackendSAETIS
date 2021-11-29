<?php

namespace App\Http\Controllers;

use App\Models\DetalleDoc;
use App\Models\Documento;
use App\Models\GrupoEmpresa;
use App\Models\ObservacionPropuesta;
use App\Models\OrdenCambio;
use App\Models\Postulacion;
use App\Models\responses\RespuestaGenerica;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;

class DocumentoController extends Controller
{

    public function index(Request $request)
    {
        $postulacion  = Postulacion::where('grupoEmpresa_id', $request->id)->first();
        $dataOrden = new RespuestaGenerica();
        $respuesta = new RespuestaGenerica();
        $dataDocRequeridos = new RespuestaGenerica();
        $documento=  collect();

        if(OrdenCambio::where('postulacion_id', $postulacion->id)->exists()){
            $orden = OrdenCambio::where('postulacion_id', $postulacion->id)->first();
            $dataOrden->idDocumento = $orden->id;
            $dataOrden->nombreDocumento = "Orden de Cambio";
            $dataOrden->codDocumento = $orden->codigo;
            $dataOrden->fechaRecepcion=$orden->fechaEmContrato;
            $dataOrden->documento = $orden->documento;
            $documento->add($dataOrden);
            $dataDocRequeridos = collect();
            $observaciones = ObservacionPropuesta::where('ordenDeCambio_id',$orden->id)->get();
            foreach (  $observaciones as $observacion){
                $docReq = DetalleDoc::find($observacion->documento_id);
                if( !$dataDocRequeridos->contains($docReq)){
                    $dataDocRequeridos->add($docReq);
                }
            }

        }


        $dataOrden1 = new RespuestaGenerica();
        $dataOrden1->idDocumento = $orden->id;
        $dataOrden1->nombreDocumento = "Adenda";
        $dataOrden1->codDocumento = $orden->codigo;
        $dataOrden1->fechaRecepcion=$orden->fechaEmContrato;
        $dataOrden1->documento = $orden->documento;
        $documento->add($dataOrden1);



        $respuesta->documento = $documento;
        $respuesta->docRequeridos = $dataDocRequeridos;
        $respuesta = collect($respuesta);
        return $respuesta;
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
