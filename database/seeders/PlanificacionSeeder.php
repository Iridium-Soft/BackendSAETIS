<?php

namespace Database\Seeders;

use App\Models\Planificacion;
use Illuminate\Database\Seeder;

class PlanificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plani = new Planificacion();
        $plani -> postulacion_id = 1;
        $plani->save();

        $plani1 = new Planificacion();
        $plani1 -> postulacion_id = 2;
        $plani1->save();

        $plani2 = new Planificacion();
        $plani2 -> postulacion_id = 3;
        $plani2->save();

        $plani3 = new Planificacion();
        $plani3 -> postulacion_id = 4;
        $plani3->save();

        $plani4 = new Planificacion();
        $plani4 -> postulacion_id = 5;
        $plani4->save();
    }
}
