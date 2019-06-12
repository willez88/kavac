@php
	$pdf->SetTitle('Balance de Comprobación'); // titulo del archivo
    $height = $pdf->get_Y();

    $totDebit = 0;
    $totAssets = 0;
    $totDebitor = 0;
    $totCreditor = 0;
    $beg_Balance = 0;

    $shownAccounts = [];

	$initDate = new DateTime($initDate);
	$endDate = new DateTime($endDate);

	$initDate = $initDate->format('d/m/Y');
	$endDate = $endDate->format('d/m/Y');

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
					$debitAcc  =0;
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

							if ($beg_Balance >= 0) {
								if (($debitAcc-$assetsAcc) >= 0) {
									$res = $beg_Balance + ($debitAcc-$assetsAcc);
								}else{
									$res = $beg_Balance + ($debitAcc-$assetsAcc);
								}
							}else if ($beg_Balance < 0) {
								if (($debitAcc-$assetsAcc) >= 0) {
									$res = $beg_Balance + ($debitAcc-$assetsAcc);
								}else{
									$res = $beg_Balance + ($debitAcc-$assetsAcc);
								}
							}

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
