@php
function format_code($value)
{
    return \date('d/m/y h:m:s', strtotime($value));
}
@endphp

{{-- Productos --}}
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
        <th width="20%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Código</th>
        <th width="20%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Fecha</th>
        <th width="25%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Nombre o Razón social del cliente</th>
        <th width="25%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Descripción del servicio</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Estatus solicitud</th>
    </tr>
    @foreach($records as $service_request)
        <tr>
            <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="center">
                {{ $service_request['code'] }}
            </td>
            <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="center">
                {{ \date('d/m/y h:m:s', strtotime($service_request['created_at'])) }}
            </td>
            <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="center">
                {{ $service_request['organization'] }}
            </td>
            <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="center">
                {{ $service_request['description'] }}
            </td>
            <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="center">
                {{ $service_request['status'] }}
            </td>
        </tr>
    @endforeach
</table>
