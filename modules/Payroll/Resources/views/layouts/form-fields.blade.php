<div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} is-required">
            {!! Form::label('name', 'Nombre', []) !!}
            {!! Form::text('name',(isset($staff_type))?$staff_type->name:old('name'),
                [
                    'class' => 'form-control input-sm',
                    'data-toggle' => 'tooltip',
                    'title' => 'Indique el nombre de tipo de personal'
                ]
            ) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }} is-required">
            {!! Form::label('description', 'Descripción', []) !!}
            {!! Form::text('description',(isset($staff_type))?$staff_type->description:old('description'),
                [
                    'class' => 'form-control input-sm',
                    'data-toggle' => 'tooltip',
                    'title' => 'Indique la descripción del tipo de personal'
                ]
            ) !!}
        </div>
    </div>
</div>