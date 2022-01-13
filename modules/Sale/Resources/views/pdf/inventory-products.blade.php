{{-- Productos --}}
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
        <th width="20%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Código</th>
        <th width="40%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Descripción</th>
        <th width="40%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Inventario</th>
    </tr>
    @foreach($inventory_products as $product)
        <tr>
            <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="center">
                {{ $product['code'] }}
            </td>
            <td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="left">
                <b>Nombre:</b> {{ $product['sale_setting_product']['name'] }}
                <br>
                <b>Descripción:</b> {{ $product['sale_setting_product']['description'] }}
                <br>
                <b>Valor:</b> {{ $product['unit_value'] }}
            </td>
            <td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="left">
                <b>Almacén:</b> {{ $product['sale_warehouse_institution_warehouse']['sale_warehouse']['name'] }}
                <br>
                <b>Existencia:</b> {{ $product['exist'] }}
                <br>
                <b>Reservados:</b> {{ $product['reserved'] }}
            </td>
        </tr>
    @endforeach
</table>