<?php

namespace Database\Seeders;

use App\Models\Consultor;
use Illuminate\Database\Seeder;

class ConsultorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $consultor = new Consultor();
        $consultor-> nombre = "Leticia Blanco";
        $consultor-> activo = true;
        $consultor ->save();

        $consultor1 = new Consultor();
        $consultor1-> nombre = "David Escalera";
        $consultor1-> activo = true;
        $consultor1 ->save();

        $consultor2 = new Consultor();
        $consultor2-> nombre = "Corina Flores";
        $consultor2-> activo = true;
        $consultor2 ->save();

        $consultor1 = new Consultor();
        $consultor1-> nombre = "Patricia Rodriguez";
        $consultor1-> activo = true;
        $consultor1 ->save();

    }
}
