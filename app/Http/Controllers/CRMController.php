<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CrmClaimRewardHistory;
use App\Models\CrmReward;
use App\Models\CrmPoin;
use App\Models\CrmResetPoinHistory;
use App\Models\ProductType;
use App\Models\TrackingSalesDetail;
use App\Models\TrackingSalesHistory;
use App\Models\TransactionDetail;
use App\Models\TransactionDetailSell;
use App\Models\TransactionHistory;
use App\Models\TransactionHistorySell;
use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use PDF;


class CRMController extends Controller
{
    
    public function print_cluster(){
        return view("crm.cluster.print_cluster");
    }
    
    
    
    
    public function viewOmzet($id)
    {
        if(auth()->user()->lihat_crm == 1)
        {
            $owner = User::where('id', $id)->first();
            if($owner->user_position != "reseller" && $owner->user_position != "sales")
            {
                $rewards = CrmReward::where('type', 'distributor')->get();
            }
            else if($owner->user_position == "reseller" || $owner->user_position == "sales")
            {
                $rewards = CrmReward::where('type', 'reseller')->get();
            }
            return view('crm.main.omzet', compact(['owner', 'rewards']));
        }

        return back();
    }

    public function print_omzet($id){
        if(auth()->user()->lihat_crm == 1)
        {
            $owner = User::where('id', $id)->first();
            if($owner->user_position != "reseller" && $owner->user_position != "sales")
            {
                $rewards = CrmReward::where('type', 'distributor')->get();
            }
            else if($owner->user_position == "reseller" || $owner->user_position == "sales")
            {
                $rewards = CrmReward::where('type', 'reseller')->get();
            }
            return view('crm.main.print_omzet', compact(['owner', 'rewards']));
        }
    }
    public function export_omzet($id){
        if(auth()->user()->lihat_crm == 1)
        {
            $owner = User::where('id', $id)->first();
            if($owner->user_position != "reseller" && $owner->user_position != "sales")
            {
                $rewards = CrmReward::where('type', 'distributor')->get();
            }
            else if($owner->user_position == "reseller" || $owner->user_position == "sales")
            {
                $rewards = CrmReward::where('type', 'reseller')->get();
            }
            $pdf = PDF::loadView('crm.main.export_omzet', compact(['owner', 'rewards']));
            return $pdf->download('CRM '.$owner->firstname.' '.$owner->lastname.' - ' .date('F Y').'.pdf');
        }
    }

    public function viewOmzetHistory($id)
    {
        if(auth()->user()->lihat_crm == 1)
        {
            $owner = User::where('id', $id)->first();
            
            if($owner->user_position != "reseller" && $owner->user_position != "sales")
            {
                $reseller_beli = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $owner->id)->where('id_reset_poin_crm', 0)->get();
                $jual_kasir = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $owner->id)->where('id_reset_poin_crm_distributor', 0)->get();
                $reseller_jual = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_group', $owner->id_group)->where('transaction_history_sells.id_owner', '!=', $owner->id)->where('id_reset_poin_crm_distributor', 0)->get();
                $tracking_sales = TrackingSalesDetail::join('tracking_sales_histories', 'tracking_sales_histories.id', '=', 'tracking_sales_details.id_tracking_sales')->where('tracking_sales_histories.id_group', $owner->id_group)->where('id_reset_poin_crm_distributor', 0)->get();
                $claim_reward_history = CrmClaimRewardHistory::where('id_owner', $owner->id)->where('status', '1')->where('id_reset_poin_crm', 0)->get();

                $resets = CrmResetPoinHistory::where('type', 'distributor')->get();

                return view('crm.main.history', compact(['owner', 'reseller_beli', 'jual_kasir', 'reseller_jual', 'tracking_sales', 'claim_reward_history', 'resets']));
            }
            else if($owner->user_position == "reseller")
            {
                $jual_kasir = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $owner->id)->where('id_reset_poin_crm', 0)->get();
                $claim_reward_history = CrmClaimRewardHistory::where('id_owner', $owner->id)->where('status', '1')->where('id_reset_poin_crm', 0)->get();
                
