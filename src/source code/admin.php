<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] != 'admin'){
    echo "Bạn không có quyền truy cập!";
    exit();
}

include "config.php";

/* THỐNG KÊ */

$totalProducts =
mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM products
")
)['total'];

$totalOrders =
mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM orders
")
)['total'];

$totalUsers =
$totalBan =
mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM orders
WHERE type='ban'
")
)['total'];

$totalNhap =
mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM orders
WHERE type='nhap'
")
)['total'];

$totalStock =
mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COALESCE(SUM(stock),0) total
FROM products
")
)['total'];
mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM users
WHERE role='user'
")
)['total'];

$revenue =
mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COALESCE(SUM(p.price * oi.qty),0) total
FROM order_items oi
JOIN products p
ON p.id = oi.product_id
")
)['total'];

?>

<!DOCTYPE html>
<html lang="vi">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{

    min-height:100vh;

    background:
    linear-gradient(
        135deg,
        #fff3ee,
        #fff8f5,
        #ffffff
    );

    padding:40px 20px;
}

/* CONTAINER */

.container{

    max-width:1300px;

    margin:auto;
}

/* HEADER */

.header{

    background:
    linear-gradient(
        135deg,
        #ee4d2d,
        #ff784e
    );

    color:#fff;

    border-radius:35px;

    padding:40px;

    text-align:center;

    margin-bottom:35px;

    box-shadow:
    0 15px 40px rgba(238,77,45,0.25);
}

.header h1{

    font-size:42px;

    margin-bottom:10px;
}

.header p{

    font-size:16px;
}

/* STATS */

.stats{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(240px,1fr));

    gap:20px;

    margin-bottom:35px;
}

.stat-box{

    background:#fff;

    padding:25px;

    border-radius:25px;

    text-align:center;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.06);
}

.stat-box h3{

    color:#666;

    margin-bottom:10px;
}

.stat-box span{

    font-size:32px;

    font-weight:700;

    color:#ee4d2d;
}

/* GRID */

.grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(280px,1fr));

    gap:25px;
}

/* CARD */

.card{

    background:#fff;

    border-radius:28px;

    padding:35px 25px;

    text-align:center;

    text-decoration:none;

    color:#333;

    position:relative;

    overflow:hidden;

    transition:0.35s;

    box-shadow:
    0 12px 30px rgba(0,0,0,0.06);
}

.card::before{

    content:"";

    position:absolute;

    top:0;
    left:0;

    width:100%;
    height:6px;

    background:
    linear-gradient(
        90deg,
        #ee4d2d,
        #ff784e
    );
}

.card:hover{

    transform:
    translateY(-10px);

    box-shadow:
    0 20px 40px rgba(0,0,0,0.12);
}

.icon{

    width:90px;
    height:90px;

    margin:0 auto 20px;

    border-radius:24px;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:42px;

    color:#fff;
}

.orange{
    background:
    linear-gradient(
        135deg,
        #ee4d2d,
        #ff784e
    );
}

.blue{
    background:
    linear-gradient(
        135deg,
        #2d7dff,
        #4da3ff
    );
}

.green{
    background:
    linear-gradient(
        135deg,
        #00b894,
        #00d2a8
    );
}

.red{
    background:
    linear-gradient(
        135deg,
        #ff3b3b,
        #ff6b6b
    );
}

.card h2{

    margin-bottom:10px;

    font-size:22px;
}

.card p{

    color:#666;

    line-height:1.7;
}

@media(max-width:768px){

    .header h1{
        font-size:30px;
    }

    .stats{
        grid-template-columns:1fr;
    }
}

</style>

</head>

<body>

<div class="container">

    <div class="header">

        <h1>
            👑 Quản Lý DASHBOARD
        </h1>

        <p>
            Xin chào Admin:
            <b>
                <?php echo $_SESSION['user']; ?>
            </b>
        </p>

    </div>

    <div class="stats">

    <div class="stat-box">
        <h3>🛍️ Sản phẩm</h3>
        <span><?= $totalProducts ?></span>
    </div>

    <div class="stat-box">
        <h3>📦 Đơn hàng</h3>
        <span><?= $totalOrders ?></span>
    </div>

    <div class="stat-box">
        <h3>👥 Khách hàng</h3>
        <span><?= $totalUsers ?></span>
    </div>

    <div class="stat-box">
        <h3>💰 Doanh thu</h3>
        <span><?= number_format($revenue) ?>₫</span>
    </div>

    <div class="stat-box">
        <h3>🛒 Đơn bán</h3>
        <span><?= $totalBan ?></span>
    </div>

    <div class="stat-box">
        <h3>📥 Đơn nhập</h3>
        <span><?= $totalNhap ?></span>
    </div>

    <div class="stat-box">
        <h3>🏺 Tồn kho</h3>
        <span><?= $totalStock ?></span>
    </div>

</div>
    <div class="grid">

        <a href="shop.php" class="card">

            <div class="icon blue">🛍️</div>

            <h2>Sản phẩm</h2>

            <p>
                Quản lý sản phẩm và tồn kho.
            </p>

        </a>

        <a href="orders.php?type=ban" class="card">

            <div class="icon green">📦</div>

            <h2>Đơn bán</h2>

            <p>
                Quản lý đơn bán hàng.
            </p>

        </a>

        <a href="orders.php?type=nhap" class="card">

            <div class="icon orange">📥</div>

            <h2>Nhập kho</h2>

            <p>
                Theo dõi đơn nhập kho.
            </p>

        </a>

        <a href="users.php" class="card">

            <div class="icon blue">👥</div>

            <h2>Tài khoản</h2>

            <p>
                Quản lý người dùng.
            </p>

        </a>

        <a href="top_products.php" class="card">

            <div class="icon green">📈</div>

            <h2>Doanh thu</h2>

            <p>
                Thống kê doanh thu và bán hàng.
            </p>

        </a>

        <a href="seller_shop.php" class="card">

            <div class="icon orange">🏪</div>

            <h2>Thông tin Shop</h2>

            <p>
                Quản lý cửa hàng.
            </p>

        </a>

        <a href="logout.php" class="card">

            <div class="icon red">🚪</div>

            <h2>Đăng xuất</h2>

            <p>
                Thoát khỏi hệ thống.
            </p>

        </a>

    </div>

</div>

</body>
</html>