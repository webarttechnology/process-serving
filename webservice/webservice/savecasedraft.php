<?php
//header("Access-Control-Allow-Origin: http://netzera.com");
// header("Content-type:application/json");
header("Content-Type: application/pdf");
// $getcnt=base64_encode(file_get_contents($_FILES["file_76nh"]["tmp_name"]));
// $getcnt="mm";
// echo $getcnt;exit;
require_once('dbclass.php');

$sql = new MySQL_class();
$sql->Create('countrywideproce_cwprocess');

$sectn=$_POST['sectn'];
$userid=$_POST['userid'];
// echo json_encode($sectn);

$query = "SELECT * from draft_caseinfo where ldmaxclient_id='".$userid."'";// check for saved draft of logined user
$sql->QueryRow($query);
$data = $sql->data;

if($sectn=="caseinfo")// insert case info
{
    $caseno=$_POST['caseno'];
    $courtid=$_POST['courtid'];
    $court=$_POST['court'];
    $atrny=$_POST['atrny'];
    $atrnyid=$_POST['atrnyid'];
    // echo json_encode($courtid);exit;

    if($caseno=="Not Applicable")
    {
        $caseno=0;
    }

    $proof=explode("/",$atrnyid);
    $who=$proof[1];
    $atrid=$proof[0];
    if($who=="same")
    {
        $who="client";
    }

    if($sql->rows>0)
    {
        $dataid=$data['id'];// foreinkey

        $delquery ="DELETE From draft_caseinfo where ldmaxclient_id='".$userid."' ";// case and order info section
        $sql->Delete($delquery);
        $delquery ="DELETE From draft_casepart where draft_caseinfo_id='".$dataid."' ";// case participants section
        $sql->Delete($delquery);
        $delquery ="DELETE From draft_documents where draft_caseinfo_id='".$dataid."' ";// documents section
        $sql->Delete($delquery);
        $delquery ="DELETE From draft_srvaddress where draft_caseinfo_id='".$dataid."' ";// serve info section
        $sql->Delete($delquery);
    }

    $iquery = "INSERT into draft_caseinfo set caseno='".$caseno."', ldmaxclient_id='".$userid."',court='".$court."', court_id='".$courtid."', reqatrname='".$atrny."', proofwho='".$who."', proof_id='".$atrid."'";
    $sql->InsertA($iquery);
    $id = $sql->lastid;
    echo json_encode($id);
}
else if($sectn=="orderinfo")
{
    $srvnum=$_POST['parties'];
    $cmnsrvchk=$_POST['cmnsrvchk'];

    $iquery = "UPDATE draft_caseinfo set srvnum='".$srvnum."', samedocs='".$cmnsrvchk[0]."',sameaddr='".$cmnsrvchk[1]."', allwtnsfee='".$cmnsrvchk[2]."' where id='".$data['id']."'";
    $sql->Update($iquery);
    $srvdata=$sql->a_rows;
    // echo json_encode($srvdata);

    $delquery ="DELETE From draft_srvaddress where draft_caseinfo_id='".$data['id']."' ";// delete old serve info draft
    $sql->Delete($delquery);

    $srv=$_POST['srv'];
    $cap=$_POST['cap'];
    $regagent=$_POST['regagent'];

    $address=$_POST['address'];
    $adrid=$_POST['adrid'];
    $busname=$_POST['busname'];
    $tzone=$_POST['tzone'];
    $hdate=$_POST['hdate'];
    $witnsfee=$_POST['witnsfee'];
    $fileproof=$_POST['fileproof'];
    $notarize=$_POST['notarize'];
    $spinstr=$_POST['spinstr'];

    $id = array();
    for($i=0;$i<$srvnum;$i++)
    {
        $iquery = "INSERT into draft_srvaddress set draft_caseinfo_id='".$data['id']."', srvname='".$srv[$i]."',srvcap='".$cap[$i]."', srvregagent='".$regagent[$i]."', address='".$address[$i]."', addr_id='".$adrid[$i]."', busname='".$busname[$i]."', timezone='".$tzone[$i]."', heardate='".$hdate[$i]."', witnsfee='".$witnsfee[$i]."', fileproof='".$fileproof[$i]."', notarize='".$notarize[$i]."', spinstrctn='".$spinstr[$i]."'";
        $sql->InsertA($iquery);
        $id[$i] = $sql->lastid;
    }
    echo json_encode($id);
}
else if($sectn=="delcasepart")
{
    $delquery ="DELETE From draft_casepart where draft_caseinfo_id='".$data['id']."' ";// delete old case part draft
    $sql->Delete($delquery);
}
else if($sectn=="casepart")
{
    $prtywho=$_POST['prtywho'];
    $prtyrole=$_POST['prtyrole'];
    $prtyname=$_POST['prtyname'];
    $prtysfx="";
    $prtyfname="";
    $prtymname="";
    $prtyfname="";
    $prtycode=$_POST['prtycode'];
    if($prtywho=="per")
    {
        $prtysfx=$prtyname[0];
        $prtyfname=$prtyname[1];
        $prtymname=$prtyname[2];
        $prtylname=$prtyname[3];
    }
    else{
        $prtyfname=$prtyname;
    }
    // echo json_encode("code-".$prtycode);exit;
    if($prtycode!=0)
    {
        $lead=1;
    }
    else{
        $lead=0;
    }

    $iquery = "INSERT into draft_casepart set draft_caseinfo_id='".$data['id']."', prtywho='".$prtywho."',prtyrole='".$prtyrole."', prtysfx='".$prtysfx."', prtyfname='".$prtyfname."', prtymname='".$prtymname."', prtylname='".$prtylname."', leadclient='".$lead."', billcode='".$prtycode."'";
    $sql->InsertA($iquery);
    $id = $sql->lastid;
    echo json_encode($id);
}
else if($sectn=="casedocs")
{
    $draftcaseid=$data['id'];
    $dbdocid=array();

    $query="SELECT * from draft_documents where draft_caseinfo_id='".$data['id']."'";
    $sql->QueryRow($query);
    for($i=0;$i<$sql->rows;$i++)
    {
        $sql->Fetch($i);
        $docs[$i] = $sql->data;
        $dbdocid[$i]=$docs[$i]["id"];
    }

    // $delquery ="DELETE From draft_documents where draft_caseinfo_id='".$data['id']."' ";// delete old case part draft
    // $sql->Delete($delquery);

    $query="SELECT * from draft_srvaddress where draft_caseinfo_id='".$data['id']."' order by id";
    $sql->QueryRow($query);
    for($i=0;$i<$sql->rows;$i++)
    {
        $sql->Fetch($i);
        $part[$i] = $sql->data;
    }
    // echo json_encode($part);exit;

    // echo json_encode($_POST['userid']."_".$_POST['sectn']."_".$_POST['method']."_".$_POST['partynum']."_".$_POST['docttle']."_".$_POST['ttlid']);
    $partynum=$_POST['partynum'];
    $samedoc=$_POST['samedoc'];
    $method=$_POST['method'];
    $numdocs=$_POST['numdocs'];

    // echo json_encode($numdocs);exit;

    if($partynum==1 || ($partynum>1 && $samedoc==1))
    {
        $newname=array();
        $arr=array();// for deleting drafted files if removed on updating draft.
        // $num=$numdocs;
        for($i=0;$i<$partynum;$i++)
        {
            for($j=0;$j<$numdocs;$j++)
            {
                $docttle=$_POST['docttle_0_'.$j];
                $docttleid=$_POST['ttlid0_'.$j];
                if($method==1)
                {
                    if($i<1)
                    {
                        $fileid=$_POST['fileid'];
                        $fileid=explode(",",$fileid);
                        // echo json_encode($fileid[0]);exit;
                        if(!in_array($fileid[$j],$dbdocid))
                        {
                            // echo json_encode("not match");exit;
                            $file=$_FILES["file_".$fileid[$j]]["name"];
                            $target_dir = "documents/";
                            $target_file = $target_dir . basename($_FILES["file_".$fileid[$j]]["name"]);
                            // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                            $time=microtime(true);
                            $time=explode(".",$time);
                            $temp = explode(".", $_FILES["file_".$fileid[$j]]["name"]);
                            $newfilename = $time[0].$time[1] . '.' . end($temp);
                            $newname[$j]=$newfilename;
                            move_uploaded_file($_FILES["file_".$fileid[$j]]["tmp_name"], $target_dir.$newfilename);

                            $iquery = "INSERT into draft_documents set draft_caseinfo_id='".$draftcaseid."', draft_srv_id='".$part[$i]['id']."',method='".$method."', doctitle_id='".$docttleid."', doctitle='".$docttle."', filename='".$newname[$j]."'";
                            $sql->InsertA($iquery);
                        }
                        else{
                            $arr[$j]=$fileid[$j];
                        }
                    }
                }
            }
            $delarr=implode("','",$arr);
            $delquery ="DELETE From draft_documents where id not in ('".$delarr."') and draft_caseinfo_id='".$draftcaseid."'";// delete old case part draft
            $sql->Delete($delquery);
            for($i=0;$i<count($docs);$i++)
            {
                if(!in_array($dbdocid[$i],$arr))
                {
                    if(file_exists("documents/".$docs[$i]['filename']))
                    {
                        unlink("documents/".$docs[$i]['filename']);
                    }
                }
            }
            echo json_encode($delarr);
        }
    }
    else if($partynum>1 && $samedoc==0)
    {
        $arr=array();// for deleting drafted files if removed on updating draft.
        for($i=0;$i<$partynum;$i++)
        {
            for($j=0;$j<$numdocs[$i];$j++)
            {
                // echo json_encode("ooho");exit;
                $docttle=$_POST['docttle_'.($i+1).'_'.($j+1)];
                $docttleid=$_POST['ttlid'.($i+1).'_'.($j+1)];
                if($method==1)
                {
                    $fileid=$_POST['fileid'];
                    $fileid=explode(",",$fileid);
                    if(!in_array($fileid[$j],$dbdocid))
                    {
                        // echo json_encode($fileid[0]);exit;
                        $file=$_FILES["file_".$fileid[$j]]["name"];
                        $target_dir = "documents/";
                        $target_file = $target_dir . basename($_FILES["file_".$fileid[$j]]["name"]);
                        // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                        $time=microtime(true);
                        $time=explode(".",$time);
                        $temp = explode(".", $_FILES["file_".$fileid[$j]]["name"]);
                        $newfilename = $time[0].$time[1] . '.' . end($temp);
                        move_uploaded_file($_FILES["file_".$fileid[$j]]["tmp_name"], $target_dir.$newfilename);

                        $iquery = "INSERT into draft_documents set draft_caseinfo_id='".$draftcaseid."', draft_srv_id='".$part[$i]['id']."',method='".$method."', doctitle_id='".$docttleid."', doctitle='".$docttle."', filename='".$newfilename."'";
                        $sql->InsertA($iquery);
                    }
                    else{
                        $arr[$j]=$fileid[$j];
                    }
                }
            }
            $delarr=implode("','",$arr);
            $delquery ="DELETE From draft_documents where id not in ('".$delarr."') and draft_caseinfo_id='".$draftcaseid."'";// delete old case part draft
            $sql->Delete($delquery);
            for($i=0;$i<count($docs);$i++)
            {
                if(!in_array($dbdocid[$i],$arr))
                {
                    if(file_exists("documents/".$docs[$i]['filename']))
                    {
                        unlink("documents/".$docs[$i]['filename']);
                    }
                }
            }
        }
    }
    // echo json_encode($docttle);
}
else if($sectn=="atm")
{
    $prtynum=$_POST['prtynum'];
    $attmdate=$_POST['attmdate'];
    $attmtime=$_POST['attmtime'];
    $attmamt=$_POST['attmamt'];
    $attminame=$_POST['attminame'];

    $query="SELECT * from draft_srvaddress where draft_caseinfo_id='".$data['id']."' order by id asc";
    $sql->QueryRow($query);
    for($i=0;$i<$sql->rows;$i++)
    {
        $sql->Fetch($i);
        $srv[$i] = $sql->data;
    }

    $delquery ="DELETE From draft_attempt where draft_caseinfo_id='".$data['id']."' ";// delete old case part draft
    $sql->Delete($delquery);

    if($prtynum==1 || ($prtynum>1 && $data['sameaddr']==1))
    {
        for($i=0;$i<$prtynum;$i++)
        {
            $iquery = "INSERT into draft_attempt set draft_caseinfo_id='".$data['id']."', draft_srv_id='".$srv[$i]['id']."',atm_date='".$attmdate[$i]."', atm_time='".$attmtime[$i]."', atm_fee='".$attmamt[$i]."', atm_iname='".$attminame[$i]."'";
            $sql->InsertA($iquery);
        }
    }
    else{
        if($prtynum>1 && $data['sameaddr']==0)
        {
            for($i=0;$i<$prtynum;$i++)
            {
                $iquery = "INSERT into draft_attempt set draft_caseinfo_id='".$data['id']."', draft_srv_id='".$srv[$i]['id']."',atm_date='".$attmdate[$i]."', atm_time='".$attmtime[$i]."', atm_fee='".$attmamt[$i]."', atm_iname='".$attminame[$i]."'";
                $sql->InsertA($iquery);
            }
        }
    }
}
?>