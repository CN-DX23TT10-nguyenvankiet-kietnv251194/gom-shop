<?php include "config.php"; ?>
<link rel="stylesheet" href="style.css">

<h2>📥 Nhập hàng</h2>

<form method="POST">

<select name="product_id">
<?php
$res = $conn->query("SELECT * FROM products");
while($p = $res->fetch_assoc()):
?>
<option value="<?php echo $p['id']; ?>">
    <?php echo $p['name']; ?>
</option>
<?php endwhile; ?>
</select>

<input type="number" name="qty" placeholder="Số lượng" required>

<button name="import">Nhập hàng</button>

</form>

<?php
if(isset($_POST['import'])){
    $pid = $_POST['product_id'];
    $qty = $_POST['qty'];

    // tạo đơn nhập
    $conn->query("INSERT INTO orders(customer,type) VALUES('Nhập kho','nhap')");
    $oid = $conn->insert_id;

    // thêm sản phẩm vào đơn nhập
    $conn->query("INSERT INTO order_items(order_id,product_id,qty)
    VALUES($oid,$pid,$qty)");

    echo "<p>✔ Đã nhập hàng thành công</p>";
}
?>
