@php  $total=0;
@endphp

<table cellspacing="0" cellpadding="1" border="1">
    <tr align="C">

        <th>Código</th>
        <th>Proveedor</th>
        <th>Año de Adquisición</th>
        <th>Estatus de uso</th>
        <th>Serial</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Valor</th>


    </tr>
    @foreach($assets as $asset)
        <tr>
            <td> {{ $asset->serial_inventario }} </td>
            <td> {{ $asset->proveedor_id }} </td>
            <td> {{ $asset->purchase_year }} </td>
            <td> {{ $asset->status->name }} </td>
            <td> {{ $asset->serial }} </td>
            <td> {{ $asset->marca }} </td>
            <td> {{ $asset->model }} </td>
            <td> {{ $asset->value }} </td>
            @php $total +=$asset->value
            @endphp
        
        </tr>
    @endforeach
    <tr align="R">

        <th width="87.5%">Total</th>
        <th>{{$total}}</th>
    </tr>


</table>
