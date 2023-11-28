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
	
    die("SOAP Fault:<br />fault code: ".$fault->faultcode.", fault string: ".$fault->faultstring);
}



/*$xslt = new xsltProcessor;
$xslt->registerPHPFunctions();
$xslt->importStyleSheet(DomDocument::load("header.xsl"));
print $xslt->transformToXML(DomDocument::loadXML($result));*/

// Create an XSLTProcessor object
$xslt = new XSLTProcessor();

// Load the XSL stylesheet
$stylesheet = new DOMDocument();
$stylesheet->load("header.xsl");

// Import the XSL stylesheet
$xslt->importStylesheet($stylesheet);

// Load the input XML
$inputXml = new DOMDocument();
$inputXml->loadXML($result);

// Apply the XSL transformation
$nresult = $xslt->transformToXML($inputXml);

// Print the result
print $nresult;



/*$xslt = new xsltProcessor;
$xslt->registerPHPFunctions();
$xslt->importStyleSheet(DomDocument::load("dashboard.xsl"));
print $xslt->transformToXML(DomDocument::loadXML($result));*/


// Create an XSLTProcessor object
$xslt = new XSLTProcessor();

// Load the XSL stylesheet
$stylesheet = new DOMDocument();
$stylesheet->load("dashboard.xsl");

// Import the XSL stylesheet
$xslt->importStylesheet($stylesheet);

// Load the input XML
$inputXml = new DOMDocument();
$inputXml->loadXML($result);

// Apply the XSL transformation
$nresult = $xslt->transformToXML($inputXml);

// Print the result
print $nresult;




echo "<script src='assets/js/placeorder.js'></script>";

include('footer.php'); 
?>