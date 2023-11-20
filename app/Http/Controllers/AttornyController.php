<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\AdminInfo;
use Illuminate\Http\Request;
use App\Models\attorny;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AttornyController extends Controller
{
    public function update_attorney(Request $req)
    {
        $attorney = attorny::find($req->input('s_id'));

        $attorney->update([
            'name' => $req->input('s_name'),
            'firm_name' => $req->input('s_afm'),
            'street_address' => $req->input('s_fa'),
            'city_state_zip' => $req->input('s_csz'),
            'email' => $req->input('s_em'),
            'phone' => $req->input('s_ph'),
            'b_id' => $req->input('s_bid'),
        ]);

        return response()->json([
            'status' => true
        ]);
    }

    public function add_attorney(Request $req)
    {
        $rules = [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'b_id' => 'required',
            // 'firm_name' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'pass' => 'required|min:4',
            'cpass' => 'required|min:4|same:pass',
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

        $admin = admin::create([
            'owner_id' => session('admin_id'),
            'attorney' => true,
            'role' => 'staff',
            'verified' => 1,
            'password' => Hash::make($req->input('pass')),
            'name' => $req->input('fname') . ' ' . $req->input('lname'),
            'email' => $req->input('email'),
            'phone' => $req->input('phone'),
        ]);

        // AdminInfo::create([
        //     'admin_id' => $admin->id,

        // ]);

        attorny::create([
            'admin_id' => $admin->id,
            'owner_id' => session('admin_id'),
            'temp_password' => $req->input('pass'),
            'password' => Hash::make($req->input('pass')),
            'name' => $req->input('fname') . ' ' . $req->input('lname'),
            'email' => $req->input('email'),
            'phone' => $req->input('phone'),
            'b_id' => $req->input('b_id'),
            // 'firm_name' => $req->firm_name,
            'street_address' => $req->street_address,
            'city' => $req->city,
            'state' => $req->state,
            'zip' => $req->zip,
        ]);

        $data = [
            'name' => $req->input('fname') . ' ' . $req->input('lname'),
            'email' => $req->input('email'),
            'phone' => $req->input('phone'),
            'b_id' => $req->input('b_id'),
            // 'firm_name' => $req->firm_name,
            'street_address' => $req->street_address,
            'city' => $req->city,
            'state' => $req->state,
            'zip' => $req->zip,
        ];

        Mail::send('client.mail.welcome', ['type' => 'Attorney', 'pass' => $req->pass, 'name' => $req->fname . ' ' . $req->lname, 'email' => $req->email], function ($message) use ($req) {
            $message->to($req->email)->subject("Welcome to Countrywide Process");
        });

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function get_attorney($name)
    {
        $data = attorny::where('name', $name)->first();
        return response()->json($data);
    }
}
