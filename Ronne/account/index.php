<?php
    //页面标题
    define('pageTittle', '用户中心');
    include './header.php';
    include './public1.php';
    //订单总数
    $sql="select * from dingdan where yonghu = '{$account_data['username']}'";
    $payorder_number=mysqli_num_rows(Execute($conn, $sql));

    //待审核订单总数
    $sql="select * from dingdan where yonghu = '{$account_data['username']}' and zhuangtai = 'dengdai'";
    $dengdai=mysqli_num_rows(Execute($conn, $sql));
    
    //已完成订单总数
    $sql="select * from dingdan where yonghu = '{$account_data['username']}' and zhuangtai = 'wancheng'";
    $wancheng=mysqli_num_rows(Execute($conn, $sql));
    
    //处理中订单总数
    $sql="select * from dingdan where yonghu = '{$account_data['username']}' and zhuangtai = 'chuli'";
    $chuli=mysqli_num_rows(Execute($conn, $sql));
    
    //被驳回订单总数
    $sql="select * from dingdan where yonghu = '{$account_data['username']}' and zhuangtai = 'buxing'";
    $buxing=mysqli_num_rows(Execute($conn, $sql));
    
    //爱发电库
    include($_SERVER['DOCUMENT_ROOT']."/pay/afd/afdian.php");
    
    //爱发电实例
    define("USERID", $account_data['afd_id']);
    define("TOKEN", $account_data['afd_tk']);
    //新建对象
    $afdian = new Afdian(USERID, TOKEN);
    
    //公告分页
    $page_now_page = Escape($conn,$_GET['page']);
    $page_result = page($conn,'select * from contents',"top",1,5,$page_now_page,$page_totalPage);
    
    $current_username = $account_data['username'];
    $sql_user = "SELECT isOP, chance FROM account WHERE username = '$current_username'";
    $result_user = $conn->query($sql_user);
    $user_data = $result_user->fetch_assoc();
    $user_power = $user_data['isOP'];
    $user_chance = $user_data['chance'];
?>
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">用户中心</h4>
                                </div>
                            </div>
                        </div>
                        <?Vnotifications()?>
                        <!-- end page title -->
                        
                        <div class="row">
                            <div class="col-xl-9 col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm order-2 order-sm-1">
                                                <div class="d-flex align-items-start mt-3 mt-sm-0">
                                                    <div class="flex-shrink-0">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div>
                                                            <div><h5><i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>欢迎回来，<?echo $account_data['username'];?>。</div></h5>

                                                            <div class="d-flex flex-wrap align-items-start gap-2 gap-lg-3 text-muted font-size-13">
                                                                <div><h5><i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>你上一次登录是在... <?echo $account_data['sign_time'];?> (GMT+8)</h5></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->

                                <div class="tab-content">
                                    <div class="tab-pane active" id="overview" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">我的资料</h5>
                                            </div>
                                            <div class="card-body">
                                                <div>
                                                    <div class="pb-3">
                                                        <div class="row mb-4">
                                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">申领物资</label>
                                                            <div class="col-sm-9">
<?php if ($user_chance > 0 || $user_power == 1): ?>
    <a href="./suborder.php">
        <button type="button" class="btn btn-success waves-effect btn-label waves-light">
            <i class="bx bx-check-double label-icon"></i>
            <?php echo ($user_power == 0 && $user_chance == 1) ? "今日次数用尽" : "现在去申请"; ?>
        </button>
    </a>
<?php else: ?>
    <a href="index.php?notifications_state=w&notifications=您的提交次数已用尽，暂时不能提交。每日0点(GMT+8)刷新次数。">
        <button type="button" class="btn btn-danger waves-effect btn-label waves-light"><i class="bx bx-block label-icon"></i>
            今日次数用尽
        </button>
    </a>
<?php endif; ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pb-3">
                                                        <div class="row mb-4">
                                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">用户ID</label>
                                                            <div class="col-sm-9">
                                                              <input type="text" class="form-control" id="horizontal-firstname-input" value="<?echo $account_data['username'];?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">唯一密钥</label>
                                                            <div class="col-sm-9">
                                                              <input type="text" class="form-control" id="horizontal-firstname-input" value="<?echo $account_data['tk'];?>" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->

                                    </div>
                                    <!-- end tab pane -->
                                </div>
                                <!-- end tab content -->
                            </div>
                            <!-- end col -->

                            <div class="col-xl-3 col-lg-4">

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">订单数据</h5>

                                        <div>
                                            <ul class="list-unstyled mb-0">
                                                <li><h5>
                                                    <i class="mdi mdi-briefcase text-primary me-1"></i> 全部订单：<?echo $payorder_number?>
                                                </li></h5>
                                                
                                                <li>
                                                    <i class="mdi mdi-briefcase-check text-primary me-1"></i> 待审核的订单：<?echo $dengdai?>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-briefcase text-primary me-1"></i> 正在处理的订单：<?echo $chuli?>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-briefcase-check text-primary me-1"></i> 已完成的订单：<?echo $wancheng?>
                                                </li>
                                                                                                <li>
                                                    <i class="mdi mdi-briefcase text-primary me-1"></i> 被驳回的订单：<?echo $buxing?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            
                        </div><!-- end row-->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

<?php include 'footer.php';?>