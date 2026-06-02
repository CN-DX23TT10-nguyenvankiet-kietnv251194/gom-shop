<?php
include "config.php";

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header("Location: orders.php");
    exit;
}

$customer = trim($_POST['customer']);
$phone = trim($_POST['phone']);
$type = $_POST['type'];

$product_id = (int)$_POST['product_id'];
$qty = (int)$_POST['qty'];

if($customer == ""){
    die("Vui lòng nhập tên khách hàng");
}

/* tạo đơn */
$status = "Chờ xử lý";

$stmt = $conn->prepare("
INSERT INTO orders(customer,phone,status,type)
VALUES(?,?,?,?)
");

$stmt->bind_param(
    "ssss",
    $customer,
    $phone,
    $status,
    $type
);

$stmt->execute();

$order_id = $conn->insert_id;

/* thêm chi tiết đơn */
$stmt2 = $conn->prepare("
INSERT INTO order_items(order_id,product_id,qty)
VALUES(?,?,?)
");

$stmt2->bind_param(
    "iii",
    $order_id,
    $product_id,
    $qty
);

$stmt2->execute();

/* cập nhật kho */
if($type == 'ban'){

    $conn->query("
    UPDATE products
    SET stock = stock - $qty
    WHERE id = $product_id
    ");

}else{

    $conn->query("
    UPDATE products
    SET stock = stock + $qty
    WHERE id = $product_id
    ");

}

header("Location: orders.php?type=".$type);
exit;
?>