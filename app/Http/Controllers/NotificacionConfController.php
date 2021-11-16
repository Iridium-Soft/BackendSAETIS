<?php

namespace App\Http\Controllers;

use App\Models\NotificacionConf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
