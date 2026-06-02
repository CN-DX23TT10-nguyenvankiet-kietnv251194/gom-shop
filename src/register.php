<?php
include "config.php";

$msg = "";
$success = false;

if(isset($_POST['register'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm_password']);

    if(empty($username) || empty($password) || empty($confirm)){

        $msg = "Vui lòng nhập đầy đủ thông tin";

    }elseif(strlen($password) < 6){

        $msg = "Mật khẩu phải có ít nhất 6 ký tự";

    }elseif($password != $confirm){

        $msg = "Mật khẩu xác nhận không khớp";

    }else{

        $stmt = $conn->prepare(
            "SELECT id FROM users WHERE username=?"
        );

        $stmt->bind_param("s",$username);
        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows > 0){

            $msg = "Tên đăng nhập đã tồn tại";

        }else{

            $hash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "INSERT INTO users(username,password)
                 VALUES(?,?)"
            );

            $stmt->bind_param(
                "ss",
                $username,
                $hash
            );

            if($stmt->execute()){

                $success = true;

                $msg = "Đăng ký thành công!";

                echo "
                <script>
                setTimeout(function(){
                    window.location='login.php';
                },2000);
                </script>
                ";

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

<title>Đăng ký tài khoản</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

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

    background:
    linear-gradient(
        135deg,
        #fff4ef,
        #ffffff
    );

    overflow:hidden;
}

body::before{

    content:"";

    position:absolute;

    width:420px;
    height:420px;

    border-radius:50%;

    background:
    rgba(238,77,45,.12);

    top:-120px;
    left:-120px;
}

body::after{

    content:"";

    position:absolute;

    width:350px;
    height:350px;

    border-radius:50%;

    background:
    rgba(255,140,70,.12);

    right:-100px;
    bottom:-100px;
}

.box{

    width:420px;

    background:
    rgba(255,255,255,.95);

    padding:35px;

    border-radius:25px;

    backdrop-filter:blur(10px);

    box-shadow:
    0 15px 40px rgba(0,0,0,.08);

    position:relative;

    z-index:5;
}

.icon{

    width:85px;
    height:85px;

    margin:auto;

    border-radius:50%;

    display:flex;
    align-items:center;
    justify-content:center;

    background:
    linear-gradient(
        135deg,
        #ee4d2d,
        #ff845f
    );

    font-size:38px;

    color:white;

    margin-bottom:15px;
}

h2{

    text-align:center;

    color:#ee4d2d;

    margin-bottom:25px;

    font-size:30px;
}

.msg{

    padding:14px;

    border-radius:12px;

    margin-bottom:18px;

    text-align:center;

    font-size:14px;
}

.success{

    background:#eaffee;
    color:#008a33;
}

.error{

    background:#fff0f0;
    color:#ff0033;
}

.input-group{

    position:relative;

    margin-bottom:16px;
}

.input-group input{

    width:100%;

    padding:15px;

    border:1px solid #ddd;

    border-radius:15px;

    outline:none;

    transition:.3s;

    font-size:14px;
}

.input-group input:focus{

    border-color:#ee4d2d;

    box-shadow:
    0 0 0 4px rgba(238,77,45,.08);
}

.eye{

    position:absolute;

    right:15px;

    top:50%;

    transform:
    translateY(-50%);

    cursor:pointer;

    user-select:none;
}

button{

    width:100%;

    padding:15px;

    border:none;

    border-radius:15px;

    background:
    linear-gradient(
        135deg,
        #ee4d2d,
        #ff845f
    );

    color:white;

    font-size:16px;

    font-weight:600;

    cursor:pointer;

    transition:.3s;
}

button:hover{

    transform:
    translateY(-3px);
}

.link{

    margin-top:20px;

    text-align:center;
}

.link a{

    text-decoration:none;

    color:#666;
}

.link a:hover{

    color:#ee4d2d;
}

@media(max-width:500px){

    .box{

        width:95%;
    }
}

</style>

</head>

<body>

<div class="box">

    <div class="icon">
        🏺
    </div>

    <h2>Đăng ký</h2>

    <?php if($msg!=""): ?>

        <div class="msg <?php echo $success ? 'success' : 'error'; ?>">

            <?php echo $msg; ?>

        </div>

    <?php endif; ?>

    <form method="POST" id="registerForm">

        <div class="input-group">

            <input
                type="text"
                name="username"
                placeholder="👤 Tên đăng nhập"
                required
            >

        </div>

        <div class="input-group">

            <input
                type="password"
                id="password"
                name="password"
                placeholder="🔑 Mật khẩu"
                required
            >

            <span
                class="eye"
                onclick="togglePassword('password')"
            >
                👁️
            </span>

        </div>

        <div class="input-group">

            <input
                type="password"
                id="confirm"
                name="confirm_password"
                placeholder="🔒 Xác nhận mật khẩu"
                required
            >

            <span
                class="eye"
                onclick="togglePassword('confirm')"
            >
                👁️
            </span>

        </div>

        <button
            id="btnRegister"
            name="register"
        >
            🚀 Đăng ký tài khoản
        </button>

    </form>

    <div class="link">

        <a href="login.php">

            Đã có tài khoản? Đăng nhập

        </a>

    </div>

</div>

<script>

function togglePassword(id){

    let input =
    document.getElementById(id);

    if(input.type==="password"){

        input.type="text";

    }else{

        input.type="password";
    }
}

document
.getElementById("registerForm")
.addEventListener(
"submit",
function(){

    let btn =
    document.getElementById(
    "btnRegister"
    );

    btn.innerHTML =
    "⏳ Đang xử lý...";

    btn.disabled = true;
});

</script>

</body>
</html>