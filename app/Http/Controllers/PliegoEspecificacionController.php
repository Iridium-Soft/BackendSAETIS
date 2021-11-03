<?php

namespace App\Http\Controllers;

use App\Models\PliegoEspecificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PliegoEspecificacionController extends Controller
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
    public function publicarPliego(Request $request, $id)
    {
        $pliego = PliegoEspecificacion::findOrFail($id);
        $pliego -> publica = true;
        $pliego-> save();
        if($pliego->wasChanged() ){
            return response("Pliego Publicado");
        }
        return response("Pliego Ya es Publico");

    }

    public function storeDocument(Request $request){
        $image_64 = $request->documento;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = $this-> storeDocument($request);
        $pliego = new PliegoEspecificacion();
        $pliego -> codigo = $request -> get('codigo');
        $pliego -> titulo = $request -> get('titulo')  ;
        $pliego -> convocatoria_id = $request -> get('convocatoria_id') ;
        $pliego -> documento = $path;
        $pliego->save();
        return response($pliego);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PliegoEspecificacion  $pliegoEspecificacion
     * @return \Illuminate\Http\Response
     */
    public function show(PliegoEspecificacion $pliegoEspecificacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PliegoEspecificacion  $pliegoEspecificacion
     * @return \Illuminate\Http\Response
     */
    public function edit(PliegoEspecificacion $pliegoEspecificacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PliegoEspecificacion  $pliegoEspecificacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PliegoEspecificacion $pliegoEspecificacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PliegoEspecificacion  $pliegoEspecificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(PliegoEspecificacion $pliegoEspecificacion)
    {
        //
    }
}
