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
<title>Đơn hàng</title>

<style>
body{font-family:Arial;background:#f4f6fb;margin:0;}
.header{background:linear-gradient(135deg,#ee4d2d,#ff7337);padding:15px 40px;color:#fff;display:flex;justify-content:space-between;align-items:center;}
.header b{font-size:20px;}
.menu a{color:#fff;margin-left:15px;text-decoration:none;font-weight:bold;}
.container{width:95%;max-width:1200px;margin:20px auto;}
.box{background:#fff;padding:15px;border-radius:10px;margin-bottom:20px;box-shadow:0 3px 10px rgba(0,0,0,0.06);}
input{padding:10px;border:1px solid #ddd;border-radius:8px;margin-right:10px;margin-bottom:10px;}
.btn{padding:10px 15px;border:none;border-radius:8px;cursor:pointer;color:#fff;text-decoration:none;}
.btn-ban{background:#ee4d2d;}
.btn-nhap{background:#2d7dff;}
.order{background:#fff;padding:15px;border-radius:10px;margin-bottom:15px;box-shadow:0 3px 10px rgba(0,0,0,0.06);}
.item{display:flex;align-items:center;border-bottom:1px solid #eee;padding:10px 0;}
.item img{width:60px;height:60px;object-fit:cover;border-radius:8px;margin-right:12px;}
.price{margin-left:auto;color:#ee4d2d;font-weight:bold;}
.delete{color:red;text-decoration:none;float:right;}
.total{text-align:right;margin-top:10px;font-size:18px;color:#ee4d2d;}
.tabs{margin-bottom:20px;}
.tabs a{padding:10px 15px;border-radius:8px;text-decoration:none;margin-right:10px;background:#ddd;color:#333;}
.tabs .active{background:#ee4d2d;color:#fff;}
.empty{text-align:center;padding:30px;color:#888;}
.stock-badge{font-size:12px;color:#555;}
</style>
</head>

<body>

<div class="header">
    <div><b>🛍 Gốm Shop</b></div>
    <div class="menu">
        <a href="index.php">Trang chủ</a>
        <a href="orders.php">Đơn hàng</a>
    </div>
</div>

<div class="container">

<h2>📦 Quản lý đơn hàng</h2>

<div class="tabs">
    <a class="<?= $type=='ban'?'active':'' ?>" href="orders.php?type=ban">Đơn bán</a>
    <a class="<?= $type=='nhap'?'active':'' ?>" href="orders.php?type=nhap">Đơn nhập</a>
</div>

<div class="box">

<h3><?= $type=='ban'?'➕ Tạo đơn bán':'📥 Tạo đơn nhập' ?></h3>

<form method="POST" action="create_order.php">

    <input type="text" name="customer" placeholder="Tên khách" required>
    <input type="text" name="phone" placeholder="SĐT">
    <input type="hidden" name="type" value="<?= $type ?>">

    <button class="btn <?= $type=='ban'?'btn-ban':'btn-nhap' ?>">Tạo đơn</button>

</form>

</div>

<?php if($orders->num_rows > 0): ?>

<?php while($o = $orders->fetch_assoc()): ?>

<div class="order">

    <a class="delete"
       href="delete_order.php?id=<?= $o['id'] ?>"
       onclick="return confirm('Xóa đơn này?')">🗑</a>

    <b>#<?= $o['id'] ?> - <?= htmlspecialchars($o['customer']) ?> | 📞 <?= htmlspecialchars($o['phone']) ?></b>

    <div style="margin-top:10px;">

    <?php
    $items = $conn->query("
        SELECT p.name,p.price,p.image,p.stock,oi.qty
        FROM order_items oi
        JOIN products p ON p.id = oi.product_id
        WHERE oi.order_id = {$o['id']}
    ");

    $total = 0;

    while($i = $items->fetch_assoc()):

        $price = ($type=='nhap') ? $i['price']*0.5 : $i['price'];
        $subtotal = $price * $i['qty'];
        $total += $subtotal;
    ?>

        <div class="item">

            <img src="uploads/<?= htmlspecialchars($i['image']) ?>">

            <div>
                <b><?= htmlspecialchars($i['name']) ?></b><br>
                SL: <?= $i['qty'] ?><br>
                <span class="stock-badge">Kho hiện tại: <?= $i['stock'] ?></span>
            </div>

            <div class="price">
                <?= number_format($subtotal) ?>₫
            </div>

        </div>

    <?php endwhile; ?>

    </div>

    <div class="total">
        Tổng: <?= number_format($total) ?>₫
    </div>

</div>

<?php endwhile; ?>

<?php else: ?>

<div class="box empty">Chưa có đơn hàng</div>

<?php endif; ?>

</div>

</body>
</html>