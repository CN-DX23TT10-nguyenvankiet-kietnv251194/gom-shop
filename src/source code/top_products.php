<?php
include "config.php";

$sql = mysqli_query($conn,"
SELECT
    p.id,
    p.name,
    p.image,
    p.price,
    p.stock,
    SUM(oi.qty) AS sold,
    SUM(oi.qty * p.price) AS revenue
FROM order_items oi
JOIN products p ON p.id = oi.product_id
GROUP BY p.id
ORDER BY sold DESC
");

$data = [];
$totalSold = 0;
$totalRevenue = 0;

while($row = mysqli_fetch_assoc($sql)){

    $totalSold += $row['sold'];
    $totalRevenue += $row['revenue'];

    $data[] = $row;
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Top sản phẩm bán chạy</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:linear-gradient(135deg,#fff3ee,#fff8f5,#ffffff);
    min-height:100vh;
    padding:40px 20px;
}

.container{
    max-width:1300px;
    margin:auto;
}

.back{
    display:inline-block;
    margin-bottom:20px;
    text-decoration:none;
    background:#ee4d2d;
    color:#fff;
    padding:12px 20px;
    border-radius:12px;
    font-weight:600;
}

.header{
    background:linear-gradient(135deg,#ee4d2d,#ff784e);
    color:#fff;
    padding:35px;
    border-radius:30px;
    text-align:center;
    margin-bottom:30px;
    box-shadow:0 15px 40px rgba(238,77,45,.25);
}

.header h1{
    font-size:38px;
}

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    margin-bottom:35px;
}

.stat-box{
    background:#fff;
    border-radius:20px;
    padding:25px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.stat-box h2{
    color:#ee4d2d;
    margin-bottom:10px;
}

.products{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:25px;
}

.card-wrap{
    position:relative;
}

.rank{
    position:absolute;
    top:15px;
    left:15px;
    color:#fff;
    padding:8px 15px;
    border-radius:30px;
    font-weight:700;
    z-index:2;
}

.gold{
    background:#f5b301;
}

.silver{
    background:#9e9e9e;
}

.bronze{
    background:#cd7f32;
}

.normal{
    background:#ff784e;
}

.card{
    background:#fff;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    transition:.3s;
}

.card:hover{
    transform:translateY(-8px);
    box-shadow:0 20px 35px rgba(0,0,0,.12);
}

.card img{
    width:100%;
    height:220px;
    object-fit:cover;
}

.content{
    padding:20px;
}

.name{
    font-size:20px;
    font-weight:700;
    margin-bottom:10px;
}

.price{
    color:#ee4d2d;
    font-size:20px;
    font-weight:700;
    margin-bottom:10px;
}

.info{
    line-height:1.9;
    color:#555;
}

.revenue{
    color:#28a745;
    font-weight:700;
}

</style>
</head>

<body>

<div class="container">

<a href="admin.php" class="back">
← Quay lại Quản Lý
</a>

<div class="header">
    <h1>🔥 TOP SẢN PHẨM BÁN CHẠY</h1>
</div>

<div class="stats">

    <div class="stat-box">
        <h2><?= $totalSold ?></h2>
        <p>Tổng sản phẩm đã bán</p>
    </div>

    <div class="stat-box">
        <h2><?= count($data) ?></h2>
        <p>Mặt hàng bán được</p>
    </div>

    <div class="stat-box">
        <h2><?= number_format($totalRevenue) ?>₫</h2>
        <p>Tổng doanh thu</p>
    </div>

</div>

<div class="products">

<?php
$rank = 1;

foreach($data as $r):

$class = "normal";
$title = "#".$rank;

if($rank == 1){
    $class = "gold";
    $title = "🥇 TOP 1";
}
elseif($rank == 2){
    $class = "silver";
    $title = "🥈 TOP 2";
}
elseif($rank == 3){
    $class = "bronze";
    $title = "🥉 TOP 3";
}

$percent = $totalSold > 0
? round(($r['sold']/$totalSold)*100,2)
: 0;
?>

<div class="card-wrap">

<div class="rank <?= $class ?>">
<?= $title ?>
</div>

<div class="card">

<img src="uploads/<?= htmlspecialchars($r['image']) ?>">

<div class="content">

<div class="name">
<?= htmlspecialchars($r['name']) ?>
</div>

<div class="price">
<?= number_format($r['price']) ?>₫
</div>

<div class="info">

📦 Tồn kho:
<b><?= $r['stock'] ?></b>

<br>

🔥 Đã bán:
<b><?= $r['sold'] ?></b>

<br>

📊 Tỷ lệ bán:
<b><?= $percent ?>%</b>

<br>

💰 Doanh thu:

<span class="revenue">
<?= number_format($r['revenue']) ?>₫
</span>

</div>

</div>

</div>

</div>

<?php
$rank++;
endforeach;
?>

</div>

</div>

</body>
</html>