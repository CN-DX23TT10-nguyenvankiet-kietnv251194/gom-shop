<?php
session_start();

unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Đặt hàng thành công</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;

    background:linear-gradient(135deg,#f6f9fc,#fff1eb);
}

.box{
    text-align:center;

    background:#fff;
    padding:50px 40px;

    border-radius:28px;

    box-shadow:0 15px 40px rgba(0,0,0,0.08);

    max-width:500px;
    width:90%;
    animation:fadeIn 0.6s ease;
}

@keyframes fadeIn{
    from{
        transform:translateY(20px);
        opacity:0;
    }
    to{
        transform:translateY(0);
        opacity:1;
    }
}

.icon{
    font-size:80px;
    margin-bottom:20px;
}

h2{
    font-size:28px;
    color:#111827;
    margin-bottom:10px;
}

p{
    color:#6b7280;
    margin-bottom:25px;
    line-height:1.6;
}

.info{
    background:#f9fafb;
    padding:15px;
    border-radius:16px;
    margin-bottom:25px;
    font-size:14px;
    color:#555;
}

.btn{
    display:inline-block;

    padding:14px 22px;

    border-radius:14px;

    text-decoration:none;

    font-weight:600;

    transition:0.3s;
}

.btn-primary{
    background:linear-gradient(135deg,#ee4d2d,#ff7337);
    color:#fff;
    margin-right:10px;
}

.btn-secondary{
    background:#eef2ff;
    color:#4f46e5;
}

.btn:hover{
    transform:translateY(-3px);
}

</style>

</head>

<body>

<div class="box">

    <div class="icon">🎉</div>

    <h2>Đặt hàng thành công!</h2>

    <p>
        Cảm ơn bạn đã mua hàng tại <b>Gốm Shop</b>.<br>
        Đơn hàng của bạn đang được xử lý và sẽ sớm được giao.
    </p>

    <div class="info">
        📦 Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng trong thời gian sớm nhất.
    </div>

    <a href="index.php" class="btn btn-primary">
        🏠 Về trang chủ
    </a>

    <a href="shop.php" class="btn btn-secondary">
        🛍️ Tiếp tục mua sắm
    </a>

</div>

</body>

</html>