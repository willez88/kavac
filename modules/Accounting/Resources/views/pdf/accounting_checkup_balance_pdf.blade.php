@php
	$pdf->SetTitle('Balance de Comprobación'); // titulo del archivo
    $height = $pdf->get_Y();

    $totDebit = 0;
    $totAssets = 0;
    $totDebitor = 0;
    $totCreditor = 0;

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
		<tr style="background-color: #BDBDBD;">
			<th width="15%" align="center">CÓDIGO</th>
			<th width="25%" align="center">CUENTA</th>
			<th width="30%" align="center">SUMAS</th>
			<th width="30%" align="center">SALDOS</th>
		</tr>
	</table>
	<table cellspacing="1" cellpadding="1" border="0">
		{{-- Header de la tabla --}}
		<tr style="background-color: #BDBDBD;">
			<th width="15%"></th>
			<th width="25%"></th>
			<th width="15%" align="center">DEBE</th>
			<th width="15%" align="center">HABER</th>
			<th width="15%" align="center">DEUDOR</th>
			<th width="15%" align="center">ACREEDOR</th>
		</tr>
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
					<td align="right">
						@if($typeBalance == 'Complet' || $typeBalance == 'Sum')
							{{ number_format($debitAcc, (int)$currency->decimal_places, ',', '.') }}
						@endif
					</td>
					<td align="right">
						@if($typeBalance == 'Complet' || $typeBalance == 'Sum')
							{{ number_format($assetsAcc, (int)$currency->decimal_places, ',', '.') }}
						@endif
					</td>
					<td align="right"> 
						@if($typeBalance == 'Complet' || $typeBalance == 'Balance')
							@if($debitAcc-$assetsAcc >= 0)
								{{ number_format(($debitAcc-$assetsAcc), (int)$currency->decimal_places, ',', '.') }}
								@php
									$totDebitor += (float)($debitAcc-$assetsAcc);
								@endphp
							@endif
						@endif
					</td>
					<td align="right"> 
						@if($typeBalance == 'Complet' || $typeBalance == 'Balance')
							@if($debitAcc-$assetsAcc < 0)
								{{ number_format(-($debitAcc-$assetsAcc), (int)$currency->decimal_places, ',', '.') }}
								@php
									$totCreditor += -((float)($debitAcc-$assetsAcc));
								@endphp
							@endif
						@endif
					</td>
				</tr>
				@php
					$totDebit += $debitAcc;
					$totAssets += $assetsAcc;
				@endphp
			@endif
		@endforeach
		<tr style="background-color: #BDBDBD;">
			<td></td>
			<td align="right"><strong>TOTALES</strong></td>
			<td align="right">
				@if($typeBalance == 'Complet' || $typeBalance == 'Sum')
					{{ number_format($totDebit, (int)$currency->decimal_places, ',', '.') }}
				@endif
			</td>
			<td align="right">
				@if($typeBalance == 'Complet' || $typeBalance == 'Sum')
					{{ number_format($totAssets, (int)$currency->decimal_places, ',', '.') }}
				@endif
			</td>
			<td align="right">
				@if($typeBalance == 'Complet' || $typeBalance == 'Balance')
				{{ number_format($totDebitor, (int)$currency->decimal_places, ',', '.') }}
				@endif
			</td>
			<td align="right">
				@if($typeBalance == 'Complet' || $typeBalance == 'Balance')
					{{ number_format($totCreditor, (int)$currency->decimal_places, ',', '.') }}
				@endif
			</td>
		</tr>
	</table>
	@php
		array_push($shownAccounts, $record[0]['account']['id']);
	@endphp
