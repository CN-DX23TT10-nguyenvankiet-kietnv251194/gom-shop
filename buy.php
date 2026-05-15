<?php
include "config.php";

/* =========================
   XỬ LÝ ĐẶT HÀNG
========================= */
if(isset($_GET['confirm'])){

    $id = (int)$_GET['confirm'];

    $qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;

    if($qty < 1){
        $qty = 1;
    }

    $conn->query("
        INSERT INTO orders(product_id, quantity, created_at)
        VALUES($id, $qty, NOW())
    ");

    echo "
    <script>
        alert('Đặt hàng thành công!');
        window.location.href='index.php';
    </script>
    ";
    exit;
}

/* =========================
   LẤY ID + QTY
========================= */
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

$qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;

if($qty < 1){
    $qty = 1;
}

/* =========================
   LẤY SẢN PHẨM
========================= */
$sql = "SELECT * FROM products WHERE id = $id";
$res = $conn->query($sql);

if ($res->num_rows == 0) {
    die("Sản phẩm không tồn tại");
}

$product = $res->fetch_assoc();

$total = $product['price'] * $qty;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thanh toán</title>

<style>

body{
    font-family:Arial;
    background:#f5f5f5;
    margin:0;
}

.box{
    width:420px;
    margin:60px auto;
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    text-align:center;
}

h2{
    color:#ee4d2d;
    margin-bottom:15px;
}

.price{
    font-size:26px;
    font-weight:bold;
    color:#ee4d2d;
    margin:15px 0;
}

.qty{
    font-size:16px;
    margin:10px 0;
    color:#333;
}

.btn{
    display:block;
    margin-top:20px;
    background:linear-gradient(135deg,#ee4d2d,#ff7337);
    color:#fff;
    text-align:center;
    padding:12px;
    text-decoration:none;
    border-radius:10px;
    font-weight:600;
    transition:0.2s;
}

.btn:hover{
    transform:translateY(-2px);
}

.back{
    display:block;
    margin-top:10px;
    color:#666;
    text-decoration:none;
    font-size:14px;
}

.note{
    color:#777;
    font-size:13px;
}

</style>

</head>

<body>

<div class="box">

    <h2>Thanh toán nhanh</h2>

    <p>
        <b>Sản phẩm:</b><br>
        <?= htmlspecialchars($product['name']); ?>
    </p>

    <div class="qty">
        Số lượng: <b><?= $qty; ?></b>
    </div>

    <div class="price">
        <?= number_format($total); ?>₫
    </div>

    <p class="note">
        Thanh toán nhanh không qua giỏ hàng
    </p>

    <a class="btn"
       href="?confirm=<?= $product['id']; ?>&qty=<?= $qty; ?>">
        Xác nhận mua
    </a>

    <a class="back" href="index.php">
        ⬅ Quay lại
    </a>

</div>

</body>
</html>
