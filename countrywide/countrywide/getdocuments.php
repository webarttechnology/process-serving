<?php
session_start();
// $newmemb=$_POST['newmemb'];
// echo $atrname;
// echo json_encode("aynu");exit;

// echo json_encode("dooocs");exit;

$id="";
$value="";
$fltrtype="";// starts/contain

$type=$_POST['type'];
if($type=="dynamic")
{
    $id=$_POST['doc_id'];
}
else if($type=="filter")
{
    $value=$_POST['dockey'];
    $fltrtype=$_POST['fltrtype'];
    // echo json_encode($value.$fltrtype);exit;
}
// $caseno=$_POST['caseno'];
// $courtid=$_POST['courtid'];
// $court=$_POST['court'];
// $atrid=$_POST['atrid'];
$jxml="<?xml version=\"1.0\" ?>
    <auth>
        <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
        <custid>cw</custid>
        <func>GETDOCUMENTS</func>
        <type>".$type."</type>
        <docid>".$id."</docid>
        <filter>".$value."</filter>
        <fltrtype>".$fltrtype."</fltrtype>
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

if($type=="getalldoc")// get all doc types
{
    // echo json_encode("getalldocs");exit;
    try {
        $client = new SoapClient("https://".$ldserver."/doldmaxservices.wsdl",$options);
        $client->__setLocation("https://".$ldserver."/doldmaxservices.php");

        $result = $client->doFunction($jxml);
        $res = simplexml_load_string($result);
        $doctype="";
        $doctype.="<option value=''>--select--</option>";
        foreach($res->Doc as $row)
        {
            $doctype.="<option class='doctypelst' value='".$row->docid."'>".$row->doctype."</option>";
        }
        // echo $result;exit;

        echo json_encode($doctype);

    }
    catch(SoapFault $fault){
        die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
    }
}
else if($type=="dynamic")// for dynamic dropdown
{
    echo json_encode("some doc title - bla blah blaah");exit;

    // try {
    //     $client = new SoapClient("https://".$ldserver."/doldmaxservices.wsdl",$options);
    //     $client->__setLocation("https://".$ldserver."/doldmaxservices.php");

    //     $result = $client->doFunction($jxml);
    //     $res = simplexml_load_string($result);
    //     $doctype="";
    //     $doctype.="<option value=''>--select--</option>";
    //     foreach($res->Doc as $row)
    //     {
    //         $doctype.="<option value='".$row->docid."'>".$row->doctype."</option>";
    //     }
    //     // echo $result;exit;

    //     echo json_encode($doctype);exit;

    // }
    // catch(SoapFault $fault){
    //     die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
    // }
}
else if($type=="filter")// for doc type search filter
{
    // echo json_encode("some doc filter - bla blah blaah");exit;

    try {
        $client = new SoapClient("https://".$ldserver."/doldmaxservices.wsdl",$options);
        $client->__setLocation("https://".$ldserver."/doldmaxservices.php");

        $result = $client->doFunction($jxml);
        // echo json_encode($result);exit;
        $res = simplexml_load_string($result);
        $doctype="";
        $i=0;
        foreach($res->Doc as $row)
        {
            $i++;
            $doctype.="<li><a href data-docid='".$row->docid."' class='doclst'>".$row->doctype."</a></li>";
        }
        // echo $result;exit;

        echo json_encode($doctype);exit;

    }
    catch(SoapFault $fault){
        die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
    }
}
?>
