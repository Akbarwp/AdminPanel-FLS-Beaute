<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AkumulasiBonusPenjualanSales;
use App\Models\CrmPoin;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Province;
use App\Models\SalesProduct;
use App\Models\SalesStokDetail;
use App\Models\SalesStokHistory;
use App\Models\TrackingSalesDetail;
use App\Models\TrackingSalesHistory;
use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use PDF;

class ManageSalesController extends Controller
{
    public function viewSalesListDistributor()
    {
        $distributors = User::where('user_position', 'superadmin_distributor')->get();
        return view('manage_sales.list_distributor', compact('distributors'));
    }

    public function printSalesListDistributor(){
        $distributors = User::where('user_position', 'superadmin_distributor')->get();
        return view("manage_sales.print_list_distributor", compact('distributors'));
    }

    public function exportSalesListDistributor(){
        $distributors = User::where('user_position', 'superadmin_distributor')->get();

        $pdf = PDF::loadView('manage_sales.export_list_distributor', compact(['distributors']));
        return $pdf->download('List Distributor - '.date('F Y').'.pdf');
    }

    public function viewSettingBonus($id_group)
    {
        $products = SalesProduct::where('id_group', $id_group)->get();

        return view('manage_sales.bonus', compact(['products']));
    }

    public function editSettingBonus($id_bonus)
    {
        $product = SalesProduct::where('id', $id_bonus)->first();
        $type = ProductType::where('id', $product->id_productType)->first();
        return response()->json(['product' => $product, 'type' => $type]);
    }

    public function updateSettingBonus(Request $request)
    {
        $validateData['bonus'] = $request->bonus;
        $validateData['harga_jual'] = $request->harga_jual;

        $product = SalesProduct::where('id', $request->id)->first();
        $product->update($validateData);

        $type = ProductType::where('id', $product->id_productType)->first();

        $allProducts = Product::join('users', 'users.id', '=', 'products.id_owner')->where('products.id_group', $product->id_group)->where('user_position', "sales")->where('id_productType', $product->id_productType)->Select('products.*')->get();
        // dd($allProducts);
        foreach($allProducts as $a)
        {
            $a->update(array('bonus_penjualan' => $validateData['bonus']));
            $a->update(array('harga_jual' => $validateData['harga_jual']));
        }

        $newActivity['id_user'] = auth()->user()->id;
        $newActivity['id_group'] = auth()->user()->id_group;
        $newActivity['kegiatan'] = "Edit Bonus Penjualan Sales '". $type->nama_produk."'";
        UserHistory::create($newActivity);


        Session::flash('update_success', 'Bonus berhasil diubah');

        return redirect('/sales/setting_bonus/'.auth()->user()->id_group);
    }
    public function viewSales($id_group)
    {
        if(auth()->user()->lihat_tracking_sales == 1)
        {
            $provinces = Province::all();
    
            $distributor = User::where('id_group', $id_group)->where('user_position', 'superadmin_distributor')->first();
            $sales = User::where('id_group', $id_group)->where('user_position', 'sales')->get();
            return view('manage_sales.index',compact(['provinces', 'sales', 'distributor']) );
        }

        return back();
    }

    public function printSales($id_group){
        if(auth()->user()->lihat_tracking_sales == 1)
        {    
            $distributor = User::where('id_group', $id_group)->where('user_position', 'superadmin_distributor')->first();
            $sales = User::where('id_group', $id_group)->where('user_position', 'sales')->get();
            return view('manage_sales.print_index',compact(['sales', 'distributor']) );
        }
    }

    public function exportSales($id_group){
        if(auth()->user()->lihat_tracking_sales == 1)
        {    
            $distributor = User::where('id_group', $id_group)->where('user_position', 'superadmin_distributor')->first();
            $sales = User::where('id_group', $id_group)->where('user_position', 'sales')->get();
            
            $pdf = PDF::loadView('manage_sales.export_index', compact(['sales', 'distributor']));
            return $pdf->download('List Sales - '.$distributor->firstname." ".$distributor->lastname." - ".date('F Y').'.pdf');
        }
    }

// TRACKING
    public function viewTrackingHistory($id_sales)
    {
        if(auth()->user()->lihat_tracking_sales == 1)
        {
            $histories = TrackingSalesHistory::where('id_reseller', $id_sales)->get();
            return view('manage_sales.tracking.index', compact('histories','id_sales'));
        }

        return back();
    }

