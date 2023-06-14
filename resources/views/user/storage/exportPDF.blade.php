<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DANH SÁCH KHO</title>
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
    <h1>DANH SÁCH KHO</h1>
    <h5>
        <div>Ngày: {{ date('d/m/Y') }}</div>
        <div>Tổng số kho: {{ count($data) }}</div>
    </h5>
    <hr>
    <table>
        <tr>
            <th>#</th>
            <th>Mã kho</th>
            <th>Tên kho</th>
            <th>Địa chỉ</th>
        </tr>
        @foreach ($data as $key => $value)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $value['code'] }}</td>
                <td>{{ $value['name'] }}</td>
                <td>{{ $value['address'] }}</td>
            </tr>
        @endforeach
    </table>

</body>

</html>
