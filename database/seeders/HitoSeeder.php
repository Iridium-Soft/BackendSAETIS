<?php

namespace Database\Seeders;

use App\Models\HitoPlanificacion;
use App\Models\Planificacion;
use Illuminate\Database\Seeder;

class HitoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $planificacion = new Planificacion();
        $planificacion->save();

        $hito = new HitoPlanificacion();
        $hito-> nombre = "prueba2";
        $hito-> fechaIni = "2021-10-22";
        $hito-> fechaFin ="2021-10-22";
        $hito-> porcentajeCobro = 46;
        $hito->planificacion_id = 1;
        $hito-> entregables = "fnrgergoinsfsgsfg";
        $hito ->save();


    }
}
