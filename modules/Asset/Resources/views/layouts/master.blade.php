@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/asset/js/app.js'), [], Request::secure()) !!}
@endsection
