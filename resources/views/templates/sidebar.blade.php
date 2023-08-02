{{-- sidebar --}}
<nav id="sidebar">
    <div class="sidebar-header">
        <div class="row align-items-center">
            <div class="col-sm-9">
                <h4>ASTANA</h4>
                <p>for your daily activity</p>
            </div>
            @php
                $count_notif = 0;
                if(auth()->user()->id_group == 1) {
                    if(\App\Models\Product::where('id_group', auth()->user()->id_group)->where('stok', '<', '50')->count() > 0) {
                        $count_notif++;
                    }
                    $count_notif += \App\Models\TransactionHistory::join('users', 'users.id', '=', 'transaction_histories.id_owner')->where('users.user_position','superadmin_distributor')->where('status_pesanan', 0)->count();
                    $supplier = \App\Models\User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();
                    $count_notif += \App\Models\ReturHistory::where('id_supplier', $supplier->id)->where('status_retur', 0)->count();
                    // claim reward
                    $count_notif += \App\Models\CrmClaimRewardHistory::where('status', 0)->count();
                }
                else if(auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales") {
                    $distributor = \App\Models\User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
                    if(\App\Models\Product::where('id_owner', $distributor->id)->where('stok', '<', '50')->count() > 0) {
                        $count_notif++;
                    }
                    $count_notif += \App\Models\TransactionHistory::join('users', 'users.id', '=', 'transaction_histories.id_owner')->where('users.user_position','reseller')->where('status_pesanan', 0)->count();
                    $supplier = \App\Models\User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
                    $count_notif += \App\Models\ReturHistory::where('id_supplier', $supplier->id)->where('status_retur', 0)->count();
                    if(\App\Models\CrmReward::where('type', 'distributor')->where('poin', '<=', $distributor->crm_poin)->count() > 0)
                    {
                        $count_notif++;
                    }
                }
                else if(auth()->user()->user_position == "reseller") {
                    if (\App\Models\Product::where('id_owner', auth()->user()->id)->where('stok', '<', '50')->count() > 0 ) {
                        $count_notif++;
                    }
                    if(\App\Models\CrmReward::where('type', 'reseller')->where('poin', '<=', auth()->user()->crm_poin)->count() > 0)
                    {
                        $count_notif++;
                    }
                }
                else if(auth()->user()->user_position == "sales")
                {
                    if (\App\Models\Product::where('id_owner', auth()->user()->id)->where('stok', '<', '50')->count() > 0 ) {
                        $count_notif++;
                    }
                    $count_notif += \App\Models\SalesStokHistory::where('id_owner', auth()->user()->id)->where('status', '=', 0)->count();
                    if(\App\Models\CrmReward::where('type', 'reseller')->where('poin', '<=', auth()->user()->crm_poin)->count() > 0)
                    {
                        $count_notif++;
                    }
                }
                else {
                    $count_notif = -1;
                }
            @endphp
            <div class="col-sm-3 ">
                <i class="btn fa fa-bell" style="color:white;" onclick="location.href='{{ url('/notification') }}'" ><span class="badge badge-danger" @if($count_notif==0)hidden @endif>{{ $count_notif }}</span></i> 
            </div>
        </div>
    </div>
    <div class="row" style="padding-left:8px;">
        <div class="col-4">
            @if(auth()->user()->image)
                <img src={{ asset('storage/' . auth()->user()->image) }} alt=profile-img class="avatar-60 roundimg" img-fluid/>
            @else
                <div id="profile" class="d-flex justify-content-center align-items-center">
                    <p style="font-weight:bold;">{{ auth()->user()->firstname[0] }}{{ auth()->user()->lastname[0] }}</p>
                </div>
            @endif
        </div>
        <div class="col align-self-center">
            <div class="row"><p style="font-weight:bold;">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</p></div>
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
                    <img src="{{asset('images/templates/main/dashboard.png')}}" style="height:16px;width:16px;" class="invert">
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
                    <img src="{{ asset('images/templates/main/kelola akun.png') }}" style="height:16px;width:16px;" class="invert">
                </div>
                <div class="col">
                    <a href="#kelolaakun" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Kelola Akun</a>
                    <ul class="collapse list-unstyled" id="kelolaakun">
                        <li>
                            <a href="{{ url('/manage_account/users/create') }}">Tambah Akun Baru</a>
                        </li>
                        <li>
                            <a href="{{ url('/manage_account/users') }}">Daftar Akun</a>
                        </li>
                        <li>
                            <a href="{{ url('/manage_account/permission') }}">Permission Akun</a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        @endcan
{{-- KELOLA BARANG --}}
        @if(auth()->user()->lihat_barang == 1 && auth()->user()->user_position != "reseller")
        <li class="list-group-item">
            <div class="row">
                <div class="col-2 align-self-center">
                    <img src="{{ asset('images/templates/main/kelola barang.png') }}" style="height:16px;width:16px;" class="invert">
                </div>
                <div class="col">
                    <a href="#kelolabarang" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Kelola Barang</a>
                    <ul class="collapse list-unstyled" id="kelolabarang">
                        @if(auth()->user()->id_group == 1)
                            @if(auth()->user()->tambah_barang == 1)
                            <li>
                                <a href="{{ url('/manage_product/products/create') }}">Tambah Barang Baru</a>
                            </li>
                            @endif
                            <li>
                                <a href="{{ url('/manage_product/products') }}">Daftar Barang Pusat</a>
                            </li>
                            <li>
                                <a href="{{ url('/manage_product/distributor/products') }}">Daftar Barang Distributor</a>
                            </li>
                            <li>
                                <a href="{{ url('/manage_product/distributor_reseller/products') }}">Daftar Barang Reseller</a>
                            </li>
                            @if(auth()->user()->pasok_barang == 1)
                            <li>
                                <a href="{{ url('/manage_product/input_pasok/supplyhistories') }}">Stok Masuk</a>
                            </li>
                            @endif
                        @endif

                        @if(auth()->user()->id_group != 1)
                            <li>
                                <a href="{{ url('/manage_product/products') }}">Daftar Barang Distributor</a>
                            </li>
                            <li>
                                <a href="{{ url('/manage_product/reseller/products') }}">Daftar Barang Reseller</a>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>
        </li>
        @endif

        @if(auth()->user()->lihat_barang == 1 && auth()->user()->user_position == "reseller")
        <li class="list-group-item">
            <div class="row">
                <div class="col-2 align-self-center">
                    <img src="{{ asset('images/templates/main/kelola barang.png') }}" style="height:16px;width:16px;" class="invert">
                </div>
                <div class="col">
                    <a href="{{ url('/manage_product/products') }}">Kelola Barang</a>
                </div>
            </div>
        </li>
        @endif
