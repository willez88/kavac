{!! (!isset($model))?Form::open($header):Form::model($model, $header) !!}
<div class="row">


    <div class="col-md-6">
        <div class="form-group {{ $errors->has('date') ? ' has-error' : '' }}">
            {!! Form::label('date_label', 'Fecha de Solicitud', []) !!}
            <div class="input-group input-sm">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons ui-1_calendar-60"></i>
                                </span>
                                {!! Form::date('date',(isset($date))?$asset_request->created_at:old('created_at'),
                [
                    'class' => 'form-control input-sm',
                    'disabled' => 'true',
                    'data-toggle' => 'tooltip',
                    'title' => 'Fecha de la solicitud'
                ]
            ) !!}
                            </div>
            
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('motivo') ? ' has-error' : '' }} is-required">
            {!! Form::label('motivo_label', 'Motivo de la solicitud', []) !!}
            {!! Form::text('motivo',(isset($request_motivo))?$request_motivo->motivo:old('motivo'),
                [
                    'class' => 'form-control input-sm',
                    'data-toggle' => 'tooltip',
                    'title' => 'Indique el motivo de la solicitud'
                ]
            ) !!}
        </div>
    </div>


  
    <div class="col-md-2">
        <b>Filtros</b>
    </div>
    <div class="form-group col-md-2">
        <div class="input-group input-sm">
            <span class="input-group-addon">
                <i class="now-ui-icons design_app"></i>
            </span>
            {!! Form::text('model',(isset($asset))?$asset->model:old('model'),
                [
                    'class' => 'form-control input-sm',
                    'data-toggle' => 'tooltip',
                    'placeholder' => 'Modelo',
                    'title' => 'Indique el modelo del bien solicitado'
                ]
            ) !!}
        </div>
    </div>

    <div class="form-group col-md-2">
        <div class="input-group input-sm">
            <span class="input-group-addon">
                <i class="now-ui-icons design_app"></i>
            </span>
            {!! Form::text('marca',(isset($asset))?$asset->marca:old('marca'),
                [
                    'class' => 'form-control input-sm',
                    'data-toggle' => 'tooltip',
                    'placeholder' => 'Marca',
                    'title' => 'Indique la marca del bien solicitado'
                ]
            ) !!}
        </div>
    </div>
    
    <div class="form-group col-md-2">
        <div class="input-group input-sm">
            <span class="input-group-addon">
                <i class="now-ui-icons design_app"></i>
            </span>
            {!! Form::text('serial', (isset($asset))?$asset->serial:old('serial'), [
                    'class' => 'form-control',
                    'data-toggle' => 'tooltip',
                    'placeholder' => 'Serial',
                    'title' => 'Indique el serial del bien solicito'
            ]) !!}
        </div>
    </div>
    
    <div class="form-group col-md-2">
        {!! Form::button('Buscar <i class="fa fa-search"></i>', [
                'class' => 'btn btn-sm btn-info',
                'data-toggle' => 'tooltip', 'onclick' => '#',
                'title' => 'Buscar registros eliminados',
        ]) !!}
    </div>
</div>

<table class="table table-hover table-striped dt-responsive datatable">
    <thead>
        <tr class="text-center">

            <th>Código</th>
            <th>Tipo</th>
            <th>Categoria</th>
            <th>Subcategoria</th>
            <th>Categoria Específica</th>
            <th>Ubicación</th>
            <th>Proveedor</th>
            <th>Condición Física</th>
            <th>Forma de Adquisición</th>
            <th>Año de Adquisición</th>
            <th>Estatus de uso</th>
            <th>Serial</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Valor</th>

        </tr>
    </thead>
    <tbody>
    @foreach($assets as $asset)
        <tr>
            <td> {{ $asset->serial_inventario }} </td>
            <td> {{ $asset->type_id }} </td>
            <td> {{ $asset->category_id }} </td>
            <td> {{ $asset->subcategory_id }} </td>
            <td> {{ $asset->specific_category_id }} </td>
            <td> {{ $asset->institution_id }} </td>
            <td> {{ $asset->proveedor_id }} </td>
            <td> {{ $asset->condition }} </td>
            <td> {{ $asset->purchase_id }} </td>
            <td> {{ $asset->purchase_year }} </td>
            <td> {{ $asset->status }} </td>
            <td> {{ $asset->serial }} </td>
            <td> {{ $asset->marca }} </td>
            <td> {{ $asset->model }} </td>
            <td> {{ $asset->value }} </td>
                                    
        </tr>
    @endforeach
    </tbody>
</table>
<div class="card-footer text-right">
    @include('layouts.form-buttons')
</div>
{!! Form::close() !!}