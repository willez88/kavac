<template>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Registrar los Datos Profesionales</h6>

					<div class="card-btns">
						<a href="#" class="btn btn-sm btn-primary btn-custom" @click="redirect_back(route_list)"
						   title="Ir atrás" data-toggle="tooltip">
							<i class="fa fa-reply"></i>
						</a>
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
                </div>

				<div class="modal-footer">
	                <button type="button" @click="createRecord('payroll/professional-informations')"
	                	class="btn btn-primary btn-sm btn-round btn-modal-save">
	                	Guardar
		            </button>
		        </div>

			</div>
		</div>
	</div>
</template>
