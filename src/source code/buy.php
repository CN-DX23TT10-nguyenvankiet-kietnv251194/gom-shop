<?php
session_start();
include "config.php";

$id  = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;

if($id <= 0){
    die("Sản phẩm không hợp lệ");
}

$rs = $conn->query("SELECT * FROM products WHERE id=$id");

if(!$rs || $rs->num_rows == 0){
    die("Không tìm thấy sản phẩm");
}

$p = $rs->fetch_assoc();

if($qty < 1){
    $qty = 1;
}

if($qty > $p['stock']){
    $qty = $p['stock'];
}

$total = $p['price'] * $qty;

/* XÁC NHẬN ĐẶT HÀNG */
if(isset($_POST['order'])){

    $conn->begin_transaction();

    try{

        $sqlOrder = "
        INSERT INTO orders(
            customer,
            phone,
            type,
            status
        )
        VALUES(
            'Khách lẻ',
            '0000000000',
            'ban',
            'Chờ xác nhận'
        )";

        $conn->query($sqlOrder);

        $order_id = $conn->insert_id;

        $sqlItem = "
        INSERT INTO order_items(
            order_id,
            product_id,
            qty
        )
        VALUES(
            $order_id,
            {$p['id']},
            $qty
        )";

        $conn->query($sqlItem);

        $newStock = $p['stock'] - $qty;

        $conn->query("
        UPDATE products
        SET stock = $newStock
        WHERE id = {$p['id']}
        ");

        $conn->commit();

        echo "
        <script>
            alert('🎉 Đặt hàng thành công!');
            window.location='index.php';
        </script>
        ";
        exit;

    }catch(Exception $e){

        $conn->rollback();

        echo "
        <script>
            alert('Có lỗi xảy ra khi đặt hàng!');
        </script>
        ";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Mua ngay</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, Helvetica, sans-serif;
    background:#f5f5f5;
}

.container{
    max-width:1100px;
    margin:40px auto;
    display:flex;
    gap:30px;
}

.left,
.right{
    background:#fff;
    border-radius:18px;
    padding:25px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.left{
    width:42%;
}

.right{
    flex:1;
}

.product-img{
    width:100%;
    border-radius:15px;
}

.name{
    font-size:32px;
    font-weight:bold;
    margin-bottom:15px;
}

.price{
    color:#ee4d2d;
    font-size:36px;
    font-weight:bold;
    margin-bottom:15px;
}

.badge{
    display:inline-block;
    background:#e8fff0;
    color:#16a34a;
    padding:10px 15px;
    border-radius:999px;
    margin-bottom:20px;
    font-weight:bold;
}

.info{
    line-height:2;
    font-size:18px;
}

.total{
    margin-top:20px;
    background:#fff3f1;
    border:2px solid #ffd3ca;
    padding:20px;
    border-radius:12px;
    font-size:28px;
    color:#ee4d2d;
    font-weight:bold;
}

.btn{
    width:100%;
    margin-top:25px;
    border:none;
    padding:18px;
    border-radius:14px;
    background:linear-gradient(
        45deg,
        #ee4d2d,
        #ff7b42
    );
    color:#fff;
    font-size:20px;
    font-weight:bold;
    cursor:pointer;
}

.btn:hover{
    opacity:.9;
}

.back{
    display:inline-block;
    margin-top:15px;
    text-decoration:none;
    color:#666;
}

@media(max-width:900px){

    .container{
        flex-direction:column;
        padding:15px;
    }

    .left{
        width:100%;
    }

}
</style>

</head>
<body>

<div class="container">

    <div class="left">

        <img
        src="uploads/<?php echo $p['image']; ?>"
        class="product-img">

    </div>

    <div class="right">

        <div class="name">
            <?php echo htmlspecialchars($p['name']); ?>
        </div>

        <div class="badge">
            ✔ Còn <?php echo $p['stock']; ?> sản phẩm
        </div>

        <div class="price">
            <?php echo number_format($p['price']); ?>₫
        </div>

        <div class="info">
            <p><b>Số lượng:</b> <?php echo $qty; ?></p>
            <p><b>Mã sản phẩm:</b> #<?php echo $p['id']; ?></p>
        </div>

        <div class="total">
            Tổng tiền:
            <?php echo number_format($total); ?>₫
        </div>

        <form method="post">

            <button
            type="submit"
            name="order"
            class="btn">

                🛍 XÁC NHẬN ĐẶT HÀNG

            </button>

        </form>

        <a href="index.php" class="back">
            ← Quay lại trang chủ
        </a>

    </div>

</div>

</body>
</html>