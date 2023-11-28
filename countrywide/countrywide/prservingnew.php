<?php
session_start();
include('header.php');

$jxml="<?xml version=\"1.0\" ?>
<auth>
<ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
<custid>cw</custid>
<func>GETHEADER</func>
<ClientID>".$_SESSION['ClientIDn']."</ClientID>
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
}
catch(SoapFault $fault){
    die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
}

$xslt = new xsltProcessor;
$xslt->registerPHPFunctions();
$xslt->importStyleSheet(DomDocument::load("header_prserving.xsl"));
print $xslt->transformToXML(DomDocument::loadXML($result));


// for fetching attorney and requestor
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
try {
    $client1 = new SoapClient("https://".$ldserver."/doldmaxservices.wsdl",$options);
    $client1->__setLocation("https://".$ldserver."/doldmaxservices.php");

    $result1 = $client1->doFunction($jxml1);
    // echo $result1;exit;
}
catch(SoapFault $fault1){
    die("SOAP Fault:<br />fault code: {$fault1->faultcode}, fault string: {$fault1->faultstring}");
}

$xslt1 = new xsltProcessor;
$xslt1->registerPHPFunctions();
$xslt1->importStyleSheet(DomDocument::load("prservingnew.xsl"));
print $xslt1->transformToXML(DomDocument::loadXML($result1));

// include('prserving.xsl');

// $xslt = new xsltProcessor;
// $xslt->registerPHPFunctions();
// $xslt->importStyleSheet(DomDocument::load("dashboard.xsl"));
// print $xslt->transformToXML(DomDocument::loadXML($result));

echo "<script src='assets/js/prservingnew.js?v=4'></script>";
echo "<script src='assets/js//wow.min.js'></script>";
echo "<script src='assets/js/prserving.js?v=3'></script>";
echo "<script src='assets/js/sweetalert.min.js'></script>";
include('footer.php'); ?>