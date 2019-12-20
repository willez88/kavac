@extends('layouts.app')

@section('maproute-icon')
    <i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
    <i class="ion-settings"></i>
@stop

@section('maproute-actual')
    Configuración
@stop

@section('maproute-title')
    Usuarios
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Usuarios</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.new', ['route' => route('users.create')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped dt-responsive datatable">
                        <thead>
                            <tr class="text-center">
                                <th class="col-md-3">Usuario</th>
                                <th class="col-md-7">Institución</th>
                                <th class="col-md-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (App\User::all() as $user)
                                <tr>
                                    <td>{{ $user->username }}</td>
                                    <td>
                                        @php
                                            $institution = ($user->profile && $user->profile->institution)
                                                           ? $user->profile->institution->acronym
                                                           : 'NO ASIGNADA';
                                        @endphp
                                        {{ $institution }}
                                    </td>
                                    <td class="text-center">
                                        {!! Form::button('<i class="fa fa-info-circle"></i>', [
                                            'class' => 'btn btn-info btn-xs btn-icon btn-action',
                                            'data-toggle' => 'tooltip', 'type' => 'button',
                                            'onclick' => 'view_user_info('.$user->id.')',
                                            'title' => 'Ver información del usuario',
                                        ]) !!}
                                        @include('buttons.edit', ['route' => route('users.edit', $user->id)])
                                        @include('buttons.delete', ['route' => route('users.destroy', $user->id)])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
