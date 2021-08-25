<table cellspacing="0" cellpadding="1" border="0">
    <colgroup>
        <col span="1" style="width: auto" />
        <col span="1" style="width: auto" />
        <col span="1" style="width: auto" />
        <col span="1" style="width: auto" />
        <col span="1" style="width: auto" />
    </colgroup>
    <thead>
        <tr style="background-color: #BDBDBD;">
            <th span="1">Trabajador</th>
            <th span="1">Fecha de ingreso a la institución</th>
            <th span="1">Años en la institución</th>
            <th span="1">Período Vacacional</th>
            <th span="1">Días por antiguedad</th>
            <th span="1">Días Solicitados</th>
            <th span="1">Días pendientes</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($field as $record)
        <tr>
            <td>{{ $record->payrollStaff->first_name . $record->payrollStaff->last_name }}</td>
            <td>{{ $record->payrollStaff->payrollEmployment->start_date }}</td>
            <td>{{ now()->diffInYears($record->payrollStaff->payrollEmployment->start_date) }}</td>
            <td>{{ $record->vacation_period_year }}</td>
            <td>{{ $record->days_old }}</td>
            <td>{{ $record->days_requested }}</td>
            <td>{{ $record->pending_days }}</td>
        </tr>
        @endforeach
    </tbody>
</table>