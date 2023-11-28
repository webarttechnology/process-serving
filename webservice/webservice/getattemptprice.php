<?php
//header("Access-Control-Allow-Origin: http://netzera.com");
header("Content-type:application/json");

require_once('dbclass.php');

$sql = new MySQL_class();
$sql->Create('countrywideproce_cwprocess');

$prtynum=$_POST['parties'];
$prtycity=$_POST['pcity'];

// echo json_encode($prtycity);exit;

$atmdata=array();
for($i=0;$i<$prtynum;$i++)
{
    $query="SELECT distinct prices_cities.City,prices_zones_levels.zones,prices_zones_levels.levels,prices_zones_levels.prices,
        prices_zones_levels.filefee
        from prices_zones_levels
        left join prices_cities on prices_cities.PricingZone=prices_zones_levels.zones and prices_cities.City LIKE '%".$prtycity[$i]."%'
        where prices_cities.City LIKE '%".$prtycity[$i]."%'";
    $sql->QueryRow($query);
    for($j=0;$j<4;$j++)
    {
        $sql->Fetch($j);
        $data[$j] = $sql->data;
    }
    // echo json_encode($data);exit;
    $temp=array();
    array_push($temp,$data);
    $atmdata[$i]=$temp;
}
echo json_encode($atmdata);
?>