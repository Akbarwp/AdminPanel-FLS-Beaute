<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>FLS Beauty</title>

    <!-- TEMPLATE -->
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/flslogo.jpg') }}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    <link href="{{ asset('css/star-rating.css') }}" rel="stylesheet">

    {{-- swall --}}
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.1.2/js/star-rating.min.js"></script>


    <!-- bootdtrap css cdn -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"> -->


    <!-- Latest compiled and minified CSS ??????-->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <!-- popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
        integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

    <!-- bootstrap js -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Latest compiled and minified JavaScript ??????/ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <!-- bootstrap dropdown js ?????? -->
    <!-- <script src="https://gist.github.com/dstaley/8c9d53f88d1ad53c57b4.js"></script> -->

    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />

    <!-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.1.2/css/star-rating.min.css"></script>



    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" ></script> --}}

    <!-- datatables -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('css/templates/main/style.css') }}">


    @yield('css')

</head>

<body>
    <div class="wrapper">
        {{-- sidebar --}}
        <nav id="sidebar">
            <div class="sidebar-header">
                <div class="row align-items-center">
                    <div class="col-sm-9">
                        <img src="{{asset('images/templates/main/logo.png')}}" style="text-align:center; height:65px;width:200px;" class="invert">
                        <h4>FLS Beauty</h4>
                        <p>Pancarkan Cantikmu Bersama Kami</p>
                    </div>
                    @php
                        $count_notif = 0;
                        if (auth()->user()->id_group == 1) {
                            if (
                                \App\Models\Product::where('id_group', auth()->user()->id_group)
                                    ->where('stok', '<', '50')
                                    ->count() > 0
                            ) {
                                $count_notif++;
                            }
                            $count_notif += \App\Models\TransactionHistory::join('users', 'users.id', '=', 'transaction_histories.id_owner')
                                ->where('users.user_position', 'superadmin_distributor')
                                ->where('status_pesanan', 0)
                                ->count();
                            $supplier = \App\Models\User::where('id_group', auth()->user()->id_group)
                                ->where('user_position', 'superadmin_pabrik')
                                ->first();
                            $count_notif += \App\Models\ReturHistory::where('id_supplier', $supplier->id)
                                ->where('status_retur', 0)
                                ->count();
                            // claim reward
                            $count_notif += \App\Models\CrmClaimRewardHistory::where('status', 0)->count();
                        } elseif (auth()->user()->user_position != 'reseller' && auth()->user()->user_position != 'sales') {
                            $distributor = \App\Models\User::where('id_group', auth()->user()->id_group)
                                ->where('user_position', 'superadmin_distributor')
                                ->first();
                            if (
                                \App\Models\Product::where('id_owner', $distributor->id)
                                    ->where('stok', '<', '50')
                                    ->count() > 0
                            ) {
                                $count_notif++;
                            }
                            $count_notif += \App\Models\TransactionHistory::join('users', 'users.id', '=', 'transaction_histories.id_owner')
                                ->where('users.user_position', 'reseller')
                                ->where('status_pesanan', 0)
                                ->count();
                            $supplier = \App\Models\User::where('id_group', auth()->user()->id_group)
                                ->where('user_position', 'superadmin_distributor')
                                ->first();
                            $count_notif += \App\Models\ReturHistory::where('id_supplier', $supplier->id)
                                ->where('status_retur', 0)
                                ->count();
                            if (
                                \App\Models\CrmReward::where('type', 'distributor')
                                    ->where('poin', '<=', $distributor->crm_poin)
                                    ->count() > 0
                            ) {
                                $count_notif++;
                            }
                        } elseif (auth()->user()->user_position == 'reseller') {
                            if (
                                \App\Models\Product::where('id_owner', auth()->user()->id)
                                    ->where('stok', '<', '50')
                                    ->count() > 0
                            ) {
                                $count_notif++;
                            }
                            if (
                                \App\Models\CrmReward::where('type', 'reseller')
                                    ->where('poin', '<=', auth()->user()->crm_poin)
                                    ->count() > 0
                            ) {
                                $count_notif++;
                            }
                        } elseif (auth()->user()->user_position == 'sales') {
                            if (
                                \App\Models\Product::where('id_owner', auth()->user()->id)
                                    ->where('stok', '<', '50')
                                    ->count() > 0
                            ) {
                                $count_notif++;
                            }
                            $count_notif += \App\Models\SalesStokHistory::where('id_owner', auth()->user()->id)
                                ->where('status', '=', 0)
                                ->count();
                            if (
                                \App\Models\CrmReward::where('type', 'reseller')
                                    ->where('poin', '<=', auth()->user()->crm_poin)
                                    ->count() > 0
                            ) {
                                $count_notif++;
                            }
                        } else {
                            $count_notif = -1;
                        }
                    @endphp
                    {{-- <div class="col-sm-3 ">
                        <i class="btn fa fa-bell" style="color:white;" onclick="location.href='{{ url('/notification') }}'" ><span class="badge badge-danger" @if($count_notif==0)hidden @endif>{{ $count_notif }}</span></i> 
                    </div> --}}
                </div>
            </div>
            <div class="row" style="padding-left:8px;">
                <div class="col-4">
                    @if (auth()->user()->image)
                        <img src={{ asset('storage/' . auth()->user()->image) }} alt=profile-img
                            class="avatar-60 roundimg" img-fluid />
                    @else
                        <div id="profile" class="d-flex justify-content-center align-items-center">
                            <p style="font-weight:bold;">
                                {{ auth()->user()->firstname[0] }}{{ auth()->user()->lastname[0] }}</p>
                        </div>
                    @endif
                </div>
                <div class="col align-self-center">
                    <div class="row"><p style="font-weight:bold; color:rgba(199, 199, 199, 1);">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</p></div>
                    <div class="row"><p style="color:rgba(199, 199, 199, 1);">
                        @if(auth()->user()->user_position == "superadmin_pabrik")
                            superadmin
                        @elseif(auth()->user()->user_position == "superadmin_distributor")
                            distributor
                        @else
                            {{ auth()->user()->user_position }}
                        @endif
                    </p></div>
                </div>
            </div>

            <ul class="list-unstyled components">
                {{-- <li class="list-group-item">
                    <form action="/logout" method="post">
                        @csrf
                        <div class="row">
                            <button type="submit" class="col">Logout</button>
                        </div>
                    </form>
                </li>    --}}
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2 align-self-center">
                            <img src="{{ asset('images/templates/main/dashboard.png') }}"
                                style="height:16px;width:16px;" class="invert">
                        </div>
                        <div class="col">
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        </div>
                    </div>
                </li>
                {{-- KELOLA AKUN --}}
                @canany(['superadmin_pabrik', 'superadmin_distributor'])
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-2 align-self-center">
                                <img src="{{ asset('images/templates/main/kelola akun.png') }}"
                                    style="height:16px;width:16px;" class="invert">
                            </div>
                            <div class="col">
                                <a href="#kelolaakun" data-toggle="collapse" aria-expanded="false"
                                    class="dropdown-toggle">Kelola Akun</a>
                                <ul class="collapse list-unstyled" id="kelolaakun">
                                    <li>
                                        <a href="{{ url('/manage_account/users/create') }}">Tambah Akun Baru</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/manage_account/users') }}">Daftar Akun</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/manage_account/permission') }}">Izin Akun</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endcan
                {{-- KELOLA BARANG --}}
                @if (auth()->user()->lihat_barang == 1 && auth()->user()->user_position != 'reseller')
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-2 align-self-center">
                                <img src="{{ asset('images/templates/main/kelola barang.png') }}"
                                    style="height:16px;width:16px;" class="invert">
                            </div>
                            <div class="col">
                                <a href="#kelolabarang" data-toggle="collapse" aria-expanded="false"
                                    class="dropdown-toggle">Kelola Barang</a>
                                <ul class="collapse list-unstyled" id="kelolabarang">
                                    @if (auth()->user()->id_group == 1)
                                        @if (auth()->user()->tambah_barang == 1)
                                            <li>
                                                <a href="{{ url('/manage_product/products/create') }}">Tambah Barang
                                                    Baru</a>
                                            </li>
                                            <li>
                                                <a href="{{ url('/manage_product/category') }}">Daftar Kategori
                                                    Barang</a>
                                            </li>
                                        @endif
                                        <li>
                                            <a href="{{ url('/manage_product/products') }}">Daftar Barang Pusat</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/manage_product/distributor/products') }}">Daftar Barang
                                                Distributor</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/manage_product/distributor_reseller/products') }}">Daftar
                                                Barang Reseller</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/report_product/lostproducts') }}">Barang Hilang</a>
                                        </li>
                                        @if (auth()->user()->pasok_barang == 1)
                                            <li>
                                                <a href="{{ url('/manage_product/input_pasok/supplyhistories') }}">Stok
                                                    Masuk</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (auth()->user()->id_group != 1)
                                        <li>
                                            <a href="{{ url('/manage_product/products') }}">Daftar Barang
                                                Distributor</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/manage_product/reseller/products') }}">Daftar Barang
                                                Reseller</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/report_product/lostproducts') }}">Barang Hilang</a>
                                        </li>
                                    @endif

                                </ul>
                            </div>
                        </div>
                    </li>
                @endif

                @if (auth()->user()->lihat_barang == 1 && auth()->user()->user_position == 'reseller')
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-2 align-self-center">
                                <img src="{{ asset('images/templates/main/kelola barang.png') }}"
                                    style="height:16px;width:16px;" class="invert">
                            </div>
                            <div class="col">
                                <a href="{{ url('/manage_product/products') }}">Kelola Barang</a>
                            </div>
                        </div>
                    </li>
                @endif
        
