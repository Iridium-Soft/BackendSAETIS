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
        $hito = new HitoPlanificacion();
        $hito-> nombre = "Sprint 0";
        $hito-> fechaIni = "2021-10-22";
        $hito-> fechaFin ="2021-10-22";
        $hito-> porcentajeCobro = 16;
        $hito->planificacion_id = 1;
        $hito-> entregables = "fnrgergoinsfsgsfg";
        $hito ->save();

        $hito1 = new HitoPlanificacion();
        $hito1-> nombre = "Sprint 1";
        $hito1-> fechaIni = "2021-10-23";
        $hito1-> fechaFin ="2021-10-24";
        $hito1-> porcentajeCobro = 16;
        $hito1->planificacion_id = 1;
        $hito1-> entregables = "fnrgergowjjjjjjemmossss";
        $hito1->save();

        $hito2 = new HitoPlanificacion();
        $hito2-> nombre = "Sprint 1";
        $hito2-> fechaIni = "2021-10-24";
        $hito2-> fechaFin ="2021-10-25";
        $hito2-> porcentajeCobro = 100;
        $hito2->planificacion_id = 2;
        $hito2-> entregables = "fnrgergowjjjjjjemmossss";
        $hito2->save();

        $hito3 = new HitoPlanificacion();
        $hito3-> nombre = "Sprint 1";
        $hito3-> fechaIni = "2021-10-25";
        $hito3-> fechaFin ="2021-10-26";
        $hito3-> porcentajeCobro = 100;
        $hito3->planificacion_id = 3;
        $hito3-> entregables = "fnrgergowjjjjjjemmossss";
        $hito3->save();

    }
}
