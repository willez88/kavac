@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/asset/js/app.js'), [], Request::secure()) !!}
@endsection

@section('modules-css')
    @parent
    {!! Html::style(mix('modules/payroll/css/app.css'), [], Request::secure()) !!}
@endsection
