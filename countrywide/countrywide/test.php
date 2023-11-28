<?php
session_start();
include('header.php');

$jxml="<?xml version=\"1.0\" ?>
<auth>
    <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
    <custid>cw</custid>
    <func>SEARCHCLIENTS</func>
    <filters>
        <filter>
            <param>clients.mainlogin</param>
            <qualifier>=</qualifier>
            <value>".$email."</value>
        </filter>
        <filter>
            <param>clients.mainpass</param>
            <qualifier>=</qualifier>
            <value>".$pass."</value>
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
$client = new SoapClient("https://".$ldserver."/doldmaxservices.wsdl",$options);
$client->__setLocation("https://".$ldserver."/doldmaxservices.php");

$result = $client->doFunction($jxml);
echo $result;exit;
}
catch(SoapFault $fault){
    die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
}

$xslt = new xsltProcessor;
$xslt->registerPHPFunctions();
$xslt->importStyleSheet(DomDocument::load("header_prserving.xsl"));
print $xslt->transformToXML(DomDocument::loadXML($result));

include('prserving.xsl');

// $xslt = new xsltProcessor;
// $xslt->registerPHPFunctions();
// $xslt->importStyleSheet(DomDocument::load("dashboard.xsl"));
// print $xslt->transformToXML(DomDocument::loadXML($result));

echo "<script src='assets/js/prserving1.js'></script>";
echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js'></script>";
echo "<script src='assets/js/prserving.js'></script>";

include('footer.php'); ?>