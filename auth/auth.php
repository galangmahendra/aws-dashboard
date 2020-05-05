<?php
session_start();
if(empty($_SESSION["nickname"])) {
  header("Location: login");
}
if(!empty($_POST["nickname"])) {
  $_SESSION["nickname"] = $_POST["nickname"];
}
header("Location: ../index");
?>