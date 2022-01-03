<?php

namespace App\Http\Controllers;

use App\Models\Adenda;
use App\Models\Contrato;
use App\Models\ConvConsultor;
use App\Models\Convocatoria;
use App\Models\Documento;
use App\Models\Estado;
use App\Models\GrupoEmpresa;
use App\Models\HitoPlanificacion;
use App\Models\NotificacionConf;
use App\Models\OrdenCambio;
use App\Models\Planificacion;
use App\Models\Postulacion;
use App\Models\responses\Postulaciones;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Version;

use Illuminate\Support\Facades\Storage;


class PostulacionController extends Controller
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

    public function registrarPostulacion(Request $request,$id)
    {
        $convocatoria = Convocatoria::findOrFail($request->convocatoria_id);
        $fechaValida =  $convocatoria-> fechaLimRec;
        $fechaActual = now();
        $postulacion = new Postulacion();
        if($fechaValida > $fechaActual){
            $postulacion-> convocatoria_id = $request->convocatoria_id;
            $postulacion-> grupoEmpresa_id = $id;
            $postulacion-> estado_id = 1;
            $postulacion->save();
        }
        return response($postulacion);
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


    public function guardarDocumentos(Request $request , int $id)
    {
        $postulacion = Postulacion::where('grupoEmpresa_id',$id)->first();
        $this->registrarDocumento($postulacion->id,1,$request->parteA);
        $this->registrarDocumento($postulacion->id,2,$request->boletaDeGarantia);
        $this->registrarDocumento($postulacion->id,3,$request->cartaDePresentacion);
        $this->registrarDocumento($postulacion->id,4,$request->constitucion);
        $this->registrarDocumento($postulacion->id,5,$request->parteB);
        if(Planificacion::where("postulacion_id",$postulacion->id)->exists()){
            $postulacion->estado_id =2;
            $postulacion->save();
        }
        return \response( $postulacion );
    }
    private function registrarDocumento($idPostulacion, $idDoc, $docu){
        $doc = new Documento();
        $doc-> documento = $this->storeDocument($docu);
        $doc-> postulacion_id = $idPostulacion;
        $doc-> detalleDoc_id = $idDoc;
        $doc->save();
    }

    public function verPostulacionesEspecificas(Request $request,$id)
    {
        $convConsultores = ConvConsultor::where('consultor_id',$id)->get();
        $listaPostulaciones= collect();
        foreach ($convConsultores as $asignadas){
            $convocatorias = Convocatoria::where('id',$asignadas->convocatoria_id)->first();
            $postulaciones = Postulacion::where('convocatoria_id',$asignadas->convocatoria_id)->get();
            foreach ($postulaciones as $postulacion){
                $postus = new Postulaciones();
                $grupoEmpresa = GrupoEmpresa::where('id',$postulacion->grupoEmpresa_id)->first();
                $postus->nombreGrupoEmpresa=$grupoEmpresa->nombre;
                $postus->idGrupoEmpresa=$grupoEmpresa->id;
                $postus->idConvocatoria=$convocatorias->id;
                $postus->idPostulacion=$postulacion->id;
                $postus->codigoConvocatoria=$convocatorias->codigo;
                $postus->tituloConvocatoria=$convocatorias->titulo;
                $postus->fechaRegistro=$postulacion->created_at;

                if(OrdenCambio::where('postulacion_id',$postulacion->id)->exists()){
                    $ordenCamb = OrdenCambio::where('postulacion_id',$postulacion->id)->first();
                    $postus->idOrdenCambio=$ordenCamb->id;
                    $postus->notificacion_conformidad = $ordenCamb->documento;
                    if(Adenda::where('ordendecambio_id',$ordenCamb->id)->exists()){
                        $adenda = Adenda::where('ordendecambio_id',$ordenCamb->id)->first();
                        $postus->adenda = $adenda->documento;
                    }
                }else {
                    $postus->idOrdenCambio = 0;
                }
                if(NotificacionConf::where('postulacion_id',$postulacion->id)->exists()){
                    $notiConf = NotificacionConf::where('postulacion_id',$postulacion->id)->first();
                    $postus->idNotiConf=$notiConf->id;
                    $postus->notificacion_conformidad = $notiConf->documento;
                }else {
                    $postus->idNotiConf = 0;
                }
                if(Contrato::where('postulacion_id',$postulacion->id)->exists()){
                    $contrato = Contrato::where('postulacion_id',$postulacion->id)->first();
                    $postus->contrato = $contrato->documento;
                }
                $postus->estado = $postulacion->estado_id;
                $estado = Estado::find($postulacion->estado_id);
                $postus->nombreEstado =$estado->descripcion;
                $listaPostulaciones->add($postus);
            }
        }
        return ($listaPostulaciones);
    }

    public function doyDocumentos(Request $request,$id){
        $postulacion = Postulacion::find($id);
        return $postulacion;
    }

    public function revisionPostulacion (Request $request,$id){
        $postulacion = Postulacion::find($id);
        if($request->orden_cambio==0){
            $postulacion->estado_id = 3;
        }else{
            $postulacion->estado_id = 6;
        }
        $postulacion->save();
        return $postulacion;
    }

    public function revisionOrdenCambio(Request $request,$id){
        $postulacion = Postulacion::find($id);
        if($request->contrato==1){
            $postulacion->estado_id = 5;
        }else{
            $postulacion->estado_id = 10;
        }
        $postulacion->save();
        return $postulacion;
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
