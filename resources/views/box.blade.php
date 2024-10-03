<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mes Box</title>
</head>
<body>
    <table>
        <tr>
            <th>#</th>
            <th>Location par mois</th>
        </tr>
        @foreach ($boxes as $box)
        <tr>
            <td>{{$box->id}}</td>
            <td>{{$box->price}}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>