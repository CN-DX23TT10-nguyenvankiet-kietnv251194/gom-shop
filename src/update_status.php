<?php

include "config.php";

$id=$_GET['id'];
$status=$_GET['status'];

$stmt=$conn->prepare("
UPDATE orders
SET status=?
WHERE id=?
");

$stmt->bind_param("si",$status,$id);
$stmt->execute();

header("Location: orders.php");