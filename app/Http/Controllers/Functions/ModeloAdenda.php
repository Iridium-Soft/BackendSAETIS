<?php

namespace App\Http\Controllers\Functions;

use App\Models\Adenda;
use App\Models\Documento;
use App\Models\GrupoEmpresa;
use App\Models\ObservacionPropuesta;
use App\Models\OrdenCambio;
use App\Models\Postulacion;

class ModeloAdenda
{
    public $contenidoTotal="";
    function crearAdenda($id_Adenda){
        $adenda = Adenda::find($id_Adenda);
        $archivo = fopen("adenda.tex", "w+b");
        $this->addCabecera();
        $this->addAutor($adenda);
        $this->addCuerpo($adenda);
        $datos = $this->contenidoTotal;
        fwrite($archivo, $datos);
    }

    function addCabecera(){
        $cabecera =  "\documentclass[10pt,letterpaper]{article} \n\usepackage[utf8]{inputenc}\n\usepackage[left=3cm,right=2cm,top=2cm,bottom=2cm]{geometry}\n\usepackage[spanish]{babel}\n\usepackage{amsmath}\n\usepackage{amsfonts}\n\usepackage{amssymb}\n\usepackage{graphicx}\n\n";
        $this-> contenidoTotal .= $cabecera;
    }

    function addAutor($adenda){
        $autor =  "\\title{Adenda}\n\author{{$adenda->codigo}\\\\{Nombre de Consultor}}\n\date{{$adenda->fechaEmContrato}}\n\n";
        $this-> contenidoTotal .= $autor;
    }

    function addCuerpo($adenda){

        $this-> contenidoTotal .= "\begin{document}\n\maketitle\n\n
TIS ha revisado la propuesta corregida que \\textbf{Iridium pa} ha entregado y se ha evidenciado que no se han
respondido a cabalidad las observaciones de la orden de cambio, por lo que en comun acuerdo se define la
siguiente adenda a los puntos no respondidos a cabalidad de la orden de cambio:\\\\\n\n";

        $this->addListaObs($adenda);
        $this-> contenidoTotal .= "\\end{document}\n";
    }

    function addListaObs($adenda){
        $ordencambio = OrdenCambio::find($adenda->ordendecambio_id);
        $postulacion = Postulacion::find( $ordencambio->postulacion_id);
        $documentos = Documento::where('postulacion_id',$ordencambio->postulacion_id)->get();
        $observaciones = collect();

        foreach ($documentos as $docus){
            $observacionesPorDoc = ObservacionPropuesta::where('documento_id',$docus->id)->get();

            foreach ($observacionesPorDoc as $obs){
                $observaciones->add($obs);
            }
        }
        for ($i=1;$i<=$observaciones->count() ;$i++) {
            if (!$observaciones[$i-1]->corregido) {
                $this->contenidoTotal .= "\\textbf{Observacion {$i} :} {$observaciones[$i-1]->correccion}\\\\\n\n ";
            }
        }
    }
}
