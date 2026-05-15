<?php

// START SESSION
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// KẾT NỐI DATABASE
$conn = new mysqli(
    "localhost",
    "root",
    "",
    "gom_shop"
);

// CHECK LỖI
if($conn->connect_error){

    die("Kết nối database thất bại: " . $conn->connect_error);

}

// UTF8
$conn->set_charset("utf8");

// KHỞI TẠO GIỎ HÀNG
if(!isset($_SESSION['cart'])){

    $_SESSION['cart'] = [];

}

// USER LOGIN
if(!isset($_SESSION['user'])){

    $_SESSION['user'] = null;

}

?>