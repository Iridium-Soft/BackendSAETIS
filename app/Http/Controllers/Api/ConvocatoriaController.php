<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Convocatoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConvocatoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Convocatoria::all());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = $request->file('documento')->store('documentos/convocatorias');
        $convocatoria = new Convocatoria();
        $convocatoria -> codigo = $request -> codigo;
        $convocatoria -> titulo = $request -> titulo  ;
        $convocatoria -> descripcion =  $request -> descripcion;
        $convocatoria -> consultorEnc =  $request -> consultorEnc ;
        $convocatoria -> fechaLimRec =$request -> fechaLimRec;
        $convocatoria -> fechaIniDur =$request -> fechaIniDur;
        $convocatoria -> fechaFinDur = $request -> fechaFinDur;
        $convocatoria -> documento = $path;
        $convocatoria->save();
        return response($convocatoria);
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
    public function publicarConvocatoria(Request $request, $id)
    {
        $convocatoria = Convocatoria::findOrFail($id);
        $convocatoria -> publica = true;
        $convocatoria-> save();
        if($convocatoria->wasChanged() ){
        return response("Convocatoria Publicada");
        }
        return response("Convocatoria Ya es Publica");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Convocatoria::find($id);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function showPDF($fileID)
    {
        $path = base_path(). "/storage/app/apiDocs/{$fileID}";
        return response()->file($path);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
