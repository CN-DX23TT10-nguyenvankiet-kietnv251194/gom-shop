<?php
session_start();
include "config.php";

// kiểm tra đăng nhập
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$username = $_SESSION['user'];

// lấy user
$user = $conn->query("SELECT * FROM users WHERE username='$username'");
$u = $user->fetch_assoc();

// kiểm tra quyền seller
if($u['role'] != 'seller'){
    echo "<h2>⛔ Bạn không có quyền truy cập trang này</h2>";
    exit;
}

// lấy sản phẩm của seller (nếu có cột user_id)
$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="vi">

<head>
<meta charset="UTF-8">
<title>Seller Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>

body{
    font-family:Poppins;
    background:#f5f7fb;
    padding:30px;
}

.container{
    max-width:1100px;
    margin:auto;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.btn{
    padding:10px 15px;
    background:#ee4d2d;
    color:#fff;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
}

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.card{
    background:#fff;
    border-radius:16px;
    padding:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.card img{
    width:100%;
    height:180px;
    object-fit:cover;
    border-radius:12px;
}

.name{
    font-weight:600;
    margin-top:10px;
}

.price{
    color:#ee4d2d;
    font-weight:700;
    margin:5px 0;
}

.actions{
    display:flex;
    gap:10px;
}

.edit{
    background:#4f46e5;
    color:#fff;
    padding:6px 10px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
}

.delete{
    background:#ff3b30;
    color:#fff;
    padding:6px 10px;
    border-radius:8px;
    text-decoration:none;
    font-size:13px;
}

</style>

</head>

<body>

<div class="container">

<div class="header">

    <h2>🏪 Seller Dashboard</h2>

    <a href="add.php" class="btn">+ Thêm sản phẩm</a>

</div>

<div class="grid">

<?php while($p = $products->fetch_assoc()): ?>

<div class="card">

    <img src="uploads/<?= htmlspecialchars($p['image']) ?>">

    <div class="name">
        <?= htmlspecialchars($p['name']) ?>
    </div>

    <div class="price">
        <?= number_format($p['price']) ?>₫
    </div>

    <div class="actions">

        <a href="edit.php?id=<?= $p['id'] ?>" class="edit">Sửa</a>

        <a href="delete.php?id=<?= $p['id'] ?>" class="delete"
           onclick="return confirm('Xóa sản phẩm?')">
            Xóa
        </a>

    </div>

</div>

<?php endwhile; ?>

</div>

</div>

</body>
</html>