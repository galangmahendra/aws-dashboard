<?php
date_default_timezone_set('Asia/Jakarta');

// include database
include_once '../config/db.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: $_SERVER[REQUEST_METHOD]");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

function bad_request($message) {
    http_response_code(404);
    $response = array(
        "status" => 0,
        "message" => $message,
        "waktu" => date("Y-m-d H:i:s")
    );
    echo json_encode($response);
    exit;
}

// cek token
$token = null;
$headers = apache_request_headers();
if(!empty($headers['Authorization'])){
    $auth = explode(' ', $headers['Authorization']);
    $token = $auth[1];
    $sql = mysqli_query($mysqli, "SELECT id FROM token WHERE token = '$token'");
    $check = mysqli_num_rows($sql);
    if($check == 0) {
        http_response_code(404);
        echo json_encode(array("message" => "Invalid token"));
        exit;
    }
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Invalid token"));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // GET --------------------------------------
    // get data from table
    $limit = 12;
    $id_stasiun = $_GET['id'];
    $id_stasiun = str_replace('.php','',$id_stasiun);
    $sql = mysqli_query($mysqli, "SELECT * FROM aqm WHERE id_stasiun = '$id_stasiun' ORDER BY waktu DESC LIMIT 0,$limit");
    if(mysqli_num_rows($sql) == 0) {
        bad_request("id_stasiun not found");
    }
    while ($row = mysqli_fetch_array($sql)) {

        $value = explode('|',$row['data']);
        $aqmdata[] = array(
            'id_stasiun' => $row['id_stasiun'],
            'waktu' => $row['waktu'],
            'pm10' => $value[0],
            'pm25' => $value[1],
            'so2' => $value[2],
            'co' => $value[3],
            'o3' => $value[4],
            'no2' => $value[5],
            'hc' => $value[6],
            'ws' => $value[7],
            'wd' => $value[8],
            'humidity' => $value[9],
            'temperature' => $value[10],
            'pressure' => $value[11],
            'sr' => $value[12],
            'rain_intensity' => $value[13],
            'stat_pm10' => $value[14],
            'stat_pm25' => $value[15],
            'stat_so2' => $value[16],
            'stat_co' => $value[17],
            'stat_o3' => $value[18],
            'stat_no2' => $value[19],
            'stat_hc' => $value[20],
        );
    }
    if(!empty($aqmdata)){
        $response = array(
            "status" => 1,
            "message" => "Success",
            "data" => $aqmdata
        );
        // set response code - 200 OK
        http_response_code(200);
        echo json_encode($response);
    } else {
        bad_request("No Data");
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // POST -----------------------------
    $req = $_POST;
    if(empty($_POST)) {
        $req = json_decode(file_get_contents("php://input"), true);
        if(empty($req)) {
            bad_request("Invalid request");
        }
    }
    $id_stasiun     = empty($req['id_stasiun']) ? '0' : $req['id_stasiun'];
    $waktu          = empty($req['waktu']) ? '0' : $req['waktu'];
    $pm10           = $value[] = empty($req['pm10']) ? '0' : $req['pm10'];
    $pm25           = $value[] = empty($req['pm25']) ? '0' : $req['pm25'];
    $so2            = $value[] = empty($req['so2']) ? '0' : $req['so2'];
    $co             = $value[] = empty($req['co']) ? '0' : $req['co'];
    $o3             = $value[] = empty($req['o3']) ? '0' : $req['o3'];
    $no2            = $value[] = empty($req['no2']) ? '0' : $req['no2'];
    $hc             = $value[] = empty($req['hc']) ? '0' : $req['hc'];
    $ws             = $value[] = empty($req['ws']) ? '0' : $req['ws'];
    $wd             = $value[] = empty($req['wd']) ? '0' : $req['wd'];
    $humidity       = $value[] = empty($req['humidity']) ? '0' : $req['humidity'];
    $temperature    = $value[] = empty($req['temperature']) ? '0' : $req['temperature'];
    $pressure       = $value[] = empty($req['pressure']) ? '0' : $req['pressure'];
    $sr             = $value[] = empty($req['sr']) ? '0' : $req['sr'];
    $rain_intensity = $value[] = empty($req['rain_intensity']) ? '0' : $req['rain_intensity'];
    $stat_pm10      = $value[] = empty($req['stat_pm10']) ? '0' : $req['stat_pm10'];
    $stat_pm25      = $value[] = empty($req['stat_pm25']) ? '0' : $req['stat_pm25'];
    $stat_so2       = $value[] = empty($req['stat_so2']) ? '0' : $req['stat_so2'];
    $stat_co        = $value[] = empty($req['stat_co']) ? '0' : $req['stat_co'];
    $stat_o3        = $value[] = empty($req['stat_o3']) ? '0' : $req['stat_o3'];
    $stat_no2       = $value[] = empty($req['stat_no2']) ? '0' : $req['stat_no2'];
    $stat_hc        = $value[] = empty($req['stat_hc']) ? '0' : $req['stat_hc'];

    $data = implode('|', $value);
    if(!mysqli_query($mysqli, "INSERT INTO aqm(id_stasiun,waktu,data) VALUES('$id_stasiun','$waktu','$data')")) {
        bad_request("Failed to save data");
    }
    $response = array(
        "status" => 1,
        "message" => "Success",
        "waktu" => date("Y-m-d H:i:s")
    );
    // set response code - 200 OK
    http_response_code(200);
    echo json_encode($response);
}
?>