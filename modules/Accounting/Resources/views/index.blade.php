
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Operaciones en modulo de contabilidad</h6>
				<div class="card-btns">
					@include('buttons.minimize')
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<span class="text-muted">
							Acceso a infomación de los ultimos asientos contables.
						</span>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-12">
						<dashboard-accounting-info />
					</div>
				</div>
				<hr>
			</div>
		</div>
	</div>

	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">reportes de contabilidad</h6>
				<div class="card-btns">
					@include('buttons.minimize')
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						<span class="text-muted">
							Información de las fechas en las que se han genera reportes del modulo de contabilidad.
						</span>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-12">
						<dashboard-accounting-report-histories />
					</div>
				</div>
				<hr>
			</div>
		</div>
	</div>
</div>