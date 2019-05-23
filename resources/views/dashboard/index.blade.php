@extends('layouts.app')

@section('content')
	@role('dev')
		@include('dev.tools-availables')
	@endrole
	
	@role('admin')
		@include('dashboard.users-connected')
		@include('dashboard.logs-list')
		@include('dashboard.undelete-records')
	@endrole
	@yield('dashboard')
@stop

@section('extra-js')
	<script>
		$(document).ready(function() {
			$('.datatable').DataTable();
		});
	</script>
@stop