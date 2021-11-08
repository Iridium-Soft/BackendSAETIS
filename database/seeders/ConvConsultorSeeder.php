<?php

namespace Database\Seeders;

use App\Models\ConvConsultor;
use Illuminate\Database\Seeder;

class ConvConsultorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $convConsultor = new ConvConsultor();
        $convConsultor-> convocatoria_id = 1;
        $convConsultor-> consultor_id = 1;
        $convConsultor ->save();

        $convConsultor1 = new ConvConsultor();
        $convConsultor1-> convocatoria_id = 2;
        $convConsultor1-> consultor_id = 2;
        $convConsultor1 ->save();

        $convConsultor1 = new ConvConsultor();
        $convConsultor1-> convocatoria_id = 3;
        $convConsultor1-> consultor_id = 3;
        $convConsultor1 ->save();

        $convConsultor1 = new ConvConsultor();
        $convConsultor1-> convocatoria_id = 4;
        $convConsultor1-> consultor_id = 4;
        $convConsultor1 ->save();
    }
}
