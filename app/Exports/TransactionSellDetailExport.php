<?php

namespace App\Exports;

use App\Models\TransactionHistorySell;
use App\Models\TransactionDetailSell;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionSellDetailExport implements FromView
{
    protected $id;
    
    public function __construct(int $id)
    {
        $this->id = $id;
    }   

    public function view(): View
    {
        $history = TransactionHistorySell::where('id', $this->id)->first();
        $details = TransactionDetailSell::where('id_transaction', $history->id)->get();

        return view('manage_transactions.sell.exportDetail', compact(['history', 'details']));
    }
}
