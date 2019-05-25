<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Arcanedev\LogViewer\Http\Controllers\LogViewerController as ArcanedevLogViewerController;
use App\Http\Controllers\Controller;

class LogViewerController extends ArcanedevLogViewerController
{
    /**
     * Show the dashboard.
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
