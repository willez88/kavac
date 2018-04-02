@extends('layouts.app')

@section('content')
	@include('dashboard.users-connected')
	@include('dashboard.logs-list')
@stop

@section('extra-js')
	<script>
		$(document).ready(function() {
			$('.datatable').DataTable();
		});
	</script>
@stop