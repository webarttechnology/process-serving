<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapClient;
use SoapFault;

class XmlCallController extends Controller
{

    public static function allCourts()
    {
        $jxml = "<?xml version=\"1.0\" ?>
        <auth>
            <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
            <custid>cw</custid>
            <func>SEARCHCOURTS</func>
            <agencylogin>1</agencylogin>
            <filters>
                <filter>
                    <param>courts.ename</param>
                    <qualifier>like</qualifier>
                    <value></value>
                </filter>
                <filter>
                    <param>courts.ebranchname</param>
                    <qualifier>like</qualifier>
                    <value></value>
                </filter>
            </filters>
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
            // echo json_encode($result);exit;
            $res = simplexml_load_string($result);
            $resxml = json_decode(json_encode($res), true);
            return $res;
        } catch (SoapFault $fault) {
            return [];
        }
    }
    
}