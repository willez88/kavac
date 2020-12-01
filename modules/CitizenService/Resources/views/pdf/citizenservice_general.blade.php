<table cellspacing="0" cellpadding="1" border="1">
    <tr align="center" valign="middle">
        <th width="3.91%">Fecha de solicitud</th>
        <th width="27.43%">Nombre del solicitante</th>
        <th width="10.83%">Cedula de identidad</th>
        <th width="51.99%">Correo electrónico</th>
        <th width="9.75%">Número de conctato</th>
        <th width="7.84%">Nombre de la institución</th>
        <th width="7.84%">Rif</th>
        <th width="7.84%">Dirección de la institución</th>
        <th width="7.84%">Sitio web</th>
    </tr>

    @foreach($citizenServiceRequest as $fields)
            <tr align="C">

                <td width="3.91%"> {{ ($fields->citizenservice)?($fields->citizenservice->first_name):($fields->first_name) }} </td>
                <td width="7.84%"> {{ ($fields->citizenservice)?($fields->citizenservice->id_numbe):($fields->id_numbe) }} </td>
                <td width="7.84%">  </td>
                <td width="7.84%">  </td>
                <td width="10.83%">  </td>
                <td width="51.99%" align="L">  </td>
                <td width="9.75%" align="R">  </td>

            </tr>
    @endforeach


</table>
