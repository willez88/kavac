<table cellspacing="0" cellpadding="1" border="0">
  
    <tr><th></th></tr>

    <tr style="background-color: #BDBDBD;">
        <th width="50%">Trabajador</th>
        <th width="50%">¿Activo?</th>
    </tr>
    <tr>
        <td width="50%">
            {{
                $field->first_name
                    ? $field->first_name . ' ' . $field->last_name
                    : 'No definido'
            }}
        </td>
        <td width="50%">
            {{
                $field->payrollEmployment
                    ? $field->payrollEmployment->active
                        ? ($field->payrollEmployment->active ==  'true')
                            ? 'Si'
                            : 'No'
                        : 'No'
                    : 'No'
            }} </td>
    </tr>
    <tr><th></th></tr>
    <tr style="background-color: #BDBDBD;">
        <th width="50%">Correo institucional</th>
        <th width="50%">Cedula</th>
      
    </tr>
    <tr>
        <td width="50%">
            {{
                $field->institution_email
                    ? $field->institution_email
                    : 'No definido'
            }}
        </td>
        <td width="50%">
            {{
                $field->id_number
                    ? $field->id_number
                    : 'No definido'
            }}
        </td>
       
    </tr>
    <tr><th></th></tr>

</table>