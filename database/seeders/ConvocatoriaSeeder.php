<?php

namespace Database\Seeders;

use App\Models\Convocatoria;
use App\Models\GrupoEmpresa;
use App\Models\PliegoEspecificacion;
use Illuminate\Database\Seeder;

class ConvocatoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grupoempresa = new GrupoEmpresa();
        $grupoempresa-> nombre = "Iridium";
        $grupoempresa->save();

        $grupoempresa1 = new GrupoEmpresa();
        $grupoempresa1-> nombre = "Pacha";
        $grupoempresa1->save();

        $grupoempresa2 = new GrupoEmpresa();
        $grupoempresa2-> nombre = "AlgoSoft";
        $grupoempresa2->save();

        $grupoempresa3 = new GrupoEmpresa();
        $grupoempresa3-> nombre = "IntiSoft";
        $grupoempresa3->save();

        $grupoempresa4 = new GrupoEmpresa();
        $grupoempresa4-> nombre = "CocaSoft";
        $grupoempresa4->save();

        $grupoempresa4 = new GrupoEmpresa();
        $grupoempresa4-> nombre = "Fracaso SOFT";
        $grupoempresa4->save();

        $convocatoria = new Convocatoria();
        $convocatoria -> codigo = "2020convo-2";
        $convocatoria -> titulo = "Convocatoria primera" ;
        $convocatoria -> descripcion = "Lorum ipsum dolor Lorum ipsum dolo Lorum ipsum dolo Lorum ipsum dolo";
        $convocatoria -> consultorEnc = "Leticia Blanco";
        $convocatoria -> fechaLimRec ="2021-12-22";
        $convocatoria -> fechaIniDur ="2021-12-25";
        $convocatoria -> fechaFinDur = "2022-2-25";
        $convocatoria -> documento = "7XcWvSqdDOAhziMIsd0m.pdf";
        $convocatoria->save();

        $convocatoria1 = new Convocatoria();
        $convocatoria1 -> codigo = "2021convo-1";
        $convocatoria1 -> titulo = "Convocatoria segunda" ;
        $convocatoria1 -> descripcion = "Lorum ipsum dolor Lorum ipsum dolo Lorum ipsum dolo Lorum ipsum dolo";
        $convocatoria1 -> consultorEnc = "Vladimir Lopez";
        $convocatoria1 -> fechaLimRec ="2021-11-22";
        $convocatoria1 -> fechaIniDur ="2021-11-25";
        $convocatoria1 -> fechaFinDur = "2021-12-25";
        $convocatoria1 -> documento = "7XcWvSqdDOAhziMIsd0m.pdf";
        $convocatoria1->save();

        $convocatoria2 = new Convocatoria();
        $convocatoria2 -> codigo = "2010convo-1";
        $convocatoria2 -> titulo = "Convocatoria tercera" ;
        $convocatoria2 -> descripcion = "Lorum ipsum dolor Lorum ipsum dolo Lorum ipsum dolo Lorum ipsum dolo";
        $convocatoria2 -> consultorEnc = "Vladimir Lopez";
        $convocatoria2 -> fechaLimRec ="2021-11-22";
        $convocatoria2 -> fechaIniDur ="2021-11-25";
        $convocatoria2 -> fechaFinDur = "2021-12-25";
        $convocatoria2 -> documento = "7XcWvSqdDOAhziMIsd0m.pdf";
        $convocatoria2->save();

        $convocatoria3 = new Convocatoria();
        $convocatoria3 -> codigo = "2017convo-1";
        $convocatoria3 -> titulo = "Convocatoria cuarta" ;
        $convocatoria3 -> descripcion = "Lorum ipsum dolor Lorum ipsum dolo Lorum ipsum dolo Lorum ipsum dolo";
        $convocatoria3 -> consultorEnc = "Vladimir";
        $convocatoria3 -> fechaLimRec ="2021-11-22";
        $convocatoria3 -> fechaIniDur ="2021-11-25";
        $convocatoria3 -> fechaFinDur = "2021-12-25";
        $convocatoria3 -> documento = "7XcWvSqdDOAhziMIsd0m.pdf";
        $convocatoria3->save();

        $convocatoria4 = new Convocatoria();
        $convocatoria4 -> codigo = "2021-11";
        $convocatoria4 -> titulo = "Quinta Convocatoria" ;
        $convocatoria4 -> descripcion = "Lorum ipsum dolor Lorum ipsum dolo Lorum ipsum dolo Lorum ipsum dolo";
        $convocatoria4 -> consultorEnc = "Leticia Blanco";
        $convocatoria4 -> fechaLimRec ="2021-11-22";
        $convocatoria4 -> fechaIniDur ="2021-11-25";
        $convocatoria4 -> fechaFinDur = "2021-12-25";
        $convocatoria4 -> documento = "7XcWvSqdDOAhziMIsd0m.pdf";
        $convocatoria4->save();

        $pliego = new PliegoEspecificacion();
        $pliego -> codigo = "2021convo-1";
        $pliego -> titulo = "Convocatoria segunda" ;
        $pliego -> documento = "7XcWvSqdDOAhziMIsd0m.pdf";
        $pliego -> convocatoria_id = 1;
        $pliego->save();
    }
}
