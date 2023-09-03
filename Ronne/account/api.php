<?php
    include_once './public.php';
    // Include the afdian libs
    include_once "../pay/afd/afdian.php";
    //curl模块
    include_once "../public/curl.php";
    //支付操作函数
    include_once "../pay/lib/function.php";
    //引入数据库操作函数库
    require_once "../pay/lib/PayUtils.php";
    
    //极验二次验证
    require_once dirname(dirname(__FILE__)) . '/public/geetest/lib/class.geetestlib.php';
    require_once dirname(dirname(__FILE__)) . '/public/geetest/config/config.php';
    $GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
    
    //登入验证
    if ($_POST['state'] == 'login') {
        
        //极验验证逻辑
        if ($_SESSION['gtserver'] == 1) {   //服务器正常
            $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode']);
            if ($result) {
            } else {
                Notifications("./login.php","人机验证失败，请重试！","i");
            }
        } else {  //服务器宕机,走failback模式
            if ($GtSdk->fail_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'])) {
            } else {
                Notifications("./login.php","人机验证失败，请重试！","i");
            }
        }
        
        if (empty($_POST['username'])) {
            Notifications("./login.php","请输入账号！","w");
        }
        if (empty($_POST['password'])) {
            Notifications("./login.php","请输入密码！","w");
        }
        //判断是否存在中文
        if (preg_match("/[\x7f-\xff]/", $_POST['password'])||preg_match("/[\x7f-\xff]/", $_POST['username'])) {
            Notifications("./login.php","存在非法字符！","w");
        }
        if (mb_strlen($_POST['username'], 'UTF8') > 24) {
            Notifications("./login.php","用户名不得超出24个字符！","w");
        }
        if (mb_strlen($_POST['username'], 'UTF8') < 6) {
            Notifications("./login.php","用户名不得低于6个字符！","w");
        }
        if (mb_strlen($_POST['password'], 'UTF8') > 24) {
            Notifications("./login.php","密码不得超出24个字符！","w");
        }
        if (mb_strlen($_POST['password'], 'UTF8') < 6) {
            Notifications("./login.php","密码不得低于6个字符！","w");
        }
    
        $username = Escape($conn, $_POST['username']);//获取登录表单信息
        $password = md5($_POST['password']);//获取登录表单信息
    
        $sql = Execute($conn, "select * from account where username = '{$username}' and password = '{$password}'");//查询数据库
    
        if (mysqli_num_rows($sql) !== 1) {
            Notifications("./login.php","账号或密码错误！","d");
        }
    
        $linshi_data = mysqli_fetch_array($sql);
        //登陆成功设置session id
        $_SESSION['uid'] = $linshi_data['uid'];
        
        $sql = "update account set sign_time = '{$time}',sign_ip = '{$ip}' where uid='{$linshi_data['uid']}'";
        Execute($conn, $sql);
        Notifications("./index.php","登入成功！");
    }
    
    //注册验证
    if ($_POST['state'] == 'register') {
        //极验验证逻辑
        if ($_SESSION['gtserver'] == 1) {   //服务器正常
            $result = $GtSdk->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode']);
            if ($result) {
            } else {
                Notifications("./register.php?state=register&code={$_POST['code']}","人机验证失败，请重试！","i");
            }
        } else {  //服务器宕机,走failback模式
            if ($GtSdk->fail_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode'])) {
            } else {
                Notifications("./register.php?state=register&code={$_POST['code']}","人机验证失败，请重试！","i");
            }
        }

        if (empty($_SESSION['email'])) {
            Notifications("./register.php","邮箱参数不存在，请重新提交！","w");
        }
        if ($_POST['code'] != $_SESSION['code']) {
            Notifications("./register.php?state=register","验证码错误！","w");
        }
        if (empty($_POST['username'])) {
            Notifications("./register.php?state=register&code={$_POST['code']}","请输入账号！","w");
        }
        if (empty($_POST['password'])) {
            Notifications("./register.php?state=register&code={$_POST['code']}","请输入密码！","w");
        }
        if ($_POST['password'] != $_POST['password1']) {
            Notifications("./register.php?state=register&code={$_POST['code']}","两次输入密码不一致！","w");
        }
        
        //判断是否存在中文
        if (preg_match("/[\x7f-\xff]/", $_POST['password'])||preg_match("/[\x7f-\xff]/", $_POST['username'])) {
            Notifications("./login.php","存在非法字符！","w");
        }
        if (mb_strlen($_POST['username'], 'UTF8') > 24) {
            Notifications("./register.php?state=register&code={$_POST['code']}","用户名不得超出24个字符！","w");
        }
        if (mb_strlen($_POST['username'], 'UTF8') < 6) {
            Notifications("./register.php?state=register&code={$_POST['code']}","用户名不得低于6个字符！","w");
        }
        if (mb_strlen($_POST['password'], 'UTF8') > 24) {
            Notifications("./register.php?state=register&code={$_POST['code']}","密码不得超出24个字符！","w");
        }
        if (mb_strlen($_POST['password'], 'UTF8') < 6) {
            Notifications("./register.php?state=register&code={$_POST['code']}","密码不得低于6个字符！","w");
        }
        
        $username = Escape($conn, $_POST['username']);
        $password = $_POST['password'];
        
        //判断邮箱是否存在
        $sql = "select * from account where email = '{$_SESSION['email']}'";
        $linshi_data = Execute($conn, $sql);
        if (mysqli_num_rows($linshi_data)) {
            Notifications("./register.php","当前邮箱已经注册，请更换后再试！","w");
        }   
        //判断账号是否存在
        $sql = "select * from account where username = '{$username}'";
        $linshi_data = Execute($conn, $sql);
        if (mysqli_num_rows($linshi_data)) {
            Notifications("./register.php?state=register&code={$_POST['code']}","该用户名重复，请更换后再试！","w");
        }
        
        //用户数据
        $password = md5($password);
        $status = 1;//激活状态
        $tk = md5(randomkeys(5).$time);
        
        $sql = "INSERT INTO account (tk,email,username,password,set_time,sign_ip,status)
        VALUES ('{$tk}','{$_SESSION['email']}','{$username}','{$password}','{$time}','{$ip}','{$status}')";
        //清除沉于数据
        unset($_SESSION['email']);
        unset($_SESSION['code']);
        
        if (Execute($conn, $sql)) {
            Notifications("./login.php","注册成功！","s");
        }
        Notifications("./register.php","数据写入失败，注册失败！","d");
    }

