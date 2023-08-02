<?php

namespace App\Exports;

use App\Models\User;
use App\Models\TransactionHistorySell;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionSellHistoryExport implements FromView
{
    public function view(): View
    {
        if(auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales")
        {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->get();
            return view('manage_transactions.sell.export', compact(['owner', 'histories']));
        }
        else if(auth()->user()->user_position == "reseller")
        {
            $owner = auth()->user();
            $histories = TransactionHistorySell::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->get();
            return view('manage_transactions.sell.export', compact(['owner', 'histories']));
        }
    }
}