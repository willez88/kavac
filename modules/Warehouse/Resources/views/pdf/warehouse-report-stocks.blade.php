<table cellspacing="0" cellpadding="1" border="1">
    <tr align="C">
        <th width="70%">Producto</th>
        <th width="15%">Mínimo</th>
        <th width="15%">Máximo</th>
    </tr>

    @foreach($fields as $field)
        <tr>
            <td width="70%"> {{ $field->warehouseInventoryProduct
                ? $field->warehouseInventoryProduct->warehouseProduct
                    ? $field->warehouseInventoryProduct->warehouseProduct->name
                    : ''
                : ''  }} </td>
            <td width="15%"> {{ $field->warehouseInventoryProduct
                ? $field->warehouseInventoryProduct->minimum
                : '' }} </td>
            <td width="15%"> {{ $field->warehouseInventoryProduct
                ? $field->warehouseInventoryProduct->maximum
                : '' }} </td>
        </tr>
    @endforeach
</table>
