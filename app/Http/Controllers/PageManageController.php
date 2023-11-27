<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\AdminInfo;
use App\Models\ccase;
use App\Models\order;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use SimpleXMLElement;

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
        $customerId = '';
        $userInfo = admin::with('adminInfo')->find(session('admin_id'));
        $ch = curl_init();

        if ($userInfo->role == 'owner_admin') {
            $customerId = $userInfo->adminInfo->stax_customer_id;
            $ownerId = $userInfo->id;
        } else {
            $ownerInfo = admin::with('adminInfo')->find($userInfo->owner_id);
            $ownerId = $userInfo->owner_id;
            $customerId = $ownerInfo->adminInfo->stax_customer_id;
        }

        curl_setopt($ch, CURLOPT_URL, "https://apiprod.fattlabs.com/customer/" . $customerId . "/payment-method");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZXJjaGFudCI6ImRmODMzOWEwLTk4N2UtNGUxZC1iMDYxLWUyYWUwNTcxYTZlMiIsImdvZFVzZXIiOmZhbHNlLCJhc3N1bWluZyI6ZmFsc2UsImJyYW5kIjoiZmF0dG1lcmNoYW50LXNhbmRib3giLCJzdWIiOiI5OTI1YzVlNi05MzczLTQ4MjUtOWJkYy0wYTgzNzE0ZDc3MGYiLCJpc3MiOiJodHRwOi8vYXBpcHJvZC5mYXR0bGFicy5jb20vc2FuZGJveCIsImlhdCI6MTcwMDQ1NDg1OCwiZXhwIjo0ODU0MDU0ODU4LCJuYmYiOjE3MDA0NTQ4NTgsImp0aSI6IjNQb251dXk5Rmx6Sm5ONjAifQ._gqDA6-FZSFHEXXzOOjbRNu329b3bQo46__Bib08kBg",
            "Accept: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $paymentInfo = json_decode($response, true);

        return view('client.settings', compact('userInfo', 'paymentInfo', 'ownerId', 'customerId'));
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

        $cases = order::with('case', 'documents', 'parties', 'servees', 'serveAddress')->get()->toArray();
        $data = [];
        foreach ($cases as $key => $case) {
            $data = [
                'caseId' => $case['id']
            ];
        }

        function arrayToXml($data, &$xmlData)
        {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    if (is_numeric($key)) {
                        // If the key is numeric, use a generic item name
                        $key = 'item';
                    }
                    $subnode = $xmlData->addChild($key);
                    arrayToXml($value, $subnode);
                } else {
                    $xmlData->addChild("$key", htmlspecialchars("$value"));
                }
            }
        }


        // Create a new SimpleXMLElement
        $xmlData = new SimpleXMLElement('<cases/>');

        // Call the function to convert the PHP array to XML
        arrayToXml($data, $xmlData);

        // Format the XML for readability
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xmlData->asXML());
        echo $dom->saveXML();
        exit;

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
}
