 <!DOCTYPE html>
<html>
<head>
    <style>
        /* Estilos para la tabla */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }

        /* Estilos para el encabezado de la tabla */
        .thead-dark th {
            color: #fff;
            background-color: #343a40;
            border-color: #454d55;
        }
    </style>
</head>
<body>
<h1>New user registered.</h1>
<h5>Please select the option to accept or reject to change the role</h5>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre del Usuario</th>
                <th scope="col">Correo Electrónico</th>
            </tr>
        </thead>
        <tbody>
        <td style="border: 1px solid black;">{{ $user->name }}</td>
      <td style="border: 1px solid black;">{{ $user->email }}</td>
        </tbody>
    </table>
    <br>
    <a href="{{ $url2 }}" style="display: inline-block; padding: 10px 20px; color: white; background-color: blue; text-decoration: none;">Accept</a>

<a href="{{ $url1 }}" style="display: inline-block; padding: 10px 20px; color: white; background-color: green; text-decoration: none;">Reject</a>
</body>
</html>