<a href="javascript:void(0)" title="{{ __('Haz click para ver la ayuda guiada de este elemento') }}"
   data-toggle="tooltip" class="btn-help" id="btnHelp{{ $helpId ?? '' }}">
    <i class="ion ion-ios-help-outline cursor-pointer"></i>
</a>
@section('extra-js')
    @parent
    <script>
        $(document).ready(function() {
            @if (isset($helpId) && !empty($helpId) && isset($helpSteps) && count($helpSteps) > 0)
                $('#btnHelp{{ $helpId }}').on('click', function() {
                    startGuidedTour(JSON.parse(JSON.stringify({!! json_encode($helpSteps) !!})));
                });
            @endif
        });
    </script>
@stop
