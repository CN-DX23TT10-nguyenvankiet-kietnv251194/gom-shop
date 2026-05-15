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
    linear-gradient(135deg,#ee4d2d,#ff784e,#ff5e62);

    padding:16px 35px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    position:sticky;
    top:0;
    z-index:999;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.08);
}

.logo{

    font-size:30px;
    color:#fff;
    font-weight:700;
}

/* MENU */
.menu{

    display:flex;
    gap:12px;
}

.menu a{

    color:#fff;
    text-decoration:none;

    padding:10px 16px;

    border-radius:12px;

    transition:0.3s;

    background:
    rgba(255,255,255,0.12);
}

.menu a:hover{

    transform:
    translateY(-3px);

    background:
    rgba(255,255,255,0.2);
}

/* =========================
   CONTAINER
========================= */
.admin-container{

    width:95%;
    max-width:1300px;

    margin:35px auto;
}

/* TITLE */
.admin-title{

    font-size:32px;
    font-weight:700;

    margin-bottom:25px;

    color:#ee4d2d;
}

/* =========================
   FORM BOX
========================= */
.admin-form{

    display:flex;
    justify-content:center;

    margin-bottom:45px;
}

.admin-form form{

    width:460px;

    background:
    rgba(255,255,255,0.92);

    backdrop-filter:blur(12px);

    padding:30px;

    border-radius:24px;

    box-shadow:
    0 15px 35px rgba(0,0,0,0.08);

    position:relative;

    overflow:hidden;
}

.admin-form form::before{

    content:"";

    position:absolute;

    width:180px;
    height:180px;

    background:
    rgba(238,77,45,0.08);

    border-radius:50%;

    top:-60px;
    right:-60px;
}

.admin-form input{

    width:100%;

    padding:15px 16px;

    margin-bottom:15px;

    border:
    1px solid #e5e5e5;

    border-radius:14px;

    outline:none;

    font-size:14px;

    transition:0.3s;

    background:#fafafa;

    position:relative;
    z-index:2;
}

.admin-form input:focus{

    border-color:#ee4d2d;

    background:#fff;

    box-shadow:
    0 0 0 4px rgba(238,77,45,0.08);
}

/* BUTTON */
.btn{

    background:
    linear-gradient(135deg,#ee4d2d,#ff784e);

    color:#fff;

    border:none;

    padding:15px;

    width:100%;

    border-radius:16px;

    cursor:pointer;

    font-size:16px;
    font-weight:600;

    transition:0.3s;

    position:relative;
    z-index:2;
}

.btn:hover{

    transform:
    translateY(-3px);

    box-shadow:
    0 12px 24px rgba(238,77,45,0.25);
}

/* =========================
   PRODUCT GRID
========================= */
.container{

    display:grid;

    grid-template-columns:
    repeat(auto-fill,minmax(250px,1fr));

    gap:24px;
}

/* CARD */
.product{

    background:#fff;

    border-radius:24px;

    overflow:hidden;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.06);

    transition:0.35s;

    position:relative;
}

.product:hover{

    transform:
    translateY(-10px)
    scale(1.02);

    box-shadow:
    0 18px 40px rgba(0,0,0,0.15);
}

/* IMAGE */
.product img{

    width:100%;
    height:240px;

    object-fit:cover;

    transition:0.5s;
}

.product:hover img{

    transform:scale(1.08);
}

/* INFO */
.product h3{

    padding:16px 16px 8px;

    font-size:17px;

    min-height:60px;

    line-height:1.5;
}

/* PRICE */
.price{

    padding:0 16px;

    color:#ee4d2d;

    font-weight:700;

    font-size:24px;
}

/* STOCK */
.stock{

    padding:8px 16px 16px;

    color:#555;

    font-size:14px;
}

/* DELETE BUTTON */
.btn-danger{

    display:block;

    margin:0 16px 18px;

    text-align:center;

    background:
    linear-gradient(135deg,#ff0033,#ff4d6d);

    color:#fff;

    padding:12px;

    border-radius:14px;

    text-decoration:none;

    font-weight:600;

    transition:0.3s;
}

.btn-danger:hover{

    transform:
    translateY(-3px);

    box-shadow:
    0 10px 20px rgba(255,0,51,0.25);
}

/* =========================
   SECTION TITLE
========================= */
.section-title{

    font-size:28px;

    margin-bottom:22px;

    color:#222;
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

    .admin-form form{

        width:100%;
    }

    .container{

        grid-template-columns:
        repeat(auto-fill,minmax(180px,1fr));
    }

    .product img{

        height:190px;
    }
}

</style>
</head>

<body>

<div class="header">

    <div class="logo">
        ⚙️ Quản lý Gốm Shop
    </div>

    <div class="menu">

        <a href="index.php">
            🏠 Trang chủ
        </a>

        <a href="orders.php">
            📦 Đơn hàng
        </a>

        <a href="admin.php">
            ⚙️ Quản lý
        </a>

    </div>

</div>

<div class="admin-container">

<div class="admin-title">
    ➕ Thêm sản phẩm gốm
</div>

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

<!-- FORM -->
<div class="admin-form">

<form method="POST" enctype="multipart/form-data">

    <input
        name="name"
        placeholder="🏺 Tên gốm (VD: Bình cổ Bát Tràng)"
        required
    >

    <input
        name="price"
        type="number"
        placeholder="💰 Giá sản phẩm"
        required
    >

    <input
        name="stock"
        type="number"
        placeholder="📦 Tồn kho ban đầu"
        value="0"
        required
    >

    <input
        type="file"
        name="img"
        required
    >

    <button class="btn" name="add">
        ➕ Thêm sản phẩm
    </button>

</form>

</div>

<div class="section-title">
    🏺 Danh sách gốm
</div>

<!-- PRODUCTS -->
<div class="container">

<?php
$res = $conn->query("SELECT * FROM products ORDER BY id DESC");

while($p = $res->fetch_assoc()):
?>

<div class="product">

    <img src="uploads/<?= htmlspecialchars($p['image']) ?>">

    <h3>
        <?= htmlspecialchars($p['name']) ?>
    </h3>

    <p class="price">
        <?= number_format($p['price']) ?>₫
    </p>

    <p class="stock">
        📦 Tồn kho:
        <b><?= (int)$p['stock'] ?></b>
    </p>

    <a class="btn-danger"
       href="delete.php?id=<?= $p['id'] ?>"
       onclick="return confirm('Xóa sản phẩm này?')">

        🗑 Xóa sản phẩm

    </a>

</div>

<?php endwhile; ?>

</div>

</div>

</body>
</html>
