<?php
    @header("Content-type: text/html; charset=utf-8");
    //引入数据库配置
    require_once "../config/sqlConfig.php";
    //引入数据库操作函数库
    require_once "../public/dbInc.php";

    //启动session
    @session_start();

    //数据库连接检测
    $conn = Connect();


    //其余

    // 报告 E_NOTICE 之外的所有错误
    error_reporting(E_ALL & ~E_NOTICE);
    
    //360网站卫士
    require_once(dirname(dirname(__FILE__)).'/public/360safe/360webscan.php');

    
    //ip获取函数
    function GetClientIp(){
        $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) and preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] as $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }
        return $ip;
    }
    //获取来源URL地址
    function SourceUrl() {
        $url = $_SERVER['HTTP_REFERER'];
        if(empty($url)){
            return "./";
        }
    	$rstr='';
    	$tmparr=parse_url($url);
    	$rstr=empty($tmparr['scheme'])?'http://':$tmparr['scheme'].'://';
    	$rstr.=$tmparr['host'].$tmparr['path'];
    	return $rstr;
    }
    //常用变量
    $ip = GetClientIp();
    $time = date("Y-m-d H:i:s",time());
    //通知并跳转 地址/内容
    function Notifications($href,$content,$state = "s"){
        if(strpos($href,'?') !== false){ 
            echo '<script>window.location.href="'.$href.'&notifications_state='.$state.'&notifications='.$content.'"</script>';
        }else{
            echo '<script>window.location.href="'.$href.'?notifications_state='.$state.'&notifications='.$content.'"</script>'; 
        }
        exit;
    }
    
    //生成随机数
    function randomkeys($length){
        $pattern=md5(time().'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ');
        return  mb_substr($pattern,0,$length);
    }
    
    //获取系统信息
    $sql = Execute($conn, "SELECT * FROM system");//查询数据
    $system_data = mysqli_fetch_all($sql);//查询表全部数据存入数组
    $system_data = array_column($system_data, 1, 0);//从二级数组中提取键1，0组成新数组
    //echo $system_data["copyright"];
    
    //获取支付配置
    $sql = Execute($conn, "SELECT * FROM payconf");//查询数据
    $payconf_data = mysqli_fetch_all($sql);//查询表全部数据存入数组
    $payconf_data = array_column($payconf_data, 1, 0);//从二级数组中提取键1，0组成新数组
    
    //获取管理员信息
    $sql = Execute($conn, "select * from user where id = '{$_SESSION['id']}'");//查询数据
    $admin_data = mysqli_fetch_assoc($sql);