<?php
    //页面标题
    define('pageTittle', '邮箱配置');
    include './header.php';
    include './public1.php';
?>
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">邮箱配置</h4>
                                </div>
                            </div>
                        </div>
                        <?Vnotifications()?>
                        <!-- end page title -->
                        
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">编辑 邮箱信息</h4>
                                        <p class="card-title-desc">
                                            注意:仅支持SMTP协议
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        
                                        <form method="post" action="./api.php" class="needs-validation" novalidate="">
                                            <input name="state" style="display: none;" value="emailConf" />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">用户名</label>
                                                        <input name="email_username" type="text" class="form-control" id="validationTooltip01" placeholder="email_username" value="<?echo $system_data['email_username'];?>" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">密码</label>
                                                        <input name="email_password" type="text" class="form-control" id="validationTooltip01" placeholder="email_password" value="<?echo $system_data['email_password'];?>" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">验证方式<code>TLS/ssl</code></label>
                                                        <input name="email_smtpsecure" type="text" class="form-control" id="validationTooltip01" placeholder="TLS/ssl" value="<?echo $system_data['email_smtpsecure'];?>" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">服务器地址</label>
                                                        <input name="email_host" type="text" class="form-control" id="validationTooltip01" placeholder="email_host" value="<?echo $system_data['email_host'];?>" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">服务器端口</label>
                                                        <input name="email_port" type="text" class="form-control" id="validationTooltip01" placeholder="25" value="<?echo $system_data['email_port'];?>" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">发件人姓名</label>
                                                        <input name="email_name" type="text" class="form-control" id="validationTooltip01" placeholder="PaperPay邮递员" value="<?echo $system_data['email_name'];?>" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit"> 提 交 </button>
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