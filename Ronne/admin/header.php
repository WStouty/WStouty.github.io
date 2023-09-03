<?php
    //引入模板公共头部资源
    include './public-head.php';
?>


        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="./index.php" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="../assets/admin/picture/logo-sm.svg" alt="" height="24">
                                </span>
                                <span class="logo-lg">
                                    <img src="../assets/admin/picture/logo-sm.svg" alt="" height="24"> <span class="logo-txt"><?echo $system_data['tittle']?></span>
                                </span>
                            </a>

                            <a href="./index.php" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="../assets/admin/picture/logo-sm.svg" alt="" height="24">
                                </span>
                                <span class="logo-lg">
                                    <img src="../assets/admin/picture/logo-sm.svg" alt="" height="24"> <span class="logo-txt"><?echo $system_data['tittle']?></span>
                                </span>
                            </a>
                            
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>
                    </div>

                    <div class="d-flex">
                        
                        <div class="dropdown d-inline-block">
                            <a href="?layoutmode=turn">
                            <button type="button" class="btn header-item me-2">
                                <i style="font-size: 20px;" class="mdi mdi-theme-light-dark"></i>
                            </button>
                            </a>
                        </div>
                        
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item bg-soft-light border-start border-end" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="../assets/admin/image/fijuIH.png" alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium"><?echo $admin_data['username'];?></span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item
                                <a class="dropdown-item" href="apps-contacts-profile.html"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Profile</a>
                                <a class="dropdown-item" href="auth-lock-screen.html"><i class="mdi mdi-lock font-size-16 align-middle me-1"></i> Lock screen</a>
                                <div class="dropdown-divider"></div>
                                -->
                                <a class="dropdown-item" href="./api.php?state=logout"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> 退出</a>
                            </div>
                        </div>

                    </div>
                </div>
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar="" class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" data-key="t-menu">菜单</li>

                            <li>
                                <a href="index.php">
                                    <i data-feather="home"></i>
                                    <span data-key="t-dashboard">控制面板</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="pie-chart"></i>
                                    <span data-key="t-apps">数据管理</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="contents.php">
                                            <span data-key="t-calendar">文章管理</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="account.php">
                                            <span data-key="t-calendar">账户管理</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="payorder.php">
                                            <span data-key="t-calendar">订单管理</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
<? if ($admin_data['power'] == "1") {?>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="sliders"></i>
                                    <span data-key="t-apps">系统管理</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="user.php">
                                            <span data-key="t-calendar">系统管理员</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="email.php">
                                            <span data-key="t-chat">邮箱配置</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="system.php">
                                            <span data-key="t-chat">系统信息</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
<?}?>
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

