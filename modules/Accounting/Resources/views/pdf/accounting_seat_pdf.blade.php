@php
	$pdf->SetTitle('Asientos Contables'); // titulo del archivo
    $height = $pdf->get_Y();
    $totDebe=0;
    $totHaber=0;                
@endphp
<table cellspacing="0" cellpadding="1" border="1">
	@foreach($seats as $seat)
	<tr>
		@php
			$from_date = explode('-', $seat['from_date']);
		@endphp
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
			<th width="70%" align="center">Cuentas Patrimoniales</th>
			<th width="15%" align="center">Debe</th>
			<th width="15%" align="center">Haber</th>
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
	@endforeach
	<br><br>
	<table cellspacing="0" cellpadding="1" border="1">
		<tr>
			<th width="70%"></th>
			<th width="15%" align="center">Total Debe</th>
			<th width="15%" align="center">Total Haber</th>
		</tr>
		<tr>
			<td></td>
			<td>
				{{' '.$totDebe }}
			</td>
			<td>
				{{' '.$totHaber }}
			</td>
		</tr>
	</table>
</table>
{{-- Totales --}}