<!-- Sales -->
        @if(auth()->user()->user_position != "reseller")
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
                    </ul>
                </div>
                @elseif(auth()->user()->user_position != "sales")
                <div class="col">
                    <a href="#sales" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Sales</a>
                    <ul class="collapse list-unstyled" id="sales">
                        <li>
                            <a href="{{ url('/sales/index/'.auth()->user()->id_group) }}">Tracking Sales</a>
                        </li>
                        <li>
                            <a href="{{ url('/sales/setting_bonus/'.auth()->user()->id_group) }}">Setting Sales</a>
                        </li>
                    </ul>
                </div>
                @elseif(auth()->user()->user_position == "sales")
                <div class="col">
                    <a href="#sales" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Sales</a>
                    <ul class="collapse list-unstyled" id="sales">
                        <li>
                            <a href="{{ url('/sales/tracking/'.auth()->user()->id) }}">Tracking</a>
                        </li>
                        <li>
                            <a href="{{ url('/sales/product/'.auth()->user()->id) }}">Barang</a>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </li>
        @endif

{{-- CRM --}}
        @if(auth()->user()->lihat_crm == 1 && auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales")
        <li class="list-group-item">
            <div class="row">
                <div class="col-2 align-self-center">
                    <img src="{{ asset('images/templates/main/distributor.png') }}" style="height:16px;width:16px;" class="invert">
                </div>
                <div class="col">
                    <a href="#crm" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">CRM</a>
                    <ul class="collapse list-unstyled" id="crm">
                        <li>
                            @if(auth()->user()->id_group == 1)
                                <a href="{{ url('/crm/list/') }}">Distributor</a>
                            @else
                                @php
                                    $distributor = \App\Models\User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
                                @endphp
                                <a href="{{ url('/crm/omzet/'.$distributor->id) }}">Distributor</a>
                            @endif
                        </li>
                        <li>
                            @if(auth()->user()->id_group == 1)
                                <a href="{{ url('/crm/list_distributor/') }}">Reseller</a>
                            @else
                                <a href="{{ url('/crm/list/') }}">Reseller</a>
                            @endif
                        </li>
                        @if(auth()->user()->id_group == 1)
                        @if(auth()->user()->input_reward_crm)
                        <li>
                            <a href="{{ url('/crm/reward') }}">Reward</a>
                        </li>
                        @endif
                        {{-- <li>
                            <a href="{{ url('/crm/cluster') }}">Cluster</a>
                        </li> --}}
                        @if(auth()->user()->input_poin_crm)
                        <li>
                            <a href="{{ url('/crm/poin') }}">Poin</a>
                        </li>
                        @endif
                        @endif
                    </ul>
                </div>
            </div>
        </li>
        @endif

        @canany(['reseller', 'sales'])
        @if(auth()->user()->lihat_crm == 1)
        <li class="list-group-item">
            <div class="row">
                <div class="col-2 align-self-center">
                    <img src="{{ asset('images/templates/main/distributor.png') }}" style="height:16px;width:16px;" class="invert">
                </div>
                <div class="col">
                    <a href="{{ url('/crm/omzet/'.auth()->user()->id) }}">CRM</a>
                </div>
            </div>
        </li>
        @endif
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
                    <a href="{{ url('/retur/to_supplier/') }}">Retur</a>
                </div>
            </div>
        </li>
        @endif
        @endif

{{-- KELOLA TRANSAKSI --}}
        @if(auth()->user()->lihat_pos == 1)
        <li class="list-group-item">
            <div class="row">
                <div class="col-2 align-self-center">
                    <img src="{{ asset('images/templates/main/kelola transaksi.png') }}" style="height:16px;width:16px;" class="invert">
                </div>
                <div class="col">
                    <a href="#kelolatransaksi" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Kelola Transaksi</a>
                    <ul class="collapse list-unstyled" id="kelolatransaksi">
                        @if(auth()->user()->input_pos == 1)
                        <li>
                            <a href="{{ url('/manage_transactions/transaction') }}">Transaksi Pusat</a>
                        </li>
                        @endif
                        <li>
                            {{-- <a href="{{ url('/manage_transactions/transaction_history') }}">Riwayat Transaksi Pusat</a> --}}
                            <a href="{{ url('/manage_transaction/buy/history') }}">Riwayat Transaksi Pusat</a>
                        </li>
                        @if(auth()->user()->input_pos == 1)
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
        @if(auth()->user()->lihat_laporan_penjualan == 1 || auth()->user()->lihat_laporan_pembelian == 1 || auth()->user()->lihat_laporan_pegawai == 1)
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
                        @endcan
                    </ul>
                </div>
            </div>
        </li>
        @endif
        
        {{-- @canany(['superadmin_pabrik','superadmin_distributor'])
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

        <li class="list-group-item">
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