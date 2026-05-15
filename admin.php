<?php
session_start();
include "config.php";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Quản lý - Gốm Shop</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#f5f5f5;
}

/* HEADER */
.header{
    background:#ee4d2d;
    padding:14px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    position:sticky;
    top:0;
}

.logo{
    font-size:26px;
    color:#fff;
    font-weight:bold;
}

.menu a{
    color:#fff;
    text-decoration:none;
    margin-left:15px;
}

/* CONTAINER */
.admin-container{
    width:95%;
    margin:30px auto;
}

/* FORM */
.admin-form{
    display:flex;
    justify-content:center;
    margin-bottom:30px;
}

.admin-form form{
    width:420px;
    background:#fff;
    padding:20px;
    border-radius:12px;
}

.admin-form input{
    width:100%;
    padding:12px;
    margin-bottom:12px;
    border:1px solid #ddd;
    border-radius:8px;
}

.btn{
    background:#ee4d2d;
    color:#fff;
    border:none;
    padding:12px;
    width:100%;
    border-radius:8px;
    cursor:pointer;
}

/* PRODUCT GRID */
.container{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
    gap:20px;
}

.product{
    background:#fff;
    border-radius:12px;
    overflow:hidden;
}

.product img{
    width:100%;
    height:220px;
    object-fit:cover;
}

.product h3{
    padding:10px;
    font-size:16px;
}

.price{
    padding:0 10px;
    color:#ee4d2d;
    font-weight:bold;
}

.stock{
    padding:0 10px 10px;
    color:#555;
    font-size:14px;
}

.btn-danger{
    display:inline-block;
    margin:10px;
    background:red;
    color:#fff;
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
}
</style>
</head>

<body>

<div class="header">
    <div class="logo">⚙️ Quản lý Gốm Shop</div>

    <div class="menu">
        <a href="index.php">Trang chủ</a>
        <a href="orders.php">Đơn hàng</a>
        <a href="admin.php">Quản lý</a>
    </div>
</div>

<div class="admin-container">

<h2>➕ Thêm sản phẩm gốm</h2>

<?php
/* ================= ADD PRODUCT ================= */
if(isset($_POST['add'])){

    $name  = trim($_POST['name']);
    $price = (int)$_POST['price'];
    $stock = (int)$_POST['stock'];

    if($stock < 0){
        $stock = 0;
    }

    if(!is_dir("uploads")){
        mkdir("uploads", 0777, true);
    }

    if($_FILES['img']['error'] == 0){

        $img = time() . "_" . $_FILES['img']['name'];

        move_uploaded_file(
            $_FILES['img']['tmp_name'],
            "uploads/".$img
        );

        $stmt = $conn->prepare("
            INSERT INTO products(name,price,image,stock)
            VALUES(?,?,?,?)
        ");

        $stmt->bind_param("sisi",$name,$price,$img,$stock);
        $stmt->execute();
    }
}
?>

<div class="admin-form">

<form method="POST" enctype="multipart/form-data">

    <input name="name" placeholder="Tên gốm (VD: Bình cổ Bát Tràng)" required>

    <input name="price" type="number" placeholder="Giá sản phẩm" required>

    <input name="stock" type="number" placeholder="Tồn kho ban đầu" value="0" required>

    <input type="file" name="img" required>

    <button class="btn" name="add">➕ Thêm sản phẩm</button>

</form>

</div>

<h2>🏺 Danh sách gốm</h2>

<div class="container">

<?php
$res = $conn->query("SELECT * FROM products ORDER BY id DESC");

while($p = $res->fetch_assoc()):
?>

<div class="product">

    <img src="uploads/<?= htmlspecialchars($p['image']) ?>">

    <h3><?= htmlspecialchars($p['name']) ?></h3>

    <p class="price">
        <?= number_format($p['price']) ?>₫
    </p>

    <p class="stock">
        📦 Tồn kho: <b><?= (int)$p['stock'] ?></b>
    </p>

    <a class="btn-danger"
       href="delete.php?id=<?= $p['id'] ?>"
       onclick="return confirm('Xóa sản phẩm này?')">
        🗑 Xóa
    </a>

</div>

<?php endwhile; ?>

</div>

</div>

</body>
</html>