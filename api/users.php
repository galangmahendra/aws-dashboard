<?php
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
    echo json_encode(array("message" => $message));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = mysqli_query($mysqli, "SELECT id,name,email FROM users");
    if(mysqli_num_rows($sql) == 0) {
        http_response_code(200);
        echo json_encode(array("message" => "Data user is empty"));
        exit;
    }
    while ($row = mysqli_fetch_array($sql)) {
        $data[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'username' => $row['email'],
        );
    }
    http_response_code(200);
    echo json_encode($data);

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_POST['reset']) && $_POST['reset'] == '1') {
        mysqli_query($mysqli, "TRUNCATE TABLE users");
        http_response_code(200);
        echo json_encode(array("message" => "Success"));
        exit;
    }
    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
        bad_request("Data is not valid");
    }
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);
    if(!mysqli_query($mysqli, "INSERT INTO users(name,email,password) VALUES('$name','$email','$password')")) {
        bad_request("Failed to save data");
    }
    http_response_code(200);
    echo json_encode(array("message" => "Data saved successfully"));
}
?>