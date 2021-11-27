<?php

namespace Database\Seeders;

use App\Models\DetalleDoc;
use Illuminate\Database\Seeder;

class DetalleDocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $det = new DetalleDoc();
        $det-> nombreDoc = "Parte-A";
        $det->save();

        $det1 = new DetalleDoc();
        $det1-> nombreDoc = "Parte-B";
        $det1->save();

        $det2 = new DetalleDoc();
        $det2-> nombreDoc = "BoletaDeGarantia";
        $det2->save();

        $det3 = new DetalleDoc();
        $det3-> nombreDoc = "CartaDePresentacion";
        $det3->save();

        $det4 = new DetalleDoc();
        $det4-> nombreDoc = "Constitucion";
        $det4->save();
    }
}
