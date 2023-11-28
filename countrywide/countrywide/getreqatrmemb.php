<?php
session_start();
$memb=$_POST['memb'];
$id=$_POST['id'];
// echo $atrname;
// echo $newmemb;exit;

if($memb=="at")
{
    // echo "atr";exit;

    $jxml="<?xml version=\"1.0\" ?>
    <auth>
        <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
        <custid>cw</custid>
        <func>GETATTORNEY</func>
        <attyid>".$id."</attyid>
        <agencylogin>1</agencylogin>
    </auth>";


    $ldserver="ldmax.loyalpuppy.com";

    $options = array(
        'cache_wsdl' => 0,
        'uri'=>"urn:ld",
        'compression'=> SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
        'trace' => 1,
        'stream_context' => stream_context_create(array(
            'ssl' => array(
                'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
            )
    )));

    try {
        $client = new SoapClient("https://".$ldserver."/doldmaxservices.wsdl",$options);
        $client->__setLocation("https://".$ldserver."/doldmaxservices.php");

        $result = $client->doFunction($jxml);

        // $xml=simplexml_load_string($result);
        // // echo $xml->Attorney->AttorneyID;exit;
        // foreach($xml->Attorney as $row)
        // {
        //     echo $row->AttorneyID;
        //     echo "<br>";
        // }
        // echo $result;exit;

        echo json_encode($result);

    }
    catch(SoapFault $fault){
        die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
    }
}
// else if($memb=="req")
// {
    // echo "req";exit;

    $jxml="<?xml version=\"1.0\" ?>
    <auth>
        <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
        <custid>cw</custid>
        <func>GETREQUESTOR</func>
        <attyid>".$id."</attyid>
        <agencylogin>1</agencylogin>
    </auth>";


//     $ldserver="ldmax.loyalpuppy.com";

//     $options = array(
//         'cache_wsdl' => 0,
//         'uri'=>"urn:ld",
//         'compression'=> SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
//         'trace' => 1,
//         'stream_context' => stream_context_create(array(
//             'ssl' => array(
//                 'verify_peer' => false,
//                     'verify_peer_name' => false,
//                     'allow_self_signed' => true
//             )
//     )));

//     try {
//         $client = new SoapClient("https://".$ldserver."/doldmaxservices.wsdl",$options);
//         $client->__setLocation("https://".$ldserver."/doldmaxservices.php");

//         $result = $client->doFunction($jxml);
//         echo $result;exit;

//         // echo json_encode($result);

//     }
//     catch(SoapFault $fault){
//         die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
//     }
// }

if($_POST['getall']=="all")
{
    // echo json_encode($_SESSION['Passwordn']);exit;
    $jxml1="<?xml version=\"1.0\" ?>
    <auth>
        <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
        <custid>cw</custid>
        <func>SEARCHCLIENTS</func>
        <filters>
            <filter>
                <param>clients.mainlogin</param>
                <qualifier>=</qualifier>
                <value>".$_SESSION['Emailn']."</value>
            </filter>
            <filter>
                <param>clients.mainpass</param>
                <qualifier>=</qualifier>
                <value>".$_SESSION['Passwordn']."</value>
            </filter>
        </filters>
        <agencylogin>1</agencylogin>
    </auth>";

    $ldserver="ldmax.loyalpuppy.com";

    $options = array(
        'cache_wsdl' => 0,
        'uri'=>"urn:ld",
        'compression'=> SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
        'trace' => 1,
        'stream_context' => stream_context_create(array(
            'ssl' => array(
                'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
            )
    )));

    try {
        $client1 = new SoapClient("https://".$ldserver."/doldmaxservices.wsdl",$options);
        $client1->__setLocation("https://".$ldserver."/doldmaxservices.php");

        $result1 = $client1->doFunction($jxml1);

        $res = simplexml_load_string($result1);
        $reqatrli="<option selected='' value=''>Attorney of Record:</option>
        <option value='new'>New</option>";
        foreach($res->Client->Attorneys->Attorney as $row)// for attorney options
        {
            $reqatrli.="<option value='".$row->AttorneyID."/at'>".$row->Attorney."</option>";
        }
        foreach($res->Client->Secretaries->Secretary as $row)// for requestor options
        {
            $reqatrli.="<option value='".$row->SecretaryID."/req'>".$row->Secretary."</option>";
        }
        // echo $reqatrli;exit;
        echo json_encode($reqatrli);
    }
    catch(SoapFault $fault1){
        die("SOAP Fault:<br />fault code: {$fault1->faultcode}, fault string: {$fault1->faultstring}");
    }
}
?>
