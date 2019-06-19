@php
	$pdf->SetTitle('Mayor Analítico'); // titulo del archivo
    $height = $pdf->get_Y();

    $shownAccounts = [];

	$initDate = new DateTime($initDate);
	$endDate = new DateTime($endDate);

	$initDate = $initDate->format('d/m/Y');
	$endDate = $endDate->format('d/m/Y');

	/** @var boolean bandera que indica si la cuenta aumenta por el debe ó por el haber*/
    $ForAssets = false;

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

@foreach($records as $record)

	@php
		$first = true;
		$beginningBalance = 0;
		$totDebe=0;
    	$totHaber=0;
	@endphp
	@if(uniqueRecord($shownAccounts, $record[0]['account']['id']))

		@if($first)
			<h4>MAYOR ANALÍTICO {{ $record[0]['account']['denomination'] }}</h4>
			<h4>DESDE {{ $initDate }} HASTA {{ $endDate }}</h4>
			<h4>EXPRESADO EN {{ $currency->symbol }}</h4>
			<br>
			@php
				if ($record[0]['account']['group'] == 1) {
					$ForAssets = true;
				}
			@endphp
		@endif
		<table cellspacing="0" cellpadding="1" border="0">
			@if($first)
				<tr style="background-color: #BDBDBD;">
					<th width="8%" align="center">FECHA</th>
					<th width="15%" align="center">REFERENCIA</th>
					<th width="28%" align="center">DESCRIPCIÓN DE LA OPERACIÓN</th>
					<th width="16%" align="center">DEBE</th>
					<th width="16%" align="center">HABER</th>
					<th width="16%" align="center">SALDO FINAL</th>
				</tr>
				@php
					$first = false;
				@endphp
			@endif
			@foreach($record as $r)
				<tr>
					<td> {{ $r['updated_at']->format('d/m/Y') }}</td>
					<td> {{ $r['seating']['reference'] }}</td>
					<td> {{ $r['seating']['concept'] }}</td>
					<td align="right">
						{{ number_format($r['debit'], (int)$currency->decimal_places, ',', '.') }} 
						@php
							$totDebe += (float)$r['debit'];
						@endphp
					</td>
					<td align="right">
						{{ number_format($r['assets'], (int)$currency->decimal_places, ',', '.') }} 
						@php
							$totHaber += (float)$r['assets'];
						@endphp
					</td>
					<td align="right">
						@php
							if ($ForAssets) {
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
				<td style="background-color: #BDBDBD;"></td>
				<td style="background-color: #BDBDBD;" align="right"> TOTAL CUENTA</td>
				<td style="background-color: #BDBDBD;" align="right"> {{ number_format($totDebe, (int)$currency->decimal_places, ',', '.') }} </td>
				<td style="background-color: #BDBDBD;" align="right"> {{ number_format($totHaber, (int)$currency->decimal_places, ',', '.') }} </td>
				<td style="background-color: #BDBDBD;" align="right"> {{ number_format($totBalance, (int)$currency->decimal_places, ',', '.') }} </td>
			</tr>
		</table>
		@php
			array_push($shownAccounts, $record[0]['account']['id']);
			$ForAssets = false;
		@endphp
	@endif
	<br><br>

@endforeach