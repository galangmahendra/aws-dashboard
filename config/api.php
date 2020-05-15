<?php
date_default_timezone_set('Asia/Jakarta');

// include database
include_once 'db.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

function sequence($num,$interval) { // for sequential intervals
    $count = count($interval) - 1;
    $index = rand(0,$count);
    $number = $num + $interval[$index];
    return $number;
}

// get data from table
$sql = mysqli_query($mysqli, "SELECT * FROM aws ORDER BY time DESC");
while ($row = mysqli_fetch_array($sql)) {
    $data[$row['time']] = $row['val'];
}

$dataview_total = 15;
$time = date("Y-m-d H:i", time() - 450);
for( $i = 1; $i <= $dataview_total; $i++ ) {
    $time = date("Y-m-d H:i:s", strtotime($time) + 30);
    if(!empty($data[$time])) {
        $value = explode('|',$data[$time]);
        $values = array(
            'pm2' => $value[0],
            'pm10' => $value[1],
            'so2' => $value[2],
            'no2' => $value[3],
            'co' => $value[4],
            'o3' => $value[5],
            'ispu' => $value[6],
            'rem' => $value[7],
            't' => $value[8],
            'rh' => $value[9],
            'hc' => $value[10],
        );
        $dataview[] = array_merge(array('time'=>$time),$values);
    } else {
        $values = array(
            'pm2' => '7.'.rand(0,30),
            'pm10' => '17.'.rand(0,50),
            'so2' => rand(20,23).'.'.rand(10,99),
            'no2' => rand(9,11).'.'.rand(10,99),
            'co' => rand(248,249).'.'.rand(100,999),
            'o3' => rand(70,72),
            'ispu' => '10',
            'rem' => 'Baik',
            't' => '30.'.rand(1,7),
            'rh' => rand(60,62),
            'hc' => '0',
        );
        $dataview[] = array_merge(array('time'=>$time),$values);
        $values_all = implode('|',$values);
        mysqli_query($mysqli, "INSERT INTO aws(time,val) VALUES ('$time','$values_all')");
    }
}

if(!empty($dataview)){
    $dataview = array_reverse($dataview);
    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($dataview);
} else {
    // set response code - 404 Not found
    http_response_code(404);
    echo json_encode(array("message" => "Data not found."));
}
?>