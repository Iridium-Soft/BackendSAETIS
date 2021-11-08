<?php

namespace App\Http\Controllers;

use App\Models\ConvConsultor;
use App\Models\Convocatoria;
use App\Models\GrupoEmpresa;
use App\Models\HitoPlanificacion;
use App\Models\Postulacion;
use App\Models\responses\Postulaciones;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Version;

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
    public function aplicar(Request $request)
    {
        //$request trae el id dela grupoempresa
        $convocatoria = Convocatoria::findOrFail($request->convocatoria_id);
        $grupoEmpresa = GrupoEmpresa::findOrFail(1);

        $fechaValida =  $convocatoria-> fechaLimRec;
        $fechaActual = now();
        if($fechaValida > $fechaActual){
            $respuesta = response('Fecha Valida Postulacion exitosa');
            $postulacion = new Postulacion();
            $postulacion -> convocatoria_id = $convocatoria->id;
            $postulacion -> grupoEmpresa_id = 1;
            $postulacion->save();
        }
        return response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'parteA' =>'required',
            'boletaDeGarantia',
            'cartaDePresentacion',
            'constitucion',
            'parteB'
        ]);

        $postulacion = new Postulacion();
        $postulacion-> parteA = $request->file('parteA')->store('documentos/postulaciones');
        $postulacion-> boletaDeGarantia  = $request->file('boletaDeGarantia')->store('documentos/postulaciones');
        $postulacion-> cartaDePresentacion  = $request->file('cartaDePresentacion')->store('documentos/postulaciones');
        $postulacion-> constitucion  = $request->file('constitucion')->store('documentos/postulaciones');
        $postulacion-> parteB  = $request->file( 'parteB')->store('documentos/postulaciones');

        $postulacion->save();

        return \response($postulacion);
    }
    public function verPostulacionesEspecificas(Request $request)
    {   //$p = new Postulaciones;
        $convocatorias = ConvConsultor::where('consultor_id',$request->id)->get();
        $listaConvocatorias= new Convocatoria();
        $listaConvocatorias= collect();

        $listaPostulaciones= collect();
        $listaGrupoEmpresas = collect();
        foreach ($convocatorias as $asignadas){
            $convocatoria = Convocatoria::where('id',$asignadas->convocatoria_id)->get()->collect();

            $listaConvocatorias->add($convocatoria);
        }
      /*  $listas= $listaConvocatorias->toArray();
        //$array = Arr::dot($listas);

        /*foreach ($listaConvocatorias as $postulacion){
           $postulaciones = Postulacion::where('id',$postulacion->convocatoria_id)->get()->collect();
           $listaPostulaciones->add($postulaciones);
       }
       foreach ($listaPostulaciones as $grupoEmpresa){
           $grupoEmpresas = GrupoEmpresa::where('id',$grupoEmpresa->grupoEmpresa_id)->get()->collect();
           $listaGrupoEmpresas->add($grupoEmpresas);
       }*/

      // for($i=0; $i<$tam; $i++){
           // $grupoEmpresa = GrupoEmpresa::where("id",$postulaciones->grupoEmpresa_id)->get();
          // $grupoEmpresa = GrupoEmpresa::where('id',$postulaciones.id.[$i].grupoEmpresa_id)->get();
          // $grupos->add($grupo);
        //}*/

        return response( $listaConvocatorias);

    }
    public function prueba(Request $request){
           $p = new Postulaciones;
        return response( $p);
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
