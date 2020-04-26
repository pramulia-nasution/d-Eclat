<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export Data</title>
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('asset/css/bootstrap.min.css')}}">

    <!-- plugins -->
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/plugins/datatables.bootstrap.min.css')}}"/> --}}
</head>
<body>
<center>
    <h2>Otput Hasil Asosiasi pemkaian NAPZA mengggunakan Metode d'Eclat</h2>
</center>

<h4>Hasil 6 Itemset</h4>
    <table border="1">
        <thead>
            <tr>
                <th width="5">No</th>
                <th width="20">Inisial</th>
                <th width="15">Support Count</th>
                <th width="10">Support (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($declat as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->inisial}}</td>
                    <td>{{$item->supportCount}}</td>
                    <td>{{$item->support}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Nilai Confidence</h4>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Itemset</th>
                <th>Support (%)</th>
                <th>Confidence</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($confidences as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->itemset}}</td>
                    <td>{{$item->support}}</td>
                    <td>{{$item->confidence}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Hasil Evaluasi</h4>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Kesimpulan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($evaluation as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

{{-- <script src="{{asset('asset/js/jquery.min.js')}}"></script>
<script src="{{asset('asset/js/bootstrap.min.js')}}"></script>

<script src="{{asset('asset/js/plugins/jquery.datatables.min.js')}}"></script>
<script src="{{asset('asset/js/plugins/datatables.bootstrap.min.js')}}"></script> --}}
</body>
</html>