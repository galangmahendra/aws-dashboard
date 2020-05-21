<?php
// include database
include_once '../config/db.php';

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

function bad_request($message) {
    http_response_code(404);
    $response = array(
        "status" => 0,
        "message" => $message,
    );
    echo json_encode($response);
    exit;
}

$req = $_POST;
if(empty($_POST['username']) || empty($_POST['password'])) {
    $req = json_decode(file_get_contents("php://input"), true);
    if(empty($req['username']) || empty($req['password'])) {
        bad_request("Invalid request");
    } else {
        
    }
}
$username = $req['username'];
$password = $req['password'];

// check user
$sql = mysqli_query($mysqli, "SELECT id FROM users WHERE email = '$username'");
$check = mysqli_num_rows($sql);
if($check == 0) {
    bad_request("User is not registered");
}
// check password
$password = md5($password);
$sql = mysqli_query($mysqli, "SELECT id FROM users WHERE email = '$username' AND password = '$password'");
$check = mysqli_num_rows($sql);
if($check == 0) {
    bad_request("Authentication Failed. Your credentials did not work");
}

//$token = md5(uniqid(rand(), true));
$token = bin2hex(openssl_random_pseudo_bytes(64));
mysqli_query($mysqli, "INSERT INTO token(token) VALUES('$token')");
$response = array(
    "status" => 1,
    "message" => "Authentication Successful",
    "token" => $token
);
// set response code - 200 OK
http_response_code(200);
echo json_encode($response);
?>