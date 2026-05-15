<?php
session_start();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;

if($qty < 1){
    $qty = 1;
}

/* tạo cart */
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

/* thêm sản phẩm */
if(isset($_SESSION['cart'][$id])){

    $_SESSION['cart'][$id] += $qty;

}else{

    $_SESSION['cart'][$id] = $qty;
}

/* trả về tổng số lượng */
echo array_sum($_SESSION['cart']);
?>