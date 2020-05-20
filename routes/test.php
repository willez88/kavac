<?php
/*
|--------------------------------------------------------------------------
| Test Routes
|--------------------------------------------------------------------------
|
| Here is where you can register test routes only for development tests. These
| routes are loaded by the RouteServiceProvider if config app is in debug mode
| within a group which contains the "web" middleware group.
|
*/

Route::get('test', function () {
    /** @var string Familia de fuente a utilizar en el reporte */
    $fontFamily = 'helvetica';
    /** @var string Ruta en donde se encuentra ubicada la imagen del logotipo institucional */
    $imageFile = K_PATH_IMAGES."/logo.png";
    /** @var string Ruta en donde se encuentra el cintillo o banner institucional */
    $bannerFile = K_PATH_IMAGES."/cintillo.png";
    /** @var array Estilos a implementar en el código QR a generar */
    $qrCodeStyle = [
        'border' => false,
        'padding' => 0,
        'fgcolor' => [0,0,0],
        'bgcolor' => false
    ];
    $barCodeStyle = [
        'border' => 0,
        'vpadding' => 'auto',
        'hpadding' => 'auto',
        'fgcolor' => [0,0,0],
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
    ];

    /** @var string Ruta de verificación del reporte mediante el código QR */
    $urlVerifyReport = 'www.tcpdf.org';
    /** @var string Título a mostrar en el reporte */
    $reportTitle = 'Título del Reporte';
    /** @var string Descripción o subtítulo del reporte */
    $reportDescription = 'Descripción breve del reporte';
    /** @var array Estilos a implementar en las líneas de separación entre las secciones del reporte */
    $lineStyle = ['width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => [0, 0, 0]];

    /** Configuración del encabezado del reporte */
    PDF::setHeaderCallback(function ($pdf) use (
        $fontFamily,
        $imageFile,
        $bannerFile,
        $barCodeStyle,
        $qrCodeStyle,
        $urlVerifyReport,
        $reportTitle,
        $reportDescription,
        $lineStyle
    ) {
        /** Imagen del banner institucional a implementar en el reporte */
        $pdf->Image($bannerFile, 10, 10, '', 10, '', '', 'T', false, 300, 'C', false, false, 0, false, false, true);
        /** Imagen del logotipo institucional a implementar en el reporte */
        $pdf->Image($imageFile, 10, 20, 25, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
        /** Configuración de la fuente para el título del reporte */
        $pdf->SetFont($fontFamily, 'B', 15);
        /** Título del reporte */
        $pdf->MultiCell(145, 7, $reportTitle, 0, 'C', false, 1, 40, 22, true, 0, false, true, 0, 'T', true);
        /** Código QR con enlace de verificación del reporte */
        $pdf->write2DBarcode($urlVerifyReport, 'QRCODE,H', 190, 22, 12, 12, $qrCodeStyle, 'T');
        /** Configuración de la fuente para la breve descripción del reporte */
        $pdf->SetFont($fontFamily, 'B', 12);
        /** Descripción breve del reporte */
        $pdf->MultiCell(72, 4, $reportDescription, 0, 'L', false, 1, 40, 30, true, 1, false, true, 0, 'T', true);
        /** Fecha de emisión del reporte */
        $pdf->MultiCell(72, 4, \Carbon\Carbon::now(), 0, 'R', false, 1, 113, 30, true, 1, false, true, 0, 'T', true);
        /** Línea de separación entre el encabezado del reporte y el cuerpo */
        $pdf->Line(7, 35, 205, 35, $lineStyle);

        /*$pdf->write1DBarcode(
        '$2y$10$syg39jYYUGB/PDi/i9MI5u53FMza75uWPaBmU8XtYrBgWuloA8Xva', 'C128', 80, 90, 60, 10, '', $barCodeStyle, 'N'
        );*/
        /*$pdf->write1DBarcode('1234567890', 'UPCA', 80, 90, 60, 10, '', $barCodeStyle, 'N');*/
        /*$pdf->write1DBarcode('1234567890', 'CODABAR', 80, 90, 60, 10, '', $barCodeStyle, 'N');*/
        /*$pdf->write1DBarcode('1234567890', 'CODE11', 80, 90, 60, 10, '', $barCodeStyle, 'N');*/
        //$pdf->Text(80, 85, 'PDF417 (ISO/IEC 15438:2006)');
        //
        //ESTE DE ACA ABAJO
        /*$pdf->write2DBarcode('www.tcpdf.org', 'PDF417,4,6,1,99998,,filename.txt', 80, 90, 60, 15, $barCodeStyle, 'N');
        $pdf->Text(80, 85, 'PDF417 (ISO/IEC 15438:2006)');*/
    });

    /** @var string Dirección o texto a mostrar en el pie de página del reporte */
    $footerText = 'Dirección o texto a mostrar';
    PDF::setFooterCallback(function ($pdf) use ($fontFamily, $footerText, $lineStyle) {
        /** @var Número de página del reporte [description] */
        $pageNumber = 'Pág. '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages();
        /** Posición a 14 mm del borde inferior de la página*/
        $pdf->SetY(-14);
        /** Configuración de la fuenta a utilizar */
        $pdf->SetFont($fontFamily, 'I', 8);
        /** Texto a mostrar en el pie de página del reporte */
        $pdf->MultiCell(198, 8, $footerText, 0, 'C', false, 1, 7, -12, true, 1, false, true, 0, 'T', true);
        /** Texto a mostrar para el número de página */
        $pdf->MultiCell(20, 4, $pageNumber, 0, 'R', false, 1, 185, -8, true, 1, false, true, 1, 'T', true);
        /** Línea de separación entre el cuerpo del reporte y el pie de página */
        $pdf->Line(7, 265, 205, 265, $lineStyle);
    });

    /** @var string Nombre del archivo bajo el cual se va a generar el reporte */
    $filename = 'my_file';
    /** @var string Datos a mostrar en el cuerpo del reporte */
    $html = 'texto a mostrar';
    /** Configuración sobre el autor del reporte */
    PDF::SetAuthor('Sistema de Gestión de Recursos - ' . config('app.name'));
    /** Configuración del título de reporte */
    PDF::SetTitle($reportTitle);
    /** Configuración sobre el asunto del reporte */
    PDF::SetSubject('Reporte del módulo de ...');
    /** Configuración de los márgenes del cuerpo del reporte */
    PDF::SetMargins(7, 40, 7);
    /** Establece si se configura o no las fuentes para sub configuraciones */
    PDF::SetFontSubsetting(false);
    /** Configuración de la fuente por defecto del cuerpo del reporte */
    PDF::SetFontSize('10px');
    /**
     * Configuración que permite realizar un salto de página automático al alcanzar el límite inferior del cuerpo
     * del reporte
     */
    PDF::SetAutoPageBreak(true, 15); //PDF_MARGIN_BOTTOM
    /** Agrega las respectivas páginas del reporte */
    PDF::AddPage('P', 'LETTER');
    /** Escribre el contenido del reporte */
    PDF::writeHTML($html, true, false, true, false, '');
    /** Establece el apuntador del reporte a la última página generada */
    PDF::lastPage();
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
    PDF::Output($filename . '.pdf', 'I');
});


Route::get('mail', function () {
    $user = App\User::find(1);

    return (new App\Notifications\UserRegistered($user, '123456'))
                ->toMail($user);
});

Route::get('test-notify', function () {
    $user = User::find(1);
    $user->notify(new SystemNotification('prueba', 'prueba de notificación'));
    echo "Notificación enviada";
});

Route::get('clear-database', function () {
    \Modules\Accounting\Models\AccountingAccount::where('subspecific', '<>', '00')->delete();
    \Modules\Budget\Models\BudgetAccount::where('subspecific', '<>', '00')->delete();
    \Modules\Asset\Models\AssetSpecificCategory::where('code', '<>', '08')->delete();
    \Modules\Purchase\Models\PurchaseSupplierSpecialty::where(
        'name',
        '<>',
        'Mobiliario de equipos de oficina'
    )->delete();

    return redirect()->route('index');
});
