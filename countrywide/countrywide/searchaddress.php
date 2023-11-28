<?php
$adr=$_POST['adr'];
// echo $caseno;exit;

$jxml="<?xml version=\"1.0\" ?>
<auth>
<ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
<custid>cw</custid>
<func>GETADDRESS</func>
<address>".$adr."</address>
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
$res = simplexml_load_string($result);
$adrli="";
if($_POST['type']=="single")
{
    foreach($res->Address as $row)
    {
        $adrli.="<li><a href data-adrid='".$row->addrid."' class='adrlst'>".$row->address.",".$row->city.",".$row->state.",".$row->zip.",".$row->country."</a></li>";
    }
}
else if($_POST['type']=="multi")
{
    foreach($res->Address as $row)
    {
        $adrli.="<li><a href data-adrid='".$row->addrid."' class='multadrsrchli'>".$row->address.",".$row->city.",".$row->state.",".$row->zip.",".$row->country."</a></li>";
    }
}
echo json_encode($adrli);

}
catch(SoapFault $fault){
    die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
}
?>
