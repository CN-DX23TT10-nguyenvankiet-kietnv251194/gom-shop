<?php
session_start();
include "config.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];
$role = $_SESSION['role'] ?? 'user';

$cartCount = isset($_SESSION['cart'])
    ? array_sum($_SESSION['cart'])
    : 0;

/* THỐNG KÊ */

$orderCount = 0;

$sql = mysqli_query($conn,"
    SELECT COUNT(*) total
    FROM orders
    WHERE customer='$username'
");

if($sql){
    $orderCount = mysqli_fetch_assoc($sql)['total'];
}

/* ĐƠN HÀNG GẦN ĐÂY */
$recentOrders = mysqli_query($conn,"
    SELECT *
    FROM orders
    WHERE customer='$username'
    ORDER BY id DESC
    LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="vi">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">

<title>Tài khoản khách hàng</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#f8f9fb;
}

/* HEADER */

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 30px;
    background:#fff;
    box-shadow:0 3px 10px rgba(0,0,0,.08);
    flex-wrap:wrap;
}

.logo{
    font-size:28px;
    font-weight:700;
    color:#ee4d2d;
}

.menu{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.menu a{
    text-decoration:none;
    padding:10px 15px;
    border-radius:10px;
    background:#f2f2f2;
    color:#333;
    font-weight:600;
}

.menu a:hover{
    background:#ee4d2d;
    color:#fff;
}

.logout-btn{
    background:#dc3545 !important;
    color:#fff !important;
}

.admin-btn{
    background:#111827 !important;
    color:#fff !important;
}

.seller-btn{
    background:#4f46e5 !important;
    color:#fff !important;
}

/* CONTAINER */

.container{
    width:95%;
    max-width:1200px;
    margin:30px auto;
}

/* HERO */

.hero{
    background:linear-gradient(135deg,#ee4d2d,#ff7b54);
    color:#fff;
    padding:35px;
    border-radius:20px;
}

.hero h1{
    font-size:32px;
}

.hero p{
    margin-top:10px;
}

/* STATS */

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-top:25px;
}

.stat{
    background:#fff;
    padding:25px;
    border-radius:18px;
    text-align:center;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.stat i{
    font-size:30px;
    color:#ee4d2d;
}

.stat h2{
    margin:10px 0;
}

/* DASHBOARD */

.dashboard{
    margin-top:25px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.card{
    background:#fff;
    padding:25px;
    border-radius:18px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.card i{
    font-size:30px;
    color:#ee4d2d;
}

.card h3{
    margin:15px 0 10px;
}

.card a{
    display:inline-block;
    margin-top:15px;
    padding:10px 15px;
    background:#ee4d2d;
    color:#fff;
    border-radius:10px;
    text-decoration:none;
}

/* TABLE */

.orders{
    margin-top:30px;
    background:#fff;
    border-radius:18px;
    padding:20px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.orders h2{
    margin-bottom:15px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th,
table td{
    padding:12px;
    border-bottom:1px solid #eee;
    text-align:left;
}

.status{
    padding:5px 10px;
    border-radius:8px;
    background:#fff3cd;
}

@media(max-width:768px){

    .header{
        padding:15px;
    }

    .menu{
        margin-top:10px;
    }

    table{
        display:block;
        overflow:auto;
    }
}

</style>
</head>
<body>

<div class="header">

    <div class="logo">🏺 Gốm Shop</div>

    <div class="menu">

        <a href="index.php">Trang chủ</a>

        <a href="shop.php">Mua hàng</a>

        <a href="cart.php">
            Giỏ hàng (<?= $cartCount ?>)
        </a>

        <a href="orders.php">
            Đơn hàng
        </a>

        <a href="seller_shop.php" class="seller-btn">
            Shop bán hàng
        </a>

        <?php if($role=='admin'){ ?>
            <a href="admin.php" class="admin-btn">
                Quản lý
            </a>
        <?php } ?>

        <a href="logout.php" class="logout-btn">
            Đăng xuất
        </a>

    </div>

</div>

<div class="container">

    <div class="hero">
        <h1>Xin chào, <?= htmlspecialchars($username) ?></h1>
        <p>Quản lý tài khoản và đơn hàng của bạn.</p>
    </div>

    <div class="stats">

        <div class="stat">
            <i class="fa-solid fa-cart-shopping"></i>
            <h2><?= $cartCount ?></h2>
            <p>Sản phẩm trong giỏ</p>
        </div>

        <div class="stat">
            <i class="fa-solid fa-box"></i>
            <h2><?= $orderCount ?></h2>
            <p>Tổng đơn hàng</p>
        </div>

        <div class="stat">
            <i class="fa-solid fa-user"></i>
            <h2><?= strtoupper($role) ?></h2>
            <p>Vai trò</p>
        </div>

    </div>

    <div class="dashboard">

        <div class="card">
            <i class="fa-solid fa-box"></i>
            <h3>Đơn hàng</h3>
            <p>Xem lịch sử mua hàng.</p>
            <a href="orders.php">Xem ngay</a>
        </div>

        <div class="card">
            <i class="fa-solid fa-cart-shopping"></i>
            <h3>Giỏ hàng</h3>
            <p>Quản lý sản phẩm đã chọn.</p>
            <a href="cart.php">Mở giỏ hàng</a>
        </div>

        <div class="card">
            <i class="fa-solid fa-store"></i>
            <h3>Shop bán hàng</h3>
            <p>Đăng sản phẩm và quản lý shop.</p>
            <a href="seller_shop.php">Vào shop</a>
        </div>

    </div>

    <div class="orders">

        <h2>Đơn hàng gần đây</h2>

        <table>

            <tr>
                <th>Mã đơn</th>
                <th>Ngày tạo</th>
                <th>Loại</th>
                <th>Trạng thái</th>
            </tr>

            <?php while($o = mysqli_fetch_assoc($recentOrders)){ ?>

            <tr>

                <td>#<?= $o['id'] ?></td>

                <td><?= $o['created_at'] ?></td>

                <td><?= $o['type'] ?></td>

                <td>
                    <span class="status">
                        <?= $o['status'] ?>
                    </span>
                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>