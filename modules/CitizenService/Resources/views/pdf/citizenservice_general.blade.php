<table cellspacing="0" cellpadding="1" border="1">
    <tr align="center" valign="middle">
        <th width="10%">Fecha de solicitud</th>
        <th width="10%">Nombre del solicitante</th>
        <th width="10%">Cedula de identidad</th>
        <th width="10%">Correo electrónico</th>
        <th width="10%">Número de conctato</th>
        <th width="10%">Nombre de la institución</th>
        <th width="10%">Rif</th>
        <th width="10%">Dirección de la institución</th>
        <th width="20%">Sitio web</th>
    </tr>

    <tr align="C">
       <td width="10%"> {{ $field->date}} </td>

        <td width="10%"> {{ $field->first_name}} </td>
        <td width="10%">{{ $field->id_number}} </td>

        <td width="10%"> {{ $field->email}}</td>
        <td width="10%"> {{ $field->phone}}  </td>
        <td width="10%"> {{ $field->institution_name}}  </td>
        <td width="10%"> {{ $field->rif}}  </td>
        <td width="10%"> {{ $field->institution_address}}  </td>
        <td width="20%"> {{ $field->web}}  </td>


    </tr>

</table>
