<?php

namespace Database\Seeders;

use App\Models\Convocatoria;
use App\Models\Documento;
use App\Models\GrupoEmpresa;
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
        $grupoempresa = new GrupoEmpresa();
        $grupoempresa-> nombre = "Iridium";
        $grupoempresa-> nombreRepresentante = "Andy Garcia";
        $grupoempresa-> nombreconsultor = "Leticia Blanco";
        $grupoempresa->save();

        $convocatoria = new Convocatoria();
        $convocatoria -> codigo = "2020convo-2";
        $convocatoria -> titulo = "Convocatoria primera" ;
        $convocatoria -> descripcion = "Lorum ipsum dolor Lorum ipsum dolo Lorum ipsum dolo Lorum ipsum dolo";
        $convocatoria -> consultorEnc = "Leticia Blanco";
        $convocatoria -> fechaLimRec ="22-10-2021";
        $convocatoria -> fechaIniDur ="25-10-2021";
        $convocatoria -> fechaFinDur = "25-12-2021";
        $convocatoria -> documento = "dirdoc/dirdoc.gg";
        $convocatoria->save();
    }
}
