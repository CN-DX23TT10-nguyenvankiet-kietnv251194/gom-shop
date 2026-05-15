<?php
include "config.php";

$id = (int)$_GET['id'];

/* xóa chi tiết trước */
$conn->query("DELETE FROM order_items WHERE order_id=$id");

/* xóa đơn */
$conn->query("DELETE FROM orders WHERE id=$id");

header("Location: orders.php");
exit;
?>