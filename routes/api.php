<?php

use App\Http\Controllers\AdendaController;
use App\Http\Controllers\Api\ConvocatoriaController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\GrupoEmpresaController;
use App\Http\Controllers\HitoPlanificacionController;
use App\Http\Controllers\NotificacionConfController;
use App\Http\Controllers\ObservacionPropuestaController;
use App\Http\Controllers\OrdenCambioController;
use App\Http\Controllers\PlanificacionController;
use App\Http\Controllers\PliegoEspecificacionController;
use App\Http\Controllers\PostulacionController;
use App\Http\Controllers\UserController;
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
Route::get('/convocatoria/sinpliego/{id}', [ConvocatoriaController::class, 'convocatoriaSinPliego']);
Route::get('/convocatoria', [ConvocatoriaController::class, 'noPublicas']);
Route::get('/convocatoria/publica', [ConvocatoriaController::class, 'index']);
Route::get('/convocatoria/{id}', [ConvocatoriaController::class, 'show']);
Route::get('/documento/revision/{fileID}', [OrdenCambioController::class, 'showPDF']);
Route::post('/documento/revision', [DocumentoController::class, 'recibirDocumentosRevision']);
Route::get('/documento/convocatoria/{fileID}', [ConvocatoriaController::class, 'showPDF']);
Route::get('/documento/pliegoespecificacion/{fileID}', [PliegoEspecificacionController::class, 'showPDF']);
Route::get('/pliegoespecificacion/{id}', [PliegoEspecificacionController::class, 'mostrarPLiego']);

Route::get('/postulacion/bandejaentrada/{id}', [DocumentoController::class, 'index']);

Route::get('/postulacion/hitos/{id}', [HitoPlanificacionController::class, 'doyHitos']);
Route::get('/postulacion/documentos/{id}', [PostulacionController::class, 'doyDocumentos']);


Route::post('/postulacion/{id}',[PostulacionController::class, 'registrarPostulacion']);
Route::post('/postulacion/documentos/{id}',[PostulacionController::class, 'guardarDocumentos']);


//Route::get('/documento/pliegoespecificacion/{fileID}', [PliegoEspecificacion::class, 'showPDF']);
Route::get('/grupoempresa/{id}',[GrupoEmpresaController::class, 'show']);
Route::put('/convocatoria/{id}', [ConvocatoriaController::class, 'publicarConvocatoria']);

Route::post('/convocatoria', [ConvocatoriaController::class, 'store']);

Route::get('/planificacion/ordendeCambio/{id}', [OrdenCambioController::class, 'getOrden']);
Route::get('/planificacion/notificaciondeConformidad/{id}', [NotificacionConfController::class, 'getNoti']);


Route::post('postulacion/planificacion/{id}', [HitoPlanificacionController::class, 'guardarHitos']);

Route::post('/pliegoespecificacion',[PliegoEspecificacionController::class,'store']);
Route::put('/pliegoespecificacion/{id}', [PliegoEspecificacionController::class, 'publicarPliego']);
Route::get('/postulacion/propias/{id}', [PostulacionController::class, 'verPostulacionesEspecificas']);
Route::get('/documento/ordencambio/{fileID}', [OrdenCambioController::class, 'showDetallesOrden']);
Route::put('/ordencambio/{id}', [OrdenCambioController::class, 'estadoOrdenC']);
Route::get('/documento/adenda/{fileID}', [AdendaController::class, 'showDetallesAdenda']);
Route::put('/adenda/{id}', [AdendaController::class, 'estadoAdenda']);
Route::get('/documento/notificacion/{fileID}', [NotificacionConfController::class, 'showDetallesNotificacion']);
Route::put('/notificacion/{id}', [NotificacionConfController::class, 'estadoNotificacion']);
Route::put('/contrato/{id}', [ContratoController::class, 'estadoContrato']);

Route::get('/generar/ordencambio/{id}', [OrdenCambioController::class, 'generarOC']);
Route::get('/generar/notificacionconformidad/{id}', [NotificacionConfController::class, 'generarNC']);
Route::get('/generar/contrato/{id}', [ContratoController::class, 'generarCN']);

Route::apiResource('postulacion',PostulacionController::class);
Route::apiResource('/postulacion/ordencambio/',OrdenCambioController::class);

Route::post('postulacion/notificacionconformidad/',[NotificacionConfController::class, 'registrarNotificacion']);
Route::get('revision/postulacion/{id}', [OrdenCambioController::class, 'doyDatosRevision']);
Route::post('revision/observaciones',[ObservacionPropuestaController::class, 'aniadirObs']);
Route::put('/eliminarObs/{id}', [ObservacionPropuestaController::class, 'eliminarObs']);
Route::get('/revision/documentos/{fileID}', [ObservacionPropuestaController::class, 'showDocs']);
Route::get('/ver/observaciones/{id}', [OrdenCambioController::class, 'doyDatosRevisionObs']);
Route::post('aniadir/observaciones',[ObservacionPropuestaController::class, 'aniadirArrObs']);
Route::get('/enviar/documentos/{fileID}', [ObservacionPropuestaController::class, 'showDocs']);
Route::post('aniadir/rol',[UserController::class, 'asignarRol']);
Route::get('/enviar/permisos/{id}', [UserController::class, 'darPermisos']);
Route::get('/ordendecambio/autollenado/{id}', [OrdenCambioController::class, 'doyOrdenCambio']);
Route::get('/notificacionconformidad/autollenado/{id}', [NotificacionConfController::class, 'doyNoti']);
Route::post('/asignar/grupo', [UserController::class, 'asignarAGE']);


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::post('cambiar', 'App\Http\Controllers\AuthController@cambiar');
    Route::post('registerConsultor', 'App\Http\Controllers\AuthController@registerConsultor');



});
