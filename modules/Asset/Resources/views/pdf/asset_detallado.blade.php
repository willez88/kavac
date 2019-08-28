@php  
    $height = $pdf->getPositionY();
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

    @foreach($assets as $fields)
        @php 
            $height += $pdf->getStringHeight(34.625, ($fields->asset)?($fields->assetStatus):($fields->assetStatus->name), 1);
        @endphp
        
        @if ($height > $pdf->getCheckBreak()+25)
            <tr>
                <th width="87.5%" align="R">Total Van</th>
                <th width="12.5%"> {{ $total }} </th>
            </tr>
            @php 
                $height = $pdf->getPositionY() + $pdf->getStringHeight(34.625, ($fields->asset)?($fields->assetStatus):($fields->assetStatus->name));
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
                <td width="12.5%"> {{ ($fields->asset)?($fields->asset->inventory_serial):($fields->inventory_serial) }} </td>
                <td width="12.5%"> </td>
                <td width="12.5%"> {{ ($fields->asset)?($fields->asset->acquisition_year):$fields->acquisition_year }} </td>
                <td width="12.5%"> {{ ($fields->asset)?($fields->assetStatus):$fields->assetStatus->name }} </td>
                <td width="12.5%"> {{ ($fields->asset)?($fields->asset->serial):$fields->serial }} </td>
                <td width="12.5%"> {{ ($fields->asset)?($fields->asset->marca):$fields->marca }} </td>
                <td width="12.5%"> {{ ($fields->asset)?($fields->asset->model):$fields->model }} </td>
                <td width="12.5%"> {{ ($fields->asset)?($fields->asset->value):$fields->value }} </td>
                @php 
                    $total += ($fields->asset)?($fields->asset->value):($fields->value);
                @endphp
            
            </tr>

    @endforeach
    <tr align="R">

        <th width="87.5%">Total</th>
        <th width="12.5%">{{$total}}</th>
    </tr>


</table>
