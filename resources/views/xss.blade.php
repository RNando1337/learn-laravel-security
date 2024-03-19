<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>This is XSS</title>
    <style>
        table, th, td {
            border: 1px solid;
        }
    </style>
</head>
<body>
    <h3>When using echo statements in Blade, always use @{{ }}, and avoid using @{!! !!} because these echo statements will display unescaped data.</h3>
    <span>To try an example of XSS, you can add data first via `/api/users/register` URL using the POST method to create new data and try filling the name field with an XSS payload. You can try example payload based on https://github.com/payloadbox/xss-payload-list</span>
    <br><br>
    <h2>This is a table with the echo statement @{{ }}</h2>
    <table>
        <thead>
            <th width="10%">Name</th>
            <th width="10%">Email</th>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>
    <h2>This is a table with echo statement @{!! !!}</h2>
    <table>
        <thead>
            <th width="10%">Name</th>
            <th width="10%">Email</th>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{!! $user->name !!}</td>
                    <td>{!! $user->email !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>