<?php

namespace App\Http\Controllers;

use App\Models\Consultor;
use App\Models\GrupoEmpresa;
use App\Models\PersonalAccessToken;
use App\Models\responses\Login;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','logout','registerConsultor']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return string
     */
    public function login(Request $request){
        $user = User::where('username', $request->username)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'mensaje' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token=$user->createToken($request->username);
        $log=new Login();
        $log->nomUsuario=$user->name;
        $log->token=$token->plainTextToken;
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
        return $log;
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
        $user = User::find($request->user_id);
        $user->tokens()->delete();

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
            'nombreGE' =>'required|string|max:100|unique:grupo_empresas'

        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => bcrypt($request->password)]
        ));

        $grupo = new GrupoEmpresa();
        $grupo->nombre=$request->nombreGE;
        $grupo->user_id=$user->id;
        $grupo->consultor_id=$request->consultor_id;
        $grupo->save();
        $user->assignRole('Socio');
        return response()->json([
            'message' => '¡Usuario registrado exitosamente!',
            'user' => $user,
            'grupoE'=> $grupo
        ], 201);
    }
     public function registerConsultor(Request $request){
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
         $user->assignRole('Consultor');
         $consultor=new Consultor();
         $consultor->user_id=$user->id;
         $consultor->activo=true;
         $consultor->save();
         return response()->json([
             'message' => '¡Usuario registrado exitosamente!',
             'user' => $user,
             'consultor'=> $consultor
         ], 201);
         }
}
