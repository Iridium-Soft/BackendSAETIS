<?php

namespace App\Http\Controllers;

use App\Models\Convocatoria;
use App\Models\GrupoEmpresa;
use App\Models\Postulacion;
use Illuminate\Http\Request;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $convocatoria = Convocatoria::findOrFail($request->convocatoria_id);
        $fechaValida =  $convocatoria-> fechaLimRec;
        $fechaActual = now();
        $postulacion = new Postulacion();
        if($fechaValida < $fechaActual){
            $postulacion-> convocatoria_id = $request->convocatoria_id;
            $postulacion-> grupoEmpresa_id = 1;
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

    /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function guardarDocumentos(Request $request , int $id)
    {
        $postulacion = Postulacion::find($id);
        $postulacion-> parteA = $this->storeDocument($request->parteA);
        $postulacion-> boletaDeGarantia  = $this->storeDocument($request->boletaDeGarantia);
        $postulacion-> cartaDePresentacion  = $this->storeDocument($request->cartaDePresentacion);
        $postulacion-> constitucion  = $this->storeDocument($request->constitucion);
        $postulacion-> parteB  = $this->storeDocument($request->parteB);
        $postulacion->save();

        return \response( $postulacion );
    }

    public function verPostulacionesEspecificas(Request $request)
    {
        $postulaciones= Postulacion::where('convocatoria_id',$request->id)->get();

        return response( $postulaciones );
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
