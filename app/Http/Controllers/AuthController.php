<?php

namespace App\Http\Controllers;

use App\Models\Consultor;
use App\Models\GrupoEmpresa;
use App\Models\responses\Login;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','logout']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return string
     */
    public function login(Request $request)
    {
        $credentials = $request->all();
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Nombre de usuario o contrase;a incorrectos'], 401);
        }
       // $token1=$this->respondWithToken($token);
        $user=User::where('username',$request->username)->first();
        $log=new Login();
        $log->nomUsuario=$user->name;
        $log->token=$token;
        $rol = $user->roles()->first();
        $name=$rol->name;
        if($name=="Socio"){
            $grupo=GrupoEmpresa::where('user_id',$user->id)->first();
            $log->nombreGE=$grupo;
        }
        else{
            $consultor=Consultor::where('user_id',$user->id)->first();
            $log->nombreCon=$consultor;
        }
        $log=collect($log);
        return ($log);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        auth()->logout();
        return response()->json(['mensaje' => 'Sesion cerrada correctamente']);

    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username'=> 'required',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => '¡Usuario registrado exitosamente!',
            'user' => $user
        ], 201);
    }
   /* public function register(Request $request){
        $user = new User();
        $user-> name = $request->name;
        $user-> username = $request->username;
        $user-> email = $request->email;
        $user->password=$request->password;
        $user->save();
        return($user);
        }*/
}
