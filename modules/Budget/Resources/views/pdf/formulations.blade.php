<h4 style="font-size: 9rem;">EXPRESADO EN {{ $currencySymbol }}</h4>
<h4 style="font-size: 9rem;">Código del ente: {{ $institution['onapre_code'] }}</h4>
<h4 style="font-size: 9rem;">Denominación del ente: {{ $institution['name'] }}</h4>
<h4 style="font-size: 9rem;">Año Fiscal: {{ $fiscal_year }}</h4>
<br>
<table cellspacing="0" cellpadding="1" border="1">
    {{-- Header de la tabla --}}
    <tr>
        <th style="font-size: 9rem;" width="25%" align="center">Código</th>
        <th style="font-size: 9rem;" width="25%" align="center">Monto</th>
        <th style="font-size: 9rem;" width="25%" align="center">% Asignado</th>
        <th style="font-size: 9rem;" width="25%" align="center">Total</th>
    </tr>
</table>
<table cellspacing="0" cellpadding="1" border="0">
    @foreach($records as $record)
    <tr>
        <td style="font-size: 9rem; border-bottom: 1px solid #999; text-align: center;">{{ $record->code }}</td>
        <td style="font-size: 9rem; border-bottom: 1px solid #999; text-align: center;">{{ $record->total_real_amount }}</td>
        <td style="font-size: 9rem; border-bottom: 1px solid #999; text-align: center;">{{ $record->percentage }}</td>
        <td style="font-size: 9rem; border-bottom: 1px solid #999; text-align: center;">{{ $record->total }}</td>
    </tr>
    @endforeach
</table>