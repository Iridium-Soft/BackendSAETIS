<?php

use App\Http\Controllers\AdendaController;
use App\Http\Controllers\Api\ConvocatoriaController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\GrupoEmpresaController;
use App\Http\Controllers\HitoPlanificacionController;
use App\Http\Controllers\NotificacionConfController;
use App\Http\Controllers\OrdenCambioController;
use App\Http\Controllers\PlanificacionController;
use App\Http\Controllers\PliegoEspecificacionController;
use App\Http\Controllers\PostulacionController;
use App\Http\Middleware\JsonResponseMiddleware;
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

Route::get('/postulacion/hitos/{id}', [HitoPlanificacionController::class, 'doyHitos']);
Route::get('/postulacion/documentos/{id}', [PostulacionController::class, 'doyDocumentos']);


Route::post('/postulacion',[PostulacionController::class, 'store']);
Route::post('/postulacion/documentos/{id}',[PostulacionController::class, 'guardarDocumentos']);


//Route::get('/documento/pliegoespecificacion/{fileID}', [PliegoEspecificacion::class, 'showPDF']);
Route::get('/grupoempresa/{id}',[GrupoEmpresaController::class, 'show']);
Route::put('/convocatoria/{id}', [ConvocatoriaController::class, 'publicarConvocatoria']);

Route::post('/convocatoria', [ConvocatoriaController::class, 'store']);



Route::post('postulacion/planificacion', [HitoPlanificacionController::class, 'guardarHitos']);

Route::post('/pliegoespecificacion',[PliegoEspecificacionController::class,'store']);
Route::put('/pliegoespecificacion/{id}', [PliegoEspecificacionController::class, 'publicarPliego']);
Route::get('/postulacion/propias/', [PostulacionController::class, 'verPostulacionesEspecificas']);
Route::get('/documento/ordencambio/{fileID}', [OrdenCambioController::class, 'showDetallesOrden']);
Route::put('/ordencambio/{id}', [OrdenCambioController::class, 'estadoOrdenC']);
Route::get('/documento/adenda/{fileID}', [AdendaController::class, 'showDetallesAdenda']);
Route::put('/adenda/{id}', [AdendaController::class, 'estadoAdenda']);
Route::get('/documento/notificacion/{fileID}', [NotificacionConfController::class, 'showDetallesNotificacion']);
Route::put('/notificacion/{id}', [NotificacionConfController::class, 'estadoNotificacion']);

Route::get('/generar/ordencambio/{id}', [OrdenCambioController::class, 'generarOC']);
Route::get('/generar/notificacionconformidad/{id}', [OrdenCambioController::class, '']);


Route::apiResource('postulacion',PostulacionController::class);
Route::apiResource('/postulacion/ordencambio/',OrdenCambioController::class);

Route::post('postulacion/notificacionconformidad/',[OrdenCambioController::class, '']);


