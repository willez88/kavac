<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Parámetros Generales</h6>
				<div class="card-btns">
					<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
					   data-toggle="tooltip">
    					<i class="now-ui-icons arrows-1_minimal-up"></i>
    				</a>
				</div>
			</div>
			{!! Form::model($model_setting, $header_setting) !!}
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<h6>Activar funciones de la aplicación</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Soporte Técnico</label>
								<div class="col-12">
									{!! Form::checkbox('support', true, 
										($model_setting->support!==null && $model_setting->support==true), [
										'id' => 'support', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Chat</label>
								<div class="col-12">
									{!! Form::checkbox('chat', true, 
										($model_setting->chat!==null && $model_setting->chat==true), [
										'id' => 'chat', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Notificaciones</label>
								<div class="col-12">
									{!! Form::checkbox('notify', true, 
										($model_setting->notify!==null && $model_setting->notify==true), [
										'id' => 'notify', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Banner en Reportes</label>
								<div class="col-12">
									{!! Form::checkbox('report_banner', true, 
										($model_setting->report_banner!==null && $model_setting->report_banner==true), [
										'id' => 'report_banner', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Multi Gestión (varias instituciones)</label>
								<div class="col-12">
									{!! Form::checkbox('multi_institution', true, 
										($model_setting->multi_institution!==null && $model_setting->multi_institution==true), [
										'id' => 'multi_institution', 'class' => 'form-control bootstrap-switch',
										'data-on-label' => 'SI', 'data-off-label' => 'NO'
									]) !!}
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Firma Electrónica</label>
								<div class="col-12">
									{!! Form::checkbox('digital_sign', true, 
										($model_setting->digital_sign!==null && $model_setting->digital_sign==true), [
										'id' => 'digital_sign', 'class' => 'form-control bootstrap-switch',
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