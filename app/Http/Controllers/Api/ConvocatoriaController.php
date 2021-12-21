<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConvConsultor;
use App\Models\Convocatoria;
use App\Models\PliegoEspecificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\True_;

class ConvocatoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
//        $convocatorias = Convocatoria::all();
        $convocatoriasPublicadas= Convocatoria::where('publica', true)->get()->collect();

        return response()->json($convocatoriasPublicadas);

    }
    public function noPublicas()
    {
        $convocatorias = Convocatoria::all();

        return response( $convocatorias );

    }

    public function convocatoriaSinPliego()
    {
        $convocatorias = Convocatoria::all();
        $convocatoriasSinPLiego= collect();
        foreach ($convocatorias as $key => $convocatoria) {
            $pliego = PliegoEspecificacion::firstWhere('convocatoria_id',$convocatoria->id);
            if(DB::table('pliego_especificacions')->where('convocatoria_id', $convocatoria->id)->exists()){
                $convocatoriasSinPLiego->add($convocatoria);
            }
        }
        return response( $convocatorias->diff($convocatoriasSinPLiego));
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
        $convocatoria = new Convocatoria();
        $convocatoria -> codigo = $request -> get('codigo');
        $convocatoria -> titulo = $request -> get('titulo')  ;
        $convocatoria -> descripcion =  $request -> get('descripcion');
        $convocatoria -> consultorEnc = "Leticia Blanco";
        $convocatoria -> fechaLimRec = $request -> get('fechaLimRec');
        $convocatoria -> fechaIniDur =$request -> get('fechaIniDur');
        $convocatoria -> fechaFinDur = $request -> get('fechaFinDur');
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


    public function show($id)
    {
        $convocatorias  = collect();
        $convConsultor = ConvConsultor::where('consultor_id', $id)->get();
        foreach ($convConsultor as $aux ){
            $convocatoria = Convocatoria::find( $aux->convocatoria_id);
            $convocatorias->add($convocatoria);
        }

        return $convocatorias;
    }

    public function showPDF($fileID)
    {
        $path = base_path(). "/storage/app/public/{$fileID}";
        $image = base64_encode(file_get_contents($path));

        return "data:@file/pdf;base64,{$image}";
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
