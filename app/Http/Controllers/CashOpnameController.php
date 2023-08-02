<?php

namespace App\Http\Controllers;

use App\Models\CashOpname;
use App\Http\Controllers\Controller;
use App\Models\TransactionHistory;
use App\Models\TransactionHistorySell;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class CashOpnameController extends Controller
{
    public function report()
    {
        $opnames = CashOpname::orderBy('created_at', 'desc')->get();
        return view('cash_opname.report', compact('opnames'));
    }

    public function open()
    {
        $currentDate = Carbon::now()->toDateString();

        $opname = CashOpname::where('user_id', auth()->user()->id)->whereDate('created_at', $currentDate)->first();

        return view('cash_opname.open', compact('opname'));
    }

    public function storeOpen(Request $request)
    {
        try {
            if ($request->cash_awal < 1) {
                return back()->with('create_failed', 'Masukan cash dengan benar');
            }
            CashOpname::create([
                'user_id' => auth()->user()->id,
                'nama_distributor' => $request->nama_distributor,
                'cash_awal' => $request->cash_awal,
                'status' => 1
            ]);
            return back()->with('create_success', "Buka cash berhasil");
        } catch (Exception $e) {
            return $e;
            return back()->with('create_failed', $e);
        }
    }

    public function close()
    {
        $currentDate = Carbon::now()->toDateString();

        $opname = CashOpname::where('user_id', auth()->user()->id)->whereDate('created_at', $currentDate)->first();

        $total_transaksi_kasir = 0;
        $total_transaksi_pusat = 0;
        $cash_awal = 0;
        if ($opname) {
            $cash_awal = $opname->cash_awal;
        }

        $transaksi_kasir = TransactionHistorySell::where('id_owner', auth()->user()->id)->whereDate('created_at', $currentDate)->get();

        // $transaksi_pusat = TransactionHistory::where('id_owner', auth()->user()->id)->whereDate('created_at', $currentDate)->get();

        foreach ($transaksi_kasir as $kasir) {
            $total_transaksi_kasir += $kasir->total;
        }

        // foreach ($transaksi_pusat as $pusat) {
        //     $total_transaksi_pusat += $pusat->total;
        // }

        // $total_transaksi = $cash_awal - $total_transaksi_pusat + $total_transaksi_kasir;
        $total_transaksi = $cash_awal + $total_transaksi_kasir;
        return view('cash_opname.close', compact('opname', 'total_transaksi'));
    }

    public function storeClose(Request $request)
    {
        $currentDate = Carbon::now()->toDateString();

        try {
            if ($request->cash_akhir < 1) {
                return back()->with('create_failed', 'Masukan cash dengan benar');
            }

            $opname = CashOpname::where('user_id', auth()->user()->id)->whereDate('created_at', $currentDate)->where('status', 1)->first();

            $opname->update([
                'total_transaksi' => $request->total_transaksi,
                'cash_akhir' => $request->cash_akhir,
                'selisih' => $request->selisih,
                'status' => 2
            ]);
            return back()->with('create_success', "Buka cash berhasil");
        } catch (Exception $e) {
            return $e;
            return back()->with('create_failed', $e);
        }
    }
}
