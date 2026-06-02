/* THỐNG KÊ */

$totalProducts = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT COUNT(*) AS total
        FROM products
    ")
)['total'];

$totalOrders = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT COUNT(*) AS total
        FROM orders
        WHERE type='ban'
    ")
)['total'];

$totalUsers = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT COUNT(*) AS total
        FROM users
    ")
)['total'];

$revenue = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT SUM(p.price * oi.qty) AS total
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN products p ON p.id = oi.product_id
        WHERE o.type='ban'
    ")
)['total'] ?? 0;