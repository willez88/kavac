@php
	$pdf->SetTitle('Libro Auxiliar'); // titulo del archivo
    $height = $pdf->get_Y();

    // @var float total por el debe
    $totDebit=0;

    // @var float total por el debe
    $totAssets=0;

    // @var float saldo total
    $totBalance = 0;

    // @var float saldo acumulado en cada iteración
    $beginningBalance = 0;

    $lineWrites = 7;
@endphp

<h1 align="center">
	LIBRO AUXILIAR
</h1>
{{-- si la cuenta tiene una de nivel superior la muesta de lo contrario solo muesta la cuenta --}}
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
	{{-- $record es un array el cual tiene cada registro relacionado con una cuenta en un asiento contable  --}}
	@foreach($records as $record)
		{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
		@if($lineWrites+1 >= 26)
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
				// se realizan los calculos para el saldo total
				$totBalance = ((float)$beginningBalance + (float)$record['debit'] - (float)$record['assets']);
				$beginningBalance = $totBalance;
			@endphp
		</tr>
	@endforeach
	<br>
	{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
		@if($lineWrites+2 >= 26)
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