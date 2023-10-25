<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function edit_draft_order($id)
    {
        $order = order::with('case')->where('status', 'draft')->find($id);

        session()->put('order_id', $id);
        session()->put('case_id', $order->case->case_no);
        session()->put('step', $order->step);

        if( $order->doc_check ) {
            session()->put('doc_check', true);
        }
        
        if( $order->add_check ) {
            session()->put('add_check', true);
        }

        return redirect('place-order');
    }

    public function del_order( Request $req, $id )
    {
        if ($req->ajax()) {
            $order = order::find($id);
            $order->delete();
            return true;
        }
        return abort(404);
    }

    public function save_as_draft()
    {
        $order = Order::find(session('order_id'));
        $order->status = 'draft';
        $order->save(); 
        
        session()->forget('order_id');
        session()->forget('case_id');
        session()->forget('step');
        session()->forget('doc_check');
        session()->forget('add_check');

    }
    
    public function reset_order()
    {
        session()->forget('order_id');
        session()->forget('case_id');
        session()->forget('step');
        session()->forget('doc_check');
        session()->forget('add_check');
        
        return redirect()->to('place-order');
    }

    public function final_step(Request $req)
    {
        $order = Order::find(session('order_id'));
        $order->attempt_type = json_encode($req->input('attempt_type'));
        $order->attempt_time = json_encode($req->input('optradio'));
        $order->internal_reference_number = $req->input('irn');
        $order->notification = $req->input('notification');
        $order->status = 'pending';
        $order->save();
            
        session()->forget('order_id');
        session()->forget('case_id');
        session()->forget('doc_check');
        session()->forget('add_check');
        session()->forget('step');
        return true;
    }
}