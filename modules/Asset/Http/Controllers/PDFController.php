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
    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.report.print', ['only' => 'create']);
    }

    public function create(Request $request)
    {
        $assets = Asset::codeclasification($request->type,$request->category,$request->subcategory,$request->specific_category)->get();
        $view = \View::make('asset::pdf.asset_detallado',compact('assets'));
        $html = $view->render();
        
        $pdf = new TCPDF('L','mm','Letter', true, 'UTF-8', false);

        $pdf::Open();
        $pdf::AddPage("L");
        $pdf::SetAutoPageBreak(TRUE, 0); 

        
        $this->Header_detallado($pdf);
        

        $pdf::writeHTML($html, true, false, true, false, '');
        
        $this->Footer($pdf);
        $pdf::Output("ReporteBienes_".date("d-m-Y").".pdf");
    }

    public function create_general(Request $request)
    {
        $assets = Asset::dateclasification($request->start_date,$request->end_date)->get();
        $view = \View::make('asset::pdf.asset_general',compact('assets'));
        $html = $view->render();
                
        $pdf = new TCPDF('L','mm','Letter', true, 'UTF-8', false);

        $pdf::Open();
        $pdf::AddPage("L");
        $pdf::SetAutoPageBreak(TRUE, 0); 

        
        $this->Header_general($pdf);
        $pdf::writeHTML($html, true, false, true, false, '');

        $this->Footer($pdf);
        $pdf::Output("ReporteGeneralBienes_".date("d-m-Y").".pdf");
    }


    /**
     * Header para Reporte de Bienes General
     *
     */
    public function Header_general(TCPDF $pdf) {
        
        $Institution = Institution::all()->first();
        $pdf::SetAuthor($Institution->acronym);
        $pdf::SetTitle('Inventario de Bienes');

        $ancho_pag=277;
        //Arial bold 8
        $pdf::SetFont('Courier','B',10);
        //Movernos a la derecha
        $pdf::Cell($ancho_pag,30,'',1);
        $enx=$pdf::GetX();
        $tam_linea=6;
        $pdf::Ln(1);


        //Logo
        
        if (!is_null($Institution->logo)){
            $pdf::Image("../".$Institution->logo->url,12,12,26,26);
        }


        $pdf::Cell(28,$tam_linea,'',0);
        $pdf::Cell($ancho_pag/2,$tam_linea,$Institution->name,0,1,'L');

        $pdf::SetFont('Courier','',6);
        $pdf::Cell(0,6,'Pag. '.$pdf::getAliasNumPage()."/".$pdf::getAliasNbPages(),0,1,'R');

        $pdf::SetFont('Courier','',8);
        $pdf::Cell(28,$tam_linea,'',0);
        $pdf::MultiCell($ancho_pag/2,3,$Institution->legal_address,0,'L');
        
        
        $pdf::SetFont('Courier','',8);
        $pdf::Cell(28,$tam_linea,'',0);
        $pdf::MultiCell($ancho_pag/2,3,"RIF ".$Institution->rif,0,'L');


        $pdf::SetFont('Courier','',8);
        $pdf::Cell(28,$tam_linea,'',0);
        $pdf::MultiCell($ancho_pag/2,3,"NIT: ",0,'L');
        
        $pdf::SetXY($enx,30);
        
        $pdf::SetFont('Courier','B',10);
        $pdf::Ln(10);
        $pdf::Cell($ancho_pag,$tam_linea,'Inventario de Bienes General',1,1,'C');
        $pdf::SetFont('Courier','',6);
        $pdf::Cell($ancho_pag,$tam_linea,"Fecha: ".date('d/m/Y'),1,1,'R');

        $pdf::Ln(1);

        $pdf::SetFont('Courier','B',8);
    
        $ancho_colcod=76;
        $ancho_colinv=30;
        $ancho_colmonto=27;
        $posx_ini=$pdf::GetX();
        $posy_ini=$pdf::GetY();
        $pdf::Cell($ancho_colcod,$tam_linea,"Clasificación",1,0,'C');
        $posy=$pdf::GetY();
        $posx=$pdf::GetX();
        
        $pdf::SetXY($posx_ini,$posy_ini+$tam_linea);
        $pdf::Cell($ancho_colcod/7,$tam_linea,'Tipo',1,0,'C');
        $pdf::Cell(2*$ancho_colcod/7,$tam_linea,'Categoria',1,0,'C');
        $pdf::Cell(2*$ancho_colcod/7,$tam_linea,"SubCategoria",1,0,'C');
        $pdf::Cell(2*$ancho_colcod/7,$tam_linea,"Cat. Especif.",1,0,'C');
        $pdf::SetXY($posx,$posy);
        $pdf::Cell($ancho_colinv,2*$tam_linea,"N° identificación",1,0,'C');  
        $pdf::Cell($ancho_pag-$ancho_colcod-$ancho_colinv-$ancho_colmonto,2*$tam_linea,"Nombre y descripción del bien",1,0,'C');
        $pdf::Cell($ancho_colmonto,2*$tam_linea,'Valor unitario',1,1,'C');
        
        if ($pdf::getAliasNumPage()>1) {
          $pdf::SetFont('Courier','B');
          $pdf::Cell($ancho_pag-$ancho_colmonto,$tam_linea,'Vienen ',1,0,'R');
          $pdf::Cell($ancho_colmonto,$tam_linea,'',1,1,'R');

        }
        $pdf::SetFont('Courier');
    }

    /**
     * Header para Reporte de Bienes por Clasificación
     *
     */
    public function Header_detallado(TCPDF $pdf) {
        $Institution = Institution::all()->first();

        
        $pdf::SetAuthor($Institution->acronym);
        $pdf::SetTitle('Inventario de Bienes');

        $ancho_pag=277; //260
        //Arial bold 8
        $pdf::SetFont('Courier','B',10);
        //Movernos a la derecha
        $pdf::Cell($ancho_pag,30,'',1);
        $enx=$pdf::GetX();
        $tam_linea=6;
        $pdf::Ln(1);
        //Logo
        if (!is_null($Institution->logo)){
            $pdf::Image("../".$Institution->logo->url,12,12,26,26);
        }

        $pdf::SetFont('Courier','',6);
        $pdf::Cell(0,6,'Pag. '.$pdf::getAliasNumPage()."/".$pdf::getAliasNbPages(),0,1,'R');
        $pdf::SetFont('Courier','B',10);
        $pdf::Cell(28,$tam_linea,'',0);
        $pdf::Cell($ancho_pag/2,$tam_linea,$Institution->name,0,1,'L');

        $pdf::SetFont('Courier','',8);
        $pdf::Cell(28,$tam_linea,'',0);
        $pdf::MultiCell($ancho_pag/2,3,$Institution->legal_address,0,'L');
        
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

        $pdf::Ln(1);


    }

    public function Footer(TCPDF $pdf){

        $Institution = Institution::all()->first();
            if (is_null($Institution)){
                exit;
            }
        //Posici&oacute;n: a 1,5 cm del final
        $pdf::SetY(-20);
        
        $ancho_etiqueta=20;
        $ancho_firma=70;
        $ancho_pag=277;
        $tam_linea=4;
        $pdf::SetFont('Courier','',6);

        $pdf::Cell($ancho_etiqueta,$tam_linea,'',1,0,'R');
        $pdf::Cell($ancho_firma,$tam_linea,"PREPARACION",1,0,'C');
        $pdf::Cell($ancho_firma,$tam_linea,"CONFORMACION",1,0,'C');
        $pdf::Cell($ancho_firma,$tam_linea,"APROBACION",1,0,'C');
        $pdf::Cell($ancho_pag-($ancho_etiqueta+3*$ancho_firma),$tam_linea,'','LRT',1,'C');
        $pdf::Cell($ancho_etiqueta,$tam_linea,'Nombre',1,0,'L');
        $pdf::Cell($ancho_firma,$tam_linea,'SAID',1,0,'C');
        $pdf::Cell($ancho_firma,$tam_linea,$Institution->name,1,0,'C');
        
        $pdf::Cell($ancho_firma,$tam_linea,$Institution->name,1,0,'C');
        $pdf::Cell($ancho_pag-($ancho_etiqueta+3*$ancho_firma),$tam_linea,'','LR',1,'C');
        $pdf::Cell($ancho_etiqueta,$tam_linea,'Cargo',1,0,'L');
        $pdf::Cell($ancho_firma,$tam_linea,'Herramienta automatizada',1,0,'C');
        
        $pdf::Cell($ancho_firma,$tam_linea,"rep_carg_conf",1,0,'C');
        $pdf::Cell($ancho_firma,$tam_linea,"rep_carg_aprob",1,0,'C');
        $pdf::Cell($ancho_pag-($ancho_etiqueta+3*$ancho_firma),$tam_linea,'','LR',1,'C');
        $pdf::Cell($ancho_etiqueta,$tam_linea,'Firma',1,0,'L');
        $pdf::Cell($ancho_firma,$tam_linea,'',1,0,'C');
        $pdf::Cell($ancho_firma,$tam_linea,'',1,0,'C');
        $pdf::Cell($ancho_firma,$tam_linea,'',1,0,'C');
        $pdf::Cell($ancho_pag-($ancho_etiqueta+3*$ancho_firma),$tam_linea,'','LRB',1,'C');
  }

}
