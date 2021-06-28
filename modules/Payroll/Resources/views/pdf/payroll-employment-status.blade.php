<table cellspacing="0" cellpadding="1" border="0">
  
    <tr><th></th></tr>

    <tr style="background-color: #BDBDBD;">
        <th width="50%">Trabajador</th>
        <th width="50%">¿Activo?</th>
    </tr>
    <tr>
        <td width="50%">
            {{
                $field->payrollStaff
                ? $field->payrollStaff->first_name . ' ' . $field->payrollStaff->last_name
                : 'No definido'
            }}
        </td>
        <td width="50%"> {{ $field->active }} </td>
    </tr>
    <tr><th></th></tr>
    <tr style="background-color: #BDBDBD;">
        <th width="50%">Correo institucional</th>
        <th width="50%">Cedula</th>
      
    </tr>
    <tr>
        <td width="50%"> {{ $field->payrollEmployment->institution_email }} </td>
        <td width="50%"> {{    $field->payrollStaff
                ? $field->payrollStaff->id_number
                : 'No definido'}} </td>
       
    </tr>
    <tr><th></th></tr>

</table>