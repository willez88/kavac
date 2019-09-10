@php
    // @var float total por el debe
    $totDebit = 0;
    // @var float total por el haber
    $totAssets = 0;
    // @var float total deudor
    $totDebitor = 0;
    // @var float total acreedor
    $totCreditor = 0;
    // @var float saldo acumulado en cada iteración por cuenta
    $beg_Balance = 0;

    // @var array arreglo con la informacion de las cuentas de manera unica
    $shownAccounts = [];

	$initDate = new DateTime($initDate);
	$endDate = new DateTime($endDate);

	// Se formatea la fecha
	$initDate = $initDate->format('d/m/Y');

	// Se formatea la fecha
	$endDate = $endDate->format('d/m/Y');

    /**
     * Verifica que la cuenta este registrada en el arreglo de manera unica
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

	<h2 style="font-size: 9rem;" align="center">BALACE DE COMPROBACIÓN DESDE {{ $initDate }} HASTA {{ $endDate }}</h2>
	<h4 style="font-size: 9rem;">EXPRESADO EN {{ $currency->symbol }}</h4>
	<br>
	<table cellspacing="0" cellpadding="1" border="1">
		{{-- Header de la tabla --}}
		<tr>
			<th style="font-size: 9rem;" width="12%" align="center">CÓDIGO</th>
			<th style="font-size: 9rem;" width="25%" align="center">CUENTA</th>
			<th style="font-size: 9rem;" width="21%" align="center">SALDO INICIAL</th>
			<th style="font-size: 9rem;" width="21%" align="center">SUMAS</th>
			<th style="font-size: 9rem;" width="21%" align="center">SALDO FINAL</th>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="1" border="0">
		{{-- Header de la tabla --}}
		<tr style="background-color: #BDBDBD;">
			<td style="font-size: 9rem;" width="12%"></td>
			<td style="font-size: 9rem;" width="25%"></td>
			<td style="font-size: 9rem;" width="10.3%" align="center">DEUDOR</td>
			<td style="font-size: 9rem;" width="10.7%" align="center">ACREEDOR</td>
			<td style="font-size: 9rem;" width="10.3%" align="center">DEBE</td>
			<td style="font-size: 9rem;" width="10.7%" align="center">HABER</td>
			<td style="font-size: 9rem;" width="10.3%" align="center">DEUDOR</td>
			<td style="font-size: 9rem;" width="10.7%" align="center">ACREEDOR</td>
		</tr>
		@if(count($records) > 0)
			@foreach($records as $record)
				@php
					// @var float total por el debe de la cuenta
					$debitAcc  =0;
					// @var float total por el haber de la cuenta
			    	$assetsAcc =0;
				@endphp
				@if(uniqueRecord($shownAccounts, $record[0]['account']['id']))

					@foreach($record as $r)
						@php
							$debitAcc += (float)$r['debit'];
							$assetsAcc += (float)$r['assets'];
							$totBalance = (float)$r['debit'] - (float)$r['assets'];
						@endphp
					@endforeach
					<tr>
						<td style="font-size: 9rem;" align="left"> {{ $r['account']->getCodeAttribute() }}</td>
						<td style="font-size: 9rem;" align="left"> {{ $r['account']['denomination'] }}</td>
						@php
							$beg_Balance = 0;
							if ( !is_null($beginningBalance) && array_key_exists($r['account']['id'], $beginningBalance)) {
								$beg_Balance = $beginningBalance[ $r['account']['id'] ];
							}
						@endphp

						<td style="font-size: 9rem;" align="right">
							@if( ((float)$beg_Balance >= 0) )
								{{ number_format($beg_Balance, (int)$currency->decimal_places, ',', '.') }}
							@endif
						</td>
						<td style="font-size: 9rem;" align="right">
							@if( ((float)$beg_Balance < 0) )
								{{ number_format(-$beg_Balance, (int)$currency->decimal_places, ',', '.') }}
							@endif
						</td>
						<td style="font-size: 9rem;" align="right">
							{{ number_format($debitAcc, (int)$currency->decimal_places, ',', '.') }}
						</td>
						<td style="font-size: 9rem;" align="right">
							{{ number_format($assetsAcc, (int)$currency->decimal_places, ',', '.') }}
						</td>
						@php
							$res = 0;
							$res = $beg_Balance + ($debitAcc-$assetsAcc);
						@endphp
						<td style="font-size: 9rem;" align="right"> 
							@if($res >= 0)
								{{ number_format($res, (int)$currency->decimal_places, ',', '.') }}
								@php
									$totDebitor += (float)($res);
								@endphp
							@endif
						</td>
						<td style="font-size: 9rem;" align="right"> 
							@if($res < 0)
								{{ number_format(-$res, (int)$currency->decimal_places, ',', '.') }}
								@php
									$totCreditor += -((float)($res));
								@endphp
							@endif
						</td>
					</tr>
					@php
						$totDebit += $debitAcc;
						$totAssets += $assetsAcc;
					@endphp
				@endif
				@php
					array_push($shownAccounts, $record[0]['account']['id']);
				@endphp
			@endforeach
		@endif
		<tr style="background-color: #BDBDBD;">
			<td></td>
			<td style="font-size: 9rem;" align="center"><strong>TOTALES</strong></td>
			<td style="font-size: 9rem;"></td>
			<td style="font-size: 9rem;"></td>
			<td style="font-size: 9rem;" align="right">
					{{ number_format($totDebit, (int)$currency->decimal_places, ',', '.') }}
			</td>
			<td style="font-size: 9rem;" align="right">
					{{ number_format($totAssets, (int)$currency->decimal_places, ',', '.') }}
			</td>
			<td style="font-size: 9rem;" align="right">
				{{ number_format($totDebitor, (int)$currency->decimal_places, ',', '.') }}
			</td>
			<td style="font-size: 9rem;" align="right">
					{{ number_format($totCreditor, (int)$currency->decimal_places, ',', '.') }}
			</td>
		</tr>
	</table>
