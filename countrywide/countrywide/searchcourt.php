<?php
$court=$_POST['court'];
// echo $caseno;exit;

$jxml="<?xml version=\"1.0\" ?>
<auth>
    <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
    <custid>cw</custid>
    <func>SEARCHCOURTS</func>
    <filters>
        <filter>
            <param>courts.ename</param>
            <qualifier>like</qualifier>
            <value>".$court."</value>
        </filter>
        <filter>
            <param>courts.ebranchname</param>
            <qualifier>like</qualifier>
            <value>".$court."</value>
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
// echo json_encode($result);exit;
$res = simplexml_load_string($result);
$courtli="";
$a="";
$i=0;
foreach($res->Court as $row)
{
    $branch="";
    if(trim($row->Branch)!="")
    {
        $branch="(".$row->Branch.")";
    }
    else{
        $branch="";
    }
    $address="";
    if(trim($row->Address)!="")
    {
        $address=$row->Address;
    }
    else{
        $address="";
    }
    $city="";
    if(trim($row->City)!="")
    {
        $city=",".$row->City;
    }
    else{
        $city="";
    }
    $state="";
    if(trim($row->State)!="")
    {
        $state=",".$row->State;
    }
    else{
        $state="";
    }
    $zip="";
    if(trim($row->Zip)!="")
    {
        $zip=",".$row->Zip;
    }
    else{
        $zip="";
    }
    // $a.="---|".$row->Branch."|".$row->Address."|".$row->City."|".$row->State."|".$row->Zip."|--";
    $courtli.="<li><a href data-courtid='".$row->CourtID."' class='courtlst'>".$row->Court.$branch."-".$address.$city.$state.$zip."</a></li>";
    // $courtli.="<li><a href class='courtlst'>".$row->Court."(".$row->Branch.")".$row->City.$row->State.$row->Zip."</a></li>";
    // echo $row->Court."<br>";
    // $i++;
    // if($i==5)
    // break;
}
echo json_encode($courtli);

}
catch(SoapFault $fault){
    die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
}

// // $xslt = new xsltProcessor;
// // $xslt->registerPHPFunctions();
// // $xslt->importStyleSheet(DomDocument::load("header1.xsl"));
// // print $xslt->transformToXML(DomDocument::loadXML($result));
// // echo "<script src='assets/js/filter.js'></script>";
?>
