<?php
session_start();
include "config.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);

if($result->num_rows == 0){
    echo "Không tìm thấy sản phẩm";
    exit;
}

$p = $result->fetch_assoc();

/* tồn kho demo */
$stock = isset($p['stock']) ? $p['stock'] : 15;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($p['name']); ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, Helvetica, sans-serif;
    background:#f5f5f5;
    color:#222;
}

/* HEADER */
.header{
    background:#fff;
    padding:15px 0;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
    position:sticky;
    top:0;
    z-index:999;
}

.header-inner{
    width:90%;
    margin:auto;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.logo{
    font-size:22px;
    font-weight:bold;
    color:#ee4d2d;
}

.home-btn{
    text-decoration:none;
    padding:10px 16px;
    background:#fff;
    border:1px solid #ddd;
    border-radius:10px;
    color:#333;
    font-weight:bold;
    transition:0.3s;
}

.home-btn:hover{
    background:#f1f1f1;
}

/* MAIN */
.container{
    width:90%;
    margin:30px auto;
    display:flex;
    gap:25px;
}

/* LEFT */
.left{
    width:42%;
    background:#fff;
    border-radius:18px;
    padding:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
}

/* MAIN IMAGE */
.main-image{
    width:100%;
    height:450px;
    border-radius:16px;
    overflow:hidden;
    border:1px solid #eee;
}

.main-image img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:0.4s;
}

.main-image img:hover{
    transform:scale(1.08);
}

/* THUMB */
.thumb-list{
    display:flex;
    gap:10px;
    margin-top:15px;
}

.thumb-list img{
    width:80px;
    height:80px;
    object-fit:cover;
    border-radius:10px;
    cursor:pointer;
    border:2px solid transparent;
    transition:0.2s;
}

.thumb-list img:hover{
    border-color:#ee4d2d;
}

/* RIGHT */
.right{
    flex:1;
    background:#fff;
    border-radius:18px;
    padding:28px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
}

/* TITLE */
.product-name{
    font-size:28px;
    margin-bottom:12px;
}

/* RATING */
.rating{
    color:#ffb400;
    margin-bottom:15px;
    font-size:18px;
}

/* PRICE */
.price{
    font-size:34px;
    color:#ee4d2d;
    font-weight:bold;
    margin-bottom:15px;
}

/* STOCK */
.stock{
    display:inline-block;
    background:#e8fff0;
    color:#16a34a;
    padding:8px 14px;
    border-radius:999px;
    font-size:14px;
    margin-bottom:20px;
    font-weight:bold;
}

/* DESC */
.desc{
    line-height:1.7;
    color:#555;
    margin-bottom:25px;
}

/* QTY */
.qty-title{
    margin-bottom:10px;
    font-weight:bold;
}

.qty-box{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:25px;
}

.qty-box button{
    width:42px;
    height:42px;
    border:none;
    border-radius:10px;
    background:#f1f1f1;
    font-size:20px;
    cursor:pointer;
    transition:0.2s;
}

.qty-box button:hover{
    background:#ddd;
}

.qty-box input{
    width:70px;
    height:42px;
    text-align:center;
    border:1px solid #ddd;
    border-radius:10px;
    font-size:16px;
}

/* TOTAL */
.total{
    font-size:22px;
    font-weight:bold;
    margin-bottom:25px;
}

/* BUTTONS */
.buttons{
    display:flex;
    gap:15px;
}

