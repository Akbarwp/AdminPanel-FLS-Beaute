<?php

namespace App\Exports;

use App\Models\User;
use App\Models\ReturHistory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReturHistoryExport implements FromView
{
    public function view(): View
    {
        if (auth()->user()->input_retur == 1 && auth()->user()->id_group != 1) {
            if (auth()->user()->user_position != "reseller") {
                $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
            } else if (auth()->user()->user_position == "reseller") {
                $owner = auth()->user();
            }
        
            $returs = ReturHistory::where('id_owner', $owner->id)->get();
            return view('retur.supplier.exportXlsx', compact('returs'));
        }

        return back();
    }

}
