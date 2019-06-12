<?php
use Modules\Budget\Models\BudgetSubSpecificFormulation;
use Modules\Budget\Models\BudgetAccountOpen;
use Modules\Budget\Models\AditionalCredit;
use Modules\Budget\Models\AditionalCreditAccount;

if (! function_exists('budget_available')) {
	/**
	 * Determina la disponibilidad presupuestaria de una cuenta
	 *
	 * @author	Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
	 * @param  string  $year  	  		   Año de la formulación presupuestaria
	 * @param  integer $specific_action_id Identificador de la acción específica
	 * @param  integer $account_id 		   Identificador de la cuenta presupuestaria
	 * @return Devuelve el monto de la disponibilidad de la cuenta
	 */
	function budget_available($year, $specific_action_id, $account_id)
	{
		$available = 0;

		$formulation = BudgetSubSpecificFormulation::where([
			'year' => $year, 'budget_specific_action_id' => $specific_action_id
		])->first();

		if ($formulation) {
			$account_formulated = $formulation->account_opens()->where('budget_account_id', $account_id)->first();
			
			if ($account_formulated) {
				$available += $account_formulated->total_year_amount;
			}

			$aditional_credits = $formulation->aditional_credit_accounts()
											 ->where('budget_account_id', $account_id)->get();

			if ($aditional_credits) {
				foreach ($aditional_credits as $aditionalCredit) {
					$available += $aditionalCredit->amount;
				}
			}
		}

		return $available ?? 0;
	}
}

if (! function_exists('budget_check_opened_account')) {
	/**
	 * Determina si la cuenta esta aperturada para el año de ejecución presupuestaria
	 *
	 * @author	Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
	 * @param  string  $year               Año de la ejecución presupuestaria
	 * @param  integer $specific_action_id Identificador de la acción específica
	 * @param  integer $account_id         Identificador de la cuenta presupuestaria
	 * @return boolean                     Devuelve verdadero si la cuenta esta aperturada, 
	 *                                     de lo contrario retorna falso
	 */
	function budget_check_opened_account($year, $specific_action_id, $account_id)
	{
		$opened = false;

		$formulation = BudgetSubSpecificFormulation::where([
			'year' => $year, 'budget_specific_action_id' => $specific_action_id
		])->first();

		if ($formulation) {
			$opened = ($formulation->account_opens()->where('budget_account_id', $account_id)->first());
		}

		return $opened;
	}
}