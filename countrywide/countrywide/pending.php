<?php include('header.php');

$jxml="<?xml version=\"1.0\" ?>
<auth>
<ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
<custid>cw</custid>
<func>GETHEADER</func>
<ClientID>2247</ClientID>
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
catch(SoapFault $fault1){
    die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
}

// $res = simplexml_load_string($result);
// echo $res->Info->RecentJobs;exit;
// for($i=0;$i<5;$i++)
// {
//     echo $res->Info->RecentJobs[$i]->JobNum."<br>";
// }exit;
// foreach($res->Info->RecentJobs as $row)
// {
//     foreach($row as $key=>$value)
//     {
//         echo $key."<br>";
//         echo $value."<br>";
//     }
//     // exit;
// }exit;

// $doc = new DomDocument('1.0');
// $doc->preserveWhiteSpace = false;
// $doc->formatOutput = true;

// $root = $doc->createElement('Rooot');
// $root = $doc->appendChild($root);

// foreach($res->Info->RecentJobs as $row)
// {
//     $outer = $doc->createElement('aynu');
//     $outer = $root->appendChild($outer);
//     foreach($row as $key=>$value)
//     {
//         $child = $doc->createElement($key);
//         $child = $outer->appendChild($child);
//         $value = $doc->createTextNode($value);
//         $value = $child->appendChild($value);
//     }
//     // exit;
// }
// $test = $doc->saveXML();
// // echo $test;

// $res1 = simplexml_load_string($test);
// foreach($res1->aynu as $row)
// {
//     foreach($row as $key=>$value)
//     {
//         echo $key."<br>";
//         echo $value."<br>";
//     }
// }
// exit;

$xslt = new xsltProcessor;
$xslt->registerPHPFunctions();
$xslt->importStyleSheet(DomDocument::load("header.xsl"));
// clear any text in the output buffer
print $xslt->transformToXML(DomDocument::loadXML($result));

$xslt = new xsltProcessor;
$xslt->registerPHPFunctions();
$xslt->importStyleSheet(DomDocument::load("pending.xsl"));
print $xslt->transformToXML(DomDocument::loadXML($result));
include('footer.php');

?>