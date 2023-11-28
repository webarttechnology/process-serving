<?php 
session_start();
ob_start();

if(isset($_SESSION['Emailn']))//if logined
{
    // echo $_SESSION['Email'].$_SESSION['Password'];exit;
    $email=$_SESSION['Emailn'];
    $pass=$_SESSION['Passwordn'];
    $rembrme=0;
}
else if(isset($_POST['email']))//if logging in
{
    // echo "nice";exit;
    $email=$_POST['email'];
    $pass=$_POST['pass'];
    if(!empty($_POST['remember']))
    $rembrme="yes";
    else
    $rembrme="no";
}
else{
    // echo "aaa";exit;
    header("location:index.php");
}

//first thing we gonna do is get the XML data that we are going to use to fill this page. All we need is the ClientID that we got when they logged in.
$jxml="<?xml version=\"1.0\" ?>
<auth>
    <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
    <custid>cw</custid>
    <func>SEARCHCLIENTS</func>
    <filters>
        <filter>
            <param>clients.mainlogin</param>
            <qualifier>=</qualifier>
            <value>".$email."</value>
        </filter>
        <filter>
            <param>clients.mainpass</param>
            <qualifier>=</qualifier>
            <value>".$pass."</value>
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

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://countrywideprocess.com/webservice/login.php");// search for client in other cw db
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "email=".$email."&pass=".$pass);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
curl_close($ch);
//echo $server_output;exit;

try {
    $client = new SoapClient("https://".$ldserver."/doldmaxservices.wsdl",$options);
    $client->__setLocation("https://".$ldserver."/doldmaxservices.php");

    $result = $client->doFunction($jxml);
    $clientarr=simplexml_load_string($result);
    $clientarr=json_decode(json_encode($clientarr),true);
    // echo $result;
    // echo $clientarr['Client']['ClientID'];
    // exit;
    
    //print_r($clientarr);

    if($clientarr['Client']['ClientID'] >0 && $clientarr['Client']['ClientID']!="")
    {
        
        $_SESSION['ClientIDn']=$clientarr['Client']['ClientID'];
        $_SESSION['Clientn']=$clientarr['Client']['Client'];
        $_SESSION['Emailn']=$clientarr['Client']['Email'];
        $_SESSION['Passwordn']=$clientarr['Client']['Password'];

        if($rembrme=="yes")
        {
            $hour=time()+3600*24*30;
            setcookie('email',$email,$hour);
            setcookie('Pass',$pass,$hour);
            setcookie('rem',$pass,$hour);
        }
        else if($rembrme=="no")
        {
            $hour=time()-3600*24*30;
            setcookie('email',$email,$hour);
            setcookie('Pass',$pass,$hour);
            setcookie('rem',$pass,$hour);
        }
        
        
        
    }
    else if($server_output!="0")
    {
        // echo "ok";exit;
        $arr=array();
        $arr=explode(",",$server_output);
        $options=[
            'cost' => 11
            ];
            
        $hash=password_hash($arr[6], PASSWORD_BCRYPT, $options);
        $jxml="<?xml version=\"1.0\" ?>
                    <auth>
                        <ldapikey>ASKLHKDN21341KDJ332323Z32</ldapikey>
                        <custid>cw</custid>
                        <func>ADDNEWCLIENT</func>
                        <newclientlogin>".$arr[5]."</newclientlogin>
                        <newclientpassword>".$pass."</newclientpassword>
                        <newclientname>".$arr[0]." ".$arr[1]." ".$arr[2]."</newclientname>
                        <newclientaddress>".$arr[9]."</newclientaddress>
                        <newclientaddress1>".$arr[10]."</newclientaddress1>
                        <newclientcity>".$arr[11]."</newclientcity>
                        <newclientstate>".$arr[12]."</newclientstate>
                        <newclientzip>".$arr[13]."</newclientzip>
                        <newclientphone>".$arr[7]."</newclientphone>
                        <newclientfax></newclientfax>
                        <newclientemail>".$arr[5]."</newclientemail>
                        <agencylogin>1</agencylogin>
                    </auth>";
        try {
            $client = new SoapClient("https://".$ldserver."/doldmaxservices.wsdl",$options);
            $client->__setLocation("https://".$ldserver."/doldmaxservices.php");
        
            $result1 = $client->doFunction($jxml);
            $resxml=simplexml_load_string($result1);
            // echo $resxml->ClientID;exit;

            $_SESSION['ClientIDn']=$resxml->ClientID;
            $_SESSION['Clientn']=$arr[0]." ".$arr[1]." ".$arr[2];
            $_SESSION['Emailn']=$email;
            $_SESSION['Passwordn']=$pass;

            if($rembrme=="yes")
            {
                $hour=time()+3600*24*30;
                setcookie('email',$email,$hour);
                setcookie('Pass',$pass,$hour);
                setcookie('rem',$pass,$hour);
            }
            else if($rembrme=="no")
            {
                $hour=time()-3600*24*30;
                setcookie('email',$email,$hour);
                setcookie('Pass',$pass,$hour);
                setcookie('rem',$pass,$hour);
            }
            
            
            
        }
        catch(SoapFault $fault){
            die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
        }
    }
    else{
        // echo "invalid";exit;
        $_SESSION['invalidlogin']="Invalid Login";
        header("location:index.php");
    }
}
catch(SoapFault $fault){
    die("SOAP Fault:<br />fault code: {$fault->faultcode}, fault string: {$fault->faultstring}");
}

// now we have the result file, lets perform the transformation.

// $xslt = new xsltProcessor;
// $xslt->registerPHPFunctions();
// $xslt->importStyleSheet(DomDocument::load("header.xsl"));
// // clear any text in the output buffer
// ob_clean(); print $xslt->transformToXML(DomDocument::loadXML($result));
ob_clean();
?>