<?php

namespace App\Exports;

use App\Models\ReturHistory;
use App\Models\ReturDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReturDetailHistoryExport implements FromView
{
    protected $id;
    
    public function __construct(int $id)
    {
        $this->id = $id;
    } 

    public function view(): View
    {
        if (auth()->user()->input_retur == 1 && auth()->user()->id_group != 1) {
            $retur = ReturHistory::where('id', $this->id)->first();
            $details = ReturDetail::where('id_retur', $this->id)->get();

            return view('retur.supplier.exportDetailXlsx', compact(['retur', 'details']));
        }
        return back();
    }
}
