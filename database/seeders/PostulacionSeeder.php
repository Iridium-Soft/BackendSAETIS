<?php

namespace Database\Seeders;

use App\Models\Postulacion;
use Illuminate\Database\Seeder;

class PostulacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $postulacion = new Postulacion();
        $postulacion-> convocatoria_id = 1;
        $postulacion-> grupoEmpresa_id = 1;
        $postulacion->save();

        $postulacion1 = new Postulacion();
        $postulacion1-> convocatoria_id = 1;
        $postulacion1-> grupoEmpresa_id = 2;
        $postulacion1->save();

        $postulacion2 = new Postulacion();
        $postulacion2-> convocatoria_id = 1;
        $postulacion2-> grupoEmpresa_id = 3;
        $postulacion2->save();

        $postulacion3 = new Postulacion();
        $postulacion3-> convocatoria_id = 2;
        $postulacion3-> grupoEmpresa_id = 4;
        $postulacion3->save();

        $postulacion4 = new Postulacion();
        $postulacion4-> convocatoria_id = 5;
        $postulacion4-> grupoEmpresa_id = 5;
        $postulacion4->save();
    }
}
