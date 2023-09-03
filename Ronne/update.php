<?php
$servername = "127.0.0.1";
$username_db = "storr";
$password = "XfjJfw5DGNiMWX4b";
$dbname = "storr";

$conn = new mysqli($servername, $username_db, $password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
    die("连接数据库失败: " . $conn->connect_error);
}

// 更新用户的 chance 字段为 2
$sql_update_chance = "UPDATE account SET chance = 2";
if ($conn->query($sql_update_chance) !== TRUE) {
    echo "更新数据时出错: " . $conn->error;
}

// 关闭数据库连接
$conn->close();

echo "sUcEss.";
?>
