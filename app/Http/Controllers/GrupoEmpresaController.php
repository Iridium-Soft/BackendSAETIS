<?php

namespace App\Http\Controllers;

use App\Models\Convocatoria;
use App\Models\GrupoEmpresa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\True_;

class GrupoEmpresaController extends Controller
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
        //
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

    public function aplicarConvocatoria(Request $request, $id)
    {
        //$request trae el id dela grupoempresa
        $convocatoria = Convocatoria::findOrFail($id);
        $grupoEmpresa = GrupoEmpresa::findOrFail(1);

        $fechaValida =  $convocatoria-> fechaLimRec;
        $fechaActual = now();

        $respuesta = response('Fecha invalida de postulacion', 304)
            ->header('Content-Type', 'text/plain');
        if($fechaValida > $fechaActual){
            $respuesta = response('Fecha Valida Postulacion exitosa', 200)
                ->header('Content-Type', 'text/plain');
            $grupoEmpresa -> convocatoria_id = $convocatoria->id;
            $grupoEmpresa->save();
        }
        return response($respuesta);
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
