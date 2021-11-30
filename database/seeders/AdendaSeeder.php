<?php

namespace Database\Seeders;

use App\Models\Adenda;
use App\Models\Contrato;
use Illuminate\Database\Seeder;

class AdendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adenda = new Adenda();
        $adenda-> codigo = "2021-AD";
        $adenda->fechaEmDocumento ="2021-11-22";
        $adenda -> estado = false;
        $adenda -> documento = "zLyRNydCmAzTSPrVkw2x.pdf";
        $adenda -> ordendecambio_id = 1;
        $adenda ->save();

        $contrato = new Contrato();
        $contrato-> codigo = "2021-CN";
        $contrato-> fechaEmDocumento ="2021-11-22";
        $contrato -> estado = false;
        $contrato -> documento = "zLyRNydCmAzTSPrVkw2x.pdf";
        $contrato -> postulacion_id = 1;
        $contrato ->save();
    }
}
