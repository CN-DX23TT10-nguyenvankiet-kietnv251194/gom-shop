<?php
session_start();

header("Content-Type: application/json");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$response = [
    "success" => false,
    "count" => 0
];

if($id > 0 && isset($_SESSION['cart'][$id])){

    unset($_SESSION['cart'][$id]);

    $response["success"] = true;
    $response["count"] = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
}

/* =========================
   AJAX REQUEST
========================= */
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){

    echo json_encode($response);
    exit;
}

/* =========================
   NORMAL REQUEST
========================= */
header("Location: cart.php");
exit;
?>