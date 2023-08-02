<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\SalesStokDetail;
use App\Models\SalesStokHistory;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class everyMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minute:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto acc data terima barang sales apabila 24 jam belum di acc';

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
        echo "operation on going - ";

        $histories = SalesStokHistory::where('status', 0)->get();
        foreach($histories as $history)
        {
            $now = strtotime(Carbon::now()->toDateTimeString());
            echo $now." - ";
            $create = strtotime($history->created_at->toDateTimeString());
            echo $create." - ";

            // Formulate the Difference between two dates
            $diff = abs($now - $create);
            echo $diff." - ";
            
            // To get the year divide the resultant date into
            // total seconds in a year (365*60*60*24)
            $years = floor($diff / (365*60*60*24));
            
            // To get the month, subtract it with years and
            // divide the resultant date into
            // total seconds in a month (30*60*60*24)
            $months = floor(($diff - $years * 365*60*60*24)
                                            / (30*60*60*24));
            
            // To get the day, subtract it with years and
            // months and divide the resultant date into
            // total seconds in a days (60*60*24)
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

            // To get the hour, subtract it with years,
            // months & seconds and divide the resultant
            // date into total seconds in a hours (60*60)
            $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));

            // To get the minutes, subtract it with years,
            // months, seconds and hours and divide the
            // resultant date into total seconds i.e. 60
            // $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
            echo $days." - ";
            if($hours >= 24)
            {
                $history->update(array('status' => 1));
                $history->update(array('id_approve' => 0));
                $history->update(array('nama_approve' => "auto system"));

                // Tambah stok sales
                $details = SalesStokDetail::where('id_sales_stok', $history->id)->get();
                foreach($details as $detail)
                {
                    $salesProduk = Product::where('id', $detail->id_product)->first();
        
                    $salesProduk->update(array('stok' => $salesProduk->stok + $detail->jumlah));
                }
            }
        }
    }
}