.btn{
    flex:1;
    border:none;
    padding:16px;
    border-radius:14px;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

/* CART */
.cart-btn{
    background:#fff3f1;
    border:2px solid #ee4d2d;
    color:#ee4d2d;
}

.cart-btn:hover{
    background:#ffe0d9;
    transform:translateY(-3px);
}

/* BUY */
.buy-btn{
    background:linear-gradient(45deg,#ee4d2d,#ff7b42);
    color:#fff;
    animation:pulse 1.5s infinite;
}

.buy-btn:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 25px rgba(238,77,45,0.3);
}

/* ANIMATION */
@keyframes pulse{
    0%{
        transform:scale(1);
    }
    50%{
        transform:scale(1.02);
    }
    100%{
        transform:scale(1);
    }
}

/* TOAST */
.toast{
    position:fixed;
    top:20px;
    right:20px;
    background:#16a34a;
    color:#fff;
    padding:14px 20px;
    border-radius:12px;
    display:none;
    font-weight:bold;
    z-index:9999;
    box-shadow:0 5px 15px rgba(0,0,0,0.15);
}

/* MOBILE */
@media(max-width:900px){

    .container{
        flex-direction:column;
    }

    .left{
        width:100%;
    }

    .main-image{
        height:320px;
    }

    .buttons{
        flex-direction:column;
    }

    .product-name{
        font-size:24px;
    }

}

</style>
</head>

<body>

<div class="toast" id="toast">
    ✅ Đã thêm vào giỏ hàng
</div>

<!-- HEADER -->
<div class="header">

    <div class="header-inner">

        <div class="logo">
            🏺 Gốm Shop
        </div>

        <a href="index.php" class="home-btn">
            ⬅ Trang chủ
        </a>

    </div>

</div>

<!-- CONTENT -->
<div class="container">

    <!-- LEFT -->
    <div class="left">

        <div class="main-image">
            <img id="mainImg"
                 src="uploads/<?php echo $p['image']; ?>">
        </div>

        <!-- demo thumbnail -->
        <div class="thumb-list">

            <img src="uploads/<?php echo $p['image']; ?>"
                 onclick="changeImage(this.src)">

            <img src="uploads/<?php echo $p['image']; ?>"
                 onclick="changeImage(this.src)">

            <img src="uploads/<?php echo $p['image']; ?>"
                 onclick="changeImage(this.src)">

        </div>

    </div>

    <!-- RIGHT -->
    <div class="right">

        <h1 class="product-name">
            <?php echo htmlspecialchars($p['name']); ?>
        </h1>

        <div class="rating">
            ⭐⭐⭐⭐⭐ (4.9 đánh giá)
        </div>

        <div class="price"
             id="basePrice"
             data-price="<?php echo $p['price']; ?>">

            <?php echo number_format($p['price']); ?>₫

        </div>

        <div class="stock">
            ✔ Còn <?php echo $stock; ?> sản phẩm
        </div>

        <div class="desc">

            Đây là sản phẩm gốm thủ công cao cấp với thiết kế tinh tế,
            phù hợp trưng bày và sưu tầm.

        </div>

        <div class="qty-title">
            Số lượng
        </div>

        <div class="qty-box">

            <button onclick="changeQty(-1)">-</button>

            <input type="number"
                   id="qty"
                   value="1"
                   min="1"
                   max="<?php echo $stock; ?>"
                   oninput="updatePrice()">

            <button onclick="changeQty(1)">+</button>

        </div>

        <div class="total" id="totalPrice">
            Tổng: <?php echo number_format($p['price']); ?>₫
        </div>

        <div class="buttons">

            <button class="btn cart-btn"
                    onclick="addToCart(<?php echo $p['id']; ?>)">

                🛒 Thêm vào giỏ

            </button>

            <button class="btn buy-btn"
                    onclick="buyNow(<?php echo $p['id']; ?>)">

                ⚡ Mua ngay

            </button>

        </div>

    </div>

</div>

<script>

function changeImage(src){
    document.getElementById("mainImg").src = src;
}

/* qty */
function changeQty(val){

    let qtyInput = document.getElementById("qty");

    let current = parseInt(qtyInput.value) || 1;

    let max = parseInt(qtyInput.max);

    current += val;

    if(current < 1) current = 1;

    if(current > max) current = max;

    qtyInput.value = current;

    updatePrice();
}

/* total */
function updatePrice(){

    let qty =
        parseInt(document.getElementById("qty").value) || 1;

    let price =
        parseInt(document.getElementById("basePrice").dataset.price);

    let total = qty * price;

    document.getElementById("totalPrice").innerHTML =
        "Tổng: " + total.toLocaleString('vi-VN') + "₫";
}

/* toast */
function showToast(msg){

    let toast = document.getElementById("toast");

    toast.innerHTML = msg;

    toast.style.display = "block";

    setTimeout(() => {
        toast.style.display = "none";
    }, 2500);
}

/* add cart */
function addToCart(id){

    let qty =
        parseInt(document.getElementById("qty").value) || 1;

    fetch("add.php?id=" + id + "&qty=" + qty)

    .then(res => res.text())

    .then(() => {

        showToast("✅ Đã thêm " + qty + " sản phẩm vào giỏ");

    });

}

/* buy now */
function buyNow(id){

    let qty =
        parseInt(document.getElementById("qty").value) || 1;

    window.location.href =
        "buy.php?id=" + id + "&qty=" + qty;
}

updatePrice();

</script>

</body>
</html>
