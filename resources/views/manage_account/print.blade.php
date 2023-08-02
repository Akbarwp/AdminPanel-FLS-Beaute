@extends('templates/print')

@section('css')

@endsection

@section('content')
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <img src="{{ asset('images/flslogo.jpg') }}" style="width:25%">
            </div>
            <div class="col-sm-7">
                <div class="d-flex justify-content-end" style="font-weight:bold">
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
            </div>
        </div>
        <hr style="border-color:black;">
        <div class="row d-flex justify-content-center" style="font-weight:bold; font-size:24px">
            Daftar Akun
        </div>
        <hr style="border-color:black;">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-12 grid-margin ">
                <div class="iq-card">
                    <div class="iq-card-body">
                        <!-- <p style="font-weight:bold; font-size: 20px; text-align:left;"></p> -->
                        <br>
                        <div class="table-responsive-xl" style="overflow: scroll; ">
                            <table
                                class="table table-hover table-striped table-light text-nowrap text-left"
                                cellspacing="0" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Akun</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Posisi</th>
                                        <th scope="col">Admin Input</th>
                                        <th scope="col">Tanggal Diinput</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td class='col-2'>
                                                @if($user->image)
                                                    <img src={{ asset('storage/' . $user->image) }} alt=profile-img class="avatar-50 roundimg" img-fluid/>
                                                @else
                                                    <img src={{ asset('images/manage_account/users/11.png') }} alt=profile-img class="avatar-50 roundimg" img-fluid/>
                                                @endif
                                                {{ $user->firstname}} {{ $user->lastname }}
                                            </td >
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->user_position == "superadmin_pabrik")
                                                    superadmin
                                                @elseif($user->user_position == "superadmin_distributor")
                                                    distributor
                                                @else
                                                    {{ $user->user_position }}
                                                @endif    
                                            </td>
                                            @canany(['superadmin_pabrik','admin'])
                                                <td>
                                                    @if($admins->where('id', $user->id_input)->first())
                                                    {{ $admins->where('id', $user->id_input)->first()->firstname }} {{ $admins->where('id', $user->id_input)->first()->lastname }}
                                                    @else
                                                    {{ $user->nama_input }}
                                                    @endif
                                                </td>
                                            @endcan
                                            @can('superadmin_distributor')
                                                <td>
                                                    {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                                                </td>
                                            @endcan
                                            <td>{{ $user->created_at->format('d/m/y H:i:s') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @canany(['superadmin_pabrik', 'admin'])
                            <div class="row form-group text-left">
                                <div class="col-sm-5" style="font-weight:bold">Total Akun</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-6">{{ $countTotal }} Akun</div>
                            </div>
                            <div class="row form-group text-left">
                                <div class="col-sm-5" style="font-weight:bold">Total Akun Super Admin Pabrik</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-6">{{ $countSuperAdminPabrik }} Akun</div>
                            </div>
                            <div class="row form-group text-left">
                                <div class="col-sm-5" style="font-weight:bold">Total Akun Admin Pabrik</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-6">{{ $countAdmin }} Akun</div>
                            </div>
                            <div class="row form-group text-left">
                                <div class="col-sm-5" style="font-weight:bold">Total Akun Accounting Pabrik</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-6">{{ $countAccountingPabrik }} Akun</div>
                            </div>
                            <div class="row form-group text-left">
                                <div class="col-sm-5" style="font-weight:bold">Total Akun Cashier Pabrik</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-6">{{ $countCashierPabrik }} Akun</div>
                            </div>
                            <div class="row form-group text-left">
                                <div class="col-sm-5" style="font-weight:bold">Total Akun Distributor</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-6">{{ $countSuperAdminDistributor }} Akun</div>
                            </div>
                            <div class="row form-group text-left">
                                <div class="col-sm-5" style="font-weight:bold">Total Akun Prospek Distributor</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-6">{{ $countProspekDistributor }} Akun</div>
                            </div>
                        @endcan

                        @can('superadmin_distributor')
                            <div class="row form-group text-left">
                                <div class="col-sm-5" style="font-weight:bold">Total Akun</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-6">{{ $countTotal }} Akun</div>
                            </div>
                            <div class="row form-group text-left">
                                <div class="col-sm-5" style="font-weight:bold">Total Akun Distributor</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-6">{{ $countSuperAdminDistributor }} Akun</div>
                            </div>
                            <div class="row form-group text-left">
                                <div class="col-sm-5" style="font-weight:bold">Total Akun Accounting Distributor</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-6">{{ $countAccountingDistributor }} Akun</div>
                            </div>
                            <div class="row form-group text-left">
                                <div class="col-sm-5" style="font-weight:bold">Total Akun Cashier Distributor</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-6">{{ $countCashierDistributor }} Akun</div>
                            </div>
                            <div class="row form-group text-left">
                                <div class="col-sm-5" style="font-weight:bold">Total Akun Reseller</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-6">{{ $countReseller }} Akun</div>
                            </div>
                            <div class="row form-group text-left">
                                <div class="col-sm-5" style="font-weight:bold">Total Akun Prospek Reseller</div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-6">{{ $countProspekReseller }} Akun</div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>

<script>
@endsection