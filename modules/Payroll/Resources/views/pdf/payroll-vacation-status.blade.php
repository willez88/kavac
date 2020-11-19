<table cellspacing="0" cellpadding="1" border="0">
    <tr style="background-color: #BDBDBD;">
        <th width="50%">Código de la solicitud</th>
        <th width="50%">Fecha de la solicitud</th>
    </tr>
    <tr>
        <td width="50%"> {{ $field->code }} </td>
        <td width="50%"> {{ $field->created_at }} </td>
    </tr>
    <tr><th></th></tr>

    <tr style="background-color: #BDBDBD;">
        <th width="50%">Trabajador</th>
        <th width="50%">Año del períoo vacacional</th>
    </tr>
    <tr>
        <td width="50%">
            {{
                $field->payrollStaff
                ? $field->payrollStaff->first_name . ' ' . $field->payrollStaff->last_name
                : 'No definido'
            }}
        </td>
        <td width="50%"> {{ $field->vacation_period_year }} </td>
    </tr>
    <tr><th></th></tr>
    <tr style="background-color: #BDBDBD;">
        <th width="50%">Período</th>
        <th width="50%">Días solicitados</th>
    </tr>
    <tr>
        <td width="50%"> {{ $field->start_date . ' - ' . $field->end_date }} </td>
        <td width="50%"> {{ $field->days_requested }} </td>
    </tr>
</table>