<?php

namespace App\Http\Controllers;

use App\Models\GrupoEmpresa;
use App\Models\HitoPlanificacion;
use App\Models\Planificacion;
use App\Models\Postulacion;
use App\Models\responses\Observaciones;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function asignarRol(Request $request){
        $user= User::where('username', $request->username)->first();
        $user->assignRole($request->rol);

          return ($user);
    }

    public function asignarPermisos(){

    }
    public function darPermisos($id){
        $pers= new Observaciones();
        $user= User::find($id);
        $permissionNames = $user->getAllPermissions();
        $permisosFiltrado = collect();
        if($user->getRoleNames()->first()=='Socio'){
            $grupoEmpresa = GrupoEmpresa::where("user_id",$id)->first();
            if(Postulacion::where("grupoEmpresa_id",$grupoEmpresa->id)->exists()){
                $postulacion = Postulacion::where("grupoEmpresa_id",$grupoEmpresa->id)->first();
                if($postulacion->estado_id==1){
                    if(!Planificacion::where("postulacion_id",$postulacion->id)->exists()){
                        $permisosFiltrado->add($permissionNames[0]);
                    }
                    if(!$postulacion->parteA){
                        $permisosFiltrado->add($permissionNames[2]);
                    }
                }
            }else{
                $permisosFiltrado->add($permissionNames[1]);
            }
            $permisosFiltrado->add($permissionNames[3]);
            $pers->permisos=$permisosFiltrado;
        }else{
            $pers->permisos=$permissionNames;
        }
        $pers=collect($pers);
        return $pers;

    }
    public function asignarAGE(Request $request){
        $grupo=GrupoEmpresa::where('nombre', $request->nombre)->first();
        $grupito=GrupoEmpresa::find($grupo->id);
        $grupito->user_id=$request->user_id;
        $grupito->save();
        return($grupito);
    }

}
