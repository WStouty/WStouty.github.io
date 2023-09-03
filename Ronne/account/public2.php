<?php
    //判断是否登入
    if (empty($_SESSION['id'])) {
        Notifications("login.php","请先登录","w");
    }

?>