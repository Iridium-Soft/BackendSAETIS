<?php

namespace App\Http\Controllers\Functions;

use App\Models\Calificacion;
use App\Models\CampoEvaluable;
use App\Models\OrdenCambio;

class ModeloOrdenDeCambio
{
    public $contenidoTotal="";

    function crearOrden($id_OrdenCambio){
        $ordenCambio = OrdenCambio::find($id_OrdenCambio);
        $archivo = fopen("plantilla.tex", "w+b");
        $this->addCabecera();
        $this->addAutor($ordenCambio);
        $this->addCuerpo($ordenCambio);
        $datos = $this->contenidoTotal;
        fwrite($archivo, $datos);
    }

    function addCabecera(){
        $cabecera =  "\documentclass[10pt,letterpaper]{article} \n\usepackage[utf8]{inputenc}\n\usepackage[left=3cm,right=2cm,top=2cm,bottom=2cm]{geometry}\n\usepackage[spanish]{babel}\n\usepackage{amsmath}\n\usepackage{amsfonts}\n\usepackage{amssymb}\n\usepackage{graphicx}\n\n";
        $this-> contenidoTotal .= $cabecera;
    }

    function addAutor($ordenCambio){
        $autor =  "\\title{Orden de Cambio}\n\author{{$ordenCambio->codigo}\\\\Leticia Blanco Coca}\n\date{{$ordenCambio->fechaEmContrato}}\n\n";
        $this-> contenidoTotal .= $autor;
    }

    function addCuerpo($ordenCambio){
        $this-> contenidoTotal .= "\begin{document}\n\maketitle\n\n
TIS ha revisado la propuesta que su empresa ha entregado y se ha puntuado de la siguiente manera:\n\n";
        $this->addTablaCalificacion($ordenCambio);
        $this-> contenidoTotal .="TIS después de revisar la propuesta de su empresa \\textbf{SoftVision}, tiene las siguientes observaciones:\n\n";
        $this->addListaObs($ordenCambio);
        $this-> contenidoTotal .= "Esta adenda de corrección debe ser entregada hasta el \\textbf{{$ordenCambio->fechaFirma} a horas 9:30} , en \\textbf{ {$ordenCambio->lugar}}.\n\n
Paralelamente se solicita, llenar la planilla adjunta - RESUMENGRUPOEMPRESA; con la información resumen de su propuesta técnica. En este archivo debe registrar el día que su GE ha elegido para el seguimiento de su propuesta de desarrollo en el tiempo que dure el contrato con TIS.\n\n
Asímismo, recordar que para el día de la firma del contrato se requiere la entrega de la planilla resumen requerida.\n";
        $this-> contenidoTotal .= "\\end{document}\n";
    }
    function addTablaCalificacion($ordenCambio){
        $ordenCambio_id = $ordenCambio->id;
        $camposEvaluables = CampoEvaluable::all();
        $this-> contenidoTotal .= "	\begin{table}[h]
		\begin{tabular}{|l|l|r|}
				\hline
                \\textbf{Descripcion}                                 & \\textbf{\begin{tabular}[c]{@{}l@{}}Puntaje \\\\ Referencial\\end{tabular}} & \multicolumn{1}{l|}{\\textbf{\begin{tabular}[c]{@{}l@{}}Puntaje \\\\ Obtenido\\end{tabular}}} \\\\ \hline\n";
        foreach ($camposEvaluables as $campoEval){
            $calificacion = Calificacion::where('campoEvaluable_id',$campoEval->id)->where('ordenDeCambio_id',$ordenCambio_id)->first();

            $this-> contenidoTotal .= "{$campoEval->descripcion} & {$campoEval->puntaje} puntos & {$calificacion->puntajeObtenido} \\\\ \hline\n";
        }

        $this-> contenidoTotal .= "\\end{tabular}\n
	\\end{table}\n";
    }
    function addListaObs($ordenCambio){

    }
}
