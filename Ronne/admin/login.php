<?php
    //页面标题
    define('pageTittle', '登入');
    include './public-head.php';
    //判断是否登入
    if (!empty($_SESSION['id'])) {
        Notifications("./index.php","您已登入");
    }
    include '../public/curl.php';
    //一言参数
    $headers = array("Content-type:application/x-www-form-urlencoded");
    $responseXml = curlRequest("https://v1.hitokoto.cn/?min_length=28", "GET", 1,'','');
    
    //判断响应是否成功
    if (isset($responseXml['Error'])) {
        $yiyan_data['hitokoto'] = "你写下的每一个bug，都是人类反抗被人工智能统治的一颗子弹!";
        $yiyan_data['from'] = "";
        $yiyan_data['from_who'] = "辣椒の酱";
    }else{
        //解码json数据
        $yiyan_data = json_decode($responseXml,TRUE);    
    }
?>

    <!-- <body data-layout="horizontal"> -->
        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-xxl-3 col-lg-4 col-md-5">
                        <div class="auth-full-page-content d-flex p-sm-5 p-4">
                            <div class="w-100">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4 mb-md-5 text-center">
                                        <a href="index.html" class="d-block auth-logo">
                                            <img src="../assets/admin/picture/logo-sm.svg" alt="" height="28"> <span class="logo-txt"><?echo $system_data["tittle"];?></span>
                                        </a>
                                    </div>
                                    <form  method="post" action="./api.php" enctype="multipart/form-data">
                                    <div class="auth-content my-auto">
                                        <div class="text-center">
                                            <h5 class="mb-0">Welcome Back</h5>
                                            <p class="text-muted mt-2"> 登 入 <?echo $system_data["tittle"];?>.</p>
                                        </div>
                                        <form class="custom-form mt-4 pt-2">
                                            <div class="mb-3">
                                                <input name="state" style="display: none;" value="login" />
                                                <label class="form-label">用 户 名</label>
                                                <input type="text" class="form-control" name="username" placeholder="输入用户名">
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">密 码</label>
                                                    </div>
                                                </div>
                                                
                                                <div class="input-group auth-pass-inputgroup">
                                                    <input type="password" name="password" class="form-control" placeholder="输入密码" aria-label="Password" aria-describedby="password-addon">
                                                    <button class="btn btn-light shadow-none ms-0" type="button" ><i class="mdi mdi-eye-outline"></i></button>
                                                </div>
                                            </div>
                                            
                                            <div class="row mb-4">
                                                <div class="col">
                                                    <!-- 极验 --> 
                                                    <div id="embed-captcha"></div>
                                                    <div id="notice" class="hide" role="alert">请先完成验证</div>
                                                    <p id="wait" class="show">正在加载验证码......</p>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <button id="embed-submit" class="btn btn-primary w-100 waves-effect waves-light" type="submit">登 入</button>
                                            </div>
                                        </form>
                                        <?Vnotifications()?>
                                        <!--
                                        <div class="mt-4 pt-2 text-center">
                                            <div class="signin-other-title">
                                                <h5 class="font-size-14 mb-3 text-muted fw-medium">- 快 捷 方 式 -</h5>
                                            </div>

                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="javascript:void()" class="social-list-item bg-primary text-white border-primary">
                                                        <i class="mdi mdi-facebook"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void()" class="social-list-item bg-info text-white border-info">
                                                        <i class="mdi mdi-twitter"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void()" class="social-list-item bg-danger text-white border-danger">
                                                        <i class="mdi mdi-google"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        
                                        <div class="mt-5 text-center">
                                            <p class="text-muted mb-0">Don't have an account ? <a href="auth-register.html" class="text-primary fw-semibold"> Signup now </a> </p>
                                        </div>
                                        -->
                                    </div>
                                    </form>
                                    <div class="mt-4 mt-md-5 text-center">
                                        <p class="mb-0">
                                            <?echo $system_data["copyright"];?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end auth full page content -->
                    </div>
                    <!-- end col -->
                    <div class="col-xxl-9 col-lg-8 col-md-7">
                        <div class="auth-bg pt-md-5 p-4 d-flex" style="background-image:url(../assets/admin/image/auth-bg.jpg)">
                            <div class="bg-overlay bg-primary"></div>
                            <ul class="bg-bubbles">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                            <!-- end bubble effect -->
                            <div class="row justify-content-center align-items-center">
                                <div class="col-xl-7">
                                    <div class="p-0 p-sm-4 px-xl-0">
                                        <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                            <!-- end carouselIndicators -->
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“<?echo $yiyan_data['hitokoto'];?>”</h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                            <div class="d-flex align-items-start">
                                                                <div class="flex-shrink-0">
                                                                    <img src="../assets/admin/image/fijuIH.png" class="avatar-md img-fluid rounded-circle" alt="...">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3 mb-4">
                                                                    <h5 class="font-size-18 text-white"><?echo $yiyan_data['from_who'];?>
                                                                    </h5>
                                                                    <p class="mb-0 text-white-50"><?echo $yiyan_data['from'];?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end carousel-inner -->
                                        </div>
                                        <!-- end review carousel -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>
        <!-- JAVASCRIPT -->
        <script src="../assets/admin/js/jquery.min.js"></script>
        <script src="../assets/admin/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/admin/js/metisMenu.min.js"></script>
        <script src="../assets/admin/js/simplebar.min.js"></script>
        <script src="../assets/admin/js/waves.min.js"></script>
        <script src="../assets/admin/js/feather.min.js"></script>
        <!-- pace js -->
        <script src="../assets/admin/js/pace.min.js"></script>
        <!-- password addon init -->
        <script src="../assets/admin/js/pass-addon.init.js"></script>
        <!-- 引入极验所需 -->
        <?require_once '../public/geetest/geetest.php';?>
    </body>

</html>