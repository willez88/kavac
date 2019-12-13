@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/accounting/js/app.js'), [], Request::secure()) !!}
@endsection
@section('modules-css')
    @parent
    {!! Html::style(mix('modules/accounting/css/app.css'), [], Request::secure()) !!}
@endsection
