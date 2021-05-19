<table width="100%" cellpadding="4">
    <tbody>
        <tr>
            <td width="25%" style="font-weight: bold;">Presupuesto asignado:</td>
            <td width="75%">{{ ($formulation->assigned || $formulation->assigned==='1')?'Sí':'No' }}</td>
        </tr>
        <tr>
            <td width="25%" style="font-weight: bold;">Institución:</td>
            <td width="75%">{{ $formulation->specificAction->institution }}</td>
        </tr>
        <tr>
            <td width="25%" style="font-weight: bold;">Moneda:</td>
            <td width="75%">{{ $formulation->currency->description }}</td>
        </tr>
        <tr>
            <td width="25%" style="font-weight: bold;">Presupuesto:</td>
            <td width="75%">{{ $formulation->year }}</td>
        </tr>
        <tr>
            <td width="25%" style="font-weight: bold;">{{ $formulation->specificAction->type }}:</td>
            <td width="75%">{{ $formulation->specificAction->specificable->code }} -
                {{ $formulation->specificAction->specificable->name }}
            </td>
        </tr>
        <tr>
            <td width="25%" style="font-weight: bold;">Acción Específica</td>
            <td width="75%">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td width="10%">{{ $formulation->specificAction->code }} -</td>
                            <td width="90%" style="text-align: justify;">{!! $formulation->specificAction->description !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td width="25%" style="font-weight: bold;">Total Formulado:</td>
            <td width="75%">
                {{ $formulation->currency->symbol }}&#160;
                {{ number_format($formulation->total_formulated, $formulation->currency->decimal_places, ",", ".") }}
            </td>
        </tr>
    </tbody>
</table>
<div style="margin-bottom: 10px"></div>

<table width="100%" cellpadding="4" style="font-size: 8px;">
    <thead>
        <tr align="center" style="font-weight: bold;">
            <td width="15%" style="border-bottom: solid 1px #000;">{{ __('Código') }}</td>
            <td width="65%"
                style="border-left: solid 1px #000;border-right: solid 1px #000;border-bottom: solid 1px #000;">
                {{ __('Denominación') }}
            </td>
            <td width="20%" style="border-bottom: solid 1px #000;">{{ __('Total Año') }}</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($formulation->accountOpens as $accountOpen)
            @php
                $finalBorder = '';
                $style = ($accountOpen->budgetAccount->specific==="00") ? 'font-weight:bold;' : '';
            @endphp
            @if ($loop->last)
                @php
                    $finalBorder = "border-bottom: solid 1px #000;";
                @endphp
            @endif
            <tr style="{{ $style }}">
                <td width="15%" style="{{ $finalBorder }}">{{ $accountOpen->budgetAccount->code }}</td>
                <td width="65%" style="border-left: solid 1px #000;border-right: solid 1px #000;{{ $finalBorder }}">
                    {{ $accountOpen->budgetAccount->denomination }}
                </td>
                <td width="20%" align="right" style="{{ $finalBorder }}">
                    {{ number_format(
                        $accountOpen->total_year_amount,
                        $formulation->currency->decimal_places, ",", "."
                    ) }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
