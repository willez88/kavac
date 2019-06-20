@php
	$pdf->SetTitle('balance General'); // titulo del archivo
    $height = $pdf->get_Y();

    $result_of_the_excersice = 0;
@endphp
<h3>BALANCE GENERAL AL {{ $endDate }}</h3>
<h4>EXPRESADO EN {{ $currency->symbol }}</h4>
<table cellspacing="0" cellpadding="1" border="1">
	<tr style="background-color: #BDBDBD;">
		<td width="12%" align="center">CÓDIGO</td>
		<td width="63%" align="center">DENOMINACIÓN</td>
		<td width="25%" align="center"></td>
	</tr>

	{{-- Inicio Nivel 1 --}}
	@if($level >= 1 && count($records) > 0)
	@foreach($records as $parent)
		<tr style="background-color: #BDBDBD;">
			<td>&nbsp;{{ $parent['code'] }}</td>
			<td>&nbsp;{{ $parent['denomination'] }}</td>
			<td align="right"></td>
		</tr>

		{{-- Inicio Nivel 2 --}}
		@if($level >= 2 )
		@foreach($parent['children'] as $children2)
			@if($parent['show_children'] || $parent['balance'] == number_format(0, (int)$currency->decimal_places, ',', '.') && !$zero)
				{{-- No muestra nada --}}
			@else
				<tr>
					<td>&nbsp;{{ $children2['code'] }}</td>
					<td>&nbsp; {{ $children2['denomination'] }}</td>
					<td align="right">{{ number_format($children2['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
				</tr>
			@endif

			{{-- Inicio Nivel 3 --}}
			@if($level >= 3 )
			@foreach($children2['children'] as $children3)
				@if($children2['show_children'] || $children2['balance'] == number_format(0, (int)$currency->decimal_places, ',', '.') && !$zero)
					{{-- No muestra nada --}}
				@else
					<tr>
						<td>&nbsp;{{ $children3['code'] }}</td>
						<td>&nbsp; &nbsp; {{ $children3['denomination'] }}</td>
						<td align="right">{{ number_format($children3['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
					</tr>
				@endif
				{{-- Inicio Nivel 4 --}}
				@if($level >= 4 )
				@foreach($children3['children'] as $children4)
					@if($children3['show_children'] || $children3['balance'] == number_format(0, (int)$currency->decimal_places, ',', '.') && !$zero)
						{{-- No muestra nada --}}
					@else
						<tr>
							<td>&nbsp;{{ $children4['code'] }}</td>
							<td>&nbsp; &nbsp; &nbsp; {{ $children4['denomination'] }}</td>
							<td align="right">{{ number_format($children4['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
						</tr>
					@endif
					{{-- Inicio Nivel 5 --}}
					@if($level >= 5 )
					@foreach($children4['children'] as $children5)
						@if($children4['show_children'] || $children4['balance'] == number_format(0, (int)$currency->decimal_places, ',', '.') && !$zero)
							{{-- No muestra nada --}}
						@else
							<tr>
								<td>&nbsp;{{ $children5['code'] }}</td>
								<td>&nbsp; &nbsp; &nbsp; &nbsp; {{ $children5['denomination'] }}</td>
								<td align="right">{{ number_format($children5['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
							</tr>
						@endif
						{{-- Inicio Nivel 6 --}}
						@if($level == 6 )
						@foreach($children5['children'] as $children6)
							@if($children5['show_children'] || $children5['balance'] == number_format(0, (int)$currency->decimal_places, ',', '.') && !$zero)
								{{-- No muestra nada --}}
							@else
								<tr>
									<td>&nbsp;{{ $children6['code'] }}</td>
									<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; {{ $children6['denomination'] }}</td>
									<td align="right">{{ number_format($children6['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
								</tr>
							@endif
						@endforeach
						{{-- Fin Nivel 6 --}}
						@endif

					@endforeach
					{{-- Fin Nivel 5 --}}
					@endif

				@endforeach
				{{-- Fin Nivel 4 --}}
				@endif

			@endforeach
			{{-- Fin Nivel 3 --}}
			@endif

		@endforeach
		{{-- Fin Nivel 2 --}}
		@endif
		<tr style="background-color: #BDBDBD;">
			<td></td>
			<td align="right">
				@if($parent['code'][0] === '5')
					TOTAL INGRESOS
				@elseif($parent['code'][0] === '6')
					TOTAL GASTOS
				@endif
			</td>
			<td align="right">
				{{ number_format($parent['balance'], (int)$currency->decimal_places, ',', '.') }}
				@php
				
					if($parent['code'][0] === '5')
						$result_of_the_excersice += $parent['balance'];
					else if ($parent['code'][0] === '6') 
						$result_of_the_excersice -= $parent['balance'];
				@endphp
			</td>
		</tr>
		@if($parent['code'][0] == 6)
			<br>
			<tr style="background-color: #BDBDBD;">
				<td></td>
				<td align="right">SUB TOTAL</td>
				<td align="right">{{ number_format($result_of_the_excersice, (int)$currency->decimal_places, ',', '.') }}</td>
			</tr>
			<tr style="background-color: #BDBDBD;">
				<td></td>
				<td align="right">RESULTADO DEL EJERCICIO</td>
				<td align="right">{{ number_format($result_of_the_excersice, (int)$currency->decimal_places, ',', '.') }}</td>
			</tr>
		@endif
		<br><br>
	@endforeach
	@endif
	{{-- Fin Nivel 1 --}}
</table>