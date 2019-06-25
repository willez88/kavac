@php
	if ($Seating) {
		$pdf->SetTitle('Asiento Contable'); // titulo del archivo
	}else{
		$pdf->SetTitle('Libro Diario'); // titulo del archivo
	}
    $height = $pdf->get_Y();
    $totDebit=0;
    $totAssets=0;
    $cont = 1;

    $lineWrites = 0;
@endphp
@if($Seating)
	<h2 align="center">ASIENTO CONTABLE</h2>
	@php $lineWrites = 5; @endphp
@else
	<h2 align="center">LIBRO DIARIO</h2>
	@php $lineWrites = 3; @endphp
@endif
<h4>EXPRESADO EN {{ $currency->symbol }}</h4>

@if($Seating)
	{{-- Pdf de asiento contable --}}
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
				{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
				@if($lineWrites == 26)
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
		{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
		@if($lineWrites+1 == 26)
			<br pagebreak="true" />
			@php
				$lineWrites = 0;
			@endphp
		@endif

		@php
			// Se aumenta el contador de lineas
			$lineWrites++;

			// Se formatea la fecha
			$from_date = explode('-', $seat['from_date']);
		@endphp
		{{-- Fin de la validación --}}
		<table cellspacing="0" cellpadding="1" border="0">
			<tr >
				{{-- se formatea la fecha de Y-m-d a d-m-Y --}}
				<td width="10%" style="background-color: #BDBDBD;" align="left"> <strong>{{ $from_date[2].'-'.$from_date[1].'-'.$from_date[0] }}</strong></td>
				<td width="15%" style="background-color: #BDBDBD;"></td>
		        <td width="45%" style="background-color: #BDBDBD;" align="center">
		        	<strong>{{ $cont }}</strong>
		        	@php
		        		$cont++;
		        	@endphp
		        </td>
		        <td width="15%" style="background-color: #BDBDBD;"></td>
		        <td width="15%" style="background-color: #BDBDBD;"></td>
			</tr>
			@foreach($seat['accounting_accounts'] as $account)
				{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
				@if($lineWrites+1 == 26)
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
