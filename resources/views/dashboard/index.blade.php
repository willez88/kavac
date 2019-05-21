@extends('layouts.app')

@section('content')
	@yield('dashboard')
	hola
	@role('admin')
		@include('dashboard.users-connected')
		@include('dashboard.logs-list')
		@include('dashboard.undelete-records')
	@endrole
@stop

@section('extra-js')
	<script>
		$(document).ready(function() {
			$('.datatable').DataTable();
		});
	</script>
@stop