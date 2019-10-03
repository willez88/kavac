<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">
					Parámetros Generales
					@include('buttons.help', ['helpId' => 'GeneralParams', 'helpSteps' => [
						[
							'element' => '#card_general_params',
							'intro' => 'Opciones de configuración que permiten establecer los parámetros generales de la aplicación',
							'position' => 'top'
						],
						[
							'element' => '#switchSupport',
							'intro' => 'Habilita/Deshabilita la opción de soporte técnico en la aplicación',
							'position' => 'right'
						],
						[
							'element' => '#switchChat',
							'intro' => 'Habilita/Deshabilita la opción de un sistema de comunicación interna (chat)',
							'position' => 'right'
						],
						[
							'element' => '#switchNotify',
							'intro' => 'Habilita/Deshabilita la opción de notificaciones del sistema',
							'position' => 'right'
						],
						[
							'element' => '#switchBannerInReport',
							'intro' => 'Habilita/Deshabilita la opción de mostrar la imagen del banner de la institución en reportes',
							'position' => 'left'
						],
						[
							'element' => '#switchMultiInstitution',
							'intro' => 'Habilita/Deshabilita la opción de gestión para multiples instituciones',
							'position' => 'right'
						],
						[
							'element' => '#switchSign',
							'intro' => 'Habilita/Deshabilita la opción de firma electrónica en los procesos del
										sistema',
							'position' => 'right'
						],
						[
							'element' => '#switchAppMaintenance',
							'intro' => 'Habilita/Deshabilita la opción para colocar la aplicación en mantenimiento. Una vez activada esta opción, el sistema solo será accesible desde la dirección IP del usuario que la activo.',
							'position' => 'right'
						],
						[
							'element' => '#settingParamButtons',
							'intro' => 'Botones para ejecutar las acciones de limpiar, cancelar o guardar los datos del formulario',
							'position' => 'top'
						]
					]])
				</h6>
				<div class="card-btns">
					@include('buttons.previous', ['route' => url()->previous()])
					@include('buttons.minimize')
				</div>
			</div>
			{!! Form::open($header_parameters) !!}
				<div class="card-body" id="card_general_params">
					<div class="row">
						<div class="col-12">
							<h6>Activar funciones de la aplicación</h6>
						</div>
					</div>
					@include('layouts.form-errors')
					<div class="row">
						<div class="col-md-3" id="switchSupport">
							<div class="form-group">
								<label for="" class="control-label">Soporte Técnico</label>
								<div class="col-12 bootstrap-switch-mini">
									{!! Form::checkbox('support', true,
										(!is_null($paramSupport) && $paramSupport->p_value === 'true'), [
										'id' => 'support', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
						<div class="col-md-3" id="switchChat">
							<div class="form-group">
								<label for="" class="control-label">Chat</label>
								<div class="col-12 bootstrap-switch-mini">
									{!! Form::checkbox('chat', true,
										(!is_null($paramChat) && $paramChat->p_value === 'true'), [
										'id' => 'chat', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
						<div class="col-md-3" id="switchNotify">
							<div class="form-group">
								<label for="" class="control-label">Notificaciones</label>
								<div class="col-12 bootstrap-switch-mini">
									{!! Form::checkbox('notify', true,
										(!is_null($paramNotify) && $paramNotify->p_value === 'true'), [
										'id' => 'notify', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
						<div class="col-md-3" id="switchBannerInReport">
							<div class="form-group">
								<label for="" class="control-label">Banner en Reportes</label>
								<div class="col-12 bootstrap-switch-mini">
									{!! Form::checkbox('report_banner', true,
										(!is_null($paramReportBanner) && $paramReportBanner->p_value === 'true'), [
										'id' => 'report_banner', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
						<div class="col-md-3" id="switchMultiInstitution">
							<div class="form-group">
								<label for="" class="control-label">Multi Gestión (varias instituciones)</label>
								<div class="col-12 bootstrap-switch-mini">
									{!! Form::checkbox('multi_institution', true,
										(
											!is_null($paramMultiInstitution)
											&& $paramMultiInstitution->p_value === 'true'
										), [
										'id' => 'multi_institution', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
						<div class="col-md-3" id="switchSign">
							<div class="form-group">
								<label for="" class="control-label">Firma Electrónica</label>
								<div class="col-12 bootstrap-switch-mini">
									{!! Form::checkbox('digital_sign', true,
										(!is_null($paramDigitalSign) && $paramDigitalSign->p_value === 'true'), [
										'id' => 'digital_sign', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
						<div class="col-md-3" id="switchAppMaintenance">
							<div class="form-group">
								<label for="" class="control-label">Mantenimiento</label>
								<div class="col-12 bootstrap-switch-mini">
									{!! Form::checkbox('online', true,
										(!is_null($paramOnline) && $paramOnline->p_value === 'true'), [
										'id' => 'online', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer text-right">
					<div class="row">
						<div class="col-md-3 offset-md-9" id="settingParamButtons">
							@include('layouts.form-buttons')
						</div>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
