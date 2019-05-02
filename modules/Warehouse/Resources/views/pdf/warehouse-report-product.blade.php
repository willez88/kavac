@php  
    $height = $pdf->get_Y();
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

    @foreach($inventary_product as $inventary)
        @php 
            $height += $pdf->getStringHeight(34.625, $inventary->product->description,1);
        @endphp
        
        @if ($height > $pdf->get_checkBreak()+25)
            @php 
                $height = $pdf->get_Y() + $pdf->getStringHeight(34.625, $inventary->product->description);
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
                <td width="12.5%"> {{ $inventary->product->id }} </td>
                <td width="12.5%"> {{ $inventary->product->name  }} </td>
                <td width="25%"> {{ $inventary->product->description }} </td>
                <td width="12.5%"> {{ $inventary->warehouseInstitution->warehouse->name }} </td>
                <td width="12.5%"> {{ $inventary->exist }} </td>
                <td width="12.5%"> {{ $inventary->reserved }} </td>
                <td width="12.5%"> {{ $inventary->unit_value }} </td>
            
            </tr>

    @endforeach
</table>
