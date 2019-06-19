@php
	$pdf->SetTitle('Libro Auxiliar'); // titulo del archivo
    $height = $pdf->get_Y();
    $totDebit=0;
    $totAssets=0;
    $totBalance = 0;
    $cont = 1;
    $beginningBalance = 0;
@endphp

<h1 align="center">
	LIBRO AUXILIAR
</h1>
@if($parent_account)
	<h3>CUENTA {{ $parent_account->getCode().' '.$parent_account->denomination }} </h3>
	@if($parent_account->id != $account->id)
		<h3>SUBCUENTA {{ $account->getCode().' '.$account->denomination }}</h3>
	@endif
@else
	<h3>CUENTA {{ $account->getCode().' '.$account->denomination }}</h3>
@endif

<h4>EXPRESADO EN {{ $currency->symbol }}</h4>
<table cellspacing="0" cellpadding="1" border="1">
	<tr style="background-color: #BDBDBD;">
		<td width="10%" align="center">FECHA</td>
		<td width="32%" align="center">CONCEPTO</td>
		<td width="14%" align="center">REFERENCIA</td>
		<td width="22%" align="center">DEBITO</td>
		<td width="22%" align="center">CREDITO</td>
	</tr>
	@foreach($records as $record)
		<tr>
			<td> {{ $record['updated_at']->format('d/m/Y') }}</td>
			<td> {{ $record['seating']['concept'] }}</td>
			<td> {{ $record['seating']['reference'] }}</td>
			<td align="right">
				{{ number_format($record['debit'], (int)$currency->decimal_places, ',', '.') }} 
				@php
					$totDebit += (float)$record['debit'];
				@endphp
			</td>
			<td align="right">
				{{ number_format($record['assets'], (int)$currency->decimal_places, ',', '.') }} 
				@php
					$totAssets += (float)$record['assets'];
				@endphp
			</td>
			@php
				$totBalance = ((float)$beginningBalance + (float)$record['debit'] - (float)$record['assets']);
				$beginningBalance = $totBalance;
			@endphp
		</tr>
	@endforeach
	<br>
	<tr>
		<td></td>
		<td style="background-color: #BDBDBD;" align="right">SUMAS</td>
		<td style="background-color: #BDBDBD;"></td>
		<td style="background-color: #BDBDBD;" align="right"> {{ number_format($totDebit, (int)$currency->decimal_places, ',', '.') }} </td>
		<td style="background-color: #BDBDBD;" align="right"> {{ number_format($totAssets, (int)$currency->decimal_places, ',', '.') }} </td>
	</tr>
	<tr>
		<td></td>
		<td style="background-color: #BDBDBD;" align="right">SALDO</td>
		<td style="background-color: #BDBDBD;"></td>

		<td style="background-color: #BDBDBD;" align="right">
			@if($totBalance >= 0)
				{{ number_format($totBalance, (int)$currency->decimal_places, ',', '.') }}
			@endif
		</td>
		<td style="background-color: #BDBDBD;" align="right">
			@if($totBalance < 0)
				{{ number_format(-$totBalance, (int)$currency->decimal_places, ',', '.') }} 
			@endif
		</td>
	</tr>
</table>