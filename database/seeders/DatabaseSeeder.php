<?php

namespace Database\Seeders;

use App\Models\Convocatoria;
use App\Models\Documento;
use App\Models\GrupoEmpresa;
use App\Models\HitoPlanificacion;
use App\Models\PliegoEspecificacion;
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

        $grupoempresa1 = new GrupoEmpresa();
        $grupoempresa1-> nombre = "Pacha";
        $grupoempresa1-> nombreRepresentante = "Pedro Perez";
        $grupoempresa1-> nombreconsultor = "Leticia Blanco";
        $grupoempresa1->save();

        $grupoempresa2 = new GrupoEmpresa();
        $grupoempresa2-> nombre = "AlgoSoft";
        $grupoempresa2-> nombreRepresentante = "Maria Nieves";
        $grupoempresa2-> nombreconsultor = "Leticia Blanco";
        $grupoempresa2->save();

        $grupoempresa3 = new GrupoEmpresa();
        $grupoempresa3-> nombre = "IntiSoft";
        $grupoempresa3-> nombreRepresentante = "Carlos Rojas";
        $grupoempresa3-> nombreconsultor = "Leticia Blanco";
        $grupoempresa3->save();

        $grupoempresa4 = new GrupoEmpresa();
        $grupoempresa4-> nombre = "CocaSoft";
        $grupoempresa4-> nombreRepresentante = "Marcelo Coca";
        $grupoempresa4-> nombreconsultor = "Vladimir Lopez";
        $grupoempresa4->save();





        $convocatoria = new Convocatoria();
        $convocatoria -> codigo = "2020convo-2";
        $convocatoria -> titulo = "Convocatoria primera" ;
        $convocatoria -> descripcion = "Lorum ipsum dolor Lorum ipsum dolo Lorum ipsum dolo Lorum ipsum dolo";
        $convocatoria -> consultorEnc = "Leticia Blanco";
        $convocatoria -> fechaLimRec ="2021-10-22";
        $convocatoria -> fechaIniDur ="2021-10-25";
        $convocatoria -> fechaFinDur = "2021-12-25";
        $convocatoria -> documento = "dirdoc/dirdoc.gg";
        $convocatoria->save();

        $convocatoria1 = new Convocatoria();
        $convocatoria1 -> codigo = "2021convo-1";
        $convocatoria1 -> titulo = "Convocatoria segunda" ;
        $convocatoria1 -> descripcion = "Lorum ipsum dolor Lorum ipsum dolo Lorum ipsum dolo Lorum ipsum dolo";
        $convocatoria1 -> consultorEnc = "Vladimir Lopez";
        $convocatoria1 -> fechaLimRec ="2021-11-22";
        $convocatoria1 -> fechaIniDur ="2021-11-25";
        $convocatoria1 -> fechaFinDur = "2021-12-25";
        $convocatoria1 -> documento = "dirdoc/dirdoc.gg";
        $convocatoria1->save();

        $pliego = new PliegoEspecificacion();
        $pliego -> codigo = "2021convo-1";
        $pliego -> titulo = "Convocatoria segunda" ;
        $pliego -> documento = "dirdoc/dirdoc.gg";
        $pliego -> convocatoria_id = 1;
        $pliego->save();


        $this -> call(HitoSeeder::class);
        $this -> call(PostulacionSeeder::class);

    }
}
