<!DOCTYPE html>
<html>

<head>
    <title>Responsáveis</title>
</head>

<body>

    <h1>Responsáveis</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ativo</th>
            </tr>
        </thead>

        <tbody>
            @foreach($responsaveis as $responsavel)
            <tr>
                <td>{{ $responsavel->id }}</td>
                <td>{{ $responsavel->nome }}</td>
                <td>
                    {{ $responsavel->ativo ? 'Sim' : 'Não' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>