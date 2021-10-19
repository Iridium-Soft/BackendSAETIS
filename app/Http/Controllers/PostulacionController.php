<?php

namespace App\Http\Controllers;

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