                $resets = CrmResetPoinHistory::where('type', 'reseller')->get();

                return view('crm.main.history', compact(['owner', 'jual_kasir', 'claim_reward_history', 'resets']));
            }
            else if($owner->user_position == "sales")
            {
                $jual_tracking = TrackingSalesDetail::join('tracking_sales_histories', 'tracking_sales_histories.id', '=', 'tracking_sales_details.id_tracking_sales')->where('tracking_sales_histories.id_reseller', $owner->id)->where('id_reset_poin_crm', 0)->get();
                $claim_reward_history = CrmClaimRewardHistory::where('id_owner', $owner->id)->where('status', '1')->where('id_reset_poin_crm', 0)->get();

                $resets = CrmResetPoinHistory::where('type', 'reseller')->get();

                return view('crm.main.history', compact(['owner', 'jual_tracking', 'claim_reward_history', 'resets']));
            }
        }

        return back();
    }

    public function print_history($id){
        if(auth()->user()->lihat_crm == 1)
        {
            $owner = User::where('id', $id)->first();
            if($owner->user_position != "reseller" && $owner->user_position != "sales")
            {
                $reseller_beli = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $owner->id)->get();
                $jual_kasir = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $owner->id)->get();
                $reseller_jual = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_group', $owner->id_group)->where('transaction_history_sells.id_owner', '!=', $owner->id)->get();
                $claim_reward_history = CrmClaimRewardHistory::where('id_owner', $owner->id)->where('status', '1')->get();
                return view('crm.main.printHistory', compact(['owner', 'reseller_beli', 'jual_kasir', 'reseller_jual', 'claim_reward_history']));
            }
            else if($owner->user_position == "reseller")
            {
                $jual_kasir = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $owner->id)->get();
                $claim_reward_history = CrmClaimRewardHistory::where('id_owner', $owner->id)->where('status', '1')->get();
                return view('crm.main.printHistory', compact(['owner', 'jual_kasir', 'claim_reward_history']));
            }
            else if($owner->user_position == "sales")
            {
                $jual_tracking = TrackingSalesDetail::join('tracking_sales_histories', 'tracking_sales_histories.id', '=', 'tracking_sales_details.id_tracking_sales')->where('tracking_sales_histories.id_reseller', $owner->id)->get();
                $claim_reward_history = CrmClaimRewardHistory::where('id_owner', $owner->id)->where('status', '1')->get();
                return view('crm.main.printHistory', compact(['owner', 'jual_tracking', 'claim_reward_history']));
            }
        }
    }

    public function export_history($id){
        if(auth()->user()->lihat_crm == 1)
        {
            $owner = User::where('id', $id)->first();
            if($owner->user_position != "reseller" && $owner->user_position != "sales")
            {
                $reseller_beli = TransactionDetail::join('transaction_histories', 'transaction_histories.id', '=', 'transaction_details.id_transaction')->where('transaction_histories.id_distributor', $owner->id)->get();
                $jual_kasir = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $owner->id)->get();
                $reseller_jual = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_group', $owner->id_group)->where('transaction_history_sells.id_owner', '!=', $owner->id)->get();
                $claim_reward_history = CrmClaimRewardHistory::where('id_owner', $owner->id)->where('status', '1')->get();
                
                $pdf = PDF::loadView('crm.main.exportHistory', compact(['owner', 'reseller_beli', 'jual_kasir', 'reseller_jual', 'claim_reward_history']));
                return $pdf->download('History Point '.$owner->firstname.' '.$owner->lastname.' - ' .date('F Y').'.pdf');
            }
            else if($owner->user_position == "reseller")
            {
                $jual_kasir = TransactionDetailSell::join('transaction_history_sells', 'transaction_history_sells.id', '=', 'transaction_detail_sells.id_transaction')->where('transaction_history_sells.id_owner', $owner->id)->get();
                $claim_reward_history = CrmClaimRewardHistory::where('id_owner', $owner->id)->where('status', '1')->get();

                $pdf = PDF::loadView('crm.main.exportHistory', compact(['owner', 'jual_kasir', 'claim_reward_history']));
                return $pdf->download('History Point '.$owner->firstname.' '.$owner->lastname.' - ' .date('F Y').'.pdf');
            }
            else if($owner->user_position == "sales")
            {
                $jual_tracking = TrackingSalesDetail::join('tracking_sales_histories', 'tracking_sales_histories.id', '=', 'tracking_sales_details.id_tracking_sales')->where('tracking_sales_histories.id_reseller', $owner->id)->get();
                $claim_reward_history = CrmClaimRewardHistory::where('id_owner', $owner->id)->where('status', '1')->get();
                $pdf = PDF::loadView('crm.main.exportHistory', compact(['owner', 'jual_tracking', 'claim_reward_history']));
                return $pdf->download('History Point '.$owner->firstname.' '.$owner->lastname.' - ' .date('F Y').'.pdf');
            }
        }
    }

    public function claimReward(Request $request, $id)
    {
        if(auth()->user()->lihat_crm == 1)
        {
            if(auth()->user()->user_position != "reseller" && auth()->user()->user_position != "sales")
            {
                $owner = User::where('id_group', auth()->user()->id_group)->where('user_position', 'superadmin_distributor')->first();
                $validateData['id_owner'] = $owner->id;
                $validateData['sisa_poin'] = $owner->crm_poin;
            }
            else if(auth()->user()->user_position == "reseller" || auth()->user()->user_position == "sales")
            {
                $validateData['id_owner'] = auth()->user()->id;
                $validateData['sisa_poin'] = auth()->user()->crm_poin;
            }
            $validateData['id_group'] = auth()->user()->id_group;
            $validateData['id_input'] = auth()->user()->id;
            $validateData['nama_input'] = auth()->user()->firstname." ".auth()->user()->lastname; 
            $validateData['id_reward'] = $request->id_reward;
    
            $reward = CrmReward::where('id', $request->id_reward)->first();
            $validateData['reward'] = $reward->reward;
            $validateData['poin'] = $reward->poin;
            $validateData['detail_reward'] = $reward->detail;
            $validateData['image'] = $reward->image;
            $validateData['status'] = 0;
    
            CrmClaimRewardHistory::create($validateData);

            Session::flash('claim_success', 'Hadiah berhasil diclaim');
            return redirect('/crm/omzet/'.$id);
        }

        return back();
    }
    
    public function getReward($id)
    {
        if(auth()->user()->lihat_crm == 1){
            $reward = CrmReward::where('id', $id)->first();
            return response()->json(['reward' => $reward]);
        }
        return back();
    }

    public function viewListSecond()
    {
        if(auth()->user()->lihat_crm == 1)
        {
            if(auth()->user()->id_group == 1)
            {
                $lists = User::where('user_position', 'superadmin_distributor')->get();
            }
            else if(auth()->user()->user_position != "reseller")
            {
                $lists = User::where('user_position', 'reseller')->where('id_group', auth()->user()->id_group)->orWhere('user_position', 'sales')->where('id_group', auth()->user()->id_group)->get();
            }

            return view('crm.second.list', compact('lists'));
        }

        return back();
    }

    public function print_list(){
        if(auth()->user()->lihat_crm == 1)
        {
            if(auth()->user()->id_group == 1)
            {
                $lists = User::where('user_position', 'superadmin_distributor')->get();
            }
            else if(auth()->user()->user_position != "reseller")
            {
                $lists = User::where('user_position', 'reseller')->where('id_group', auth()->user()->id_group)->orWhere('user_position', 'sales')->where('id_group', auth()->user()->id_group)->get();
            }

            return view('crm.second.print_list', compact('lists'));
        }
    }

    public function export_list(){
        if(auth()->user()->lihat_crm == 1)
        {
            if(auth()->user()->id_group == 1)
            {
                $lists = User::where('user_position', 'superadmin_distributor')->get();
                $pdf = PDF::loadView('crm.second.export_list', compact(['lists']));
                return $pdf->download('CRM Distributor Dashboard - ' .date('F Y').'.pdf');

            }
            else if(auth()->user()->user_position != "reseller")
            {
                $lists = User::where('user_position', 'reseller')->where('id_group', auth()->user()->id_group)->orWhere('user_position', 'sales')->where('id_group', auth()->user()->id_group)->get();
                $pdf = PDF::loadView('crm.second.export_list', compact(['lists']));
                return $pdf->download('CRM Reseller Dashboard - ' .date('F Y').'.pdf');

            }
        }
    }

    public function viewDistributor()
    {
        if(auth()->user()->lihat_crm == 1)
        {
            $lists = User::where('user_position', 'superadmin_distributor')->get();
            return view('crm.second.list', compact('lists'));
        }

        return back();
    }

    public function viewListDistThird()
    {
        if(auth()->user()->lihat_crm == 1)
        {
            $lists = User::where('user_position', 'superadmin_distributor')->get();
            return view('crm.third.listDist', compact('lists'));
        }

        return back();
    }

    public function printListDistThird()
    {
        if(auth()->user()->lihat_crm == 1)
        {
            $lists = User::where('user_position', 'superadmin_distributor')->get();
            return view('crm.third.print_listDist', compact('lists'));
        }

        return back();
    }

    public function exportListDistThird()
    {
        if(auth()->user()->lihat_crm == 1)
        {
            $lists = User::where('user_position', 'superadmin_distributor')->get();
            $pdf = PDF::loadView('crm.third.export_listDist', compact(['lists']));
            return $pdf->download('CRM Reseller Dashboard - ' .date('F Y').'.pdf');
        }

        return back();
    }

    public function viewListResThird($id)
    {
        if(auth()->user()->lihat_crm == 1)
        {
            $distributor = User::where('id', $id)->first();
            $lists = User::where('user_position', 'reseller')->where('id_group', $distributor->id_group)->orWhere('user_position', 'sales')->where('id_group', $distributor->id_group)->get();

            return view('crm.third.listRes', compact('lists', 'id'));
        }

        return back();
    }

    public function printListResThird($id)
    {
        if(auth()->user()->lihat_crm == 1)
        {
            $distributor = User::where('id', $id)->first();
            $lists = User::where('user_position', 'reseller')->where('id_group', $distributor->id_group)->orWhere('user_position', 'sales')->where('id_group', $distributor->id_group)->get();

            return view('crm.third.print_listDist', compact('lists'));
        }

        return back();
    }

    public function exportListResThird($id)
    {
        if(auth()->user()->lihat_crm == 1)
        {
            $distributor = User::where('id', $id)->first();
            $lists = User::where('user_position', 'reseller')->where('id_group', $distributor->id_group)->orWhere('user_position', 'sales')->where('id_group', $distributor->id_group)->get();

            $pdf = PDF::loadView('crm.third.export_listDist', compact(['lists']));
            return $pdf->download('CRM Reseller Dashboard - ' .date('F Y').'.pdf');
        }

        return back();
    }

    public function viewOmzetThird()
    {
        return view('crm.third.omzet');
    }

    public function viewHistoryThird()
    {
        return view('crm.third.history');
    }

    public function viewReward()
    {
        if(auth()->user()->input_reward_crm == 1)
        {
            $distributor_rewards = CrmReward::where('type', 'distributor')->get();
            $reseller_rewards = CrmReward::where('type', 'reseller')->get();
    
            return view('crm.reward.index', compact(['distributor_rewards', 'reseller_rewards']));
        }

        return back();
    }

    public function print_reward(){
        if(auth()->user()->input_reward_crm == 1)
        {
            $distributor_rewards = CrmReward::where('type', 'distributor')->get();
            $reseller_rewards = CrmReward::where('type', 'reseller')->get();
    
            return view('crm.reward.print_reward', compact(['distributor_rewards', 'reseller_rewards']));
        }

        return back();
    }

    public function export_reward(){
        if(auth()->user()->input_reward_crm == 1)
        {
            $distributor_rewards = CrmReward::where('type', 'distributor')->get();
            $reseller_rewards = CrmReward::where('type', 'reseller')->get();
    
            $pdf = PDF::loadView('crm.reward.export_reward', compact(['distributor_rewards', 'reseller_rewards']));
            return $pdf->download('CRM Reward - ' .date('F Y').'.pdf');
        }
        
        return back();
    }

    public function createReward($type)
    {
        if(auth()->user()->input_reward_crm == 1)
        {
            return view('crm.reward.create', compact('type'));
        }

        return back();
    }
    
    public function storeReward(Request $request, $type)
    {
        if(auth()->user()->input_reward_crm == 1)
        {
            // dd($request);

            $validateData['type'] = $type;
            $validateData['reward'] = $request->reward;
            $validateData['poin'] = $request->poin;
            $validateData['detail'] = "-";

            if($request->file('image'))
            {
                $temp = 'image';
                $validateData['image'] = $request->file($temp)->store('/crm/reward');
                $validateData['image_name'] = $request->image_name;
            }

            CrmReward::create($validateData);

            $newActivity['id_user'] = auth()->user()->id;
            $newActivity['id_group'] = auth()->user()->id_group;
            $newActivity['kegiatan'] = "Tambah Reward '".$type."' - ".$request->reward;
            UserHistory::create($newActivity);

            Session::flash('create_success', 'Reward berhasil ditambahkan');
            return redirect('/crm/reward');
        }

        return back();
    }

    public function editReward($id)
    {
        if(auth()->user()->input_reward_crm == 1){
            $reward = CrmReward::where('id', $id)->first();
            return response()->json(['reward' => $reward]);
        }
        return back();
    }

    public function updateReward(Request $request)
    {
        if(auth()->user()->input_reward_crm == 1){
            $validateData['reward'] = $request->reward;
            $validateData['poin'] = $request->poin;
            $validateData['detail'] = $request->detail;

            $reward = CrmReward::where('id',$request->id)->first();

            if($request->file('image'))
            {
                Storage::delete($reward->image);

                $temp='image';
                $validateData['image'] = $request->file($temp)->store('/crm/reward');
                $validateData['image_name'] = $request->image_name;
            }
            
            $reward->update($validateData);

            $newActivity['id_user'] = auth()->user()->id;
            $newActivity['id_group'] = auth()->user()->id_group;
            $newActivity['kegiatan'] = "Edit reward CRM '".$reward->type."' - ".$request->reward;
            UserHistory::create($newActivity);

            Session::flash('update_success', 'Reward berhasil diubah');

            return redirect('/crm/reward/');
        }
        return back();
    }

    

    public function viewCluster()
    {
        return view('crm.cluster.index');
    }

    public function editCluster()
    {
        return view('crm.cluster.edit');
    }

    public function viewPoin()
    {
        if(auth()->user()->input_poin_crm == 1){
            $types = ProductType::all();
            $poins = CrmPoin::all();
            return view('crm.poin.index', compact('types', 'poins'));
        }

        return back();
    }

    public function print_point(){
        if(auth()->user()->input_poin_crm == 1){
            $types = ProductType::all();
            $poins = CrmPoin::all();
            return view('crm.poin.print_poin', compact('types', 'poins'));
        }
    }

    public function export_point(){
        if(auth()->user()->input_poin_crm == 1){
            $types = ProductType::all();
            $poins = CrmPoin::all();

            $pdf = PDF::loadView('crm.poin.export_poin', compact(['types', 'poins']));
            return $pdf->download('CRM Poin - ' .date('F Y').'.pdf');
        }
    }

    public function editPoin($id)
    {
        if(auth()->user()->input_poin_crm == 1){
            $poin = CrmPoin::where('id', $id)->first();
            $type = ProductType::where('id', $poin->id_productType)->first();
            return response()->json(['poin' => $poin, 'type' => $type]);
        }
        return back();
    }

    public function updatePoin(Request $request)
    {
        if(auth()->user()->input_poin_crm == 1){
            $validateData['distributor_jual'] = $request->distributor_jual;
            $validateData['distributor_reseller_jual'] = $request->distributor_reseller_jual;
            $validateData['reseller_jual'] = $request->reseller_jual;

            $poin = CrmPoin::where('id', $request->id)->first();
            $poin->update($validateData);

            $type = ProductType::where('id', $poin->id_productType)->first();

            $newActivity['id_user'] = auth()->user()->id;
            $newActivity['id_group'] = auth()->user()->id_group;
            $newActivity['kegiatan'] = "Edit poin CRM '". $type->nama_produk."'";
            UserHistory::create($newActivity);


            Session::flash('update_success', 'Poin berhasil diubah');

            return redirect('/crm/poin/');
        }
        return back();
    }

    public function resetPoin($type)
    {
        // dd($type);
        
        $validateData['id_input'] = auth()->user()->id;
        $validateData['nama_input'] = auth()->user()->firstname.' '.auth()->user()->lastname;
        $validateData['type'] = $type;
        
        CrmResetPoinHistory::create($validateData);

        $history = CrmResetPoinHistory::latest()->first();

        if($type == "distributor")
        {
            $reseller_beli = TransactionHistory::where('id_distributor', '!=', 1)->where('id_reset_poin_crm', '=', 0)->get();
            $jual = TransactionHistorySell::where('id_reset_poin_crm_distributor', '=', 0)->get();
            $tracking = TrackingSalesHistory::where('id_reset_poin_crm_distributor', '=', 0)->get();
            $claim_reward = CrmClaimRewardHistory::join('users', 'users.id', 'crm_claim_reward_histories.id_owner')->where('users.user_position', 'superadmin_distributor')->where('crm_claim_reward_histories.id_reset_poin_crm', '=', 0)->select('crm_claim_reward_histories.*')->get();
            
            // dd($claim_reward);
            foreach($reseller_beli as $temp)
            {
                $temp->update(array('id_reset_poin_crm' => $history->id));
            }
            foreach($jual as $temp)
            {
                $temp->update(array('id_reset_poin_crm_distributor' => $history->id));
            }
            foreach($tracking as $temp)
            {
                $temp->update(array('id_reset_poin_crm_distributor' => $history->id));
            }
            foreach($claim_reward as $temp)
            {
                $temp->update(array('id_reset_poin_crm' => $history->id));
            }

            $users = User::where('user_position', 'superadmin_distributor')->get();
            foreach($users as $temp)
            {
                $temp->update(array('crm_poin' => 0));
            }

            Session::flash('reset_success', 'Reset poin distributor berhasil');
            return redirect('/crm/list/');
        }
        else if($type = "reseller")
        {
            $jual = TransactionHistorySell::where('id_reset_poin_crm', '=', 0)->get();
            $tracking = TrackingSalesHistory::where('id_reset_poin_crm', '=', 0)->get();
            $claim_reward = CrmClaimRewardHistory::join('users', 'users.id', 'crm_claim_reward_histories.id_owner')->where('users.user_position', 'reseller')->where('id_reset_poin_crm', '=', 0)->orWhere('users.user_position', 'sales')->where('id_reset_poin_crm', '=', 0)->select('crm_claim_reward_histories.*')->get();
        
            foreach($jual as $temp)
            {
                $temp->update(array('id_reset_poin_crm' => $history->id));
            }
            foreach($tracking as $temp)
            {
                $temp->update(array('id_reset_poin_crm' => $history->id));
            }
            foreach($claim_reward as $temp)
            {
                $temp->update(array('id_reset_poin_crm' => $history->id));
            }

            $users = User::where('user_position', 'reseller')->orWhere('user_position', 'sales')->get();
            foreach($users as $temp)
            {
                $temp->update(array('crm_poin' => 0));
            }

            Session::flash('reset_success', 'Reset poin reseller berhasil');
            return redirect('/crm/list_distributor/');
        }

    }
}
