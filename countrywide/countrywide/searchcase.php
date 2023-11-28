<?php
$caseno=$_POST['caseno'];
$clientid=$_POST['clientid'];
// echo $caseno;exit;

$jxml="<?xml version=\"1.0\" ?>
<auth>
    <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
    <custid>cw</custid>
    <func>SEARCHCASES</func>
    <filters>
        <filter>
            <param>cases.caseno</param>
            <qualifier>like</qualifier>
            <value>".$caseno."</value>
        </filter>
		<filter>
            <param>cases.clientid</param>
            <qualifier>like</qualifier>
            <value>".$clientid."</value>
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
	libxml_disable_entity_loader(false);
$client = new SoapClient("https://".$ldserver."/doldmaxservices.wsdl",$options);
$client->__setLocation("https://".$ldserver."/doldmaxservices.php");

$result = $client->doFunction($jxml);
//echo json_encode($result);


$xmlres = simplexml_load_string($result); 
//echo $json = json_encode($xmlres);
$json = json_encode($xmlres,JSON_FORCE_OBJECT);

$resarr=array();
$xmarray=json_decode($json,true);

//$i=0;
foreach($xmarray as $key=>$values)
{
	$resarr[$key]	= $values;
	//$i++;
}

echo $json_data=json_encode($resarr); 
			
// $case=simplexml_load_string($result);
// $case=json_decode(json_encode($case),true);
// echo $case['Case'][0]['Court'];
// echo $case['Case']['Court'];
// for($i=0;$i<count())
// foreach($case->Cases->children() as $row)
// {
//     echo $row->CaseID;
//     exit;
// }
}
catch(SoapFault $fault){
    //die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
	$resarr=array();
	echo $json_data=json_encode($resarr); 
}

// $xslt = new xsltProcessor;
// $xslt->registerPHPFunctions();
// $xslt->importStyleSheet(DomDocument::load("header1.xsl"));
// print $xslt->transformToXML(DomDocument::loadXML($result));
// echo "<script src='assets/js/filter.js'></script>";
?>
