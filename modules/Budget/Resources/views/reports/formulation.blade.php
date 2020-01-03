<table width="100%" cellpadding="4">
    <thead>
        <tr align="center" style="font-weight: bold;">
            <td width="15%">{{ __('Código') }}</td>
            <td width="60%">{{ __('Denominación') }}</td>
            <td width="25%">{{ __('Total Año') }}</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($formulation->accountOpens as $accountOpen)
            <tr>
                <td width="15%">{{ $accountOpen->budgetAccount->code }}</td>
                <td width="60%">{{ $accountOpen->budgetAccount->denomination }}</td>
                <td width="25%" align="right">
                    {{ number_format(
                        $accountOpen->total_year_amount,
                        $formulation->currency->decimal_places, ",", "."
                    ) }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
