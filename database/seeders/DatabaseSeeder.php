<?php

namespace Database\Seeders;

use App\Models\Documento;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $documento = new Documento();
        $documento-> nombre = "Documentopdf";
        $documento-> direccion = "app\Documentopdf";
        $documento->save();
    }
}
