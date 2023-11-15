<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\AdminInfo;
use App\Models\attorny;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function verify($id, Request $req)
    {
        $admin = admin::find($id);
        $admin->verified = 1;
        $admin->save();

        $req->session()->flash('success', 'Your email has been successfully verified. Please login to visit your dashboard');
        return redirect('/');
    }

    public function register(Request $request)
    {

        $admin = admin::create([
            'owner_id' => !empty($request->owner_id) ? $request->owner_id : NULL,
            'name' => $request->fname . ' ' . $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => !empty($request->role) ? $request->role : 'owner_admin',
            'password' => Hash::make($request->password)
        ]);

        $adminInfo = AdminInfo::create([
            'admin_id' => $admin->id,
            'type_of_account' => $request->deperment,
            'referral' => $request->referral,
            'referral_other' => $request->referral_other,
            'account_name' => $request->acc_name,
            'address' => $request->address,
            'billing_name' => $request->primary_billing_name,
            'billing_email' => $request->primary_billing_email,
            'billing_state' => $request->business_state,
            'billing_city' => $request->business_city,
            'billing_phone' => $request->primary_billing_phone,
            'billing_code_on_invoice' => $request->invoice_code == 'Yes' ? true : false,
            'payment_token' => $request->payment_token,
            'stax_customer_id' => $request->stax_customer_id
        ]);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://apiprod.fattlabs.com/customer/" . $request->stax_customer_id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
            \"reference\": \"$admin->id\"
        }");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZXJjaGFudCI6IjkzZGYyODE0LTA3NmQtNGEyMC1hOTcwLTBjMzAyMzRjNjJjMSIsImdvZFVzZXIiOmZhbHNlLCJhc3N1bWluZyI6ZmFsc2UsImJyYW5kIjoiZmF0dG1lcmNoYW50LXNhbmRib3giLCJzdWIiOiI2YmY0OWMwMi1kYzRjLTQwZTItYmIxMS1jZmYyZGYxNmIzNWQiLCJpc3MiOiJodHRwOi8vYXBpcHJvZC5mYXR0bGFicy5jb20vc2FuZGJveCIsImlhdCI6MTY5ODgxMDI1NywiZXhwIjo0ODUyNDEwMjU3LCJuYmYiOjE2OTg4MTAyNTcsImp0aSI6InlwRExXNVJVaFpPNE40RVEifQ.4DESXAUnxrbWgnuszkLSAwCV1PkIigaEkPPQziOFndw",
            "Accept: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        // return response()->json($response);exit;

        if ($request->attorney) {
            attorny::create([
                'name' => $request->fname . ' ' . $request->lname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'street_address' => $request->address,
                'state' => $request->business_state,
                'city' => $request->business_city,
                'bar_id' => $request->bar_id
            ]);
        }

        Mail::send('client.mail.verifyEmail', ['id' => $admin->id], function ($message) use ($request) {
            $message->to($request->email)->subject("Verify your email");
        });
    }

    public function login(Request $req)
    {
        if (!App::runningInConsole()) {
            $res = Admin::where(['email' => $req->post('email')])->first();
        }
        if ($res) {
            if (Hash::check($req->post('password'), $res->password)) {

                if ($res->verified) {
                    $req->session()->put('admin_login', true);
                    $req->session()->put('admin_id', $res->id);
                    $req->session()->put('admin_name', $res->name);
                    return redirect('dashboard');
                } else {
                    $req->session()->flash('error', 'Please verify your email first to login');
                    return redirect('/');
                }
            } else {
                $req->session()->flash('error', 'Aww ! Enter Valid Password.');
                return redirect('/');
            }
        } else {
            $req->session()->flash('error', 'Aww ! Enter Valid Email.');
            return redirect('/');
        }
    }

    public function update_password_info(Request $req)
    {
        if ($req->input('password') != $req->input('confirm_password')) {
            return redirect('settings')->with('error', 'Password and confirm password has to be the same');
        }

        $admin = admin::find(session('admin_id'));

        $admin->update([
            'password' => Hash::make($req->input('password'))
        ]);

        return redirect('settings')->with('success', 'Password updated successfully');
    }
    public function update_info(Request $req)
    {
        $admin = admin::find(session('admin_id'));

        $admin->update([
            'name' => $req->input('name'),
            'phone' => $req->input('phone'),
        ]);

        if (!empty(AdminInfo::where('admin_id', session('admin_id'))->first())) {
            $adminInfo = AdminInfo::where('admin_id', session('admin_id'))
                ->update([
                    'address' => $req->input('address'),
                    'billing_state' => $req->input('state'),
                    'billing_city' => $req->input('city'),
                ]);
        } else {
            $adminInfo = AdminInfo::create([
                'admin_id' => session('admin_id'),
                'type_of_account' => 'Admin',
                'address' => $req->input('address'),
                'billing_state' => $req->input('state'),
                'billing_city' => $req->input('city'),
            ]);
        }


        return redirect('settings')->with('success', 'User updated successfully');
    }
}
