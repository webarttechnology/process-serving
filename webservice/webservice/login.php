<?php
// header("Access-Control-Allow-Origin: http://netzera.com");
$email=$_POST['email'];
$pass=$_POST['pass'];
require_once('dbclass.php');

$sql = new MySQL_class();
$sql->Create('countrywideproce_cwprocess');

$query="SELECT * from registrations where email_id='".$email."'";
$sql->QueryRow($query);
// $data = $sql->data;
for($j=0;$j<$sql->rows;$j++)
{
    $sql->Fetch($j);
    $data[$j] = $sql->data;
}
// echo $data[0]['password'];exit;
// print_r($data);exit;
$login=0;
if(count($data)>0)
{
    for($i=0;$i<$sql->rows;$i++)
    {
        if(password_verify($pass, $data[$i]['password']))
        {
            $login=1;
            break;
        }
        else{
            $login=0;
        }
    }
}
else{
    $login=0;
}
if($login==1)
{
    $op=$data[$i]['fname'].",".$data[$i]['mname'].",".$data[$i]['lname'].",".$data[$i]['businesNameforwithoutatoney'].",".$data[$i]['company'].",".$data[$i]['email_id'].",".$data[$i]['password'].",".$data[$i]['mobile_no'].",".$data[$i]['address_type'].",".$data[$i]['address_atoney'].",".$data[$i]['unit'].",".$data[$i]['city'].",".$data[$i]['state'].",".$data[$i]['zipcode'].",".$data[$i]['business_name'].",".$data[$i]['firm_name'].",".$data[$i]['bar_id'].",".$data[$i]['registration_as'].",".$data[$i]['is_active'].",".$data[$i]['account_type'].",".$data[$i]['account_name'].",".$data[$i]['account_address'].",".$data[$i]['areyou'].",".$data[$i]['billing_name'].",".$data[$i]['billing_email'].",".$data[$i]['billing_phone'].",".$data[$i]['billing_address'];
    echo $op;
}
else{
    echo 0;
}
// print_r(count($data));exit;
// print_r($data);exit;
?>