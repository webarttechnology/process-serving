<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\admin;
use App\Models\attorny;
use App\Models\document;
use App\Models\order;
use App\Models\serve;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SoapClient;
use SoapFault;

class OrderController extends Controller
{
    public function chargeJob( $orderId, $amount )
    {
        $apiKey = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZXJjaGFudCI6ImJiOTM2NjQ5LTZhZjYtNGQ5NS1hMjIwLTg1N2U0OWYwMDg0OCIsImdvZFVzZXIiOmZhbHNlLCJhc3N1bWluZyI6ZmFsc2UsImJyYW5kIjoiZmF0dG1lcmNoYW50LXNhbmRib3giLCJzdWIiOiI1OGY4MDYwYi0zNjI5LTQzOTctOTJkYS1mYjk0Yjc5MWQyY2IiLCJpc3MiOiJodHRwOi8vYXBpcHJvZC5mYXR0bGFicy5jb20vc2FuZGJveCIsImlhdCI6MTcwNTI5NDI4NywiZXhwIjo0ODU4ODk0Mjg3LCJuYmYiOjE3MDUyOTQyODcsImp0aSI6Ik56aXdIM1dWcW05cGlWb3oifQ.NgAKOXh7x6pupTp9MZQX3iih3XYXWqxwPvLNDboNxtM';

        $customerId = '';
        $paymentToken = '';
        $apiEndpoint = 'https://private-anon-013420dd9c-staxapi.apiary-proxy.com/charge';

        $userInfo = admin::with('adminInfo')->find(session('admin_id'));
        if ($userInfo->role == 'owner_admin' || $userInfo->role == 'Admin') {
            $customerId = $userInfo->adminInfo->stax_customer_id;
            // dd($userInfo->adminInfo);
            $paymentToken = $userInfo->adminInfo->payment_token;
        } else {
            $ownerInfo = admin::with('adminInfo')->find($userInfo->owner_id);
            $paymentToken = $ownerInfo->adminInfo->payment_token;
            $customerId = $ownerInfo->adminInfo->stax_customer_id;
        }

        $arr = [
            'payment_method_id' => "$paymentToken",
            "total" => $amount,
            "pre_auth" => true,
            "meta" => [
                'poNumber' => $customerId,
                'payment_note' => "Billing CHarge"
            ]
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arr));


        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey",
            "Accept: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);


        var_dump(json_decode($response, true));exit;

