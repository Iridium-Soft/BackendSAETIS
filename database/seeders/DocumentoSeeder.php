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
        $doc-> documento = "algo1.pdf";
        $doc-> postulacion_id = 1;
        $doc-> detalleDoc_id = 1;
        $doc->save();

        $doc1 = new Documento();
        $doc1-> documento = "algo2.pdf";
        $doc1-> postulacion_id = 1;
        $doc1-> detalleDoc_id = 2;
        $doc1->save();


        $doc2 = new Documento();
        $doc2-> documento = "algo3.pdf";
        $doc2-> postulacion_id = 1;
        $doc2-> detalleDoc_id = 3;
        $doc2->save();


        $doc3 = new Documento();
        $doc3-> documento = "algo4.pdf";
        $doc3-> postulacion_id = 1;
        $doc3-> detalleDoc_id = 4;
        $doc3->save();


        $doc4 = new Documento();
        $doc4-> documento = "algo5.pdf";
        $doc4-> postulacion_id = 1;
        $doc4-> detalleDoc_id = 5;
        $doc4->save();


    }

}
