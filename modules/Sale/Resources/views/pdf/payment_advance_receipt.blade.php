<table cellspacing="1" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td style="font-size:9rem;" width="33%">
				<strong> Recibo de Anticipo </strong> {{$SalePayment->id}}
			</td>
			<br>
		</tr>
		@if ($SalePayment->type_person == 'Natural')
			<tr>
				<td style="font-size:9rem;" width="33%">
					<strong> Nombre del cliente </strong> {{$SalePayment->total_amount}}
				</td>
				<br>
			</tr>
			<tr>
				<td style="font-size:9rem; " width="33%">
					<strong> Identificación </strong> {{ $SalePayment->total_amount}}
				</td>
			</tr>
		@endif
		@if ($SalePayment->type_person == 'Jurídica')
			<tr>
				<td style="font-size:9rem;" width="33%">
					<strong> Nombre de la empresa </strong> {{$SalePayment->total_amount}}
				</td>
				<br>
			</tr>
			<tr>
				<td style="font-size:9rem; " width="33%">
					<strong> RIF </strong> {{ $SalePayment->total_amount}}
				</td>
			</tr>
		@endif
		<tr>
			<td style="font-size:9rem;" width="33%">
				<strong> Fecha de emisión </strong> {{ $SalePayment->total_amount }}
			</td>
			<br>
		</tr>
	</tbody>
</table>
