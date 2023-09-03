<?php
    //页面标题
    define('pageTittle', '爱发电配置');
    include './header.php';
    include './public1.php';
?>

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">爱发电配置</h4>
                                </div>
                            </div>
                        </div>
                        <?Vnotifications()?>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">修改配置</h4>
                                        <p class="card-title-desc">
                                            注意:请先配置爱发电成功后即可正常发起订单<code>(用户中心显示爱发电配置状态)</code>
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        
                                        <form method="post" action="./api.php" class="needs-validation" novalidate="">
                                        <input name="state" style="display: none;" value="configAfd" />
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip03">爱发电ID</label>
                                                        <input name="afd_id" type="text" class="form-control" id="validationTooltip03" placeholder="id" required="" value="<?echo $account_data['afd_id']?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip03">爱发电Token</label>
                                                        <input name="afd_tk" type="password" class="form-control" id="validationTooltip03" placeholder="token" required="" value="<?echo $account_data['afd_tk']?>">
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