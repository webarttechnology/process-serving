<?php
//header("Access-Control-Allow-Origin: http://netzera.com");
header("Content-type:application/json");
header("Content-Type: application/pdf");

require_once('dbclass.php');

$sql = new MySQL_class();
$sql->Create('countrywideproce_cwprocess');

$sectn=$_POST['sectn'];

$query="SELECT * from draft_caseinfo where ldmaxclient_id='".$_POST['userid']."'";
$sql->QueryRow($query);
$data = $sql->data;

if($sectn=="ci")
{
    $userid=$_POST['userid'];

    $query="SELECT draft_caseinfo.*,draft_srvaddress.draft_caseinfo_id as ifsrvinfo,draft_srvaddress.srvname,draft_srvaddress.srvcap,
    draft_srvaddress.srvregagent,draft_srvaddress.address,draft_srvaddress.addr_id,draft_srvaddress.busname,draft_srvaddress.timezone,
    draft_srvaddress.heardate,draft_srvaddress.witnsfee,draft_srvaddress.fileproof,draft_srvaddress.notarize,draft_srvaddress.spinstrctn
    from draft_caseinfo
    left join draft_srvaddress on draft_srvaddress.draft_caseinfo_id=draft_caseinfo.id and draft_caseinfo.srvnum=1
    where ldmaxclient_id='".$userid."'";// select address result if number of serve is 1
    $sql->QueryRow($query);
    $data = $sql->data;
    if($sql->rows>0)
    {
        echo json_encode($data);
    }
    else
    {
        echo json_encode(0);
    }
}
else if($sectn=="oi")
{
    $userid=$_POST['userid'];

    $query="SELECT draft_caseinfo.*,draft_srvaddress.id as srvid,draft_srvaddress.draft_caseinfo_id as ifsrvinfo,draft_srvaddress.srvname,draft_srvaddress.srvcap,
    draft_srvaddress.srvregagent,draft_srvaddress.address,draft_srvaddress.addr_id,draft_srvaddress.busname,draft_srvaddress.timezone,
    draft_srvaddress.heardate,draft_srvaddress.witnsfee,draft_srvaddress.fileproof,draft_srvaddress.notarize,draft_srvaddress.spinstrctn
    from draft_caseinfo
    left join draft_srvaddress on draft_srvaddress.draft_caseinfo_id=draft_caseinfo.id
    where ldmaxclient_id='".$userid."'";
    $sql->QueryRow($query);
    $data = $sql->data;
    for($i=0;$i<$sql->rows;$i++)
    {
        $sql->Fetch($i);
        $a[$i] = $sql->data;
    }
    echo json_encode($a);
}
else if($sectn=="cp")
{
    $userid=$_POST['userid'];

    $query="SELECT * from draft_casepart where draft_caseinfo_id='".$data['id']."'";// case participants
    $sql->QueryRow($query);
    $cpdata = $sql->data;
    for($i=0;$i<$sql->rows;$i++)
    {
        $sql->Fetch($i);
        $a[$i] = $sql->data;
    }
    // echo json_encode($a);

    $query="SELECT id as docid, draft_caseinfo_id, draft_srv_id, method, doctitle_id, doctitle, `filename` from draft_documents where draft_caseinfo_id='".$data['id']."'";// documents
    $sql->QueryRow($query);
    $docdata = $sql->data;
    if($data["srvnum"]==1 || ($data["srvnum"]>1 && $data["samedocs"]==1))
    {
        if($data["srvnum"]>1)
        {
            $resnum=$sql->rows;
            $docnum=$resnum/$data["srvnum"];
        }
        else{
            $docnum=$sql->rows;
        }
    }
    else if($data["srvnum"]>1 && $data["samedocs"]==0)
    {
        $docnum=$sql->rows;
    }
    // echo json_encode($docnum);exit;
    $filedata=array();
    for($i=0;$i<$docnum;$i++)
    {
        $sql->Fetch($i);
        $b[$i] = $sql->data;
        if(file_exists("documents/".$b[$i]['filename']))
        {
            $getcnt=base64_encode(file_get_contents("documents/".$b[$i]['filename']));
            $filedata[$i]['filedata']=$getcnt;
        }
        else{
            $filedata[$i]['filedata']="";
        }
    }
    $c=array(
        $a,$b,$filedata
    );// both doc and cp in single array
    echo json_encode($c);
}
else if($sectn=="atm")
{
    // echo json_encode($data['id']);exit;
    $query="SELECT * from draft_attempt where draft_caseinfo_id='".$data['id']."'";// attempt time
    $sql->QueryRow($query);
    for($i=0;$i<$sql->rows;$i++)
    {
        $sql->Fetch($i);
        $atm[$i] = $sql->data;
    }
    echo json_encode($atm);
}
?>