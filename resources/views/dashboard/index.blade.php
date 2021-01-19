@extends('layouts.app')

@section('content')
	@role('dev')
		@include('dev.tools-availables')
	@endrole

	@role('admin')
		@include('dashboard.users-connected')
        <audit-records id="helpAudit" help-file="{{ json_encode(get_json_resource('ui-guides/audit_list.json')) }}"
                       :modules='{!! json_encode(info_modules(true)) !!}'></audit-records>
        <restore-records id="helpRestore" help-file="{{ json_encode(get_json_resource('ui-guides/restore_list.json')) }}"
                         :modules='{!! json_encode(info_modules(true)) !!}'></restore-records>
	@endrole
	@yield('dashboard')

    @if (!(bool)env('APP_TESTING', false))
    	@foreach(Module::all() as $module)
    		@php
    			$perm = App\Roles\Models\Permission::where('slug', strtolower($module) . '.dashboard')->first();
    			$hasPerm = (!is_null($perm));
    		@endphp
    		@if (auth()->user()->hasRole(strtolower($module)) || $hasPerm)
    			@includeIf(strtolower($module) . '::index')
    		@endif
    	@endforeach
    @endif
@stop

@section('extra-js')
	<script>
		$(document).ready(function() {
			$('.datatable').DataTable();
		});
	</script>
@stop
