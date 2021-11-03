<?php

namespace App\Http\Controllers;

use App\Models\Convocatoria;
use App\Models\GrupoEmpresa;
use App\Models\Postulacion;
use Illuminate\Http\Request;

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
