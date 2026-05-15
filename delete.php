<?php
include "config.php";

// kiểm tra id tồn tại
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // (tuỳ chọn) xóa ảnh trong thư mục
    $res = $conn->query("SELECT image FROM products WHERE id=$id");
    if ($row = $res->fetch_assoc()) {
        $file = "uploads/" . $row['image'];
        if (file_exists($file)) unlink($file);
    }

    // xóa sản phẩm
    $conn->query("DELETE FROM products WHERE id=$id");
}

header("Location: admin.php");
exit;