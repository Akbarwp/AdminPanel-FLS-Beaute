<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Province;
use App\Models\ReturCashierHistory;
use App\Models\ReturHistory;
use App\Models\SupplyDetail;
use App\Models\SupplyHistory;
use App\Models\TrackingSalesDetail;
use App\Models\TrackingSalesHistory;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TransactionDetail;
use App\Models\TransactionDetailSell;
use App\Models\TransactionHistorySell;
use Illuminate\Support\Carbon;
use PDF;

class ManageReport extends Controller
{

    public function print_manage_report_transaction()
    {
        return view("manage_report.transaction.print_detail");
    }

    // TRANSACTION SELL
    public function indexTransactionSell()
    {
        if (auth()->user()->lihat_laporan_penjualan == 1) {
            if (auth()->user()->id_group == 1) {
                $owner = User::where('id_group', 1)->where('user_position', 'superadmin_pabrik')->first();
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
                $details = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $owner->id)->select('transaction_details.*')->get();
                return view('manage_report.transaction.sell.index_normal', compact(['owner', 'transactions', 'details']));
            } else if (auth()->user()->user_position != "sales" && auth()->user()->user_position != "reseller") {
                $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
                $details = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $owner->id)->select('transaction_details.*')->get();
                $transactions2 = TransactionHistorySell::where('id_owner', $owner->id)->whereMonth('transaction_history_sells.updated_at', Carbon::now()->month)->get();
                $details2 = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $owner->id)->select('transaction_detail_sells.*')->get();

