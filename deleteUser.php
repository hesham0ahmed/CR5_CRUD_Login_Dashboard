<?php
require_once "db_connect.php";

// 
session_start();

if (isset($_SESSION["user"])) {
  header("Location: home.php");
}

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
  header("Location: login.php");
}
// 
$id = $_GET["id"]; // to take the value from the parameter "id" in the url 
$sql = "SELECT * FROM users WHERE id = $id"; // finding the product 
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);  // fetching the data 
if ($row["picture"] != "avatar.png") { // if the picture is not product.png (the detault picture) we will delete the picture
  unlink("pictures/$row[picture]");
}

$delete = "DELETE FROM users WHERE id = $id"; // query to delete a record from the database

if (mysqli_query($connect, $delete)) {
  header("Location: dashboard.php");
} else {
  echo "Error";
}

mysqli_close($connect);
