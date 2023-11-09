<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\AdminInfo;
use App\Models\order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class PageManageController extends Controller
{
    //

    public function dashboard()
    {
        $pendingOrders = order::where('status', 'pending')->count();
        $draftOrders = order::where('status', 'draft')->count();

        return view('client.dashboard', compact('pendingOrders', 'draftOrders'));
    }

    public function settings()
    {
        $userInfo = admin::find(session('admin_id'));
        $extraInfo = AdminInfo::where('admin_id', session("admin_id"))->first();

        // var_dump($userInfo);exit;

        return view('client.settings', compact('userInfo', 'extraInfo'));
    }

    public function place_order()
    {
        $ca_at = null;
        $orderInfo = null;
        $parties = [];
        $par = [];

        $step = !empty(session('step')) ? session('step') : 1;

        if (!empty(session('order_id'))) {
            $orderInfo = order::find(session('order_id'));
        }

        if (!empty(session('case_id'))) {
            $par = DB::table('parties')
                ->where('case_no', session('case_id'))
                ->get();

            $parties = DB::table('parties')
                ->where(['case_no' => session('case_id')])
                ->whereNotNull('type')
                ->whereNotNull('role')
                ->get();
        }


        $s_d = DB::table('serves')
            ->where(['order_id' => session('order_id')])
            ->get();

        $serve = DB::table('serves')
            ->where(['order_id' => session('order_id')])
            ->get();

        $ca = DB::table('ccases')
            ->where('order_id', session('order_id'))
            ->orWhere('case_no', session('case_id'))
            ->first();

        if (!empty($ca)) {
            $ca_at = DB::table('attornies')
                ->where(['name' => $ca->attorney])
                ->first();
        }

        $att = DB::table('attornies')->get();

        $jur = DB::table('court_details')->get();

        return view('client.place_order', compact('orderInfo', 'par', 'parties', 'ca', 'jur', 'ca_at', 'att', 'step', 's_d', 'serve'));
    }

    public function step1()
    {
        return view('client.step1');
    }

    public function step2()
    {
        return view('client.step2');
    }

    public function step3()
    {
        return view('client.step3');
    }

    public function step4()
    {
        return view('client.step4');
    }

    public function step5()
    {
        return view('client.step5');
    }

    public function step6()
    {
        return view('client.step6');
    }

    public function close_order()
    {
        return view('client.close_order');
    }

    public function pending_order()
    {
        $orders = order::with('case')->where('status', 'pending')->get();

        return view('client.pending_order', compact('orders'));
    }

    public function draft_order()
    {
        $orders = order::with('case')->where('status', 'draft')->get();

        return view('client.draft_order', compact('orders'));
    }

    /**
     * Forget Password
     */

    public function forgot_Pass($verifyCode = null)
    {
        if ($verifyCode == null) {
            return view('client.forgot_password');
        } else {
            $check_code = admin::where('email_verify_code', $verifyCode)->first();

            if ($check_code != null) {
                return view('client.change_password', compact('verifyCode'));
            } else {
                Session()->flash('error', 'Please Verify Your Email Properly');
                return view('client.forgot_password');
            }
        }
    }

    public function forgot_Pass_action(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        $email = $request->email;

        $check_email = admin::whereEmail($email)->first();

        if (!$check_email) {
            $request->session()->flash('error', 'The email you entered is not valid.');
            return redirect()->back();
        } else {
            $code = Str::random(20);

            admin::whereEmail($email)->update([
                'email_verify_code' => $code,
            ]);

            Mail::send('client.mail.forgot_pass_link', ['email' => $email, 'verifyCode' => $code], function ($message) use ($email) {
                $message->to($email)->subject("Forget Password");
            });

            $request->session()->flash('success', 'Please check your email');
            return redirect()->back();
        }
    }

    public function pass_change_action(Request $request)
    {
        if ($request->password == $request->confirm_password) {
            admin::where('email_verify_code', $request->verifyCode)->update([
                'password' => Hash::make($request->password),
            ]);

            $request->session()->flash('success', 'Password is successfully updated');
            return redirect('/');
        } else {
            $request->session()->flash('error', 'Password & Confirm Password Must Be Same');
            return redirect()->back();
        }
    }

    public function users()
    {
        return view('client.users');
    }

    public function add_users()
    {
        return view('client.add_users');
    }
}
