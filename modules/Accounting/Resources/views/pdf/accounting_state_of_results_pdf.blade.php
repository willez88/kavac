@php
	$pdf->SetTitle('Estado de Resultados'); // titulo del archivo
    $height = $pdf->get_Y();

    $lineWrites = 3;

    // @var float resultado total de las operaciones
    $result_of_the_excersice = 0;
@endphp
<h3>ESTADO DE RESULTADOS AL {{ $endDate }}</h3>
<h4>EXPRESADO EN {{ $currency->symbol }}</h4>
<table cellspacing="0" cellpadding="1" border="1">
	<tr style="background-color: #BDBDBD;">
		<td width="12%" align="center">CÓDIGO</td>
		<td width="63%" align="center">DENOMINACIÓN</td>
		<td width="25%" align="center"></td>
	</tr>
</table>
<table cellspacing="0" cellpadding="1" border="0">

	{{-- Se recorren las cuentas de Inicio Nivel 1 --}}
	@if($level >= 1 && count($records) > 0)
	@foreach($records as $parent)
		<tr style="background-color: #BDBDBD;">
			<td width="12%">&nbsp;{{ $parent['code'] }}</td>
			<td width="63%">&nbsp;{{ $parent['denomination'] }}</td>
			<td align="right" width="25%"></td>
		</tr>
		{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
		@if($lineWrites == 28)
			<br pagebreak="true" />
			@php
				$lineWrites = 0;
			@endphp
		@endif
		@php
			// Se aumenta el contador de lineas
			$lineWrites++;
		@endphp

		{{-- Se recorren las cuentas de Inicio Nivel 2 --}}
		@if($level >= 2 )
		@foreach($parent['children'] as $children2)
			@if($parent['show_children'] || $parent['balance'] == number_format(0, (int)$currency->decimal_places, ',', '.') && !$zero)
				{{-- No muestra nada --}}
			@else
				<tr>
					<td width="12%">&nbsp;{{ $children2['code'] }}</td>
					<td width="63%">&nbsp; {{ $children2['denomination'] }}</td>
					<td align="right" width="25%">{{ number_format($children2['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
				</tr>
				{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
				@if($lineWrites == 28)
					<br pagebreak="true" />
					@php
						$lineWrites = 0;
					@endphp
				@endif
				@php
					// Se aumenta el contador de lineas
					$lineWrites++;
				@endphp
			@endif

			{{-- Se recorren las cuentas de Inicio Nivel 3 --}}
			@if($level >= 3 )
			@foreach($children2['children'] as $children3)
				@if($children2['show_children'] || $children2['balance'] == number_format(0, (int)$currency->decimal_places, ',', '.') && !$zero)
					{{-- No muestra nada --}}
				@else
					<tr>
						<td width="12%">&nbsp;{{ $children3['code'] }}</td>
						<td width="63%">&nbsp; &nbsp; {{ $children3['denomination'] }}</td>
						<td align="right" width="25%">{{ number_format($children3['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
					</tr>
					{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
					@if($lineWrites == 28)
						<br pagebreak="true" />
						@php
							$lineWrites = 0;
						@endphp
					@endif
					@php
						// Se aumenta el contador de lineas
						$lineWrites++;
					@endphp
				@endif
				{{-- Se recorren las cuentas de Inicio Nivel 4 --}}
				@if($level >= 4 )
				@foreach($children3['children'] as $children4)
					@if($children3['show_children'] || $children3['balance'] == number_format(0, (int)$currency->decimal_places, ',', '.') && !$zero)
						{{-- No muestra nada --}}
					@else
						<tr>
							<td width="12%">&nbsp;{{ $children4['code'] }}</td>
							<td width="63%">&nbsp; &nbsp; &nbsp; {{ $children4['denomination'] }}</td>
							<td align="right" width="25%">{{ number_format($children4['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
						</tr>
						{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
						@if($lineWrites == 28)
							<br pagebreak="true" />
							@php
								$lineWrites = 0;
							@endphp
						@endif
						@php
							// Se aumenta el contador de lineas
							$lineWrites++;
						@endphp
					@endif
					{{-- Se recorren las cuentas de Inicio Nivel 5 --}}
					@if($level >= 5 )
					@foreach($children4['children'] as $children5)
						@if($children4['show_children'] || $children4['balance'] == number_format(0, (int)$currency->decimal_places, ',', '.') && !$zero)
							{{-- No muestra nada --}}
						@else
							<tr>
								<td width="12%">&nbsp;{{ $children5['code'] }}</td>
								<td width="63%">&nbsp; &nbsp; &nbsp; &nbsp; {{ $children5['denomination'] }}</td>
								<td align="right" width="25%">{{ number_format($children5['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
							</tr>
							{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
							@if($lineWrites == 28)
								<br pagebreak="true" />
								@php
									$lineWrites = 0;
								@endphp
							@endif
							@php
								// Se aumenta el contador de lineas
								$lineWrites++;
							@endphp
						@endif
						{{-- Se recorren las cuentas de Inicio Nivel 6 --}}
						@if($level == 6 )
						@foreach($children5['children'] as $children6)
							@if($children5['show_children'] || $children5['balance'] == number_format(0, (int)$currency->decimal_places, ',', '.') && !$zero)
								{{-- No muestra nada --}}
							@else
								<tr>
									<td width="12%">&nbsp;{{ $children6['code'] }}</td>
									<td width="63%">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; {{ $children6['denomination'] }}</td>
									<td align="right" width="25%">{{ number_format($children6['balance'], (int)$currency->decimal_places, ',', '.') }}</td>
								</tr>
								{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
								@if($lineWrites == 28)
									<br pagebreak="true" />
									@php
										$lineWrites = 0;
									@endphp
								@endif
								@php
									// Se aumenta el contador de lineas
									$lineWrites++;
								@endphp
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
					// Se suman los totales resultantes de las cuentas de nivel superior que ya traen los resultados de los calculos desde el controlador
					if($parent['code'][0] === '5')
						$result_of_the_excersice += $parent['balance'];
					else if ($parent['code'][0] === '6') 
						$result_of_the_excersice -= $parent['balance'];
				@endphp
			</td>
		</tr>
		{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
		@if($lineWrites == 28)
			<br pagebreak="true" />
			@php
				$lineWrites = 0;
			@endphp
		@endif
		@php
			// Se aumenta el contador de lineas
			$lineWrites++;
		@endphp

		@if($parent['code'][0] == 6)
			<br>
{{-- 			<tr style="background-color: #BDBDBD;">
				<td width="12%"></td>
				<td align="right" width="63%">SUB TOTAL</td>
				<td align="right" width="25%">{{ number_format($result_of_the_excersice, (int)$currency->decimal_places, ',', '.') }}</td>
			</tr> --}}
			<tr style="background-color: #BDBDBD;">
				<td width="12%"></td>
				<td align="right" width="63%">RESULTADO DEL EJERCICIO</td>
				<td align="right" width="25%">{{ number_format($result_of_the_excersice, (int)$currency->decimal_places, ',', '.') }}</td>
			</tr>
			{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
			@if($lineWrites == 28)
				<br pagebreak="true" />
				@php
					$lineWrites = 0;
				@endphp
			@endif
			@php
				// Se aumenta el contador de lineas
				$lineWrites++;
			@endphp
		@endif
		<br><br>
	@endforeach
	@endif
	{{-- Fin Nivel 1 --}}
</table>