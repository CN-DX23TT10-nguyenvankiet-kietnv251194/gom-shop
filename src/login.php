
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "config.php";

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

$msg = "";

if(isset($_POST['login'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username'";

    $res = $conn->query($sql);

    if($res->num_rows > 0){

        $user = $res->fetch_assoc();

        if(password_verify($password, $user['password'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user']    = $user['username'];
            $_SESSION['role']    = $user['role'];

            /* ADMIN */
            if($user['role'] == 'admin'){

                header("Location: admin.php");
                exit();

            }

            /* USER */
            else{

                header("Location: index.php");
                exit();
            }

        }else{

            $msg = "❌ Sai mật khẩu!";
        }

    }else{

        $msg = "❌ Tài khoản không tồn tại!";
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

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

/* =========================
   BODY
========================= */
body{

    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    background:
    linear-gradient(
        135deg,
        #fff4ef,
        #fffaf8,
        #ffffff
    );

    padding:20px;

    position:relative;
}

/* =========================
   BACKGROUND EFFECT
========================= */
body::before{

    content:"";

    position:absolute;

    width:350px;
    height:350px;

    background:
    rgba(238,77,45,0.10);

    border-radius:50%;

    top:-120px;
    left:-120px;

    filter:blur(10px);
}

body::after{

    content:"";

    position:absolute;

    width:300px;
    height:300px;

    background:
    rgba(255,120,78,0.08);

    border-radius:50%;

    bottom:-100px;
    right:-100px;

    filter:blur(10px);
}

/* =========================
   BOX
========================= */
.box{

    width:100%;
    max-width:410px;

    background:
    rgba(255,255,255,0.95);

    border-radius:28px;

    padding:40px 35px;

    box-shadow:
    0 15px 40px rgba(0,0,0,0.08);

    position:relative;

    z-index:10;

    animation:fadeUp 0.5s ease;
}

/* =========================
   ANIMATION
========================= */
@keyframes fadeUp{

    from{
        opacity:0;
        transform:
        translateY(20px);
    }

    to{
        opacity:1;
        transform:
        translateY(0);
    }
}

/* =========================
   ICON
========================= */
.icon{

    width:80px;
    height:80px;

    margin:0 auto 18px;

    border-radius:50%;

    background:
    linear-gradient(
        135deg,
        #ee4d2d,
        #ff7a4d
    );

    display:flex;
    justify-content:center;
    align-items:center;

    font-size:34px;

    color:#fff;

    box-shadow:
    0 10px 25px rgba(238,77,45,0.22);
}

/* =========================
   TITLE
========================= */
h2{

    text-align:center;

    color:#ee4d2d;

    font-size:42px;

    margin-bottom:28px;

    font-weight:700;
}

/* =========================
   MESSAGE
========================= */
.msg{

    background:#ffeaea;

    color:#ff0033;

    padding:12px;

    border-radius:14px;

    text-align:center;

    margin-bottom:18px;

    font-size:14px;
}

/* =========================
   INPUT
========================= */
input{

    width:100%;

    padding:16px 18px;

    border:
    1px solid #e5e5e5;

    border-radius:18px;

    margin-bottom:18px;

    font-size:15px;

    background:#fafafa;

    outline:none;

    transition:0.3s;
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

    padding:16px;

    border:none;

    border-radius:18px;

    background:
    linear-gradient(
        135deg,
        #ee4d2d,
        #ff7a4d
    );

    color:#fff;

    font-size:17px;

    font-weight:600;

    cursor:pointer;

    transition:0.3s;

    box-shadow:
    0 10px 22px rgba(238,77,45,0.20);
}

button:hover{

    transform:
    translateY(-3px);

    box-shadow:
    0 16px 28px rgba(238,77,45,0.28);
}

/* =========================
   REGISTER
========================= */
.register{

    display:block;

    text-align:center;

    margin-top:22px;

    color:#666;

    text-decoration:none;

    font-size:14px;

    transition:0.3s;
}

.register:hover{

    color:#ee4d2d;
}

/* =========================
   MOBILE
========================= */
@media(max-width:500px){

    .box{

        padding:35px 25px;
    }

    h2{

        font-size:34px;
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

    <?php if($msg != ""){ ?>

        <div class="msg">
            <?php echo $msg; ?>
        </div>

    <?php } ?>

    <form method="POST">

        <input
            type="text"
            name="username"
            placeholder="👤 Tên tài khoản"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="🔑 Mật khẩu"
            required
        >

        <button name="login">

            🚀 Đăng nhập

        </button>

    </form>

    <a class="register" href="register.php">

        Chưa có tài khoản? Đăng ký

    </a>

</div>

</body>
</html>

