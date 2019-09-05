<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Parámetros Generales</h6>
				<div class="card-btns">
					@include('buttons.previous', ['route' => url()->previous()])
					@include('buttons.minimize')
				</div>
			</div>
			{!! Form::open($header_parameters) !!}
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<h6>Activar funciones de la aplicación</h6>
						</div>
					</div>
					@include('layouts.form-errors')
					<div class="row">
						<div class="col-md-3">
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
						<div class="col-md-3">
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
						<div class="col-md-3">
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
						<div class="col-md-3">
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
						<div class="col-md-3">
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
						<div class="col-md-3">
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
						<div class="col-md-3">
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
					@include('layouts.form-buttons')
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
