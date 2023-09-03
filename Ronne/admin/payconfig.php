<?php
    //页面标题
    define('pageTittle', '支付配置');
    include './header.php';
    include './public1.php';
?>
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">支付配置</h4>
                                </div>
                            </div>
                        </div>
                        <?Vnotifications()?>
                        <!-- end page title -->
                        
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">编辑 支付信息</h4>
                                        <p class="card-title-desc">
                                            注意:请配置定时任务每分钟一次轮询该地址"<code><?echo $system_data['url']."/pay/automatic/dbAuto.php?key=".$payconf_data['auto_key']?></code>"
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        
                                        <form method="post" action="./api.php" class="needs-validation" novalidate="">
                                            <input name="state" style="display: none;" value="payConf" />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">订单最小价格[大于5]</label>
                                                        <input name="pay_minmoney" type="text" class="form-control" id="validationTooltip01" placeholder="5" value="<?echo $payconf_data['pay_minmoney'];?>" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">订单最大价格[小于10000]</label>
                                                        <input name="pay_maxmoney" type="text" class="form-control" id="validationTooltip01" placeholder="1000" value="<?echo $payconf_data['pay_maxmoney'];?>" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">订单自动轮询KEY[必要]</label>
                                                        <input name="auto_key" type="text" class="form-control" id="validationTooltip01" placeholder="xxx" value="<?echo $payconf_data['auto_key'];?>" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">屏蔽词[注意格式]</label>
                                                        <textarea name="blockname" type="text" class="form-control" id="validationTooltip01" placeholder='xxx|xxx|xxx' required=""><?echo $payconf_data['blockname'];?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">违规订单拦截提示</label>
                                                        <textarea name="blockalert" type="text" class="form-control" id="validationTooltip01" placeholder='温馨提醒该商品禁止出售，如有疑问请联系网站客服！' required=""><?echo $payconf_data['blockalert'];?></textarea>
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