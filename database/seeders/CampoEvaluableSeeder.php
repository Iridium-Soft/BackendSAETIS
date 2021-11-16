<?php

namespace Database\Seeders;

use App\Models\Calificacion;
use App\Models\CampoEvaluable;
use Illuminate\Database\Seeder;

class CampoEvaluableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $campoEvaluar = new CampoEvaluable();
        $campoEvaluar->descripcion ="Cumplimiento de especificaciones del proponente";
        $campoEvaluar->puntaje=15;
        $campoEvaluar->save();
        $campoEvaluar = new CampoEvaluable();
        $campoEvaluar->descripcion ="Claridad en la organización de la empresa proponente";
        $campoEvaluar->puntaje=10;
        $campoEvaluar->save();
        $campoEvaluar = new CampoEvaluable();
        $campoEvaluar->descripcion ="Cumplimiento de especificaciones técnicas";
        $campoEvaluar->puntaje=30;
        $campoEvaluar->save();
        $campoEvaluar = new CampoEvaluable();
        $campoEvaluar->descripcion ="Claridad en el proceso de desarrollo";
        $campoEvaluar->puntaje=10;
        $campoEvaluar->save();
        $campoEvaluar = new CampoEvaluable();
        $campoEvaluar->descripcion ="Plazo de ejecución";
        $campoEvaluar->puntaje=10;
        $campoEvaluar->save();
        $campoEvaluar = new CampoEvaluable();
        $campoEvaluar->descripcion ="Precio total";
        $campoEvaluar->puntaje=15;
        $campoEvaluar->save();
        $campoEvaluar = new CampoEvaluable();
        $campoEvaluar->descripcion ="Uso de herramientas en el proceso de desarrollo";
        $campoEvaluar->puntaje=10;
        $campoEvaluar->save();

    }
}
