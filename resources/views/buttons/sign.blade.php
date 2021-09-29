@if (isset($route))
    <a class="btn btn-sm btn-primary btn-custom" data-toggle="modal" data-target="#exampleModal">
        <i class="icofont icofont-ui-password" title="{{ __('Firmar registro') }}" data-toggle="tooltip"></i>
    </a>

    <!-- Modal -->
    <div id="exampleModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 id="exampleModalLabel" class="modal-title">Ingrese la frase de paso de su certificado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <input id="phasepass" class="form-control" type="password" name="password" tabindex="3"
                       placeholder="pkcs12 password" required />
          </div>
          <div class="modal-footer">
            <button class="btn btn-default btn-sm btn-round" type="button" data-dismiss="modal"
                    style="padding: 5px 15px;">
                Cerrar
            </button>
            <button class="btn btn-primary btn-sm btn-round" href="{{ $route }}" target="_blank"
                    style="padding: 5px 15px;">
                <i class="icofont icofont-fountain-pen"></i>
                Firmar
            </button>
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
