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
                <h4>CRM - {{ $owner->firstname }} {{ $owner->lastname }}</h4>
            </div>
            <hr style="border-color:black;">
            <div class="iq-card-body">
                <div class="row">
                    <h4>Point Saya : {{ number_format($owner->crm_poin, 0, ',', '.') }}</h4>
                </div>
                
                <hr>
                <table id="mytable" class="table table-hover table-striped table-light text-nowrap"
                    cellspacing="0" style="width:100%; text-align:left">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Reward</th>
                            <th>Point</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        @foreach($rewards as $reward)
                            <tr>

                                <td class="w-25" style="width:25%;">
                                    <?php $image_path = '/storage'.'/'. $reward->image; ?>
                                    <img src="{{ public_path() . $image_path }}" style="width:75%" class="img-fluid img-thumbnail" alt=profile-img>
                                    {{-- <img src={{ asset('storage/' . $reward->image) }} alt=profile-img
                                        class="img-fluid img-thumbnail" style="width:75%;"/> --}}
                                <td class="align-middle">
                                    {{ $reward->reward }}
                                </td >
                                <td class="align-middle">{{ number_format($reward->poin, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>