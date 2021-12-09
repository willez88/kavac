@if (isset($route))
    <a id="verify-sign-button" class="btn btn-sm btn-primary btn-custom" data-toggle="modal" data-target="#signModal">
        <i class="icofont icofont-ui-password" title="{{ __('Firmar registro') }}" data-toggle="tooltip"></i>
    </a>

    <!-- Modal -->
    <div id="signModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="signModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="signModalLabel" class="modal-title">Ingrese la frase de paso de su certificado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input
                        id="phasepass-modal"
                        class="form-control"
                        type="password"
                        name="password"
                        tabindex="1"
                        placeholder="pkcs12 password" required
                    />
                    <a id="signed-modal" class="btn btn-link d-none mt-3" href="{{ $route }}" target="_blank">
                        <i class="icofont icofont-download-alt"></i>
                        Descargar archivo firmado
                    </a>
                    <div id="authentication" class="d-none mt-3"> 
                        <p> Autenticación invalidada </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default btn-sm btn-round" type="button" data-dismiss="modal"
                            style="padding: 5px 15px;">
                            Cerrar
                    </button>
                    <a id="verify-modal" class="btn btn-primary btn-sm btn-round" style="padding: 5px 15px;">
                        <i class="icofont icofont-fountain-pen"></i>
                        Firmar
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    {!! Form::button('<i class="fa fa-print"></i>', [
        'class' => 'btn btn-sm btn-primary btn-custom', 'data-toggle' => 'tooltip', 'type' => 'button',
        'title' => __('Firmar registro'),
        'onclick' => (isset($print['action']))
        ? "print({$print['action']})"
        : ((isset($print['function']))?$print['function']:'print()')
    ]) !!}
@endif
