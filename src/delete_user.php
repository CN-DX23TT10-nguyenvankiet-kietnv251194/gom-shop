<?php
session_start();
include "config.php";

if(!isset($_GET['id'])){
    die("Thiếu ID");
}

$id = (int)$_GET['id'];

/* không cho xóa admin đầu tiên */
if($id == 1){
    die("Không thể xóa tài khoản này");
}

mysqli_query($conn,"
DELETE FROM users
WHERE id=$id
");

header("Location: users.php");
exit;
?>