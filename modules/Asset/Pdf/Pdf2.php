<?php

namespace Modules\Asset\Pdf;

use App\Models\Institution;
use App\Models\Setting;

class Pdf2 extends \TCPDF
{
    public function header()
    {
        $Institution = Institution::all()->first();
        $Setting = Setting::all()->first();

        if ($this->CurOrientation =='P') {
            $ancho1=80;
            $ancho2=60;
        }
        $tamanho_letra=14;

        $this->SetAuthor($Institution->acronym);
        $this->SetTitle('Asiento Contable de Bienes');
        
        if (isset($Setting) and $Setting->report_banner == true) {
            $this->Image("../".$Institution->banner->url, 10, 8, 190);
            /** Logo */
            if (!is_null($Institution->logo)) {
                $this->Image("../".$Institution->logo->url, 10, 18, 26, 20);
            }

            /** Cabecera */
            if (isset($Institution->name)) {
                $this->Ln(5);
                $this->SetFont('Courier', 'B', 14);
                $this->Cell($ancho1);
              

                $this->Cell($ancho2, 6, "", 0, 1, 'C');
                $this->Cell($ancho1);
                $this->SetFont('Courier', 'B', $tamanho_letra);
                $this->Cell($ancho2, 6, "Titulo del Reporte", 0, 1, 'C');
                $this->Cell($ancho1);
                $this->SetFont('Courier', '', 8);

                $this->Cell($ancho1, 6, 'Fecha: '.date("d/m/Y"), 0, 1, 'R');
                $this->Ln(20);
            }
        } else {
            /** Logo */
            if (!is_null($Institution->logo)) {
                $this->Image("../".$Institution->logo->url, 10, 8, 26, 20);
            }
          

            if (isset($Institution->name)) {
                $this->SetFont('Courier', 'B', 14);
                $this->Cell($ancho1);
            

                $this->Cell($ancho2, 6, "", 0, 1, 'C');
                $this->Cell($ancho1);
                $this->SetFont('Courier', 'B', $tamanho_letra);
                $this->Cell($ancho2, 6, "Titulo del Reporte", 0, 1, 'C');
                $this->Cell($ancho1);
                $this->SetFont('Courier', '', 8);

                $this->Cell($ancho1, 6, 'Fecha: '.date("d/m/Y"), 0, 1, 'R');
                $this->Ln(20);
            } else {
                $this->Ln(20);
            }
        }
    }

    public function footer()
    {

        /** Posición: a 1,5 cm del final */
        $this->SetY(-15);

        $this->SetFont('Courier', 'I', 8);
        $this->Cell(0, 10, 'Pag. '.$this->getAliasNumPage()."/".$this->getAliasNbPages(), 0, 0, 'R');
    }

    public function setPositionY($y)
    {
        $this->SetY($y);
    }

    public function getPositionY()
    {
        return $this->GetY();
    }
    public function getCheckBreak()
    {
        return $this->PageBreakTrigger;
    }
}
