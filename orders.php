<?php
include "config.php";

/* SESSION */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* loại đơn */
$type = $_GET['type'] ?? 'ban';

if (!in_array($type, ['ban', 'nhap'])) {
    $type = 'ban';
}

/* lấy đơn */
$stmt = $conn->prepare("SELECT * FROM orders WHERE type=? ORDER BY id DESC");
$stmt->bind_param("s", $type);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Đơn hàng</title>

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

body{

    background:
    linear-gradient(135deg,#fff8f2,#f8f4ee,#ffffff);

    min-height:100vh;

    color:#333;
}

/* =========================
   HEADER
========================= */
.header{

    background:
    linear-gradient(135deg,#ee4d2d,#ff7337,#ff5e62);

    padding:16px 40px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    position:sticky;
    top:0;
    z-index:999;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.08);
}

.header b{

    font-size:28px;
    color:#fff;
}

.menu{

    display:flex;
    gap:12px;
}

.menu a{

    color:#fff;

    text-decoration:none;

    padding:10px 16px;

    border-radius:12px;

    font-weight:600;

    transition:0.3s;

    background:
    rgba(255,255,255,0.12);
}

.menu a:hover{

    transform:
    translateY(-3px);

    background:
    rgba(255,255,255,0.22);
}

/* =========================
   CONTAINER
========================= */
.container{

    width:95%;
    max-width:1250px;

    margin:35px auto;
}

.page-title{

    font-size:34px;

    color:#ee4d2d;

    margin-bottom:25px;

    font-weight:700;
}

/* =========================
   TABS
========================= */
.tabs{

    display:flex;

    gap:14px;

    margin-bottom:28px;

    flex-wrap:wrap;
}

.tabs a{

    padding:13px 22px;

    border-radius:16px;

    text-decoration:none;

    font-weight:600;

    transition:0.3s;

    background:#fff;

    color:#555;

    box-shadow:
    0 5px 15px rgba(0,0,0,0.06);
}

.tabs a:hover{

    transform:
    translateY(-3px);
}

.tabs .active{

    background:
    linear-gradient(135deg,#ee4d2d,#ff784e);

    color:#fff;

    box-shadow:
    0 12px 24px rgba(238,77,45,0.25);
}

/* =========================
   FORM BOX
========================= */
.box{

    background:
    rgba(255,255,255,0.95);

    backdrop-filter:blur(10px);

    padding:28px;

    border-radius:24px;

    margin-bottom:28px;

    box-shadow:
    0 12px 30px rgba(0,0,0,0.06);
}

.box h3{

    margin-bottom:20px;

    font-size:24px;

    color:#222;
}

form{

    display:flex;

    flex-wrap:wrap;

    gap:15px;
}

input{

    flex:1;

    min-width:220px;

    padding:15px;

    border:
    1px solid #e5e5e5;

    border-radius:14px;

    outline:none;

    font-size:14px;

    transition:0.3s;

    background:#fafafa;
}

input:focus{

    border-color:#ee4d2d;

    background:#fff;

    box-shadow:
    0 0 0 4px rgba(238,77,45,0.08);
}

/* BUTTON */
.btn{

    padding:15px 22px;

    border:none;

    border-radius:14px;

    cursor:pointer;

    color:#fff;

    font-weight:600;

    font-size:15px;

    transition:0.3s;
}

.btn:hover{

    transform:
    translateY(-3px);
}

.btn-ban{

    background:
    linear-gradient(135deg,#ee4d2d,#ff784e);

    box-shadow:
    0 10px 20px rgba(238,77,45,0.2);
}

.btn-nhap{

    background:
    linear-gradient(135deg,#2d7dff,#4da3ff);

    box-shadow:
    0 10px 20px rgba(45,125,255,0.2);
}

/* =========================
   ORDER CARD
========================= */
.order{

    background:#fff;

    padding:25px;

    border-radius:24px;

    margin-bottom:24px;

    box-shadow:
    0 12px 30px rgba(0,0,0,0.06);

    transition:0.3s;

    position:relative;
}

.order:hover{

    transform:
    translateY(-5px);

    box-shadow:
    0 18px 35px rgba(0,0,0,0.12);
}

/* DELETE */
.delete{

    position:absolute;

    top:18px;
    right:18px;

    background:
    linear-gradient(135deg,#ff0033,#ff4d6d);

    color:#fff;

    text-decoration:none;

    width:40px;
    height:40px;

    border-radius:12px;

    display:flex;
    align-items:center;
    justify-content:center;

    transition:0.3s;
}

.delete:hover{

    transform:
    scale(1.08);
}

/* ORDER INFO */
.order-top{

    margin-bottom:20px;

    padding-right:50px;

    line-height:1.8;
}

/* ITEM */
.item{

    display:flex;
    align-items:center;

    gap:16px;

    padding:16px 0;

    border-bottom:
    1px solid #f0f0f0;
}

.item:last-child{

    border-bottom:none;
}

.item img{

    width:75px;
    height:75px;

    object-fit:cover;

    border-radius:18px;

    transition:0.3s;
}

.item:hover img{

    transform:scale(1.05);
}

.item-info{

    flex:1;
}

.item-info b{

    font-size:16px;
}

.stock-badge{

    display:inline-block;

    margin-top:6px;

    padding:5px 10px;

    border-radius:20px;

    background:#f3f3f3;

    font-size:12px;

    color:#555;
}

/* PRICE */
.price{

    color:#ee4d2d;

    font-weight:700;

    font-size:18px;
}

/* TOTAL */
.total{

    text-align:right;

    margin-top:20px;

    font-size:24px;

    color:#ee4d2d;

    font-weight:700;
}

/* EMPTY */
.empty{

    text-align:center;

    padding:50px;

    color:#888;

    font-size:18px;
}

/* =========================
   MOBILE
========================= */
@media(max-width:768px){

    .header{

        flex-direction:column;

        gap:15px;

        text-align:center;
    }

    .menu{

        flex-wrap:wrap;

        justify-content:center;
    }

    form{

        flex-direction:column;
    }

    .item{

        flex-direction:column;

        align-items:flex-start;
    }

    .price{

        margin-top:10px;
    }

    .total{

        text-align:left;
    }
}

</style>
</head>

<body>

<div class="header">

    <div>
        <b>🛍 Gốm Shop</b>
    </div>

    <div class="menu">

        <a href="index.php">
            🏠 Trang chủ
        </a>

        <a href="orders.php">
            📦 Đơn hàng
        </a>

    </div>

</div>

<div class="container">

<div class="page-title">
    📦 Quản lý đơn hàng
</div>

<!-- TABS -->
<div class="tabs">

    <a class="<?= $type=='ban'?'active':'' ?>"
       href="orders.php?type=ban">

       🛒 Đơn bán

    </a>

    <a class="<?= $type=='nhap'?'active':'' ?>"
       href="orders.php?type=nhap">

       📥 Đơn nhập

    </a>

</div>

<!-- FORM -->
<div class="box">

<h3>
<?= $type=='ban'
? '➕ Tạo đơn bán'
: '📥 Tạo đơn nhập' ?>
</h3>

<form method="POST" action="create_order.php">

    <input
        type="text"
        name="customer"
        placeholder="👤 Tên khách"
        required
    >

    <input
        type="text"
        name="phone"
        placeholder="📞 Số điện thoại"
    >

    <input
        type="hidden"
        name="type"
        value="<?= $type ?>"
    >

    <button class="btn <?= $type=='ban'?'btn-ban':'btn-nhap' ?>">

        <?= $type=='ban'
        ? '🛒 Tạo đơn bán'
        : '📥 Tạo đơn nhập' ?>

    </button>

</form>

</div>

<?php if($orders->num_rows > 0): ?>

<?php while($o = $orders->fetch_assoc()): ?>

<div class="order">

    <a class="delete"
       href="delete_order.php?id=<?= $o['id'] ?>"
       onclick="return confirm('Xóa đơn này?')">

       🗑

    </a>

    <div class="order-top">

        <b>
            #<?= $o['id'] ?>
        </b>

        • 👤 <?= htmlspecialchars($o['customer']) ?>

        <?php if($o['phone'] != ""): ?>
            • 📞 <?= htmlspecialchars($o['phone']) ?>
        <?php endif; ?>

    </div>

    <?php
    $items = $conn->query("
        SELECT p.name,p.price,p.image,p.stock,oi.qty
        FROM order_items oi
        JOIN products p ON p.id = oi.product_id
        WHERE oi.order_id = {$o['id']}
    ");

    $total = 0;

    while($i = $items->fetch_assoc()):

        $price = ($type=='nhap')
        ? $i['price']*0.5
        : $i['price'];

        $subtotal = $price * $i['qty'];

        $total += $subtotal;
    ?>

    <div class="item">

        <img src="uploads/<?= htmlspecialchars($i['image']) ?>">

        <div class="item-info">

            <b>
                <?= htmlspecialchars($i['name']) ?>
            </b>

            <br><br>

            📦 Số lượng:
            <?= $i['qty'] ?>

            <br>

            <span class="stock-badge">

                Kho hiện tại:
                <?= $i['stock'] ?>

            </span>

        </div>

        <div class="price">

            <?= number_format($subtotal) ?>₫

        </div>

    </div>

    <?php endwhile; ?>

    <div class="total">

        Tổng:
        <?= number_format($total) ?>₫

    </div>

</div>

<?php endwhile; ?>

<?php else: ?>

<div class="box empty">
    📭 Chưa có đơn hàng
</div>

<?php endif; ?>

</div>

</body>
</html>
