@extends('asset::layouts.master')

@section('maproute-icon')
	<i class="ion-ios-pricetags-outline"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-ios-pricetags-outline"></i>
@stop

@section('maproute-actual')
	Bienes
@stop

@section('maproute-title')
	Gestión de Bienes
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Bienes</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('asset.register.create')])
                    	{!! Form::button('<i class="fa fa-upload"></i>', [
							'class'       => 'btn btn-sm btn-primary btn-custom',
							'data-toggle' => 'tooltip',
							'type'        => 'button',
							'title'       => __('Importar registros'),
							'onclick'     => "$('input[name=importFile]').click()"
						]) !!}
                        <input  id="importFile" name="importFile"
                        		type="file" style="display:none"
                               	onchange="importData()">
                        {!! Form::button('<i class="fa fa-download"></i>', [
							'class'       => 'btn btn-sm btn-primary btn-custom',
							'data-toggle' => 'tooltip',
							'type'        => 'button',
							'title'       => __('Exportar registros'),
							'onclick'     => 'exportData()'
						]) !!}
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<asset-list
						route_list="{{ url('asset/registers/vue-list') }}"
						route_edit="{{ url('asset/registers/edit/{id}') }}"
						route_delete="{{ url('asset/registers/delete') }}">
					</asset-list>
				</div>
			</div>
		</div>
	</div>
@stop

@section('extra-js')
	@parent
    <script>
        function exportData() {
            location.href = '/asset/registers/export/all';
        };
        function importData() {
        	var url = '/asset/registers/import/all' ;
            var formData = new FormData();
            var importFile = document.querySelector('#importFile');
            formData.append("file", importFile.files[0]);
            axios.post(url, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
            	console.log('exit');
                $.gritter.add({
                    title: 'Exito!',
                    text: "Registro almacenado con exito",
                    class_name: 'growl-success',
                    image: "/images/screen-ok.png",
                    sticky: false,
                    time: 2500
                });
            }).catch(error => {
                console.log('failure');

            });
        }
    </script>
@endsection
