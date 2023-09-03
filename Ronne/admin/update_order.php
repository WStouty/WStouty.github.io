<?php
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["action"]) && isset($_GET["id"])) {
    $action = $_GET["action"];
    $order_id = $_GET["id"];

    // 连接数据库
    $servername = "127.0.0.1";
    $username = "storr";
    $password = "XfjJfw5DGNiMWX4b";
    $dbname = "storr";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // 检查连接是否成功
    if ($conn->connect_error) {
        die("连接数据库失败: " . $conn->connect_error);
    }

    // 更新订单状态
    switch ($action) {
        case "approve":
            $newStatus = "chuli";
            break;
        case "complete":
            $newStatus = "wancheng";
            break;
        case "reject":
            $newStatus = "buxing";
            break;
        default:
            echo "无效的操作";
            exit;
    }

    // 更新状态字段
    $sql = "UPDATE dingdan SET zhuangtai = '$newStatus' WHERE id = $order_id";
    if ($conn->query($sql) === TRUE) {
        echo "订单状态已更新";
    } else {
        echo "更新订单状态时出错: " . $conn->error;
    }

    // 关闭数据库连接
    $conn->close();
} else {
    echo "无效的请求";
}
?>
<meta http-equiv="refresh" content="1;url=payorder.php">