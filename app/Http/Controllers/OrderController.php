<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
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
        $order = Order::with('case', 'documents', 'parties', 'servees', 'serveAddress')->find(session('order_id'));
        $order->attempt_type = json_encode($req->input('attempt_type'));
        $order->attempt_time = json_encode($req->input('optradio'));
        $order->internal_reference_number = $req->input('irn');
        $order->notification = $req->input('notification');
        $order->status = 'pending';
        $order->save();



        $jxml = "<?xml version=\"1.0\" ?>
            <auth>
                <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
                <custid>cw</custid>
                <func>CWADDNEWCASE</func>
                <ClientID>" . $_SESSION['ClientIDn'] . "</ClientID>
                <AttorneyID>" . $atrid . "</AttorneyID>
                <RequestorID>" . $reqid . "</RequestorID>
                <CourtID>" . $courtid . "</CourtID>
                <CaseNo>" . $caseno . "</CaseNo>
                <CaseLevelBillingCode>" . $billcode . "</CaseLevelBillingCode>
                <Plaintiff>" . $plntf . "</Plaintiff>
                <PlaintiffRole>" . $plntfrole . "</PlaintiffRole>
                <Defendant>" . $diff . "</Defendant>
                <DefendantRole>" . $diffrole . "</DefendantRole>
                <CaseLevelNotes>This is a test case</CaseLevelNotes>
                <Docmethod>" . $docmethod . "</Docmethod>
                <Servees>
                    <Serveenum>" . $prtynum . "</Serveenum>
                    <Samedocchk>" . $samedocs . "</Samedocchk>
                    " . $xmlservenodes . "
                </Servees>
                <Notify>
                    <emailnum>" . count($emailarr) . "</emailnum>
                    " . $xmlemailnodes . "
                </Notify>
                <agencylogin>1</agencylogin>
            </auth>";
        // echo json_encode($jxml);exit;
        // echo $jxml;exit;

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
            // echo $result;exit;

            echo json_encode($result);
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
}