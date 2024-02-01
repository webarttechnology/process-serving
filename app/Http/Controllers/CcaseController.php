<?php

namespace App\Http\Controllers;

use App\Models\attorny;
use Illuminate\Http\Request;
use App\Models\ccase;
use App\Models\order;
use App\Models\party;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CcaseController extends Controller
{
    public function add_case(Request $req)
    {
        $req->session()->put('step', 2);
        $existingCase = Ccase::where('case_no', $req->input('c_num'))->first();
        
        if (!session()->has('order_id')) {
            $unique_id = 'PS' . mt_rand(1000000, 9999999);;

            $arr = [
                'order_id' => $unique_id,
                'step' => 2
            ];

            if( !empty($existingCase)  )
            {
                $party = party::where('l_client', 'yes')->where('case_no', $req->input('c_num'))->first();

                
                if( !empty($party) )
                {
                    $arr['l_client'] =  $party->id;
                    $arr['b_code'] = $party->b_code;
                }
            }
            $order = order::create($arr);

            $req->session()->put('order_id', $order->id);
        }
        
        if ($existingCase) {
            
            DB::table('ccases')
                ->where('case_no', $req->input('c_num'))
                ->update([
                    'attorney' => $req->input('c_at'),
                    'order_id' => session('order_id')
                ]);
                
            $req->session()->put('case_id', $existingCase->id);

            $order = order::find(session('order_id'));
            $order->case_id = $existingCase->id;
            $order->save();
        } else {
            $caseInfo = Ccase::create([
                'order_id' => session('order_id'),
                'case_no' => $req->input('c_num'),
                'case_title' => $req->input('c_ti'),
                'jurisdiction' => $req->input('c_ju'),
                'attorney' => $req->input('c_at'),
            ]);
            
            $req->session()->put('case_id', $caseInfo->id);
            
            $order = order::find(session('order_id'));
            $order->case_id = $caseInfo->id;
            $order->save();
        }

    }

    public function get_case($ccase)
    {
        $data = ccase::where('case_no', $ccase)->first();

        $data->attorneyRow = attorny::where("name", $data->attorney)->first();
        return response()->json($data);
    }

    public function previous_step( Request $req )
    {
        $step = session('step');
        
        if( !empty($step) && $step != 1 ) {
            $req->session()->put('step',  --$step);
        }    
    }
}