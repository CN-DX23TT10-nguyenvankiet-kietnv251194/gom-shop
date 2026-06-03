<?php
session_start();
include "config.php";

if(!isset($_GET['id'])){
    die("Thiếu ID");
}

$id = (int)$_GET['id'];

$user = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT role FROM users WHERE id=$id")
);

if(!$user){
    die("Không tìm thấy tài khoản");
}

$newRole =
($user['role'] == 'admin')
? 'user'
: 'admin';

mysqli_query($conn,"
UPDATE users
SET role='$newRole'
WHERE id=$id
");

header("Location: users.php");
exit;
?>