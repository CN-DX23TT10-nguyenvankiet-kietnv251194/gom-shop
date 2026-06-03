<?php
session_start();
include "config.php";
?>

<!DOCTYPE html>
<html lang="vi">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Mua sắm</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Poppins;
}

body{
    background:#f5f7fb;
    padding:40px;
}

.container{
    max-width:1200px;
    margin:auto;
}

/* TOPBAR */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    flex-wrap:wrap;
    gap:10px;
}

h1{
    font-size:28px;
}

/* HOME BUTTON */
.home-btn{
    text-decoration:none;
    background:#fff;
    padding:10px 15px;
    border-radius:12px;
    font-weight:600;
    color:#4f46e5;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
    transition:0.3s;
}

.home-btn:hover{
    transform:translateY(-2px);
    background:#eef2ff;
}

/* CART */
.cart{
    position:relative;
    text-decoration:none;
    background:#fff;
    padding:10px 15px;
    border-radius:12px;
    font-weight:600;
    color:#ee4d2d;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

#cart-count{
    position:absolute;
    top:-8px;
    right:-8px;
    background:#ff3b30;
    color:#fff;
    width:22px;
    height:22px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    font-size:12px;
    font-weight:700;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

/* CARD */
.card{
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.06);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card img{
    width:100%;
    height:200px;
    object-fit:cover;
}

.content{
    padding:15px;
}

.name{
    font-size:18px;
    font-weight:600;
    margin-bottom:8px;
}

.price{
    color:#ee4d2d;
    font-size:20px;
    font-weight:700;
    margin-bottom:10px;
}

/* BUTTON */
.btn{
    width:100%;
    border:none;
    cursor:pointer;
    display:block;
    text-align:center;
    background:linear-gradient(135deg,#ee4d2d,#ff7337);
    color:#fff;
    padding:10px;
    border-radius:12px;
    font-weight:600;
    margin-top:8px;
    transition:0.3s;
}

.btn:hover{
    opacity:0.9;
}

/* BUY */
.buy{
    background:linear-gradient(135deg,#4f46e5,#6366f1);
}

/* TOP ACTIONS */
.top-actions{
    display:flex;
    gap:10px;
    align-items:center;
}

</style>

</head>

<body>

<div class="container">

<!-- TOP BAR -->
<div class="topbar">

    <h1>🛍️ Sản phẩm của chúng tôi</h1>

    <div class="top-actions">

        <!-- HOME -->
        <a href="index.php" class="home-btn">
            🏠 Trang chủ
        </a>

        <!-- CART -->
        <a href="cart.php" class="cart">
            🛒 Giỏ hàng
            <span id="cart-count">
                <?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?>
            </span>
        </a>

    </div>

</div>

<!-- PRODUCTS -->
<div class="grid">

<?php
$sql = $conn->query("SELECT * FROM products ORDER BY id DESC");

while($p = $sql->fetch_assoc()):
?>

<div class="card">

    <img src="uploads/<?= htmlspecialchars($p['image']) ?>"
         onerror="this.src='uploads/no-image.png'">

    <div class="content">

        <div class="name">
            <?= htmlspecialchars($p['name']) ?>
        </div>

        <div class="price">
            <?= number_format($p['price']) ?>₫
        </div>

        <!-- ADD TO CART -->
        <button class="btn" onclick="addToCart(<?= $p['id'] ?>)">
            Thêm vào giỏ
        </button>

        <!-- BUY NOW -->
        <a href="buy_now.php?id=<?= $p['id'] ?>" class="btn buy">
            Mua ngay
        </a>

    </div>

</div>

<?php endwhile; ?>

</div>

</div>

<script>

function addToCart(id){

    fetch("add_to_cart.php?id=" + id)
    .then(res => res.json())
    .then(data => {

        document.getElementById("cart-count").innerText = data.count;

        alert("Đã thêm vào giỏ hàng!");
    });

}

</script>

</body>
</html>