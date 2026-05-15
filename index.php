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

/* =========================
   RESET
========================= */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

html{
    scroll-behavior:smooth;
}

body{
    background:
    linear-gradient(135deg,#fff8f2,#f8f4ee,#fff);

    min-height:100vh;
    color:#333;
    overflow-x:hidden;
}

/* =========================
   HEADER
========================= */
.header{

    background:
    linear-gradient(135deg,#ee4d2d,#ff784e,#ff5e62);

    padding:16px 40px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    flex-wrap:wrap;
    gap:15px;

    position:sticky;
    top:0;
    z-index:999;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.08);
}

.logo{
    font-size:32px;
    font-weight:700;
    color:#fff;
}

/* =========================
   SEARCH
========================= */
.search-box{

    display:flex;

    width:42%;
    min-width:260px;

    background:#fff;

    border-radius:16px;

    overflow:hidden;

    box-shadow:
    0 6px 18px rgba(0,0,0,0.08);
}

.search-box input{

    flex:1;

    border:none;

    padding:14px 16px;

    outline:none;

    font-size:14px;
}

.search-box button{

    width:70px;

    border:none;

    background:
    linear-gradient(135deg,#ff5722,#ff784e);

    color:#fff;

    cursor:pointer;

    transition:0.3s;
}

.search-box button:hover{

    transform:scale(1.05);
}

/* =========================
   MENU
========================= */
.menu{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
}

.menu a,
.user-name{

    height:42px;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:0 16px;

    border-radius:14px;

    font-size:14px;
    font-weight:600;

    color:#fff;
    text-decoration:none;

    transition:0.3s;
}

.menu a:hover{

    transform:
    translateY(-3px);
}

.menu a:not(.cart-menu):not(.login-btn):not(.register-btn):not(.logout-btn):not(.admin-btn){

    background:
    rgba(255,255,255,0.14);
}

.cart-menu{

    background:#fff;

    color:#ee4d2d !important;

    box-shadow:
    0 8px 18px rgba(255,255,255,0.2);
}

.user-name{

    background:
    rgba(255,255,255,0.15);
}

.login-btn{

    background:
    rgba(255,255,255,0.14);
}

.register-btn{

    background:#fff;

    color:#ee4d2d !important;
}

.logout-btn{

    background:
    rgba(0,0,0,0.15);
}

.admin-btn{

    background:
    linear-gradient(135deg,#333,#444);
}

/* =========================
   BANNER
========================= */
.banner{

    width:95%;
    max-width:1280px;

    margin:28px auto;

    padding:38px;

    border-radius:28px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    position:relative;

    overflow:hidden;

    background:
    linear-gradient(135deg,#ff3d00,#ff006a,#ff8c00);

    color:#fff;

    box-shadow:
    0 18px 40px rgba(255,61,0,0.25);
}

.banner::before{

    content:"";

    position:absolute;

    width:350px;
    height:350px;

    background:
    rgba(255,255,255,0.1);

    border-radius:50%;

    top:-100px;
    right:-80px;
}

.badge{

    display:inline-block;

    background:#111;

    padding:6px 14px;

    border-radius:30px;

    font-size:12px;

    margin-bottom:15px;
}

.banner-left{

    position:relative;
    z-index:2;
}

.banner-left h2{

    font-size:42px;

    margin-bottom:12px;
}

.banner-left p{

    opacity:0.95;

    max-width:500px;

    line-height:1.7;
}

.banner-btn{

    display:inline-block;

    margin-top:20px;

    background:#fff;

    color:#ff3d00;

    padding:14px 22px;

    border-radius:16px;

    text-decoration:none;
    font-weight:700;

    transition:0.3s;
}

.banner-btn:hover{

    transform:
    translateY(-4px);

    box-shadow:
    0 12px 25px rgba(255,255,255,0.25);
}

/* =========================
   PRODUCTS
========================= */
.container{

    width:95%;
    max-width:1280px;

    margin:auto;

    display:grid;

    grid-template-columns:
    repeat(auto-fill,minmax(260px,1fr));

    gap:26px;

    padding:20px 0 50px;
}

.product{

    background:#fff;

    border-radius:24px;

    overflow:hidden;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.06);

    transition:0.35s;

    position:relative;
}

.product:hover{

    transform:
    translateY(-10px)
    scale(1.02);

    box-shadow:
    0 18px 40px rgba(0,0,0,0.15);
}

.product img{

    width:100%;
    height:250px;

    object-fit:cover;

    transition:0.5s;
}

.product:hover img{

    transform:scale(1.08);
}

/* =========================
   HOT BADGE
========================= */
.hot-badge{

    position:absolute;

    top:14px;
    left:14px;

    background:
    linear-gradient(135deg,#ff0033,#ff4d6d);

    color:#fff;

    padding:6px 12px;

    border-radius:30px;

    font-size:12px;
    font-weight:700;

    z-index:2;
}

/* =========================
   PRODUCT INFO
========================= */
.product-info{
    padding:18px;
}

.product-name{

    font-size:16px;
    font-weight:600;

    min-height:50px;

    color:#222;

    line-height:1.5;
}

.product-price{

    margin-top:10px;

    color:#ee4d2d;

    font-size:28px;
    font-weight:700;
}

.product-meta{

    margin-top:8px;

    font-size:13px;
    color:#777;

    line-height:1.6;
}

/* =========================
   BUTTONS
========================= */
.product-btns{

    display:flex;
    gap:12px;

    padding:0 18px 18px;
}

.cart-btn,
.buy-btn{

    flex:1;

    height:48px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:14px;

    text-decoration:none;
    font-weight:600;

    transition:0.3s;
}

.cart-btn{

    background:#fff;

    color:#ee4d2d;

    border:
    1px solid rgba(238,77,45,0.25);
}

.cart-btn:hover{

    background:#fff3ef;

    transform:translateY(-3px);
}

.buy-btn{

    background:
    linear-gradient(135deg,#ee4d2d,#ff7337);

    color:#fff;

    box-shadow:
    0 10px 20px rgba(238,77,45,0.25);
}

.buy-btn:hover{

    transform:
    translateY(-3px)
    scale(1.03);
}

/* =========================
   TOAST
========================= */
.toast{

    position:fixed;

    bottom:25px;
    right:25px;

    background:
    linear-gradient(135deg,#111,#333);

    color:#fff;

    padding:14px 20px;

    border-radius:16px;

    opacity:0;

    transform:
    translateY(30px);

    transition:0.35s;

    z-index:9999;
}

.toast.show{

    opacity:1;

    transform:
    translateY(0);
}

/* =========================
   EMPTY
========================= */
.empty{

    width:100%;

    text-align:center;

    padding:60px;

    background:#fff;

    border-radius:25px;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.06);
}

/* =========================
   FOOTER
========================= */
.footer{

    margin-top:50px;

    background:
    linear-gradient(135deg,#1a1a1a,#2d2d2d);

    color:#fff;

    text-align:center;

    padding:28px;

    line-height:1.8;
}

/* =========================
   MOBILE
========================= */
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
        padding:28px;
    }

    .banner-left h2{
        font-size:32px;
    }

    .container{
        grid-template-columns:
        repeat(auto-fill,minmax(180px,1fr));
    }

    .product img{
        height:200px;
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

            document.getElementById("cartCount").innerHTML =
            "🛒 Giỏ hàng (" + total + ")";

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
