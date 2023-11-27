<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;
use App\Models\party;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class PartyController extends Controller
{
    public function add_party(Request $req)
    {
        if ($req->ajax()) {

            $rules = [
                'p_type' => 'required|in:person,organization',
                'p_role' => 'required',
                'role_type' => 'required',
                'p_fname' => 'required_if:p_type,person',
                'p_lname' => 'required_if:p_type,person',
                'p_bcode' => 'required_if:p_lclient,yes',
                'org_name' => 'required_if:p_type,organization',
            ];

            $messages = [
                'required' => 'The :attribute field is required.',
                'in' => 'Invalid value for :attribute.',
                'required_if' => 'The :attribute field is required',
                // Add more custom messages as needed
            ];

            $validator = Validator::make($req->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }

            $model = new party();
            $model->order_id = session('order_id');
            $model->case_no = session('case_id');
            $model->type = $req->input('p_type');
            $model->role_type = $req->input('role_type');
            $model->role = $req->input('p_role');
            $model->name = $req->input('p_type') == 'person' ? $req->input('p_fname') . ' ' . $req->input('p_mname') . ' ' . $req->input('p_lname') : $req->input('org_name');
            $model->sfx = $req->input('p_sfx');
            $model->l_client = $req->input('p_lclient');
            $model->b_code = $req->input('p_bcode');
            $model->save();

            if ($req->p_lclient == 'yes') {
                party::where('case_no', session('case_id'))
                    ->whereNotIn('id', [$model->id])
                    ->update([
                        'l_client' => 'no',
                        'b_code' => '',
                    ]);

                $order = order::find(session('order_id'));
                $order->l_client = $model->id;
                $order->b_code = $req->p_bcode;
                $order->save();
            }

            // if( $req->input('p_lclient') == 'yes' )
            // {
            //     party::where('order_id', session('order_id'))
            //     ->where('case_no', session('case_id'))
            //     ->update([
            //         'l_client' => 'no',
            //         'b_code' => '',
            //     ]);
            // }

            return response()->json([
                'status' => true,
                'data' => $model
            ]);
        }

        return abort(404);
    }

    public function change_party_lead(Request $req)
    {
        if ($req->ajax()) {

            $party = party::find($req->party_form_id);

            if (empty($party)) return false;

            $order = order::find(session('order_id'));
            $order->l_client = $req->party_form_id;
            $order->b_code = $req->p_bcode;
            $order->save();

            if ($req->change_lead == 'yes') {
                $party->l_client = 'yes';
                $party->save();

                party::where('case_no', session('case_id'))
                    ->whereNotIn('id', [$req->party_form_id])
                    ->update([
                        'l_client' => 'no',
                    ]);
            }

            if ($req->change_billing == 'yes') {
                $party->b_code = $req->p_bcode;
                $party->save();

                party::where('case_no', session('case_id'))
                    ->whereNotIn('id', [$req->party_form_id])
                    ->update([
                        'b_code' => '',
                    ]);
            }
        }
    }

    public function check_party($name)
    {
        $party = party::where('name', $name)->first();

        if (!empty($party)) {
            return response()->json($party);
        }

        return abort(404);
    }

    public function add_partyd(Request $req)
    {
        if ($req->ajax()) {
            $model = new party();
            $model->order_id = session('order_id');
            $model->case_no = session('case_id');
            $model->name = $req->input('party');
            $model->save();
            return response()->json($model);
        }
        return abort(404);
    }
    public function edit_party(Request $req)
    {
        if ($req->ajax()) {

            // var_dump($req->post());
            // exit;
            $rules = [
                'pe_type' => 'required|in:person,organization',
                'pe_role' => 'required',
                'pe_name' => 'required',
                'role_type' => 'required',
                'pe_bcode' => 'required_if:pe_lclient,yes',
            ];

            $messages = [
                'required' => 'The :attribute field is required.',
                'in' => 'Invalid value for :attribute.',
                'required_if' => 'The :attribute field is required',
                // Add more custom messages as needed
            ];

            $validator = Validator::make($req->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }

            $id = $req->input('pe_id');
            $model = party::find($id);
            $model->role = $req->input('pe_role');
            $model->role_type = $req->input('role_type');
            $model->name = $req->input('pe_name');
            $model->sfx = $req->input('pe_sfx');
            $model->l_client = $req->input('pe_lclient');
            $model->b_code = $req->input('pe_bcode');
            $model->save();

            if ($req->pe_lclient == 'yes') {
                party::where('case_no', session('case_id'))
                    ->whereNotIn('id', [$id])
                    ->update([
                        'l_client' => 'no',
                        'b_code' => '',
                    ]);

                $order = order::find(session('order_id'));
                $order->l_client = $model->id;
                $order->b_code = $req->pe_bcode;
                $order->save();
            }

            return response()->json([
                'status' => true,
                'data' => $model
            ]);
        }
        return abort(404);
    }

    public function get_party($id)
    {
        $data = party::where('id', $id)->first();
        return response()->json($data);
    }
    public function get_party_all()
    {
        $data = [];

        if (!empty(session('case_id'))) {
            $data = DB::table('parties')
                ->where(['case_no' => session('case_id')])
                ->get();
        }

        return response()->json($data);
    }
    public function get_party_all_c()
    {
        $data = DB::table('parties')
            ->where(['case_no' => session('case_id')])
            ->whereNotNull('type')
            ->whereNotNull('role')
            ->get();
        return response()->json($data);
    }
    public function del_party(Request $req, $id)
    {
        if ($req->ajax()) {
            $model = party::find($id);
            $model->delete();
            return true;
        }
        return abort(404);
    }
}