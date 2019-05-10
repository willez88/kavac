@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Nómina
@stop

@section('maproute-title')
	Datos Socioeconómicos
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Registrar los Datos Socioeconómicos</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! (!isset($socioeconomic_information))?Form::open($header):Form::model($socioeconomic_information, $header) !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
						<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div>
						<div class="row">
							<div class="col-md-4">
						        <div class="form-group {{ $errors->has('staff_id') ? ' has-error' : '' }} is-required">
									{!! Form::label('payroll_staff_id', 'Trabajador', []) !!}
						            {!! Form::select('payroll_staff_id',(isset($staffs))?$staffs:[], (isset($socioeconomic_information))?$socioeconomic_information->staff->full_name:null,
						                [
						                    'class' => 'form-control select2',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Seleccione al trabajador'
						                ]
						            ) !!}
						        </div>
						    </div>
							<div class="col-md-4">
						        <div class="form-group {{ $errors->has('marital_status_id') ? ' has-error' : '' }} is-required">
									{!! Form::label('marital_status_id', 'Estado Civil', []) !!}
						            {!! Form::select('marital_status_id',(isset($marital_status))?$marital_status:[], (isset($socioeconomic_information))?$socioeconomic_information->marital_status->name:null,
						                [
						                    'class' => 'form-control select2',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Seleccione el estado civil del trabajador',
											'onchange' => 'block_twosome_show_hide(this.value);'
						                ]
						            ) !!}
						        </div>
						    </div>
						</div>

						<div class="row d-none" id="block_twosome">
							<div class="col-md-4">
								<div class="form-group {{ $errors->has('full_name_twosome') ? ' has-error' : '' }} is-required">
									{!! Form::label('full_name_twosome', 'Nombres y apellidos de la pareja del trabajador', []) !!}
									{!! Form::text('full_name_twosome',(isset($socioeconomic_information))?$socioeconomic_information->name:old('full_name_twosome'),
										[
											'class' => 'form-control input-sm',
											'data-toggle' => 'tooltip',
											'title' => 'Indique los nombres y apellidos de la pareja del trabajador'
										]
									) !!}
								</div>
							</div>
							<div class="col-md-4">
						        <div class="form-group {{ $errors->has('id_number_twosome') ? ' has-error' : '' }} is-required">
						            {!! Form::label('id_number_twosome', 'Cédula de identidad de la pareja del trabajador', []) !!}
						            {!! Form::text('id_number_twosome',(isset($socioeconomic_information))?$socioeconomic_information->id_number:old('id_number_twosome'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique la cédula de identidad de la pareja del trabajador'
						                ]
						            ) !!}
						        </div>
						    </div>
							<div class="col-md-4">
						        <div class="form-group {{ $errors->has('birthdate_twosome') ? ' has-error' : '' }} is-required">
						            {!! Form::label('birthdate_twosome', 'Fecha de nacimiento de la pareja del trabajador', []) !!}
						            {!! Form::date('birthdate_twosome',(isset($socioeconomic_information))?$socioeconomic_information->birthdate_twosome:old('birthdate_twosome'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique la fecha de nacimiento de la pareja del trabajador'
						                ]
						            ) !!}
						        </div>
						    </div>
						</div>

						<hr>
						<div class="row">
							<div class="col-md-4">
								<h6 class="card-title">
									Hijos del Trabajador <i class="fa fa-plus-circle cursor-pointer" onclick="add_sons();"></i>
								</h6>
							</div>
						</div>

					</div>
					<div class="card-footer text-right">
						@include('layouts.form-buttons')
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop

@section('extra-js')
	<script>

		$(document).ready(function() {

		});

		/**
		 * Permite ocultar los campos de la pareja del trabajador
		 *
		 * @author  William Páez <wpaez@cenditel.gob.ve>
		 * @param    {integer} id ID del estado civil que indica el valor Casado(a)
		 */
		function block_twosome_show_hide(val)
		{
			if( val == 2)
			{
				$('#block_twosome').removeClass('d-none');
			}
			else
			{
				$('#block_twosome').addClass('d-none');
			}
		}

		var c = 0;
		function add_sons()
		{
			$('#form .card-body').append(' \
				<div class="row" id="son_'+c+'"> \
					<div class="col-md-3"> \
						<input type="text" name="full_name_son_'+c+'" class="form-control input-sm" placeholder="Nombres y Apellidos" required/> \
					</div> \
					<div class="col-md-3"> \
						<input type="text" name="id_number_son_'+c+'" class="form-control input-sm" placeholder="Cédula de Identidad" /> \
					</div> \
					<div class="col-md-3"> \
						<input type="date" name="birthdate_son_'+c+'" class="form-control input-sm" placeholder="Fecha de Nacimiento" required/> \
					</div> \
					<div class="col-md-3"> \
						<button class="btn btn-sm btn-danger btn-action" type="button" \
							title="Eliminar este dato" data-toggle="tooltip" onclick="remove_sons();"> \
							<i class="fa fa-minus-circle"></i> \
						</button> \
					</div> \
				</div>');
			c = c + 1;
		}

		function remove_sons()
		{
			if ( c > 0 )
			{
				c = c - 1;
				$('#son_'+c).remove();
			}
		}

	</script>
@endsection
