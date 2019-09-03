@extends('payroll::layouts.master')

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
	Personal
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Datos Personales</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('payroll.staffs.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<payroll-staffs-list route_list="{{ url('payroll/staffs/show/vue-list') }}"
										  route_delete="{{ url('payroll/staffs') }}"
										  route_edit="{{ url('payroll/staffs/{id}/edit') }}"
										  route_show="{{ url('payroll/staffs/{id}') }}">
					</payroll-staffs-list>
				</div>
			</div>
		</div>
	</div>
@stop

@section('extra-js')
	<script type="text/javascript">
		var records;
		function openmodal($staff) {
			axios.get("/payroll/staffs/" + $staff).then(response => {
				records = response.data.record;
				$(".modal-body #code").val( records.code );
				$(".modal-body #first_name").val( records.first_name );
				$(".modal-body #last_name").val( records.last_name );
				$(".modal-body #nationality").val( records.nationality );
				$(".modal-body #id_number").val( records.id_number );
				$(".modal-body #passport").val( records.passport );
				$(".modal-body #email").val( records.email );
				$(".modal-body #birthdate").val( records.birthdate );
				$(".modal-body #gender").val( records.gender );
				$(".modal-body #emergency_contact").val( records.emergency_contact );
				$(".modal-body #emergency_phone").val( records.emergency_phone );
				/*if(records.active)
				{
					$('#active').bootstrapSwitch('state', true);
				}
				else
				{
					$('#active').bootstrapSwitch('state', false);
				}*/
				$(".modal-body #country").val( records.country );
				$(".modal-body #estate").val( records.estate );
				$(".modal-body #municipality").val( records.municipality );
				$(".modal-body #parish").val( records.parish );
				$(".modal-body #address").val( records.address );
				$("#show_staff").modal("show");
			})
		}
	</script>
@stop
