<?php

namespace App\Http\Controllers\Functions;

use App\Models\CalificacionNotificacionConformidad;
use App\Models\CampoEvaluable;
use App\Models\GrupoEmpresa;
use App\Models\NotificacionConf;
use App\Models\Postulacion;

class ModeloNotificacionDeConformidad
{
    public $contenidoTotal="";

    function crearNotificacion($id_NotificacionConformidad){
        $notificacion = NotificacionConf::find($id_NotificacionConformidad);
        $archivo = fopen("notificacionConformidad.tex", "w+b");
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

    function addAutor($notificacion){
        $autor =  "\\title{Notificacion de Conformidad}\n\author{{$notificacion->codigo}\\\\Leticia Blanco Coca}\n\date{{$notificacion->fechaEmDocumento}}\n\n";
        $this-> contenidoTotal .= $autor;
    }

    function addCuerpo($notificacion){
        $postu = Postulacion::find($notificacion->postulacion_id);
        $GE = GrupoEmpresa::find($postu->grupoEmpresa_id);
        $this-> contenidoTotal .= "\begin{document}\n\maketitle\n\n
TIS ha revisado la propuesta que su empresa ha entregado y se ha puntuado de la siguiente manera:\n\n";
        $this->addTablaCalificacion($notificacion);
        $this-> contenidoTotal .="TIS acepta la propuesta técnica presentada por su empresa: \\textbf{{$GE->nombre}}.";

        $this-> contenidoTotal .= " Por lo que solicita hacerse presente el \\textbf{{$notificacion->fechaFirma} a horas 9:30} a realizar firma de contrato,, en \\textbf{ {$notificacion->lugar}}.\n\n
Paralelamente se solicita, llenar la planilla adjunta - RESUMENGRUPOEMPRESA; con la información resumen de su propuesta técnica. En este archivo debe registrar el día que su GE ha elegido para el seguimiento de su propuesta de desarrollo en el tiempo que dure el contrato con TIS.\n\n
Asímismo, recordar que para el día de la firma del contrato se requiere la entrega de la planilla resumen requerida.\n";
        $this-> contenidoTotal .= "\\end{document}\n";
    }
    function addTablaCalificacion($notificacion){
        $notificacion_id = $notificacion->id;
        $camposEvaluables = CampoEvaluable::all();
        $this-> contenidoTotal .= "	\begin{table}[h]
		\begin{tabular}{|l|l|r|}
				\hline
                \\textbf{Descripcion}                                 & \\textbf{\begin{tabular}[c]{@{}l@{}}Puntaje \\\\ Referencial\\end{tabular}} & \multicolumn{1}{l|}{\\textbf{\begin{tabular}[c]{@{}l@{}}Puntaje \\\\ Obtenido\\end{tabular}}} \\\\ \hline\n";
        foreach ($camposEvaluables as $campoEval){
            $calificacion = CalificacionNotificacionConformidad::where('campoEvaluable_id',$campoEval->id)->where('notificacionConformidad_id',$notificacion_id)->first();

            $this-> contenidoTotal .= "{$campoEval->descripcion} & {$campoEval->puntaje} puntos & {$calificacion->puntajeObtenido} \\\\ \hline\n";
        }

        $this-> contenidoTotal .= "\\end{tabular}\n
	\\end{table}\n";
    }

}
