<?php
include "config.php";

$msg = "";
$success = false;

if(isset($_POST['register'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if($username == "" || $password == ""){

        $msg = "Vui lòng nhập đầy đủ";

    }else{

        $username = $conn->real_escape_string($username);

        // CHECK USER
        $check = $conn->query("
            SELECT * FROM users
            WHERE username='$username'
        ");

        if($check->num_rows > 0){

            $msg = "Tài khoản đã tồn tại";

        }else{

            // HASH PASSWORD
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // INSERT
            $insert = $conn->query("
                INSERT INTO users(username,password)
                VALUES('$username','$hash')
            ");

            if($insert){

                $success = true;

                $msg = "Đăng ký thành công! Đang chuyển sang đăng nhập...";

                header("refresh:2;url=login.php");

            }else{

                $msg = "Đăng ký thất bại";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Đăng ký</title>

<style>

body{
    background:#f5f5f5;
    font-family:Arial;
}

.box{
    width:360px;
    background:#fff;
    margin:100px auto;
    padding:30px;
    border-radius:10px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

h2{
    text-align:center;
    margin-bottom:20px;
    color:#333;
}

input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ddd;
    border-radius:6px;
    outline:none;
}

input:focus{
    border-color:#ee4d2d;
}

button{
    width:100%;
    padding:12px;
    border:none;
    background:#ee4d2d;
    color:#fff;
    border-radius:6px;
    cursor:pointer;
    font-size:15px;
    font-weight:bold;
}

button:hover{
    background:#d73211;
}

.msg{
    margin-bottom:15px;
    text-align:center;
    padding:10px;
    border-radius:6px;
    font-size:14px;
}

.error{
    background:#ffe5e5;
    color:#d8000c;
}

.success{
    background:#e5ffe8;
    color:#008000;
}

.link{
    text-align:center;
    margin-top:15px;
}

a{
    text-decoration:none;
    color:#ee4d2d;
}

/* BACK HOME */
.back-home{
    display:block;
    text-align:center;
    margin-top:10px;
    padding:10px;
    background:#2d7dff;
    color:#fff;
    border-radius:6px;
    text-decoration:none;
    font-weight:600;
    transition:0.2s;
}

.back-home:hover{
    background:#1f5ed6;
}

</style>

</head>
<body>

<div class="box">

    <h2>Đăng ký tài khoản</h2>

    <?php if($msg != ""): ?>

        <div class="msg <?php echo $success ? 'success' : 'error'; ?>">

            <?php echo $msg; ?>

        </div>

    <?php endif; ?>

    <form method="POST">

        <input type="text" name="username" placeholder="Tên đăng nhập">

        <input type="password" name="password" placeholder="Mật khẩu">

        <button name="register">
            Đăng ký
        </button>

    </form>

    <!-- BACK HOME -->
    <a class="back-home" href="index.php">
        ⬅ Trở về trang chủ
    </a>

    <div class="link">
        <a href="login.php">
            Đã có tài khoản? Đăng nhập
        </a>
    </div>

</div>

</body>
</html>