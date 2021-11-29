<?php

namespace Database\Seeders;

use App\Models\ObservacionPropuesta;
use Illuminate\Database\Seeder;

class ObservacionPropuestaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $observacion = new ObservacionPropuesta();
        $observacion-> seccionDoc = "AndyJoto";
        $observacion-> descripcion = "andy tienes que llenar los seeders tambien vago, en su respectivo archivo por favor";
        $observacion-> revisado= false;
        $observacion->corregido= false;
        $observacion-> documento_id=1;
        $observacion->save();


        $observacion1 = new ObservacionPropuesta();
        $observacion1-> seccionDoc = "1.9.1.";
        $observacion1-> descripcion= "TIS hace notar que estan planificando en fechas que son feriados y fines de semana,
lo que genera una riesgo de imposibilidad de realizacion. Por lo que, se solicita revisar este apartado.";
        $observacion1-> revisado= false;
        $observacion1->corregido= false;
        $observacion1-> documento_id=2;
        $observacion1->save();


        $observacion2 = new ObservacionPropuesta();
        $observacion2-> seccionDoc = "4.1.1.";
        $observacion2-> descripcion= "TIS solicita justificar los montos estipulados como parte de pago de personal, en
cuanto al esfuerzo comprometido y requerido para el desarrollo del proyecto.";
        $observacion2-> revisado= false;
        $observacion2->corregido= false;
        $observacion2-> documento_id=2;
        $observacion2->save();

        $observacion3 = new ObservacionPropuesta();
        $observacion3-> seccionDoc = "4.2.";
        $observacion3-> descripcion= "TIS solicita justificar los montos erogados en cada item de los costo de la propuesta";
        $observacion3-> revisado= false;
        $observacion3->corregido= false;
        $observacion3-> documento_id=3;
        $observacion3->save();


        $observacion4 = new ObservacionPropuesta();
        $observacion4-> seccionDoc = "Plazo de duración";
        $observacion4-> descripcion= "la vida de la empresa es minima y no genera
confianza a TIS, ya que estas fechas no permiten manteniiento de software
";      $observacion4-> revisado= false;
        $observacion4->corregido= false;
        $observacion4-> documento_id=4;
        $observacion4->save();


        $observacion5 = new ObservacionPropuesta();
        $observacion5-> seccionDoc = "Previsiones para reservas";
        $observacion5-> descripcion= "que a la letra dice “En caso de fallecimiento, impedimento o incapacidad sobreviniente de uno de los socios, los restantes continuarán con
el giro social, juntamente con los herederos forzosos o legales o los representantes según el caso hasta la
culminación de la gestión anual.”, para fines de este contrato los herederos no forma parte de la sociedad
en ningun contexto. TIS solicita se corrija este apartado.";
        $observacion5-> revisado= false;
        $observacion5->corregido= false;
        $observacion5-> documento_id=5;
        $observacion5->save();
    }
}