//==============================================================================================================

    //判断是否登入
    if (empty($_SESSION['uid'])) {
        Notifications("./login.php","请先登录","i");
    }
    
    //账号退出
    if ($_GET['state'] == 'logout') {
        unset($_SESSION['uid']);
        Notifications("./login.php","退出成功",);
    }
 
    //重置TK
    if ($_GET['state'] == 'editTk') {
        $tk = md5(randomkeys(5).$time);
        $sql = "update account set tk = '{$tk}' where uid='{$_SESSION['uid']}'";
        if (Execute($conn, $sql)) {Notifications("./index.php","重置成功",);}else{Notifications("./index.php","重置失败",);}
    }

    //修改密码
    if ($_POST['state'] == 'editPassword') {
        
        if (empty($_POST['password1'])) {
            Notifications("./edit.php?state=editPassword","请输入原密码！","w");
        }
        if (empty($_POST['password2'])) {
            Notifications("./edit.php?state=editPassword","请输入新密码！","w");
        }
        if (empty($_POST['password3'])) {
            Notifications("./edit.php?state=editPassword","请重复新密码！","w");
        }
        
        if ($_POST['password3'] != $_POST['password2']) {
            Notifications("./edit.php?state=editPassword","两次输入密码不一致！","w");
        }

        if (mb_strlen($_POST['password2'], 'UTF8') > 24) {
            Notifications("./edit.php?state=editPassword","密码不得超出24个字符！","w");
        }
        if (mb_strlen($_POST['password2'], 'UTF8') < 6) {
            Notifications("./edit.php?state=editPassword","密码不得低于6个字符！","w");
        }

        //判断是否存在中文
        if (preg_match("/[\x7f-\xff]/", $_POST['password1'])||preg_match("/[\x7f-\xff]/", $_POST['password2'])||preg_match("/[\x7f-\xff]/", $_POST['password3'])) {
            Notifications("./edit.php?state=editPassword","存在非法字符！","w");
        }

        //整理数据确保可入库
        $password1 = Escape($conn, $_POST['password1']);
        $password2 = Escape($conn, $_POST['password2']);
        $password3 = Escape($conn, $_POST['password3']);
        
        $password2 = md5($password2);
        
        $sql = "update account set password = '{$password2}' where uid='{$account_data['uid']}'";
        if (Execute($conn, $sql)) {Notifications("./index.php","密码修改成功！","s");}else{Notifications("./edit.php?state=editPassword","密码修改失败！","s");}
    }
    //修改用户名
    if ($_POST['state'] == 'editUsername') {
        if (empty($_POST['username'])) {
            Notifications("./edit.php?state=editUsername","请输入用户名！","w");
        }
        //判断是否存在中文
        if (preg_match("/[\x7f-\xff]/", $_POST['username'])) {
            Notifications("./edit.php?state=editUsername","存在非法字符！","w");
        }
        if (mb_strlen($_POST['username'], 'UTF8') > 24) {
            Notifications("./edit.php?state=editUsername","用户名不得超出24个字符！","w");
        }
        if (mb_strlen($_POST['username'], 'UTF8') < 6) {
            Notifications("./edit.php?state=editUsername","用户名不得低于6个字符！","w");
        }
        if ($_POST['username'] == $account_data['username']) {
            Notifications("./edit.php?state=editUsername","不能与当前用户名重复！","w");
        }
        $username = Escape($conn, $_POST['username']);
        
        //判断账号是否存在
        $sql = "select * from account where username = '{$username}'";
        $linshi_data = Execute($conn, $sql);
        if (mysqli_num_rows($linshi_data)) {
            Notifications("./edit.php?state=editUsername","该用户名重复，请更换后再试！","w");
        }
        $sql = "update account set username = '{$username}' where uid='{$account_data['uid']}'";
        if (Execute($conn, $sql)) { Notifications("./index.php","用户名修改成功！","s");}else{ Notifications("./edit.php?state=editUsername","用户名修改失败！","w");}
    }
    
    //补单回调
    if ($_GET['state'] == 'notityOrder') {
        
        $notify = notify($_GET['trade_no'],$conn);
        //停止返回数据
        if($notify['code'] == 200){
            Notifications("./payorder.php",$notify['code'].":".$notify['msg']);//请求成功
        }else{
            Notifications("./payorder.php",$notify['code'].":".$notify['msg'],w);//请求失败
        }
    }
    //删除订单
    if ($_GET['state'] == 'deleteOrder') {
        $sql = Execute($conn, "select * from payorder where trade_no = '{$_GET['trade_no']}' and uid = '{$account_data['uid']}'");//查询数据
        if (mysqli_num_rows($sql) !== 1) {
            Notifications("./payorder.php","该订单不存在或不属于你！","w");
        }
        $sql = "delete from payorder where trade_no = '{$_GET['trade_no']}'";
        if (Execute($conn, $sql)) {
            Notifications("./payorder.php","删除成功！","s");
        }else{
            Notifications("./payorder.php","删除失败！","d");
        }
    }
    
    //配置爱发电
    if ($_POST['state'] == 'configAfd') {
        if (empty($_POST['afd_tk'])) {
            Notifications("./afdconfig.php","请输入Token！","w");
        }
        if (empty($_POST['afd_id'])) {
            Notifications("./afdconfig.php","请输入ID！","w");
        }
        //判断是否存在中文
        if (preg_match("/[\x7f-\xff]/", $_POST['afd_tk'])) {
            Notifications("./afdconfig.php","存在非法字符！","w");
        }
        if (preg_match("/[\x7f-\xff]/", $_POST['afd_id'])) {
            Notifications("./afdconfig.php","存在非法字符！","w");
        }
        if (mb_strlen($_POST['afd_tk'], 'UTF8') > 50) {
            Notifications("./afdconfig.php","TK不得超出50个字符！","w");
        }
        if (mb_strlen($_POST['afd_id'], 'UTF8') > 50) {
            Notifications("./afdconfig.php","ID不得超出50个字符！","w");
        }
		
        if ($_POST['afd_id'] == $account_data['afd_id'] && $_POST['afd_tk'] == $account_data['afd_tk']) {
            Notifications("./afdconfig.php","不能与当前ID和Token重复！","w");
        }
        $afd_tk = Escape($conn, $_POST['afd_tk']);
		$afd_id = Escape($conn, $_POST['afd_id']);
        
        //判断爱发电id是否存在
        $sql = "select * from account where afd_id = '{$afd_id}' and uid != '{$account_data['uid']}'";
        $linshi_data = Execute($conn, $sql);
        if (mysqli_num_rows($linshi_data)) {
            Notifications("./afdconfig.php","当前ID已被绑定请换其他ID再试！","w");
        }
        $sql = "update account set afd_tk = '{$afd_tk}',afd_id = '{$afd_id}' where uid='{$account_data['uid']}'";
        if (Execute($conn, $sql)) {Notifications("./index.php","爱发电配置修改成功！","s");}else{ Notifications("./afdconfig.php","爱发电配置修改失败！","w");}
    }
    
    Notifications("./","参数无效！","d");
    Close($conn); //关闭数据库连接
?>