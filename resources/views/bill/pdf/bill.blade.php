<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
</head>
<body>
    <style>

table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    
    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    header{
        display: flex;
        width: 100%
    }
    header div {
        width: 50%
    }
    </style>

    <header>
        <div>
            <h1>AVIS D'ÉCHÉANCE</h1>
            <p>Mandat : {{$user->name}}</p>
            <p>Box : {{$box->address}}</p>
        </div>
        <div>
            <p>Le {{$dates[0]}}</p>
        </div>
    </header>

    <div>
        <p>{{$tenant->first_name}} {{$tenant->last_name}}</p>
        <p>{{$tenant->address}}</p>
    </div>

    <table>
        <tr>
            <th>Avis d'échéance</th>
            <th>Montant</th>
        </tr>
        <tr>
            <td>Période du {{$dates[0]}} au {{$dates[1]}}</td>
            <td>{{$box->price}} €</td>
        </tr>
        <tr>
            <td>Total à régler</td>
            <td>{{$box->price}} €</td>
        </tr>
    </table>
</body>
</html>