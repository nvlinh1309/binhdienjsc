<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ strtoupper($data['title']) }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #000000;
            text-align: left;
            padding: 8px;
        }

        th {
            text-align: center !important;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <h1>{{ strtoupper($data['title']) }}</h1>
    <h5>
        <div>Ngày: {{ date('d/m/Y H:m:s') }}</div>
        <div>{{ $data['count_record'] }}</div>
    </h5>
    <hr>
    <table>
        <tr>
            @foreach ($data['columns'] as $key => $value)
                <th>{{  $value }}</th>
            @endforeach
        </tr>
            @foreach ($data['rows'] as $key => $value)
                <tr>
                    @foreach ($value as $key => $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
    </table>

</body>

</html>
