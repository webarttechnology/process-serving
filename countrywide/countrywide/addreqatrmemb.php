<?php
session_start();
$newmemb=$_POST['newmemb'];
// echo $atrname;
// echo $newmemb;exit;

if($newmemb=="atr")
{
    // echo "atr";exit;
    $atrname=$_POST['atrname'];
    $atrbarid=$_POST['atrbarid'];

    $atremail=$_POST['atremail'];
    $atraddress=$_POST['atraddress'];
    $atrcity=$_POST['atrcity'];
    $atrstate=$_POST['atrstate'];
    $atrzip=$_POST['atrzip'];
    $atrphone=$_POST['atrphone'];

    $jxml="<?xml version=\"1.0\" ?>
    <auth>
        <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
        <custid>cw</custid>
        <func>ADDNEWATTORNEY</func>
        <clientid>".$_SESSION['ClientIDn']."</clientid>
        <newattorneyname>".$atrname."</newattorneyname>
        <newattorneybarnum>SBAR#: ".$atrbarid."</newattorneybarnum>
        <newattorneyemail>".$atremail."</newattorneyemail>
        <newattorneyaddress>".$atraddress."</newattorneyaddress>
        <newattorneycity>".$atrcity."</newattorneycity>
        <newattorneystate>".$atrstate."</newattorneystate>
        <newattorneyzip>".$atrzip."</newattorneyzip>
        <newattorneyphone>".$atrphone."</newattorneyphone>
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
        // echo $result;exit;

        echo json_encode($result);

    }
    catch(SoapFault $fault){
        die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
    }
}
else if($newmemb=="req")
{
    // echo "req";exit;
    $reqname=$_POST['reqname'];
    $reqemail=$_POST['reqemail'];
    // echo json_encode($reqemail);exit;

    $jxml="<?xml version=\"1.0\" ?>
    <auth>
        <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
        <custid>cw</custid>
        <func>ADDNEWREQUESTOR</func>
        <clientid>".$_SESSION['ClientIDn']."</clientid>
        <newrequestorname>".$reqname."</newrequestorname>
        <newrequestoremail>".$reqemail."</newrequestoremail>
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
        // echo $result;exit;

        echo json_encode($result);

    }
    catch(SoapFault $fault){
        die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
    }
}
?>
