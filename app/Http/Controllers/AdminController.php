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
use SoapClient;
use SoapFault;

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

    public function update_payment_method(Request $request)
    {

        $userInfo = admin::with('adminInfo')->find(session('admin_id'));

        if ($userInfo->role == 'owner_admin' || $userInfo->role == 'Admin') {
            $admin = AdminInfo::where('admin_id', $userInfo->id);
        } else {
            $admin = AdminInfo::where('admin_id', $userInfo->owner_id);
        }

        $admin->update([
            'payment_token' => $request->payment_token,
            'stax_customer_id' => $request->stax_customer_id
        ]);

        return redirect('/settings');
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

        Mail::send('client.mail.verifyEmail', ['type' => $request->deperment, 'name' => $request->fname . ' ' . $request->lname, 'email' => $request->email], function ($message) use ($request) {
            $message->to($request->email)->subject("Welcome to Countrywide Process");
        });

        exit;
    }

    public function login(Request $req)
    {
        $email = $_POST['email'];
        $pass = $_POST['password'];

        $validUser = false;
        $jxml = "<?xml version=\"1.0\" ?>
            <auth>
                <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
                <custid>cw</custid>
                <func>SEARCHCLIENTS</func>
                <filters>
                    <filter>
                        <param>clients.mainlogin</param>
                        <qualifier>=</qualifier>
                        <value>" . $req->post('email') . "</value>
                    </filter>
                    <filter>
                        <param>clients.mainpass</param>
                        <qualifier>=</qualifier>
                        <value>" . $req->post('password') . "</value>
                    </filter>
                </filters>
                <agencylogin>1</agencylogin>
            </auth>";

        $ldserver = "ldmax.loyalpuppy.com";

        $options = array(
            'cache_wsdl' => 0,
            'uri' => "urn:ld",
            'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
            'trace' => 1,
            'stream_context' => stream_context_create(array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            ))
        );

        $user = Admin::where(['email' => $req->post('email')])->with('adminInfo')->first();

        if ($user) {
            if (Hash::check($req->post('password'), $user->password)) {
                if ($user->verified) {
                    $validUser = true;
                }
            }
        }

        try {
            $client = new SoapClient("https://" . $ldserver . "/doldmaxservices.wsdl", $options);
            $client->__setLocation("https://" . $ldserver . "/doldmaxservices.php");

            $result = $client->doFunction($jxml);
            $clientarr = simplexml_load_string($result);
            $clientarr = json_decode(json_encode($clientarr), true);
            // var_dump($clientarr);
            // echo $clientarr['Client']['ClientID'];
            // exit;

            //print_r($clientarr);

            if (isset($clientarr['Client']['ClientID']) && $clientarr['Client']['ClientID'] != "") {
                
                if( $validUser )
                {
                    $req->session()->put('ClientIDn', $clientarr['Client']['ClientID']);
                    $req->session()->put('Clientn', $clientarr['Client']['Client']);
                    $req->session()->put('Emailn', $clientarr['Client']['Email']);
                    $req->session()->put('Passwordn', $clientarr['Client']['Password']);
                    $req->session()->put('admin_login', true);
                    $req->session()->put('admin_id', $user->id);
                    $req->session()->put('admin_name', $user->name);
                    return redirect('dashboard');
                    
                } else {
                    $req->session()->flash('error', "You need to register to Process Serving first to login");
                    return redirect('/');
                }

            } else if ($validUser) {
                $options = array(
                    'cache_wsdl' => 0,
                    'uri' => "urn:ld",
                    'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
                    'trace' => 1,
                    'stream_context' => stream_context_create(array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    ))
                );
                $hash = password_hash($user->password, PASSWORD_BCRYPT, $options);
                $jxml = "<?xml version=\"1.0\" ?>
                    <auth>
                            <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
                            <custid>cw</custid>
                            <func>ADDNEWCLIENT</func>
                            <newclientlogin>" . $user->email . "</newclientlogin>
                            <newclientpassword>" . $pass . "</newclientpassword>
                            <newclientname>" . $user->name . "</newclientname>
                            <newclientaddress>" . $user->adminInfo->address . "</newclientaddress>
                            <newclientaddress1>" . $user->adminInfo->address . "</newclientaddress1>
                            <newclientcity>" . $user->adminInfo->billing_city . "</newclientcity>
                            <newclientstate>" . $user->adminInfo->billing_state . "</newclientstate>
                            <newclientzip>" . $user->adminInfo->zip . "</newclientzip>
                            <newclientphone>" . $user->phone . "</newclientphone>
                            <newclientfax></newclientfax>
                            <newclientemail>" . $user->email . "</newclientemail>
                            <agencylogin>1</agencylogin>
                        </auth>";

                    // <auth>
                    //     <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
                    //     <custid>cw</custid>
                    //     <func>ADDNEWCLIENT</func>
                    //     <newclientlogin>registerworking@yopmail.com</newclientlogin>
                    //     <newclientpassword>123456</newclientpassword>
                    //     <newclientname>Countrywide Test</newclientname>
                    //     <newclientaddress>Agarpara, South Station Road</newclientaddress>
                    //     <newclientaddress1>Agarpara, South Station Road</newclientaddress1>
                    //     <newclientcity>Kolkata</newclientcity>
                    //     <newclientstate>West Bengal</newclientstate>
                    //     <newclientzip>700109</newclientzip>
                    //     <newclientphone>1233456678</newclientphone>
                    //     <newclientfax></newclientfax>
                    //     <newclientemail>registerworking@yopmail.com</newclientemail>
                    //     <agencylogin>1</agencylogin>
                    // </auth>";

                try {
                    $client = new SoapClient("https://" . $ldserver . "/doldmaxservices.wsdl", $options);
                    $client->__setLocation("https://" . $ldserver . "/doldmaxservices.php");

                    $result1 = $client->doFunction($jxml);
                    $resxml = simplexml_load_string($result1);
                    $resxml = json_decode(json_encode($resxml), true);
                    // echo $resxml->ClientID;exit;

                    if($resxml['Code'] != 'FAIL' )
                    {
                        $req->session()->put('ClientIDn', $resxml['ClientID']);
                        $req->session()->put('Clientn', $user->name);
                        $req->session()->put('Emailn', $user->email);
                        $req->session()->put('Passwordn', $pass);
                        $req->session()->put('admin_login', true);
                        $req->session()->put('admin_id', $user->id);
                        $req->session()->put('admin_name', $user->name);
    
                        return redirect('dashboard');
                    }
                    $req->session()->flash('error', $resxml['Detail']);
                    return redirect('/');

                } catch (SoapFault $fault) {

                    // dd(1, $fault);
                    $req->session()->flash('error', "SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
                    return redirect('/');
                }
            } else {
                $req->session()->flash('error', "Please enter valid credentials");
                return redirect('/');
            }
        } catch (SoapFault $fault) {
            $req->session()->flash('error', "SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
            return redirect('/');
        }

        // if (!App::runningInConsole()) {
        // $res = Admin::where(['email' => $req->post('email')])->first();
        // }
        // if ($res) {
        // if (Hash::check($req->post('password'), $res->password)) {

        // if ($res->verified) {
        // $req->session()->put('admin_login', true);
        // $req->session()->put('admin_id', $res->id);
        // $req->session()->put('admin_name', $res->name);
        // return redirect('dashboard');
        // } else {
        // $req->session()->flash('error', 'Please verify your email first to login');
        // return redirect('/');
        // }
        // } else {
        // $req->session()->flash('error', 'Aww ! Enter Valid Password.');
        // return redirect('/');
        // }
        // } else {
        // $req->session()->flash('error', 'Aww ! Enter Valid Email.');
        // return redirect('/');
        // }
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
