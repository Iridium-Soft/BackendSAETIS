<?php

namespace Database\Seeders;

use App\Models\Adenda;
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
        $adenda ->save();
    }
}
