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

	@foreach(Module::all() as $module)
		@php
			$perm = App\Roles\Models\Permission::where('slug', strtolower($module) . '.dashboard')->first();
			$hasPerm = (!is_null($perm));
		@endphp
		@if (auth()->user()->hasRole(strtolower($module)) || $hasPerm)
			@includeIf(strtolower($module) . '::index')
		@endif
	@endforeach
@stop

@section('extra-js')
	<script>
		$(document).ready(function() {
			$('.datatable').DataTable();
		});
	</script>
@stop
