<?php

namespace Database\Seeders;

use App\Models\Documento;
use Illuminate\Database\Seeder;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doc = new Documento();
        $doc-> documento = "JenniferPacoPremioTuring.pdf";
        $doc-> postulacion_id = 1;
        //$doc->revisionDoc_id=6;
        $doc-> detalleDoc_id = 1;
        $doc->save();

        $doc1 = new Documento();
        $doc1-> documento = "JenniferPacoPremioTuring.pdf";
        $doc1-> postulacion_id = 1;
        //$doc1->revisionDoc_id=7;
        $doc1-> detalleDoc_id = 2;
        $doc1->save();


        $doc2 = new Documento();
        $doc2-> documento = "JenniferPacoPremioTuring.pdf";
        $doc2-> postulacion_id = 1;
        //$doc2->revisionDoc_id=8;
        $doc2-> detalleDoc_id = 3;
        $doc2->save();


        $doc3 = new Documento();
        $doc3-> documento = "JenniferPacoPremioTuring.pdf";
        $doc3-> postulacion_id = 1;
        $doc3-> detalleDoc_id = 4;
        $doc3->save();


        $doc4 = new Documento();
        $doc4-> documento = "JenniferPacoPremioTuring.pdf";
        $doc4-> postulacion_id = 1;
        $doc4-> detalleDoc_id = 5;
        $doc4->save();
/*
        $doc5 = new Documento();
        $doc5-> documento = "JenniferPacoPremioTuring.pdf";
        $doc5-> postulacion_id = 1;
        $doc5->revisionDoc_id=1;
        $doc5-> detalleDoc_id = 6;
        $doc5->save();

        $doc6 = new Documento();
        $doc6-> documento = "JenniferPacoPremioTuring.pdf";
        $doc6-> postulacion_id = 1;
        $doc6->revisionDoc_id=2;
        $doc6-> detalleDoc_id = 7;
        $doc6->save();

        $doc7 = new Documento();
        $doc7-> documento = "JenniferPacoPremioTuring.pdf";
        $doc7-> postulacion_id = 1;
        $doc7->revisionDoc_id=3;
        $doc7-> detalleDoc_id = 8;
        $doc7->save();*/

    }

}
