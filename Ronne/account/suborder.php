<?php
    //页面标题
    define('pageTittle', '物资申领提交');
    include './header.php';
    include './public1.php';
    
?>
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">物资申领提交</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

<?php
$current_username = $account_data['username'];
$sql = "SELECT * FROM account WHERE username = '$current_username'";
$result_user = $conn->query($sql);
$user_data = $result_user->fetch_assoc();
$user_power = $user_data['isOP'];
$user_chance = $user_data['chance'];

$user_type = ($user_power == 1) ? '管理员' : '普通账户';
?>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">订单申请</h4>
                <p class="card-title-desc">
                    注意:订单进度将以邮件形式通知！不要重复提交！<br>
                    <code>账户等级：<?php echo $user_type; ?><br>
                    剩余次数：<?php echo $user_data['chance']; ?></code>
                </p>
            </div>
            <div class="card-body">
<style>
  .resizeable-container {
    resize: both;
    overflow: auto;
    width: 300px;
    border: 1px solid #ccc;
    padding: 10px;
  }
</style>
<form method="post" action="process_form.php">
<div class="form-row">
    <textarea name="field[]" class="form-control" rows="5">物资名称</textarea>
    <br>
    <textarea name="rfield[]" class="form-control" rows="1">申请理由</textarea>
    <br>
    <textarea name="weizhi[]" class="form-control" rows="1">邮寄地址</textarea>
</div>

    <br>
    <button type="submit" class="btn btn-success waves-effect btn-label waves-light"><i class="bx bx-check-double label-icon"></i>立即提交</button>
</form>

                                    </div>
                                </div>
                                <!-- end card -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
<?php include 'footer.php';?>
