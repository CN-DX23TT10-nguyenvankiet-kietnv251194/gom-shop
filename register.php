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
<html lang="vi">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Đăng ký</title>

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

/* BG EFFECT */
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
   REGISTER BOX
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

/* ICON */
.icon{

    width:85px;
    height:85px;

    margin:0 auto 18px;

    border-radius:50%;

    background:
    linear-gradient(135deg,#ee4d2d,#ff784e);

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:38px;

    color:#fff;

    box-shadow:
    0 15px 30px rgba(238,77,45,0.22);
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

    margin-bottom:18px;

    text-align:center;

    padding:14px;

    border-radius:14px;

    font-size:14px;

    border:
    1px solid transparent;
}

.error{

    background:
    linear-gradient(135deg,#ffeaea,#fff5f5);

    color:#ff0033;

    border-color:
    rgba(255,0,51,0.1);
}

.success{

    background:
    linear-gradient(135deg,#e9ffef,#f6fff7);

    color:#009933;

    border-color:
    rgba(0,153,51,0.1);
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
    0 18px 30px rgba(238,77,45,0.28);
}

/* BACK HOME */
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

/* LOGIN LINK */
.link{

    text-align:center;

    margin-top:22px;
}

.link a{

    text-decoration:none;

    color:#666;

    font-size:14px;

    transition:0.3s;
}

.link a:hover{

    color:#ee4d2d;
}

/* MOBILE */
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
        📝
    </div>

    <h2>
        Đăng ký
    </h2>

    <?php if($msg != ""): ?>

        <div class="msg <?php echo $success ? 'success' : 'error'; ?>">

            <?php echo $msg; ?>

        </div>

    <?php endif; ?>

    <form method="POST">

        <input
            type="text"
            name="username"
            placeholder="👤 Tên đăng nhập"
        >

        <input
            type="password"
            name="password"
            placeholder="🔑 Mật khẩu"
        >

        <button name="register">

            🚀 Đăng ký tài khoản

        </button>

    </form>

    <!-- BACK HOME -->
    <a class="back-home" href="index.php">

        ⬅ Trở về trang chủ

    </a>

    <!-- LOGIN -->
    <div class="link">

        <a href="login.php">

            Đã có tài khoản? Đăng nhập

        </a>

    </div>

</div>

</body>
</html>
