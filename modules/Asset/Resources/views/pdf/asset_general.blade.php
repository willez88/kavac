@php
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

    @foreach($assets as $fields)
            <tr align="C">

                <td width="3.91%"> {{ ($fields->asset)?($fields->asset->asset_type_id):($fields->asset_type_id) }} </td>
                <td width="7.84%"> {{ ($fields->asset)?($fields->asset->asset_category_id):($fields->asset_category_id) }} </td>
                <td width="7.84%"> {{ ($fields->asset)?($fields->asset->asset_subcategory_id):($fields->asset_subcategory_id) }} </td>
                <td width="7.84%"> {{ ($fields->asset)?($fields->asset->asset_specific_category_id):($fields->asset_specific_category_id) }} </td>
                <td width="10.83%"> {{ ($fields->asset)?($fields->asset->inventory_serial):($fields->inventory_serial) }} </td>
                <td width="51.99%" align="L"> {{ ($fields->asset)?($fields->asset->assetSpecificCategory->name):($fields->assetSpecificCategory->name) }}. {{ ($fields->asset)?($fields->asset->getDescription()):($fields->getDescription()) }} </td>
                <td width="9.75%" align="R"> {{ ($fields->asset)?($fields->asset->value):($fields->value) }} </td>
                @php
                    $total += ($fields->asset)?($fields->asset->value):($fields->value)
                @endphp

            </tr>
    @endforeach
    <tr align="R">

        <th width="90.25%">Total</th>
        <th width="9.75%">{{$total}}</th>
    </tr>


</table>
