<?php
//API入口1
//接受初步的易支付参数过滤，并生成一级订单
include "./pay/public.php";

//检查安装情况
if (is_dir("./install")) {
    if (!file_exists("./install/lock.txt")) {
        header("location:./install/index.php");
        exit;
    }
}

//检查传入参数
if(isset($_GET['pid'])){
	$queryArr=$_GET;
	$is_defend=true;
}elseif(isset($_POST['pid'])){
	$queryArr=$_POST;
}else{
    Notifications("./pay/000.php","你还未配置支付接口商户！");
}

//参数整理
$prestr = createLinkstring(argSort(paraFilter($queryArr)));
$pid=intval($queryArr['pid']);
if(empty($pid))Notifications("./pay/000.php","PID不存在！");

//查询数据是否存在并返回数据
$sql = Execute($conn, "select * from account where uid = '{$pid}'");
if (mysqli_num_rows($sql) !== 1){Notifications("./pay/000.php","商户不存在！");}else{
    $sql = Execute($conn, "select * from account where uid = '{$pid}'");//查询数据
    $account_data = mysqli_fetch_assoc($sql);
};

//校验签名
if(!md5Verify($prestr, $queryArr['sign'], $account_data['tk']))Notifications("./pay/000.php","签名校验失败，请重试！");
//检查商户状态
if($account_data['status'] == "0")Notifications("./pay/000.php","商户已封禁，无法支付！");
//检查商户afd是否配置
if(empty($account_data['afd_id']))Notifications("./pay/000.php","商户爱发电接口ID未配置！");
if(empty($account_data['afd_tk']))Notifications("./pay/000.php","商户爱发电接口TK未配置！");

//整理数据确保可入库
$type = Escape($conn, $queryArr['type']);
$out_trade_no = Escape($conn, $queryArr['out_trade_no']);
$notify_url = Escape($conn, $queryArr['notify_url']);
$return_url = Escape($conn, $queryArr['return_url']);
$name =  Escape($conn, $queryArr['name']);
$money =  Escape($conn, $queryArr['money']);
$sitename =  Escape($conn, $queryArr['sitename']);


//过滤过长字符串
if(strlen($out_trade_no) > 64)Notifications("./pay/000.php","单号不能超过64个字符");
//查询单号是否重复并返回数据
$sql = Execute($conn, "select * from payorder where trade_no='{$out_trade_no}'");
if (mysqli_num_rows($sql) == 1)Notifications("./pay/000.php","订单号已存在，请返回来源地重新发起请求！");

if(empty($out_trade_no))Notifications("./pay/000.php",'订单号(out_trade_no)不能为空');
if(empty($notify_url))Notifications("./pay/000.php",'通知地址(notify_url)不能为空');
if(empty($return_url))Notifications("./pay/000.php",'回调地址(return_url)不能为空');
if(empty($name))Notifications("./pay/000.php",'商品名称(name)不能为空');
if(empty($money))Notifications("./pay/000.php",'金额(money)不能为空');

if($money<=0 || !is_numeric($money) || !preg_match('/^[0-9.]+$/', $money))Notifications("./pay/000.php",'金额不合法');
if($payconf_data['pay_maxmoney']>0 && $money>$payconf_data['pay_maxmoney'])Notifications("./pay/000.php",'最大支付金额是'.$payconf_data['pay_maxmoney'].'元');
if($payconf_data['pay_minmoney']>0 && $money<$payconf_data['pay_minmoney'])Notifications("./pay/000.php",'最小支付金额是'.$payconf_data['pay_minmoney'].'元');
if(!preg_match('/^[a-zA-Z0-9.\_\-|]+$/',$out_trade_no))Notifications("./pay/000.php",'订单号(out_trade_no)格式不正确');
//获取请求方域名
$domain=getdomain($notify_url);
//检查商品名称
if(!empty($payconf_data['blockname'])){
	$block_name = explode('|',$payconf_data['blockname']);
	foreach($block_name as $rows){
		if(strpos($name,$rows)!==false){
			Notifications("./pay/000.php",$payconf_data['blockalert']);
		}
	}
}

$date = date('Y-m-d');
//订单写入数据库
$sql = "INSERT INTO payorder (trade_no, out_trade_no, uid, addtime, name, money, notify_url, return_url, domain, ip, status ,date)
VALUES ('{$out_trade_no}', '0', '{$pid}', '{$time}', '{$name}', '{$money}', '{$notify_url}', '{$return_url}', '{$domain}', '{$ip}', '0' ,'{$date}')";
if(!Execute($conn, $sql))Notifications("./pay/000.php","创建订单失败，请重试！");

if(empty($type)){
	echo "<script>window.location.href='./pay/cashier.php?trade_no={$out_trade_no}&sitename={$sitename}';</script>";
	exit;
}
echo "<script>window.location.href='./pay/cashier.php?trade_no={$out_trade_no}&sitename={$sitename}&type={$type}';</script>";
exit;
?>