<?php

namespace Database\Seeders;

use App\Models\Contrato;
use App\Models\NotificacionConf;
use Illuminate\Database\Seeder;

class NotificacionConfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $noti = new NotificacionConf();
        $noti -> codigo = "2021NC-1";
        $noti -> fechaEmDocumento = "2021-10-22" ;
        $noti -> lugar = "cochabamba";
        $noti -> estado = false;
        $noti -> documento = "7XcWvSqdDOAhziMIsd0m.pdf";
        $noti -> postulacion_id = 2;
        $noti->save();

        $contrato = new Contrato();
        $contrato-> codigo = "2021-CN";
        $contrato-> fechaEmDocumento ="2021-11-22";
        $contrato -> estado = false;
        $contrato -> documento = "zLyRNydCmAzTSPrVkw2x.pdf";
        $contrato -> postulacion_id = 2;
        $contrato ->save();
    }

}