        dd($orderId, $amount);
    }

    public function edit_draft_order($id)
    {
        $order = order::with('case')->where('status', 'draft')->find($id);

        session()->put('order_id', $id);
        session()->put('case_id', $order->case->case_no);
        session()->put('step', $order->step);

        if( $order->doc_check ) {
            session()->put('doc_check', true);
        }
        
        if( $order->add_check ) {
            session()->put('add_check', true);
        }

        return redirect('place-order');
    }

    public function del_order( Request $req, $id )
    {
        if ($req->ajax()) {
            $order = order::find($id);
            $order->delete();
            return true;
        }
        return abort(404);
    }

    public function save_as_draft()
    {
        $order = Order::find(session('order_id'));
        $order->status = 'draft';
        $order->save(); 
        
        session()->forget('order_id');
        session()->forget('case_id');
        session()->forget('step');
        session()->forget('doc_check');
        session()->forget('add_check');

    }
    
    public function reset_order()
    {
        session()->forget('order_id');
        session()->forget('case_id');
        session()->forget('step');
        session()->forget('doc_check');
        session()->forget('add_check');
        
        return redirect()->to('place-order');
    }

    public function final_step(Request $req)
    {
        $order = Order::with('case', 'documents', 'parties', 'servees', 'serveAddress','plaintiffParty', 'defendantParty')->find(session('order_id'));

        $attemptType = [];
        $attemptTime = [];

        foreach ($req->input('attempt_type') as $key => $arr) {
            foreach( $arr as $key2 => $val )
            {
                $attemptType[] = $val;
                $attemptTime[] = $req->input('optradio')[$key][$key2];
            }
        }

        
        $order->attempt_type = json_encode($attemptType);
        $order->attempt_time = json_encode($attemptTime);
        $order->internal_reference_number = $req->input('irn');
        $order->notification = $req->input('notification');
        $order->status = 'pending';
        $order->save();

        $attroeny = attorny::where('name', $order->case->attorney)->first();

        $xmlservenodes = '';

        foreach ($order->servees as $serve) 
        {
            $addresses = json_decode($serve->address, true);
            $states = json_decode($serve->state, true);
            $units = json_decode($serve->unit, true);
            $zips = json_decode($serve->zip, true);
            $cities = json_decode($serve->city, true);
            $attemptType = json_decode($order->attempt_type, true);
            $attemptTime = json_decode($order->attempt_time, true);
            $businessName = json_decode($serve->business_name, true);
            
            foreach ($addresses as $key => $address) 
            {
                // var_dump($states[$key]);exit;
                $jxml = "<?xml version=\"1.0\" ?>
                    <auth>
                        <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
                        <custid>cw</custid>
                        <func>ADDNEWADDRESS</func>
                        <newaddress>". $address ."</newaddress>
                        <newunit>". $units[$key] ."</newunit>
                        <newcity>". $cities[$key] ."</newcity>
                        <newstate>". $states[$key] ."</newstate>
                        <newzip>". $zips[$key] ."</newzip>
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
        
                    try {
                        $client = new SoapClient("https://" . $ldserver . "/doldmaxservices.wsdl", $options);
                        $client->__setLocation("https://" . $ldserver . "/doldmaxservices.php");
        
                        $result = $client->doFunction($jxml);
                        $res = simplexml_load_string($result);
        
                        $id = $res->Detail;
                        $id = explode("=", $id);
        
                        $serveUpdate = serve::find($serve->id);
                        $serveUpdate->ldmax_addr_id = $id[1];
                        $serveUpdate->save();
                    } catch (SoapFault $fault) {
                    }

                    $price = 65;

                    switch ($attemptType[$key]) {
                        case 'urgent':
                            $price = 125;
                            break;
                        case 'priority':
                            $price = 75;
                            break;
                        case 'on demand':
                            $price = 195;
                            break;
                    }

                    $busName = !empty($businessName[$key]) ? $businessName[$key] : '';

                    $date = Carbon::parse($serve->h_date);

                    $hrDate = $date->format('Y-m-d');
                    $hrTime = $date->format('H:i');

                    $xmlservenodes .= "<Servee>
                                    <Serveename>" . $serve->p_t_serve . "</Serveename>
                                    <Serveecap>". count($order->servees) . "</Serveecap>
                                    <Regagent>1</Regagent>
                                    <Addr></Addr>
                                    <AddrID>" . $id[1] . "</AddrID>
                                    <Busname>" . $busName . "</Busname>
                                    <Tzone>" . $serve->timezone . "</Tzone>
                                    <Hrdate>" . $hrDate . "</Hrdate>
                                    <Hrtime>" . $hrTime . "</Hrtime>
                                    <Wtnsfee>" . $serve->w_fee . "</Wtnsfee>
                                    <Proof>" . $serve->proof . "</Proof>
                                    <Splinstrcns>" . $serve->s_inst . "</Splinstrcns>
                                    <Atmdate>". date('Y-m-d', strtotime($attemptTime[$key])) ."</Atmdate>
                                    <Atmtime>". date('H:i', strtotime($attemptTime[$key])) ."</Atmtime>
                                    <Atmamt>$price</Atmamt>
                                    <Itemname>$attemptType[$key]</Itemname>
                                    <Itemdate>$attemptTime[$key]</Itemdate>
                                    <Docs>";
        
                    if( $order->doc_check )
                    {
                        $docs = document::where('order_id', session('order_id'))->get();
                    } else {
                        $docs = document::where('s_no', $serve->id)->get();
                    }
        
                    foreach ($docs as $doc) 
                    {
                        $getcnt = base64_encode(file_get_contents('uploads/' . $doc->document));
        
                        $xmlservenodes .= "<Doc>
                                            <title>$doc->d_title</title>
                                            <titleid>4</titleid>
                                            <fileid>6</fileid>
                                            <filename>" . $doc->document . "</filename>
                                            <fileext>" . pathinfo($doc->document, PATHINFO_EXTENSION) . "</fileext>
                                            <filegetcnt>" . $getcnt . "</filegetcnt>
                                        </Doc>";
                    }
        
                    $xmlservenodes .= "</Docs></Servee>";
            }


        }
        
        $jxml = "<?xml version=\"1.0\" ?>
            <auth>
                <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
                <custid>cw</custid>
                <func>CWADDNEWCASE</func>
                <ClientID>" . session('ClientIDn') . "</ClientID>
                <AttorneyID>" . $attroeny->ldmax_id . "</AttorneyID>
                <RequestorID></RequestorID>
                <CourtID>" . $order->case->jurisdiction . "</CourtID>
                <CaseNo>" . $order->case->case_no . "</CaseNo>
                <CaseLevelBillingCode></CaseLevelBillingCode>
                <Plaintiff>" . $order->plaintiffParty->name . "</Plaintiff>
                <PlaintiffRole>" . $order->plaintiffParty->role . "</PlaintiffRole>
                <Defendant>" . $order->defendantParty->name . "</Defendant>
                <DefendantRole>" . $order->defendantParty->role . "</DefendantRole>
                <CaseLevelNotes>This is a test case</CaseLevelNotes>
                <Docmethod>up</Docmethod>
                <Servees>
                    <Serveenum>" . count($order->parties) . "</Serveenum>
                    <Samedocchk>" . $order->doc_check . "</Samedocchk>
                    " . $xmlservenodes . "
                </Servees>
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

        try {
            $client = new SoapClient("https://" . $ldserver . "/doldmaxservices.wsdl", $options);
            $client->__setLocation("https://" . $ldserver . "/doldmaxservices.php");

            $result = $client->doFunction($jxml);
            $res = simplexml_load_string($result);

            // var_dump($res, $jxml);

            $resxml = json_decode(json_encode($res), true);

            preg_match('/CaseID (\d+)/', $resxml['Detail'], $matches);
            $ldmaxId = $matches[1];

            $query = order::find($order->id);
            $query->ldmax_id = $ldmaxId;
            $query->save();
        } catch (SoapFault $fault) {
            die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
        }

        session()->forget('order_id');
        session()->forget('case_id');
        session()->forget('doc_check');
        session()->forget('add_check');
        session()->forget('step');
        return true;
    }

    public function order_details_view( Request $req, $id )
    {
        $jxml = "<?xml version=\"1.0\" ?>
            <auth>
                <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
                <custid>cw</custid>
                <func>SEARCHCASES</func>
                <filters>
                    <filter>
                        <param>cases.active</param>
                        <qualifier>=</qualifier>
                        <value>1</value>
                    </filter>
                    <filter>
                        <param>cases.instance</param>
                        <qualifier>=</qualifier>
                        <value>" . $id . "</value>
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

        try {
            $client = new SoapClient("https://" . $ldserver . "/doldmaxservices.wsdl", $options);
            $client->__setLocation("https://" . $ldserver . "/doldmaxservices.php");

            $result = $client->doFunction($jxml);

            $res = simplexml_load_string($result);

            $order = json_decode(json_encode($res), true);
            $order = $order['Case'];

        } catch (SoapFault $fault) {
            die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
        }

        return view('client.order_details', compact('order', 'id'));
    }
}