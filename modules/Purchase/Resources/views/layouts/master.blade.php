@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/purchase/js/app.js'), [], Request::secure()) !!}
@endsection
