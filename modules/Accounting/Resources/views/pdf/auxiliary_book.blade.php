@php
    /**
	* [$subTotDebit total por el debe de una cuenta]
	* @var float
	*/
    $subTotDebit=0.0;

    /**
	* [$subTotAssets total por el haber de una cuenta]
	* @var float
	*/
    $subTotAssets=0.0;

    /**
	* [$total saldo de la cuenta]
	* @var float
	*/
    $totalDebit = 0.0;

    /**
	* [$total saldo de la cuenta]
	* @var float
	*/
    $totalAssets = 0.0;

@endphp
{{-- si la cuenta tiene una de nivel superior la muesta de lo contrario solo muesta la cuenta --}}

<h5 style="font-size: 9rem;">DESDE {{ $initDate }} AL {{ $endDate }}</h5>
<h5 style="font-size: 9rem;">EXPRESADO EN {{ $currency->symbol }}</h5>

<table cellspacing="0" cellpadding="1" border="0">
	<thead>
		<tr style="background-color: #BDBDBD;">
			<td style="font-size: 9rem;" width="12%" align="center">CÓDIGO</td>
			<td style="font-size: 9rem;" width="44%" align="center">CUENTA</td>
			<td style="font-size: 9rem;" width="22%" align="right">DEBITO</td>
			<td style="font-size: 9rem;" width="22%" align="right">CREDITO</td>
		</tr>
	</thead>
	<tbody>
		@foreach($record as $rec)
			@php
				$subTotal     = 0.0;
				$subTotDebit  = 0.0;
				$subTotAssets = 0.0;
			@endphp
			@foreach($rec['entryAccount'] as $r)
				@if($r['entries'])
					@php
                        $subTotDebit  += (float)$r['debit'];
                        $subTotAssets += (float)$r['assets'];
					@endphp
				@endif
			@endforeach

			<tr>
				<td style="font-size: 9rem;" width="12%" align="left">{{ $rec['code'] }}</td>
				<td style="font-size: 9rem;" width="44%" align="left">{{ $rec['denomination'] }}</td>
				<td style="font-size: 9rem;" width="22%" align="right">
					{{ number_format($subTotDebit, (int)$currency->decimal_places, ',', '.') }}
				</td>
				<td style="font-size: 9rem;" width="22%" align="right">
					{{ number_format($subTotAssets, (int)$currency->decimal_places, ',', '.') }}
				</td>
			</tr>
			@php
                $totalDebit  += $subTotDebit;
                $totalAssets += $subTotAssets;
			@endphp
		@endforeach
	</tbody>
</table>

<table cellspacing="0" cellpadding="1" border="0">
	<thead>
		<tr style="background-color: #BDBDBD;">
			<td style="font-size: 9rem;" width="56%"></td>
			<td style="font-size: 9rem;" width="22%" align="right">TOTAL DEBITO</td>
			<td style="font-size: 9rem;" width="22%" align="right">TOTAL CREDITO</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="font-size: 9rem;" width="56%"></td>
			<td style="font-size: 9rem;" width="22%" align="right">
				{{ $currency->symbol }} 
				{{ number_format($totalDebit, (int)$currency->decimal_places, ',', '.') }}
			</td>
			<td style="font-size: 9rem;" width="22%" align="right">
				{{ $currency->symbol }} 
				{{ number_format($totalAssets, (int)$currency->decimal_places, ',', '.') }}
			</td>
		</tr>
	</tbody>
</table>


