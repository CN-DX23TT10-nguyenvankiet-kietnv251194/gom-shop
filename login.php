<?php
include "config.php";

/* đảm bảo session */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$msg = "";

if(isset($_POST['login'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $res = $conn->query("
        SELECT * FROM users
        WHERE username='$username'
    ");

    if($res->num_rows > 0){

        $user = $res->fetch_assoc();

        if(password_verify($password, $user['password'])){

            $_SESSION['user'] = $user['username'];

            header("Location: index.php");
            exit();

        }else{
            $msg = "Sai mật khẩu";
        }

    }else{
        $msg = "Tài khoản không tồn tại";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Đăng nhập</title>

<style>

body{
    font-family:Arial;
    background:#f5f5f5;
}

.box{
    width:350px;
    background:#fff;
    margin:100px auto;
    padding:30px;
    border-radius:10px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ddd;
    border-radius:8px;
    outline:none;
}

button{
    width:100%;
    padding:12px;
    border:none;
    background:#ee4d2d;
    color:#fff;
    cursor:pointer;
    border-radius:8px;
    font-weight:600;
}

.msg{
    color:red;
    margin-bottom:15px;
}

/* BACK BUTTON */
.back-home{
    display:block;
    text-align:center;
    margin-top:12px;
    padding:10px;
    background:#2d7dff;
    color:#fff;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
    transition:0.2s;
}

.back-home:hover{
    background:#1f5ed6;
}

a{
    text-decoration:none;
    color:#ee4d2d;
}

</style>

</head>
<body>

<div class="box">

    <h2>Đăng nhập</h2>

    <div class="msg">
        <?php echo $msg; ?>
    </div>

    <form method="POST">

        <input type="text" name="username" placeholder="Tên tài khoản">

        <input type="password" name="password" placeholder="Mật khẩu">

        <button name="login">
            Đăng nhập
        </button>

    </form>

    <!-- NÚT TRỞ VỀ TRANG CHỦ -->
    <a class="back-home" href="index.php">
        ⬅ Trở về trang chủ
    </a>

    <br>

    <a href="register.php">
        Chưa có tài khoản? Đăng ký
    </a>

</div>

</body>
</html>