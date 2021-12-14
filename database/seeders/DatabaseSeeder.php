<?php

namespace Database\Seeders;

use App\Models\CampoEvaluable;
use App\Models\Consultor;
use App\Models\ConvConsultor;
use App\Models\Convocatoria;
use App\Models\Documento;
use App\Models\GrupoEmpresa;
use App\Models\HitoPlanificacion;
use App\Models\ObservacionPropuesta;
use App\Models\PliegoEspecificacion;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this -> call(RoleSeeder::class);
        $this -> call(UserSeeder::class);
        $this -> call(ConsultorSeeder::class);
        $this -> call(ConvocatoriaSeeder::class);
        $this -> call(ConvConsultorSeeder::class);
        $this -> call(PostulacionSeeder::class);
        $this -> call(PlanificacionSeeder::class);
        $this -> call(HitoSeeder::class);
        $this -> call(CampoEvaluableSeeder::class);
        $this -> call(NotificacionConfSeeder::class);
        $this -> call(OrdenCambioSeeder::class);
        $this -> call(AdendaSeeder::class);
        $this -> call(DetalleDocSeeder::class);
        $this -> call(DocumentoSeeder::class);
        $this -> call(ObservacionPropuestaSeeder::class);


    }
}
