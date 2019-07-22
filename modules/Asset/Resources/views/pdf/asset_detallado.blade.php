@php  
    $height = $pdf->get_Y();
    $total = 0;
@endphp

<table cellspacing="0" cellpadding="1" border="1">
    <tr align="C">
        <th width="12.5%">Código</th>
        <th width="12.5%">Proveedor</th>
        <th width="12.5%">Año de Adquisición</th>
        <th width="12.5%">Estatus de uso</th>
        <th width="12.5%">Serial</th>
        <th width="12.5%">Marca</th>
        <th width="12.5%">Modelo</th>
        <th width="12.5%">Valor</th>
    </tr>

    @foreach($assets as $asset)
        @php 
            $height += $pdf->getStringHeight(34.625, $asset->asset_status->name,1);
        @endphp
        
        @if ($height > $pdf->get_checkBreak()+25)
            <tr>
                <th width="87.5%" align="R">Total Van</th>
                <th width="12.5%"> {{ $total }} </th>
            </tr>
            @php 
                $height = $pdf->get_Y() + $pdf->getStringHeight(34.625, $asset->asset_status->name);
            @endphp
        </table>

        <br pagebreak="true" />

        <table cellspacing="0" cellpadding="1" border="1">
            <tr align="C">
                <th width="12.5%">Código</th>
                <th width="12.5%">Proveedor</th>
                <th width="12.5%">Año de Adquisición</th>
                <th width="12.5%">Estatus de uso</th>
                <th width="12.5%">Serial</th>
                <th width="12.5%">Marca</th>
                <th width="12.5%">Modelo</th>
                <th width="12.5%">Valor Unitario</th>
            </tr>

            <tr>
                <th width="87.5%" align="R">Total Vienen</th>
                <th width="12.5%"> {{ $total }} </th>
            </tr>
            @endif

            <tr>
                <td width="12.5%"> {{ $asset->inventory_serial }} </td>
                <td width="12.5%"> </td>
                <td width="12.5%"> {{ $asset->acquisition_year }} </td>
                <td width="12.5%"> {{ $asset->asset_status->name }} </td>
                <td width="12.5%"> {{ $asset->serial }} </td>
                <td width="12.5%"> {{ $asset->marca }} </td>
                <td width="12.5%"> {{ $asset->model }} </td>
                <td width="12.5%"> {{ $asset->value }} </td>
                @php 
                    $total +=$asset->value;
                @endphp
            
            </tr>

    @endforeach
    <tr align="R">

        <th width="87.5%">Total</th>
        <th width="12.5%">{{$total}}</th>
    </tr>


</table>
