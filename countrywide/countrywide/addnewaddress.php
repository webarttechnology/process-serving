<?php
session_start();
// $newmemb=$_POST['newmemb'];
// echo $atrname;
// echo json_encode("aynu");exit;

// echo "atr";exit;
$newadr=$_POST['newadr'];
$newadrunit=$_POST['newadrunit'];
$newcity=$_POST['newcity'];
$newstate=$_POST['newstate'];
$newzip=$_POST['newzip'];

$jxml="<?xml version=\"1.0\" ?>
<auth>
<ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
<custid>cw</custid>
<func>ADDNEWADDRESS</func>
<newaddress>".$newadr."</newaddress>
<newunit>".$newadrunit."</newunit>
<newcity>".$newcity."</newcity>
<newstate>".$newstate."</newstate>
<newzip>".$newzip."</newzip>
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
    $res = simplexml_load_string($result);
    $id=$res->Detail;
    $id=explode("=",$id);
    // echo $result;exit;

    echo json_encode($id[1]);

}
catch(SoapFault $fault){
    die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
}

?>
