<?php

namespace App\Exports;

use App\Models\TransactionHistory;
use App\Models\TransactionDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionDetailBuyHistoryExport implements FromView
{
    protected $id;
    
    public function __construct(int $id)
    {
        $this->id = $id;
    }  

    public function view(): View
    {
        $history = TransactionHistory::where('id', $this->id)->first();
        $details = TransactionDetail::where('id_transaction', $history->id)->get();
        return view('manage_transactions.buy.exportDetail', compact(['history', 'details']));
    }
}
