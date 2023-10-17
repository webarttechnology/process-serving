<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order_details;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderDetailsController extends Controller
{
    public function order_details(Request $req)
    {
        $existingData = order_details::where('order_id', $req->session()->get('order_id'))->first();

        if (!$existingData) {
            DB::table('order_details')->insert([
                'order_id' => session('order_id'),
                'case_no' => session('case_id'),
                'attempt' => $req->input('optradio'),
                'irn' => $req->input('irn'),
                'notification' => $req->input('notification'),
                'status' => 1,
            ]);
        } else {
            DB::table('order_details')
                ->where('order_id', session('order_id'))
                ->update([
                    'order_id' => session('order_id'),
                    'case_no' => session('case_id'),
                    'attempt' => $req->input('optradio'),
                    'irn' => $req->input('irn'),
                    'notification' => $req->input('notification'),
                    'status' => 1,
                ]);
        }
        session()->forget('order_id');
        session()->forget('case_id');
        session()->forget('doc_check');
        session()->forget('add_check');
        Session::forget('step2');
        Session::forget('step3');
        return true;
    }
    public function order_draft(Request $req)
    {
        DB::table('order_details')->insert([
            'order_id' => session('order_id'),
            'case_no' => session('case_id'),
            'attempt' => $req->input('optradio'),
            'irn' => $req->input('irn'),
            'notification' => $req->input('notification'),
            'status' => 2,
        ]);
        session()->forget('order_id');
        session()->forget('case_id');
        session()->forget('doc_check');
        session()->forget('add_check');
        Session::forget('step2');
        Session::forget('step3');

        return true;
    }
}
