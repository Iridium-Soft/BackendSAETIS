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
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Component\Translation\PseudoLocalizationTranslator;

class DocumentoController extends Controller
{

    public function index(Request $request,$id)
    {
        $postulacion  = Postulacion::where('grupoEmpresa_id', $id)->first();
        $respuesta = new RespuestaGenerica();
        $dataDocRequeridos = collect();
        $documentosRequeridos=  collect();

        if(OrdenCambio::where('postulacion_id', $postulacion->id)->where('estado',true)->exists()){
            $dataOrden = new RespuestaGenerica();
            $orden = OrdenCambio::where('postulacion_id', $postulacion->id)->where('estado',true)->first();
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
            if(Adenda::where('ordendecambio_id',$orden->id)->where('estado',true)->exists()){
                $adenda = Adenda::where('ordendecambio_id',$orden->id)->where('estado',true)->first();
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

        if(NotificacionConf::where('postulacion_id',$postulacion->id)->where('estado',true)->exists()){
            $notificacion = NotificacionConf::where('postulacion_id',$postulacion->id)->where('estado',true)->first();
            $dataNotificacion->idDocumento = $notificacion->id;
            $dataNotificacion->nombreDocumento = "Notificacion de Conformidad";
            $dataNotificacion->codDocumento = $notificacion->codigo;
            $dataNotificacion->fechaRecepcion=$notificacion->fechaEmDocumento;
            $dataNotificacion->documento = $notificacion->documento;
            $documentosRequeridos->add($dataNotificacion);
        }

        //Contrato

        $dataContrato = new RespuestaGenerica();
        if(Contrato::where('postulacion_id',$postulacion->id)->where('estado',true)->exists()){
            $contrato = Contrato::where('postulacion_id',$postulacion->id)->where('estado',true)->first();
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

    public function storeDocument($image_64){
        //$image_64 = $request->documento;
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
        $replace = substr($image_64, 0, strpos($image_64, ',')+1);
        $image = str_replace($replace, '', $image_64);
        $image = str_replace(' ', '+', $image);
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        $length = 20;
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $imageName = "{$randomString}.{$extension}";
        Storage::disk('public')->put($imageName, base64_decode($image));
        $path="app/public/{$imageName}";

        return $imageName;
    }

    public function recibirDocumentosRevision(Request $request)
    {
        $tam = collect($request)->count();
        $respuesta= "";
        $docIdPrueba = $request->input("0.documento_id");
        if(!Documento::where('revisionDoc_id', $docIdPrueba)->exists()){
            $postulacion = new Postulacion();
            for($i=0;$i<$tam;$i++){
                $docId = $request->input("{$i}.documento_id");
                $documentoOriginal = Documento::find($docId);
                $detalleDoc = DetalleDoc::find(($documentoOriginal->detalleDoc_id)+5);
                $documento = $request->input("{$i}.documento");
                $documentoRev = new Documento();
                $documentoRev-> documento = $this->storeDocument($documento);
                $documentoRev-> postulacion_id = $documentoOriginal->postulacion_id;
                $documentoRev->revisionDoc_id=$docId;
                $documentoRev-> detalleDoc_id = $detalleDoc->id;
                $documentoRev->save();
                $postulacion = Postulacion::find($documentoOriginal->postulacion_id);
            }
            $postulacion->estado_id = 9;
            $postulacion->save();
            $respuesta = "Documentos corregidos registrados correctamente";
        }else{
            $respuesta = "Documentos corregidos registrados previamente, Espere la respuesta de su consultor TIS.";
        }
        return ( $respuesta );
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
