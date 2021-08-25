<table cellspacing="0" cellpadding="1" border="0">
    <colgroup>
        <col span="1" style="width: 20%" />
        <col span="1" style="width: 20%" />
        <col span="1" style="width: 20%" />
        <col span="1" style="width: 20%" />
        <col span="1" style="width: 20%" />
    </colgroup>
    <thead>
        <tr style="background-color: #BDBDBD;">
            <th span="1">Trabajador</th>
            <th span="1">Fecha de ingreso a la institución</th>
            <th span="1">Años en la institución</th>
            <th span="1">Inicio del período vacacional</th>
            <th span="1">Fin del período vacacional</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($field as $record)
        <tr>
            <td>{{ $record->payrollStaff->first_name . $record->payrollStaff->last_name }}</td>
            <td>{{ $record->payrollStaff->payrollEmployment->start_date }}</td>
            <td>{{ now()->diffInYears($record->payrollStaff->payrollEmployment->start_date) }}</td>
            <td>{{ $record->start_date }}</td>
            <td>{{ $record->end_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>