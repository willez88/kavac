<table cellspacing="1" cellpadding="0" border="1">
	<tbody>
		<tr>
			<td style="font-size:9rem;" width="25%">
				<strong> Fecha y hora</strong>: <br> {{ $requirement->created_at }}
			</td>
			<td style="font-size:9rem;" width="25%"> <strong>Institución</strong>: {{ $requirement->institution['name'] }} </td>
			<td style="font-size:9rem;" width="25%">
				<strong> Unidad contratante</strong>: <br> {{ $requirement->contratingDepartment['name']}}
			</td>
			<td style="font-size:9rem;" width="25%">
				<strong> Unidad usuaria</strong>: <br> {{ $requirement->userDepartment['name'] }}
			</td>
		</tr>
		<br>
		<tr>
			<td style="font-size:9rem;" width="25%">
				<strong> Ejercicio económico</strong>: <br> {{ $requirement->fiscalYear['year'] }}
			</td>
			<td style="font-size:9rem;" width="25%">
				<strong> Tipo</strong>: <br> {{ $requirement->purchaseSupplierObject['name'] }}
			</td>
			<td style="font-size:9rem;" width="50%">
				<strong> Descripcion</strong>: <br> {{ $requirement->description }}
			</td>
		</tr>
	</tbody>
</table>
<br><br>
{{-- Cuentas patrimoniales --}}
<table cellspacing="1" cellpadding="1" border="0.1">
	<tr>
		<th width="25%" style="font-size:9rem; background-color: #BDBDBD;" align="center">PRODUCTO</th>
		<th width="45%" style="font-size:9rem; background-color: #BDBDBD;" align="center">ESPECIFICACIONES</th>
		<th width="15%" style="font-size:9rem; background-color: #BDBDBD;" align="center">CANTIDAD</th>
		<th width="15%" style="font-size:9rem; background-color: #BDBDBD;" align="center">UNIDAD DE MEDIDA</th>
	</tr>
	@foreach($requirement['purchaseRequirementItems'] as $product)
		<tr>
			<td style="font-size: 8rem;" align="left">
				{{' '.$product['name'] }}
			</td>
			<td style="font-size:9rem;" align="left">
				{!! $product['description'] !!}
			</td>
			<td style="font-size:9rem;" align="right">
				{{' '.$product['quantity'] }}
			</td>
			<td style="font-size:9rem;">
				{{' '.$product['warehouseProduct']['measurementUnit']['name'] }}
			</td>
		</tr>
	@endforeach
</table>