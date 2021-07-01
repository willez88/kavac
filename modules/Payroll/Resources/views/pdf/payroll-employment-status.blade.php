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
        <th width="25%">Correo Personal</th>
        <th width="20%">Cedula</th>
	<th width="30%">Discapacidad</th>
	<th width="25%">Licencia</th>
      
    </tr>
    <tr>
        <td width="25%">
            {{
                $field->email
                    ? $field->email
                    : 'No definido'
            }}
        </td>

        <td width="20%">
            {{
                $field->id_number
                    ? $field->id_number
                    : 'No definido'
            }}
        </td>

	    <td width="30%">
            {{
                  $field->payrollDisability
                    ? $field->payrollDisability->name
                    : 'No'
            }}
        </td>

        <td width="30%">
            {{
                  $field->payrollLicensedegree
                    ? $field->payrollLicensedegree->name
                    : 'No'
            }}
        </td>

       
    </tr>
    <tr><th></th></tr>
    <tr style="background-color: #BDBDBD;">
    <th width="33%">Estado civil</th>
    <th width="33%">Hijos</th>
	<th width="33%">Pareja</th>
	
      
    </tr>
    <tr>
        <td width="33%">
                {{
                    $field->payrollSocioeconomic
                        ?  $field->payrollSocioeconomic->MaritalStatus
	 		                ?  $field->payrollSocioEconomic->MaritalStatus->name
 			                : 'No definido'
                        : 'No definido'
            }}
         </td>

        <td width="33%">
            {{
                $field->payrollSocioeconomic
                    ? $field->payrollSocioeconomic->payrollChildren
                        ? $field->payrollSocioeconomic->payrollChildren->firts_name
                        : 'No definido'
                    : 'No definido'
            }}
        </td>

	    <td width="33%">
            {{
                    $field->payrollSocioeconomic
                        ?  $field->payrollSocioeconomic->full_name_twosome
                        : 'No definido'
            }}
        </td>



       
    </tr>
    <tr><th></th></tr>
   <tr style="background-color: #BDBDBD;">
        <th width="25%">Fecha de ingreso a la administración pública</th>
        <th width="25%">Fecha de ingreso a la institución</th>
	    <th width="25%">Tipo de Cargo</th>
	    <th width="25%">Cargo</th>
      
    </tr>
    <tr>
        <td width="25%">
            {{
                $field->payrollEmployment
                    ? $field->payrollEmployment->start_date_apn
                    : 'No definido'
            }}
        </td>
        <td width="25%">
            {{
                $field->payrollEmployment
                    ? $field->payrollEmployment->start_date
                    : 'No definido'
            }}
        </td>

	    <td width="25%">
            {{
                      $field->payrollEmployment
                    ? $field->payrollEmployment->payrollPositionType
			? $field->payrollEmployment->payrollPositionType->name
			: 'No definido'
                    : 'No definido'
            }}
        </td>

	    <td width="25%">
            {{
                $field->payrollEmployment
                    ? $field->payrollEmployment->payrollPosition
			? $field->payrollEmployment->payrollPosition->name
			: 'No definido'
                    : 'No definido'
            }}
        </td>

       
    </tr>
    <tr><th></th></tr>
    <tr style="background-color: #BDBDBD;">
        <th width="33%">Tipo de personal</th>
        <th width="33%">Tipo de contrato</th>
	    <th width="33%">Departamento</th>

      
    </tr>
    <tr>

	    <td width="33%">
            {{
                      $field->payrollEmployment
                    ? $field->payrollEmployment->payrollStaffType
			? $field->payrollEmployment->payrollStaffType->name
			: 'No definido'
                    : 'No definido'
            }}
        </td>


	    <td width="33%">
            {{
                $field->payrollEmployment
                    ? $field->payrollEmployment->payrollContractType
			            ? $field->payrollEmployment->payrollContractType->name
			            : 'No definido'
                    : 'No definido'
            }}
        </td>

	    <td width="33%">
            {{
                $field->payrollEmployment
                    ? $field->payrollEmployment->Department
			            ? $field->payrollEmployment->Department->name
			            : 'No definido'
                    : 'No definido'
            }}
        </td>

       
    </tr>
    <tr><th></th></tr>

</table>
