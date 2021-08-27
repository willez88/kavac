<?php

/** Repositorios del sistema */
namespace App\Repositories;

use App\Repositories\Contracts\ReportInterface;
use App\Models\Parameter;
use Carbon\Carbon;
use Elibyy\TCPDF\TCPDF as PDF;

/**
 * @class ReportRepository
 * @brief Gestiona los reportes de la aplicación
 *
 * Gestiona los reportes de la aplicación
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class ReportRepository implements ReportInterface
{
    /** @var string Establece la orientación de la página, los posibles valores son P o L */
    private $orientation;
    /** @var string Establece la unidad de medida a implementar en el reporte */
    private $units;
    /** @var string Establece el formato de la página (A4, Letter, ...) */
    private $format;
    /** @var string Establece el tipo de fuente a usar en el reporte */
    private $fontFamily;
    /** @var array Estilos a implementar en códigos QR a generar */
    private $qrCodeStyle;
    /** @var array Estilos a implementar en códigos de barras a generar */
    private $barCodeStyle;
    /** @var string Estilos para líneas de separación entre encabezado cuerpo y pie de página */
    private $lineStyle;
    /** @var string URL de verificación del reporte */
    private $urlVerify;
    /** @var string Fecha en la que se genera el reporte */
    private $reportDate;
    /** @var object Identificador de la organización que genera el reporte */
    private $institution;
    /** @var string Nombre del archivo a generar con el reporte */
    private $filename;
    /** @var string Título del reporte */
    private $title;
    /** @var string Asunto del reporte */
    private $subject;
    /** @var integer Establece el eje de las Y en donde comienza a mostrarse el encabezado del reporte */
    private $headerY;
    /** @var integer Establece el eje de las Y para el texto de subtítulo y fecha del reporte */
    private $headerTextY;
    /** @var object Crea y gestiona el objeto PDF */
    private $pdf;

    /**
     * Método constructor de la clase
     *
     * @method     __construct()
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        $this->pdf = new PDF(config('app.name'));
    }

    /**
     * Método que permite establecer la configuración general de los reportes
     *
     * @method     setConfig(array $params)
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      array    $params    Parámetros de configuración
     */
    public function setConfig($params = [])
    {
        $this->reportDate = \Carbon\Carbon::now();
        $this->orientation = $params['orientation'] ?? 'P';
        $this->units = $params['units'] ?? 'mm';
        $this->format = $params['format'] ?? 'LETTER';
        $this->fontFamily = $params['fontFamily'] ?? 'helvetica';
        $this->qrCodeStyle = $params['qrCodeStyle'] ?? [
            'border' => false,
            'padding' => 0,
            'fgcolor' => [0,0,0],
            'bgcolor' => false
        ];
        $this->barCodeStyle = $params['barCodeStyle'] ?? [
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => [0,0,0],
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        ];
        $this->lineStyle = $params['lineStyle'] ?? [
            'width' => 0.2,
            'cap' => 'butt',
            'join' => 'miter',
            'dash' => 0,
            'color' => [0, 0, 0]
        ];
        $this->urlVerify = $params['urlVerify'] ?? null;
        $this->institution = $params['institution'] ?? null;
        $this->headerY = (is_null($this->institution->banner)) ? 10 : 22;
        $this->headerTextY = ($this->headerY === 22) ? 30 : 22;
        $this->filename = $params['filename'] ?? uniqid() . 'pdf';
        $this->subject = '';
    }

    /**
     * Método que establece los datos a mostrar en el encabezado del reporte
     *
     * @method     setHeader(string $title, string $subTitle, boolean $hasQR, boolean $hasBarCode)
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      string           $title         Título del reporte
     * @param      string           $subTitle      Subtítulo o descripción del reporte
     * @param      boolean          $hasQR         Indica si el reporte dispone de un código QR de verificación
     * @param      boolean          $hasBarCode    Indica si el reporte dispone de un código de barras que identifica
     *                                             el serial del documento
     * @param      string           $logoAlign     Alineación del logo en el reporte. Los valores posibles son:
     *                                             (L)eft, (R)ight, (C)enter. Valor por defecto es vacio lo cual
     *                                             realiza la alineación en el centro
     */
    public function setHeader(
        $title = '',
        $subTitle = '',
        $hasQR = true,
        $hasBarCode = false,
        $logoAlign = '',
        $titleAlign = 'C'
    ) {
        $params = (object)[
            'institution' => $this->institution,
            'fontFamily' => $this->fontFamily,
            'barCodeStyle' => $this->barCodeStyle,
            'qrCodeStyle' => $this->qrCodeStyle,
            'lineStyle' => $this->lineStyle,
            'hasQR' => $hasQR,
            'urlVerify' => $this->urlVerify,
            'title' => $title,
            'titleAlign' => $titleAlign,
            'subTitle' => $subTitle,
            'reportDate' => $this->reportDate,
            'headerY' => $this->headerY,
            'logoAlign' => $logoAlign
        ];
        $this->title = $title ?? 'Reporte';
        $this->pdf->setHeaderCallback(function ($pdf) use ($params) {
            $parameter = Parameter::where(['p_key' => 'report_banner', 'p_value' => 'true'])->first();

            if (!is_null($params->institution->banner)) {
                /** Imagen del banner de la organización a implementar en el reporte */
                $pdf->Image(
                    storage_path('pictures') . '/' . $params->institution->banner->file,
                    10,
                    10,
                    '',
                    10,
                    '',
                    '',
                    'T',
                    false,
                    300,
                    'C',
                    false,
                    false,
                    0,
                    false,
                    false,
                    true
                );
            }
            if (!is_null($params->institution->logo)) {
                /** Imagen del logotipo de la organización a implementar en el reporte */
                $pdf->Image(
                    storage_path('pictures') . '/' . $params->institution->logo->file,
                    10,
                    $params->headerY,
                    25,
                    '',
                    '',
                    '',
                    'T',
                    false,
                    300,
                    $params->logoAlign,
                    false,
                    false,
                    0,
                    false,
                    false,
                    false
                );
            }
            if ($params->hasQR && !is_null($params->urlVerify)) {
                /** Código QR con enlace de verificación del reporte */
                $pdf->write2DBarcode(
                    $params->urlVerify,
                    'QRCODE,H',
                    190,
                    $params->headerY,
                    12,
                    12,
                    $params->qrCodeStyle,
                    'T'
                );
            }
            /** Configuración de la fuente para el título del reporte */
            $pdf->SetFont($params->fontFamily, 'B', 15);
            /** Título del reporte */
            $pdf->MultiCell(
                145,
                7,
                $params->title,
                0,
                $params->titleAlign,
                false,
                1,
                40,
                $params->headerY,
                true,
                0,
                false,
                true,
                0,
                'T',
                true
            );
            /** Configuración de la fuente para la breve descripción del reporte */
            $pdf->SetFont($params->fontFamily, 'B', 12);
            /** Descripción breve del reporte */
            $pdf->MultiCell(
                72,
                4,
                $params->subTitle,
                0,
                'L',
                false,
                1,
                40,
                $params->headerY + 8,
                true,
                1,
                false,
                true,
                0,
                'T',
                true
            );
            /** Fecha de emisión del reporte */
            $pdf->MultiCell(
                72,
                4,
                $params->reportDate,
                0,
                'R',
                false,
                1,
                113,
                $params->headerY + 8,
                true,
                1,
                false,
                true,
                0,
                'T',
                true
            );
            /** Línea de separación entre el encabezado del reporte y el cuerpo */
            $pdf->Line(7, $params->headerY + 15, 205, $params->headerY + 15, $params->lineStyle);

            /*$pdf->write1DBarcode(
                '123', 'C128', 80, 90, 60, 10, '', $barCodeStyle, 'N'
            );*/
            /*$pdf->write1DBarcode('1234567890', 'UPCA', 80, 90, 60, 10, '', $barCodeStyle, 'N');*/
            /*$pdf->write1DBarcode('1234567890', 'CODABAR', 80, 90, 60, 10, '', $barCodeStyle, 'N');*/
            /*$pdf->write1DBarcode('1234567890', 'CODE11', 80, 90, 60, 10, '', $barCodeStyle, 'N');*/
            //$pdf->Text(80, 85, 'PDF417 (ISO/IEC 15438:2006)');
            //
            //ESTE DE ACA ABAJO
            /*$pdf->write2DBarcode(
                'www.tcpdf.org', 'PDF417,4,6,1,99998,,filename.txt', 80, 90, 60, 15, $barCodeStyle, 'N'
            );
            $pdf->Text(80, 85, 'PDF417 (ISO/IEC 15438:2006)');*/
        });
    }

    /**
     * Método que permite agregar el contenido del reporte a generar
     *
     * @method     setBody(string $body, boolean $isHTML, array $htmlParams)
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      string         $body        Plantilla a utilizar para el reporte en caso de estar establecido
     *                                         como isHTML, en caso contrario será un texto a incluir en el cuerpo
     *                                         del reporte
     * @param      boolean        $isHTML      Establece si el cuerpo del reporte es una plantilla de blade a renderizar
     * @param      array          $htmlParams  Conjunto de parámetros requeridos por la plantilla de blade
     */
    public function setBody($body, $isHTML = true, $htmlParams = [])
    {
        /** @var string Contenido del reporte */
        $htmlContent = $body;
        /** Configuración sobre el autor del reporte */
        $this->pdf->SetAuthor(__('Sistema de Gestión de Recursos - :app', ['app' => config('app.name')]));
        /** Configuración del título de reporte */
        $this->pdf->SetTitle($this->title);
        /** Configuración sobre el asunto del reporte */
        $this->pdf->SetSubject($this->subject);
        /** Configuración de los márgenes del cuerpo del reporte */
        $this->pdf->SetMargins(7, 45, 7);
        /** Establece si se configura o no las fuentes para sub configuraciones */
        $this->pdf->SetFontSubsetting(false);
        /** Configuración de la fuente por defecto del cuerpo del reporte */
        $this->pdf->SetFontSize('10px');
        /**
         * Configuración que permite realizar un salto de página automático al alcanzar el límite inferior del cuerpo
         * del reporte
         */
        $this->pdf->SetAutoPageBreak(true, 15); //PDF_MARGIN_BOTTOM
        /** Agrega las respectivas páginas del reporte */
        $this->pdf->AddPage($this->orientation, $this->format);

        if ($isHTML) {
            $view = \View::make($body, $htmlParams);
            $htmlContent = $view->render();
        }
        /** Escribre el contenido del reporte */
        $this->pdf->writeHTML($htmlContent, true, false, true, false, '');
        /** Establece el apuntador del reporte a la última página generada */
        $this->pdf->lastPage();
        /**
         * Genera el reporte. Las opciones disponibles son:
         *
         * I: Genera el archivo directamente para ser visualizado en el navegador
         * D: Genera el archivo y forza la descarga del mismo
         * F: Guarda el archivo generado en la ruta del servidor establecida por defecto
         * S: Devuelve el documento generado como una cadena de texto
         * FI: Es equivalente a las opciones F + I
         * FD: Es equivalente a las opciones F + D
         * E: Devuelve el documento del tipo mime base64 para ser adjuntado en correos electrónicos
         */
        $this->pdf->Output($this->filename, 'I');
    }

    public function setBodySign($body, $isHTML = true, $htmlParams = [])
    {
        /** @var string Contenido del reporte */
        $htmlContent = $body;
        /** Configuración sobre el autor del reporte */
        $this->pdf->SetAuthor(__('Sistema de Gestión de Recursos - :app', ['app' => config('app.name')]));
        /** Configuración del título de reporte */
        $this->pdf->SetTitle($this->title);
        /** Configuración sobre el asunto del reporte */
        $this->pdf->SetSubject($this->subject);
        /** Configuración de los márgenes del cuerpo del reporte */
        $this->pdf->SetMargins(7, 45, 7);
        /** Establece si se configura o no las fuentes para sub configuraciones */
        $this->pdf->SetFontSubsetting(false);
        /** Configuración de la fuente por defecto del cuerpo del reporte */
        $this->pdf->SetFontSize('10px');
        /**
         * Configuración que permite realizar un salto de página automático al alcanzar el límite inferior del cuerpo
         * del reporte
         */
        $this->pdf->SetAutoPageBreak(true, 15); //PDF_MARGIN_BOTTOM
        /** Agrega las respectivas páginas del reporte */
        $this->pdf->AddPage($this->orientation, $this->format);

        if ($isHTML) {
            $view = \View::make($body, $htmlParams);
            $htmlContent = $view->render();
        }
        /** Escribre el contenido del reporte */
        $this->pdf->writeHTML($htmlContent, true, false, true, false, '');
        /** Establece el apuntador del reporte a la última página generada */
        $this->pdf->lastPage();
        /**
         * Genera el reporte. Las opciones disponibles son:
         *
         * I: Genera el archivo directamente para ser visualizado en el navegador
         * D: Genera el archivo y forza la descarga del mismo
         * F: Guarda el archivo generado en la ruta del servidor establecida por defecto
         * S: Devuelve el documento generado como una cadena de texto
         * FI: Es equivalente a las opciones F + I
         * FD: Es equivalente a las opciones F + D
         * E: Devuelve el documento del tipo mime base64 para ser adjuntado en correos electrónicos
         */
        // $this->pdf->Output($this->filename, 'F');
        $isEnableSign = isModuleEnabled('DigitalSignature');
        if ($isEnableSign) {
            error_log("El módulo está activado " . $isEnableSign);
            $this->pdf->Output(storage_path() . '/reports/' . $this->filename, 'F');
            return true;
        } else {
            error_log("El módulo está desactivado " . $isEnableSign);
            return false;
        }
    }

    public function setFooter($pages = true, $footerText = '')
    {
        $fontFamily = $this->fontFamily;
        $lineStyle = $this->lineStyle;
        if (empty($footerText)) {
            $footerText = $this->institution->legal_address;
        }

        $this->pdf->setFooterCallback(function ($pdf) use ($pages, $fontFamily, $footerText, $lineStyle) {
            /** Posición a 14 mm del borde inferior de la página*/
            $pdf->SetY(-14);
            /** Configuración de la fuenta a utilizar */
            $pdf->SetFont($fontFamily, 'I', 8);
            if ($pages) {
                /** @var string Número de página del reporte */
                $pageNumber = __('Pág. ').$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages();
                /** Texto a mostrar para el número de página */
                $pdf->MultiCell(20, 4, $pageNumber, 0, 'R', false, 0, 185, -8, true, 1, false, true, 1, 'T', true);
            }
            /** Texto a mostrar en el pie de página del reporte */
            $pdf->MultiCell(
                198,
                8,
                $footerText,
                0,
                'C',
                false,
                0,
                7,
                -12,
                true,
                1,
                true,
                true,
                0,
                'T',
                true
            );
            /** Línea de separación entre el cuerpo del reporte y el pie de página */
            $pdf->Line(7, 265, 205, 265, $lineStyle);
        });
    }

    /**
     * Descarga un reporte
     *
     * @method    show
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     string|null    $file    Nombre del archivo a descargar. Este dato es opcional, si no se indica se
     *                                    genera un archivo con la fecha actual del servidor como nombre
     *
     * @return    Response
     */
    public function show($file = null)
    {
        $filename = storage_path() . '/reports/' . $file ?? 'report' . Carbon::now() . '.pdf';
        $this->pdf->Output($filename, 'F');
        return response()->download($filename);
    }
}
