
<h4 style="font-size: 9rem;">DESDE {{ $initDate }} HASTA {{ $endDate }}</h4>
<h4 style="font-size: 9rem;">EXPRESADO EN {{ $currency->symbol }}</h4>

@foreach($records as $record)
	@php
		/**
		* [$previousBalance saldo acumulado en cada iteración por cuenta]
		* @var float
		*/
		$previousBalance = 0.0;
		
		/**
		* [$totBalance total del saldo de la cuenta]
		* @var float
		*/
		$totBalance      = 0.0;

		/**
		* [$totDebit total por el debe de una cuenta]
		* @var float
		*/
		$totDebit         =0.0;
		
		/**
		* [$totAssets total por el haber de una cuenta]
		* @var float
		*/
		$totAssets        =0.0;

	@endphp

		{{-- HEADER de tablas --}}
		<h4 style="font-size: 9rem;">MAYOR ANALÍTICO {{ $record['denomination'] }}</h4>
		<br>
		<table cellspacing="0" cellpadding="1" border="0">
			<tr style="background-color: #BDBDBD;">
				<th width="9%" align="center" style="font-size: 9rem;">FECHA</th>
				<th width="15%" align="center" style="font-size: 9rem;">REFERENCIA</th>
				<th width="28%" align="center" style="font-size: 9rem;">DESCRIPCIÓN DE LA OPERACIÓN</th>
				<th width="16%" align="center" style="font-size: 9rem;">DEBE</th>
				<th width="16%" align="center" style="font-size: 9rem;">HABER</th>
				<th width="16%" align="center" style="font-size: 9rem;">SALDO FINAL</th>
			</tr>
			@foreach($record['entryAccount'] as $r)
				@if($r['entries'])
					<tr>
						<td style="font-size: 9rem;"> {{ $r['entries']['created_at'] }}</td>
						<td style="font-size: 9rem;"> {{ $r['entries']['reference'] }}</td>
						<td style="font-size: 9rem;"> {{ $r['entries']['concept'] }}</td>
						<td style="font-size: 9rem;" align="right">
							{{ number_format($r['debit'], (int)$currency->decimal_places, ',', '.') }} 
							@php
								// se realizan los calculos para el saldo total por el debe
								$totDebit += (float)$r['debit'];
							@endphp
						</td>
						<td style="font-size: 9rem;" align="right">
							{{ number_format($r['assets'], (int)$currency->decimal_places, ',', '.') }} 
							@php
								// se realizan los calculos para el saldo total por el haber
								$totAssets += (float)$r['assets'];
							@endphp
						</td>
						<td style="font-size: 9rem;" align="right">
							@php
								$totBalance = ((float)$previousBalance + (float)$r['debit']) - (float)$r['assets'];
								$previousBalance = $totBalance;
							@endphp
							{{ number_format($totBalance, (int)$currency->decimal_places, ',', '.') }}
						</td>
					</tr>
				@endif
			@endforeach
			<tr>
				<td></td>
				<td style="font-size: 9rem; background-color: #BDBDBD;"></td>
				<td style="font-size: 9rem; background-color: #BDBDBD;" align="right"> TOTAL CUENTA</td>
				<td style="font-size: 9rem; background-color: #BDBDBD;" align="right"> {{ number_format($totDebit, (int)$currency->decimal_places, ',', '.') }} </td>
				<td style="font-size: 9rem; background-color: #BDBDBD;" align="right"> {{ number_format($totAssets, (int)$currency->decimal_places, ',', '.') }} </td>
				<td style="font-size: 9rem; background-color: #BDBDBD;" align="right"> {{ number_format($totBalance, (int)$currency->decimal_places, ',', '.') }} </td>
			</tr>
		</table>
	<br>

@endforeach
