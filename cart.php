<?php
include "config.php";

/* session */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =========================
   AJAX: COUNT CART
========================= */
if(isset($_GET['action']) && $_GET['action'] == 'count'){

    if(!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])){
        echo 0;
        exit;
    }

    echo array_sum($_SESSION['cart']);
    exit;
}

/* =========================
   XỬ LÝ REMOVE / CLEAR
========================= */
if(isset($_GET['remove'])){
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
}

if(isset($_GET['clear'])){
    unset($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Giỏ hàng</title>

<style>

/* giữ nguyên UI (mình chỉ giữ gọn lại) */
body{
    font-family:Arial;
    background:#f4f6fb;
    margin:0;
}

.header{
    background:linear-gradient(135deg,#ff5722,#ff784e);
    color:#fff;
    padding:18px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.home-top{
    background:#fff;
    color:#ff5722;
    padding:10px 16px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
}

.cart-container{
    width:95%;
    max-width:1100px;
    margin:30px auto;
}

table{
    width:100%;
    background:#fff;
    border-collapse:collapse;
    border-radius:12px;
    overflow:hidden;
}

table th{
    background:#ff5722;
    color:#fff;
    padding:12px;
}

table td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #eee;
}

table img{
    width:70px;
    height:70px;
    object-fit:cover;
    border-radius:8px;
}

.total{
    margin-top:20px;
    font-size:22px;
    font-weight:bold;
    color:#ff5722;
    text-align:right;
}

.btn{
    padding:10px 14px;
    border-radius:8px;
    text-decoration:none;
    color:#fff;
    font-weight:bold;
    display:inline-block;
}

.btn-delete{background:#333;}
.btn-shop{background:#ff5722;}
.btn-remove{background:#e91e63;}

.cart-actions{
    margin-top:15px;
    display:flex;
    gap:10px;
}

.checkout-box{
    margin-top:25px;
    background:#fff;
    padding:20px;
    border-radius:12px;
    max-width:420px;
}

.checkout-box input{
    width:100%;
    padding:10px;
    margin-bottom:10px;
    border:1px solid #ddd;
    border-radius:6px;
}

.checkout-btn{
    width:100%;
    padding:12px;
    background:#4caf50;
    color:#fff;
    border:none;
    border-radius:8px;
    font-weight:bold;
}

.empty{
    background:#fff;
    padding:40px;
    text-align:center;
    border-radius:12px;
}

</style>
</head>

<body>

<div class="header">
    <div>🛒 Giỏ hàng</div>
    <a class="home-top" href="index.php">🏠 Trang chủ</a>
</div>

<div class="cart-container">

<?php
$total = 0;

if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0):
?>

<table>

<tr>
    <th>Sản phẩm</th>
    <th>Hình</th>
    <th>Số lượng</th>
    <th>Giá</th>
    <th>Thành tiền</th>
    <th>Xóa</th>
</tr>

<?php foreach($_SESSION['cart'] as $id => $qty):

$res = $conn->query("SELECT * FROM products WHERE id=$id");
$p = $res->fetch_assoc();

$money = $p['price'] * $qty;
$total += $money;
?>

<tr>
    <td><?= $p['name'] ?></td>
    <td><img src="uploads/<?= $p['image'] ?>"></td>
    <td><?= $qty ?></td>
    <td><?= number_format($p['price']) ?></td>
    <td><?= number_format($money) ?></td>
    <td>
        <a class="btn btn-remove" href="?remove=<?= $id ?>">X</a>
    </td>
</tr>

<?php endforeach; ?>

</table>

<div class="total">
    Tổng: <?= number_format($total) ?> VNĐ
</div>

<div class="cart-actions">
    <a class="btn btn-delete" href="?clear=1">Xóa tất cả</a>
    <a class="btn btn-shop" href="index.php">Tiếp tục mua</a>
</div>

<div class="checkout-box">

    <h3>Thanh toán</h3>

    <form method="POST" action="checkout.php">

        <input type="text" name="customer" placeholder="Tên khách" required>
        <input type="text" name="phone" placeholder="SĐT" required>
        <input type="text" name="address" placeholder="Địa chỉ" required>

        <button class="checkout-btn">Thanh toán</button>

    </form>

</div>

<?php else: ?>

<div class="empty">
    🛒 Giỏ hàng trống
    <br><br>
    <a class="btn btn-shop" href="index.php">Mua ngay</a>
</div>

<?php endif; ?>

</div>

</body>
</html>