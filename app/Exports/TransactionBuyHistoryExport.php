<?php

namespace App\Exports;

use App\Models\User;
use App\Models\TransactionHistory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionBuyHistoryExport implements FromView
{   
    public function view(): View
    {
        if(auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales")
        {
            $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            $histories = TransactionHistory::where('id_group', auth()->user()->id_group)->where('id_owner', $owner->id)->get();
            return view('manage_transactions.buy.export', compact(['owner', 'histories']));
        }
        else if(auth()->user()->user_position == "reseller")
        {
            $owner = auth()->user();
            $histories = TransactionHistory::where('id_owner', $owner->id)->get();
            return view('manage_transactions.buy.export', compact(['owner', 'histories']));
        }
    }
}