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
			{!! Form::open($header) !!}
				<div class="card-body" style="min-height: 0px">
					@include('layouts.form-errors')
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="" class="control-label">Multi Almacén (varios almacenes)</label>
								<div class="col-12">
									{!! Form::checkbox('multi_warehouse', true, 
										(!is_null($paramMultiWarehouse) && $paramMultiWarehouse->p_value === 'true'), [
										'id' => 'multi_warehouse', 'class' => 'form-control bootstrap-switch',
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