<!-- Sales -->
                {{-- @if(auth()->user()->user_position != "reseller")
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2 align-self-center">
                            <img src="{{ asset('images/templates/main/reseller.png') }}" style="height:16px;width:16px;" class="invert">
                        </div>
                        @if(auth()->user()->id_group == 1)
                        <div class="col">
                            <a href="#sales" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Sales</a>
                            <ul class="collapse list-unstyled" id="sales">
                                <li>
                                    <a href="{{ url('/sales/list_distributor') }}">Tracking Sales</a>
                                </li>
                                {{-- <li>
                                    <a href="{{ url('/sales/setting_bonus/') }}">Setting Sales</a>
                                </li> --}}
                                    {{-- </ul>
                                </div>
                            @elseif(auth()->user()->user_position != 'sales')
                                <div class="col">
                                    <a href="#sales" data-toggle="collapse" aria-expanded="false"
                                        class="dropdown-toggle">Sales</a>
                                    <ul class="collapse list-unstyled" id="sales">
                                        <li>
                                            <a href="{{ url('/sales/index/' . auth()->user()->id_group) }}">Tracking
                                                Sales</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/sales/setting_bonus/' . auth()->user()->id_group) }}">Setting
                                                Sales</a>
                                        </li>
                                    </ul>
                                </div>
                            @elseif(auth()->user()->user_position == 'sales')
                                <div class="col">
                                    <a href="#sales" data-toggle="collapse" aria-expanded="false"
                                        class="dropdown-toggle">Sales</a>
                                    <ul class="collapse list-unstyled" id="sales">
                                        <li>
                                            <a href="{{ url('/sales/tracking/' . auth()->user()->id) }}">Tracking</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('/sales/product/' . auth()->user()->id) }}">Barang</a>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </li>
                @endif --}}

                {{-- CRM --}}
                {{-- @if (auth()->user()->lihat_crm == 1 &&
                        auth()->user()->user_position != 'reseller' &&
                        auth()->user()->user_position != 'sales')
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-2 align-self-center">
                                <img src="{{ asset('images/templates/main/distributor.png') }}"
                                    style="height:16px;width:16px;" class="invert">
                            </div>
                            <div class="col">
                                <a href="#crm" data-toggle="collapse" aria-expanded="false"
                                    class="dropdown-toggle">CRM</a>
                                <ul class="collapse list-unstyled" id="crm">
                                    <li>
                                        @if (auth()->user()->id_group == 1)
                                            <a href="{{ url('/crm/list/') }}">Distributor</a>
                                        @else
                                            @php
                                                $distributor = \App\Models\User::where('id_group', auth()->user()->id_group)
                                                    ->where('user_position', 'superadmin_distributor')
                                                    ->first();
                                            @endphp
                                            <a href="{{ url('/crm/omzet/' . $distributor->id) }}">Distributor</a>
                                        @endif
                                    </li>
                                    <li>
                                        @if (auth()->user()->id_group == 1)
                                            <a href="{{ url('/crm/list_distributor/') }}">Reseller</a>
                                        @else
                                            <a href="{{ url('/crm/list/') }}">Reseller</a>
                                        @endif
                                    </li>
                                    @if (auth()->user()->id_group == 1)
                                        @if (auth()->user()->input_reward_crm)
                                            <li>
                                                <a href="{{ url('/crm/reward') }}">Reward</a>
                                            </li>
                                        @endif
                                        {{-- <li>
                                    <a href="{{ url('/crm/cluster') }}">Cluster</a>
                                </li> --}}
                                        {{-- @if (auth()->user()->input_poin_crm)
                                            <li>
                                                <a href="{{ url('/crm/poin') }}">Poin</a>
                                            </li>
                                        @endif
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif  --}}

                @canany(['reseller', 'sales'])
                    {{-- @if (auth()->user()->lihat_crm == 1)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-2 align-self-center">
                                    <img src="{{ asset('images/templates/main/distributor.png') }}"
                                        style="height:16px;width:16px;" class="invert">
                                </div>
                                <div class="col">
                                    <a href="{{ url('/crm/omzet/' . auth()->user()->id) }}">CRM</a>
                                </div>
                            </div>
                        </li>
                    @endif --}}
                @endcan
                {{-- RETUR --}}
                @if(auth()->user()->input_retur == 1)
                @if(auth()->user()->id_group != 1)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2 align-self-center">
                            <img src="{{ asset('images/templates/main/retur.png') }}" style="height:16px;width:16px;" class="invert">
                        </div>
                        <div class="col">
                            <a href="#retur" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Retur</a>
                            <ul class="collapse list-unstyled" id="retur">
                                <li>
                                    <a href="{{ url('/retur/to_supplier/') }}">Retur Pembelian</a>
                                </li>
                                <li>
                                    <a href="{{ url('/retur/to_cashier/') }}">Retur Penjualan</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                @endif
                @endif
                {{-- Cash Opname Distributor --}}
                @if (auth()->user()->user_position == 'superadmin_distributor' || auth()->user()->user_position == 'reseller')
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-2 align-self-center">
                                <img src="{{ asset('images/templates/main/reseller.png') }}"
                                    style="height:16px;width:16px;" class="invert">
                            </div>
                            <div class="col">
                                <a href="#cash_opname" data-toggle="collapse" aria-expanded="false"
                                    class="dropdown-toggle">Cash Opname</a>
                                <ul class="collapse list-unstyled" id="cash_opname">
                                    <li>
                                        <a href="{{ url('/cash_opname/report') }}">Report</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/cash_opname/open') }}">Open Cash</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/cash_opname/close') }}">Close Cash</a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </li>
                @endif
                {{-- KELOLA TRANSAKSI --}}
                @if (auth()->user()->lihat_pos == 1)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-2 align-self-center">
                                <img src="{{ asset('images/templates/main/kelola transaksi.png') }}"
                                    style="height:16px;width:16px;" class="invert">
                            </div>
                            <div class="col">
                                <a href="#kelolatransaksi" data-toggle="collapse" aria-expanded="false"
                                    class="dropdown-toggle">Kelola Transaksi</a>
                                <ul class="collapse list-unstyled" id="kelolatransaksi">
                                    @if (auth()->user()->input_pos == 1)
                                        <li>
                                            <a href="{{ url('/manage_transactions/transaction') }}">Transaksi
                                                Pusat</a>
                                        </li>
                                    @endif
                                    <li>
                                        {{-- <a href="{{ url('/manage_transactions/transaction_history') }}">Riwayat Transaksi Pusat</a> --}}
                                        <a href="{{ url('/manage_transaction/buy/history') }}">Riwayat Transaksi
                                            Pusat</a>
                                    </li>
                                    @if (auth()->user()->input_pos == 1)
                                        <li>
                                            <a href="{{ url('/manage_transactions/transaction_sell') }}">Kasir</a>
                                        </li>
                                    @endif
                                    <li>
                                        {{-- <a href="{{ url('/manage_transactions/transaction_history_sell') }}">Riwayat Kasir</a> --}}
                                        <a href="{{ url('/manage_transaction/sell/history/') }}">Riwayat Kasir</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif
{{-- KELOLA LAPORAN --}}
                @if(auth()->user()->lihat_laporan_penjualan == 1 || auth()->user()->lihat_laporan_pembelian == 1 || auth()->user()->lihat_laporan_pegawai == 1 || auth()->user()->lihat_laporan_retur_penjualan == 1 || auth()->user()->lihat_laporan_retur_pembelian == 1)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2 align-self-center">
                            <img src="{{ asset('images/templates/main/kelola laporan.png') }}" style="height:16px;width:16px;" class="invert">
                        </div>
                        <div class="col">
                            <a href="#kelolalaporan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Kelola Laporan</a>
                            <ul class="collapse list-unstyled" id="kelolalaporan">
                                @if(auth()->user()->lihat_laporan_penjualan == 1)
                                <li>
                                    <a href="{{ url('/manage_report/transaction/sell') }}">Laporan Transaksi Penjualan</a>
                                </li>
                                @endif
                                @if(auth()->user()->lihat_laporan_pembelian == 1)
                                <li>
                                    <a href="{{ url('/manage_report/transaction/buy') }}">Laporan Transaksi Pembelian</a>
                                </li>
                                @endif
                                @if(auth()->user()->lihat_laporan_pegawai == 1)
                                <li>
                                    <a href="{{ url('/manage_report/users') }}">Laporan Pegawai</a>
                                </li>
                                @endif
                                @if(auth()->user()->lihat_laporan_retur_penjualan == 1)
                                <li>
                                    <a href="{{ url('/manage_report/transaction/retur/sell') }}">Laporan Retur Penjualan</a>
                                </li>
                                @endif
                                @if(auth()->user()->lihat_laporan_retur_pembelian == 1)
                                <li>
                                    <a href="{{ url('/manage_report/transaction/retur/buy') }}">Laporan Retur Pembelian</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </li>
            @endif

            {{-- @canany(['superadmin_pabrik', 'superadmin_distributor'])
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2 align-self-center">
                            <img src="{{ asset('images/templates/main/clipboard.png') }}" style="height:16px;width:16px;" class="invert">
                        </div>
                        <div class="col">
                            <a href="#laporanbarang" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Laporan Barang</a>
                            <ul class="collapse list-unstyled" id="laporanbarang">
                                <li>
                                    <a href="{{ url('/report_product/lostproducts/') }}">Laporan Barang Hilang</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                @endcan --}}
        
                {{-- <li class="list-group-item">
                    <div class="row">
                        <div class="col-2 align-self-center">
                            <img src="{{ asset('images/templates/main/budget.png') }}" style="height:16px;width:16px;" class="invert">
                        </div>
                        <div class="col">
                            <a href="#akun" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Akuntansi</a>
                            <ul class="collapse list-unstyled" id="akun">
                                <li class="subheader">Akun</li>
                                <li>
                                    <a href="#">Manage Akun</a>
                                </li>
                                <li>
                                    <a href="#">Data Akun</a>
                                </li>
                
                                <li class="subheader">Aktiva</li>
                                <li>
                                    <a href="#">Aktiva Tetap</a>
                                </li>
                                <li>
                                    <a href="#">Aktiva Lancar</a>
                                </li>
                                <li>
                                    <a href="#">Laporan Aktiva</a>
                                </li>
                
                                <li class="subheader">Kas</li>
                                <li>
                                    <a href="#">Kas In</a>
                                </li>
                                <li>
                                    <a href="#">Kas Out</a>
                                </li>
                                <li>
                                    <a href="#">Bank</a>
                                </li>
                
                                <li class="subheader">Laporan Keuangan</li>
                                <li>
                                    <a href="#">Jurnal Harian</a>
                                </li>
                                <li>
                                    <a href="#">Buku Besar</a>
                                </li>
                                <li>
                                    <a href="#">Neraca</a>
                                </li>
                                <li>
                                    <a href="#">Laporan Laba Rugi</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li> --}}
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2 align-self-center">	
                            <i class="fa fa-bell"></i>
                        </div>
                        <div class="col">
                            <a href="{{ url('/notification') }}">Notifikasi</a>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2 align-self-center">	
                            <i class="fa fa-door-open" style="color:#e86969"></i>
                        </div>
                        <div class="col">
                            <a href="{{ url('/logout') }}" style="color:#e86969">Log Out</a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>

    <div class="container">
        {{-- sidebar button --}}
        <nav>
            <div class="row">
                <div class="col-sm">
                    <button type="button" id="sidebarcollapse" class="btn btn-info" style="background-color:rgba(165,78,182); color:whitesmoke">
                        <i class="fas fa-align-left"></i>
                        <span>Menu</span>
                    </button>
                </div>
                <div class="col-sm">
                    <h2>
                        <?php
                        // echo $_SESSION['pagename'];
                        ?>
                    </h2>
                </div>
            </div>
        </nav>

        {{-- content --}}
        @yield('content')
    </div>
</div>

<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script>
    $(document).ready(
        function() {
            $('#sidebarcollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
        }
    )
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
</script>

@yield('script')
</body>

</html>
