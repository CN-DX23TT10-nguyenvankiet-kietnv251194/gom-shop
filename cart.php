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

/* ===== BODY ===== */
body{
    font-family:Arial;
    background:#f4f6fb;
    margin:0;
}

/* ===== HEADER ===== */
.header{
    background:linear-gradient(135deg,#ff5722,#ff784e);
    color:#fff;
    padding:18px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

.home-top{
    background:#fff;
    color:#ff5722;
    padding:10px 16px;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
}

.home-top:hover{
    transform:translateY(-2px);
}

/* ===== CONTAINER ===== */
.cart-container{
    width:95%;
    max-width:1300px;
    margin:30px auto;
}

/* ===== LAYOUT ===== */
.cart-layout{
    display:flex;
    gap:25px;
    align-items:flex-start;
}

.cart-left{
    flex:2;
}

.cart-right{
    width:380px;
    position:sticky;
    top:20px;
}

/* ===== TABLE ===== */
table{
    width:100%;
    background:#fff;
    border-collapse:collapse;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,0.06);
}

table th{
    background:linear-gradient(135deg,#ff5722,#ff784e);
    color:#fff;
    padding:14px;
}

table td{
    padding:14px;
    text-align:center;
    border-bottom:1px solid #eee;
}

table tr:hover{
    background:#fff5f1;
}

table img{
    width:80px;
    height:80px;
    object-fit:cover;
    border-radius:12px;
    transition:0.3s;
}

table img:hover{
    transform:scale(1.08);
}

/* ===== BUTTON ===== */
.btn{
    padding:10px 14px;
    border-radius:10px;
    text-decoration:none;
    color:#fff;
    font-weight:bold;
    display:inline-block;
    transition:0.3s;
}

.btn:hover{
    transform:translateY(-2px);
}

.btn-delete{
    background:#333;
}

.btn-shop{
    background:#ff5722;
}

.btn-remove{
    background:#e91e63;
}

/* ===== CHECKOUT ===== */
.checkout-box{
    background:#fff;
    padding:25px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.06);
}

.checkout-title{
    font-size:28px;
    font-weight:bold;
    margin-bottom:20px;
    color:#ff5722;
}

.checkout-total{
    background:#fff5f1;
    padding:16px;
    border-radius:14px;
    margin-bottom:20px;
    font-size:22px;
    font-weight:bold;
}

.checkout-total span{
    color:#ff5722;
    float:right;
}

/* ===== INPUT ===== */
.input-group{
    display:flex;
    align-items:center;
    background:#f7f7f7;
    border-radius:14px;
    padding:0 14px;
    margin-bottom:15px;
    transition:0.3s;
}

.input-group:hover{
    background:#fff;
    box-shadow:0 5px 15px rgba(255,87,34,0.15);
}

.input-group span{
    font-size:20px;
    margin-right:10px;
}

.input-group input{
    width:100%;
    padding:15px 0;
    border:none;
    background:none;
    outline:none;
    font-size:15px;
}

/* ===== CHECKOUT BUTTON ===== */
.checkout-btn{
    width:100%;
    padding:15px;
    border:none;
    border-radius:16px;
    background:linear-gradient(135deg,#ff5722,#ff784e);
    color:#fff;
    font-size:18px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.checkout-btn:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 20px rgba(255,87,34,0.3);
}

/* ===== ACTION ===== */
.cart-actions{
    margin-top:18px;
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

/* ===== EMPTY ===== */
.empty{
    background:#fff;
    padding:50px;
    text-align:center;
    border-radius:20px;
    font-size:24px;
    box-shadow:0 10px 30px rgba(0,0,0,0.05);
}

/* ===== MOBILE ===== */
@media(max-width:900px){

    .cart-layout{
        flex-direction:column;
    }

    .cart-right{
        width:100%;
        position:static;
    }
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

<div class="cart-layout">

    <!-- LEFT -->
    <div class="cart-left">

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

            <td>
                <img src="uploads/<?= $p['image'] ?>">
            </td>

            <td><?= $qty ?></td>

            <td><?= number_format($p['price']) ?>đ</td>

            <td><?= number_format($money) ?>đ</td>

            <td>
                <a class="btn btn-remove" href="?remove=<?= $id ?>">X</a>
            </td>
        </tr>

        <?php endforeach; ?>

        </table>

    </div>

    <!-- RIGHT -->
    <div class="cart-right">

        <div class="checkout-box">

            <div class="checkout-title">
                💳 Thanh toán
            </div>

            <div class="checkout-total">
                Tổng:
                <span><?= number_format($total) ?>đ</span>
            </div>

            <form method="POST" action="checkout.php">

                <div class="input-group">
                    <span>👤</span>
                    <input type="text" name="customer" placeholder="Tên khách hàng" required>
                </div>

                <div class="input-group">
                    <span>📞</span>
                    <input type="text" name="phone" placeholder="Số điện thoại" required>
                </div>

                <div class="input-group">
                    <span>📍</span>
                    <input type="text" name="address" placeholder="Địa chỉ nhận hàng" required>
                </div>

                <button class="checkout-btn">
                    🚀 Thanh toán ngay
                </button>

            </form>

            <div class="cart-actions">

                <a class="btn btn-delete" href="?clear=1">
                    🗑 Xóa tất cả
                </a>

                <a class="btn btn-shop" href="index.php">
                    🛍 Mua thêm
                </a>

            </div>

        </div>

    </div>

</div>

<?php else: ?>

<div class="empty">
    🛒 Giỏ hàng trống
    <br><br>

    <a class="btn btn-shop" href="index.php">
        Mua ngay
    </a>
</div>

<?php endif; ?>

</div>

</body>
</html>
