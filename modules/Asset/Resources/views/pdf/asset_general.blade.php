<table cellspacing="0" cellpadding="1" border="1">
    @foreach($assets as $asset)
        <tr align="C">
            
            <td width="3.91%"> {{ $asset->type_id }} </td>
            
            <td width="7.84%"> {{ $asset->category_id }} </td>
            <td width="7.84%"> {{ $asset->subcategory_id }} </td>
            <td width="7.84%"> {{ $asset->specific_category_id }} </td>
            <td width="10.83%"> {{ $asset->serial_inventario }} </td>
            <td width="51.99%" align="L"> {{ $asset->specific->name }}. {{ $asset->getDescription() }} </td>
            <td width="9.75%" align="R"> {{ $asset->value }} </td>
        
        </tr>
    @endforeach


</table>
