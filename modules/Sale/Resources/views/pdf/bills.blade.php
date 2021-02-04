<table cellspacing="1" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td style="font-size:9rem;" width="33%">
				<strong> Número</strong> {{$sale_bills->code}}
			</td>
			<br>
		</tr>
		<tr>
			<td style="font-size:9rem;" width="33%">
				<strong> Fecha y hora</strong> {{ $sale_bills->created_at }}
			</td>
			<br>
		</tr>
		<tr>
			<td style="font-size:9rem; " width="33%">
				<strong> RIF</strong> {{ $sale_bills->saleClient['rif']}}
			</td>
		</tr>
			<!-- <td style="font-size:9rem;" width="25%">
				<strong> Nombre del cliente</strong>: <br> {{ $sale_bills->saleClient['name_client'] }}
			</td> -->
	</tbody>
</table>
<br><br>
{{-- Productos --}}
<table cellspacing="0" cellpadding="1" border="0">
	<tr>
		<th width="25%" style="font-size:9rem; background-color: #BDBDBD;" align="center">NOMBRE PRODUCTO</th>
		<th width="35%" style="font-size:9rem; background-color: #BDBDBD;" align="center">DESCRIPCIÓN</th>
		<th width="15%" style="font-size:9rem; background-color: #BDBDBD;" align="center">SOLICITADOS</th>
		<th width="15%" style="font-size:9rem; background-color: #BDBDBD;" align="center">VALOR POR UNIDAD</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">VALOR TOTAL</th>
	</tr>
	@foreach($sale_bills['saleBillInventoryProduct'] as $product)
		<tr>
			<td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
				{{' '.$product['saleWarehouseInventoryProduct']['SaleSettingProduct']['name'] }}
			</td>
			<td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="left">
				{!! $product['saleWarehouseInventoryProduct']['SaleSettingProduct']['description'] !!}
			</td>
			<td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="right">
				{{' '.$product['quantity'] }}
			</td>
			<td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="right">
				{{' '.$product['saleWarehouseInventoryProduct']['unit_value'] }}
			</td>
            <td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="right">
				{{' '.$product['saleWarehouseInventoryProduct']['unit_value']*$product['quantity'] }}
			</td>
		</tr>
	@endforeach
</table>