    public function createTrackingHistory()
    {
        if(auth()->user()->user_position == "sales")
        {
            // dd("aa");
            $types = ProductType::all();
            $products = Product::where('id_owner', auth()->user()->id)->get();
            return view('manage_sales.tracking.create', compact('types', 'products'));
        }
        return back();
    }

    public function storeTrackingHistory(Request $request)
    {
        if(auth()->user()->user_position == "sales")
        {
            $rules = [
                'nama_toko' => 'required',
                'address' => 'required',
                'longitude' => 'required',
                'latitude' => 'required',
                'nilai' => 'required',
                'saran' => 'required',
            ];
    
            $validateData = $request->validate($rules);
            $validateData['id_group'] = auth()->user()->id_group;
            $validateData['id_reseller'] = auth()->user()->id;
            

            $length = (count($request->all()) - 7) / 2;

            // CEK STOK PRODUK
            $productsAvailable = true;
            $list = "";

            $totalJual = 0;

            for ($i = 1; $i <= $length; $i++)
            {
                if($request->input("id_produk".$i) && $request->input("jumlah_produk".$i))
                {
                    $produk = Product::where('id', $request->input("id_produk".$i))->first();
                    if($request->input("jumlah_produk".$i) > $produk->stok)
                    {
                        $productsAvailable = false;
                        $list .= " *";
                        $list .= $produk->product_type->nama_produk;
                    }

                    $totalJual += $request->input("jumlah_produk".$i) * $produk->harga_jual;

                }
            }


            if($productsAvailable)
            {
                $validateData['total'] = $totalJual;
                
                TrackingSalesHistory::create($validateData);
                $validateDetail['id_tracking_sales'] = TrackingSalesHistory::latest()->first()->id;

                $total_crm_poin_distributor = 0;
                $total_crm_poin_sales = 0;
                $total_bonus_penjualan_sales = 0;
                for ($i = 1; $i <= $length; $i++)
                {
                    if($request->input("id_produk".$i) && $request->input("jumlah_produk".$i))
                    {
                        $produk = Product::where('id', $request->input("id_produk".$i))->first();
                        $validateDetail['id_produk'] = $produk->id;
                        $validateDetail['nama_produk'] = $produk->product_type->nama_produk;
                        $validateDetail['jumlah'] = (int)$request->input("jumlah_produk".$i);
                        $validateDetail['harga'] = $produk->harga_jual;
                        $validateDetail['total'] = $validateDetail['jumlah'] * $validateDetail['harga'];

                        $crm_poin = CrmPoin::where('id_productType', $produk->id_productType)->first();
                        $validateDetail['crm_poin_distributor'] = $crm_poin->distributor_reseller_jual*$validateDetail['jumlah'];
                        $validateDetail['crm_poin_sales'] = $crm_poin->reseller_jual*$validateDetail['jumlah'];
                        $validateDetail['bonus_penjualan_sales'] = $validateDetail['jumlah'] * $produk->bonus_penjualan / 100 * ($produk->harga_jual - $produk->harga_modal);

                        TrackingSalesDetail::create($validateDetail);

                        $total_crm_poin_distributor += $validateDetail['crm_poin_distributor'];
                        $total_crm_poin_sales += $validateDetail['crm_poin_sales'];
                        $total_bonus_penjualan_sales += $validateDetail['bonus_penjualan_sales'];

                        $updateStok = $produk->stok - $validateDetail['jumlah'];
                        $produk->update(array('stok' => $updateStok));
                        if($updateStok > 0)
                        {
                            $keteranganStok = 'Tersedia';
                        }
                        else
                        {
                            $keteranganStok = 'Kosong';
                        }
                        $produk->update(array('keterangan' => $keteranganStok));
                    }
                }
                $tracking = TrackingSalesHistory::latest()->first();
                $tracking->update(array('total_crm_poin_distributor' => $total_crm_poin_distributor));
                $tracking->update(array('total_crm_poin_sales' => $total_crm_poin_sales));
                $tracking->update(array('total_bonus_penjualan_sales' => $total_bonus_penjualan_sales));

                $dist = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
                $dist->update(array('crm_poin' => $total_crm_poin_distributor + $dist->crm_poin));
                $sales = User::where('id', auth()->user()->id)->first();
                $sales->update(array('crm_poin' => $total_crm_poin_sales + $sales->crm_poin));
                $sales->update(array('bonus_penjualan_sales' => $total_bonus_penjualan_sales + $sales->bonus_penjualan_sales));

                $newActivity['id_user'] = auth()->user()->id;
                $newActivity['id_group'] = auth()->user()->id_group;
                $newActivity['kegiatan'] = "Create Penjualan Toko '".$validateData['nama_toko']."'";
                UserHistory::create($newActivity);
                
                Session::flash('create_success', 'Data tracking sales berhasil dibuat');
                return redirect('/sales/tracking/'.auth()->user()->id);
            }
            Session::flash('create_failed', 'produk :'.$list.' kurang');
            return back();
        }
        return back();
    }

