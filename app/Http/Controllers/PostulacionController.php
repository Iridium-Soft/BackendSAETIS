<?php

namespace App\Http\Controllers;

use App\Models\ConvConsultor;
use App\Models\Convocatoria;
use App\Models\Estado;
use App\Models\GrupoEmpresa;
use App\Models\HitoPlanificacion;
use App\Models\NotificacionConf;
use App\Models\OrdenCambio;
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
        $postulacion-> parteA = $this->storeDocument($request->parteA);
        $postulacion-> boletaDeGarantia  = $this->storeDocument($request->boletaDeGarantia);
        $postulacion-> cartaDePresentacion  = $this->storeDocument($request->cartaDePresentacion);
        $postulacion-> constitucion  = $this->storeDocument($request->constitucion);
        $postulacion-> parteB  = $this->storeDocument($request->parteB);
        $postulacion->save();

        return \response( $postulacion );
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
                }else {
                    $postus->idOrdenCambio = 0;
                }
                if(NotificacionConf::where('postulacion_id',$postulacion->id)->exists()){
                    $notiConf = NotificacionConf::where('postulacion_id',$postulacion->id)->first();
                    $postus->idNotiConf=$notiConf->id;
                }else {
                    $postus->idNotiConf = 0;
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
