@php
    // @var float resultado total de las operaciones
    $result_of_the_excersice = 0;
    $months = [1=>'ENERO',2=>'FEBRERO',3=>'MARZO',4=>'ABRIL',5=>'MAYO',6=>'JUNIO',
			   7=>'JULIO',8=>'AGOSTO',9=>'SEPTIEMBRE',10=>'OCTUBRE',11=>'NOVIEMBRE',
			   12=>'DICIEMBRE'];
@endphp

<h3 style="font-size: 9rem;">ESTADO DE RESULTADOS AL {{ $endDate }}</h3>
<h4 style="font-size: 9rem;">EXPRESADO EN {{ $currency->symbol }}</h4>
<table cellspacing="0" cellpadding="1" border="1">
	<tr style="background-color: #BDBDBD;">
		<td style="font-size:9rem;" width="12%" align="center">CÓDIGO</td>
		<td style="font-size:9rem;" width="38%" align="center">DENOMINACIÓN</td>
		<td style="font-size:9rem;" width="15%" align="center">ACUMULADO AL {{ $monthBefore }}</td>
		<td style="font-size:9rem;" width="15%" align="center">{{ $months[(int)explode('-',$endDate)[1]] }}</td>
		<td style="font-size:9rem;" width="20%" align="center">ACUMULADO</td>
	</tr>
