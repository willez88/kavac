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
            $height += $pdf->getStringHeight(34.625, $asset->status->name,1);
        @endphp
        
        @if ($height > $pdf->get_checkBreak()+25)
            <tr>
                <th width="87.5%" align="R">Total Van</th>
                <th width="12.5%"> {{ $total }} </th>
            </tr>
            @php 
                $height = $pdf->get_Y() + $pdf->getStringHeight(34.625, $asset->status->name);
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
                <td width="12.5%"> {{ $asset->serial_inventario }} </td>
                <td width="12.5%"> {{ $asset->proveedor_id  }} </td>
                <td width="12.5%"> {{ $asset->purchase_year }} </td>
                <td width="12.5%"> {{ $asset->status->name }} </td>
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
