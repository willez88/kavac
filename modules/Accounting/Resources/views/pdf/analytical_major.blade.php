@php

    // @var array arreglo con la informacion de las cuentas de manera unica
    $shownAccounts = [];

	/** @var boolean bandera que indica si la cuenta aumenta por el debe ó por el haber*/
    $forAssets = false;

    /**
     * [uniqueRecord Verifica que la cuenta este registrada en el arreglo de manera unica]
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param Array $records arreglo con las cuentas almacenadas de manera unica
     * @param Int $data id de la cuenta
	* @return bolean retorna falso si la cuenta ya se encuentra egregada en el array
    */

	function uniqueRecord($records, $data)
	{
		$unique = true;
		for ($i=0; $i < count($records); $i++) { 
			if ($records[$i] == $data) {
				$unique = false;
				break;
			}
		}
		return $unique;
	}
@endphp
{{-- $records es un array que en cada posición tiene otro array con los registros en asientos contables que tenga una cuenta en particular  --}}
@foreach($records as $record)
	@php
		// @var boolean bandera usada para mostrar el header de la tabla una vez por cada cuenta
		$first = true;

		// @var float saldo acumulado en cada iteración por cuenta
		$beginningBalance = 0;

		// @var float total por el debe de la cuenta
		$totDebe=0;

		// @var float total por el haber de la cuenta
    	$totHaber=0;

	@endphp
	@if(uniqueRecord($shownAccounts, $record[0]['account']['id']))
		{{-- HEADER de tablas --}}
		@if($first)
			<h4 style="font-size: 9rem;">MAYOR ANALÍTICO {{ $record[0]['account']['denomination'] }}</h4>
			<h4 style="font-size: 9rem;">DESDE {{ $initDate }} HASTA {{ $endDate }}</h4>
			<h4 style="font-size: 9rem;">EXPRESADO EN {{ $currency->symbol }}</h4>
			<br>
			@php
				// Se valida si la cuenta aumenta por el haber
				if ($record[0]['account']['group'] == 1) {
					$forAssets = true;
				}
			@endphp
		@endif
		<table cellspacing="0" cellpadding="1" border="0">
			@if($first)
				<tr style="background-color: #BDBDBD;">
					<th width="9%" align="center" style="font-size: 9rem;">FECHA</th>
					<th width="15%" align="center" style="font-size: 9rem;">REFERENCIA</th>
					<th width="28%" align="center" style="font-size: 9rem;">DESCRIPCIÓN DE LA OPERACIÓN</th>
					<th width="16%" align="center" style="font-size: 9rem;">DEBE</th>
					<th width="16%" align="center" style="font-size: 9rem;">HABER</th>
					<th width="16%" align="center" style="font-size: 9rem;">SALDO FINAL</th>
				</tr>
				@php
					// Se cambia el valor de la variable para evitar que vuelva a mostrar la fila con los th
					$first = false;
				@endphp
			@endif
			{{-- $record es un array el cual tiene cada registro relacionado con una cuenta en un asiento contable  --}}
			@foreach($record as $r)
				<tr>
					<td style="font-size: 9rem;"> {{ $r['updated_at']->format('d/m/Y') }}</td>
					<td style="font-size: 9rem;"> {{ $r['seating']['reference'] }}</td>
					<td style="font-size: 9rem;"> {{ $r['seating']['concept'] }}</td>
					<td style="font-size: 9rem;" align="right">
						{{ number_format($r['debit'], (int)$currency->decimal_places, ',', '.') }} 
						@php
							// se realizan los calculos para el saldo total por el debe
							$totDebe += (float)$r['debit'];
						@endphp
					</td>
					<td style="font-size: 9rem;" align="right">
						{{ number_format($r['assets'], (int)$currency->decimal_places, ',', '.') }} 
						@php
							// se realizan los calculos para el saldo total por el haber
							$totHaber += (float)$r['assets'];
						@endphp
					</td>
					<td style="font-size: 9rem;" align="right">
						@php
							// se realizan los calculos para el saldo total
							if ($forAssets) {
					            $totBalance = ((float)$beginningBalance + (float)$r['assets']) - (float)$r['debit'];
					        }else{
								$totBalance = ((float)$beginningBalance + (float)$r['debit']) - (float)$r['assets'];
					        }
							
							$beginningBalance = $totBalance;
						@endphp
						{{ number_format($totBalance, (int)$currency->decimal_places, ',', '.') }}
					</td>
				</tr>
			@endforeach
			<tr>
				<td></td>
				<td style="font-size: 9rem; background-color: #BDBDBD;"></td>
				<td style="font-size: 9rem; background-color: #BDBDBD;" align="right"> TOTAL CUENTA</td>
				<td style="font-size: 9rem; background-color: #BDBDBD;" align="right"> {{ number_format($totDebe, (int)$currency->decimal_places, ',', '.') }} </td>
				<td style="font-size: 9rem; background-color: #BDBDBD;" align="right"> {{ number_format($totHaber, (int)$currency->decimal_places, ',', '.') }} </td>
				<td style="font-size: 9rem; background-color: #BDBDBD;" align="right"> {{ number_format($totBalance, (int)$currency->decimal_places, ',', '.') }} </td>
			</tr>
		</table>
		@php
			// Se agrega al array de cuenta mostradas el id de la cuenta
			array_push($shownAccounts, $record[0]['account']['id']);

			$forAssets = false;
		@endphp
	@endif
	<br><br>

@endforeach

{{-- <style>
body {
  margin: 0;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #212529;
  text-align: left;
  background-color: #fff;
}
</style> --}}
