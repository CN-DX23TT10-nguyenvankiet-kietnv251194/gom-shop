<?php
session_start();
include "config.php";

/* =========================
   SEARCH
========================= */

$keyword = "";

if(isset($_GET['keyword']) && trim($_GET['keyword']) != ""){

    $keyword = trim($_GET['keyword']);

    $stmt = $conn->prepare("
        SELECT * FROM products
        WHERE name LIKE ?
        ORDER BY id DESC
    ");

    $search = "%$keyword%";

    $stmt->bind_param("s",$search);

    $stmt->execute();

    $res = $stmt->get_result();

}else{

    $res = $conn->query("
        SELECT * FROM products
        ORDER BY id DESC
    ");

}

?>

<!DOCTYPE html>
<html lang="vi">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>🏺 Gốm Shop</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:
    linear-gradient(to bottom,#f7f3ee,#f3eee7);

    min-height:100vh;
    color:#333;
}

/* HEADER */
.header{

    background:
    linear-gradient(45deg,#ee4d2d,#ff7337);

    padding:15px 40px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    flex-wrap:wrap;
    gap:15px;

    position:sticky;
    top:0;
    z-index:999;

    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

.logo{
    font-size:30px;
    font-weight:700;
    color:#fff;
}

/* SEARCH */
.search-box{

    display:flex;

    width:40%;
    min-width:260px;

    background:#fff;
    border-radius:12px;

    overflow:hidden;
}

.search-box input{

    flex:1;
    border:none;

    padding:12px 14px;

    outline:none;
    font-size:14px;
}

.search-box button{

    width:70px;

    border:none;
    background:#fb5533;

    color:#fff;
    cursor:pointer;
}

/* MENU */
.menu{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
}

.menu a,
.user-name{

    height:40px;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:0 14px;

    border-radius:10px;

    font-size:14px;
    font-weight:600;

    color:#fff;
    text-decoration:none;

    transition:0.25s;
}

.menu a:hover{
    transform:translateY(-2px);
}

.menu a:not(.cart-menu):not(.login-btn):not(.register-btn):not(.logout-btn):not(.admin-btn){
    background:rgba(255,255,255,0.12);
}

.cart-menu{
    background:#fff;
    color:#ee4d2d !important;
}

.user-name{
    background:rgba(255,255,255,0.12);
}

.login-btn{
    background:rgba(255,255,255,0.15);
}

.register-btn{
    background:#fff;
    color:#ee4d2d !important;
}

.logout-btn{
    background:rgba(0,0,0,0.15);
}

.admin-btn{
    background:rgba(0,0,0,0.12);
}

/* BANNER */
.banner{

    width:95%;
    max-width:1200px;

    margin:20px auto;

    padding:24px;

    border-radius:18px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    background:
    linear-gradient(135deg,#ff3d00,#ff006a,#ff8c00);

    color:#fff;

    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

.badge{

    display:inline-block;

    background:#000;

    padding:5px 12px;

    border-radius:20px;

    font-size:12px;

    margin-bottom:10px;
}

.banner-left h2{
    font-size:30px;
    margin-bottom:10px;
}

.banner-left p{
    opacity:0.9;
    max-width:450px;
}

.banner-btn{

    display:inline-block;

    margin-top:15px;

    background:#fff;
    color:#ff3d00;

    padding:12px 16px;

    border-radius:12px;

    text-decoration:none;
    font-weight:600;
}

/* PRODUCTS */
.container{

    width:95%;
    margin:auto;

    display:grid;

    grid-template-columns:
    repeat(auto-fill,minmax(230px,1fr));

    gap:20px;

    padding:20px 0 40px;
}

.product{

    background:#fff;

    border-radius:18px;

    overflow:hidden;

    box-shadow:
    0 4px 12px rgba(0,0,0,0.08);

    transition:0.3s;

    position:relative;
}

.product:hover{

    transform:
    translateY(-8px)
    scale(1.02);

    box-shadow:
    0 12px 30px rgba(0,0,0,0.15);
}

.product img{

    width:100%;
    height:230px;

    object-fit:cover;
}

/* BADGE */
.hot-badge{

    position:absolute;

    top:12px;
    left:12px;

    background:#ff0033;
    color:#fff;

    padding:5px 10px;

    border-radius:20px;

    font-size:12px;
    font-weight:600;

    z-index:2;
}

/* PRODUCT INFO */
.product-info{
    padding:14px;
}

.product-name{

    font-size:15px;
    font-weight:600;

    min-height:45px;

    color:#333;
}

.product-price{

    margin-top:8px;

    color:#ee4d2d;

    font-size:22px;
    font-weight:700;
}

.product-meta{

    margin-top:6px;

    font-size:13px;
    color:#777;
}

/* BUTTONS */
.product-btns{

    display:flex;
    gap:10px;

    padding:14px;
}

.cart-btn,
.buy-btn{

    flex:1;

    height:44px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:12px;

    text-decoration:none;
    font-weight:600;
}

.cart-btn{

    background:#fff;

    color:#ee4d2d;

    border:1px solid rgba(238,77,45,0.3);
}

.buy-btn{

    background:
    linear-gradient(45deg,#ee4d2d,#ff7337);

    color:#fff;
}

/* TOAST */
.toast{

    position:fixed;

    bottom:20px;
    right:20px;

    background:#222;
    color:#fff;

    padding:12px 18px;

    border-radius:12px;

    opacity:0;
    transition:0.3s;
}

.toast.show{
    opacity:1;
}

/* EMPTY */
.empty{

    width:100%;
    text-align:center;

    padding:40px;

    background:#fff;

    border-radius:15px;
}

/* FOOTER */
.footer{

    margin-top:40px;

    background:#222;

    color:#fff;

    text-align:center;

    padding:20px;
}

/* MOBILE */
@media(max-width:768px){

    .search-box{
        width:100%;
    }

    .logo{
        width:100%;
        text-align:center;
    }

    .menu{
        width:100%;
        justify-content:center;
    }

    .banner{
        flex-direction:column;
        text-align:center;
    }
}

</style>

</head>

<body>

<!-- HEADER -->
<div class="header">

    <div class="logo">
        🏺 Gốm Shop
    </div>

    <!-- SEARCH -->
    <form class="search-box" method="GET">

        <input
            type="text"
            name="keyword"
            placeholder="Tìm đồ gốm cổ..."
            value="<?= htmlspecialchars($keyword) ?>"
        >

        <button>🔍</button>

    </form>

    <!-- MENU -->
    <div class="menu">

        <a href="index.php">
            Trang chủ
        </a>

        <a href="orders.php">
            Đơn hàng
        </a>

        <!-- FIX CART -->
        <a href="cart.php" id="cartCount" class="cart-menu">
            🛒 Giỏ hàng (<?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?>)
        </a>

        <?php if(isset($_SESSION['user'])): ?>

            <span class="user-name">
                👋 <?= htmlspecialchars($_SESSION['user']) ?>
            </span>

            <a href="logout.php" class="logout-btn">
                Đăng xuất
            </a>

        <?php else: ?>

            <a href="login.php" class="login-btn">
                Đăng nhập
            </a>

            <a href="register.php" class="register-btn">
                Đăng ký
            </a>

        <?php endif; ?>

        <a href="admin.php" class="admin-btn">
            Quản lý
        </a>

    </div>

</div>

<!-- BANNER -->
<div class="banner">

    <div class="banner-left">

        <div class="badge">
            🔥 FLASH SALE
        </div>

        <h2>
            Gốm Cổ Sưu Tầm
        </h2>

        <p>
            Đồ gốm cũ độc bản • Thủ công • Men cổ • Giá tốt hôm nay
        </p>

        <a href="index.php" class="banner-btn">
            🛒 Mua ngay
        </a>

    </div>

</div>

<!-- PRODUCTS -->
<div class="container">

<?php if($res->num_rows > 0): ?>

<?php while($p = $res->fetch_assoc()): ?>

<div class="product">

    <div class="hot-badge">
        Độc bản
    </div>

    <a href="detail.php?id=<?= $p['id'] ?>">

        <img
            src="uploads/<?= htmlspecialchars($p['image']) ?>"
            loading="lazy"
            onerror="this.src='uploads/no-image.png'"
        >

    </a>

    <!-- INFO -->
    <div class="product-info">

        <div class="product-name">
            <?= htmlspecialchars($p['name']) ?>
        </div>

        <div class="product-price">
            <?= number_format($p['price']) ?>₫
        </div>

        <div class="product-meta">

            🏺 Gốm cũ sưu tầm

            <?php if(isset($p['origin'])): ?>
                • 📍 <?= htmlspecialchars($p['origin']) ?>
            <?php endif; ?>

        </div>

    </div>

    <!-- BUTTON -->
    <div class="product-btns">

        <a
            href="add.php?id=<?= $p['id'] ?>"
            class="cart-btn add-cart"
        >
            Thêm giỏ
        </a>

        <a
            href="detail.php?id=<?= $p['id'] ?>"
            class="buy-btn"
        >
            Mua
        </a>

    </div>

</div>

<?php endwhile; ?>

<?php else: ?>

<div class="empty">
    Không tìm thấy sản phẩm nào
</div>

<?php endif; ?>

</div>

<!-- TOAST -->
<div class="toast" id="toast">
    Đã thêm vào giỏ hàng
</div>

<!-- FOOTER -->
<div class="footer">

    © 2026 Gốm Shop

    • Đồ gốm cũ sưu tầm

    • Đồ Gốm Việt Nam

</div>

<!-- FIX AJAX -->
<script>

document.querySelectorAll(".add-cart").forEach(function(btn){

    btn.addEventListener("click", function(e){

        e.preventDefault();

        fetch(this.href)

        .then(function(response){

            return response.text();

        })

        .then(function(total){

            total = total.trim();

            // update cart realtime
            document.getElementById("cartCount").innerHTML =
            "🛒 Giỏ hàng (" + total + ")";

            // toast
            const toast = document.getElementById("toast");

            toast.classList.add("show");

            setTimeout(function(){

                toast.classList.remove("show");

            },1500);

        });

    });

});

</script>

</body>
</html>
