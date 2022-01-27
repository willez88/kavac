@php
    function format_code($value)
    {
        return \date('d/m/y h:m:s', strtotime($value));
    }
@endphp

{{-- Facturas --}}
@foreach($records as $sale_bills)
    <h3>Factura: {{ $sale_bills['code'] }}</h3>
    <h3>Fecha de emisión de la factura: {{ \date('d/m/y h:m:s', strtotime($sale_bills['created_at'])) }}</h3>

    {{-- Datos del Solicitante --}}
    <h4>Datos del Solicitante</h4>
    <table cellspacing="0" cellpadding="1" border="0.5">
        <thead>
            <tr>
                <th width="20%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Tipo de persona</th>
                <th width="20%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Razón social o Nombre y apellido</th>
                <th width="20%" style="font-size:9rem; background-color: #BDBDBD;" align="center">RIF o Identificación</th>
                <th width="20%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Número de teléfono</th>
                <th width="20%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Correo electrónico</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
                    {{ $sale_bills['type_person'] }}
                </td>
                <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
                    {{ $sale_bills['name'] }}
                </td>
                <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
                    @if ($sale_bills['type_person'] == 'Jurídica')
                        <strong> RIF </strong> {{ $sale_bills['rif'] }}
                    @endif
                    @if ($sale_bills['type_person'] == 'Natural')
                        <strong> RIF </strong> {{ $sale_bills['id_number'] }}
                    @endif
                </td>
                <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
                    {{ $sale_bills['phone'] }}
                </td>
                <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
                    {{ $sale_bills['email'] }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="line-break"></div>

    {{-- Complementarios --}}
    <h4>Complementarios</h4>
    <table cellspacing="0" cellpadding="1" border="0.5">
        <thead>
            <tr>
                <th width="100%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Forma de cobro</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
                    {{ $sale_bills['sale_form_payment']['name_form_payment'] }}
                </td>
            </tr>
        </tbody>
    </table>

    <h4>Productos/Servicios Solicitados</h4>
    <table cellspacing="0" cellpadding="1" border="0.5">
        <thead>
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
        </thead>
        <tbody>
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
        </tbody>
    </table>
    <br /><br />
    <table cellspacing="1" cellpadding="0" border="0">
        <tbody>
            <tr>
                <td style="font-size:9rem;" width="33%">
                    <strong>Total sin iva: </strong>{{ $sale_bills['bill_total_without_taxs'] }}
                </td>
                <td style="font-size:9rem;" width="33%">
                    <strong>IVA: </strong>{{ $sale_bills['bill_taxs'] }}
                </td>
                <td style="font-size:9rem;" width="33%">
                    <strong>Total a pagar: </strong>{{ $sale_bills['bill_totals'] }}
                </td>
            </tr>
        </tbody>
    </table>
    <div class="line-break"></div>
@endforeach

<style>
    .line-break{
        margin: 10px;
    }
</style>