@section('modules-js')
    @parent
    {!! Html::script(mix('modules/warehouse/js/app.js'), [], Request::secure()) !!}
@endsection

{{-- Minimo de Productos --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Estado del Inventario de Almacén</h6>
                <div class="card-btns">
                    @include('buttons.minimize')
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <span class="text-muted">
                            A continuación se muestra la disponibilidad de los productos inventariados en el almacén.
                        </span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 panel-legend">
                        <i class="ion-android-checkbox-blank text-success" title="El nivel de existencia del producto es elevado"
                           data-toggle="tooltip"></i>
                        <span>Alto</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 panel-legend">
                        <i class="ion-android-checkbox-blank text-warning" title="El nivel de existencia del producto es intermedio"
                           data-toggle="tooltip"></i>
                        <span>Medio</span>
                    </div>
                </div>
                <div class="row mg-bottom-20">
                    <div class="col-md-4 panel-legend">
                        <i class="ion-android-checkbox-blank text-danger" title="El nivel de existencia del producto se está agotando"
                           data-toggle="tooltip"></i>
                        <span>Bajo</span>
                    </div>
                </div>
                <hr>
                <warehouse-dashboard-product-list
                    route_list="warehouse/dashboard/vue-list-min-products">
                </warehouse-dashboard-product-list>
            </div>
        </div>
    </div>
</div>


{{-- Gráficos Estadísticos --}}

<warehouse-dashboard-graphs>
</warehouse-dashboard-graphs>

{{-- Histórico de Operaciones --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Histórico de Operaciones del Módulo de Almacén</h6>
                <div class="card-btns">
                    @include('buttons.minimize')
                </div>
            </div>
            <div class="card-body">
                <warehouse-operations-history-list
                    route_list="warehouse/dashboard/operations/vue-list">
                </warehouse-operations-history-list>
            </div>
        </div>
    </div>
</div>