    public function viewDetailTrackingHistory($id_tracking)
    {
        if(auth()->user()->lihat_tracking_sales == 1)
        {
            $history = TrackingSalesHistory::where('id', $id_tracking)->first();
            $details = TrackingSalesDetail::where('id_tracking_sales', $id_tracking)->get();
            return view('manage_sales.tracking.detail', compact('history', 'details'));
        }
        
        return back();
    }

    public function printTrackingHistory($id_sales)
    {
        $histories = TrackingSalesHistory::where('id_reseller', $id_sales)->get();
        $sales = User::where('id', $id_sales)->first();
        return view('manage_sales.tracking.print', compact(['histories', 'sales']));
    }

    public function exportTrackingHistory($id_sales)
    {
        $histories = TrackingSalesHistory::where('id_reseller', $id_sales)->get();
        $sales = User::where('id', $id_sales)->first();
        $pdf = PDF::loadView('manage_sales.tracking.export', compact(['histories','sales']));
        return $pdf->download('Tracking Sales - '.$sales->firstname." ".$sales->lastname." - ".date('F Y').'.pdf');
    }

    public function printDetailTrackingHistory($id_tracking)
    {
        $history = TrackingSalesHistory::where('id', $id_tracking)->first();
        $details = TrackingSalesDetail::where('id_tracking_sales', $id_tracking)->get();
        return view('manage_sales.tracking.print_detail', compact('history', 'details'));
    }

    public function exportDetailTrackingHistory($id_tracking)
    {
        $history = TrackingSalesHistory::where('id', $id_tracking)->first();
        $details = TrackingSalesDetail::where('id_tracking_sales', $id_tracking)->get();
        $pdf = PDF::loadView('manage_sales.tracking.export_detail', compact(['history', 'details']));
        return $pdf->download('Pembelian toko - '.$history->nama_toko." - ".$history->created_at->format('d/m/y H:i:s').'.pdf');
    }

// BARANG
    public function viewProduct($id_sales)
    {
        $sales = User::where('id', $id_sales)->first();
        $products = Product::where('id_owner', $id_sales)->get();
        return view('manage_sales.product.index', compact(['sales', 'products']));
    }

    public function editProduct($id_product)
    {
        $product = Product::where('id', $id_product)->first();
        $type = ProductType::where('id', $product->id_productType)->first();
        return response()->json(['product' => $product, 'type' => $type]);
    }