                return view('manage_report.transaction.sell.index', compact(['owner', 'transactions', 'transactions2', 'details', 'details2']));
            } else if (auth()->user()->user_position == "sales") {
                $owner = auth()->user();
                $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereMonth('tracking_sales_histories.updated_at', Carbon::now()->month)->get();
                $details = TrackingSalesDetail::join('tracking_sales_histories', 'tracking_sales_histories.id', '=', 'tracking_sales_details.id_tracking_sales')->where('tracking_sales_histories.id_reseller', $owner->id)->select('tracking_sales_details.*')->get();
                return view('manage_report.transaction.sell.index_normal', compact(['owner', 'transactions', 'details']));
            } else if (auth()->user()->user_position == "reseller") {
                $owner = auth()->user();
                $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereMonth('transaction_history_sells.updated_at', Carbon::now()->month)->get();
                $details = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $owner->id)->select('transaction_detail_sells.*')->get();
                return view('manage_report.transaction.sell.index_normal', compact(['owner', 'transactions', 'details']));
            }
        }
        return back();
    }

    public function getDateTransactionSell(Request $request)
    {

        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();

        $output = '
        <table id="logTable" class="table table-hover table-light">
            <thead>
                <tr>
                    <th scope="col">Kode Transaksi</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Total</th>';
        if (auth()->user()->id_group != 1 && auth()->user()->user_position != "sales") {
            $output .= '<th scope="col">Diskon</th>';
        }
        $output .= '<th scope="col">Tanggal</th>';
        if (auth()->user()->user_position != "sales") {
            $output .= '<th scope="col">Metode Pembayaran</th>';
        }
        $output .= '<th scope="col"></th>
                </tr>
            </thead>
            <tbody>';

        if (auth()->user()->id_group == 1) {
            $owner = User::where('id_group', 1)->where('user_position', 'superadmin_pabrik')->first();

            if ($request->min != "" && $request->max != "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereBetween('transaction_histories.updated_at', [$from, $to])->where('status_pesanan', 1)->select('*')->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
            } else if ($request->min == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereDate('transaction_histories.updated_at', '<=', $to)->where('status_pesanan', 1)->get();
            } else if ($request->max == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereDate('transaction_histories.updated_at', '>=', $from)->where('status_pesanan', 1)->get();
            }
        } else if (auth()->user()->user_position != "sales" && auth()->user()->user_position != "reseller") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            if ($request->min != "" && $request->max != "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereBetween('transaction_histories.updated_at', [$from, $to])->where('status_pesanan', 1)->select('*')->get();
                $transactions2 = TransactionHistorySell::where('id_owner', $owner->id)->whereBetween('transaction_history_sells.updated_at', [$from, $to])->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
                $transactions2 = TransactionHistorySell::where('id_owner', $owner->id)->whereMonth('transaction_history_sells.updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereDate('transaction_histories.updated_at', '<=', $to)->where('status_pesanan', 1)->get();
                $transactions2 = TransactionHistorySell::where('id_owner', $owner->id)->whereDate('transaction_history_sells.updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereDate('transaction_histories.updated_at', '>=', $from)->where('status_pesanan', 1)->get();
                $transactions2 = TransactionHistorySell::where('id_owner', $owner->id)->whereDate('transaction_history_sells.updated_at', '>=', $from)->get();
            }
        } else if (auth()->user()->user_position == "sales") {
            $owner = auth()->user();
            $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereMonth('tracking_sales_histories.updated_at', Carbon::now()->month)->get();
            if ($request->min != "" && $request->max != "") {
                $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereBetween('tracking_sales_histories.updated_at', [$from, $to])->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereMonth('tracking_sales_histories.updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereDate('tracking_sales_histories.updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereDate('tracking_sales_histories.updated_at', '>=', $from)->get();
            }
        } else if (auth()->user()->user_position == "reseller") {
            $owner = auth()->user();
            $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereMonth('transaction_history_sells.updated_at', Carbon::now()->month)->get();

            if ($request->min != "" && $request->max != "") {
                $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereBetween('transaction_history_sells.updated_at', [$from, $to])->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereMonth('transaction_history_sells.updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereDate('transaction_history_sells.updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereDate('transaction_history_sells.updated_at', '>=', $from)->get();
            }
        }

        foreach ($transactions as $transaction) {

            if (auth()->user()->user_position == "sales") {
                $customerName = $transaction->nama_toko;
                $code = $transaction->id;
                $type = "tracking";
            } else if (auth()->user()->user_position == "reseller") {
                $customerName = "Transaksi Kasir";
                $code = $transaction->transaction_code;
                $type = "kasir";
            } else {
                $customer = User::where('id', $transaction->id_owner)->first();
                $customerName = $customer->firstname . ' ' . $customer->lastname;
                $code = $transaction->transaction_code;
                $type = "beli";
            }
            $direct = url('/manage_report/transaction/sell/print_detail/' . $transaction->id . '/' . $type);


            $output .= '
            <tr id="' . $transaction->id . '">
                <td>' . $code . '</td>
                <td>' . $customerName . '</td>
                <td>Rp. ' . number_format($transaction->total, 0, ',', '.') . '</td>';
            if ($owner->user_position == "reseller" || $owner->user_position == "superadmin_distributor") {
                $output .= '<td>Rp. ' . number_format($transaction->diskon, 0, ',', '.') . '</td>';
            }
            // else if($owner->user_position == "superadmin_distributor")
            // {
            //     $output.='<td>-</td>';
            // }
            $output .= '<td>' . $transaction->updated_at->format('d/m/y H:i:s') . '</td>';
            if ($owner->user_position != "sales") {
                $output .= '<td>' . $transaction->metode_pembayaran . '</td>';
            }
            $output .= '
                <td class="col-2">
                    <div class="col text-left">
                    
                        <button type="button" class="btn btn-primary" onclick="window.open(`' . $direct . '`)">
                            <span><i class="fa fa-edit" ></i>Print</span>
                        </button>
                        <button type="button" class="btn btn-link carousel" onclick="functionDetail(' . $transaction->id . ')">
                            <span><i class="fa fa-angle-down"></i></span>
                        </button>
                    </div>
                </td>
            </tr>';
        }

        if ($owner->user_position == "superadmin_distributor") {
            foreach ($transactions2 as $transaction) {
                $type = "kasir";
                $direct = url('/manage_report/transaction/sell/print_detail/' . $transaction->id . '/' . $type);

                $customerName = 'Transaksi Kasir';
                $code = $transaction->transaction_code;

                $output .= '
                <tr id="khusus' . $transaction->id . '">
                    <td>' . $code . '</td>
                    <td>' . $customerName . '</td>
                    <td>Rp. ' . number_format($transaction->total, 0, ',', '.') . '</td>
                    <td>Rp. ' . number_format($transaction->diskon, 0, ',', '.') . '</td>
                    <td>' . $transaction->updated_at->format('d/m/y H:i:s') . '</td>
                    <td>' . $transaction->metode_pembayaran . '</td>
                    <td>
                        <div class="col text-left">
                            <button type="button" class="btn btn-primary" onclick="window.open(`' . $direct . '`)">
                                <span><i class="fa fa-edit" ></i>Print</span>
                            </button>
                            <button type="button" class="btn btn-link carousel" onclick="functionDetail2(' . $transaction->id . ')">
                                <span><i class="fa fa-angle-down"></i></span>
                            </button>
                        </div>
                    </td>
                </tr>';
            }
        }
        $output .= '</tbody>
        </table>
        <br>
        <h4>Total : Rp. <span id="totalAll"></span></h4>';
        return response()->json($output);
    }

    public function printTransactionSell(Request $request)
    {

        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();

        if (auth()->user()->id_group == 1) {
            $owner = User::where('id_group', 1)->where('user_position', 'superadmin_pabrik')->first();

            if ($request->min != "" && $request->max != "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereBetween('transaction_histories.updated_at', [$from, $to])->where('status_pesanan', 1)->select('*')->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
            } else if ($request->min == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereDate('transaction_histories.updated_at', '<=', $to)->where('status_pesanan', 1)->get();
            } else if ($request->max == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereDate('transaction_histories.updated_at', '>=', $from)->where('status_pesanan', 1)->get();
            }
        } else if (auth()->user()->user_position != "sales" && auth()->user()->user_position != "reseller") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            if ($request->min != "" && $request->max != "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereBetween('transaction_histories.updated_at', [$from, $to])->where('status_pesanan', 1)->select('*')->get();
                $transactions2 = TransactionHistorySell::where('id_owner', $owner->id)->whereBetween('transaction_history_sells.updated_at', [$from, $to])->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
                $transactions2 = TransactionHistorySell::where('id_owner', $owner->id)->whereMonth('transaction_history_sells.updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereDate('transaction_histories.updated_at', '<=', $to)->where('status_pesanan', 1)->get();
                $transactions2 = TransactionHistorySell::where('id_owner', $owner->id)->whereDate('transaction_history_sells.updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $transactions = TransactionHistory::where('id_distributor', $owner->id)->whereDate('transaction_histories.updated_at', '>=', $from)->where('status_pesanan', 1)->get();
                $transactions2 = TransactionHistorySell::where('id_owner', $owner->id)->whereDate('transaction_history_sells.updated_at', '>=', $from)->get();
            }

            if ($request->type == "print") {
                return view('manage_report.transaction.sell.print', compact(['transactions', 'transactions2', 'owner']));
            } else if ($request->type == "export") {
                $pdf = PDF::loadView('manage_report.transaction.sell.export', compact(['transactions', 'transactions2', 'owner']));
                return $pdf->download('Laporan Transaksi Penjualan - ' . date('F Y') . '.pdf');
            }
        } else if (auth()->user()->user_position == "sales") {
            $owner = auth()->user();
            $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereMonth('tracking_sales_histories.updated_at', Carbon::now()->month)->get();
            if ($request->min != "" && $request->max != "") {
                $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereBetween('tracking_sales_histories.updated_at', [$from, $to])->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereMonth('tracking_sales_histories.updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereDate('tracking_sales_histories.updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $transactions = TrackingSalesHistory::where('id_reseller', $owner->id)->whereDate('tracking_sales_histories.updated_at', '>=', $from)->get();
            }
        } else if (auth()->user()->user_position == "reseller") {
            $owner = auth()->user();
            $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereMonth('transaction_history_sells.updated_at', Carbon::now()->month)->get();

            if ($request->min != "" && $request->max != "") {
                $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereBetween('transaction_history_sells.updated_at', [$from, $to])->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereMonth('transaction_history_sells.updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereDate('transaction_history_sells.updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $transactions = TransactionHistorySell::where('id_owner', $owner->id)->whereDate('transaction_history_sells.updated_at', '>=', $from)->get();
            }
        }


        if ($request->type == "print") {
            return view('manage_report.transaction.sell.print', compact(['transactions', 'owner']));
        } else if ($request->type == "export") {
            $pdf = PDF::loadView('manage_report.transaction.sell.export', compact(['transactions', 'owner']));
            return $pdf->download('Laporan Transaksi Penjualan - ' . date('F Y') . '.pdf');
        }
    }

    public function printDetailTransactionSell($id, $type)
    {
        // dd($type);
        if (auth()->user()->id_group == 1) {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();
        } else if (auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
        } else {
            $owner = auth()->user();
        }

        if ($type == "kasir") {
            $transaction = TransactionHistorySell::where('id', $id)->first();
            $customer = "Transaksi Kasir";
            $details = TransactionDetailSell::where('id_transaction', $transaction->id)->get();
        } else if ($type == "beli") {
            $transaction = TransactionHistory::where('id', $id)->first();
            $cust = User::where('id', $transaction->id_owner)->first();
            $customer = $cust->firstname . ' ' . $cust->lastname;
            $details = TransactionDetail::where('id_transaction', $transaction->id)->get();
        } else if ($type == "tracking") {
            $transaction = TrackingSalesHistory::where('id', $id)->first();
            $customer = $transaction->nama_toko;
            $details = TrackingSalesDetail::where('id_tracking_sales', $transaction->id)->get();
        }

        return view('manage_report.transaction.sell.print_detail', compact(['owner', 'transaction', 'details', 'customer']));
    }

    // TRANSACTION BUY
    public function indexTransactionBuy()
    {
        if (auth()->user()->id_group == 1) {
            $owner = User::where('id_group', 1)->where('user_position', 'superadmin_pabrik')->first();
            $transactions = SupplyHistory::whereMonth('supply_histories.updated_at', Carbon::now()->month)->get();
            $details = SupplyDetail::join('supply_histories', 'supply_histories.id', '=', 'supply_details.id_supply')->select('supply_details.*')->get();
            return view('manage_report.transaction.buy.index', compact(['owner', 'transactions', 'details']));
        } else if (auth()->user()->user_position != "sales" && auth()->user()->user_position != "reseller") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $transactions = TransactionHistory::where('id_owner', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
            $details = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $owner->id)->select('transaction_details.*')->get();

            return view('manage_report.transaction.buy.index', compact(['owner', 'transactions', 'details']));
        } else if (auth()->user()->user_position == "reseller") {
            $owner = auth()->user();
            $transactions = TransactionHistory::where('id_owner', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
            $details = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_owner', $owner->id)->select('transaction_details.*')->get();
            return view('manage_report.transaction.buy.index', compact(['owner', 'transactions', 'details']));
        }
    }

    public function getDateTransactionBuy(Request $request)
    {
        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();

        $output = '
        <table id="logTable" class="table table-hover table-light">
            <thead>
                <tr>
                    <th scope="col">Kode Transaksi</th>
                    <th scope="col">Total</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Metode Pembayaran</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>';

        if (auth()->user()->id_group == 1) {
            $owner = User::where('id_group', 1)->where('user_position', 'superadmin_pabrik')->first();

            if ($request->min != "" && $request->max != "") {
                $transactions = SupplyHistory::whereBetween('supply_histories.updated_at', [$from, $to])->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = SupplyHistory::whereMonth('supply_histories.updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $transactions = SupplyHistory::whereDate('supply_histories.updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $transactions = SupplyHistory::whereDate('supply_histories.updated_at', '>=', $from)->get();
            }
        } else if (auth()->user()->user_position != "sales" && auth()->user()->user_position != "reseller") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            if ($request->min != "" && $request->max != "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereBetween('transaction_histories.updated_at', [$from, $to])->where('status_pesanan', 1)->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
            } else if ($request->min == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereDate('transaction_histories.updated_at', '<=', $to)->where('status_pesanan', 1)->get();
            } else if ($request->max == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereDate('transaction_histories.updated_at', '>=', $from)->where('status_pesanan', 1)->get();
            }
        } else if (auth()->user()->user_position == "reseller") {
            $owner = auth()->user();

            if ($request->min != "" && $request->max != "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereBetween('transaction_histories.updated_at', [$from, $to])->where('status_pesanan', 1)->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
            } else if ($request->min == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereDate('transaction_histories.updated_at', '<=', $to)->where('status_pesanan', 1)->get();
            } else if ($request->max == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereDate('transaction_histories.updated_at', '>=', $from)->where('status_pesanan', 1)->get();
            }
        }

        foreach ($transactions as $transaction) {
            if ($owner->user_position == "superadmin_pabrik") {
                $code = $transaction->kode_pasok;
            } else {
                $code = $transaction->transaction_code;
            }

            if (auth()->user()->id_group == 1) {
                $direct = url('/manage_report/transaction/buy/print_detail/' . $transaction->id . '/pasok');
            } else {
                $direct = url('/manage_report/transaction/buy/print_detail/' . $transaction->id . '/beli');
            }


            $output .= '
            <tr id="' . $transaction->id . '">
                <td>' . $code . '</td>
                <td>Rp. ' . number_format($transaction->total, 0, ',', '.') . '</td>';
            $output .= '<td>' . $transaction->updated_at->format('d/m/y H:i:s') . '</td>
                <td>' . $transaction->metode_pembayaran . '</td>';

            $output .= '
                <td class="col-2">
                    <div class="col text-left">
                    
                        <button type="button" class="btn btn-primary" onclick="window.open(`' . $direct . '`)">
                            <span><i class="fa fa-edit" ></i>Print</span>
                        </button>
                        <button type="button" class="btn btn-link carousel" onclick="functionDetail(' . $transaction->id . ')">
                            <span><i class="fa fa-angle-down"></i></span>
                        </button>
                    </div>
                </td>
            </tr>';
        }
        $output .= '</tbody>
        </table>
        <br>
        <h4>Total : Rp. <span id="totalAll"></span></h4>';
        return response()->json($output);
    }

    public function printTransactionBuy(Request $request)
    {

        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();

        if (auth()->user()->id_group == 1) {
            $owner = User::where('id_group', 1)->where('user_position', 'superadmin_pabrik')->first();

            if ($request->min != "" && $request->max != "") {
                $transactions = SupplyHistory::whereBetween('supply_histories.updated_at', [$from, $to])->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = SupplyHistory::whereMonth('supply_histories.updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $transactions = SupplyHistory::whereDate('supply_histories.updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $transactions = SupplyHistory::whereDate('supply_histories.updated_at', '>=', $from)->get();
            }
        } else if (auth()->user()->user_position != "sales" && auth()->user()->user_position != "reseller") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();

            if ($request->min != "" && $request->max != "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereBetween('transaction_histories.updated_at', [$from, $to])->where('status_pesanan', 1)->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
            } else if ($request->min == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereDate('transaction_histories.updated_at', '<=', $to)->where('status_pesanan', 1)->get();
            } else if ($request->max == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereDate('transaction_histories.updated_at', '>=', $from)->where('status_pesanan', 1)->get();
            }
        } else if (auth()->user()->user_position == "reseller") {
            $owner = auth()->user();

            if ($request->min != "" && $request->max != "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereBetween('transaction_histories.updated_at', [$from, $to])->where('status_pesanan', 1)->get();
            } else if ($request->min == "" && $request->max == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereMonth('transaction_histories.updated_at', Carbon::now()->month)->where('status_pesanan', 1)->get();
            } else if ($request->min == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereDate('transaction_histories.updated_at', '<=', $to)->where('status_pesanan', 1)->get();
            } else if ($request->max == "") {
                $transactions = TransactionHistory::where('id_owner', $owner->id)->whereDate('transaction_histories.updated_at', '>=', $from)->where('status_pesanan', 1)->get();
            }
        }

        if ($request->type == "print") {
            return view('manage_report.transaction.buy.print', compact(['transactions', 'owner']));
        } else if ($request->type == "export") {
            $pdf = PDF::loadView('manage_report.transaction.buy.export', compact(['transactions', 'owner']));
            return $pdf->download('Laporan Transaksi Pembelian - ' . date('F Y') . '.pdf');
        }
    }

    public function printDetailTransactionBuy($id, $type)
    {
        // dd($type);
        if ($type == "pasok") {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();
            $transaction = SupplyHistory::where('id', $id)->first();
            $details = SupplyDetail::where('id_supply', $transaction->id)->get();
        } else if ($type == "beli") {
            if (auth()->user()->user_position == "reseller") {
                $owner = auth()->user();
            } else {
                $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            }
            $transaction = TransactionHistory::where('id', $id)->first();
            $details = TransactionDetail::where('id_transaction', $transaction->id)->get();
        }

        return view('manage_report.transaction.buy.print_detail', compact(['owner', 'transaction', 'details']));
    }

    // PEGAWAI
    public function indexUser()
    {
        if (auth()->user()->lihat_laporan_pegawai == 1) {
            if (auth()->user()->id_group == 1) {
                $pegawais = User::where('id_group', auth()->user()->id_group)->where('user_position', '!=', 'prospek_distributor')->get();
            } else {
                $pegawais = User::where('id_group', auth()->user()->id_group)->where('user_position', '!=', 'prospek_reseller')->where('user_position', '!=', 'reseller')->get();
            }

            return view('manage_report.user.index', compact('pegawais'));
        }

        return back();
    }

    public function getDateUser(Request $request)
    {

        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();

        if (auth()->user()->user_position == "superadmin_pabrik") {
            if ($request->min != "" && $request->max != "") {
                $pegawais = User::where('user_position', 'superadmin_distributor')
                    ->whereBetween('updated_at', [$from, $to])
                    ->select('*')
                    ->get();
            } else if ($request->min == "" && $request->max == "") {
                $pegawais = User::where('user_position', 'superadmin_distributor')
                    ->whereMonth('updated_at', Carbon::now()->month)
                    ->get();
            } else if ($request->min == "") {
                $pegawais = User::where('user_position', 'superadmin_distributor')
                    ->whereDate('updated_at', '<=', $to)
                    ->get();
            } else if ($request->max == "") {
                $pegawais = User::where('user_position', 'superadmin_distributor')
                    ->whereDate('updated_at', '>=', $from)
                    ->get();
            }
        } else if (auth()->user()->user_position == "superadmin_distributor") {
            if ($request->min != "" && $request->max != "") {
                $pegawais = User::where('user_position', 'sales')
                    ->where('id_group', auth()->user()->id_group)
                    ->whereBetween('updated_at', [$from, $to])
                    ->get();
            } else if ($request->min == "" && $request->max == "") {
                $pegawais = User::where('user_position', 'sales')
                    ->where('id_group', auth()->user()->id_group)
                    ->whereMonth('updated_at', Carbon::now()->month)
                    ->get();
            } else if ($request->min == "") {
                $pegawais = User::where('user_position', 'sales')
                    ->where('id_group', auth()->user()->id_group)
                    ->whereDate('updated_at', '<=', $to)
                    ->get();
            } else if ($request->max == "") {
                $pegawais = User::where('user_position', 'sales')
                    ->where('id_group', auth()->user()->id_group)
                    ->whereDate('updated_at', '>=', $from)
                    ->get();
            }
        } else if (auth()->user()->user_position == "sales") {
            $owner = auth()->user();
            if ($request->min != "" && $request->max != "") {
                $pegawais = User::where('user_position', 'reseller')
                    ->where('id_group', $owner->id_group)
                    ->whereBetween('updated_at', [$from, $to])
                    ->get();
            } else if ($request->min == "" && $request->max == "") {
                $pegawais = User::where('user_position', '==', 'reseller')
                    ->where('id_group', $owner->id_group)
                    ->whereMonth('updated_at', Carbon::now()->month)
                    ->get();
            } else if ($request->min == "") {
                $pegawais = User::where('user_position', '==', 'reseller')
                    ->where('id_group', $owner->id_group)
                    ->whereDate('updated_at', '<=', $to)
                    ->get();
            } else if ($request->max == "") {
                $pegawais = User::where('user_position', '==', 'reseller')
                    ->where('id_group', $owner->id_group)
                    ->whereDate('updated_at', '>=', $from)
                    ->get();
            }
        }

        return view('manage_report.user.index', compact('pegawais'));
    }

    public function printUser()
    {
        if (auth()->user()->lihat_laporan_pegawai == 1) {
            if (auth()->user()->id_group == 1) {
                $pegawais = User::where('id_group', auth()->user()->id_group)->where('user_position', '!=', 'prospek_distributor')->get();
            } else {
                $pegawais = User::where('id_group', auth()->user()->id_group)->where('user_position', '!=', 'prospek_reseller')->where('user_position', '!=', 'reseller')->get();
            }

            return view('manage_report.user.print', compact('pegawais'));
        }
    }

    public function exportUser()
    {
        if (auth()->user()->lihat_laporan_pegawai == 1) {
            if (auth()->user()->id_group == 1) {
                $pegawais = User::where('id_group', auth()->user()->id_group)->where('user_position', '!=', 'prospek_distributor')->get();
            } else {
                $pegawais = User::where('id_group', auth()->user()->id_group)->where('user_position', '!=', 'prospek_reseller')->where('user_position', '!=', 'reseller')->get();
            }

            $pdf = PDF::loadView('manage_report.user.export', compact('pegawais'));
            return $pdf->download('Laporan Pegawai - ' . date('j F Y') . '.pdf');
        }
    }

    public function detailUser($id)
    {
        if (auth()->user()->lihat_laporan_pegawai == 1) {
            $user = User::where('id', $id)->first();
            return view('manage_report.user.detail', compact('user'));
        }
    }

    public function printDetailUser($id)
    {
        if (auth()->user()->id_group == 1) {
            $user = User::where('id', $id)->first();
            $pembelians = SupplyHistory::where('id_input', $id)->get();
            $juals = TransactionHistory::where('id_approve', $id)->get();

            return view('manage_report.user.printDetail', compact(['user', 'pembelians', 'juals']));
        } else {
            $user = User::where('id', $id)->first();
            $pembelians = TransactionHistory::where('id_input', $id)->get();
            $juals = TransactionHistory::where('id_approve', $id)->get();
            $jualKasirs = TransactionHistorySell::where('id_input', $id)->get();
            $jualTrackings = TrackingSalesHistory::where('id_reseller', $id)->get();

            return view('manage_report.user.printDetail', compact(['user', 'pembelians', 'juals', 'jualKasirs', 'jualTrackings']));
        }
        return back();
    }

    public function exportDetailUser($id)
    {
        if (auth()->user()->id_group == 1) {
            $user = User::where('id', $id)->first();
            $pembelians = SupplyHistory::where('id_input', $id)->get();
            $juals = TransactionHistory::where('id_approve', $id)->get();

            $pdf = PDF::loadView('manage_report.user.exportDetail', compact(['user', 'pembelians', 'juals']));
            return $pdf->download('Laporan Pegawai ' . $user->firstname . ' ' . $user->lastname . ' - ' . date('F Y') . '.pdf');
        } else {
            $user = User::where('id', $id)->first();
            $pembelians = TransactionHistory::where('id_input', $id)->get();
            $juals = TransactionHistory::where('id_approve', $id)->get();
            $jualKasirs = TransactionHistorySell::where('id_input', $id)->get();
            $jualTrackings = TrackingSalesHistory::where('id_reseller', $id)->get();

            $pdf = PDF::loadView('manage_report.user.exportDetail', compact(['user', 'pembelians', 'juals', 'jualKasirs', 'jualTrackings']));
            return $pdf->download('Laporan Pegawai ' . $user->firstname . ' ' . $user->lastname . ' - ' . date('F Y') . '.pdf');
        }
        return back();
    }

    public function getPembelianUser()
    {
        if (auth()->user()->id_group == 1) {
            $output = "
            <table id='myTable' class='table table-hover table-striped table-light' style='text-align:left;'>
            <thead>
                <tr>
                    <th scope='col'>Tanggal</th>
                    <th scope='col'>Kode Pasok</th>
                    <th scope='col'>Nama Supplier</th>
                    <th scope='col'>Surat Jalan</th>
                    <th scope='col'>Total</th>
                </tr>
            </thead>
            <tbody>";
            $id = $_GET['ajaxid'];
            $pembelians = SupplyHistory::where('id_input', $id)->get();

            foreach ($pembelians as $pembelian) {
                $output .= "
                    <tr>
                        <td scope='col'>" . $pembelian->created_at->format('d/m/y H:i:s') . "</td>
                        <td scope='col'>" . $pembelian->kode_pasok . "</td>
                        <td scope='col'>" . $pembelian->nama_supplier . "</td>
                        <td scope='col'>" . $pembelian->surat_jalan . "</td>
                        <td scope='col'>Rp. " . number_format($pembelian->total, 0, ',', '.') . "</td>
                    </tr>";
            }

            $output .= "</tbody></table>";
        } else {
            $output = "
            <table id='myTable' class='table table-hover table-striped table-light' style='text-align:left;'>
            <thead>
                <tr>
                    <th scope='col'>Tanggal</th>
                    <th scope='col'>Kode Transaksi</th>
                    <th scope='col'>Total</th>
                </tr>
            </thead>
            <tbody>";

            $id = $_GET['ajaxid'];
            $pembelians = TransactionHistory::where('id_input', $id)->get();

            foreach ($pembelians as $pembelian) {
                $output .= "
                    <tr>
                        <td scope='col'>" . $pembelian->updated_at->format('d/m/y H:i:s') . "</td>
                        <td scope='col'>" . $pembelian->transaction_code . "</td>
                        <td scope='col'>Rp. " . number_format($pembelian->total, 0, ',', '.') . "</td>
                    </tr>";
            }

            $output .= "</tbody></table>";
        }

        return response()->json($output);
    }

    public function getPenjualanUser()
    {
        $output = "
        <table id='myTable' class='table table-hover table-striped table-light' style='text-align:left;'>
        <thead>
            <tr>
                <th scope='col'>Tanggal</th>
                <th scope='col'>Kode Transaksi</th>
                <th scope='col'>Nama Customer</th>
                <th scope='col'>Total</th>
            </tr>
        </thead>
        <tbody>";

        $id = $_GET['ajaxid'];
        $juals = TransactionHistory::where('id_approve', $id)->get();

        foreach ($juals as $jual) {
            $customer = User::where('id', $jual->id_owner)->first();
            $output .= "
                <tr>
                    <td scope='col'>" . $jual->updated_at->format('d/m/y H:i:s') . "</td>
                    <td scope='col'>" . $jual->transaction_code . "</td>
                    <td scope='col'>" . $customer->firstname . " " . $customer->lastname . "</td>
                    <td scope='col'>Rp. " . number_format($jual->total, 0, ',', '.') . "</td>
                </tr>";
        }

        if (auth()->user()->id_group != 1) {
            $jualKasirs = TransactionHistorySell::where('id_input', $id)->get();
            foreach ($jualKasirs as $jualKasir) {
                $customer = "Transaksi Kasir";
                $output .= "
                    <tr>
                        <td scope='col'>" . $jualKasir->updated_at->format('d/m/y H:i:s') . "</td>
                        <td scope='col'>" . $jualKasir->transaction_code . "</td>
                        <td scope='col'>" . $customer . "</td>
                        <td scope='col'>Rp. " . number_format($jualKasir->total, 0, ',', '.') . "</td>
                    </tr>";
            }

            $jualTrackings = TrackingSalesHistory::where('id_reseller', $id)->get();
            foreach ($jualTrackings as $jualTracking) {
                $output .= "
                    <tr>
                        <td scope='col'>" . $jualTracking->updated_at->format('d/m/y H:i:s') . "</td>
                        <td scope='col'>" . $jualTracking->id . "</td>
                        <td scope='col'>" . $jualTracking->nama_toko . "</td>
                        <td scope='col'>Rp. " . number_format($jualTracking->total, 0, ',', '.') . "</td>
                    </tr>";
            }
        }

        $output .= "</tbody></table>";

        return response()->json($output);
    }

    // RETUR Cashier
    public function getDateRetur(Request $request)
    {

        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();
        if (auth()->user()->id_group == 1) {
            if ($request->min != "" && $request->max != "") {
                $returs = ReturCashierHistory::whereBetween('updated_at', [$from, $to])
                    ->select('*')
                    ->get();
            } else if ($request->min == "" && $request->max == "") {
                $returs = ReturCashierHistory::whereMonth('updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $users = ReturCashierHistory::whereDate('updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $users = ReturCashierHistory::whereDate('updated_at', '>=', $from)->get();
            }
        } else if (auth()->user()->user_position == "superadmin_distributor") {
            $supplier = User::where('id_group', auth()->user()->id_group)
                ->where('user_position', 'superadmin_distributor')
                ->first();
            if ($request->min != "" && $request->max != "") {
                $returs = ReturCashierHistory::where('id_supplier', $supplier->id)
                    ->whereBetween('updated_at', [$from, $to])
                    ->get();
            } else if ($request->min == "" && $request->max == "") {
                $returs = ReturCashierHistory::where('id_supplier', $supplier->id)
                    ->where('id_group', auth()->user()->id_group)
                    ->whereMonth('updated_at', Carbon::now()->month)
                    ->get();
            } else if ($request->min == "") {
                $returs = ReturCashierHistory::where('id_supplier', $supplier->id)
                    ->where('id_group', auth()->user()->id_group)
                    ->whereDate('updated_at', '<=', $to)
                    ->get();
            } else if ($request->max == "") {
                $returs = ReturCashierHistory::where('id_supplier', $supplier->id)
                    ->where('id_group', auth()->user()->id_group)
                    ->whereDate('updated_at', '>=', $from)
                    ->get();
            }
        } else if (auth()->user()->user_position == "sales") {
            $supplier = User::where('id_group', auth()->user()->id_group)
                ->where('user_position', 'superadmin_distributor')
                ->first();
            if ($request->min != "" && $request->max != "") {
                $returs = ReturCashierHistory::where('id_supplier', $supplier->id)
                    ->whereBetween('updated_at', [$from, $to])
                    ->get();
            } else if ($request->min == "" && $request->max == "") {
                $returs = ReturCashierHistory::where('id_supplier', $supplier->id)
                    ->whereMonth('updated_at', Carbon::now()->month)
                    ->get();
            } else if ($request->min == "") {
                $returs = ReturCashierHistory::where('id_supplier', $supplier->id)
                    ->whereDate('updated_at', '<=', $to)
                    ->get();
            } else if ($request->max == "") {
                $returs = ReturCashierHistory::where('id_supplier', $supplier->id)
                    ->whereDate('updated_at', '>=', $from)
                    ->get();
            }
        }

        return view('retur.cashier.index', compact(['returs']));
    }

    // RETUR Transaksi
    public function getDateReturTransaksi(Request $request)
    {

        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();
        $owner = auth()->user();
        if (auth()->user()->id_group == 1) {
            if ($request->min != "" && $request->max != "") {
                $returs = ReturHistory::whereBetween('updated_at', [$from, $to])
                    ->select('*')
                    ->get();
            } else if ($request->min == "" && $request->max == "") {
                $returs = ReturHistory::whereMonth('updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $users = ReturHistory::whereDate('updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $users = ReturHistory::whereDate('updated_at', '>=', $from)->get();
            }
        } else if (auth()->user()->user_position == "superadmin_distributor") {
            $supplier = User::where('id_group', auth()->user()->id_group)
                ->where('user_position', 'superadmin_distributor')
                ->first();
            if ($request->min != "" && $request->max != "") {
                $returs = ReturHistory::where('id_owner', $supplier->id)
                    ->whereBetween('updated_at', [$from, $to])
                    ->get();
            } else if ($request->min == "" && $request->max == "") {
                $returs = ReturHistory::where('id_owner', $supplier->id)
                    ->where('id_group', auth()->user()->id_group)
                    ->whereMonth('updated_at', Carbon::now()->month)
                    ->get();
            } else if ($request->min == "") {
                $returs = ReturHistory::where('id_owner', $supplier->id)
                    ->where('id_group', auth()->user()->id_group)
                    ->whereDate('updated_at', '<=', $to)
                    ->get();
            } else if ($request->max == "") {
                $returs = ReturHistory::where('id_owner', $supplier->id)
                    ->where('id_group', auth()->user()->id_group)
                    ->whereDate('updated_at', '>=', $from)
                    ->get();
            }
        } else if (auth()->user()->user_position == "sales") {
            $supplier = User::where('id_group', auth()->user()->id_group)
                ->where('user_position', 'superadmin_distributor')
                ->first();
            if ($request->min != "" && $request->max != "") {
                $returs = ReturHistory::where('id_owner', $supplier->id)
                    ->whereBetween('updated_at', [$from, $to])
                    ->get();
            } else if ($request->min == "" && $request->max == "") {
                $returs = ReturHistory::where('id_owner', $supplier->id)
                    ->whereMonth('updated_at', Carbon::now()->month)
                    ->get();
            } else if ($request->min == "") {
                $returs = ReturHistory::where('id_owner', $supplier->id)
                    ->whereDate('updated_at', '<=', $to)
                    ->get();
            } else if ($request->max == "") {
                $returs = ReturHistory::where('id_owner', $supplier->id)
                    ->whereDate('updated_at', '>=', $from)
                    ->get();
            }
        }
        return view('retur.supplier.index', compact(['returs', 'owner']));
    }

    // Product
    public function getDateProduk(Request $request)
    {
        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();

        if (auth()->user()->id_group == 1) {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_pabrik')->first();
            if ($request->min != "" && $request->max != "") {
                $products =
                    Product::where('id_owner', $owner->id)
                    ->whereBetween('updated_at', [$from, $to])
                    ->get();
            } else if ($request->min == "" && $request->max == "") {
                $products =
                    Product::where('id_owner', $owner->id)->whereMonth('updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $products =
                    Product::where('id_owner', $owner->id)->whereDate('updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $products =
                    Product::where('id_owner', $owner->id)->whereDate('updated_at', '>=', $from)->get();
            }
        } else if (auth()->user()->user_position == "superadmin_distributor") {
            $supplier = User::where('id_group', auth()->user()->id_group)
                ->where('user_position', 'superadmin_distributor')
                ->first();
            if ($request->min != "" && $request->max != "") {
                $products =
                    Product::where('id_owner', $supplier->id)->whereBetween('updated_at', [$from, $to])
                    ->get();
            } else if ($request->min == "" && $request->max == "") {
                $products =
                    Product::where('id_owner', $supplier->id)->whereMonth('updated_at', Carbon::now()->month)
                    ->get();
            } else if ($request->min == "") {
                $products =
                    Product::where('id_owner', $supplier->id)->whereDate('updated_at', '<=', $to)
                    ->get();
            } else if ($request->max == "") {
                $products =
                    Product::where('id_owner', $supplier->id)->whereDate('updated_at', '>=', $from)
                    ->get();
            }
        } else if (auth()->user()->user_position == "sales") {
            $supplier = User::where('id_group', auth()->user()->id_group)
                ->where('user_position', 'superadmin_distributor')
                ->first();
            $products = Product::where('id_owner', $supplier->id)->get();
            if ($request->min != "" && $request->max != "") {
                $products = $products->whereBetween('updated_at', [$from, $to])
                    ->get();
            } else if ($request->min == "" && $request->max == "") {
                $products = $products->whereMonth('updated_at', Carbon::now()->month)
                    ->get();
            } else if ($request->min == "") {
                $products = $products->whereDate('updated_at', '<=', $to)
                    ->get();
            } else if ($request->max == "") {
                $products = $products->whereDate('updated_at', '>=', $from)
                    ->get();
            }
        }
        return view('manage_product.main.index', compact(['owner', 'products']));
    }

    // Akun
    public function getDateAkun(Request $request)
    {
        $from = Carbon::create($request->min);
        $to = Carbon::create($request->max)->endOfDay();
        if (auth()->user()->id_group == 1) {
            $users = User::where('id_group', 1)->where('user_position', '!=', 'prospek_distributor')->orWhere('user_position', 'superadmin_distributor');
            if ($request->min != "" && $request->max != "") {
                $users = $users->whereBetween('updated_at', [$from, $to])->get();
            } else if ($request->min == "" && $request->max == "") {
                $users = $users->whereMonth('updated_at', Carbon::now()->month)->get();
            } else if ($request->min == "") {
                $users = $users->whereDate('updated_at', '<=', $to)->get();
            } else if ($request->max == "") {
                $users = $users->whereDate('updated_at', '>=', $from)->get();
            }
        } else if (auth()->user()->user_position == "superadmin_distributor") {
            $users = User::where('id_group', auth()->user()->id_group);
            if ($request->min != "" && $request->max != "") {
                $users = $users->whereBetween('updated_at', [$from, $to])
                    ->get();
            } else if ($request->min == "" && $request->max == "") {
                $users = $users->whereMonth('updated_at', Carbon::now()->month)
                    ->get();
            } else if ($request->min == "") {
                $users = $users->whereDate('updated_at', '<=', $to)
                    ->get();
            } else if ($request->max == "") {
                $users = $users->whereDate('updated_at', '>=', $from)
                    ->get();
            }
        }
        return view('manage_account.index', compact(['users']));
    }
}
