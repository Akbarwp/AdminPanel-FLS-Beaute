<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductListSecondExport implements FromView
{
    public function view(): View
    {
        if(auth()->user()->lihat_barang == 1)
        {
            if(auth()->user()->id_group == 1)
            {
                $lists = User::where('user_position', 'superadmin_distributor')->get();
                return view('manage_product.second.export', compact('lists'));
            }
            else if(auth()->user()->user_position != "reseller")
            {
                $lists = User::where('id_group', auth()->user()->id_group)->where('user_position', 'reseller')->get();
                return view('manage_product.second.export', compact('lists'));
            }
        }
    }
}
