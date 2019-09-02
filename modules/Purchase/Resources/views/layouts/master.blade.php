@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/purchase/js/purchase.js'), [], Request::secure()) !!}
@endsection
