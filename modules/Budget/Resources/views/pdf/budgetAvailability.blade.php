<h2 style="font-size: 9rem;" align="center">Información Presupuestaria {{ $initialDate }} HASTA {{ $finalDate }}</h2>
<h4 style="font-size: 9rem;">EXPRESADO EN {{ $currencySymbol }}</h4>
<h4 style="font-size: 9rem;">Código del ente: {{ $institution['onapre_code'] }}</h4>
<h4 style="font-size: 9rem;">Denominación del ente: {{ $institution['name'] }}</h4>
<h4 style="font-size: 9rem;">Año Fiscal: {{ $fiscal_year }}</h4>
<br>
<table cellspacing="0" cellpadding="1" border="1">
    {{-- Header de la tabla --}}
    <tr>
        <th style="font-size: 9rem;" width="25%" align="center">Partida Presupuestaria</th>
        <th style="font-size: 9rem;" width="25%" align="center">Monto Asignado</th>
        <th style="font-size: 9rem;" width="25%" align="center">% Asignado</th>
        <th style="font-size: 9rem;" width="25%" align="center">Monto Disponible</th>
    </tr>
</table>
<table cellspacing="0" cellpadding="1" border="0">
    @foreach($records as $record)
    @php
    $isRoot = substr_count($record['budgetAccount']['code'], '0') == 8;
    $styles = $isRoot ? 'font-weight: bold;' : '';

    @endphp
    <tr>
        <td style="font-size: 9rem; border-bottom: 1px solid #999; {{ $styles }}">{{ $record['budgetAccount']['denomination'] }}</td>
        <td style="font-size: 9rem; border-bottom: 1px solid #999;" align="right">{{ $record['total_year_amount'].' '.$currencySymbol }}</td>

        <td style="font-size: 9rem; border-bottom: 1px solid #999;" align="right">{{ $record['asigned_percentage'] }} %</td>
        <td style="font-size: 9rem; border-bottom: 1px solid #999;" align="right">{{ $record['amount_available'].' '.$currencySymbol }}</td>
    </tr>
    @endforeach
</table>