    public function updateProduct(Request $request)
    {
        $validateData['stok'] = $request->stok;
        $validateData['harga_jual'] = $request->harga_jual;

        $product = Product::where('id', $request->id)->first();
        $product->update($validateData);


        $newActivity['id_user'] = auth()->user()->id;
        $newActivity['id_group'] = auth()->user()->id_group;
        $newActivity['kegiatan'] = "Edit Stok Sales '". $product->product_type->nama_produk."'";
        UserHistory::create($newActivity);


        Session::flash('update_success', 'Stok berhasil diubah');

        return redirect('/sales/product/'.$product->id_owner);
    }

    public function createStokProduct($id_sales)
    {
        return view('manage_sales.product.create', compact(['id_sales']));
    }

    public function checkStokProduct(Request $request)
    {
        $salesProduct = Product::find($request->idItem);
        $distributor = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
        $detailProduct = Product::where('id_productType', $salesProduct->id_productType)->where('id_owner', $distributor->id)->first();

        return response()->json(["code" =>"check", "detailDistributor"=> $detailProduct, "detail"=> $salesProduct]);
    }

    public function getListSalesProduct(Request $request)
    {
        $sales = User::where('id', $request->idSales)->first();
        $products = Product::where('id_owner', $sales->id)->select('*')->get();
        
        $output = "<option value='0' selected disabled>Silahkan Pilih Barang</option>";
        foreach($products as $product)
        {
            $productName=ProductType::where('id',$product->id_productType)->first();
            $output.='<option value='.$product->id.'>'.$productName->nama_produk.'</option>';
        }

        return response()->json($output);
    }

