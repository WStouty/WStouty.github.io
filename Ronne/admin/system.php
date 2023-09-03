<?php
    //页面标题
    define('pageTittle', '系统信息');
    include './header.php';
    include './public1.php';
?>
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">系统信息</h4>
                                </div>
                            </div>
                        </div>
                        <?Vnotifications()?>
                        <!-- end page title -->
                        
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">编辑 系统信息</h4>
                                        <p class="card-title-desc">
                                            注意:请不要在非'*'项中填写HTML代码！
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        
                                        <form method="post" action="./api.php" class="needs-validation" novalidate="">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <input name="state" style="display: none;" value="editSystem" />
                                                        <label class="form-label" for="validationTooltip01">域名<code>[http(s)://xxx.xxx.xx]</code></label>
                                                        <input name="url" type="text" class="form-control" id="validationTooltip01" placeholder="http(s)://xxx.xxx.xx" value="<?echo $system_data['url'];?>" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">站点名称</label>
                                                        <input name="tittle" type="text" class="form-control" id="validationTooltip01" placeholder="PaperPay" value="<?echo $system_data['tittle'];?>" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">站点关键词</label>
                                                        <input name="keyworld" type="text" class="form-control" id="validationTooltip01" placeholder="PaperPay,吃纸怪" value="<?echo $system_data['keyworld'];?>" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">站点描述</label>
                                                        <input name="description" type="text" class="form-control" id="validationTooltip01" placeholder="我有一个想法，我正在努力实现！" value="<?echo $system_data['description'];?>" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">*站点版权</label>
                                                        <textarea name="copyright" type="text" class="form-control" id="validationTooltip01" placeholder='Copyright © 2022 <a href="//fatda.cn">Fatda.cn</a> All rights reserved' required=""><?echo $system_data['copyright'];?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip01">*友情链接</label>
                                                        <textarea name="friends" type="text" class="form-control" id="validationTooltip01" placeholder='<a href="//fatda.cn">Fatda.cn</a>' required=""><?echo $system_data['friends'];?></textarea>
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