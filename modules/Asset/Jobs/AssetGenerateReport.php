<?php

namespace Modules\Asset\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Modules\Asset\Pdf\AssetReport as ReportRepository;
use Modules\Asset\Models\AssetReport;
use Modules\Asset\Models\Asset;
use App\Models\Institution;
use App\Models\Parameter;
use Carbon\Carbon;

class AssetGenerateReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Objeto que contiene la información asociada a la solicitud
     *
     * @var Object $asset
     */
    protected $data;
    
    /**
     * Plantilla o texto a incluir en el cuerpo del reporte
     *
     * @var String $body
     */
    protected $body;

    /**
     * Título del reporte
     *
     * @var String $title
     */
    protected $title;

    /**
     * Subtítulo o descripción del reporte
     *
     * @var String $subtitle
     */
    protected $subtitle;

    /**
     * Operación a realizar al finalizar el trabajo
     *
     * @var String $operation
     */
    protected $operation;

    /**
     * Variable que contiene el tiempo de espera para la ejecución del trabajo,
     * si no se quiere limite de tiempo, se define en 0
     *
     * @var Integer $timeout
     */
    public $timeout = 0;

    /**
     * Crea una nueva instancia del trabajo
     *
     * @return void
     */
    public function __construct(AssetReport $data, String $body, String $title = null, String $subtitle = '')
    {
        $this->data     = $data;
        $this->body     = $body;
        $this->title    = $title ?? 'Reporte de Bienes';
        $this->subtitle = $subtitle;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->data->type_report == 'general') {
            $assets = Asset::dateclasification(
                $this->data->start_date,
                $this->data->end_date,
                $this->data->mes,
                $this->data->year
            )->get();
<<<<<<< HEAD
            $multi_inst =  Parameter::where('p_key', 'multi_institution')->where('active', true)->first();
            $institution = Institution::where('default', true)->where('active', true)->first();
            $pdf = new ReportRepository();

            /*
             *  Definicion de las caracteristicas generales de la página
             */
            $pdf->setConfig(
                [
                    'institution' => $institution,
                    'urlVerify' => 'www.google.com',
                    'orientation' => 'L',
                    'filename' => uniqid() . 'pdf'
                ]
            );

            $pdf->setHeader('Reporte de Bienes', 'Reporte de inventario general');
            $pdf->setFooter();
            $pdf->setBody('asset::pdf.asset_general', true, [
                'pdf' => $pdf,
                'assets' => $assets
            ]);
=======
>>>>>>> 1152a5f98efa304d3ccf5adf73e37335502686cf
        } elseif ($this->data->type_report == 'clasification') {
            if ($this->data->type_search != '') {
                $assets = Asset::dateclasification(
                    $this->data->start_date,
                    $this->data->end_date,
                    $this->data->mes_id,
                    $this->data->year_id
                )->get();
            } else {
                $assets = Asset::all();
            }
        }

        $multi_inst =  Parameter::where('p_key', 'multi_institution')
            ->where('active', true)->first();
        $institution = Institution::where('default', true)
            ->where('active', true)->first();
        $pdf = new ReportRepository();
        
        /*
         *  Definicion de las caracteristicas generales de la página
         */
        $pdf->setConfig(
            [
                'institution' => $institution,
                'urlVerify'   => 'www.google.com',
                'orientation' => 'L',
                'filename'    => 'asset-report-' . Carbon::now() . '.pdf'
            ]
        );

        $pdf->setHeader($this->title, $this->subtitle);
        $pdf->setFooter();
        $pdf->setBody(
            $this->body,
            true,
            [
                'pdf'    => $pdf,
                'assets' => $assets
            ]
        );
    }

    /**
     * Failed the job.
     *
     * @return void
     */
    public function failed()
    {
        $report = AssetReport::find($this->data->id);
        $report->delete();
    }
}
