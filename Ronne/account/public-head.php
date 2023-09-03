<?php
    //引入公共库
    include './public.php';
    /*
    弹窗提示
    $_GET['notifications'] 内容
    $_GET['notifications_state'] 状态
    */
    function Vnotifications(){
        $GET=$_GET['notifications'];
        $GETS=$_GET['notifications_state'];
        if (!empty($GET) && !empty($GETS)) {
            if($GETS == "s"){$GETS = 'success'; $N = "成功"; $I= "check-all";}
            if($GETS == "d"){$GETS = 'danger'; $N = "错误"; $I= "block-helper";}
            if($GETS == "w"){$GETS = 'warning'; $N = "注意"; $I= "alert-outline";}
            if($GETS == "i"){$GETS = 'info'; $N = "信息"; $I= "alert-circle-outline";}
            if($GETS == "success" || $GETS == "danger" || $GETS == "warning"  || $GETS == "info"){
            echo '<div class="alert alert-'.$GETS.' alert-top-border alert-dismissible fade show" role="alert"><i class="mdi mdi-'.$I.' me-3 align-middle text-'.$GETS.'"></i><strong>'.$N.'</strong> - '.$GET.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        }
    }
    //响应模板明暗模式
    if(!empty($_GET['layoutmode'])){
        $expire=time()+60*60*24*30;
        if($_COOKIE['layoutmode'] == '' || $_COOKIE['layoutmode'] == 'dark'){
            setcookie("layoutmode", "light", $expire);
            Notifications("","切换为正常模式","i");
        }elseif($_COOKIE['layoutmode'] == 'light'){
            setcookie("layoutmode", "dark", $expire);
            Notifications("","切换为黑夜模式","i");
        }
    }
?>
    
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8">
        <title><?echo pageTittle;?> | <?echo $system_data["tittle"];?>系统</title>
	    <meta name="keywords" content='<?echo $system_data["keywords"];?>'>
    	<meta name="description" content='<?echo $system_data["descriptio"];?>'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
        <meta content="Themesbrand" name="author">
        <link rel="icon" href="../assets/admin/image/layers.png" type="image/x-icon" />

        <!-- flatpickr css -->
        <link href="../assets/admin/css/flatpickr.min.css" rel="stylesheet" type="text/css">

        <!-- DataTables -->
        <link href="../assets/admin/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">

        <!-- Responsive datatable examples -->
        <link href="../assets/admin/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css"> 

        <!-- preloader css -->
        <link rel="stylesheet" href="../assets/admin/css/preloader.min.css" type="text/css">

        <!-- Bootstrap Css -->
        <link href="../assets/admin/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
        <!-- Icons Css -->
        <link href="../assets/admin/css/icons.min.css" rel="stylesheet" type="text/css">
        <!-- App Css-->
        <link href="../assets/admin/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
        <!-- 编辑器-->
        <link rel="stylesheet" href="../assets/editor/css/editormd.css" />
        
    </head>

    <body 
        <?
            $layoutMode='data-layout-mode="dark" data-topbar="dark" data-sidebar="dark"';
            $h=date('H');
            if(isset($_COOKIE['layoutmode'])){
                if($_COOKIE['layoutmode'] == "dark"){
                    echo $layoutMode;  
                }elseif($_COOKIE['layoutmode'] == "light"){
                }
            }else{
                if($h<=6 || $h>=20){
                    echo $layoutMode;  
                }
            }
        ?>
    >
    <!-- <body data-layout="horizontal"> -->