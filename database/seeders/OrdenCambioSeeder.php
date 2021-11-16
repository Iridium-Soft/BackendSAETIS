<?php

namespace Database\Seeders;
use App\Models\OrdenCambio;
use Illuminate\Database\Seeder;

class OrdenCambioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orden = new OrdenCambio();
        $orden -> codigo = "2021orden-1";
        $orden -> fechaEmContrato = "2021-10-22" ;
        $orden -> lugar = "cochabamba";
        $orden -> estado = false;
        $orden->save();
    }
}
