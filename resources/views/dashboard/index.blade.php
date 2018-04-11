@extends('layouts.app')

@section('content')
	@include('dashboard.users-connected')
	@include('dashboard.logs-list')
	@include('dashboard.undelete-records')
@stop

@section('extra-js')
	<script>
		$(document).ready(function() {
			$('.datatable').DataTable();
		});
	</script>
@stop