<?php
    //页面标题
    define('pageTittle', '用户中心');
    include './header.php';
    include './public1.php';
    //订单总数
    $sql="select * from payorder where uid = '{$account_data['uid']}'";
    $payorder_number=mysqli_num_rows(Execute($conn, $sql));
    //当天订单总数
    $date = date("Y-m-d",time());
    $sql="select * from payorder where uid = '{$account_data['uid']}' and date = '{$date}'";
    $payorder_daynumber=mysqli_num_rows(Execute($conn, $sql));
    
    //已支付订单总数
    $sql="select * from payorder where uid = '{$account_data['uid']}' and status = '1'";
    $payorder_1number=mysqli_num_rows(Execute($conn, $sql));
    //今日已支付订单总数
    $date = date("Y-m-d",time());
    $sql="select * from payorder where uid = '{$account_data['uid']}' and date = '{$date}' and status = '1'";
    $payorder_1daynumber=mysqli_num_rows(Execute($conn, $sql));
    
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
                                    <h4 class="mb-sm-0 font-size-18">龙尼新闻</h4>
                                    <code>若没有侧边栏请试着横屏过来~</code>
                                </div>
                            </div>
                        </div>
                        <?Vnotifications()?>
                        <!-- end page title -->
                        <div class="row">
<iframe src="https://ronne.ntcor.net/news/" height="750px" frameborder="0" scrolling="auto"> </iframe>
                            
                        </div><!-- end row-->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

<?php include 'footer.php';?>