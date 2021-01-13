<?php

/** Controladores para la visualización de herramientas para desarrolladores */
namespace App\Http\Controllers\Dev;

use Illuminate\Http\Request;
use Arcanedev\LogViewer\Http\Controllers\LogViewerController as ArcanedevLogViewerController;

/**
 * @class LogViewerController
 * @brief Controlador para la gestión de logs del sistema
 *
 * Clase que gestiona los logs del sistema
 */
class LogViewerController extends ArcanedevLogViewerController
{
    /**
     * Muestra el panel de control de logs del sistema.
     *
     * @method  index
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stats     = $this->logViewer->statsTable();
        $chartData = $this->prepareChartData($stats);
        $percents  = $this->calcPercentages($stats->footer(), $stats->header());
        $headers = $stats->header();
        $rows    = $this->paginate($stats->rows(), request());

        return $this->view('dashboard', compact('chartData', 'percents', 'headers', 'rows'));
    }
}
