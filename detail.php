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
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Chi tiết sản phẩm</title>

<style>

body{
    font-family:Arial;
    background:linear-gradient(135deg,#f5f6fa,#eef1f7);
    margin:0;
}

/* TOP BAR */
.top-bar{
    width:85%;
    margin:25px auto 10px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.title{
    font-size:18px;
    font-weight:bold;
    color:#333;
}

.back-home{
    padding:8px 14px;
    background:#fff;
    border-radius:10px;
    border:1px solid #ddd;
    text-decoration:none;
    color:#333;
    font-weight:600;
    transition:0.2s;
}

.back-home:hover{
    background:#f2f2f2;
    transform:translateY(-2px);
}

/* WRAPPER */
.wrapper{
    width:85%;
    margin:10px auto 40px;
    display:flex;
    gap:25px;
}

/* CARD */
.left,.right{
    background:#fff;
    padding:22px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,0.06);
    flex:1;
}

/* IMAGE */
.left img{
    width:100%;
    height:400px;
    object-fit:cover;
    border-radius:12px;
    transition:0.3s;
}

.left img:hover{
    transform:scale(1.03);
}

/* NAME */
h2{
    font-size:22px;
    color:#222;
}

/* PRICE */
.price{
    color:#ee4d2d;
    font-size:28px;
    font-weight:bold;
    margin:15px 0;
}

/* QTY */
.qty-box{
    display:flex;
    align-items:center;
    gap:10px;
    margin:15px 0;
}

.qty-box button{
    width:38px;
    height:38px;
    border:none;
    background:#f1f1f1;
    font-size:18px;
    border-radius:8px;
    cursor:pointer;
    transition:0.2s;
}

.qty-box button:hover{
    background:#ddd;
}

.qty-box input{
    width:60px;
    text-align:center;
    padding:6px;
    border:1px solid #ddd;
    border-radius:8px;
}

/* TOTAL */
.total-price{
    font-size:20px;
    font-weight:bold;
    color:#333;
    margin:10px 0 20px;
}

/* BUTTONS */
.btns{
    display:flex;
    gap:12px;
}

.btn{
    flex:1;
    padding:14px;
    border:none;
    border-radius:12px;
    font-weight:bold;
    cursor:pointer;
    transition:0.25s;
}

/* CART */
.cart-btn{
    background:#fff;
    border:2px solid #ee4d2d;
    color:#ee4d2d;
}

.cart-btn:hover{
    background:#ffe9e5;
    transform:translateY(-2px);
}

/* BUY */
.buy-btn{
    background:linear-gradient(45deg,#ee4d2d,#ff7337);
    color:#fff;
}

.buy-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(238,77,45,0.25);
}

/* MOBILE */
@media(max-width:768px){
    .wrapper{
        flex-direction:column;
        width:95%;
    }
}

</style>

</head>

<body>

<div class="top-bar">

    <div class="title">🏺 Chi tiết sản phẩm</div>

    <a href="index.php" class="back-home">⬅ Trang chủ</a>

</div>

<div class="wrapper">

<!-- LEFT -->
<div class="left">
    <img src="uploads/<?php echo $p['image']; ?>">
</div>

<!-- RIGHT -->
<div class="right">

    <h2><?php echo htmlspecialchars($p['name']); ?></h2>

    <div id="basePrice"
         data-price="<?php echo $p['price']; ?>"
         class="price">

        <?php echo number_format($p['price']); ?>₫

    </div>

    <div class="qty-box">

        <button onclick="changeQty(-1)">-</button>

        <input type="number"
               id="qty"
               value="1"
               min="1"
               oninput="updatePrice()">

        <button onclick="changeQty(1)">+</button>

    </div>

    <div class="total-price" id="totalPrice">
        Tổng: <?php echo number_format($p['price']); ?>₫
    </div>

    <div class="btns">

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

/* tăng giảm số lượng */
function changeQty(val){

    let qtyInput = document.getElementById("qty");

    let current = parseInt(qtyInput.value) || 1;

    qtyInput.value = Math.max(1, current + val);

    updatePrice();
}

/* tính tiền */
function updatePrice(){

    let qty = parseInt(document.getElementById("qty").value) || 1;

    let price = parseInt(document.getElementById("basePrice").dataset.price);

    let total = qty * price;

    document.getElementById("totalPrice").innerHTML =
        "Tổng: " + total.toLocaleString('vi-VN') + "₫";
}

/* thêm giỏ */
function addToCart(id){

    let qty = parseInt(document.getElementById("qty").value) || 1;

    fetch("add.php?id=" + id + "&qty=" + qty)

    .then(res => res.text())

    .then(() => {
        alert("Đã thêm " + qty + " sản phẩm vào giỏ!");
    });
}

/* mua ngay */
function buyNow(id){

    let qty = parseInt(document.getElementById("qty").value) || 1;

    window.location.href =
        "buy.php?id=" + id + "&qty=" + qty;
}

/* init */
updatePrice();

</script>

</body>
</html>