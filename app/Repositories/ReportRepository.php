<?php

namespace App\Repositories;

use App\Repositories\Contracts\ReportInterface;
use Carbon\Carbon;
use TCPDF;

class ReportRepository extends TCPDF implements ReportInterface
{
    /** @var string Establece la orientación de la página, los posibles valores son P o L */
    //private $orientation;
    /** @var string Establece la unidad de medida a implementar en el reporte */
    //private $units;
    /** @var string Establece el formato de la página (A4, Letter, ...) */
    //private $format;
    /** @var boolean Establece si se el reporte contiene carácteres unicode */
    //private $unicode;
    /** @var string Define el encoding a utilizar en el reporte */
    //protected $encoding;

    private $pdf;

    /*public function __construct(
        $orientation = 'P',
        $units = 'mm',
        $format = 'Letter',
        $unicode = true,
        $encoding = 'UTF-8'
    ) {
        $this->orientation = $orientation;
        $this->units = $units;
        $this->format = $format;
        $this->unicode = $unicode;
        $this->encoding = $encoding;

        $this->pdf = new TCPDF();
    }*/

    public function setHeader($title = null)
    {
        $this->pdf->SetTitle($title ?? '');
    }

    public function setBody($body)
    {
        $this->pdf->AddPage();
        $this->pdf->writeHTML($body, true, false, true, false, '');
    }

    public function setFooter($pages = false)
    {
        //
    }

    public function show($file = null)
    {
        $filename = storage_path() . '/reports/' . $file ?? 'report' . Carbon::now() . '.pdf';
        $this->pdf->Output($filename, 'F');
        return Response::download($filename);
    }
}
