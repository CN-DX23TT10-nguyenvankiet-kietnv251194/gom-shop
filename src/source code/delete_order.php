<?php
include "config.php";

$id = isset($_GET['id'])
    ? (int)$_GET['id']
    : 0;

if($id <= 0){
    die("ID không hợp lệ");
}

/* xóa chi tiết đơn */
$conn->query("
DELETE FROM order_items
WHERE order_id = $id
");

/* xóa đơn */
$conn->query("
DELETE FROM orders
WHERE id = $id
");

header("Location: ".$_SERVER['HTTP_REFERER']);
exit;
?>