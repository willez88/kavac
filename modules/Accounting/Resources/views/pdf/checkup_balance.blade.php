@php
    /**
     * [$totDebit total por el debe]
     * @var float
     */
    $totDebit = 0.0;

    /**
     * [$totAssets total por el haber]
     * @var float
     */
    $totAssets = 0.0;

    /**
     * [$totDebitor total deudor]
     * @var float
     */
    $totDebitor = 0.0;

    /**
     * [$totCreditor total acreedor]
     * @var float
     */
    $totCreditor = 0.0;
    
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
		
		@foreach($records as $record)
			<tr>
				<td style="font-size: 9rem;" align="left"> {{ $record['code'] }}</td>
				<td style="font-size: 9rem;" align="left"> {{ $record['denomination'] }}</td>
				{{-- Saldo inicial --}}
				<td style="font-size: 9rem;" align="right">
					@if($record['beginningBalance'] >= 0)
						{{ number_format($record['beginningBalance'], (int)$currency->decimal_places, ',', '.') }}
					@endif
				</td>
				<td style="font-size: 9rem;" align="right">
					@if($record['beginningBalance'] < 0)
						{{ number_format(-$record['beginningBalance'], (int)$currency->decimal_places, ',', '.') }}
					@endif
				</td>

				{{-- Suma de saldos --}}
				<td style="font-size: 9rem;" align="right">
					@if($record['sum_debit'])
						{{ number_format($record['sum_debit'], (int)$currency->decimal_places, ',', '.') }}
					@elseif(!$record['sum_assets'])
						{{ number_format(0, (int)$currency->decimal_places, ',', '.') }}
					@endif
				</td>
				<td style="font-size: 9rem;" align="right">
					@if($record['sum_assets'])
						{{ number_format(-$record['sum_assets'], (int)$currency->decimal_places, ',', '.') }}
					@elseif(!$record['sum_debit'])
						{{ number_format(0, (int)$currency->decimal_places, ',', '.') }}
					@endif
				</td>

				{{-- Saldo final --}}
				<td style="font-size: 9rem;" align="right">
					@if($record['balance_debit'])
						{{ number_format($record['balance_debit'], (int)$currency->decimal_places, ',', '.') }}
					@elseif(!$record['balance_assets'])
						{{ number_format(0, (int)$currency->decimal_places, ',', '.') }}
					@endif
				</td>
				<td style="font-size: 9rem;" align="right">
					@if($record['balance_assets'])
						{{ number_format(-$record['balance_assets'], (int)$currency->decimal_places, ',', '.') }}
					@elseif(!$record['balance_debit'])
						{{ number_format(0, (int)$currency->decimal_places, ',', '.') }}
					@endif
				</td>
				@php
					$totDebit += floatval($record['sum_debit']);
					$totAssets += floatval($record['sum_assets']);
					$totDebitor += floatval($record['balance_debit']);
					$totCreditor += floatval($record['balance_assets']);
				@endphp
			</tr>
		@endforeach
		
		<tr style="background-color: #BDBDBD;">
			<td></td>
			<td style="font-size: 9rem;" align="center"><strong>TOTALES</strong></td>
			<td style="font-size: 9rem;"></td>
			<td style="font-size: 9rem;"></td>
			<td style="font-size: 9rem;" align="right">
					{{ number_format($totDebit, (int)$currency->decimal_places, ',', '.') }}
			</td>
			<td style="font-size: 9rem;" align="right">
					{{ number_format(-$totAssets, (int)$currency->decimal_places, ',', '.') }}
			</td>
			<td style="font-size: 9rem;" align="right">
				{{ number_format($totDebitor, (int)$currency->decimal_places, ',', '.') }}
			</td>
			<td style="font-size: 9rem;" align="right">
					{{ number_format(-$totCreditor, (int)$currency->decimal_places, ',', '.') }}
			</td>
		</tr>
	</table>
