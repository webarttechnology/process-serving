<?php
session_start();
// $newmemb=$_POST['newmemb'];
// echo $atrname;
// echo json_encode("aynu");exit;

// echo json_encode($_POST['numdocs']);exit;

$usrid=$_SESSION['ClientIDn'];
$atrid=$_POST['atrid'];
$reqid=$_POST['reqid'];
$courtid=$_POST['courtid'];
$caseno=$_POST['caseno'];
$billcode=$_POST['billcode'];
$plntf=$_POST['plntf'];
$plntfrole=$_POST['plntfrole'];
$diff=$_POST['diff'];
$diffrole=$_POST['diffrole'];

$prtynum=$_POST['prtynum'];
$prtyname=$_POST['srvname'];
$prtycap=$_POST['srvcap'];
$prtyregagent=$_POST['srvregagent'];
$prtyaddr=$_POST['srvaddr'];

$prtyadrid=$_POST['srvadrid'];
$prtybusname=$_POST['srvbusname'];
$tzone=$_POST['tzone'];
$hdate=$_POST['hdate'];
$witnsfee=$_POST['witnsfee'];
$proof=$_POST['proof'];
$samedocs=$_POST['samedocs'];
$docmethod=$_POST['docmethod'];
$splinstr=$_POST['splinstr'];
$atmdate=$_POST['atmdate'];
$atmtime=$_POST['atmtime'];
$atmamt=$_POST['atmamt'];
$idate=$_POST['idate'];
$iname=$_POST['iname'];
$emailarr=$_POST['emailarr'];
// <Notify>
//         <emailnum>".count($emailarr)."<emailnum/>
//     ";
//     for($i=0;i<count($emailarr);i++)
//     {
//         $jxml.="<email>".$emailarr[$i]."</email>";
//     }
// $jxml.="</Notify>
// $docttle=$_POST['docttle'];
// $ttlid=$_POST['ttlid'];
// $fileid=$_POST['docfileid'];
// echo json_encode($emailarr);exit;

