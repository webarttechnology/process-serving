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
$xslt->importStyleSheet(DomDocument::load("header1.xsl"));
print $xslt->transformToXML(DomDocument::loadXML($result));

echo "<script>$('document').ready(function(){
		
    $('document').ready(function () {
        //jplist plugin call
        $('#demo').jplist({

            itemsBox: '.demo-tbl'
            ,itemPath: '.tbl-item'
            ,panelPath: '.jplist-panel'

            //save plugin state
            ,storage: 'localstorage' //'', 'cookies', 'localstorage'			
            ,storageName: 'jplist-table-sortable-cols'
        });

        //alternate up / down buttons on header click
        $('.demo-tbl .header').on('click', function () {
            $(this).next('.sort-btns').find('[data-path]:not(.jplist-selected):first').trigger('click');
        });
  });
});</script>";

$xslt = new xsltProcessor;
$xslt->registerPHPFunctions();
$xslt->importStyleSheet(DomDocument::load("recentorders.xsl"));
print $xslt->transformToXML(DomDocument::loadXML($result));
echo "<script src='assets/js/filter.js'></script>";
include('footer.php'); 
?>