    public function storeStokProduct(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        
        $distributor = User::where('id_group',auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
        $sales = User::where('id', $request->idSales)->first();

        $data=[
            'id_group'=>auth()->user()->id_group,
            'id_distributor'=>$distributor->id,
            'id_owner'=>$sales->id,
            'id_input'=>auth()->user()->id,
            'nama_input'=>auth()->user()->firstname." ".auth()->user()->lastname,
            'status_pesanan'=>0,
        ];
        SalesStokHistory::create($data);

        $newActivity['id_user'] = auth()->user()->id;
        $newActivity['id_group'] = auth()->user()->id_group;
        $newActivity['kegiatan'] = "Menambahkan Stok Sales '".$sales->firstname." ".$sales->lastname."'";
        UserHistory::create($newActivity);
        
        $lastHistory = SalesStokHistory::latest()->first();

        $dataBarang = $request->cart;

        $tempTotal = 0;
        for($i=0; $i< count($dataBarang); $i++)
        {
            $detail = [
                'id_sales_stok'=>$lastHistory->id,
                'id_product'=>$dataBarang[$i][4],
                'nama_produk'=>$dataBarang[$i][0],
                'jumlah'=>$dataBarang[$i][1],
                'harga_jual'=>$dataBarang[$i][2],
                'total'=>$dataBarang[$i][3],
            ];

            $tempTotal+= $detail['jumlah']*$detail['harga_jual'];
            SalesStokDetail::create($detail);

            $sales_produk = Product::where('id', $detail['id_product'])->first();
            $dist_produk = Product::where('id_productType', $sales_produk->id_productType)->where('id_owner', $distributor->id)->first();
            $dist_produk->update(array('stok' => $dist_produk->stok - $detail['jumlah']));
        }

        $lastHistory->update(array('total' => $tempTotal));

        // $job = $lastHistory->update(array('status' => 1))->delay(Carbon::now()->addMinutes(1));
        // dispatch($job);

        return response()->json(["code" =>"check"]); 
        
    }

    public function printProduct($id_sales){
        $sales = User::where('id', $id_sales)->first();
        $products = Product::where('id_owner', $id_sales)->get();
        return view('manage_sales.product.print', compact(['sales', 'products']));
    }

    public function exportProduct($id_sales){
        $sales = User::where('id', $id_sales)->first();
        $products = Product::where('id_owner', $id_sales)->get();

        $pdf = PDF::loadView('manage_sales.product.export', compact(['sales', 'products']));
        return $pdf->download('Produk Sales - '.$sales->firstname.' '.$sales->lastname.' - '.date('F Y').'.pdf');
    }

// HISTORY BONUS

    public function viewHistory($id_sales)
    {
        $sales = User::where('id', $id_sales)->first();
        return view('manage_sales.history.index', compact(['sales']));
    }

    public function getHistory(Request $request)
    {
        $output = '
        <table id="logTable" class="table table-hover table-light">
            <thead>
                <tr>
                    <th>Tanggal Bonus Masuk</th>
                    <th>Jumlah Bonus Masuk</th>
                </tr>
            </thead>
            <tbody>';

        $histories = TrackingSalesHistory::where('id_reseller', $request->id_sales)->where('total_bonus_penjualan_sales', '>', 0)->where('id_akumulasi_bonus_penjualan_sales', 0)->get();

        $akumulasis = AkumulasiBonusPenjualanSales::all();
        
        $ctr=1;

        foreach($akumulasis as $akumulasi)
        {
            $totalBonus = TrackingSalesHistory::where('id_reseller', $request->id_sales)->where('id_akumulasi_bonus_penjualan_sales', $akumulasi->id)->sum('total_bonus_penjualan_sales');
            $output.='
            <tr>
                <td>'.$akumulasi->updated_at->format('d/m/y H:i:s').' - '.$akumulasi->keterangan.'</td>
                <td>Rp. '.number_format($totalBonus, 0, ',', '.').'</td>
            </tr>
            ';
            $ctr++;
        }

        foreach($histories as $history)
        {
            $output.='
            <tr>
                <td>'.$history->created_at->format('d/m/y H:i:s').'</td>
                <td>Rp. '.number_format($history->total_bonus_penjualan_sales, 0, ',', '.').'</td>
            </tr>
            ';
            $ctr++;
        }   

        $output .= '</tbody>
        </table>';
        return response()->json($output);
    }

    public function getHistoryDate(Request $request)
    {
        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();

        $output = '
        <table id="logTable" class="table table-hover table-light">
            <thead>
                <tr>
                    <th>Tanggal Bonus Masuk</th>
                    <th>Jumlah Bonus Masuk</th>
                </tr>
            </thead>
            <tbody>';

        $histories = TrackingSalesHistory::where('id_reseller', $request->id_sales)->where('total_bonus_penjualan_sales', '>', 0)->get();

        if($request->min != "" && $request->max !="")
        {
            $histories = TrackingSalesHistory::where('id_reseller', $request->id_sales)->where('total_bonus_penjualan_sales', '>', 0)->whereBetween('tracking_sales_histories.created_at', [$from, $to])->get();
        }
        else if($request->min == "" && $request->max == "")
        {
            $histories = TrackingSalesHistory::where('id_reseller', $request->id_sales)->where('total_bonus_penjualan_sales', '>', 0)->where('id_akumulasi_bonus_penjualan_sales', 0)->get();
            $akumulasis = AkumulasiBonusPenjualanSales::all();

            foreach($akumulasis as $akumulasi)
            {
                $totalBonus = TrackingSalesHistory::where('id_reseller', $request->id_sales)->where('id_akumulasi_bonus_penjualan_sales', $akumulasi->id)->sum('total_bonus_penjualan_sales');
                $output.='
                <tr>
                    <td>'.$akumulasi->updated_at->format('d/m/y H:i:s').' - '.$akumulasi->keterangan.'</td>
                    <td>Rp. '.number_format($totalBonus, 0, ',', '.').'</td>
                </tr>
                ';
            }
        }
        else if($request->min == "")
        {
            $histories = TrackingSalesHistory::where('id_reseller', $request->id_sales)->where('total_bonus_penjualan_sales', '>', 0)->whereDate('tracking_sales_histories.created_at', '<' ,$to)->get();
        }
        else if($request->max == "")
        {
            $histories = TrackingSalesHistory::where('id_reseller', $request->id_sales)->where('total_bonus_penjualan_sales', '>', 0)->whereDate('tracking_sales_histories.created_at', '>' ,$from)->get();
        }

        $ctr=1;
        foreach($histories as $history)
        {
            $output.='
            <tr>
                <td>'.$history->created_at->format('d/m/y H:i:s').'</td>
                <td>Rp. '.number_format($history->total_bonus_penjualan_sales, 0, ',', '.').'</td>
            </tr>
            ';
            $ctr++;
        }   

        $output .= '</tbody>
        </table>';
        return response()->json($output);
    }

    public function printHistoryBonus($id_sales){
        $sales = User::where('id', $id_sales)->first();
        $histories = TrackingSalesHistory::where('id_reseller', $sales->id)->where('total_bonus_penjualan_sales', '>', 0)->get();

        return view('manage_sales.history.print_history_bonus', compact(['sales', 'histories']));
    }

    public function exportHistoryBonus($id_sales){
        $sales = User::where('id', $id_sales)->first();
        $histories = TrackingSalesHistory::where('id_reseller', $sales->id)->where('total_bonus_penjualan_sales', '>', 0)->get();

        $pdf = PDF::loadView('manage_sales.history.export_history_bonus', compact(['sales', 'histories']));
        return $pdf->download('History Bonus - '.$sales->firstname." ".$sales->lastname." - ".date('F Y').'.pdf');
    }

// HISTORY ITEM
    public function viewSalesHistoryItems($id_item){
        $product = Product::where('id', $id_item)->first();
        $owner = User::where('id', $product->id_owner)->first();
        $keluar = TrackingSalesDetail::join('tracking_sales_histories', 'tracking_sales_histories.id', '=', 'tracking_sales_details.id_tracking_sales')->where('tracking_sales_histories.id_reseller', $owner->id)->where('tracking_sales_details.id_produk', $product->id)->get();
        $masuk = SalesStokDetail::join('sales_stok_histories', 'sales_stok_histories.id', '=', 'sales_stok_details.id_sales_stok')->where('sales_stok_histories.id_owner', $owner->id)->where('status', 1)->where('sales_stok_details.id_product', $product->id)->get();
        return view("manage_sales.history.history_item", compact(['owner', 'product', 'keluar', 'masuk']));
    }

    public function printSalesHistoryItems($id_item){
        $product = Product::where('id', $id_item)->first();
        $owner = User::where('id', $product->id_owner)->first();
        $keluar = TrackingSalesDetail::join('tracking_sales_histories', 'tracking_sales_histories.id', '=', 'tracking_sales_details.id_tracking_sales')->where('tracking_sales_histories.id_reseller', $owner->id)->where('tracking_sales_details.id_produk', $product->id)->get();
        $masuk = SalesStokDetail::join('sales_stok_histories', 'sales_stok_histories.id', '=', 'sales_stok_details.id_sales_stok')->where('sales_stok_histories.id_owner', $owner->id)->where('status', 1)->where('sales_stok_details.id_product', $product->id)->get();
        return view("manage_sales.history.print_history_item", compact(['owner', 'product', 'keluar', 'masuk']));
    }

    public function exportSalesHistoryItems($id_item){
        $product = Product::where('id', $id_item)->first();
        $owner = User::where('id', $product->id_owner)->first();
        $keluar = TrackingSalesDetail::join('tracking_sales_histories', 'tracking_sales_histories.id', '=', 'tracking_sales_details.id_tracking_sales')->where('tracking_sales_histories.id_reseller', $owner->id)->where('tracking_sales_details.id_produk', $product->id)->get();
        $masuk = SalesStokDetail::join('sales_stok_histories', 'sales_stok_histories.id', '=', 'sales_stok_details.id_sales_stok')->where('sales_stok_histories.id_owner', $owner->id)->where('status', 1)->where('sales_stok_details.id_product', $product->id)->get();
        
        $pdf = PDF::loadView('manage_sales.history.export_history_item', compact(['owner', 'product', 'keluar', 'masuk']));
        return $pdf->download('History - '.$product->product_type->nama_produk.' - '.$owner->firstname." ".$owner->lastname." - ".date('F Y').'.pdf');
    }
}
