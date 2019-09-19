@php
	/**
	 * [$totDebit total por el debe]
	 * @var float
	 */
    $totDebit=0.0;

    /**
     * [$totAssets total por el haber]
     * @var float
     */
    $totAssets=0.0;

    /**
     * [$cont contador de operaciones con asientos contables]
     * @var integer
     */
    $cont = 1;

@endphp
<h4 style="font-size:9rem;">EXPRESADO EN {{ $currency->symbol }}</h4>

@if($Seating)
	@php
		$from_date = explode('-', $seat['from_date']);
	@endphp
	{{-- Pdf de asiento contable --}}
	<table cellspacing="0" cellpadding="1" border="0">
		<tr>
			{{-- se formatea la fecha de Y-m-d a d-m-Y --}}
			<th style="font-size:9rem;" width="50%"> Asiento Contable del {{ $from_date[2].'-'.$from_date[1].'-'.$from_date[0] }}</th>
	        <th style="font-size:9rem;" width="50%"> Ref.: {{ $seat['reference'] }}</th>
		</tr>
		<tr>
			<th style="font-size:9rem;" width="50%"> Concepto: {{ $seat['concept'] }}</th>
			<th style="font-size:9rem;" width="50%"> Observaciones: {{ $seat['observations'] }}</th>
		</tr>
		{{-- Cuentas patrimoniales --}}
		<table cellspacing="1" cellpadding="1" border="0">
			<tr>
				<th width="12%" style="font-size:9rem; background-color: #BDBDBD;" align="center">CÓDIGO</th>
				<th width="53%" style="font-size:9rem; background-color: #BDBDBD;" align="center">CUENTAS</th>
				<th width="17%" style="font-size:9rem; background-color: #BDBDBD;" align="center">DEBE</th>
				<th width="17%" style="font-size:9rem; background-color: #BDBDBD;" align="center">HABER</th>
			</tr>
			@foreach($seat['accountingAccounts'] as $seatAccount)
				<tr>
					<td style="font-size: 9rem;" align="center">
						{{$seatAccount['account']->getCodeAttribute() }}
					</td>
					<td style="font-size:9rem;">
						{{' '.$seatAccount['account']['denomination'] }}
					</td>
					<td style="font-size:9rem;" align="right">
						{{' '.number_format($seatAccount['debit'], (int)$currency->decimal_places, ',', '.') }}  
					</td>
					<td style="font-size:9rem;" align="right">
						{{' '.number_format($seatAccount['assets'], (int)$currency->decimal_places, ',', '.') }}  
					</td>
					@php
						$totDebit = $totDebit+$seatAccount['debit'];
						$totAssets = $totAssets+$seatAccount['assets'];
					@endphp
				</tr>
			@endforeach
		</table>
		<br><br>
		<table cellspacing="0" cellpadding="1" border="0">
			<tr style="background-color: #BDBDBD;">
				<td style="font-size:9rem;" width="65%"></td>
				<td style="font-size:9rem;" width="17%" align="center">TOTAL DEBE</td>
				<td style="font-size:9rem;" width="17%" align="center">TOTAL HABER</td>
			</tr>
			<tr>
				<td style="font-size:9rem;" ></td>
				<td style="font-size:9rem;" align="right">
					{{' '.number_format($totDebit, (int)$currency->decimal_places, ',', '.') }}  
				</td>
				<td style="font-size:9rem;" align="right">
					{{' '.number_format($totAssets, (int)$currency->decimal_places, ',', '.') }}  
				</td>
			</tr>
		</table>
	</table>
@else
	{{-- reporte de libro diario --}}
	<table cellspacing="0" cellpadding="1" border="1">
		<tr>
			<th style="font-size:9rem;" width="10%" align="center">FECHA</th>
			<th style="font-size:9rem;" width="15%" align="center">CÓDIGO</th>
			<th style="font-size:9rem;" width="45%" align="center">CUENTAS</th>
			<th style="font-size:9rem;" width="15%" align="center">DEBE</th>
			<th style="font-size:9rem;" width="15%" align="center">HABER</th>
		</tr>
	</table>
	@foreach($seats as $seat)
		<table cellspacing="0" cellpadding="1" border="0">
			<tr >
				@php
					$from_date = explode('-', $seat['from_date']);
				@endphp
				{{-- se formatea la fecha de Y-m-d a d-m-Y --}}
				<td width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="left"> {{ $from_date[2].'-'.$from_date[1].'-'.$from_date[0] }}</td>
				<td width="15%" style="font-size:9rem; background-color: #BDBDBD;"></td>
		        <td width="45%" style="font-size:9rem; background-color: #BDBDBD;" align="center">
		        	{{ $cont }}
		        	@php
		        		$cont++;
		        	@endphp
		        </td>
		        <td width="15%" style="font-size:9rem; background-color: #BDBDBD;"></td>
		        <td width="15%" style="font-size:9rem; background-color: #BDBDBD;"></td>
			</tr>
			@foreach($seat['accountingAccounts'] as $seatAccount)
				<tr>
					<td style="font-size:9rem;"></td>
					<td style="font-size:9rem;" align="center"> {{ $seatAccount['account']->getCodeAttribute() }}</td>
					<td style="font-size:9rem;">
						{{' '.$seatAccount['account']['denomination'] }} 
					</td>
					<td style="font-size:9rem;" align="right">
						{{' '.number_format($seatAccount['debit'], (int)$currency->decimal_places, ',', '.') }}  
					</td>
					<td style="font-size:9rem;" align="right">
						{{' '.number_format($seatAccount['assets'], (int)$currency->decimal_places, ',', '.') }}  
					</td>
					@php
						$totDebit = $totDebit+$seatAccount['debit'];
						$totAssets = $totAssets+$seatAccount['assets'];
					@endphp
				</tr>
			@endforeach
		</table>
	@endforeach
	<table cellspacing="0" cellpadding="1" border="0">
		<tr style="background-color: #BDBDBD;">
			<td style="font-size:9rem;" width="70%"></td>
			<td style="font-size:9rem;" width="15%" align="center">TOTAL DEBE</td>
			<td style="font-size:9rem;" width="15%" align="center">TOTAL HABER</td>
		</tr>
		<tr>
			<td style="font-size:9rem;" ></td>
			<td style="font-size:9rem;" align="right">
				{{number_format($totDebit, (int)$currency->decimal_places, ',', '.') }} 
			</td>
			<td style="font-size:9rem;" align="right">
				{{number_format($totAssets, (int)$currency->decimal_places, ',', '.') }} 
			</td>
		</tr>
	</table>
@endif
