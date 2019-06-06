@php
	$pdf->SetTitle('Libro Diario'); // titulo del archivo
    $height = $pdf->get_Y();
    $totDebit=0;
    $totAssets=0;                
@endphp
<h2 align="center">LIBRO DIARIO</h2>
<h4>EXPRESADO EN {{ $currency->symbol }}</h4>

@if($OneSeat)
	{{-- Pdf de un asiento contable --}}
	<table cellspacing="0" cellpadding="1" border="0">
		<tr>
			@php
				$from_date = explode('-', $seat['from_date']);
			@endphp
			{{-- se formatea la fecha de Y-m-d a d-m-Y --}}
			<th width="50%"> Asiento Contable del {{ $from_date[2].'-'.$from_date[1].'-'.$from_date[0] }}</th>
	        <th width="50%"> Ref.: {{ $seat['reference'] }}</th>
		</tr>
		<tr>
			<th width="50%"> Concepto: {{ $seat['concept'] }}</th>
			<th width="50%"> Observaciones: {{ $seat['observations'] }}</th>
		</tr>
		{{-- Cuentas patrimoniales --}}
		<table cellspacing="1" cellpadding="1" border="0">
			<tr>
				<th width="65%" style="background-color: #BDBDBD;" align="center">CUENTAS</th>
				<th width="17%" style="background-color: #BDBDBD;" align="center">DEBE</th>
				<th width="17%" style="background-color: #BDBDBD;" align="center">HABER</th>
			</tr>
			@foreach($seat['accounting_accounts'] as $account)
				<tr>
					<td>
						{{' '.$account['account']['denomination'] }}
					</td>
					<td>
						<span>{{ ' '.$currency->symbol }}</span>{{' '.$account['debit'] }}	
					</td>
					<td>
						<span>{{ ' '.$currency->symbol }}</span>{{' '.$account['assets'] }}
					</td>
					@php
						$totDebit = $totDebit+$account['debit'];
						$totAssets = $totAssets+$account['assets'];
					@endphp
				</tr>
			@endforeach
		</table>
		<br><br>
		<table cellspacing="0" cellpadding="1" border="0">
			<tr style="background-color: #BDBDBD;">
				<td width="65%"></td>
				<td width="17.5%" align="center">TOTAL DEBE</td>
				<td width="17.5%" align="center">TOTAL HABER</td>
			</tr>
			<tr>
				<td ></td>
				<td>
					{{' '.$totDebit }}
				</td>
				<td>
					{{' '.$totAssets }}
				</td>
			</tr>
		</table>
	</table>
@else
	{{-- reporte de libro diario --}}
	<table cellspacing="0" cellpadding="1" border="1">
		<tr>
			<th width="10%" align="center">FECHA</th>
			<th width="15%" align="center">CÓDIGO</th>
			<th width="45%" align="center">CUENTAS</th>
			<th width="15%" align="center">DEBE</th>
			<th width="15%" align="center">HABER</th>
		</tr>
	</table>
	@foreach($seats as $seat)
		@php
			$from_date = explode('-', $seat['from_date']);
		@endphp
		<table cellspacing="0" cellpadding="1" border="0">
			<tr >
				{{-- se formatea la fecha de Y-m-d a d-m-Y --}}
				<td width="10%" style="background-color: #BDBDBD;" align="left"> <strong>{{ $from_date[2].'-'.$from_date[1].'-'.$from_date[0] }}</strong></td>
				<td width="15%" style="background-color: #BDBDBD;"></td>
		        <td width="45%" style="background-color: #BDBDBD;" align="center"><strong>{{ $seat['reference'] }} - {{ $seat['concept'] }}</strong></td>
		        <td width="15%" style="background-color: #BDBDBD;"></td>
		        <td width="15%" style="background-color: #BDBDBD;"></td>
			</tr>
			@foreach($seat['accounting_accounts'] as $account)
				<tr>
					<td></td>
					<td align="left"> {{ ' '.$account['account']['group'].'.'.$account['account']['subgroup'].'.'.$account['account']['item'].'.'.$account['account']['generic'].'.'.$account['account']['specific'].'.'.$account['account']['subspecific'] }}</td>
					<td>
						{{' '.$account['account']['denomination'] }} 
					</td>
					<td align="right">
						{{' '.number_format($account['debit'], (int)$currency->decimal_places, ',', '.') }}  
					</td>
					<td align="right">
						{{' '.number_format($account['assets'], (int)$currency->decimal_places, ',', '.') }}  
					</td>
					@php
						$totDebit = $totDebit+$account['debit'];
						$totAssets = $totAssets+$account['assets'];
					@endphp
				</tr>
			@endforeach
		</table>
	@endforeach
	<table cellspacing="0" cellpadding="1" border="0">
		<tr style="background-color: #BDBDBD;">
			<td width="70%"></td>
			<td width="15%" align="center">TOTAL DEBE</td>
			<td width="15%" align="center">TOTAL HABER</td>
		</tr>
		<tr>
			<td ></td>
			<td align="right">
				{{number_format($totDebit, (int)$currency->decimal_places, ',', '.') }} 
			</td>
			<td align="right">
				{{number_format($totAssets, (int)$currency->decimal_places, ',', '.') }} 
			</td>
		</tr>
	</table>
@endif

{{-- Totales --}}
