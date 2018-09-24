<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Elibyy\TCPDF\Facades\TCPDF;
use Modules\Asset\Models\Asset;
use App\Models\Institution;

class PDFController extends Controller
{
    public function create(Request $request)
    {
        $assets = Asset::nameclasification($request->type,$request->category,$request->subcategory,$request->specific_category)->get();
        $tot=0;
        $view = \View::make('asset::pdf.asset_detallado',compact('assets','tot'));
        $html = $view->render();
        
        $pdf = new TCPDF('L','mm','Letter', true, 'UTF-8', false);

        $pdf::Open();
        $pdf::AddPage();

        
        $this->Header2($pdf);

        $pdf::writeHTML($html, true, false, true, false, '');


        $pdf::Output('Prueba.pdf');
    }


    public function header(TCPDF $pdf){

        $pdf::SetAuthor('henryparedes');
        $pdf::SetTitle('Prueba');
        $pdf::Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);
        $pdf::SetFont('helvetica', '', 8);
    }


    public function Header2(TCPDF $pdf) {

        $pdf::SetAuthor('henryparedes');
        $pdf::SetTitle('Prueba');

        $Institution = Institution::all()->first();
        $ancho_pag=190; //260
        //Arial bold 8
        $pdf::SetFont('Courier','B',10);
        //Movernos a la derecha
        $pdf::Cell($ancho_pag,30,'',1);
        $enx=$pdf::GetX();
        $tam_linea=6;
        $pdf::Ln(1);
        //Logo
        $pdf::Image("../".$Institution->logo->url,12,12,26,26);

        $pdf::Cell(28,$tam_linea,'',0);
        $pdf::Cell($ancho_pag/2,$tam_linea,$Institution->name,0,1,'L');

        $pdf::SetFont('Courier','',8);
        $pdf::Cell(28,$tam_linea,'',0);
        $pdf::MultiCell($ancho_pag/2,3,$Institution->city_id,0,'L');
        
        if (isset($Institution->rif))
        {
            $pdf::SetFont('Courier','',8);
            $pdf::Cell(28,$tam_linea,'',0);
            $pdf::MultiCell($ancho_pag/2,3,"RIF ".$Institution->rif,0,'L');
        }
        
        $pdf::SetXY($enx,30);
        
        $pdf::SetFont('Courier','B',10);
        $pdf::Ln(10);
        $pdf::Cell($ancho_pag,$tam_linea,'Inventario de Bienes por Clasificación',1,1,'C');
        $pdf::SetFont('Courier','',6);
        $pdf::Cell($ancho_pag,$tam_linea,"Fecha: ".date('d/m/Y'),1,1,'R');

        $pdf::Ln(5);
  }


}
