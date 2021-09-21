<table cellspacing="0" cellpadding="1" border="0">
    <colgroup>
        <col span="1" style="width: auto" />
        <col span="1" style="width: auto" />
        <col span="1" style="width: auto" />
        <col span="1" style="width: auto" />
    </colgroup>
    <thead>
        <tr style="background-color: #BDBDBD;">
            <th span="1">Nombre</th>
            <th span="1">Código</th>
            <th span="1">Códigon ONAPRE</th>
            <th span="1">¿Activo?</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $record)
        <tr>
            <td>{{ $record->name }}</td>
            <td>{{ $record->code }}</td>
            <td>{{ $record->onapre_code }}</td>
            <td>{{ $record->active ? 'Activo' : 'Inactivo' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>