<h5 class="card-title text-center">{{ __('Roles') }}</h5>
<div class="row" id="role">
    @foreach (App\Roles\Models\Role::all() as $role)
        <div class="col-md-2 text-center">
            <div class="form-group">
                <label for="" class="control-label">{{ $role->name }}</label>
                <div class="col-12 bootstrap-switch-mini">
                    {!! Form::checkbox('role[]', $role->id, ($user) ? $user->hasRole($role->id) : null, [
                        'class' => 'form-control bootstrap-switch bootstrap-switch-mini role',
                        'data-on-label' => __('SI'), 'data-off-label' => __('NO')
                    ]) !!}
                </div>
            </div>
        </div>
    @endforeach
</div>
<h5 class="card-title text-center">{{ __('Permisos') }}</h5>
@php
    $module = "";
@endphp
<div class="row" id="permissions">
    @foreach (App\Roles\Models\Permission::orderBy('model_prefix')->get() as $permission)
        @if ($module != $permission->model_prefix)
            @php
                $module = $permission->model_prefix;
            @endphp
            <div class="col-12" style="padding:20px 0">
                <hr>
                <h6 class="card-title text-center">
                    {{ __('MÓDULO [:module]', [
                        'module' => strtoupper((substr($module, 0,1) != '0')?$module:substr($module, 1))
                    ]) }}
                </h6>
                <hr>
            </div>
        @endif
        <div class="col-md-3 text-center">
            <div class="form-group">
                <label for="" class="control-label">{{ $permission->name }}</label>
                <div class="col-12 bootstrap-switch-mini">
                    @php
                        $userPerm = ($user) ? $permission->users()->where('user_id', $user->id)->get() : null;
                    @endphp
                    {!! Form::checkbox(
                        'permission[]', $permission->id, (!is_null($userPerm) && !$userPerm->isEmpty()) ? true : null, [
                            'class' => 'form-control bootstrap-switch bootstrap-switch-mini permission',
                            'data-on-label' => __('SI'), 'data-off-label' => __('NO')
                        ]
                    ) !!}
                </div>
            </div>
        </div>
    @endforeach
</div>
