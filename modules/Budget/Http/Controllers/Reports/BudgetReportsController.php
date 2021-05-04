<?php

/** [descripción del namespace] */

namespace Modules\Budget\Http\Controllers\Reports;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Budget\Models\BudgetAccountOpen;
use Modules\Budget\Models\BudgetAccount;
use Modules\Budget\Models\BudgetSubSpecificFormulation;
use Modules\Budget\Models\Institution;
use App\Models\FiscalYear;
use Modules\Budget\Models\Currency;

use App\Repositories\ReportRepository;
use DateTime;

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

        $budgetItems = array_map(function ($budgetItem) {
            return (int)str_replace('.', '', $budgetItem->getCodeAttribute());
        }, $budgetItems);

        return view('budget::reports.budgetAvailability', ['budgetItems' => json_encode($budgetItems)]);
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
     * @return    Array Arreglo ordenado de cuentas presupuestarias formuladas
     */
    public function getBudgetAccountsOpen()
    {
        $budgetItems = BudgetAccountOpen::all()->all();

        usort($budgetItems, function ($budgetItemOne, $budgetItemTwo) {

            $codeOne = str_replace('.', '', $budgetItemOne->budgetAccount->getCodeAttribute());
            $codeTwo = str_replace('.', '', $budgetItemTwo->budgetAccount->getCodeAttribute());

            if ($codeOne > $codeTwo) return 1;

            else if ($codeOne == $codeTwo) return 0;

            else return -1;
        });

        return array_map(function ($budgetItem) {
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
        ]);

        $pdf = new ReportRepository();

        $records = $this->getBudgetAccountsOpen();

        $records = $this->filterBudgetAccounts($records, $data['initialCode'], $data['finalCode'], $data['initialDate'], $data['finalDate']);

        $institution = Institution::find(1);

        $fiscal_year = FiscalYear::where('active', true)->first();

        $currency = Currency::where('default', true)->first();

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
}
