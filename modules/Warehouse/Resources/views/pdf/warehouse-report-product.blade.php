@php  
    $height = $pdf->getPositionY();
    $total = 0;
@endphp

<table cellspacing="0" cellpadding="1" border="1">
    <tr align="C">
        <th width="12.5%">Código</th>
        <th width="12.5%">Producto</th>
        <th width="25%">Descripción</th>
        <th width="12.5%">Almacén</th>
        <th width="12.5%">Existencia</th>
        <th width="12.5%">Reservados</th>
        <th width="12.5%">Valor Unitario</th>
    </tr>

    @foreach($inventory_product as $inventory)
        @php 
            $height += $pdf->getStringHeight(34.625, $inventory->warehouseProduct->description, 1);
        @endphp
        
        @if ($height > $pdf->getCheckBreak()+25)
            @php 
                $height = $pdf->getPositionY() + $pdf->getStringHeight(34.625, $inventory->warehouseProduct->description);
            @endphp
        </table>

        <br pagebreak="true" />

        <table cellspacing="0" cellpadding="1" border="1">
            <tr align="C">
                <th width="12.5%">Código</th>
                <th width="12.5%">Producto</th>
                <th width="25%">Descripción</th>
                <th width="12.5%">Almacén</th>
                <th width="12.5%">Existencia</th>
                <th width="12.5%">Reservados</th>
                <th width="12.5%">Valor Unitario</th>
            </tr>

            @endif

            <tr>
                <td width="12.5%"> {{ $inventory->code }} </td>
                <td width="12.5%"> {{ $inventory->warehouseProduct->name  }} </td>
                <td width="25%"> {{ $inventory->warehouseProduct->description }} </td>
                <td width="12.5%"> {{ $inventory->warehouseInstitutionWarehouse->warehouse->name }} </td>
                <td width="12.5%"> {{ $inventory->exist }} </td>
                <td width="12.5%"> {{ $inventory->reserved }} </td>
                <td width="12.5%"> {{ $inventory->unit_value .' '. $inventory->currency->symbol }} </td>
            
            </tr>

    @endforeach
</table>
