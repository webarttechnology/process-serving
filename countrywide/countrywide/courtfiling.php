<?php
session_start();
include('header.php');

$jxml="<?xml version=\"1.0\" ?>
<auth>
<ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
<custid>cw</custid>
<func>GETHEADER</func>
<ClientID>".$_SESSION['ClientID']."</ClientID>
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

}
catch(SoapFault $fault){
    die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
}

$xslt = new xsltProcessor;
$xslt->registerPHPFunctions();
$xslt->importStyleSheet(DomDocument::load("header.xsl"));
print $xslt->transformToXML(DomDocument::loadXML($result));

$xslt = new xsltProcessor;
$xslt->registerPHPFunctions();
$xslt->importStyleSheet(DomDocument::load("courtfiling.xsl"));
print $xslt->transformToXML(DomDocument::loadXML($result));

// include("recentcases.php");

include('footer.php'); ?>