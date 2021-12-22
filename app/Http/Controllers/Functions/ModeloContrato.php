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
        $cabecera =  "\documentclass[10pt,letterpaper]{article} \n\usepackage[utf8]{inputenc}\n\usepackage[left=3cm,right=2cm,top=2cm,bottom=2cm]{geometry}\n\usepackage[spanish]{babel}\n\usepackage{amsmath}\n\usepackage{amsfonts}\n\usepackage{amssymb}\n\usepackage{graphicx}\n\usepackage{multicol}\n\n";
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
denominara \\textbf{Iridium}, por otra parte, de conformidad a las clausulas que se detallan a continuacion:\n";
        $this->addPuntosContrato($contrato);
        $this-> contenidoTotal .= "\\end{document}\n";
    }

    function addPuntosContrato($notificacion)
    {
        $this-> contenidoTotal .="\\textbf{PRIMERA.-} TIS contratara los servicios del Contratista para la provision del Sistema de Apoyo a la Empresa
TIS, consultoria que se realizara, conforme a la modalidad y presupuesto entregado por la Consultora, en su
documento de propuesta tecnica, y normas estipuladas por TIS.\\\\
\\textbf{SEGUNDO.-} El objeto de este contrato es la provision de un producto software.\\\\
\\textbf{TERCERO.-} La consultora Iridium, se hace responsable por la buena ejecucion de las distintas fases, que
involucren su ingenieria del proyecto, especificadas en la propuesta tecnica corregida de acuerdo al pliego de
especificaciones.\\\\
\\textbf{CUARTO.-} Para cualquier otro punto no estipulado en el presente contrato, debe hacerse referencia a la
{CodigoConvo}, al Pliego de Especificaciones y/o al PG-TIS (Plan Global - TIS)\\\\
\\textbf{QUINTO.-} Se pone en evidencia que cualquier incumplimiento de las clausulas estipuladas en el presente
contrato, es pasible a la disolucion del mismo.\\\\
\\textbf{SEXTO.-} La consultora Iridium, declara su absoluta conformidad con los terminos del presente contrato.
Se deja constancia de que los datos y antecedentes personales juridicos proporcionados por el adjudicatario son
veridicos.\\\\
\\textbf{SEPTIMO.-} El presente contrato se disuelve tambien, por cualquier motivo de incumplimiento a normas establecidas en PG-TIS (Plan Global - TIS).\\\\
\\textbf{OCTAVO.-} Por la disolucion del contrato, TIS tiene todo el derecho de ejecutar la boleta de garantia, que es
entregada por el contratado como documento de seriedad de la empresa.\\\\
\\textbf{NOVENO.-} La informacion que TIS brinde al contratado debe ser de rigurosa confidencialidad, y no utilizarse
para otros fines que no sea el desarrollo del proyecto.\\\\
\\textbf{DECIMO.-} TIS representada por su directorio Lic. Corina Flores V., Lic. M. Leticia Blanco C., Lic. David
Escalera F. y Lic. Patricia Rodriguez y por otra la consultora Iridium, representada por su representante
legal Andy Marcelo Garcia Choque , dan su plena conformidad a los terminos y condiciones establecidos en el
presente Contrato de Prestacion de Servicios y Consultorıa, firmando en constancia al pie de presente documento.\\\\\n\n
\centering{Cochabamba, SEPTIEMBRE DEL 2021}
\\vfill
\begin{multicols}{2}\n

	\centering{Mgr. Leticia Blanco C.\\\\
	MIEMBRO DIRECTORIO CONSULTORA}

	\centering{	Andy Marcelo Garcia Choque\\\\
	CONSULTORA}

\\end{multicols}";

    }

}
