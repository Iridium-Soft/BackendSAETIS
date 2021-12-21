<?php

namespace App\Http\Controllers;

use App\Models\Convocatoria;
use App\Models\HitoPlanificacion;
use App\Models\Planificacion;
use App\Models\Postulacion;
use http\Env\Response;
use Illuminate\Http\Request;

class HitoPlanificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $hitoPlanificacions = HitoPlanificacion::all();
        $convocatorias = Convocatoria::all();
        $convocatoriasPublicadas= Convocatoria::where('publica', true)->get();;
        return response( $hitoPlanificacions);
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
        $hito = new HitoPlanificacion();
        $hito->nombreHito = $request->nombreHito;
       $hito->fechaInicial = $request->fechaInicial;
        $hito->fechaFinal = $request->fechaFinal;
        $hito->porcentajeCobro = $request->porcentajeCobro;
        $hito->entregables = $request->entregables;

        $hito->save();
        return response($hito);
    }
    public function guardarHitos(Request $request,$id)
    {
        $postulacion = Postulacion::where('grupoEmpresa_id',$id)->first();
        $planificacion = new Planificacion();
        $planificacion->  postulacion_id = $postulacion;
        $planificacion->save();
        $tam =  $request->collect('hitos')->count();
        $hitos = collect();
        for($i=0; $i<$tam; $i++){
            $hito = new HitoPlanificacion();
            $hito->nombre = $request->input("hitos.{$i}.nombre");
            $hito->fechaIni = $request->input("hitos.{$i}.fechaIni");
            $hito->fechaFin = $request->input("hitos.{$i}.fechaFin");
            $hito->porcentajeCobro = $request->input("hitos.{$i}.porcentajeCobro");
            $hito->planificacion_id= $planificacion->id;
            $hito->entregables = $request->input("hitos.{$i}.entregables");
            $hito->save();
            $hitos->add($hito);
        }

        return response($hitos);
    }

    public function doyHitos(Request $request,$id){
        $postulacion = Postulacion::where('id', $id)->get()->first();
        $planificacion= Planificacion::where('id', $postulacion-> id)->get()->first();
        $hitos= HitoPlanificacion::where('planificacion_id', $planificacion->id)->get();

        return($hitos);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HitoPlanificacion  $hitoPlanificacion
     * @return \Illuminate\Http\Response
     */
    public function show(HitoPlanificacion $hitoPlanificacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HitoPlanificacion  $hitoPlanificacion
     * @return \Illuminate\Http\Response
     */
    public function edit(HitoPlanificacion $hitoPlanificacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HitoPlanificacion  $hitoPlanificacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HitoPlanificacion $hitoPlanificacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HitoPlanificacion  $hitoPlanificacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(HitoPlanificacion $hitoPlanificacion)
    {
        //
    }
}