</table>
<table cellspacing="0" cellpadding="1" border="0">

	{{-- Se recorren las cuentas de Inicio Nivel 1 --}}
	@if($level >= 1 && count($records) > 0)
	@foreach($records as $parent)
		<tr style="background-color: #BDBDBD;">
			<td style="font-size:9rem;" width="12%">&nbsp;{{ $parent['code'] }}</td>
			<td style="font-size:9rem;" width="38%">&nbsp;{{ $parent['denomination'] }}</td>
			<td style="font-size:9rem;" align="right" width="15%">{{ number_format($parent['beginningBalance'], (int)$currency->decimal_places, ',', '.') }}</td>
			<td style="font-size:9rem;" align="right" width="15%">{{ number_format($parent['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
			<td style="font-size:9rem;" align="right" width="20%">
				{{ number_format(($parent['beginningBalance']+$parent['balance']), (int)$currency->decimal_places, ',', '.') }}
			</td>
		</tr>

		{{-- Se recorren las cuentas de Inicio Nivel 2 --}}
		@if($level >= 2 )
		@foreach($parent['children'] as $children2)
			@if($parent['level'] > $level && ($parent['balance'] == number_format(0, (int)$currency->decimal_places, ',', '.') && !$zero))
				{{-- No muestra nada --}}
			@else
				<tr>
					<td style="font-size:9rem;" width="12%">&nbsp;{{ $children2['code'] }}</td>
					<td style="font-size:9rem;" width="38%">&nbsp; {{ $children2['denomination'] }}</td>
					<td style="font-size:9rem;" align="right" width="15%">{{ number_format($children2['beginningBalance'], (int)$currency->decimal_places, ',', '.') }}</td>
					<td style="font-size:9rem;" align="right" width="15%">{{ number_format($children2['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
					<td style="font-size:9rem;" align="right" width="20%">
						{{ number_format(($children2['beginningBalance']+$children2['balance']), (int)$currency->decimal_places, ',', '.') }}
					</td>

				</tr>
			@endif

			{{-- Se recorren las cuentas de Inicio Nivel 3 --}}
			@if($level >= 3 )
			@foreach($children2['children'] as $children3)
				@if($children2['level'] > $level && ($children2['balance'] == number_format(0, (int)$currency->decimal_places, ',', '.') && !$zero))
					{{-- No muestra nada --}}
				@else
					<tr>
						<td style="font-size:9rem;" width="12%">&nbsp;{{ $children3['code'] }}</td>
						<td style="font-size:9rem;" width="38%">&nbsp; &nbsp; {{ $children3['denomination'] }}</td>
						<td style="font-size:9rem;" align="right" width="15%">{{ number_format($children3['beginningBalance'], (int)$currency->decimal_places, ',', '.') }}</td>
						<td style="font-size:9rem;" align="right" width="15%">{{ number_format($children3['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
						<td style="font-size:9rem;" align="right" width="20%">
							{{ number_format(($children3['beginningBalance']+$children3['balance']), (int)$currency->decimal_places, ',', '.') }}
						</td>
					</tr>
				@endif
				{{-- Se recorren las cuentas de Inicio Nivel 4 --}}
				@if($level >= 4 )
				@foreach($children3['children'] as $children4)
					@if($children3['level'] > $level && ($children3['balance'] == number_format(0, (int)$currency->decimal_places, ',', '.') && !$zero))
						{{-- No muestra nada --}}
					@else
						<tr>
							<td style="font-size:9rem;" width="12%">&nbsp;{{ $children4['code'] }}</td>
							<td style="font-size:9rem;" width="38%">&nbsp; &nbsp; &nbsp; {{ $children4['denomination'] }}</td>
							<td style="font-size:9rem;" align="right" width="15%">{{ number_format($children4['beginningBalance'], (int)$currency->decimal_places, ',', '.') }}</td>
							<td style="font-size:9rem;" align="right" width="15%">{{ number_format($children4['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
							<td style="font-size:9rem;" align="right" width="20%">
								{{ number_format(($children4['beginningBalance']+$children4['balance']), (int)$currency->decimal_places, ',', '.') }}
							</td>
						</tr>
					@endif
					{{-- Se recorren las cuentas de Inicio Nivel 5 --}}
					@if($level >= 5 )
					@foreach($children4['children'] as $children5)
						@if($children4['level'] > $level && ($children4['balance'] == number_format(0, (int)$currency->decimal_places, ',', '.') && !$zero))
							{{-- No muestra nada --}}
						@else
							<tr>
								<td style="font-size:9rem;" width="12%">&nbsp;{{ $children5['code'] }}</td>
								<td style="font-size:9rem;" width="38%">&nbsp; &nbsp; &nbsp; &nbsp; {{ $children5['denomination'] }}</td>
								<td style="font-size:9rem;" align="right" width="15%">{{ number_format($children5['beginningBalance'], (int)$currency->decimal_places, ',', '.') }}</td>
								<td style="font-size:9rem;" align="right" width="15%">{{ number_format($children5['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
								<td style="font-size:9rem;" align="right" width="20%">
									{{ number_format(($children5['beginningBalance']+$children5['balance']), (int)$currency->decimal_places, ',', '.') }}
								</td>
							</tr>
						@endif
						{{-- Se recorren las cuentas de Inicio Nivel 6 --}}
						@if($level == 6 )
						@foreach($children5['children'] as $children6)
							@if($children5['level'] > $level && ($children5['balance'] == number_format(0, (int)$currency->decimal_places, ',', '.') && !$zero))
								{{-- No muestra nada --}}
							@else
								<tr>
									<td style="font-size:9rem;" width="12%">&nbsp;{{ $children6['code'] }}</td>
									<td style="font-size:9rem;" width="38%">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; {{ $children6['denomination'] }}</td>
									<td style="font-size:9rem;" align="right" width="15%">{{ number_format($children6['beginningBalance'], (int)$currency->decimal_places, ',', '.') }}</td>
									<td style="font-size:9rem;" align="right" width="15%">{{ number_format($children6['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
									<td style="font-size:9rem;" align="right" width="20%">
										{{ number_format(($children6['beginningBalance']+$children6['balance']), (int)$currency->decimal_places, ',', '.') }}
									</td>
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
			<td style="font-size:9rem;"></td>
			<td style="font-size:9rem;" align="right">
				@if($parent['code'][0] === '5')
					TOTAL INGRESOS
				@elseif($parent['code'][0] === '6')
					TOTAL GASTOS
				@endif
			</td>
			<td style="font-size:9rem;" align="right" width="15%"></td>
			<td style="font-size:9rem;" align="right" width="15%"></td>
			<td style="font-size:9rem;" align="right">
				{{ number_format(($parent['beginningBalance']+$parent['balance']), (int)$currency->decimal_places, ',', '.') }}
				@php
					// Se suman los totales resultantes de las cuentas de nivel superior que ya traen los resultados de los calculos desde el controlador
					if($parent['code'][0] === '5')
						$result_of_the_excersice += ($parent['beginningBalance']+$parent['balance']);
					else if ($parent['code'][0] === '6') 
						$result_of_the_excersice += ($parent['beginningBalance']+$parent['balance']);
				@endphp
			</td>
		</tr>

		@if($parent['code'][0] == 6)
			<br>
			<tr style="background-color: #BDBDBD;">
				<td style="font-size:9rem;" width="12%"></td>
				<td style="font-size:9rem;" align="right" width="38%">RESULTADO DEL EJERCICIO</td>
				<td style="font-size:9rem;" align="right" width="15%"></td>
				<td style="font-size:9rem;" align="right" width="15%"></td>

				<td style="font-size:9rem;" align="right" width="20%">{{ number_format($result_of_the_excersice, (int)$currency->decimal_places, ',', '.') }}</td>
			</tr>
		@endif
		<br><br>
	@endforeach
	@endif
	{{-- Fin Nivel 1 --}}
</table>
