<?php

namespace App\Http\Controllers;

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
    public function darPermisos($id){
        $pers= new Observaciones();

        $user= User::find($id);
        $permissionNames = $user->getAllPermissions();
       $pers->permisos=$permissionNames;
        $pers=collect($pers);
        return($pers);

    }
}
