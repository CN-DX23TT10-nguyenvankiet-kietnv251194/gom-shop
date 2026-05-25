<?php

include "config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =========================
   TYPE
========================= */

$type = $_GET['type'] ?? 'ban';

if(!in_array($type,['ban','nhap'])){
    $type = 'ban';
}

$message = "";

/* =========================
   SUBMIT
========================= */

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $customer   = trim($_POST['customer'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $product_id = (int)($_POST['product_id'] ?? 0);
    $qty        = (int)($_POST['qty'] ?? 0);

    /* loại đơn */
    $type = $_POST['type'] ?? 'ban';

    if($customer != "" && $product_id > 0 && $qty > 0){

        /* =========================
           1. TẠO ĐƠN
        ========================== */

        $stmt = $conn->prepare("
            INSERT INTO orders(customer, phone, type)
            VALUES(?,?,?)
        ");

        $stmt->bind_param("sss", $customer, $phone, $type);
        $stmt->execute();

        $order_id = $conn->insert_id;

        /* =========================
           2. THÊM ITEM
        ========================== */

        $stmt2 = $conn->prepare("
            INSERT INTO order_items(order_id, product_id, qty)
            VALUES(?,?,?)
        ");

        $stmt2->bind_param("iii", $order_id, $product_id, $qty);
        $stmt2->execute();

        /* =========================
           3. CẬP NHẬT TỒN KHO
        ========================== */

        if($type == "ban"){

            // bán => trừ kho
            $conn->query("
                UPDATE products
                SET stock = stock - $qty
                WHERE id = $product_id
            ");

        }else{

            // nhập => cộng kho
            $conn->query("
                UPDATE products
                SET stock = stock + $qty
                WHERE id = $product_id
            ");
        }

        /* DONE */
        header("Location: orders.php?type=".$type);
        exit;

    }else{
        $message = "Vui lòng nhập đầy đủ thông tin!";
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tạo đơn hàng</title>

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

    min-height:100vh;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:30px;

    background:
    linear-gradient(135deg,#fff8f2,#f5f9ff,#ffffff);

    overflow:hidden;

    position:relative;
}

/* BG EFFECT */
body::before{

    content:"";

    position:absolute;

    width:420px;
    height:420px;

    background:
    rgba(238,77,45,0.10);

    border-radius:50%;

    top:-120px;
    right:-120px;

    filter:blur(10px);
}

body::after{

    content:"";

    position:absolute;

    width:320px;
    height:320px;

    background:
    rgba(45,125,255,0.10);

    border-radius:50%;

    bottom:-100px;
    left:-100px;

    filter:blur(10px);
}

/* =========================
   BOX
========================= */
.box{

    width:430px;

    background:
    rgba(255,255,255,0.92);

    backdrop-filter:blur(12px);

    padding:35px;

    border-radius:28px;

    box-shadow:
    0 20px 45px rgba(0,0,0,0.08);

    position:relative;

    z-index:2;

    animation:fadeUp 0.5s ease;
}

/* ANIMATION */
@keyframes fadeUp{

    from{
        opacity:0;
        transform:
        translateY(25px);
    }

    to{
        opacity:1;
        transform:
        translateY(0);
    }
}

/* TITLE */
h3{

    text-align:center;

    margin-bottom:25px;

    font-size:30px;

    color:#ee4d2d;

    font-weight:700;
}

/* ALERT */
.alert{

    background:
    linear-gradient(135deg,#ffeaea,#fff5f5);

    color:#ff0033;

    padding:14px;

    margin-bottom:18px;

    border-radius:14px;

    border:
    1px solid rgba(255,0,51,0.12);

    font-size:14px;
}

/* =========================
   FORM
========================= */
form{

    display:flex;
    flex-direction:column;
}

/* INPUT */
input,
select{

    width:100%;

    padding:15px 16px;

    margin-bottom:16px;

    border:
    1px solid #e5e5e5;

    border-radius:16px;

    outline:none;

    font-size:14px;

    transition:0.3s;

    background:#fafafa;
}

input:focus,
select:focus{

    border-color:#ee4d2d;

    background:#fff;

    box-shadow:
    0 0 0 4px rgba(238,77,45,0.08);
}

/* BUTTON */
button{

    width:100%;

    padding:16px;

    background:
    linear-gradient(135deg,#ee4d2d,#ff784e);

    color:#fff;

    border:none;

    border-radius:18px;

    cursor:pointer;

    font-size:16px;
    font-weight:600;

    transition:0.3s;

    box-shadow:
    0 12px 24px rgba(238,77,45,0.2);
}

button:hover{

    transform:
    translateY(-4px);

    box-shadow:
    0 18px 30px rgba(238,77,45,0.3);
}

/* BACK */
.back{

    display:block;

    text-align:center;

    margin-top:18px;

    color:#666;

    text-decoration:none;

    transition:0.3s;

    font-size:14px;
}

.back:hover{

    color:#ee4d2d;

    transform:
    translateX(-3px);
}

/* =========================
   MOBILE
========================= */
@media(max-width:500px){

    .box{

        width:100%;

        padding:28px;
    }

    h3{

        font-size:24px;
    }
}

</style>

</head>
<body>

<div class="box">

    <h3>

        <?= $type=='ban'
        ? '🛒 Tạo đơn bán'
        : '📥 Tạo đơn nhập' ?>

    </h3>

    <?php if($message != ""): ?>

        <div class="alert">
            <?= $message ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <!-- TYPE -->
        <select name="type" required>

            <option value="ban"
                <?= $type=='ban'?'selected':'' ?>>

                🛒 Đơn bán

            </option>

            <option value="nhap"
                <?= $type=='nhap'?'selected':'' ?>>

                📥 Đơn nhập

            </option>

        </select>

        <!-- CUSTOMER -->
        <input
            name="customer"
            placeholder="👤 Tên khách / nhà cung cấp"
            required
        >

        <!-- PHONE -->
        <input
            name="phone"
            placeholder="📞 Số điện thoại"
        >

        <!-- PRODUCT -->
        <select name="product_id" required>

            <option value="">
                -- Chọn sản phẩm --
            </option>

            <?php
            $res = $conn->query("
                SELECT id,name
                FROM products
                ORDER BY id DESC
            ");

            while($p = $res->fetch_assoc()):
            ?>

            <option value="<?= $p['id'] ?>">

                <?= htmlspecialchars($p['name']) ?>

            </option>

            <?php endwhile; ?>

        </select>

        <!-- QTY -->
        <input
            type="number"
            name="qty"
            min="1"
            value="1"
            required
        >

        <!-- BUTTON -->
        <button type="submit">

            <?= $type=='ban'
            ? '🛒 Tạo đơn bán'
            : '📥 Tạo đơn nhập' ?>

        </button>

    </form>

    <a class="back" href="orders.php?type=<?= $type ?>">

        ← Quay lại danh sách đơn

    </a>

</div>

</body>
</html>
