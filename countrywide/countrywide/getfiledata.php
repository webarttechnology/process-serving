<?php

// ==========delete old files==============
$dir = "assets/tmpdocs/";
$files=array();
$mdate=array();
if ($handle = opendir($dir)) {
    // Loop through all the files in the directory
    $i=0;
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            // Insert the file name
            $files[$i][0]=$file;
            $diff=time()-filemtime($dir.$file);
            $files[$i][1]=floor($diff / (60 * 60 * 24));
            if($files[$i][1]>0)
            {
                if (unlink($dir.$file)) {
                    $files[$i][2]=$file." deleted";
                }
            }
            $i++;
        }
    }
    // Close the directory handle
    closedir($handle);
}
// echo json_encode($files);
// exit;
// ==========delete old files==============

$cxml=$_POST['casexml'];
// echo json_encode("mmm");exit;
$cres=simplexml_load_string($cxml);
$att=array();
// $i=0;$j=0;
$jxml="<?xml version=\"1.0\" ?>
        <auth>
            <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
            <custid>cw</custid>
            <func>GETFILEDATA</func>
            <caseid>".$cres->Case->CaseID."</caseid>
            ";
            // echo json_encode($jxml);exit;
foreach($cres->Case->Defendants->Defendant as $def)
{
    $jxml.="<files>
                <jobins>".$def->Jobs->Job->JobNum."</jobins>
                ";
    foreach($def->Jobs->Job->Attachments->Attachment as $attch)
    {
        // $att[$i][$j]=$attch->AttachmentID;
        $jxml.="<file>
                    <fileid>".$attch->AttachmentID."</fileid>
                </file>
            ";
        // $j++;
    }
    $jxml.="</files>
    ";
    // $i++;
}
    $jxml.="<agencylogin>1</agencylogin>
        </auth>";
// echo json_encode($jxml);exit;

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
    // $doctype="";
    // $doctype.="<option value=''>--select--</option>";
    $i=0;$j=0;
    $flink=array();
    foreach($res->Doc as $rows)
    {
        $k=0;
        foreach($rows->file as $file)
        {
            $dr=file_put_contents('assets/tmpdocs/file_'.$i.'_'.$cres->Case->CaseID.'.pdf', base64_decode($file->filedata));
            $flink[$j][$k]="<div><a class='flink' href='assets/tmpdocs/file_".$i."_".$cres->Case->CaseID.".pdf' target='_blank' data-fileid='".$file->dockey."' style='padding:10px;background-color:#cccccc;color:black;margin-right:10px;'>File-".($k+1)."</a><i id='' class='fa fa-close red d-inline-block ms-2 delfile' style='cursor:pointer;'></i></div>";
            $k++;$i++;
        }
        $j++;
    }
    // echo json_encode($result);exit;
    echo json_encode($flink);

}
catch(SoapFault $fault){
    die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
}
?>