@if (isset($route))
    <a href="{{ $route }}" class="btn btn-sm btn-primary btn-custom" data-toggle="tooltip"
       title="{{ __('Imprimir registro') }}" target="_blank">
        <i class="fa fa-print"></i>
    </a>
@else
    {!! Form::button('<i class="fa fa-print"></i>', [
        'class' => 'btn btn-sm btn-primary btn-custom', 'data-toggle' => 'tooltip', 'type' => 'button',
        'title' => __('Imprimir registro'),
        'onclick' => (isset($print['action']))
                     ? "print({$print['action']})"
                     : ((isset($print['function']))?$print['function']:'print()')
    ]) !!}
@endif
