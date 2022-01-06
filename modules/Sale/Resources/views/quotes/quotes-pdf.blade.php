@foreach($quotes as $quote)
  <h2 style="text-align: center">Cotización: {{ $quote->id }} (Estado: {{ $quote->status_text }})</h2>
  <h3>I Datos del solicitante:</h3>
  <table cellspacing="1" cellpadding="0" border="0">
    <tbody>
      <tr>
        <td style="font-size:9rem;" width="33%">
          <strong> Tipo de persona:</strong><br>{{ $quote->type_person }}
        </td>
        <td style="font-size:9rem;" width="33%">
          <strong>
            @if ($quote->type_person === 'Jurídica')
              Nombre de la Empresa:
            @else
              Nombre y Apellido:
            @endif
          </strong><br />{{ $quote->name }}
        </td>
        <td style="font-size:9rem;" width="33%">
          <strong>
            @if ($quote->type_person === 'Jurídica')
              RIF:
            @else
              Identificación:
            @endif
          </strong><br />{{ $quote->id_number }}
        </td>
      </tr>
      <tr>
        <td style="font-size:9rem;" width="33%">
          <strong>Teléfono de contacto:</strong><br>{{$quote->phone}}
        </td>
        <td style="font-size:9rem;" width="33%">
          <strong>Correo Electrónico:</strong><br>{{$quote->email}}
        </td>
      </tr>
    </tbody>
  </table>
  <br /><br />
  <h3>II Descripción de productos:</h3>
  {{-- Productos --}}
  @if (isset($quote->SaleQuoteProduct) && count($quote->SaleQuoteProduct) > 0)
    <table cellspacing="0" cellpadding="1" border="0">
      <tr>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Tipo de Producto</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Producto</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Subservicio</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Unidad de medida</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Precio unitario</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Cantidad de productos</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Total sin iva</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Iva</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Total</th>
        <th width="10%" style="font-size:9rem; background-color: #BDBDBD;" align="center">Moneda</th>
      </tr>
      @foreach($quote->SaleQuoteProduct as $product)
        <tr>
          <td style="font-size: 8rem; border-bottom-color:#BDBDBD;" align="left">
            {{ $product->product_type }}
          </td>
          <td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="left">
            @if ($product->sale_warehouse_inventory_product_id)
              {{ $product->saleWarehouseInventoryProduct->SaleSettingProduct->name }}
            @else
              {{ $product->saleTypeGood->name }}
            @endif
          </td>
          <td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="center">
            @if ($product->sale_list_subservices_id)
              {{ $product->SaleListSubservices->name }}
            @else
              N/A
            @endif
          </td>
          <td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="center">
            {{ $product->measurementUnit->name }}
          </td>
          <td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="center">
            {{ number_format($product->value, 2) }}
          </td>
          <td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="center">
            {{ $product->quantity }}
          </td>
          <td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="center">
            {{ number_format($product->total_without_tax, 2) }}
          </td>
          <td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="center">
            {{ number_format($product->product_tax_value, 2) }}
          </td>
          <td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="center">
            {{ number_format($product->total, 2) }}
          </td>
          <td style="font-size:9rem; border-bottom-color:#BDBDBD;" align="left">
            {{ $product->Currency->name }}
          </td>
        </tr>
      @endforeach
    </table>
    <br /><br />
    <table cellspacing="1" cellpadding="0" border="0">
      <tbody>
        <tr>
          <td style="font-size:9rem;" width="33%">
            <strong>Total sin iva:</strong><br>{{ number_format($quote->total_without_tax, 2) }}
          </td>
          <td style="font-size:9rem;" width="33%">
            <strong>IVA:</strong><br>{{ number_format($quote->total - $quote->total_without_tax, 2) }}
          </td>
          <td style="font-size:9rem;" width="33%">
            <strong>Total a pagar:</strong><br>{{ number_format($quote->total, 2) }}
          </td>
        </tr>
      </tbody>
    </table>
  @else
    No hay productos en la cotización
  @endif
  <br /><br />
  <h3>III Complementarios:</h3>
  <table cellspacing="1" cellpadding="0" border="0">
    <tbody>
      <tr>
        <td style="font-size:9rem;" width="50%">
          <strong>Forma de cobro:</strong><br>
            @if (isset($quote->sale_form_payment_id))
              {{ $quote->SaleFormPayment->name_form_payment }}
            @endif
        </td>
        <td style="font-size:9rem;" width="50%">
          <strong>Fecha límite de respuesta:</strong><br>{{ date('d / m / Y', strtotime($quote->deadline_date)) }}
        </td>
      </tr>
    </tbody>
  </table>
  <br /><br /><br /><br />
@endforeach
