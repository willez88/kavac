<?php

/** [descripción del namespace] */

namespace Modules\Budget\Http\Controllers\Reports;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Budget\Models\BudgetProject;
use Modules\Budget\Models\BudgetCentralizedAction;
use Modules\Budget\Models\BudgetAccountOpen;
use Modules\Budget\Models\BudgetAccount;
use Modules\Budget\Models\BudgetSubSpecificFormulation;
use Modules\Budget\Models\Institution;
use App\Models\FiscalYear;
use Modules\Budget\Models\Currency;

use App\Repositories\ReportRepository;

/**
 * @class BudgetAccountOpenController
 * @brief Clase para generar reporte de disponibilad presupuestaria
 *
 * Clase para generar reporte de disponibilad presupuestaria
 *
 * @author Jonathan Alvarado <wizardx1407@gmail.com> | <jonathanalvarado1407@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class BudgetReportsController extends Controller
{

    private $monthColumnNames = [
        'jan_amount',
        'feb_amount',
        'mar_amount',
        'apr_amount',
        'may_amount',
        'jun_amount',
        'jul_amount',
        'aug_amount',
        'sep_amount',
        'oct_amount',
        'nov_amount',
        'dec_amount'
    ];

    /**
     * Genera los datos necesarios para el formulario de generacion de reporte de disponibilidad presupuestaria
     *
     * @author    Jonathan Alvarado <wizardx1407@gmail.com> | <jonathanalvarado1407@gmail.com>
     *
     * @return    Renderable 
     */
    public function budgetAvailability()
    {

        $budgetItems = $this->getBudgetAccounts();

        /* $budgetItems = array_map(function ($budgetItem) {
            return array(
                'text' => $budgetItem->denomination,
                'id' => (int)str_replace('.', '', $budgetItem->getCodeAttribute())
            );
        }, $budgetItems); */

        $data = array();
        $temp = array('text' => '', 'children' => []);
        $isFirst = true;

        foreach ($budgetItems as $budgetItem) {

            $code = str_replace('.', '', $budgetItem->getCodeAttribute());

            if (substr_count($code, '0') == 8) {

                if (!$isFirst) {
                    array_push($data, $temp);
                    $temp = array('text' => '', 'children' => []);
                }

                $temp['text'] = $budgetItem->denomination;
                $isFirst = false;
            }

            array_push($temp['children'], array(
                'text' => $budgetItem->denomination . ' ' . "($code)",
                'id' => (int)$code
            ));
        }

        array_push($data, $temp);

        return view('budget::reports.budgetAvailability', ['budgetItems' => json_encode($data)]);
    }

    /**
     * Metodo para retornar un array con las cuentas presupuestarias
     *
     * @author    Jonathan Alvarado <wizardx1407@gmail.com> | <jonathanalvarado1407@gmail.com>
     *
     * @return    Array Arreglo ordenado de cuentas presupuestarias
     */
    public function getBudgetAccounts()
    {

        $budgetItems = BudgetAccount::all()->all();

        usort($budgetItems, function ($budgetItemOne, $budgetItemTwo) {

            $codeOne = str_replace('.', '', $budgetItemOne->getCodeAttribute());
            $codeTwo = str_replace('.', '', $budgetItemTwo->getCodeAttribute());

            if ($codeOne > $codeTwo) return 1;

            else if ($codeOne == $codeTwo) return 0;

            else return -1;
        });

        return $budgetItems;
    }


    /**
     * Metodo para retornar un array con las cuentas presupuestarias que han sido formuladas
     *
     * @author    Jonathan Alvarado <wizardx1407@gmail.com> | <jonathanalvarado1407@gmail.com>
     *
     * @param      bool accountsWithMovements
     * 
     * @return    Array Arreglo ordenado de cuentas presupuestarias formuladas
     */
    public function getBudgetAccountsOpen(bool $accountsWithMovements)
    {
        $budgetItems = BudgetAccountOpen::all()->all();

        usort($budgetItems, function ($budgetItemOne, $budgetItemTwo) {

            $codeOne = str_replace('.', '', $budgetItemOne->budgetAccount->getCodeAttribute());
            $codeTwo = str_replace('.', '', $budgetItemTwo->budgetAccount->getCodeAttribute());

            if ($codeOne > $codeTwo) return 1;

            else if ($codeOne == $codeTwo) return 0;

            else return -1;
        });

        $budgetItems = array_map(function ($budgetItem) {
            $subSpecificFormulation = BudgetSubSpecificFormulation::where('id', $budgetItem->budget_sub_specific_formulation_id)->first();

            $budgetItem['asigned_percentage'] = round(($budgetItem->total_year_amount * 100) / $subSpecificFormulation->total_formulated, 2);

            $currentMonth = date('n') - 1;
            $amountAvailable = 0;

            for ($i = $currentMonth; $i < 12; $i++) {
                $amountAvailable += $budgetItem[$this->monthColumnNames[$i]];
            }

            $budgetItem['amount_available'] = $amountAvailable;

            return $budgetItem;
        }, $budgetItems);

        return array_filter($budgetItems, function ($budgetItem) use ($accountsWithMovements) {

            if ($accountsWithMovements && $budgetItem['amount_available'] === $budgetItem['total_year_amount']) return false;

            return true;
        });
    }


    /**
     * Metodo para filtrar y retornar un array con las cuentas presupuestarias formuladas
     *
     * @author    Jonathan Alvarado <wizardx1407@gmail.com> | <jonathanalvarado1407@gmail.com>
     *
     * @return    Array Arreglo ordenado de cuentas presupuestarias formuladas
     */
    public function filterBudgetAccounts(array $budgetAccountsOpen, int $initialCode, int $finalCode, string $initialDate, string $finalDate)
    {

        $filteredArray = array();

        foreach ($budgetAccountsOpen as $budgetItem) {

            if ($budgetItem->code > $finalCode) break;

            $specificAction = BudgetSubSpecificFormulation::where('id', $budgetItem->budget_sub_specific_formulation_id)->first()->specificAction;

            $code = str_replace('.', '', $budgetItem->budgetAccount->getCodeAttribute());

            if ($code >= $initialCode && $code <= $finalCode && strtotime($specificAction->from_date) >= strtotime($initialDate) && strtotime($specificAction->to_date) <= strtotime($finalDate)) {
                $filteredArray[] = $budgetItem;
            }
        }

        return $filteredArray;
    }

    /**
     * Metodo para generar el reporte en PDF de disponibilad presupuestaria
     *
     * @author    Jonathan Alvarado <wizardx1407@gmail.com> | <jonathanalvarado1407@gmail.com>
     *
     */
    public function getPdf(Request $request)
    {
        $data = $request->validate([
            'initialDate' => 'required',
            'finalDate' => 'required',
            'initialCode' => 'required',
            'finalCode' => 'required',
            'accountsWithMovements' => 'required'
        ]);

        $pdf = new ReportRepository();

        $records = $this->getBudgetAccountsOpen($data['accountsWithMovements']);

        $records = $this->filterBudgetAccounts($records, $data['initialCode'], $data['finalCode'], $data['initialDate'], $data['finalDate']);

        $institution = Institution::find(1);

        $fiscal_year = FiscalYear::where('active', true)->first();

        $currency = Currency::where('default', true)->first();

        if (strtotime($data['initialDate']) > strtotime($data['finalDate'])) {
            $temp = $data['initialDate'];
            $data['initialDate'] = $data['finalDate'];
            $data['finalDate'] = $temp;
        }

        $pdf->setConfig(['institution' => $institution]);
        $pdf->setHeader('Reporte de Presupuesto', 'Presupuesto Formulado del ejercicio económico financiero vigente');
        $pdf->setFooter();
        $pdf->setBody('budget::pdf.budgetAvailability', true, [
            'pdf' => $pdf,
            'records' => $records,
            'institution' => $institution,
            'currencySymbol' => $currency['symbol'],
            'fiscal_year' => $fiscal_year['year'],
            'initialDate' => $data['initialDate'],
            'finalDate' => $data['finalDate'],
        ]);
    }

    public function getProjectsView()
    {
        return view('budget::reports.projects');
    }

    public function getProjectsReportData(Request $request)
    {
        try {
            $project_code = $request->input('project_code');
            $search = $request->input('search');

            $query = BudgetProject::query();

            if ($project_code) {
                $query->where("code", "LIKE", "%" . $project_code . "%");
            }

            if ($search) {
                $query->where("name", "LIKE", "%" . $search . "%");
            }

            $query = $query->get();

            $response = [
                'data' => $query,
                "message" => "Data para reporte de proyectos"
            ];
        } catch (\Exception $e) {
            $code = $e->getCode() ? (is_numeric($e->getCode()) ? $e->getCode() : 500) : 500;
            $msg = $e->getMessage() ?? "Error al obtener la data para el reporte de proyectos";
            $response = [
                "message" => $msg,
                "errors" => []
            ];
        }

        return response()->json($response, $code ?? 200);
    }

    public function getProjectsReportPdf(Request $request)
    {
        try {
            $project_code = $request->input('project_code');
            $search = $request->input('search');

            $query = BudgetProject::query();

            if ($project_code) {
                $query->where("code", "LIKE", "%" . $project_code . "%");
            }

            if ($search) {
                $query->where("name", "LIKE", "%" . $search . "%");
            }

            $query = $query->get();



            $pdf = new ReportRepository();
            $institution = Institution::find(1);

            $pdf->setConfig(['institution' => $institution]);
            $pdf->setHeader('Reporte de proyectos', 'Reporte de proyectos de la institucion');
            $pdf->setFooter();
            $pdf->setBody('budget::pdf.projects', true, [
                'pdf' => $pdf,
                'records' => $query,
            ]);
        } catch (\Exception $e) {
            $code = $e->getCode() ? (is_numeric($e->getCode()) ? $e->getCode() : 500) : 500;
            $msg = $e->getMessage() ?? "Error al obtener la data para el reporte de proyectos";
            $response = [
                "message" => $msg,
                "errors" => []
            ];


            return response()->json($response, $code ?? 200);
        }
    }

    public function getFormulatedView()
    {
        $formulations = BudgetSubSpecificFormulation::all(['year']);

        $years = [];

        foreach ($formulations as $formulation) {
            $years[] = $formulation->year;
        }

        $years = array_unique($years);

        return view('budget::reports.budgetFormulated', ['years' => json_encode($years)]);
    }

    public function getFormulations(Request $request)
    {
        $entity = $request->input('is_project')
            ? BudgetProject::class
            : BudgetCentralizedAction::class;

        $id = $request->input('id');

        $query = BudgetSubSpecificFormulation::query();

        $query = $query->whereHas('specificAction', function ($query) use ($entity, $id) {
            $query->whereHasMorph('specificable', [BudgetProject::class, BudgetCentralizedAction::class], function ($query) use ($entity, $id) {
                return $query->where('specificable_id', $id)
                    ->where('specificable_type', $entity);
            });
        });

        $query = $query->get();

        $formulations = $query->count() ? [['id' => '', 'text' => 'Seleccione']] : [];

        foreach ($query as $formulation) {
            $formulations[] = [
                'id' => $formulation->id,
                'text' => $formulation->code
            ];
        }

        return response()->json($formulations);
    }


    public function getFormulatedReportData(Request $request)
    {

        $formulation_id = $request->input('formulation_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = BudgetAccountOpen::where('budget_sub_specific_formulation_id', $formulation_id);

        if ($start_date) {
            $query->where('created_at', '>=', $start_date);
        }

        if ($end_date) {
            $query->where('created_at', '<=', $end_date);
        }

        $query = $query->get();

        $total = $query->sum('total_real_amount');

        foreach ($query as $account) {
            $account->code = $account->budgetAccount->getCodeAttribute();
            $account->percentage = round(($account->total_real_amount * 100) / $total);
            $account->total = $total;
        }

        return response()->json(['data' => $query]);
    }

    public function getFormulatedReportPdf(Request $request)
    {
        try {

            $formulation_id = $request->input('formulation_id');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            $query = BudgetAccountOpen::where('budget_sub_specific_formulation_id', $formulation_id);

            if ($start_date) {
                $query->where('created_at', '>=', $start_date);
            }

            if ($end_date) {
                $query->where('created_at', '<=', $end_date);
            }

            $query = $query->get();
            $total = $query->sum('total_real_amount');

            foreach ($query as $account) {
                $account->code = $account->budgetAccount->getCodeAttribute();
                $account->percentage = round(($account->total_real_amount * 100) / $total);
                $account->total = $total;
            }

            $pdf = new ReportRepository();

            $institution = Institution::find(1);

            $fiscal_year = FiscalYear::where('active', true)->first();

            $currency = Currency::where('default', true)->first();

            $pdf->setConfig(['institution' => $institution]);
            $pdf->setHeader('Reporte de Presupuesto', 'Presupuesto Formulado del ejercicio económico financiero vigente');
            $pdf->setFooter();
            $pdf->setBody('budget::pdf.formulations', true, [
                'pdf' => $pdf,
                'records' => $query,
                'institution' => $institution,
                'currencySymbol' => $currency['symbol'],
                'fiscal_year' => $fiscal_year['year'],
            ]);
        } catch (\Exception $e) {
            $code = $e->getCode() ? (is_numeric($e->getCode()) ? $e->getCode() : 500) : 500;
            $msg = $e->getMessage() ?? "Error al obtener la data para el reporte de formulationes";
            $response = [
                "message" => $msg,
                "errors" => []
            ];


            return response()->json($response, $code ?? 200);
        }
    }
}
