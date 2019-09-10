@php
    // @var float total por el debe
    $totDebit=0;

    // @var float total por el debe
    $totAssets=0;

    // @var float saldo total
    $totBalance = 0;

    // @var float saldo acumulado en cada iteración
    $beginningBalance = 0;

@endphp
{{-- si la cuenta tiene una de nivel superior la muesta de lo contrario solo muesta la cuenta --}}
@if($parent_account)
	<h3 style="font-size: 9rem;">CUENTA {{ $parent_account->getCodeAttribute().' '.$parent_account->denomination }} </h3>
	@if($parent_account->id != $account->id)
		<h3 style="font-size: 9rem;">SUBCUENTA {{ $account->getCodeAttribute().' '.$account->denomination }}</h3>
	@endif
@else
	<h3 style="font-size: 9rem;">CUENTA {{ $account->getCodeAttribute().' '.$account->denomination }}</h3>
@endif

<h4 style="font-size: 9rem;">EXPRESADO EN {{ $currency->symbol }}</h4>
<table cellspacing="0" cellpadding="1" border="0">
	<tr style="background-color: #BDBDBD;">
		<td style="font-size: 9rem;" width="10%" align="center">FECHA</td>
		<td style="font-size: 9rem;" width="32%" align="center">CONCEPTO</td>
		<td style="font-size: 9rem;" width="14%" align="center">REFERENCIA</td>
		<td style="font-size: 9rem;" width="22%" align="center">DEBITO</td>
		<td style="font-size: 9rem;" width="22%" align="center">CREDITO</td>
	</tr>
	{{-- $record es un array el cual tiene cada registro relacionado con una cuenta en un asiento contable  --}}
	@foreach($records as $record)
		<tr>
			<td style="font-size: 9rem;"> {{ $record['updated_at']->format('d/m/Y') }}</td>
			<td style="font-size: 9rem;"> {{ $record['seating']['concept'] }}</td>
			<td style="font-size: 9rem;"> {{ $record['seating']['reference'] }}</td>
			<td style="font-size: 9rem;" align="right">
				{{ number_format($record['debit'], (int)$currency->decimal_places, ',', '.') }} 
				@php
					$totDebit += (float)$record['debit'];
				@endphp
			</td>
			<td style="font-size: 9rem;" align="right">
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
	<tr>
		<td></td>
		<td style="font-size: 9rem; background-color: #BDBDBD;" align="right">SUMAS</td>
		<td style="font-size: 9rem; background-color: #BDBDBD;"></td>
		<td style="font-size: 9rem; background-color: #BDBDBD;" align="right"> {{ number_format($totDebit, (int)$currency->decimal_places, ',', '.') }} </td>
		<td style="font-size: 9rem; background-color: #BDBDBD;" align="right"> {{ number_format($totAssets, (int)$currency->decimal_places, ',', '.') }} </td>
	</tr>
	<tr>
		<td></td>
		<td style="font-size: 9rem; background-color: #BDBDBD;" align="right">SALDO</td>
		<td style="font-size: 9rem; background-color: #BDBDBD;"></td>

		<td style="font-size: 9rem; background-color: #BDBDBD;" align="right">
			@if($totBalance >= 0)
				{{ number_format($totBalance, (int)$currency->decimal_places, ',', '.') }}
			@endif
		</td>
		<td style="font-size: 9rem; background-color: #BDBDBD;" align="right">
			@if($totBalance < 0)
				{{ number_format(-$totBalance, (int)$currency->decimal_places, ',', '.') }} 
			@endif
		</td>
	</tr>
</table>
