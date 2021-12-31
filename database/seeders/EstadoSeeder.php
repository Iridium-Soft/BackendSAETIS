<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado = new Estado();
        $estado->nombre = "En espera de documentos";
        $estado->descripcion = "Consultor TIS espera documentos ";
        $estado->save();

        $estado1 = new Estado();
        $estado1->nombre = "Postulacion no revisada";
        $estado1->descripcion = "En espera de revision de la postulacion de la GrupoEmpresa";
        $estado1->save();

        $estado2 = new Estado();
        $estado2->nombre = "En espera de calificacion de NC";
        $estado2->descripcion = "En espera de calificacion de una postulacion sin Observaciones";
        $estado2->save();

        $estado3 = new Estado();
        $estado3->nombre = "En espera de publicacion de NC";
        $estado3->descripcion = "En espera de publicacion de Notificacion de conformidad generada";
        $estado3->save();

        $estado4 = new Estado();
        $estado4->nombre = "En espera de publicacion de Contrato";
        $estado4->descripcion = "En espera de publicacion de Contratodd";
        $estado4->save();

        $estado5 = new Estado();
        $estado5->nombre = "En espera de calificacion de OC";
        $estado5->descripcion = "En espera de calificacion de OCdd";
        $estado5->save();

        $estado6 = new Estado();
        $estado6->nombre = "En espera de publicacion de OC";
        $estado6->descripcion = "Se espera que el cosultor TIS realice la publicacion de la Orden de Cambio correspondiente a la postulacion para informar de las observaciones realizadas a la documentacion presentada por la Grupo Empresa";
        $estado6->save();

        $estado7 = new Estado();
        $estado7->nombre = "En espera de documentos corregidos";
        $estado7->descripcion = "En espera de documentos corregidosdd";
        $estado7->save();

        $estado8 = new Estado();
        $estado8->nombre = "Postulacion Observada no revisada";
        $estado8->descripcion = "Postulacion Observada no revisadadd";
        $estado8->save();

        $estado9 = new Estado();
        $estado9->nombre = "En espera de publicacion de Adenda";
        $estado9->descripcion = "En espera de publicacion de Adendadd";
        $estado9->save();

        $estadoa = new Estado();
        $estadoa->nombre = "Postulacion Concluida";
        $estadoa->descripcion = "Postulacion Concluidadd";
        $estadoa->save();

    }
}
