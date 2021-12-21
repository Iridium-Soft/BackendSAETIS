<?php

namespace App\Http\Controllers;

use App\Models\GrupoEmpresa;
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
        $pers->permisos=$permissionNames;
        $pers=collect($pers);
        return($pers);

    }
    public function asignarAGE(Request $request){
        $grupo=GrupoEmpresa::where('nombre', $request->nombre)->first();
        $grupito=GrupoEmpresa::find($grupo->id);
        $grupito->user_id=$request->user_id;
        $grupito->save();
        return($grupito);
    }

}
