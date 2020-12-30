@php
    $assignments = 0;
    $deductions  = 0;
    $total = 0;
@endphp

<table cellspacing="0" cellpadding="1" border="1">
    <tr align="C">
        <th width="25%">Trabajador</th>
        <th width="25%">Asignaciones</th>
        <th width="25%">Deducciones</th>
        <th width="25%">Total</th>
    </tr>

    @foreach($field as $record)

            <tr>
                <td width="25%"> {{ ($record->payrollStaff)? $record->payrollStaff->first_name . ' ' . $record->payrollStaff->last_name: ''}} </td>
                <td width="25%">
                    <span>
                        @foreach(json_decode($record->assignments) as $assignment)
                            <p><strong> Concepto: </strong> {{ $assignment->name }} </p>
                            <p><strong> Valor: </strong> {{ $assignment->value }} </p>
                        @endforeach
                    </span>
                </td>
                <td width="25%">
                    <span>
                        @foreach(json_decode($record->deductions) as $deduction)
                            <p><strong> Concepto: </strong> {{ $deductions->name }} </p>
                            <p><strong> Valor: </strong> {{ $deductions->value }} </p>
                        @endforeach
                    </span>
                </td>
                <td width="25%">
                    @foreach(json_decode($record->assignments) as $assignment)
                        @php 
                            $total += $assignment->value;
                        @endphp
                    @endforeach
                    @foreach(json_decode($record->deductions) as $deduction)
                        @php 
                            $total -= $deduction->value;
                        @endphp
                    @endforeach
                    <span> {{ $total }} </span>
                </td>
            </tr>

    @endforeach
    <br pagebreak="true" />
</table>
