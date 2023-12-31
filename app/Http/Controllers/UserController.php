<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin;
use App\Models\AdminInfo;
use App\Models\attorny;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function users()
    {
        $adminData = admin::where('owner_id', session('admin_id'))->orderBy('id', 'desc')->get();
        return view('client.users', compact('adminData'));
    }

    public function add_users()
    {
        return view('client.add_users');
    }

    public function store_users(Request $request)
    {
        $request->validate([
            'organizer_name' => 'required|string|max:255',
            'role' => 'required|in:admin,staff',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'phone' => 'required|string|max:10',
            'password' => 'required|string|min:8',
            'address1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            'bar_id' => 'nullable|string|max:255',
            'billing_email' => 'required|email',
            'billing_phone' => 'required|string|max:10',
            'billing_code' => 'required|string|max:10',
            'deperment' => 'required|string|max:255',
        ]);

        $adminrecord =   admin::create([
            'owner_id' => session('admin_id'),
            'organization_name' => $request->organizer_name,
            'attorney' => $request->attorney == 'on' ? true : false,
            'role' => $request->role,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        AdminInfo::create([
            'admin_id' => $adminrecord->id,
            'type_of_account' => $request->deperment,
            'account_name' => $request->name,
            'address' => $request->address1,
            'billing_name' => $request->name,
            'billing_email' => $request->billing_email,
            'billing_phone' => $request->billing_phone,
            'billing_state' => $request->state,
            'billing_city' => $request->city,
            'billing_code_on_invoice' => $request->billing_code,
            'zip' => $request->zip,
        ]);

        if ($request->has('attorney')) {
            attorny::create([
                'admin_id' => $adminrecord->id,
                'name' => $request->organizer_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'firm_name' => $request->organizer_name,
                'street_address' => $request->address1,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'city_state_zip' => $request->zip,
                'password' => bcrypt($request->password),
                'b_id' => $request->bar_id,
            ]);
        }

        Mail::send('client.mail.welcome', ['type' => $request->deperment, 'pass' => $request->password, 'name' => $request->name, 'email' => $request->email], function ($message) use ($request) {
            $message->to($request->email)->subject("Welcome to Countrywide Process");
        });

        $request->session()->flash('success', 'Added Successfully');
        return redirect()->route('users');
    }

    public function edit_users($id)
    {
        $adminData = admin::with('admin_info_single', 'attorney_info')->where('id', $id)->first();
        return view('client.edit_users', compact('adminData'));
    }


    public function update_users(Request $request, $id)
    {
        $request->validate([
            'organizer_name' => 'required|string|max:255',
            'role' => 'required|in:admin,staff',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:12',
            'address1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            'bar_id' => 'nullable|string|max:255',
            'billing_email' => 'required|email',
            'billing_phone' => 'required|string|max:12',
            'billing_code' => 'required|string|max:10',
            'deperment' => 'required|string|max:255',
        ]);

        $admin = admin::find($id);
        $admin->organization_name = $request->organizer_name;
        $admin->role = $request->role;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->save();

        $adminInfo = AdminInfo::where('admin_id', $id)->first();
        if ($adminInfo) {
            $adminInfo->type_of_account = $request->deperment;
            $adminInfo->account_name = $request->name;
            $adminInfo->address = $request->address1;
            $adminInfo->billing_name = $request->name;
            $adminInfo->billing_email = $request->billing_email;
            $adminInfo->billing_phone = $request->billing_phone;
            $adminInfo->billing_state = $request->state;
            $adminInfo->billing_city = $request->city;
            $adminInfo->zip = $request->zip;
            $adminInfo->billing_code_on_invoice = $request->billing_code;
            $adminInfo->save();
        }

        if ($request->has('attorney')) {
            $attorney = attorny::where('admin_id', $id)->first();
            if ($attorney) {
                $attorney->name = $request->organizer_name;
                $attorney->email = $request->email;
                $attorney->phone = $request->phone;
                $attorney->firm_name = $request->organizer_name;
                $attorney->street_address = $request->address1;
                $attorney->city = $request->city;
                $attorney->state = $request->state;
                $attorney->zip = $request->code;
                $attorney->b_id = $request->bar_id;
                $attorney->save();
            } else {
                // If attorney record doesn't exist, create a new one
                attorny::create([
                    'admin_id' => $id,
                    'name' => $request->organizer_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'firm_name' => $request->organizer_name,
                    'street_address' => $request->address1,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip' => $request->code,
                    'b_id' => $request->bar_id,
                ]);
            }
        }
        $request->session()->flash('success', 'Updated Successfully');
        return redirect()->route('users');
    }



    public function delete_users($id)
    {
        admin::find($id)->delete();
        AdminInfo::where('admin_id', $id)->first()->delete();
        attorny::where('admin_id', $id)->first()->delete();
        return redirect()->route('users');
    }

    public function userDetails($id)
    {
        return admin::with('admin_info_single', 'attorney_info')->where('id', $id)->first();
    }

    public function inviteUser(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'role' => 'required',
        ]);

        $email = $request->email;
        $role = $request->role;

        Mail::send('client.mail.inviteUser', ['email' => $email, 'role' => $role, 'ownerId' => session('admin_id')], function ($message) use ($email) {
            $message->to($email)->subject("Your are Invited!!");
        });

        $request->session()->flash('success', 'Invitation link has been sent successfully');
        return redirect()->back();
    }
}
