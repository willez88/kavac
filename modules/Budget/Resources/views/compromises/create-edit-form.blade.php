@extends('budget::layouts.master')

@section('maproute-icon')
    <i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-icon-mini')
    <i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-actual')
    Presupuesto
@stop

@section('maproute-title')
    Compromiso
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">
                        {{ __('Compromiso') }}
                        @include('buttons.help')
                    </h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <budget-compromise route_list='{{ url('budget/compromises') }}'></budget-compromise>
            </div>
        </div>
    </div>
@stop

@section('extra-js')
    @parent
    {!! Html::script('js/ckeditor.js', [], Request::secure()) !!}
    <script>
        $(document).ready(function() {
            if (typeof CkEditor !== 'undefined') {
                CkEditor.create(document.querySelector('#description'), {
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'blockQuote', 'link', 'numberedList', 'bulletedList', '|',
                        'insertTable'
                    ],
                    language: '{{ app()->getLocale() }}',
                }).then(editor => {
                    window.editor = editor;
                }).catch(error => {
                    logs('budget::compromises.create-edit-form', 54, error);
                });
            }
        });
    </script>
@endsection
