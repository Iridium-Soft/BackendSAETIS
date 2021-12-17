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
    $observaciones=collect();
        $orden = OrdenCambio::where('id',$id)->first();
        $postulacion = Postulacion::where('id', $orden->postulacion_id)->first();
        $grupoNom = GrupoEmpresa::where('id', $postulacion->grupoEmpresa_id)->first();
        $documentos=Documento::where('postulacion_id', $postulacion->id)->get();
        $campos=CampoEvaluable::all();
        foreach (  $documentos as $documento) {
            if(ObservacionPropuesta::where('documento_id', $documento->id)->exists()){
                $obs = ObservacionPropuesta::where('documento_id', $documento->id)->first();
            $observaciones->add($obs);
            }
        }
            $obs= new OrdenCambio();
            $obs->grupoEmpresa= $grupoNom->nombre;
            $obs->fechaEm=$orden->fechaEmContrato;
            //$obs->fechayHoraEntrega=$orden->fechaFirma;
            $obs->fechayHoraEntrega=$orden->created_at;
            $obs->lugarEntrega=$orden->lugar;
            $obs->observaciones=$observaciones;
            $obs->calificacion= $campos;
        return ($obs);
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
