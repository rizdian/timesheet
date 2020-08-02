<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<style type="text/css">
    h2::after {
        content: '';
        background-image: url({{asset('img/sadaqa.jpg')}}); /*use tree here*/
        opacity: 0.5;
        width: 220px;
        height: 200px;
        display: inline-block;
    }

    h2::after {
        float: right;
        clear: right;
    }

    h2 {
        text-align: center;
        height: 100px;
        line-height: 100px;
    }

    /* override styles when printing */
    @media print {
        body {
            margin: 0;
        }
    }

    /* target left (even-numbered) pages only */
    @page :left {
        margin-right: 1cm;
    }

    /* target right (odd-numbered) pages only */
    @page :right {
        margin-left: 1cm;
    }

    {
        page-break-inside: auto
    ;
    }

    table tr td,
    table tr th {
        font-size: 12pt;
    }

    table.isi {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table.isi td, th {
        border: 1px solid #000;
        text-align: left;
        padding: 8px;
    }

    table.isi tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>
<h2>Report Donasi Acara</h2>

<h3>Detail Acara</h3>
<table class="table table-info">
    <tbody>
    <tr>
        <td style="width: 100px">Id Acara</td>
        <td>: {{$acara->id}}</td>
    </tr>
    <tr>
        <td>Nama</td>
        <td>: {{$acara->nama}}</td>
    </tr>
    <tr>
        <td>Deskirpsi</td>
        <td>: {{$acara->deskripsi}}</td>
    </tr>
    <tr>
        <td>Periode</td>
        <td>: {{\Carbon\Carbon::parse($acara->periode)->format('F, Y') }}</td>
    </tr>
    </tbody>
</table>
</br>
</br>

<h3>List Donasi</h3>
<table class="isi">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>No Telepon</th>
        <th>Nominal</th>
        <th>Type</th>
        <th>Tanggal Input</th>
    </tr>
    </thead>
    <tbody>
    @php $i=1 ; $total = 0 @endphp
    @foreach($isi as $p)
        <tr>
            <td>{{ $i++ }}</td>
            <td style="min-width: 180px">{{$p->nama}}</td>
            <td style="min-width: 150px">{{$p->no_telp}}</td>
            <td style="min-width: 180px">{{"Rp " . number_format($p->nominal,0,',','.')}}</td>
            <td style="width: 80px">{{$p->type}}</td>
            <td style="width: 150px">{{\Carbon\Carbon::parse($p->created_at)->format('j F Y') }}</td>
        </tr>
        {{ $total+= $p->nominal }}
    @endforeach
    <tr>
        <td colspan="3">Total Donasi :</td>
        <td colspan="3"><strong>{{"Rp " . number_format($total,0,',','.')}}</strong></td>
    </tr>
    </tbody>
</table>

</body>
</html>
