<?php
    include_once './public.php';
    // Include the afdian libs
    include_once "../pay/afd/afdian.php";
    //curl模块
    include_once "../public/curl.php";
    //支付操作函数
    include_once "../pay/lib/function.php";
    //引入数据库操作函a数库
    require_once "../pay/lib/PayUtils.php";
    
    //登入验证
    if ($_POST['state'] == 'login') {
    
        //极验二次验证
        require_once dirname(dirname(__FILE__)) . '/public/geetest/lib/class.geetestlib.php';
        require_once dirname(dirname(__FILE__)) . '/public/geetest/config/config.php';
        
        $GtSdk = new GeetestLib(CAPTCHA_ID, PRIVATE_KEY);
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
            Notifications("./login.php","请输入用户名！","w");
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
    
        $sql = Execute($conn, "select * from user where username = '{$username}' and password = '{$password}'");//查询数据库
    
        if (mysqli_num_rows($sql) !== 1) {
            Notifications("./login.php","用户名或密码错误！","d");
        }
    
        $linshi_data = mysqli_fetch_array($sql);
        //登陆成功设置session id
        $_SESSION['id'] = $linshi_data['id'];
        
        $sql = "update user set sign_time = '{$time}',sign_ip = '{$ip}' where id='{$linshi_data['id']}'";
        Execute($conn, $sql);
        Notifications("./index.php","登入成功！");
    }

