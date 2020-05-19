<?php
// include database
include_once '../config/db.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

function bad_request($message) {
    http_response_code(404);
    echo json_encode(array("message" => $message));
    exit;
}

if(empty($_POST['username']) || empty($_POST['pwd'])) {
    bad_request("Invalid request");
}

$username = $_POST['username'];
$password = $_POST['pwd'];
// check user
$sql = mysqli_query($mysqli, "SELECT id FROM users WHERE email = '$username'");
$check = mysqli_num_rows($sql);
if($check == 0) {
    bad_request("User not found");
}
// check password
$password = md5($password);
$sql = mysqli_query($mysqli, "SELECT id FROM users WHERE email = '$username' AND password = '$password'");
$check = mysqli_num_rows($sql);
if($check == 0) {
    bad_request("Your credentials did not work");
}

$token = md5(uniqid(rand(), true));
$res = array(
    "type" => "bearer",
    "token" => $token
);
mysqli_query($mysqli, "INSERT INTO token(token) VALUES('$token')");
// set response code - 200 OK
http_response_code(200);
echo json_encode($res);
?>