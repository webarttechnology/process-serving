<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\party;
use Illuminate\Http\Request;
use App\Models\serve;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ServeController extends Controller
{
    public function add_serve(Request $req)
    {
        $req->session()->put('step', 3);

        $order = order::find(session('order_id'));
        $order->step = 3;


        // DB::table('orders')
        //         ->where('order_id', session('order_id'))
        //         ->update([
        //             'step' => 3
        //         ]);

        $insertedData = [];
        if ($req->input('doc_check') === 'yes') {
            $req->session()->put('doc_check', true);
            $order->doc_check = 1;
        } else {
            $req->session()->forget('doc_check');
            $order->doc_check = 0;
        }

        if ($req->input('service_check') === 'yes') {
            $req->session()->put('service_check', true);
            $order->service_check = 1;
        } else {
            $req->session()->forget('service_check', true);
            $order->service_check = 0;
        }

        if ($req->input('add_check') === 'yes') {
            $req->session()->put('add_check', true);
            $order->add_check = 1;
        } else {
            $req->session()->forget('add_check', true);
            $order->add_check = 0;
        }

        $order->save();
        foreach ($req->input('party') as $index => $value) {

            $checkNewParty = party::where('order_id', session('order_id'))
                ->where('case_no', session('case_id'))
                ->where('name', $req->input('party')[$index])
                ->first();

            if (!$checkNewParty) {
                $newServe = party::create([
                    'order_id' => session('order_id'),
                    'case_no' => session('case_id'),
                    'name' => $req->input('party')[$index],
                    'role' => $req->input('role')[$index]
                ]);
            }

            $existingData = serve::where('order_id', session('order_id'))
                ->where('p_t_serve', $req->input('party')[$index])
                ->where('role', $req->input('role')[$index])
                ->where('agent', $req->input('agent')[$index])
                ->first();
            if (!$existingData) {
                $newServe = serve::create([
                    'order_id' => session('order_id'),
                    'p_t_serve' => $req->input('party')[$index],
                    'role_type' => $req->input('servee_role_type')[$index],
                    'role' => $req->input('role')[$index],
                    'agent' => $req->input('agent')[$index],
                    'status' => 0,
                ]);
                $insertedData[] = $newServe;
            }
        }
        return response()->json($insertedData);
    }

    public function upd_sere(Request $request)
    {
        // Retrieve the data from the form inputs
        $sIdArray = $request->input('s_id_s');
        $sAddArray = $request->input('s_add');
        $sTzArray = $request->input('s_t_z');
        $hTimeArray = $request->input('h_time');
        $dptArray = $request->input('dpt');
        $wFeeArray = $request->input('w_fee');
        $proofArray = $request->input('proof');
        $sInstructionArray = $request->input('s_instruction');

        // Loop through the arrays and update the records
        foreach ($sIdArray as $index => $sId) {
            $record = Serve::find($sId);

            if ($record) {
                $record->address = $sAddArray[$index];
                $record->timezone = $sTzArray[$index];
                $record->h_date = $hTimeArray[$index];
                $record->dept = $dptArray[$index];
                $record->w_fee = $wFeeArray[$index];
                $record->proof = $proofArray[$index];
                $record->s_inst = $sInstructionArray[$index];
                $record->save();
            }
        }

        return true;
    }

    public function del_serves(Request $req, $id)
    {
        if ($req->ajax()) {
            $model = serve::find($id);
            $model->delete();
            return true;
        }
        return abort(404);
    }

    public function upd_serve(Request $request)
    {
        // Retrieve the data from the form inputs
        $sIdArray = $request->input('s_id_s');
        $sAddArray = $request->input('s_add');
        $sNameArray = $request->input('s_add_business_name');
        $sTypeArray = $request->input('business_type');
        $sTzArray = $request->input('s_t_z');
        $hTimeArray = $request->input('h_time');
        $dptArray = $request->input('dpt');
        // $wFeeArray = ;
        $proofArray = $request->input('proof');
        $sInstructionArray = $request->input('s_instruction');
        if (isset($sIdArray)) {
            $c = 1;
            foreach ($sIdArray as $index => $sId) {
                $record = Serve::find($sId);
                if ($record) {

                    $record->address = json_encode($sAddArray[$sId]);
                    $record->type = json_encode($sTypeArray[$sId]);
                    $record->business_name = json_encode($sNameArray[$sId]);
                    $record->timezone = $sTzArray[$index];
                    $record->h_date = $hTimeArray[$index];
                    $record->dept = $dptArray[$index];
                    $record->w_fee = $request->input('w_fee_' . $c);
                    $record->proof = isset($proofArray[$index]) ? $proofArray[$index] : '';
                    $record->s_inst = $sInstructionArray[$index];
                    $record->save();
                }
                $c++;
            }
        } else {

            $c = DB::table('serve_address')
                ->where('order_id', session('order_id'))
                ->first();
            if (isset($c)) {

                DB::table('serve_address')
                    ->where('order_id', session('order_id'))
                    ->update([
                        'order_id' => session('order_id'),
                        'case_no' => session('case_id'),
                        'address' => json_encode($sAddArray[session('order_id')]),
                        'type' => json_encode($sTypeArray[session('order_id')]),
                        'business_name' => json_encode($sNameArray[session('order_id')]),
                        'timezone' => $sTzArray,
                        'h_date' => $hTimeArray,
                        'dept' => $dptArray,
                        'w_fee' => $request->input('w_fee_'),
                        'proof' => $proofArray,
                        's_inst' => $sInstructionArray,
                        // 'status' => 0,
                    ]);
            } else {
                DB::table('serve_address')->insert([
                    'order_id' => session('order_id'),
                    'case_no' => session('case_id'),
                    'address' => json_encode($sAddArray[session('order_id')]),
                    'type' => json_encode($sTypeArray[session('order_id')]),
                    'business_name' => json_encode($sNameArray[session('order_id')]),
                    'timezone' => $sTzArray,
                    'h_date' => $hTimeArray,
                    'dept' => $dptArray,
                    'w_fee' => $request->input('w_fee_'),
                    'proof' => $proofArray,
                    's_inst' => $sInstructionArray,
                    'status' => 0,
                ]);
            }
        }

        $request->session()->put('step', 5);
        $order = order::find(session('order_id'));
        $order->step = 5;
        $order->save();

        return true;
    }
    public function set_session(Request $req)
    {
        $key = $req->input('key');
        $value = $req->input('value');
        $req->session()->put($key, $value);
        return response()->json(['message' => 'Session value set successfully']);
    }
}
