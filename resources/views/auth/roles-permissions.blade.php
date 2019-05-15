<h5 class="card-title text-center">Roles</h5>
<div class="row">
    @foreach (App\Roles\Models\Role::all() as $role)
        <div class="col-md-2 text-center">
            <div class="form-group">
                <label for="" class="control-label">{{ $role->name }}</label>
                <div class="col-12 bootstrap-switch-mini">
                    {!! Form::checkbox('role[]', $role->id, ($user) ? $user->hasRole($role->id) : null, [
                        'class' => 'form-control bootstrap-switch bootstrap-switch-mini role',
                        'data-on-label' => 'SI', 'data-off-label' => 'NO'
                    ]) !!}
                </div>
            </div>
        </div>
    @endforeach
</div>
<h5 class="card-title text-center">Permisos</h5>
@php
    $module = "";
@endphp
<div class="row">
    @foreach (App\Roles\Models\Permission::orderBy('model_prefix')->get() as $permission)
        @if ($module != $permission->model_prefix)
            @php
                $module = $permission->model_prefix;
            @endphp
            <div class="col-12" style="padding:20px 0">
                <hr>
                <h6 class="card-title text-center">
                    MÓDULO [{{ strtoupper((substr($module, 0,1) != '0')?$module:substr($module, 1)) }}]
                </h6>
                <hr>
            </div>
        @endif
        <div class="col-md-4 text-center">
            <div class="form-group">
                <label for="" class="control-label">{{ $permission->name }}</label>
                <div class="col-12 bootstrap-switch-mini">
                    {!! Form::checkbox(
                        'permission[]', $permission->id, 
                        ($user) ? $user->hasPermission($permission->id) : null, [
                            'class' => 'form-control bootstrap-switch bootstrap-switch-mini permission',
                            'data-on-label' => 'SI', 'data-off-label' => 'NO'
                        ]
                    ) !!}
                </div>
            </div>
        </div>
    @endforeach
</div>