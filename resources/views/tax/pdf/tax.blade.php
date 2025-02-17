<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
</head>
<body>
    <style> </style>

    <h1>{{$info['system']}}</h1>
    
    <p>Vous dever remplir <strong>{{$info['sum_to_inform']}} €</strong> à la <strong>{{$info['case']}}</strong>. <br>
        Vous serez imposé sur <strong>{{$info['sum_taxed']}} €</strong>, soit <strong>{{$info['taxes']}} €</strong> de prévelés. </p>
</body>
</html>