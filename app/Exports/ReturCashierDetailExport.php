<?php

namespace App\Exports;

use App\Models\ReturCashierHistory;
use App\Models\ReturCashier;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReturCashierDetailExport implements FromView
{
    protected $id;
    
    public function __construct(int $id)
    {
        $this->id = $id;
    } 

    public function view(): View
    {
        if (auth()->user()->input_retur == 1 && auth()->user()->id_group != 1) {
            $retur =   ReturCashierHistory::where('id', $this->id)->first();
            $details = ReturCashier::where('id_retur', $this->id)->get();

            return view('retur.cashier.exportDetailXlsx', compact(['retur', 'details']));
        }
        return back();
    }
}
