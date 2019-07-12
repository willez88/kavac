@php
	$pdf->SetTitle('Balance de Comprobación'); // titulo del archivo
    $height = $pdf->get_Y();

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
	* Cuenta el numero de lineas de contenido para realizar el salto de pagina
	* Se inicia en 5 tomando en cuenta el titulo del contenido
	*/
	$lineWrites = 5;

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

	<h2 align="center">BALACE DE COMPROBACIÓN DESDE {{ $initDate }} HASTA {{ $endDate }}</h2>
	<h4>EXPRESADO EN {{ $currency->symbol }}</h4>
	<br>
	<table cellspacing="0" cellpadding="1" border="1">
		{{-- Header de la tabla --}}
		<tr>
			<th width="11%" align="center">CÓDIGO</th>
			<th width="25%" align="center">CUENTA</th>
			<th width="164" align="center">SALDO INICIAL</th>
			<th width="21.5%" align="center">SUMAS</th>
			<th width="21.5%" align="center">SALDO FINAL</th>
		</tr>
	</table>
	<table cellspacing="1" cellpadding="1" border="0">
		{{-- Header de la tabla --}}
		<tr style="background-color: #BDBDBD;">
			<th width="11%"></th>
			<th width="25.2%"></th>
			<th width="10.3%" align="center">DEUDOR</th>
			<th width="10.5%" align="center">ACREEDOR</th>
			<th width="10.7%" align="center">DEBE</th>
			<th width="10.7%" align="center">HABER</th>
			<th width="10.8%" align="center">DEUDOR</th>
			<th width="10.8%" align="center">ACREEDOR</th>
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

					{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
					@if($lineWrites == 24)
						<br pagebreak="true" />
						@php
							$lineWrites = 0;
						@endphp
					@endif
					@php
						// Se aumenta el contador de lineas
						$lineWrites++;
					@endphp
					{{-- Fin de la validación --}}
					@foreach($record as $r)
						@php
							$debitAcc += (float)$r['debit'];
							$assetsAcc += (float)$r['assets'];
							$totBalance = (float)$r['debit'] - (float)$r['assets'];
						@endphp
					@endforeach
					<tr>
						<td align="left"> {{ $record[0]['account']->getCode() }}</td>
						<td align="left"> {{ $record[0]['account']['denomination'] }}</td>
						@php
							$beg_Balance = $beginningBalance[ $record[0]['account']['id'] ];
						@endphp

						<td align="right">
							@if( ((float)$beg_Balance >= 0) )
								{{ number_format($beg_Balance, (int)$currency->decimal_places, ',', '.') }}
							@endif
						</td>
						<td align="right">
							@if( ((float)$beg_Balance < 0) )
								{{ number_format(-$beg_Balance, (int)$currency->decimal_places, ',', '.') }}
							@endif
						</td>
						<td align="right">
							{{ number_format($debitAcc, (int)$currency->decimal_places, ',', '.') }}
						</td>
						<td align="right">
							{{ number_format($assetsAcc, (int)$currency->decimal_places, ',', '.') }}
						</td>
						@php
							$res = 0;
							$res = $beg_Balance + ($debitAcc-$assetsAcc);
						@endphp
						<td align="right"> 
							@if($res >= 0)
								{{ number_format($res, (int)$currency->decimal_places, ',', '.') }}
								@php
									$totDebitor += (float)($res);
								@endphp
							@endif
						</td>
						<td align="right"> 
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
			@php
				if ($lineWrites == 24) {
					$lineWrites = 0;
				}
				else{
					// Se aumenta el contador de lineas
					$lineWrites++;
				}
			@endphp
			<td></td>
			<td align="center"><strong>TOTALES</strong></td>
			<td></td>
			<td></td>
			<td align="right">
					{{ number_format($totDebit, (int)$currency->decimal_places, ',', '.') }}
			</td>
			<td align="right">
					{{ number_format($totAssets, (int)$currency->decimal_places, ',', '.') }}
			</td>
			<td align="right">
				{{ number_format($totDebitor, (int)$currency->decimal_places, ',', '.') }}
			</td>
			<td align="right">
					{{ number_format($totCreditor, (int)$currency->decimal_places, ',', '.') }}
			</td>
		</tr>
	</table>