//==============================================================================================================

    //判断是否登入
    if (empty($_SESSION['id'])) {
        Notifications("./login.php","请先登录","i");
    }
    
    //账号退出
    if ($_GET['state'] == 'logout') {
        unset($_SESSION['id']);
        Notifications("./login.php","退出成功",);
    }
 
    //添加管理员
    if ($_GET['state'] == 'addUser') {
        //判断当前登录者权限
        if ($admin_data['power'] !== "1") {
            Notifications("./index.php","权限不足！","d");
        }
        
        $username = randomkeys(7);
        $password = md5("1234567");
        $sql = "INSERT INTO user (username,password,power,set_time,sign_ip)
        VALUES ('{$username}','{$password}','2','{$time}','{$ip}')";
        
        if (Execute($conn, $sql)) {
            Notifications("./user.php","添加成功,请修改用户名密码后使用！","s");
        }
        Notifications("./user.php","添加失败！","d");
    }
    //编辑管理员
    if ($_POST['state'] == 'editUser') {
        //判断当前登录者权限
        if ($admin_data['power'] !== "1") {
            Notifications("./index.php","权限不足！","d");
        }
        //判断是否存在中文
        if (preg_match("/[\x7f-\xff]/", $_POST['id'])||preg_match("/[\x7f-\xff]/", $_POST['password'])||preg_match("/[\x7f-\xff]/", $_POST['username'])||preg_match("/[\x7f-\xff]/", $_POST['power'])) {
            Notifications("./edit.php?state=editUser&id={$_POST['id']}","存在非法字符！","w");
        }

        //整理数据确保可入库
        $id = Escape($conn, $_POST['id']);
        $username = Escape($conn, $_POST['username']);
        $power = Escape($conn, $_POST['power']);

        $sql = Execute($conn, "select * from user where id = '{$id}'");//查询数据
        if (mysqli_num_rows($sql) !== 1) {
            Notifications("./user.php","该用户不存在！","w");
        }

        if (empty($_POST['username']) || empty($_POST['power'])) {
            Notifications("./edit.php?state=editUser&id={$id}","密码除外请勿留空！","w");
        }
        if ($_POST['power'] !== "1" && $_POST['power'] !== "2") {
            Notifications("./edit.php?state=editUser&id={$id}","power参数无效！","w");
        }
        
        $sql = Execute($conn, "select * from user where id = '{$_POST['id']}'");//查询数据
        $user_data = mysqli_fetch_assoc($sql);
        
        if($_POST['username'] == $user_data['username'] && $_POST['power'] == $user_data['power'] && $_POST['password'] == ""){
            Notifications("./edit.php?state=editUser&id={$id}","请修改后再提交！","w");
        }
        //判断是否修改用户名并修改
        if ($_POST['username'] !== $user_data['username']) {
            if (mb_strlen($_POST['username'], 'UTF8') > 24) {
                Notifications("./edit.php?state=editUser&id={$id}","用户名不得超出24个字符！","w");
            }
            if (mb_strlen($_POST['username'], 'UTF8') < 6) {
                Notifications("./edit.php?state=editUser&id={$id}","用户名不得低于6个字符！","w");
            }
            //判断账号是否存在
            $sql = "select * from user where username = '{$username}'";
            $linshi_data = Execute($conn, $sql);
            if (mysqli_num_rows($linshi_data)) {
                Notifications("./edit.php?state=editUser&id={$id}","该用户名重复，请更换后再试！","w");
            }
            $sql = "update user set username = '{$username}', set_time = '{$time}' where id='{$id}'";
            if (Execute($conn, $sql)) {$username = "y";}else{$username = "n";}
        }else{
            $username = "y";
        }
        //判断是否修改权限并修改
        if ($_POST['power'] !== $user_data['power']) {
            if ($id == $admin_data['id']) {
                Notifications("./edit.php?state=editUser&id={$id}","您无法修改自己的权限！","d");
            }
            $sql = "update user set power = {$power}, set_time = '{$time}' where id='{$id}'";
            if (Execute($conn, $sql)) {$power = "y";}else{$power = "n";}
        }else{
            $power = "y";
        }
        //判断是否修改密码并修改
        if ($_POST['password'] !== "") {
            if (mb_strlen($_POST['password'], 'UTF8') > 24) {
                Notifications("./edit.php?state=editUser&id={$id}","密码不得超出24个字符！","w");
            }
            if (mb_strlen($_POST['password'], 'UTF8') < 6) {
                Notifications("./edit.php?state=editUser&id={$id}","密码不得低于6个字符！","w");
            }
            $password = md5($_POST['password']);
            $sql = "update user set password = '{$password}', set_time = '{$time}' where id='{$id}'";
            if (Execute($conn, $sql)) {$password = "y";}else{$password = "n";}
        }else{
            $password = "y";
        }
        if($password == "y" && $username == "y" && $power == "y"){
            Notifications("./user.php","编辑成功！","s");
        }
        Notifications("./edit.php?state=editUser&id={$id}","用户名:{$username}/权限:{$power}/密码:{$password}","w");
    }
    //删除管理员
    if ($_GET['state'] == 'deleteUser') {
        $id = Escape($conn, $_GET['id']);
        //判断当前登录者权限
        if ($admin_data['power'] !== "1") {
            Notifications("./index.php","权限不足！","d");
        }
        if ($id == $admin_data['id']) {
            Notifications("./index.php","您无法删除自己！","d");
        }
        $sql = Execute($conn, "select * from user where id = '{$id}'");//查询数据
        if (mysqli_num_rows($sql) !== 1) {
            Notifications("./user.php","该用户不存在！","w");
        }
        $sql = "delete from user where id='{$id}'";
        if (Execute($conn, $sql)) {
            Notifications("./user.php","删除成功！","s");
        }else{
            Notifications("./user.php","删除失败！","d");
        }
    }
    
    //添加文章
    if ($_GET['state'] == 'addContents') {
        $tittle = randomkeys(7);
        $sql = "INSERT INTO contents (user_id,tittle,ip,time)
        VALUES ('{$admin_data['id']}','{$tittle}','{$ip}','{$time}')";
        
        if (Execute($conn, $sql)) {
            Notifications("./contents.php","添加成功,请编辑后使用！","s");
        }
        Notifications("./contents.php","添加失败！","d");
    }
    //编辑文章
    if ($_POST['state'] == 'editContents') {
        //整理数据确保可入库
        $id = Escape($conn, $_POST['id']);
        $tittle = Escape($conn, $_POST['tittle']);
        $content = Escape($conn, $_POST['content']);
        $oneimg = Escape($conn, $_POST['oneimg']);
        $top = Escape($conn, $_POST['top']);
        if ($_POST['top'] !== "0" && $_POST['top'] !== "1") {
            Notifications("./contents.php","TOP参数无效！","w");
        }
        
        $sql = Execute($conn, "select * from contents where id = '{$id}'");//查询数据
        if (mysqli_num_rows($sql) !== 1) {
            Notifications("./contents.php","该文章不存在！","w");
        }
        
        $sql = Execute($conn, "select * from contents where id = '{$_POST['id']}'");//查询数据
        $contents_data = mysqli_fetch_assoc($sql);

        if($_POST['tittle'] == $contents_data['tittle'] && $_POST['content'] == $contents_data['content'] && $_POST['oneimg'] == $contents_data['oneimg'] && $_POST['top'] == $contents_data['top']){
            Notifications("./contents.php?state=editContent&id={$id}","请修改后再提交","w");
        }
        if($_POST['tittle'] !== $contents_data['tittle']){
            $sql = "update contents set tittle = '{$tittle}', time = '{$time}' ,ip = '{$ip}' where id='{$id}'";
            if (Execute($conn, $sql)) {$tittle = "y";}else{$tittle = "n";}
        }else{
            $tittle = "y";
        }
        
        if($_POST['content'] !== $contents_data['content']){
            $sql = "update contents set content = '{$content}', time = '{$time}' ,ip = '{$ip}' where id='{$id}'";
            if (Execute($conn, $sql)) {$content = "y";}else{$content = "n";}
        }else{
            $content = "y";
        }

        if($_POST['oneimg'] !== $contents_data['oneimg']){
            $sql = "update contents set oneimg = '{$oneimg}', time = '{$time}' ,ip = '{$ip}' where id='{$id}'";
            if (Execute($conn, $sql)) {$oneimg = "y";}else{$oneimg = "n";}
        }else{
            $oneimg = "y";
        }
        
        if($_POST['top'] !== $contents_data['top']){
            $sql = "update contents set top = '{$top}', time = '{$time}' ,ip = '{$ip}' where id='{$id}'";
            if (Execute($conn, $sql)) {$top = "y";}else{$top = "n";}
        }else{
            $top = "y";
        }
        
        if($content == "y" && $tittle == "y" && $oneimg == "y" && $top == "y"){
            Notifications("./contents.php","编辑成功！","s");
        }
        Notifications("./system.php?state=editUser&id={$id}","文章名:{$tittle}/文章内容:{$content}/封面图:{$content}/置顶:{$top}","w");   
    }
    //删除文章
    if ($_GET['state'] == 'deleteContents') {
        $id = Escape($conn, $_GET['id']);
        $sql = Execute($conn, "select * from contents where id = '{$id}'");//查询数据
        if (mysqli_num_rows($sql) !== 1) {
            Notifications("./contents.php","该文章不存在！","w");
        }
        $sql = "delete from contents where id='{$id}'";
        if (Execute($conn, $sql)) {
            Notifications("./contents.php","删除成功！","s");
        }else{
            Notifications("./contents.php","删除失败！","d");
        }
    }

    //编辑系统
    if ($_POST['state'] == 'editSystem') {
        //判断当前登录者权限
        if ($admin_data['power'] !== "1") {
            Notifications("./index.php","权限不足！","d");
        }
        
        //整理数据确保可入库
        $url = Escape($conn, $_POST['url']);
        $tittle = Escape($conn, $_POST['tittle']);
        $keyworld = Escape($conn, $_POST['keyworld']);
        $description = Escape($conn, $_POST['description']);
        $copyright = Escape($conn, $_POST['copyright']);
        $friends = Escape($conn, $_POST['friends']);

        if($_POST['tittle'] == $system_data['tittle'] && $_POST['keyworld'] == $system_data['keyworld'] && $_POST['url'] == $system_data['url'] && $_POST['description'] == $system_data['description'] && $_POST['copyright'] == $system_data['copyright']&& $_POST['friends'] == $system_data['friends']){
            Notifications("./system.php","请修改后再提交","w");
        }
        if($_POST['tittle'] !== $system_data['tittle']){
            $sql = "update system set value = '{$tittle}' where name='tittle'";
            if (Execute($conn, $sql)) {$tittle = "y";}else{$tittle = "n";}
        }else{
            $tittle = "y";
        }
        
        if($_POST['keyworld'] !== $system_data['keyworld']){
            $sql = "update system set value = '{$keyworld}' where name='keyworld'";
            if (Execute($conn, $sql)) {$keyworld = "y";}else{$keyworld = "n";}
        }else{
            $keyworld = "y";
        }

        if($_POST['url'] !== $system_data['url']){
            $sql = "update system set value = '{$url}' where name='url'";
            if (Execute($conn, $sql)) {$url = "y";}else{$url = "n";}
        }else{
            $url = "y";
        }
        
        if($_POST['description'] !== $system_data['description']){
            $sql = "update system set value = '{$description}' where name='description'";
            if (Execute($conn, $sql)) {$description = "y";}else{$description = "n";}
        }else{
            $description = "y";
        }
		
        if($_POST['copyright'] !== $system_data['copyright']){
            $sql = "update system set value = '{$copyright}' where name='copyright'";
            if (Execute($conn, $sql)) {$copyright = "y";}else{$copyright = "n";}
        }else{
            $copyright = "y";
        }
		
        if($_POST['friends'] !== $system_data['friends']){
            $sql = "update system set value = '{$friends}' where name='friends'";
            if (Execute($conn, $sql)) {$friends = "y";}else{$friends = "n";}
        }else{
            $friends = "y";
        }
        
        if($keyworld == "y" && $tittle == "y" && $url == "y" && $description == "y" && $copyright == "y" && $friends == "y"){
            Notifications("./system.php","编辑成功！","s");
        }
        Notifications("./system.php","站点名:{$tittle}/站点关键词:{$keyworld}/站点域名:{$url}/站点描述:{$description}/站点版权:{$copyright}/友情链接:{$friends}","w");   
    }
    //支付配置
    if ($_POST['state'] == 'payConf') {
        
        //判断当前登录者权限
        if ($admin_data['power'] !== "1") {
            Notifications("./index.php","权限不足！","d");
        }
        
        //整理数据确保可入库
        $pay_maxmoney = Escape($conn, $_POST['pay_maxmoney']);
        $pay_minmoney = Escape($conn, $_POST['pay_minmoney']);
        $blockname = Escape($conn, $_POST['blockname']);
        $blockalert = Escape($conn, $_POST['blockalert']);
        $auto_key = Escape($conn, $_POST['auto_key']);

        if($_POST['pay_maxmoney'] == $payconf_data['pay_maxmoney'] && $_POST['pay_minmoney'] == $payconf_data['pay_minmoney'] && $_POST['blockname'] == $payconf_data['blockname'] && $_POST['blockalert'] == $payconf_data['blockalert'] && $_POST['auto_key'] == $payconf_data['auto_key']){
            Notifications("./payconfig.php","请修改后再提交","w");
        }
        if($_POST['pay_maxmoney'] !== $payconf_data['pay_maxmoney']){
            $sql = "update payconf set value = '{$pay_maxmoney}' where name='pay_maxmoney'";
            if (Execute($conn, $sql)) {$pay_maxmoney = "y";}else{$pay_maxmoney = "n";}
        }else{
            $pay_maxmoney = "y";
        }
        
        if($_POST['pay_minmoney'] !== $payconf_data['pay_minmoney']){
            $sql = "update payconf set value = '{$pay_minmoney}' where name='pay_minmoney'";
            if (Execute($conn, $sql)) {$pay_minmoney = "y";}else{$pay_minmoney = "n";}
        }else{
            $pay_minmoney = "y";
        }

        if($_POST['blockname'] !== $payconf_data['blockname']){
            $sql = "update payconf set value = '{$blockname}' where name='blockname'";
            if (Execute($conn, $sql)) {$blockname = "y";}else{$blockname = "n";}
        }else{
            $blockname = "y";
        }
        
        if($_POST['blockalert'] !== $payconf_data['blockalert']){
            $sql = "update payconf set value = '{$blockalert}' where name='blockalert'";
            if (Execute($conn, $sql)) {$blockalert = "y";}else{$blockalert = "n";}
        }else{
            $blockalert = "y";
        }
		
        if($_POST['auto_key'] !== $payconf_data['auto_key']){
            $sql = "update payconf set value = '{$auto_key}' where name='auto_key'";
            if (Execute($conn, $sql)) {$auto_key = "y";}else{$auto_key = "n";}
        }else{
            $auto_key = "y";
        }
        
        if($pay_minmoney == "y" && $pay_maxmoney == "y" && $blockname == "y" && $blockalert == "y" && $auto_key == "y"){
            Notifications("./payconfig.php","编辑成功！","s");
        }
        Notifications("./payconfig.php","订单最大价格:{$pay_maxmoney}/订单最小价格:{$pay_minmoney}/屏蔽词:{$blockname}/违规订单拦截提示:{$blockalert}/订单自动轮询KEY:{$auto_key}","w");
    }
    //邮箱配置
    if ($_POST['state'] == 'emailConf') {
        
        //判断当前登录者权限
        if ($admin_data['power'] !== "1") {
            Notifications("./index.php","权限不足！","d");
        }
        
        //整理数据确保可入库
        $email_username = Escape($conn, $_POST['email_username']);
        $email_password = Escape($conn, $_POST['email_password']);
        $email_smtpsecure = Escape($conn, $_POST['email_smtpsecure']);
        $email_host = Escape($conn, $_POST['email_host']);
        $email_port = Escape($conn, $_POST['email_port']);
		$email_name = Escape($conn, $_POST['email_name']);
		
        if($_POST['email_username'] == $system_data['email_username'] && $_POST['email_password'] == $system_data['email_password'] && $_POST['email_smtpsecure'] == $system_data['email_smtpsecure'] && $_POST['email_host'] == $system_data['email_host'] && $_POST['email_port'] == $system_data['email_port'] && $_POST['email_name'] == $system_data['email_name']){
            Notifications("./email.php","请修改后再提交","w");
        }
        if($_POST['email_username'] !== $system_data['email_username']){
            $sql = "update system set value = '{$email_username}' where name='email_username'";
            if (Execute($conn, $sql)) {$email_username = "y";}else{$email_username = "n";}
        }else{
            $email_username = "y";
        }
        
        if($_POST['email_password'] !== $system_data['email_password']){
            $sql = "update system set value = '{$email_password}' where name='email_password'";
            if (Execute($conn, $sql)) {$email_password = "y";}else{$email_password = "n";}
        }else{
            $email_password = "y";
        }

        if($_POST['email_smtpsecure'] !== $system_data['email_smtpsecure']){
            $sql = "update system set value = '{$email_smtpsecure}' where name='email_smtpsecure'";
            if (Execute($conn, $sql)) {$email_smtpsecure = "y";}else{$email_smtpsecure = "n";}
        }else{
            $email_smtpsecure = "y";
        }
        
        if($_POST['email_host'] !== $system_data['email_host']){
            $sql = "update system set value = '{$email_host}' where name='email_host'";
            if (Execute($conn, $sql)) {$email_host = "y";}else{$email_host = "n";}
        }else{
            $email_host = "y";
        }
		
        if($_POST['email_port'] !== $system_data['email_port']){
            $sql = "update system set value = '{$email_port}' where name='email_port'";
            if (Execute($conn, $sql)) {$email_port = "y";}else{$email_port = "n";}
        }else{
            $email_port = "y";
        }
		
        if($_POST['email_name'] !== $system_data['email_name']){
            $sql = "update system set value = '{$email_name}' where name='email_name'";
            if (Execute($conn, $sql)) {$email_name = "y";}else{$email_name = "n";}
        }else{
            $email_name = "y";
        }
		
        if($email_password == "y" && $email_username == "y" && $email_smtpsecure == "y" && $email_host == "y" && $email_port == "y" && $email_name == "y"){
            Notifications("./email.php","编辑成功！","s");
        }
        Notifications("./email.php","用户名:{$email_username}/密码:{$email_password}/验证方式:{$email_smtpsecure}/服务器地址:{$email_host}/服务器端口:{$email_port}/发件人姓名:{$email_name}","w");
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
        $sql = Execute($conn, "select * from payorder where trade_no = '{$_GET['trade_no']}'");//查询数据
        if (mysqli_num_rows($sql) !== 1) {
            Notifications("./payorder.php","该订单不存在","w");
        }
        $sql = "delete from payorder where trade_no = '{$_GET['trade_no']}'";
        if (Execute($conn, $sql)) {
            Notifications("./payorder.php","删除成功！","s");
        }else{
            Notifications("./payorder.php","删除失败！","d");
        }
    }
    
    //添加账户
    if ($_GET['state'] == 'addAccount') {

        $username = randomkeys(7);
        $password = md5("1234567");
        
        $tk = $tk = randomkeys(32);
        $status = 1;//激活状态
        
        $sql = "INSERT INTO account (tk,username,password,set_time,sign_ip,status)
        VALUES ('{$tk}','{$username}','{$password}','{$time}','{$ip}','{$status}')";
        
        if (Execute($conn, $sql)) {
            Notifications("./account.php","添加成功,请修改用户名密码后使用！","s");
        }
        Notifications("./account.php","添加失败！","d");
    }
    //编辑账户
    if ($_POST['state'] == 'editAccount') {
        //判断是否存在中文
        if (preg_match("/[\x7f-\xff]/", $_POST['uid'])||preg_match("/[\x7f-\xff]/", $_POST['password'])||preg_match("/[\x7f-\xff]/", $_POST['username'])||preg_match("/[\x7f-\xff]/", $_POST['status'])||preg_match("/[\x7f-\xff]/", $_POST['afd_tk'])||preg_match("/[\x7f-\xff]/", $_POST['email'])||preg_match("/[\x7f-\xff]/", $_POST['afd_id'])||preg_match("/[\x7f-\xff]/", $_POST['tk'])) {
            Notifications("./edit.php?state=editAccount&uid={$_POST['uid']}","存在非法字符！","w");
        }

        //整理数据确保可入库
        $uid = Escape($conn, $_POST['uid']);
        $username = Escape($conn, $_POST['username']);
        $tk = Escape($conn, $_POST['tk']);
        $email = Escape($conn, $_POST['email']);
        $afd_id = Escape($conn, $_POST['afd_id']);
        $afd_tk = Escape($conn, $_POST['afd_tk']);
        $by_town = Escape($conn, $_POST['by_town']);
        $isProfile = Escape($conn, $_POST['isProfile']);
        $isDiscord = Escape($conn, $_POST['isDiscord']);
        
        
        $sql = Execute($conn, "select * from account where uid = '{$uid}'");//查询数据
        if (mysqli_num_rows($sql) !== 1) {
            Notifications("./account.php","该账户不存在！","w");
        }

        if (empty($_POST['username'])||empty($_POST['tk'])||!isset($_POST['status'])&&empty($_POST['status'])) {
            Notifications("./edit.php?state=editAccount&uid={$uid}","用户名,封禁状态,tokne不得为空！","w");
        }
        if ($_POST['status'] !== "1" && $_POST['status'] !== "0") {
            Notifications("./edit.php?state=editAccount&uid={$uid}","status参数无效！","w");
        }
        $status = Escape($conn, $_POST['status']);
        
        $sql = Execute($conn, "select * from account where uid = '{$uid}'");//查询数据
        $account_data = mysqli_fetch_assoc($sql);
        
        //判断是否修改用户名并修改
        if ($_POST['username'] !== $account_data['username']) {
            if (mb_strlen($_POST['username'], 'UTF8') > 24) {
                Notifications("./edit.php?state=editAccount&uid={$uid}","用户名不得超出24个字符！","w");
            }
            if (mb_strlen($_POST['username'], 'UTF8') < 6) {
                Notifications("./edit.php?state=editAccount&uid={$uid}","用户名不得低于6个字符！","w");
            }
            //判断账号是否存在
            $sql = "select * from account where username = '{$username}'";
            $linshi_data = Execute($conn, $sql);
            if (mysqli_num_rows($linshi_data)) {
                Notifications("./edit.php?state=editAccount&uid={$uid}","该用户名重复，请更换后再试！","w");
            }
            $sql = "update account set username = '{$username}' where uid='{$uid}'";
            if (Execute($conn, $sql)) {$username = "y";}else{$username = "n";}
        }else{
            $username = "y";
        }
        //判断是否修改权限并修改
        if ($_POST['status'] !== $account_data['status']) {
            $sql = "update account set status = {$status} where uid='{$uid}'";
            if (Execute($conn, $sql)) {$status = "y";}else{$status = "n";}
        }else{
            $status = "y";
        }
        //判断是否修改密码并修改
        if ($_POST['password'] !== "") {
            if (mb_strlen($_POST['password'], 'UTF8') > 24) {
                Notifications("./edit.php?state=editAccount&uid={$uid}","密码不得超出24个字符！","w");
            }
            if (mb_strlen($_POST['password'], 'UTF8') < 6) {
                Notifications("./edit.php?state=editAccount&uid={$uid}","密码不得低于6个字符！","w");
            }
            $password = md5($_POST['password']);
            $sql = "update account set password = '{$password}' where uid='{$uid}'";
            if (Execute($conn, $sql)) {$password = "y";}else{$password = "n";}
        }else{
            $password = "y";
        }
        //判断是否修改afdid并修改
        if ($_POST['afd_id'] !== "") {
            if (mb_strlen($_POST['afd_id'], 'UTF8') > 50) {
                Notifications("./edit.php?state=editAccount&uid={$uid}","ID不得超出50个字符！","w");
            }
            $sql = "update account set afd_id = '{$afd_id}' where uid='{$uid}'";
            if (Execute($conn, $sql)) {$afd_id = "y";}else{$afd_id = "n";}
        }else{
            $afd_id = "y";
        }
        //判断是否修改afdtk并修改
        if ($_POST['afd_tk'] !== "") {
            if (mb_strlen($_POST['afd_tk'], 'UTF8') > 50) {
                Notifications("./edit.php?state=editAccount&uid={$uid}","ID不得超出50个字符！","w");
            }
            $sql = "update account set afd_tk = '{$afd_tk}' where uid='{$uid}'";
            if (Execute($conn, $sql)) {$afd_tk = "y";}else{$afd_tk = "n";}
        }else{
            $afd_tk = "y";
        }
        //判断是否修改email并修改
        if ($_POST['email'] !== "") {
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                Notifications("./edit.php?state=editAccount&uid={$uid}","邮箱格式存在问题！","w");
            }
            $sql = "update account set email = '{$email}' where uid='{$uid}'";
            if (Execute($conn, $sql)) {$email = "y";}else{$email = "n";}
        }else{
            $email = "y";
        }
        //判断是否修改tk并修改
                //判断是否修改afdid并修改
        if ($_POST['by_town'] !== "") {
            if (mb_strlen($_POST['by_town'], 'UTF8') > 50) {
                Notifications("./edit.php?state=editAccount&uid={$uid}","ID不得超出50个字符！","w");
            }
            $sql = "update account set by_town = '{$by_town}' where uid='{$uid}'";
            if (Execute($conn, $sql)) {$by_town = "y";}else{$by_town = "n";}
        }else{
            $by_town = "y";
        }
                        //判断是否修改afdid并修改
        if ($_POST['isProfile'] !== "") {
            if (mb_strlen($_POST['isProfile'], 'UTF8') > 50) {
                Notifications("./edit.php?state=editAccount&uid={$uid}","ID不得超出50个字符！","w");
            }
            $sql = "update account set isProfile = '{$isProfile}' where uid='{$uid}'";
            if (Execute($conn, $sql)) {$isProfile = "y";}else{$isProfile = "n";}
        }else{
            $isProfile = "y";
        }
                        //判断是否修改afdid并修改
        if ($_POST['isDiscord'] !== "") {
            if (mb_strlen($_POST['isDiscord'], 'UTF8') > 50) {
                Notifications("./edit.php?state=editAccount&uid={$uid}","ID不得超出50个字符！","w");
            }
            $sql = "update account set isDiscord = '{$isDiscord}' where uid='{$uid}'";
            if (Execute($conn, $sql)) {$isDiscord = "y";}else{$isDiscord = "n";}
        }else{
            $isDiscord = "y";
        }
        
        //判断是否修改tk并修改
        if ($_POST['tk'] !== "") {
            if (mb_strlen($_POST['tk'], 'UTF8') > 32) {
                Notifications("./edit.php?state=editAccount&uid={$uid}","Token不得超出32个字符！","w");
            }
            $sql = "update account set tk = '{$tk}' where uid='{$uid}'";
            if (Execute($conn, $sql)) {$tk = "y";}else{$tk = "n";}
        }else{
            $tk = "y";
        }
        if($password == "y" && $username == "y" && $status == "y" && $afd_id == "y" && $afd_tk == "y" && $tk == "y" && $email == "y"){
            Notifications("./account.php","编辑成功！","s");
        }
        Notifications("./edit.php?state=editAccount&id={$id}","用户名:{$username}/封禁状态:{$status}/AFDToken:{$afd_tk}/AFDID:{$afd_id}/Token:{$tk}/邮箱:{$email}/密码:{$password}","w");
    }
    //删除账户
    if ($_GET['state'] == 'deleteAccount') {
        $uid = Escape($conn, $_GET['uid']);
        $sql = Execute($conn, "select * from account where uid = '{$uid}'");//查询数据
        if (mysqli_num_rows($sql) !== 1) {
            Notifications("./account.php","该账户不存在！","w");
        }
        $sql = "delete from account where uid = '{$uid}'";
        if (Execute($conn, $sql)) {
            Notifications("./account.php","删除成功！","s");
        }else{
            Notifications("./account.php","删除失败！","d");
        }
    }
    
    Notifications("./","参数无效！","d");
    Close($conn); //关闭数据库连接
?>