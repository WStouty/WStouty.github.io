<?php
include './header.php';
include './public1.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fields = $_POST["field"];
    $rfields = $_POST["rfield"];
    $weizhi = $_POST["weizhi"];
    $username = $account_data['username'];
    $zhuangtai = "dengdai";

    // 连接数据库
    $servername = "127.0.0.1";
    $username_db = "storr";
    $password = "XfjJfw5DGNiMWX4b";
    $dbname = "storr";

    $conn = new mysqli($servername, $username_db, $password, $dbname);

    // 检查连接是否成功
    if ($conn->connect_error) {
        die("连接数据库失败: " . $conn->connect_error);
    }

    // 查询用户权限和次数
    $current_username = $account_data['username'];
    $sql_user = "SELECT isOP, chance FROM account WHERE username = '$current_username'";
    $result_user = $conn->query($sql_user);
    $user_data = $result_user->fetch_assoc();
    $user_power = $user_data['isOP'];
    $user_chance = $user_data['chance'];

    // 判断是否进行次数限制
    if ($user_power == 1) {
        process_form($fields, $rfields, $weizhi, $username, $zhuangtai, $conn);

        // 跳转并显示提示消息
        $notification_message = "数据提交成功。";
echo "<script>window.location.href = 'payorder.php?notifications_state=i&notifications=" . urlencode($notification_message) . "';</script>";
exit;

    } elseif (($user_power == 0 || $user_power == '') && $user_chance <= 0) {
        $notification_message = "您的提交次数已用尽，暂时不能提交。";
echo "<script>window.location.href = 'payorder.php?notifications_state=i&notifications=" . urlencode($notification_message) . "';</script>";
exit;

    } else {
        process_form($fields, $rfields, $weizhi, $username, $zhuangtai, $conn);

        // 更新用户的 chance 字段
        $user_chance -= 1;
        $sql_update_chance = "UPDATE account SET chance = $user_chance WHERE username = '$username'";
        $conn->query($sql_update_chance);

        // 跳转并显示提示消息
        $notification_message = "数据提交成功。";
echo "<script>window.location.href = 'payorder.php?notifications_state=i&notifications=" . urlencode($notification_message) . "';</script>";
exit;

    }

    // 关闭数据库连接
    $conn->close();
}

function process_form($fields, $rfields, $weizhi, $username, $zhuangtai, $conn) {
    for ($i = 0; $i < count($fields); $i++) {
        $field = $conn->real_escape_string($fields[$i]);
        $rfield = $conn->real_escape_string($rfields[$i]);
        $weizhi_value = $conn->real_escape_string($weizhi[$i]);

        // 获取当前时间
        $current_time = date("Y-m-d H:i:s");

        // 插入数据到数据库
        $sql = "INSERT INTO dingdan (wupin, yonghu, riqi, zhuangtai, rfield, weizhi) VALUES ('$field', '$username', '$current_time', '$zhuangtai', '$rfield', '$weizhi_value')";
        if ($conn->query($sql) !== TRUE) {
            echo "插入数据时出错: " . $conn->error;
        }
    }
}
?>

