<?php
include "config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* kiểm tra có dữ liệu gửi lên không */
if(isset($_POST['customer'])){

    $customer = $_POST['customer'];
    $phone    = $_POST['phone'];
    $address  = $_POST['address'];

    /* tính tổng tiền */
    $total = 0;

    if(isset($_SESSION['cart'])){

        foreach($_SESSION['cart'] as $id => $qty){

            $res = $conn->query("SELECT * FROM products WHERE id=$id");

            if($res->num_rows > 0){

                $p = $res->fetch_assoc();

                $total += $p['price'] * $qty;
            }
        }
    }

    /* lưu đơn hàng */
    $conn->query("
        INSERT INTO orders(customer, phone, address, total)
        VALUES('$customer','$phone','$address','$total')
    ");

    $order_id = $conn->insert_id;

    /* lưu chi tiết đơn hàng */
    if(isset($_SESSION['cart'])){

        foreach($_SESSION['cart'] as $id => $qty){

            $res = $conn->query("SELECT * FROM products WHERE id=$id");

            if($res->num_rows > 0){

                $p = $res->fetch_assoc();

                $price = $p['price'];

                $conn->query("
                    INSERT INTO order_details(order_id, product_id, qty, price)
                    VALUES('$order_id','$id','$qty','$price')
                ");
            }
        }
    }

    /* xóa giỏ hàng */
    unset($_SESSION['cart']);

    /* thông báo + quay về trang chủ */
    echo "
    <script>
        alert('Thanh toán thành công!');
        window.location='index.php';
    </script>
    ";
}
?>