@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/warehouse/js/app.js'), [], Request::secure()) !!}
@endsection
