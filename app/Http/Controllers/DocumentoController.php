<?php

namespace App\Http\Controllers;

use App\Models\Adenda;
use App\Models\Contrato;
use App\Models\DetalleDoc;
use App\Models\Documento;
use App\Models\GrupoEmpresa;
use App\Models\NotificacionConf;
use App\Models\ObservacionPropuesta;
use App\Models\OrdenCambio;
use App\Models\Postulacion;
use App\Models\responses\RespuestaGenerica;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;

class DocumentoController extends Controller
{

    public function index(Request $request,$id)
    {
        $postulacion  = Postulacion::where('grupoEmpresa_id', $id)->first();
        $respuesta = new RespuestaGenerica();
        $dataDocRequeridos = collect();
        $documentosRequeridos=  collect();

        if(OrdenCambio::where('postulacion_id', $postulacion->id)->exists()){
            $dataOrden = new RespuestaGenerica();
            $orden = OrdenCambio::where('postulacion_id', $postulacion->id)->first();
            $dataOrden->idDocumento = $orden->id;
            $dataOrden->nombreDocumento = "Orden de Cambio";
            $dataOrden->codDocumento = $orden->codigo;
            $dataOrden->fechaRecepcion=$orden->fechaEmContrato;
            $dataOrden->documento = $orden->documento;
            $documentosRequeridos->add($dataOrden);

            $documentosPostulacion = Documento::where('postulacion_id' , $postulacion->id)
                ->where('id', '<', 6)->get();
            foreach($documentosPostulacion as $docu){
                if( ObservacionPropuesta::where('documento_id',$docu->id)->exists()){
                        if( !$dataDocRequeridos->contains($docu)){
                            $detalleDoc = DetalleDoc::find($docu->detalleDoc_id);
                            $docu->nombre = $detalleDoc->nombreDoc;
                        $dataDocRequeridos->add($docu);
                    }
                }
            }
            //Adenda
            $dataAdenda = new RespuestaGenerica();
            if(Adenda::where('ordendecambio_id',$orden->id)->exists()){
                $adenda = Adenda::where('ordendecambio_id',$orden->id)->first();
                $dataAdenda->idDocumento = $adenda->id;
                $dataAdenda->nombreDocumento = "Adenda";
                $dataAdenda->codDocumento = $adenda->codigo;
                $dataAdenda->fechaRecepcion=$adenda->fechaEmDocumento;
                $dataAdenda->documento = $adenda->documento;
                $documentosRequeridos->add($dataAdenda);
            }
        }

        //Notificacion de Conformidad
        $dataNotificacion = new RespuestaGenerica();
        if(NotificacionConf::where('postulacion_id',$postulacion->id)->exists()){
            $notificacion = Contrato::where('postulacion_id',$postulacion->id)->first();
            $dataNotificacion->idDocumento = $notificacion->id;
            $dataNotificacion->nombreDocumento = "Notificacion de Conformidad";
            $dataNotificacion->codDocumento = $notificacion->codigo;
            $dataNotificacion->fechaRecepcion=$notificacion->fechaEmDocumento;
            $dataNotificacion->documento = $notificacion->documento;
            $documentosRequeridos->add($dataNotificacion);
        }

        //Contrato

        $dataContrato = new RespuestaGenerica();
        if(Contrato::where('postulacion_id',$postulacion->id)->exists()){
            $contrato = Contrato::where('postulacion_id',$postulacion->id)->first();
            $dataContrato->idDocumento = $contrato->id;
            $dataContrato->nombreDocumento = "Contrato";
            $dataContrato->codDocumento = $contrato->codigo;
            $dataContrato->fechaRecepcion=$contrato->fechaEmDocumento;
            $dataContrato->documento = $contrato->documento;
            $documentosRequeridos->add($dataContrato);
        }

        $respuesta->documento = $documentosRequeridos;
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
