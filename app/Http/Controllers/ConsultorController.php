<?php

namespace App\Http\Controllers;

use App\Models\Consultor;
use App\Models\User;
use Illuminate\Http\Request;

class ConsultorController extends Controller
{

    public function index()
    {
        $consultores = Consultor::all();
        foreach ( $consultores as $consultor){
            $consultor->nombre= "Default Name";
            if(User::find($consultor->user_id)){
                $usuario = User::find($consultor->user_id);
                $consultor->nombre= $usuario->name;
            }
        }
        return $consultores;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consultor  $consultor
     * @return \Illuminate\Http\Response
     */
    public function show(Consultor $consultor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consultor  $consultor
     * @return \Illuminate\Http\Response
     */
    public function edit(Consultor $consultor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultor  $consultor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consultor $consultor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consultor  $consultor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consultor $consultor)
    {
        //
    }
}
