<?php
session_start();
include "config.php";

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if(count($cart) <= 0){
    header("Location: cart.php");
    exit;
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="vi">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Thanh toán</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#f5f7fb;
    padding:40px 20px;
    color:#222;
}

.container{
    max-width:1200px;
    margin:auto;

    display:grid;
    grid-template-columns:1fr 400px;
    gap:30px;
}

.box{
    background:#fff;
    border-radius:24px;
    padding:30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.06);
}

.title{
    font-size:30px;
    font-weight:700;
    margin-bottom:30px;
}

.item{
    display:flex;
    align-items:center;
    justify-content:space-between;

    padding:20px 0;

    border-bottom:1px solid #eee;
}

.left{
    display:flex;
    align-items:center;
    gap:16px;
}

.item img{
    width:90px;
    height:90px;
    object-fit:cover;
    border-radius:16px;
}

.name{
    font-size:18px;
    font-weight:600;
    margin-bottom:6px;
}

.qty{
    color:#777;
}

.price{
    color:#ee4d2d;
    font-size:22px;
    font-weight:700;
}

.form-group{
    margin-bottom:20px;
}

label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
}

input,
textarea{
    width:100%;
    padding:14px;
    border:1px solid #ddd;
    border-radius:14px;
    outline:none;
    font-size:15px;
}

textarea{
    min-height:120px;
    resize:none;
}

.summary{
    background:#fff;
    border-radius:24px;
    padding:30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.06);

    height:fit-content;
}

.row{
    display:flex;
    justify-content:space-between;
    margin-bottom:18px;
}

.total{
    border-top:2px dashed #ddd;
    padding-top:20px;
    margin-top:20px;

    font-size:28px;
    font-weight:700;
    color:#ee4d2d;
}

.btn{
    width:100%;
    border:none;
    margin-top:25px;

    background:linear-gradient(135deg,#ee4d2d,#ff7337);

    color:#fff;

    padding:16px;

    border-radius:16px;

    font-size:17px;
    font-weight:700;

    cursor:pointer;

    transition:0.3s;
}

.btn:hover{
    transform:translateY(-2px);
}

@media(max-width:900px){

    .container{
        grid-template-columns:1fr;
    }
}

</style>

</head>

<body>

<form action="place_order.php" method="POST">

<div class="container">

    <!-- LEFT -->
    <div class="box">

        <div class="title">
            🧾 Xác nhận đơn hàng
        </div>

        <?php foreach($cart as $id => $qty): ?>

        <?php

        $sql = $conn->query("
            SELECT * FROM products
            WHERE id = $id
        ");

        if($sql->num_rows > 0):

        $p = $sql->fetch_assoc();

        $subtotal = $p['price'] * $qty;

        $total += $subtotal;

        ?>

        <div class="item">

            <div class="left">

                <img
                    src="uploads/<?= htmlspecialchars($p['image']) ?>"
                    onerror="this.src='uploads/no-image.png'"
                >

                <div>

                    <div class="name">
                        <?= htmlspecialchars($p['name']) ?>
                    </div>

                    <div class="qty">
                        Số lượng: <?= $qty ?>
                    </div>

                </div>

            </div>

            <div class="price">
                <?= number_format($subtotal) ?>₫
            </div>

        </div>

        <?php endif; ?>

        <?php endforeach; ?>

        <!-- FORM -->
        <div style="margin-top:40px;">

            <div class="form-group">

                <label>
                    Họ và tên
                </label>

                <input
                    type="text"
                    name="fullname"
                    required
                >

            </div>

            <div class="form-group">

                <label>
                    Số điện thoại
                </label>

                <input
                    type="text"
                    name="phone"
                    required
                >

            </div>

            <div class="form-group">

                <label>
                    Địa chỉ giao hàng
                </label>

                <textarea
                    name="address"
                    required
                ></textarea>

            </div>

        </div>

    </div>

    <!-- RIGHT -->
    <div class="summary">

        <h2 style="margin-bottom:25px;">
            💳 Thanh toán
        </h2>

        <div class="row">
            <span>Tạm tính</span>
            <span><?= number_format($total) ?>₫</span>
        </div>

        <div class="row">
            <span>Vận chuyển</span>
            <span>Miễn phí</span>
        </div>

        <div class="row total">
            <span>Tổng cộng</span>
            <span><?= number_format($total) ?>₫</span>
        </div>

        <button class="btn">
            Đặt hàng ngay
        </button>

    </div>

</div>

</form>

</body>
</html>