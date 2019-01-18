@php
    $height = $pdf->get_Y();
    $deben=0;
    $haber=0;                
@endphp
<table cellspacing="0" cellpadding="1" border="1">
    <tr align="L">

        <th width="65%">Asiento Contable</th>
        <th width="35%">Ref. :</th>
    </tr>        
    <tr>
        <th width="17.5%">Fecha</th>
        <th width="17.5%">Código</th>
        <th width="30%">Nombre de la Cuenta</th>
        <th width="17.5%">Cargos</th>
        <th width="17.5%">Abonos</th>
    </tr>
    @foreach($assets as $asset)
        
        @php 
            $height += $pdf->getStringHeight(25, $asset->created_at,1);
        @endphp
        
        @if ($height > $pdf->get_checkBreak())
            @php 
                $height = $pdf->get_Y() + $pdf->getStringHeight(25, $asset->created_at);
            @endphp
            <tr>
                <th width="65%" align="R">Total Van</th>
                <th width="17.5%"> {{ $deben }} </th>
                <th width="17.5%"> {{ $haber }} </th>
            </tr>
        </table>

            
            <br pagebreak="true" />
            <table cellspacing="0" cellpadding="1" border="1">
            <tr align="L">
                <th width="65%">Asiento Contable</th>
                <th width="35%">Ref. :</th>
            </tr>        
            <tr>
                <th width="17.5%">Fecha</th>
                <th width="17.5%">Código</th>
                <th width="30%">Nombre de la Cuenta</th>
                <th width="17.5%">Cargos</th>
                <th width="17.5%">Abonos</th>
            </tr>
            <tr>
                <th width="65%" align="R">Total Vienen</th>
                <th width="17.5%"> {{ $deben }} </th>
                <th width="17.5%"> {{ $haber }} </th>

            </tr>
        @endif

        <tr>
            <td width="17.5%"> {{ $asset->created_at }} </td>
            <td width="17.5%"> {{ $asset->serial_inventario }}</td>
            <td width="30%"> </td>
            <td width="17.5%"> </td>
            <td width="17.5%"></td>
            
        
        </tr>
    @endforeach
    <tr>
        <th width="17.5%"></th>
        <th width="17.5%"></th>
        <th width="30%">Total Asiento</th>
        <th width="17.5%">Total Cargos</th>
        <th width="17.5%">Total Abonos</th>
    </tr>

    <tr>
        <th> Explicación: </th>
    </tr>
    <tr>
        <th width="65%"></th>
        <th width="17.5%">Preparado</th>
        <th width="17.5%">Revisado</th>

    </tr>
    <tr>
        <th></th>
        <th width="17.5%">TRC</th>
        <th width="17.5%"></th>

    </tr>


</table>