<table cellspacing="1" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td style="font-size:9rem;" width="33%">
				<strong> Factura</strong> {{$sale_bills->code}}
			</td>
			<br>
		</tr>
		@if ($sale_bills->type_person == 'Natural')
			<tr>
				<td style="font-size:9rem;" width="33%">
					<strong> Nombre del cliente </strong> {{$sale_bills->name}}
				</td>
				<br>
			</tr>
			<tr>
				<td style="font-size:9rem; " width="33%">
					<strong> Identificación </strong> {{ $sale_bills->id_number}}
				</td>
			</tr>
		@endif
		@if ($sale_bills->type_person == 'Jurídica')
			<tr>
				<td style="font-size:9rem;" width="33%">
					<strong> Nombre de la empresa </strong> {{$sale_bills->name}}
				</td>
				<br>
			</tr>
			<tr>
				<td style="font-size:9rem; " width="33%">
					<strong> RIF </strong> {{ $sale_bills->rif}}
				</td>
			</tr>
		@endif
		<tr>
			<td style="font-size:9rem;" width="33%">
				<strong> Fecha de emisión </strong> {{ $sale_bills->created_at }}
			</td>
			<br>
		</tr>
	</tbody>
</table>
<br><br>
{{-- Productos --}}
<table cellspacing="0" cellpadding="1" border="0">
	<tr>
		<th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Tipo de producto</th>
		<th width="15%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Producto</th>
		<th width="15%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Subservicio</th>
		<th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Precio unitario</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Cantidad de productos</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Moneda</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Total sin IVA</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">IVA</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Total</th>
	</tr>
	@foreach($sale_bills['sale_bill_products'] as $product)
		<tr>
			<td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="center">
				{{ $product['product_type'] }}
			</td>
			<td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="center">
				{{ $product['inventory_product_name'] ? $product['inventory_product_name'] : $product['sale_goods_to_be_traded_name'] }}
			</td>
			<td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="center">
				{{ $product['sale_list_subservices_name'] ? $product['sale_list_subservices_name'] : 'N/A' }}
			</td>
			<td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="center">
				{{ $product['value'] }}
			</td>
            <td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="center">
				{{ $product['quantity'] }}
			</td>
			<td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="center">
				{{ $product['currency_name'] }}
			</td>
			<td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="center">
				{{ $product['total_without_tax'] }}
			</td>
			<td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="center">
				{{ $product['total'] - $product['total_without_tax'] }}
			</td>
			<td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="center">
				{{ $product['total'] }}
			</td>
		</tr>
	@endforeach
</table>
<br>
<br>
<h4 align="right">Total sin IVA: {{ $sale_bills['bill_total_without_taxs'] }}</h4>
<h4 align="right">IVA: {{ $sale_bills['bill_taxs'] }}</h4>
<h4 align="right">Total: {{ $sale_bills['bill_totals'] }}</h4>