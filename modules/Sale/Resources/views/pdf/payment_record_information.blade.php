<h4>Datos del Solicitante</h4>

@php
function format_code($value)
{
    return \date('d/m/y h:m:s', strtotime($value));
}
@endphp
<table cellspacing="1" cellpadding="0" border="0">
	<tbody>
		@if ($SalePayment->advance_define_attributes == '1')
			<tr>
				<td style="font-size:9rem;" width="33%">
					<strong> Pago corresponde a un anticipo </strong>SI
				</td>
				<br>
			</tr>
		@endif
		@if ($SalePayment->advance_define_attributes == '0')
			<tr>
				<td style="font-size:9rem;" width="33%">
					<strong> Pago corresponde a un anticipo </strong>NO
				</td>
				<br>
			</tr>
		@endif
		<tr>
			<td style="font-size:9rem;" width="33%">
				<strong> Fecha de emisión </strong> {{ $SalePayment->payment_date }}
			</td>
			<br>
		</tr>
		<tr>
			<td style="font-size:9rem;" width="33%">
				<strong> Monto total a pagar </strong> {{ $SalePayment->total_amount }}
			</td>
			<br>
		</tr>	
		<tr>
			<td style="font-size:9rem;" width="33%">
				<strong> Numero de referencia </strong> {{ $SalePayment->reference_number }}
			</td>
			<br>
		</tr>	
	</tbody>
</table>

<div class="line-break"></div>

<style>
    .line-break{
        margin: 10px;
    }
</style>