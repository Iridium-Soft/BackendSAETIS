<?php

use App\Http\Controllers\Api\ConvocatoriaController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\GrupoEmpresaController;
use App\Http\Controllers\HitoPlanificacionController;
use App\Http\Controllers\OrdenCambioController;
use App\Http\Controllers\PliegoEspecificacionController;
use App\Http\Controllers\PostulacionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/convocatoria/sinpliego', [ConvocatoriaController::class, 'convocatoriaSinPliego']);
Route::get('/convocatoria', [ConvocatoriaController::class, 'noPublicas']);
Route::get('/convocatoria/publica', [ConvocatoriaController::class, 'index']);
Route::get('/convocatoria/{id}', [ConvocatoriaController::class, 'show']);
Route::get('/documento/convocatoria/{fileID}', [ConvocatoriaController::class, 'showPDF']);
Route::get('/documento/pliegoespecificacion/{fileID}', [PliegoEspecificacionController::class, 'showPDF']);
Route::get('/pliegoespecificacion/{id}', [PliegoEspecificacionController::class, 'mostrarPLiego']);


Route::post('/postulacion',[PostulacionController::class, 'store']);
Route::post('/postulacion/documentos/{id}',[PostulacionController::class, 'guardarDocumentos']);


//Route::get('/documento/pliegoespecificacion/{fileID}', [PliegoEspecificacion::class, 'showPDF']);


Route::get('/grupoempresa/{id}',[GrupoEmpresaController::class, 'show']);
Route::put('/convocatoria/{id}', [ConvocatoriaController::class, 'publicarConvocatoria']);

Route::post('/convocatoria', [ConvocatoriaController::class, 'store']);

Route::apiResource('postulacion',PostulacionController::class);

Route::post('postulacion/planificacion', [HitoPlanificacionController::class, 'guardarHitos']);

Route::post('/pliegoespecificacion',[PliegoEspecificacionController::class,'store']);
Route::put('/pliegoespecificacion/{id}', [PliegoEspecificacionController::class, 'publicarPliego']);



Route::get('/postulacion', [PostulacionController::class, 'verPostulacionesEspecificas']);

Route::apiResource('/postulacion/ordencambio/',OrdenCambioController::class);
