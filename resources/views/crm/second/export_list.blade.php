<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FLS Beauty</title>
    <style>
        #myTable thead, #myTable tbody,  #myTable tr,  #myTable th, #myTable td{
            border: 1px solid black;
        }
    </style>
</head>

<body style="background-color:white">
    <div class="wrapper">
        <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table style="width:100%;">
                    <tr style="width:100%;">
                        <td style="width:20%;">
                            <?php $image_path = '/images/flslogo.jpg'; ?>
                            <img src="{{ public_path() . $image_path }}" style="width:75%">
                        </td>
                        
                        <td style="text-align: right; width:80%;">
                            <div class="d-flex justify-content-end" style="font-weight:bold; ">
                                PT ANDARA CANTIKA
                            </div>
                            <div class="d-flex justify-content-end">
                                Pergudangan Bumi Benowo Sukses Sejahtera Tbk
                            </div>
                            <div class="d-flex justify-content-end">
                                Jl. Raya Gelora Bung Tomo No. 8, Surabaya, Jawa Timur
                            </div>
                            <div class="d-flex justify-content-end">
                                Email: flsbeautyofficial@gmail.com
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <hr style="border-color:black;">
            <div class="row d-flex justify-content-center" style="font-weight:bold; font-size:24px">
                <h4>
                    @if(auth()->user()->id_group == 1)
                    CRM Distributor Dashboard
                    @elseif(auth()->user()->user_position != "reseller")
                    CRM Reseller Dashboard
                    @endif
                </h4>
            </div>
            <hr style="border-color:black;">
            <table style="width:100%;">
                <tr>
                    <td style="width:10%;">Kepada</td>
                    <td style="width:10%;">:</td>
                    <td style="width:30%;"></td>
                    <td style="width:10%;">NO INV</td>
                    <td style="width:10%;">:</td>
                    <td style="width:30%;"></td>
                </tr>
                <tr>
                    <td style="width:10%;">Alamat</td>
                    <td style="width:10%;">:</td>
                    <td style="width:30%;"></td>
                    <td style="width:10%;">Tanggal</td>
                    <td style="width:10%;">:</td>
                    <td style="width:30%;"></td>
                </tr>
            </table>
            <div class="container justify text-center">
                <div class="row">
                    <div class="col-12">
                        <div class="iq-card">
                            <div class="iq-card-body ">
                                <table id="myTable" class="table text-left table-hover table-striped table-light"
                                    id="myTable" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th >ID</th>
                                            @if(auth()->user()->id_group == 1)
                                            <th >Distributor</th>
                                            @elseif(auth()->user()->user_position != "reseller")
                                            <th >Reseller</th>
                                            @endif
                                            <th>Point</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lists as $list)
                                        <tr>
                                            <td>{{ $list->id }}</td>
                                            <td>{{ $list->firstname }} {{ $list->lastname }}</td>
                                            <td>{{ number_format($list->crm_poin, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>