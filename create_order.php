<?php

include "config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $customer   = trim($_POST['customer'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $product_id = (int)($_POST['product_id'] ?? 0);
    $qty        = (int)($_POST['qty'] ?? 0);

    if($customer != "" && $product_id > 0 && $qty > 0){

        /* =========================
           1. TẠO ĐƠN NHẬP
        ========================== */

        $type = "nhap";

        $stmt = $conn->prepare("
            INSERT INTO orders(customer, phone, type)
            VALUES(?,?,?)
        ");

        $stmt->bind_param("sss", $customer, $phone, $type);
        $stmt->execute();

        $order_id = $conn->insert_id;

        /* =========================
           2. THÊM ITEM
        ========================== */

        $stmt2 = $conn->prepare("
            INSERT INTO order_items(order_id, product_id, qty)
            VALUES(?,?,?)
        ");

        $stmt2->bind_param("iii", $order_id, $product_id, $qty);
        $stmt2->execute();

        /* =========================
           3. CẬP NHẬT TỒN KHO (TỐI ƯU)
        ========================== */

        $conn->query("
            UPDATE products
            SET stock = stock + $qty
            WHERE id = $product_id
        ");

        /* DONE */
        header("Location: orders.php?type=nhap");
        exit;

    }else{
        $message = "Vui lòng nhập đầy đủ thông tin!";
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Tạo đơn nhập</title>

<style>
body{
    font-family:Arial;
    background:#f5f5f5;
}

.box{
    width:420px;
    margin:60px auto;
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
}

h3{
    text-align:center;
    margin-bottom:20px;
}

input,select{
    width:100%;
    padding:12px;
    margin-bottom:14px;
    border:1px solid #ddd;
    border-radius:8px;
}

button{
    width:100%;
    padding:12px;
    background:linear-gradient(45deg,#2d7dff,#4da3ff);
    color:#fff;
    border:none;
    border-radius:8px;
    cursor:pointer;
}

.alert{
    background:#ffe8e8;
    color:red;
    padding:10px;
    margin-bottom:10px;
    border-radius:8px;
}

.back{
    display:block;
    text-align:center;
    margin-top:10px;
    color:#555;
    text-decoration:none;
}
</style>

</head>
<body>

<div class="box">

    <h3>📥 Tạo đơn nhập</h3>

    <?php if($message != ""): ?>
        <div class="alert"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">

        <input name="customer" placeholder="Nhà cung cấp" required>

        <input name="phone" placeholder="Số điện thoại">

        <select name="product_id" required>
            <option value="">-- Chọn sản phẩm --</option>

            <?php
            $res = $conn->query("SELECT id,name FROM products ORDER BY id DESC");
            while($p = $res->fetch_assoc()):
            ?>
                <option value="<?= $p['id'] ?>">
                    <?= htmlspecialchars($p['name']) ?>
                </option>
            <?php endwhile; ?>

        </select>

        <input type="number" name="qty" min="1" value="1" required>

        <button type="submit">➕ Tạo đơn</button>

    </form>

    <a class="back" href="orders.php?type=nhap">← Quay lại</a>

</div>

</body>
</html>