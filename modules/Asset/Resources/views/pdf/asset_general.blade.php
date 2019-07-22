@php
    $height = $pdf->get_Y();
    $total = 0;
@endphp

<table cellspacing="0" cellpadding="1" border="1">
    <tr align="center" valign="middle">
        <th colspan="4" width="27.43%">Clasificación</th>
        <th rowspan="2" width="10.83%">N° Identificación</th>
        <th rowspan="2" width="51.99%">Nombre y descripción del bien</th>
        <th rowspan="2" width="9.75%">Valor unitario</th>
    </tr>
    <tr>
        <th width="3.91%">Tipo</th>
        <th width="7.84%">Categoria</th>
        <th width="7.84%">SubCategoria</th>
        <th width="7.84%">Cat. Especific</th>
    </tr>

    @foreach($assets as $asset)
        @php
            $height += $pdf->getStringHeight(170, $asset->asset_specific_category->name . $asset->getDescription(),1);

        @endphp

        @if ($height > $pdf->get_checkBreak())
            <tr>
                <th width="90.25%" align="R">Total Van</th>
                <th width="9.75%"  align="R"> {{ $total }} </th>
            </tr>
            @php
                $height = $pdf->get_Y() + $pdf->getStringHeight(170, $asset->asset_specific_category->name . $asset->getDescription(),1);
            @endphp
            </table>

            <br pagebreak="true" />
            <table cellspacing="0" cellpadding="1" border="1">
                <tr align="center" valign="middle">
                    <th colspan="4" width="27.43%">Clasificación</th>
                    <th rowspan="2" width="10.83%">N° Identificación</th>
                    <th rowspan="2" width="51.99%">Nombre y descripción del bien</th>
                    <th rowspan="2" width="9.75%">Valor unitario</th>
                </tr>
                <tr>
                    <th width="3.91%">Tipo</th>
                    <th width="7.84%">Categoria</th>
                    <th width="7.84%">SubCategoria</th>
                    <th width="7.84%">Cat. Especific.</th>
                </tr>

                <tr>
                    <th width="90.25%" align="R">Total Vienen</th>
                    <th width="9.75%"  align="R"> {{ $total }} </th>
                </tr>
        @endif
            <tr align="C">

                <td width="3.91%"> {{ $asset->type_id }} </td>
                <td width="7.84%"> {{ $asset->category_id }} </td>
                <td width="7.84%"> {{ $asset->subcategory_id }} </td>
                <td width="7.84%"> {{ $asset->specific_category_id }} </td>
                <td width="10.83%"> {{ $asset->inventory_serial }} </td>
                <td width="51.99%" align="L"> {{ $asset->asset_specific_category->name }}. {{ $asset->getDescription() }} </td>
                <td width="9.75%" align="R"> {{ $asset->value }} </td>
                @php
                    $total +=$asset->value
                @endphp

            </tr>
    @endforeach
    <tr align="R">

        <th width="90.25%">Total</th>
        <th width="9.75%">{{$total}}</th>
    </tr>


</table>
