<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Functions\ModeloNotificacionDeConformidad;
use App\Models\Calificacion;
use App\Models\CalificacionNotificacionConformidad;
use App\Models\CampoEvaluable;
use App\Models\GrupoEmpresa;
use App\Models\NotificacionConf;
use App\Models\Postulacion;
use App\Models\responses\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NotificacionConfController extends Controller
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

    public function registrarNotificacion(Request $request){
        $grupoEmpresa = GrupoEmpresa::where('nombre',$request->nombre)->first();
        $postu = Postulacion::where('grupoEmpresa_id', $grupoEmpresa->id)->first();
        $notificacion = new NotificacionConf();
        $notificacion-> postulacion_id = $postu->id;
        $notificacion-> codigo = "COD";//
        $notificacion-> fechaFirma = $request->fechaFirma;
        $notificacion-> lugar = $request->lugar;
        $notificacion-> fechaEmDocumento = $request->fecha_emision;
        $notificacion->save();
        $notificacion-> codigo ="NC-{$notificacion->id}/2021";
        $notificacion->save();
        $tam =  $request->collect('evaluacion')->count();
        for($i=0; $i<$tam; $i++){
            $calificacion = new CalificacionNotificacionConformidad();
            $calificacion->puntajeObtenido = $request->input("evaluacion.{$i}.puntuacion");
            $calificacion->campoEvaluable_id = $request->input("evaluacion.{$i}.evaluacion_id");
            $calificacion->notificacionConformidad_id=$notificacion->id;
            $calificacion->save();
        }
        return $notificacion;
    }
    public function doyNoti($id){
        $notis= NotificacionConf::where('id',$id)->first();
        $postulacion = Postulacion::where('id', $notis->postulacion_id)->first();
        $grupoNom = GrupoEmpresa::where('id', $postulacion->grupoEmpresa_id)->first();
        $campos=CampoEvaluable::all();
        $noti=new Notificacion();
        $noti->grupoEmpresa=$grupoNom->nombre;
        $noti->fechaEm= $notis->fechaEmDocumento;
        $noti->fechayHoraEntrega=$notis->fechaFirma;
        $noti->lugarEntrega=$notis->lugar;
        $noti->calificacion=$campos;
        $noti=collect($noti);
        return($noti);
    }

    public function generarNC(Request $request, $id)
    {
        $modelo = new ModeloNotificacionDeConformidad();
        $modelo ->crearNotificacion($id);
        $salida = shell_exec('C:\xampp\htdocs\BackendSAETIS\Back\BackendSAETIS\public\execNC.bat');
        $notificacion = NotificacionConf::find($id);
        $path = $this->storeDocument();
        $notificacion->documento = $path;
        $notificacion->save();
        return $notificacion;
    }


    public function storeDocument(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        $length = 20;
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $contents = Storage::disk('generado')->get('notificacionConformidad.pdf');
        $imageName = "{$randomString}.pdf";
        Storage::disk('public')->put($imageName, $contents);
        return $imageName;
    }

    public function getNoti(Request $request,$id){
        $noti = NotificacionConf::find($id);
        return $noti;
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
     * @param  \App\Models\NotificacionConf  $notificacionConf
     * @return \Illuminate\Http\Response
     */
    public function show(NotificacionConf $notificacionConf)
    {
        //
    }

    public function showDetallesNotificacion($fileID)
    {
        $path = base_path(). "/storage/app/public/{$fileID}";
        $image = base64_encode(file_get_contents($path));
        return "data:@file/pdf;base64,{$image}";
    }

    public function estadoNotificacion(Request $request,$id)
    {
        if (DB::table('notificacion_confs')->where('id', $id)->exists()) {
            $respuesta = "se ha publicado previamente";
            $noti = DB::table('notificacion_confs')->where('id', $id)->first();
            if ($noti->estado==false) {
                $flight = NotificacionConf::find($id);
                $flight->estado = true;
                $flight->save();
                $respuesta = "se ha publicado exitosamente";
            }
        }
        else{
            $respuesta="no existe la notificacion de conformidad";
        }
        return response()->json(['mensaje' => $respuesta]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NotificacionConf  $notificacionConf
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificacionConf $notificacionConf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NotificacionConf  $notificacionConf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotificacionConf $notificacionConf)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotificacionConf  $notificacionConf
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificacionConf $notificacionConf)
    {
        //
    }
}
