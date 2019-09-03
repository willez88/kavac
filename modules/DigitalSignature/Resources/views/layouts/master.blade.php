@extends('layouts.app')

@section('modules-js')
    @parent
    {!! Html::script(mix('modules/digitalsignature/js/app.js'), [], Request::secure()) !!}
@endsection
