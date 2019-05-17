@php
	$pdf->SetTitle('Asientos Contables'); // titulo del archivo
    $height = $pdf->get_Y();
    $totDebe=0;
    $totHaber=0;                
@endphp
{{-- reporte de libro diario --}}
@if(isset($seats))
	@foreach($seats as $seat)
		<table cellspacing="0" cellpadding="1" border="1">
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
			<table cellspacing="0" cellpadding="1" border="1">
				<tr>
					<th width="65%" align="center">Cuentas Patrimoniales</th>
					<th width="17.5%" align="center">Debe</th>
					<th width="17.5%" align="center">Haber</th>
				</tr>
				@foreach($seat['accounting_accounts'] as $account)
					<tr>
						<td>
							{{' '.$account['account']['denomination'] }}
						</td>
						<td>
							{{' '.$account['debit'] }}	
						</td>
						<td>
							{{' '.$account['assets'] }}
						</td>
						@php
							$totDebe = $totDebe+$account['debit'];
							$totHaber = $totHaber+$account['assets'];
						@endphp
					</tr>
				@endforeach
			</table>
			<br><br>
			<table cellspacing="0" cellpadding="1" border="1">
				<tr>
					<th width="65%"></th>
					<th width="17.5%" align="center">Total Debe</th>
					<th width="17.5%" align="center">Total Haber</th>
				</tr>
				<tr>
					<td></td>
					<td>
						{{' '.$seat['tot_debit'] }}
					</td>
					<td>
						{{' '.$seat['tot_assets'] }}
					</td>
				</tr>
			</table>
		</table>
		@foreach($acc)
		<br><br><br><br><br><br><br><br><br><br><br>
	@endforeach
@else
{{-- reporte de asiento contable --}}
	<table cellspacing="0" cellpadding="1" border="1">
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
		<table cellspacing="0" cellpadding="1" border="1">
			<tr>
				<th width="65%" align="center">Cuentas Patrimoniales</th>
				<th width="17.5%" align="center">Debe</th>
				<th width="17.5%" align="center">Haber</th>
			</tr>
			@foreach($seat['accounting_accounts'] as $account)
				<tr>
					<td>
						{{' '.$account['account']['denomination'] }}
					</td>
					<td>
						{{' '.$account['debit'] }}	
					</td>
					<td>
						{{' '.$account['assets'] }}
					</td>
					@php
						$totDebe = $totDebe+$account['debit'];
						$totHaber = $totHaber+$account['assets'];
					@endphp
				</tr>
			@endforeach
		</table>
		<br><br>
		<table cellspacing="0" cellpadding="1" border="1">
			<tr>
				<th width="65%"></th>
				<th width="17.5%" align="center">Total Debe</th>
				<th width="17.5%" align="center">Total Haber</th>
			</tr>
			<tr>
				<td></td>
				<td>
					{{' '.$seat['tot_debit'] }}
				</td>
				<td>
					{{' '.$seat['tot_assets'] }}
				</td>
			</tr>
		</table>
	</table>
@endif
{{-- Totales --}}
