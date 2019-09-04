<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Routing\Controller;
use Module;

/**
 * @class WarehouseServiceController
 * @brief Controlador de Servicios del Módulo de Almacén
 *
 * Clase que gestiona los registros utilizados en los elemnetos del tipo select2
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseServiceController extends Controller
{
    public function getPayrollStaffs()
    {
        return (Module::has('Payroll'))?
            template_choices('Modules\Payroll\Models\PayrollStaff', ['id_number', '-', 'full_name'], '', true) : [];
    }
    
    public function getPayrollPositions()
    {
        return (Module::has('Payroll'))?
            template_choices('Modules\Payroll\Models\PayrollPosition', 'name', '', true) : [];
    }

    public function getBudgetProjects($id = null)
    {
        return (Module::has('Budget'))?
            template_choices(
                'Modules\Budget\Models\BudgetProject',
                ['code', '-', 'name'],
                ($id) ? ['id' => $id] : [],
                true
            ) : [];
    }
    public function getBudgetCentralizedActions($id = null)
    {
        return (Module::has('Budget'))?
            template_choices(
                'Modules\Budget\Models\BudgetCentralizedAction',
                ['code', '-', 'name'],
                ($id) ? ['id' => $id] : [],
                true
            ) : [];
    }
    public function getBudgetSpecificActions($type, $id, $source = null)
    {
        if (Module::has('Budget')) {
            /** @var array Arreglo con información de las acciones específicas */
            $data = [['id' => '', 'text' => 'Seleccione...']];

            if ($type==="Project") {
                /** @var object Objeto con las acciones específicas asociadas a un proyecto */
                $specificActions = \Modules\Budget\Models\BudgetProject::find($id)->specificActions()->get();
            } elseif ($type == "CentralizedAction") {
                /** @var object Objeto con las acciones específicas asociadas a una acción centralizada */
                $specificActions = \Modules\Budget\Models\BudgetCentralizedAction::find($id)->specificActions()->get();
            }

            foreach ($specificActions as $specificAction) {
                /** @var object Objeto que determina si la acción específica ya fue formulada
                 * para el último presupuesto
                 */
                $existsFormulation = \Modules\Budget\Models\BudgetSubSpecificFormulation::where([
                    'budget_specific_action_id' => $specificAction->id
                ])->orderBy('year', 'desc')->first();

                if (!$existsFormulation) {
                    array_push($data, [
                        'id' => $specificAction->id,
                        'text' => $specificAction->code . " - " . $specificAction->name
                    ]);
                }
            }

            return response()->json($data);
        } else {
            return [];
        }
    }
}
