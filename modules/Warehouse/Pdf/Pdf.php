<?php

namespace Modules\Warehouse\Pdf;

use App\Models\Institution;
use App\Models\Setting;

class Pdf extends \TCPDF
{
    /* Atributo que define el tipo del reporte */
    public $type_report;
    public $title_report = '';

    public function header()
    {
        $Institution = Institution::all()->first();
        $Setting = Setting::all()->first();

        $this->SetAuthor($Institution->acronym);
        $this->SetTitle('Inventario de Bienes');
        if ($this->getTitleReport() != '') {
            $this->SetTitle($this->getTitleReport());
        }
        /**
         * Ancho de página
         * @var integer $ancho_pag
         */
        $ancho_pag=277;

        $enx=$this->GetX();
        $tam_linea=6;

        if (!is_null($Setting) and $Setting->report_banner == true) {
            $this->Image("../".$Institution->banner->url, 10, 8, 277);

            $this->Ln(10);
            /** Arial bold 8 */
            $this->SetFont('Courier', 'B', 10);
            /** Movernos a la derecha */
            $this->Cell($ancho_pag, 30, '', 1);
            /** Logo */
            if (!is_null($Institution->logo)) {
                $this->Image("../".$Institution->logo->url, 12, 22, 26, 26);
            }

            /** Cabecera */
            $this->Ln(1);
            if (isset($Institution->name)) {
                $this->SetFont('Courier', '', 6);
                $this->Cell(0, 6, 'Pag. '.$this->getAliasNumPage()."/".$this->getAliasNbPages(), 0, 1, 'R');
                $this->SetFont('Courier', 'B', 10);
                $this->Cell(30, $tam_linea, '', 0);
                $this->Cell($ancho_pag/2, $tam_linea, $Institution->name, 0, 1, 'L');

                $this->SetFont('Courier', '', 8);
                $this->Cell(28, $tam_linea, '', 0);
                $this->MultiCell($ancho_pag/2, 3, $Institution->legal_address, 0, 'L');

                if (!is_null($Institution->rif)) {
                    $this->SetFont('Courier', '', 8);
                    $this->Cell(28, $tam_linea, '', 0);
                    $this->MultiCell($ancho_pag/2, 3, "RIF ".$Institution->rif, 0, 'L');
                }
                if (!is_null($Institution->nit)) {
                    $this->SetFont('Courier', '', 8);
                    $this->Cell(28, $tam_linea, '', 0);
                    $this->MultiCell($ancho_pag/2, 3, "NIT: ", 0, 'L');
                }
            }
            $this->Ln(10);
        } else {
            /** Arial bold 8 */
            $this->SetFont('Courier', 'B', 10);
            /** Movernos a la derecha */
            $this->Cell($ancho_pag, 30, '', 1);
            /** Logo */
            if (!is_null($Institution->logo)) {
                $this->Image("../".$Institution->logo->url, 12, 12, 26, 26);
            }

            $this->SetFont('Courier', '', 6);
            $this->Cell(0, 6, 'Pag. '.$this->getAliasNumPage()."/".$this->getAliasNbPages(), 0, 1, 'R');
            $this->SetFont('Courier', 'B', 10);
            $this->Cell(30, $tam_linea, '', 0);
            $this->Cell($ancho_pag/2, $tam_linea, $Institution->name, 0, 1, 'L');

            $this->SetFont('Courier', '', 8);
            $this->Cell(28, $tam_linea, '', 0);
            $this->MultiCell($ancho_pag/2, 3, $Institution->legal_address, 0, 'L');

            if (!is_null($Institution->rif)) {
                $this->SetFont('Courier', '', 8);
                $this->Cell(28, $tam_linea, '', 0);
                $this->MultiCell($ancho_pag/2, 3, "RIF ".$Institution->rif, 0, 'L');
            }
            if (!is_null($Institution->nit)) {
                $this->SetFont('Courier', '', 8);
                $this->Cell(28, $tam_linea, '', 0);
                $this->MultiCell($ancho_pag/2, 3, "NIT: ", 0, 'L');
            }
            $this->Ln(11);
        }
        $this->SetFont('Courier', 'B', 10);
        if ($this->getType() == 1) {
            $this->Cell($ancho_pag, $tam_linea, 'Inventario de Bienes por Clasificación', 1, 1, 'C');
        } elseif ($this->getType() == 2) {
            $this->Cell($ancho_pag, $tam_linea, 'Inventario de Bienes General', 1, 1, 'C');
        } else {
            $this->Cell($ancho_pag, $tam_linea, $this->getTitleReport(), 1, 1, 'C');
        }

        $this->SetFont('Courier', '', 6);
        $this->Cell($ancho_pag, $tam_linea, "Fecha: ".date('d/m/Y'), 1, 1, 'R');
    }

    /** Page footer */
    public function footer()
    {
        $Institution = Institution::all()->first();
        if (is_null($Institution)) {
            exit;
        }
        /** Posición: a 1,5 cm del final */
        $this->SetY(-20);

        $ancho_etiqueta=20;
        $ancho_firma=70;
        $ancho_pag=277;
        $tam_linea=4;
        $this->SetFont('Courier', '', 6);

        $this->Cell($ancho_etiqueta, $tam_linea, '', 1, 0, 'R');
        $this->Cell($ancho_firma, $tam_linea, "PREPARACION", 1, 0, 'C');
        $this->Cell($ancho_firma, $tam_linea, "CONFORMACION", 1, 0, 'C');
        $this->Cell($ancho_firma, $tam_linea, "APROBACION", 1, 0, 'C');
        $this->Cell($ancho_pag-($ancho_etiqueta+3*$ancho_firma), $tam_linea, '', 'LRT', 1, 'C');
        $this->Cell($ancho_etiqueta, $tam_linea, 'Nombre', 1, 0, 'L');
        $this->Cell($ancho_firma, $tam_linea, 'KAVAC', 1, 0, 'C');
        $this->Cell($ancho_firma, $tam_linea, $Institution->acronym, 1, 0, 'C');

        $this->Cell($ancho_firma, $tam_linea, $Institution->acronym, 1, 0, 'C');
        $this->Cell($ancho_pag-($ancho_etiqueta+3*$ancho_firma), $tam_linea, '', 'LR', 1, 'C');
        $this->Cell($ancho_etiqueta, $tam_linea, 'Cargo', 1, 0, 'L');
        $this->Cell($ancho_firma, $tam_linea, 'Herramienta automatizada', 1, 0, 'C');

        $this->Cell($ancho_firma, $tam_linea, "rep_carg_conf", 1, 0, 'C');
        $this->Cell($ancho_firma, $tam_linea, "rep_carg_aprob", 1, 0, 'C');
        $this->Cell($ancho_pag-($ancho_etiqueta+3*$ancho_firma), $tam_linea, '', 'LR', 1, 'C');
        $this->Cell($ancho_etiqueta, $tam_linea, 'Firma', 1, 0, 'L');
        $this->Cell($ancho_firma, $tam_linea, '', 1, 0, 'C');
        $this->Cell($ancho_firma, $tam_linea, '', 1, 0, 'C');
        $this->Cell($ancho_firma, $tam_linea, '', 1, 0, 'C');
        $this->Cell($ancho_pag-($ancho_etiqueta+3*$ancho_firma), $tam_linea, '', 'LRB', 1, 'C');
    }

    public function setType($type)
    {
        $this->type_report=$type;
    }

    public function getType()
    {
        return $this->type_report;
    }
    public function setTitleReport($title)
    {
        $this->title_report=$title;
    }

    public function getTitleReport()
    {
        return $this->title_report;
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