$xmlservenodes="";
for($i=0;$i<$prtynum;$i++)
{
    // if($prtynum>1)
    // {
        $xmlservenodes.="<Servee>
                            <Serveename>".$prtyname[$i]."</Serveename>
                            <Serveecap>".$prtycap[$i]."</Serveecap>
                            <Regagent>".$prtyregagent[$i]."</Regagent>
                            <Addr>".$prtyaddr[$i]."</Addr>
                            <AddrID>".$prtyadrid[$i]."</AddrID>
                            <Busname>".$prtybusname[$i]."</Busname>
                            <Tzone>".$tzone[$i]."</Tzone>
                            <Hrdate>".$hdate[$i]."</Hrdate>
                            <Wtnsfee>".$witnsfee[$i]."</Wtnsfee>
                            <Proof>".$proof[$i]."</Proof>
                            <Splinstrcns>".$splinstr[$i]."</Splinstrcns>
                            <Atmdate>".$atmdate[$i]."</Atmdate>
                            <Atmtime>".$atmtime[$i]."</Atmtime>
                            <Atmamt>".$atmamt[$i]."</Atmamt>
                            <Itemname>".$iname[$i]."</Itemname>
                            <Itemdate>".$idate."</Itemdate>
                            <Atmamt>".$atmamt[$i]."</Atmamt>
                            <Docs>";
        if($prtynum==1 || ($prtynum>1 && $samedocs==1))
        {
            $docttle=$_POST['docttle'];
            $ttlid=$_POST['ttlid'];
            $fileid=$_POST['docfileid'];

            for($j=0;$j<count($fileid);$j++)
            {
                if($docmethod=="up")
                {
                    header("Content-Type: application/pdf");
                    $file_name = $_FILES["file_".$fileid[$j]]["name"];
                    $path_parts = pathinfo($_FILES["file_".$fileid[$j]]["name"]);
                    $fm=strtolower($path_parts['extension']);
                    $getcnt=base64_encode(file_get_contents($_FILES["file_".$fileid[$j]]["tmp_name"]));
                    // $getcnt="aaaaaaaaaaaaaaaaaaaaaaaaaaa".$file_name;
                    // echo json_encode(base64_encode($getcnt));exit;
                    // echo json_encode($file_name);exit;
                }
                else{
                    $file_name="";
                    $fm="";
                    $getcnt="";
                }
                $xmlservenodes.="
                                <Doc>
                                    <title>".$docttle[$j]."</title>
                                    <titleid>".$ttlid[$j]."</titleid>
                                    <fileid>".$fileid[$j]."</fileid>
                                    <filename>".$file_name."</filename>
                                    <fileext>".$fm."</fileext>
                                    <filegetcnt>".$getcnt."</filegetcnt>
                                </Doc>
                                    ";
            }
        }
        else if($prtynum>1 && $samedocs!=1)
        {
            $numdocs=$_POST['numdocs'];
            for($j=0;$j<$numdocs[$i];$j++)
            {
                $docttle=$_POST['docttle'.$i];
                $ttlid=$_POST['ttlid'.$i];
                $fileid=$_POST['docfileid'.$i];

                if($docmethod=="up")
                {
                    header("Content-Type: application/pdf");
                    $file_name = $_FILES["file_".$fileid[$j]]["name"];
                    $path_parts = pathinfo($_FILES["file_".$fileid[$j]]["name"]);
                    $fm=strtolower($path_parts['extension']);
                    $getcnt=base64_encode(file_get_contents($_FILES["file_".$fileid[$j]]["tmp_name"]));
                    // $getcnt="aaaaaaaaaaaaaaaaaaaaaaaaaaa".$file_name;
                    // echo json_encode(base64_encode($getcnt));exit;
                    // echo json_encode($file_name);exit;
                }
                else{
                    $file_name="";
                    $fm="";
                    $getcnt="";
                }

                $xmlservenodes.="
                                <Doc>
                                    <title>".$docttle[$j]."</title>
                                    <titleid>".$ttlid[$j]."</titleid>
                                    <fileid>".$fileid[$j]."</fileid>
                                    <filename>".$file_name."</filename>
                                    <fileext>".$fm."</fileext>
                                    <filegetcnt>".$getcnt."</filegetcnt>
                                </Doc>
                                ";
            }
        }
        $xmlservenodes.="</Docs>
                        </Servee>";
    // }
}
$xmlemailnodes="";
for($i=0;$i<count($emailarr);$i++)
{
    $xmlemailnodes.="
                    <email>".$emailarr[$i]."</email>";
}
// echo json_encode($prtyname);exit;

$jxml="<?xml version=\"1.0\" ?>
<auth>
    <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
    <custid>cw</custid>
    <func>CWADDNEWCASE</func>
    <ClientID>".$usrid."</ClientID>
    <AttorneyID>".$atrid."</AttorneyID>
    <RequestorID>".$reqid."</RequestorID>
    <CourtID>".$courtid."</CourtID>
    <CaseNo>".$caseno."</CaseNo>
    <CaseLevelBillingCode>".$billcode."</CaseLevelBillingCode>
    <Plaintiff>".$plntf."</Plaintiff>
    <PlaintiffRole>".$plntfrole."</PlaintiffRole>
    <Defendant>".$diff."</Defendant>
    <DefendantRole>".$diffrole."</DefendantRole>
    <CaseLevelNotes>This is a test case</CaseLevelNotes>
    <Docmethod>".$docmethod."</Docmethod>
    <Servees>
        <Serveenum>".$prtynum."</Serveenum>
        <Samedocchk>".$samedocs."</Samedocchk>
        ".$xmlservenodes."
    </Servees>
    <Notify>
        <emailnum>".count($emailarr)."</emailnum>
        ".$xmlemailnodes."
    </Notify>
    <agencylogin>1</agencylogin>
</auth>";
// echo json_encode($jxml);exit;
// echo $jxml;exit;

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

    echo json_encode($result);

}
catch(SoapFault $fault){
    die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
}

?>
