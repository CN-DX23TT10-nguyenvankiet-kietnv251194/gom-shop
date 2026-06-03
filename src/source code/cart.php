<?php
session_start();
include "config.php";

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

/* TĂNG GIẢM SỐ LƯỢNG */
if(isset($_GET['action']) && isset($_GET['id'])){

    $id = (int)$_GET['id'];

    if(isset($_SESSION['cart'][$id])){

        if($_GET['action'] == 'plus'){

            $_SESSION['cart'][$id]++;

        }elseif($_GET['action'] == 'minus'){

            $_SESSION['cart'][$id]--;

            if($_SESSION['cart'][$id] <= 0){
                unset($_SESSION['cart'][$id]);
            }
        }
    }

    header("Location: cart.php");
    exit;
}

/* XÓA SẢN PHẨM */
if(isset($_GET['remove'])){

    $id = (int)$_GET['remove'];

    if(isset($_SESSION['cart'][$id])){
        unset($_SESSION['cart'][$id]);
    }

    header("Location: cart.php");
    exit;
}

$cart = $_SESSION['cart'];

$itemCount = array_sum($cart);
?>

<!DOCTYPE html>
<html lang="vi">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Giỏ hàng</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:linear-gradient(135deg,#f6f9fc,#eef2ff);
    min-height:100vh;
    padding:30px 15px;
}

.box{
    max-width:1100px;
    margin:auto;
    background:#fff;
    border-radius:25px;
    padding:30px;
    box-shadow:0 15px 40px rgba(0,0,0,.08);
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    flex-wrap:wrap;
    gap:10px;
}

.header h2{
    font-size:32px;
}

.count{
    background:#eef2ff;
    color:#4f46e5;
    padding:10px 18px;
    border-radius:999px;
    font-weight:600;
}

.item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 0;
    border-bottom:1px solid #eee;
    transition:.3s;
}

.item:hover{
    background:#fafafa;
}

.left{
    display:flex;
    align-items:center;
    gap:15px;
}

.item img{
    width:90px;
    height:90px;
    object-fit:cover;
    border-radius:15px;
}

.name{
    font-size:18px;
    font-weight:600;
    margin-bottom:5px;
}

.qty{
    color:#666;
    font-size:14px;
    margin-top:5px;
}

.qty-control{
    display:flex;
    align-items:center;
    gap:10px;
    margin-top:10px;
}

.qty-btn{
    width:32px;
    height:32px;
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    background:#eef2ff;
    color:#333;
    border-radius:8px;
    font-weight:bold;
    transition:.3s;
}

.qty-btn:hover{
    background:#4f46e5;
    color:#fff;
}

.price{
    font-size:22px;
    font-weight:700;
    color:#ee4d2d;
}

.remove{
    display:inline-block;
    margin-top:10px;
    color:red;
    text-decoration:none;
}

.summary{
    margin-top:30px;
    border-top:2px dashed #ddd;
    padding-top:25px;
}

.row{
    display:flex;
    justify-content:space-between;
    margin-bottom:12px;
}

.total{
    font-size:28px;
    font-weight:700;
    color:#ee4d2d;
}

.actions{
    margin-top:20px;
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.btn{
    padding:13px 20px;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
}

.btn-primary{
    background:#ee4d2d;
    color:#fff;
}

.btn-secondary{
    background:#eef2ff;
    color:#333;
}

.empty{
    text-align:center;
    padding:80px 20px;
}

.empty h3{
    margin-bottom:20px;
}

@media(max-width:768px){

    .item{
        flex-direction:column;
        align-items:flex-start;
        gap:15px;
    }

    .price{
        margin-left:105px;
    }
}

</style>

</head>

<body>

<div class="box">

<div class="header">

    <h2>🛒 Giỏ hàng của bạn</h2>

    <div class="count">
        <?= $itemCount ?> sản phẩm
    </div>

</div>

<?php

$total = 0;

if(!empty($cart)):

foreach($cart as $id => $qty):

$stmt = $conn->prepare(
    "SELECT * FROM products WHERE id=?"
);

$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows > 0):

$p = $result->fetch_assoc();

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
                Đơn giá:
                <?= number_format($p['price']) ?>₫
            </div>

            <div class="qty-control">

                <a
                href="?action=minus&id=<?= $id ?>"
                class="qty-btn">−</a>

                <strong><?= $qty ?></strong>

                <a
                href="?action=plus&id=<?= $id ?>"
                class="qty-btn">+</a>

            </div>

            <div class="qty">
                Thành tiền:
                <?= number_format($subtotal) ?>₫
            </div>

            <a
                href="?remove=<?= $id ?>"
                class="remove"
                onclick="return confirm('Xóa sản phẩm này?')"
            >
                🗑 Xóa
            </a>

        </div>

    </div>

    <div class="price">
        <?= number_format($subtotal) ?>₫
    </div>

</div>

<?php
endif;
endforeach;
?>

<div class="summary">

    <div class="row">
        <span>Số mặt hàng</span>
        <span><?= count($cart) ?></span>
    </div>

    <div class="row">
        <span>Tổng sản phẩm</span>
        <span><?= $itemCount ?></span>
    </div>

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

    <div class="actions">

        <a href="shop.php" class="btn btn-secondary">
            ← Tiếp tục mua
        </a>

        <?php if(isset($_SESSION['user_id'])): ?>

            <a href="checkout.php" class="btn btn-primary">
                Thanh toán
            </a>

        <?php else: ?>

            <a href="login.php" class="btn btn-primary">
                Đăng nhập để thanh toán
            </a>

        <?php endif; ?>

    </div>

</div>

<?php else: ?>

<div class="empty">

    <h3>🛒 Giỏ hàng của bạn đang trống</h3>

    <a href="shop.php" class="btn btn-primary">
        Mua sắm ngay
    </a>

</div>

<?php endif; ?>

</div>

</body>
</html>