@php
	$pdf->SetTitle('Mayor Analítico'); // titulo del archivo
    $height = $pdf->get_Y();

    // @var array arreglo con la informacion de las cuentas de manera unica
    $shownAccounts = [];

	$initDate = new DateTime($initDate);
	$endDate = new DateTime($endDate);

	// Se formatea la fecha
	$initDate = $initDate->format('d/m/Y');

	// Se formatea la fecha
	$endDate = $endDate->format('d/m/Y');

	/** @var boolean bandera que indica si la cuenta aumenta por el debe ó por el haber*/
    $ForAssets = false;

    // Cuenta el numero de lineas de contenido para realizar el salto de pagina
	$lineWrites = 0;

    /**
     * Verifica que la cuenta este registrada en el arreglo de manera unica
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param Array $records arreglo con las cuentas almacenadas de manera unica
     * @param Int $data id de la cuenta
	* @return bolean retorna falso si la cuenta ya se encuentra egregada en el array
    */

	function uniqueRecord($records, $data)
	{
		$unique = true;
		for ($i=0; $i < count($records); $i++) { 
			if ($records[$i] == $data) {
				$unique = false;
				break;
			}
		}
		return $unique;
	}
@endphp
{{-- $records es un array que en cada posición tiene otro array con los registros en asientos contables que tenga una cuenta en particular  --}}
@foreach($records as $record)
	@php
		// @var boolean bandera usada para mostrar el header de la tabla una vez por cada cuenta
		$first = true;

		// @var float saldo acumulado en cada iteración por cuenta
		$beginningBalance = 0;

		// @var float total por el debe de la cuenta
		$totDebe=0;

		// @var float total por el haber de la cuenta
    	$totHaber=0;

	@endphp
	@if(uniqueRecord($shownAccounts, $record[0]['account']['id']))
	{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
	{{-- El salto se calcula de 3 ya que en encabezado de cada tabla continene 3 lineas de contenido --}}
		@if($lineWrites+3 >= 18)
			<br pagebreak="true" />
			@php
				$lineWrites = 0;
			@endphp
		@endif

		@php
			// Se aumenta el contador de lineas
			$lineWrites+=3;
		@endphp
		{{-- Fin de la validación --}}
		@if($first)
			<h4>MAYOR ANALÍTICO {{ $record[0]['account']['denomination'] }}</h4>
			<h4>DESDE {{ $initDate }} HASTA {{ $endDate }}</h4>
			<h4>EXPRESADO EN {{ $currency->symbol }}</h4>
			<br>
			@php
				// Se valida si la cuenta aumenta por el haber
				if ($record[0]['account']['group'] == 1) {
					$ForAssets = true;
				}
			@endphp
		@endif
		<table cellspacing="0" cellpadding="1" border="0">
			@if($first)
				<tr style="background-color: #BDBDBD;">
					<th width="8%" align="center">FECHA</th>
					<th width="15%" align="center">REFERENCIA</th>
					<th width="28%" align="center">DESCRIPCIÓN DE LA OPERACIÓN</th>
					<th width="16%" align="center">DEBE</th>
					<th width="16%" align="center">HABER</th>
					<th width="16%" align="center">SALDO FINAL</th>
				</tr>
				@php
					// Se cambia el valor de la variable para evitar que vuelva a mostrar la fila con los th
					$first = false;
				@endphp
			@endif
			{{-- $record es un array el cual tiene cada registro relacionado con una cuenta en un asiento contable  --}}
			@foreach($record as $r)

				{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
				@if($lineWrites+1 >= 18)
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
					<td> {{ $r['updated_at']->format('d/m/Y') }}</td>
					<td> {{ $r['seating']['reference'] }}</td>
					<td> {{ $r['seating']['concept'] }}</td>
					<td align="right">
						{{ number_format($r['debit'], (int)$currency->decimal_places, ',', '.') }} 
						@php
							// se realizan los calculos para el saldo total por el debe
							$totDebe += (float)$r['debit'];
						@endphp
					</td>
					<td align="right">
						{{ number_format($r['assets'], (int)$currency->decimal_places, ',', '.') }} 
						@php
							// se realizan los calculos para el saldo total por el haber
							$totHaber += (float)$r['assets'];
						@endphp
					</td>
					<td align="right">
						@php
							// se realizan los calculos para el saldo total
							if ($ForAssets) {
					            $totBalance = ((float)$beginningBalance + (float)$r['assets']) - (float)$r['debit'];
					        }else{
								$totBalance = ((float)$beginningBalance + (float)$r['debit']) - (float)$r['assets'];
					        }
							
							$beginningBalance = $totBalance;
						@endphp
						{{ number_format($totBalance, (int)$currency->decimal_places, ',', '.') }}
					</td>
				</tr>
			@endforeach
			<tr>
				{{-- Se valida el numero de lineas impresas para llegado el limite realizar el salto de pagina manualmente --}}
				@php
					if ($lineWrites+1 >= 18) {
						$lineWrites = 0;
					}
					else{
						// Se aumenta el contador de lineas
						$lineWrites++;
					}
				@endphp
				{{-- Fin de la validacion --}}
				<td></td>
				<td style="background-color: #BDBDBD;"></td>
				<td style="background-color: #BDBDBD;" align="right"> TOTAL CUENTA</td>
				<td style="background-color: #BDBDBD;" align="right"> {{ number_format($totDebe, (int)$currency->decimal_places, ',', '.') }} </td>
				<td style="background-color: #BDBDBD;" align="right"> {{ number_format($totHaber, (int)$currency->decimal_places, ',', '.') }} </td>
				<td style="background-color: #BDBDBD;" align="right"> {{ number_format($totBalance, (int)$currency->decimal_places, ',', '.') }} </td>
			</tr>
		</table>
		@php
			// Se agrega al array de cuenta mostradas el id de la cuenta
			array_push($shownAccounts, $record[0]['account']['id']);

			$ForAssets = false;
		@endphp
	@endif
	<br><br>

@endforeach