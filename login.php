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
<html lang="vi">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Đăng nhập</title>

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

    overflow:hidden;

    background:
    linear-gradient(135deg,#fff3ee,#fff8f5,#ffffff);

    position:relative;
}

/* BACKGROUND EFFECT */
body::before{

    content:"";

    position:absolute;

    width:420px;
    height:420px;

    background:
    rgba(238,77,45,0.12);

    border-radius:50%;

    top:-120px;
    left:-120px;

    filter:blur(8px);
}

body::after{

    content:"";

    position:absolute;

    width:350px;
    height:350px;

    background:
    rgba(255,115,55,0.12);

    border-radius:50%;

    bottom:-100px;
    right:-100px;

    filter:blur(8px);
}

/* =========================
   LOGIN BOX
========================= */
.box{

    width:390px;

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
        translateY(30px);
    }

    to{
        opacity:1;
        transform:
        translateY(0);
    }
}

/* TITLE */
h2{

    text-align:center;

    margin-bottom:25px;

    font-size:32px;

    color:#ee4d2d;

    font-weight:700;
}

/* MESSAGE */
.msg{

    background:
    linear-gradient(135deg,#ffeaea,#fff5f5);

    color:#ff0033;

    padding:12px;

    margin-bottom:18px;

    border-radius:14px;

    font-size:14px;

    text-align:center;

    border:
    1px solid rgba(255,0,51,0.1);
}

/* =========================
   INPUT
========================= */
input{

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

input:focus{

    border-color:#ee4d2d;

    background:#fff;

    box-shadow:
    0 0 0 4px rgba(238,77,45,0.08);
}

/* =========================
   BUTTON
========================= */
button{

    width:100%;

    padding:15px;

    border:none;

    background:
    linear-gradient(135deg,#ee4d2d,#ff784e);

    color:#fff;

    cursor:pointer;

    border-radius:18px;

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
    0 18px 30px rgba(238,77,45,0.28);
}

/* =========================
   BACK BUTTON
========================= */
.back-home{

    display:block;

    text-align:center;

    margin-top:14px;

    padding:14px;

    background:
    linear-gradient(135deg,#2d7dff,#4da3ff);

    color:#fff;

    border-radius:18px;

    text-decoration:none;

    font-weight:600;

    transition:0.3s;

    box-shadow:
    0 10px 22px rgba(45,125,255,0.18);
}

.back-home:hover{

    transform:
    translateY(-4px);

    box-shadow:
    0 16px 28px rgba(45,125,255,0.25);
}

/* REGISTER LINK */
.register{

    display:block;

    margin-top:22px;

    text-align:center;

    color:#666;

    text-decoration:none;

    font-size:14px;

    transition:0.3s;
}

.register:hover{

    color:#ee4d2d;
}

/* ICON TOP */
.icon{

    width:80px;
    height:80px;

    margin:0 auto 18px;

    border-radius:50%;

    background:
    linear-gradient(135deg,#ee4d2d,#ff784e);

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:36px;

    color:#fff;

    box-shadow:
    0 15px 30px rgba(238,77,45,0.22);
}

/* =========================
   MOBILE
========================= */
@media(max-width:500px){

    body{
        padding:20px;
    }

    .box{

        width:100%;

        padding:28px;
    }

    h2{

        font-size:28px;
    }
}

</style>

</head>

<body>

<div class="box">

    <div class="icon">
        🔐
    </div>

    <h2>
        Đăng nhập
    </h2>

    <?php if($msg != ""): ?>

    <div class="msg">
        <?php echo $msg; ?>
    </div>

    <?php endif; ?>

    <form method="POST">

        <input
            type="text"
            name="username"
            placeholder="👤 Tên tài khoản"
        >

        <input
            type="password"
            name="password"
            placeholder="🔑 Mật khẩu"
        >

        <button name="login">

            🚀 Đăng nhập

        </button>

    </form>

    <!-- NÚT TRỞ VỀ -->
    <a class="back-home" href="index.php">

        ⬅ Trở về trang chủ

    </a>

    <!-- ĐĂNG KÝ -->
    <a class="register" href="register.php">

        Chưa có tài khoản? Đăng ký

    </a>

</div>

</body>
</html>
