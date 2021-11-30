<?php

namespace Database\Seeders;
use App\Models\Calificacion;
use App\Models\CampoEvaluable;
use App\Models\ObservacionPropuesta;
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
        $orden -> fechaFirma = "2021-10-22" ;
        $orden -> lugar = "Bloque Informatica UMSS Piso 1";
        $orden -> estado = false;
        $orden -> postulacion_id = 1;
        $orden -> documento = "zLyRNydCmAzTSPrVkw2x.pdf";
        $orden->save();

        $puntaje1 = new Calificacion();
        $puntaje1 ->puntajeObtenido = 4;
        $puntaje1 ->campoEvaluable_id = 1;
        $puntaje1 ->ordenDeCambio_id =1;
        $puntaje1->save();

        $puntaje2 = new Calificacion();
        $puntaje2 ->puntajeObtenido = 5;
        $puntaje2 ->campoEvaluable_id = 2;
        $puntaje2 ->ordenDeCambio_id =1;
        $puntaje2->save();

        $puntaje3 = new Calificacion();
        $puntaje3 ->puntajeObtenido = 6;
        $puntaje3 ->campoEvaluable_id = 3;
        $puntaje3 ->ordenDeCambio_id =1;
        $puntaje3->save();

        $puntaje4 = new Calificacion();
        $puntaje4 ->puntajeObtenido = 7;
        $puntaje4 ->campoEvaluable_id = 4;
        $puntaje4 ->ordenDeCambio_id =1;
        $puntaje4->save();

        $puntaje5 = new Calificacion();
        $puntaje5 ->puntajeObtenido = 8;
        $puntaje5 ->campoEvaluable_id = 5;
        $puntaje5 ->ordenDeCambio_id =1;
        $puntaje5->save();

        $puntaje6 = new Calificacion();
        $puntaje6 ->puntajeObtenido = 9;
        $puntaje6 ->campoEvaluable_id = 6;
        $puntaje6 ->ordenDeCambio_id =1;
        $puntaje6->save();

        $puntaje7 = new Calificacion();
        $puntaje7 ->puntajeObtenido = 10;
        $puntaje7 ->campoEvaluable_id = 7;
        $puntaje7 ->ordenDeCambio_id =1;
        $puntaje7->save();



    }
}
