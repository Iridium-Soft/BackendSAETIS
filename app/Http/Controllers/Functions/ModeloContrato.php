<?php

namespace App\Http\Controllers\Functions;

use App\Models\Contrato;
use App\Models\GrupoEmpresa;
use App\Models\Postulacion;

class ModeloContrato
{
    public $contenidoTotal="";

    function crearContrato($id_Contrato){
        $notificacion = Contrato::find($id_Contrato);
        $archivo = fopen("contrato.tex", "w+b");
        $this->addCabecera();
        $this->addAutor($notificacion);
        $this->addCuerpo($notificacion);
        $datos = $this->contenidoTotal;
        fwrite($archivo, $datos);
    }

    function addCabecera(){
        $cabecera =  "\documentclass[10pt,letterpaper]{article} \n\usepackage[utf8]{inputenc}\n\usepackage[left=3cm,right=2cm,top=2cm,bottom=2cm]{geometry}\n\usepackage[spanish]{babel}\n\usepackage{amsmath}\n\usepackage{amsfonts}\n\usepackage{amssymb}\n\usepackage{graphicx}\n\n";
        $this-> contenidoTotal .= $cabecera;
    }

    function addAutor($contrato){
        $autor =  "\\title{ \\textbf{CONTRATO DE PRESTACION DE SERVICIOS - CONSULTORIA }\\\\{$contrato->fechaEmDocumento}}\date{}\n\n";
        $this-> contenidoTotal .= $autor;
    }

    function addCuerpo($contrato){
        $postu = Postulacion::find($contrato->postulacion_id);
        $GE = GrupoEmpresa::find($postu->grupoEmpresa_id);
        $this-> contenidoTotal .= "\begin{document}\n\maketitle\n\n
Que suscriben la empresa Taller de Ingenieria de Software - TIS, que en lo sucesivo se denominara TIS, por
una parte, y la consultora \\textbf{Iridium Software SRL}, registrada debidamente en el Departamento de Procesamiento de Datos y Registro e Inscripciones, domiciliada en la ciudad de Cochabamba, que en lo sucesivo se
denominara \\textbf{Iridium}, por otra parte, de conformidad a las clausulas que se detallan a continuacion:\n\n";

        $this-> contenidoTotal .= "\\end{document}\n";
    }



}
