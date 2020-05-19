<?php 
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

$data = [
    array(
        'id' => '0000000250',
        'name' => 'L&Y Building',
        'state' => 'Online',
    ),
    array(
        'id' => '0755080016',
        'name' => 'Tunjungsekar',
        'state' => 'Offline',
    ),
    array(
        'id' => '0755080026',
        'name' => 'Pakis',
        'state' => 'Offline',
    ),
    array(
        'id' => '0755080066',
        'name' => 'Polowijen',
        'state' => 'Offline',
    ),
    array(
        'id' => '0755080250',
        'name' => 'Indragiri',
        'state' => 'Offline',
    )
];

http_response_code(200);
echo json_encode($data);
?>