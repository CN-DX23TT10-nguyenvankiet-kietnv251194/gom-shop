<?php
session_start();

$id = $_GET['id'];

// nếu chưa có giỏ hàng
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// nếu đã tồn tại thì +1
if(isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id]++;
} else {
    $_SESSION['cart'][$id] = 1;
}

echo json_encode([
    "count" => array_sum($_SESSION['cart'])
]);