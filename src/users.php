<?php
session_start();
include "config.php";

/* TÌM KIẾM */
$keyword = $_GET['keyword'] ?? '';

if($keyword != ''){

    $keyword = mysqli_real_escape_string($conn,$keyword);

    $sql = "
    SELECT *
    FROM users
    WHERE username LIKE '%$keyword%'
    ORDER BY id DESC
    ";

}else{

    $sql = "
    SELECT *
    FROM users
    ORDER BY id DESC
    ";
}

$rs = mysqli_query($conn,$sql);

/* THỐNG KÊ */
$totalUsers = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM users
"))['total'];

$adminCount = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM users
WHERE role='admin'
"))['total'];

$userCount = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM users
WHERE role='user'
"))['total'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quản lý tài khoản</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#f5f7fb;
padding:30px;
}

.container{
max-width:1200px;
margin:auto;
}

.header{
background:linear-gradient(135deg,#ee4d2d,#ff784e);
color:white;
padding:30px;
border-radius:20px;
margin-bottom:25px;
text-align:center;
}

.header h1{
font-size:32px;
}

.top{
display:flex;
gap:15px;
flex-wrap:wrap;
margin-bottom:25px;
}

.card{
background:white;
padding:20px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,.08);
flex:1;
min-width:200px;
text-align:center;
}

.card h2{
color:#ee4d2d;
font-size:30px;
}

.search-box{
background:white;
padding:20px;
border-radius:15px;
margin-bottom:20px;
box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.search-box form{
display:flex;
gap:10px;
flex-wrap:wrap;
}

.search-box input{
flex:1;
padding:12px;
border:1px solid #ddd;
border-radius:10px;
}

.btn{
background:#ee4d2d;
color:white;
border:none;
padding:12px 20px;
border-radius:10px;
cursor:pointer;
text-decoration:none;
}

.back{
display:inline-block;
margin-bottom:20px;
}

.table-box{
background:white;
border-radius:20px;
overflow:auto;
box-shadow:0 5px 15px rgba(0,0,0,.08);
}

table{
width:100%;
border-collapse:collapse;
}

th{
background:#ee4d2d;
color:white;
padding:15px;
}

td{
padding:15px;
border-bottom:1px solid #eee;
}

.role-admin{
background:#d4edda;
color:#155724;
padding:5px 10px;
border-radius:20px;
font-size:13px;
}

.role-user{
background:#e7f1ff;
color:#0056b3;
padding:5px 10px;
border-radius:20px;
font-size:13px;
}

.action{
padding:7px 12px;
border-radius:8px;
text-decoration:none;
color:white;
font-size:13px;
}

.role-btn{
background:#4f46e5;
}

.delete-btn{
background:#dc3545;
}

</style>
</head>
<body>

<div class="container">

<a href="admin.php" class="btn back">
← Quay lại Quản lý
</a>

<div class="header">
<h1>👥 Quản lý tài khoản</h1>
<p>Quản lý người dùng hệ thống</p>
</div>

<div class="top">

<div class="card">
<h2><?= $totalUsers ?></h2>
<p>Tổng tài khoản</p>
</div>

<div class="card">
<h2><?= $adminCount ?></h2>
<p>Admin</p>
</div>

<div class="card">
<h2><?= $userCount ?></h2>
<p>User</p>
</div>

</div>

<div class="search-box">

<form method="GET">

<input
type="text"
name="keyword"
placeholder="Tìm tên đăng nhập..."
value="<?= htmlspecialchars($keyword) ?>"
>

<button class="btn">
Tìm kiếm
</button>

</form>

</div>

<div class="table-box">

<table>

<thead>
<tr>
<th>ID</th>
<th>Tên đăng nhập</th>
<th>Vai trò</th>
<th>Ngày tạo</th>
<th>Thao tác</th>
</tr>
</thead>

<tbody>

<?php while($u=mysqli_fetch_assoc($rs)): ?>

<tr>

<td>#<?= $u['id'] ?></td>

<td>
<?= htmlspecialchars($u['username']) ?>
</td>

<td>

<?php if($u['role']=="admin"): ?>

<span class="role-admin">
Admin
</span>

<?php else: ?>

<span class="role-user">
User
</span>

<?php endif; ?>

</td>

<td>
<?= $u['created_at'] ?>
</td>

<td>

<a
class="action role-btn"
href="change_role.php?id=<?= $u['id'] ?>"
>
Đổi quyền
</a>

<a
class="action delete-btn"
href="delete_user.php?id=<?= $u['id'] ?>"
onclick="return confirm('Xóa tài khoản này?')"
>
Xóa
</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

</body>
</html>