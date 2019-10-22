@php
    /**
	* [$totDebit total por el debe de una cuenta]
	* @var float
	*/
    $totDebit=0;

    /**
	* [$totAssets total por el haber de una cuenta]
	* @var float
	*/
    $totAssets=0;

    /**
	* [$totBalance total del saldo de la cuenta]
	* @var float
	*/
    $totBalance = 0;

    /**
	* [$previousBalance saldo acumulado en cada iteración por cuenta]
	* @var float
	*/
    $previousBalance = 0;

@endphp
{{-- si la cuenta tiene una de nivel superior la muesta de lo contrario solo muesta la cuenta --}}
@if($parent_account)
	<h3 style="font-size: 9rem;">CUENTA {{ $parent_account->getCodeAttribute().' '.$parent_account->denomination }} </h3>
	@if($parent_account->id != $record['id'])
		<h3 style="font-size: 9rem;">SUBCUENTA {{ $record['code'].' '.$record['denomination'] }}</h3>
	@endif
@else
	<h3 style="font-size: 9rem;">CUENTA {{ $record['code'].' '.$record['denomination'] }}</h3>
@endif

<h4 style="font-size: 9rem;">DESDE {{ $initDate }} AL {{ $endDate }}</h4>
<h4 style="font-size: 9rem;">EXPRESADO EN {{ $currency->symbol }}</h4>
<table cellspacing="0" cellpadding="1" border="0">
	<tr style="background-color: #BDBDBD;">
		<td style="font-size: 9rem;" width="10%" align="center">FECHA</td>
		<td style="font-size: 9rem;" width="32%" align="center">CONCEPTO</td>
		<td style="font-size: 9rem;" width="14%" align="center">REFERENCIA</td>
		<td style="font-size: 9rem;" width="22%" align="center">DEBITO</td>
		<td style="font-size: 9rem;" width="22%" align="center">CREDITO</td>
	</tr>

	@foreach($record['entryAccount'] as $r)
	@if($r['entries'])
		<tr>
			<td style="font-size: 9rem;"> {{ $r['entries']['created_at'] }}</td>
			<td style="font-size: 9rem;"> {{ $r['entries']['concept'] }}</td>
			<td style="font-size: 9rem;"> {{ $r['entries']['reference'] }}</td>
			<td style="font-size: 9rem;" align="right">
				{{ number_format($r['debit'], (int)$currency->decimal_places, ',', '.') }} 
				@php
					$totDebit += (float)$r['debit'];
				@endphp
			</td>
			<td style="font-size: 9rem;" align="right">
				{{ number_format($r['assets'], (int)$currency->decimal_places, ',', '.') }} 
				@php
					$totAssets += (float)$r['assets'];
				@endphp
			</td>
			@php
				// se realizan los calculos para el saldo total
				$totBalance = ((float)$previousBalance + (float)$r['debit'] - (float)$r['assets']);
				$previousBalance = $totBalance;
			@endphp
		</tr>
	@endif
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
