@php
function format_code($value)
{
    return \date('d/m/y h:m:s', strtotime($value));
}
@endphp

{{-- Solicitudes de servicio --}}
@foreach($records as $service_request)
    <h3>Solicitud de servicio: {{ $service_request['code'] }}</h3>
    <h3>Fecha de la solicitud del servicio: {{ \date('d/m/y h:m:s', strtotime($service_request['created_at'])) }}</h3>
    {{-- Datos del Solicitante --}}
    <h4>Datos del Solicitante</h4>
    <table cellspacing="0" cellpadding="1" border="0.5">
        <thead>
            <tr>
                <th width="30%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Razón social o Nombre y apellido</th>
                <th width="20%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Correo electrónico</th>
                <th width="20%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Número de teléfono</th>
                <th width="30%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Actividad económica</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
                    {{ $service_request['sale_client']['name'] }}
                </td>
                <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
                    @foreach($service_request['sale_client']['sale_clients_email'] as $info)
                        {{ $info['email'] }}
                    @endforeach
                </td>
                <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
                    @foreach($service_request['sale_client']['phones'] as $phone)
                        @if($phone['type'] === 'M')
                            Móvil:
                        @elseif($phone['type'] === 'T')
                            Teléfono:
                        @elseif($phone['type'] === 'F')
                            Fax:
                        @endif

                        {{ $phone['extension'] ? ('+'.$phone['extension'].'-') : '' }}
                        {{ $phone['area_code'] }}-{{ $phone['number'] }}
                    @endforeach
                </td>
                <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
                    {{ $service_request['description'] }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="line-break"></div>

    {{-- Requerimientos del solicitante --}}
    <table cellspacing="0" cellpadding="1" border="0.5">
        <thead>
            <tr>
                <th width="100%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Requerimientos del solicitante</th>
            </tr>
        </thead>
        <tbody>
            @foreach($service_request['sale_service_requirement'] as $requirement)
                <tr>
                    <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
                        {{ $requirement['name'] }}
                    </td>
                </tr>
            @endforeach
            @if(count($service_request['sale_service_requirement']) == 0)
                <tr>
                    <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="center">
                        Sin requerimientos
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <h4>Solución tecnologica</h4>
    <table cellspacing="0" cellpadding="1" border="0.5">
        <thead>
            <tr>
                <th width="33%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Nombre del servicio</th>
                <th width="33%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Unidad o departamento</th>
                <th width="34%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Nombre y apellidos de personal especializado del servicio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($service_request['sale_goods'] as $sale_good)
                @foreach($sale_good as $service)
                    <tr>
                        <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
                            {{ $service->name }}
                        </td>
                        <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
                            {{ $service->department->name }}
                        </td>
                        <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
                            {{ $service->payrollStaff->first_name }} {{ $service->payrollStaff->last_name }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <div class="line-break"></div>

@endforeach

<style>
    .line-break{
        margin: 10px;
    }
</style>
