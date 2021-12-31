<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Functions\FunctionRegisterOrdenCambio;
use App\Http\Controllers\Functions\ModeloOrdenDeCambio;
use App\Models\Calificacion;
use App\Models\CampoEvaluable;
use App\Models\DetalleDoc;
use App\Models\Documento;
use App\Models\GrupoEmpresa;
use App\Models\ObservacionPropuesta;
use App\Models\OrdenCambio;
use App\Models\Postulacion;
use App\Models\responses\Documentos;
use App\Models\responses\Observaciones;
use App\Models\responses\Respuesta;
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


    public function store(Request $request)
    {
        $grupoEmpresa = GrupoEmpresa::where('nombre',$request->nombre)->first();
        $postu = Postulacion::where('grupoEmpresa_id', $grupoEmpresa->id)->first();
        $ordenCambio = new OrdenCambio();
        $ordenCambio-> postulacion_id = $postu->id;
        $ordenCambio-> estado = false;
        $ordenCambio-> codigo = $request->cod_orden_cambio;
        $ordenCambio-> fechaFirma = $request->fecha_entrega;
        $ordenCambio-> lugar = $request->lugar_entrega;
        $ordenCambio-> fechaEmContrato = $request->fecha_emision;
        $ordenCambio->save();
        $ordenCambio-> codigo ="OC-{$ordenCambio->id}/2021";
        $ordenCambio->save();
        $funcionSave = new FunctionRegisterOrdenCambio();
        $funcionSave::registrarEvaluaciones($request, $ordenCambio->id);
        $funcionSave::registrarObservaciones($request, $ordenCambio->id);
        return $ordenCambio;
    }

    public function registrarOrdenCalificacion(Request $request,$id)
    {
        $ordenCambio = OrdenCambio::where('postulacion_id',$id)->first();
        $ordenCambio-> postulacion_id = $id;
        $ordenCambio-> estado = false;
        $ordenCambio-> codigo = $request->cod_orden_cambio;
        $ordenCambio-> fechaFirma = $request->fecha_entrega;
        $ordenCambio-> lugar = $request->lugar_entrega;
        $ordenCambio-> fechaEmContrato = $request->fecha_emision;
        $ordenCambio->save();
        $ordenCambio-> codigo ="OC-{$ordenCambio->id}/2021";
        $ordenCambio->save();
        $funcionSave = new FunctionRegisterOrdenCambio();
        $funcionSave::registrarEvaluaciones($request, $ordenCambio->id);
        $funcionSave::registrarObservaciones($request, $ordenCambio->id);
        return $ordenCambio;
    }

    public function generarOC(Request $request, $id)
    {
        $modelo = new ModeloOrdenDeCambio();
        $modelo ->crearOrden($id);
        $salida = shell_exec('C:\xampp\htdocs\BackendSAETIS\Back\BackendSAETIS\public\execOC.bat');
        $ordenCambio = OrdenCambio::find($id);
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

    public function getOrden(Request $request,$id){
        $orden = OrdenCambio::find($id);
        return $orden;
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

    public function showPDF(Request $request ,$fileID)
    {
        $path = base_path(). "/storage/app/public/{$fileID}";
        $image = base64_encode(file_get_contents($path));

        return "data:@file/pdf;base64,{$image}";
    }

    public function showDetallesOrden($fileID)
    {
        $path = base_path(). "/storage/app/public/{$fileID}";
        $image = base64_encode(file_get_contents($path));

        return "data:@file/pdf;base64,{$image}";
    }
    public function doyDatosRevision($id, Request $request){
            $listaDoc= collect();
            $grupoEmpresa = GrupoEmpresa::where('id', $id)->get()->first();
            $postulacion= Postulacion::where('grupoEmpresa_id', $id)->get()->first();
            $documentos = Documento:: where('postulacion_id', $postulacion->id)->get();
        foreach ($documentos as $documento){
            $doc= new Documentos();
           $nombres=DetalleDoc::where('id', $documento->detalleDoc_id)->get()->first();
                $doc->idDocumento=$documento->id;
                $doc->nombreDocumento= $nombres->nombreDoc;
                $doc->rutaDocumento= $documento->documento;
                $doc->observaciones=ObservacionPropuesta::where('documento_id', $documento->id)->get();
                $listaDoc->add($doc);
        }

        $respuesta=new Respuesta($grupoEmpresa->nombre,$listaDoc);
        $algo=collect($respuesta);
        return ($algo);
    }

    public function doyDatosRevisionObs($id, Request $request){
        $listaDoc= collect();
        $grupoEmpresa = GrupoEmpresa::where('id', $id)->get()->first();
        $postulacion= Postulacion::where('grupoEmpresa_id', $id)->get()->first();
        $documentos = Documento:: where('postulacion_id', $postulacion->id)->get();
        foreach ($documentos as $documento){
            if(Documento::where('id',$documento->revisionDoc_id)->exists()){
                $doc1= new Documentos();
                $docObs= Documento::where('id',$documento->revisionDoc_id)->get()->first();
                $nombres=DetalleDoc::where('id', $docObs->detalleDoc_id)->get()->first();
                $doc1->idDocumento=$docObs->id;
                $doc1->nombreDocumento= $nombres->nombreDoc;
                $doc1->rutaDocumento= $docObs->documento;
                $doc1->observaciones=ObservacionPropuesta::where('documento_id', $docObs->id)->get();
                $listaDoc->add($doc1);
            }
        }
        $respuesta1=new Respuesta($grupoEmpresa->nombre,$listaDoc);
        $algo=collect($respuesta1);
        return ($algo);
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

    public function doyOrdenCambio($id){
        if(!OrdenCambio::where('postulacion_id',$id)->exists()){
            $orden = new OrdenCambio();
            $orden -> codigo = "OC-1-2021";
            $orden -> fechaEmContrato = "2021-12-23" ;
            $orden -> fechaFirma = "2021-12-28" ;
            $orden -> lugar = "Bloque Informatica UMSS Piso 1";
            $orden -> estado = false;
            $orden -> postulacion_id = $id;
            $orden -> documento = "";
            $orden->save();
            $orden -> codigo = "OC-{$orden->id}-2021";
            $orden->save();
        }
        $orden = OrdenCambio::where('postulacion_id',$id)->first();
        $observaciones=collect();
        $postulacion = Postulacion::find( $id);
        $grupoNom = GrupoEmpresa::find($postulacion->grupoEmpresa_id);
        $documentos=Documento::where('postulacion_id', $postulacion->id)->get();
        $campos=CampoEvaluable::all();
        $observacionesTodo = collect();
        foreach (  $documentos as $documento) {
            if(ObservacionPropuesta::where('documento_id', $documento->id)->exists()){
                $doc=new Documentos();
                $nombre = DetalleDoc::where('id', $documento->detalleDoc_id)->first();
                $obs = ObservacionPropuesta::where('documento_id', $documento->id)->get();
                foreach ($obs as $observacionE){
                    $observacionE->nombreDoc = $nombre->nombreDoc;
                    $observacionesTodo->add($observacionE);
                }
                $doc->idDocumento=$documento->id;
                $doc->nombreDocumento=$nombre->nombreDoc;
                $doc->rutaDocumento=$documento->documento;
                $doc->observaciones=$obs;
            $observaciones->add($doc);
            }
        }
        $ocRespuesta= new OrdenCambio();
        $ocRespuesta->grupoEmpresa= $grupoNom->nombre;
        $ocRespuesta->fechaEm=$orden->fechaEmContrato;
        $ocRespuesta->fechayHoraEntrega=$orden->created_at;
        $ocRespuesta->lugarEntrega=$orden->lugar;
        $ocRespuesta->observaciones=$observacionesTodo;
        $ocRespuesta->calificacion= $campos;
        return ($ocRespuesta);
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
