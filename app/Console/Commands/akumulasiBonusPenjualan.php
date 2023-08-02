<?php

namespace App\Console\Commands;

use App\Models\AkumulasiBonusPenjualanSales;
use App\Models\TrackingSalesHistory;
use Illuminate\Console\Command;

class akumulasiBonusPenjualan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'month:akumulasiBonusPenjualan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return 0;
        echo "Akhir Bulan";
        $validateData['keterangan'] = "Akumulasi Bonus - ".date('F Y');
        AkumulasiBonusPenjualanSales::create($validateData);

        $lastAkumulasi = AkumulasiBonusPenjualanSales::latest()->first();    

        $histories = TrackingSalesHistory::where('id_akumulasi_bonus_penjualan_sales', 0)->get();
        foreach($histories as $history)
        {
            $history->update(array('id_akumulasi_bonus_penjualan_sales' => $lastAkumulasi->id));
        }
    }
}
