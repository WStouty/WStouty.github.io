<?php
    //页面标题
    define('pageTittle', '编辑');
    include './header.php';
    include './public1.php';
?>

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">编辑</h4>
                                </div>
                            </div>
                        </div>
                        <?Vnotifications()?>
                        <!-- end page title -->
<?if($_GET['state'] == "editPassword"){?>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">修改密码</h4>
                                        <p class="card-title-desc">
                                            注意:<code>(字符限制6-24)</code>
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        
                                        <form method="post" action="./api.php" class="needs-validation" novalidate="">
                                        <input name="state" style="display: none;" value="editPassword" />
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip03">原密码</label>
                                                        <input name="password1" type="password" class="form-control" id="validationTooltip03" placeholder="password" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip03">新密码</label>
                                                        <input name="password2" type="password" class="form-control" id="validationTooltip03" placeholder="password" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip03">重复新密码</label>
                                                        <input name="password3" type="password" class="form-control" id="validationTooltip03" placeholder="password" required="">
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
<?}elseif($_GET['state'] == "editUsername"){?>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">修改用户名</h4>
                                        <p class="card-title-desc">
                                            注意:<code>(字符限制6-24)</code>
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        
                                        <form method="post" action="./api.php" class="needs-validation" novalidate="">
                                        <input name="state" style="display: none;" value="editUsername" />
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip03">新用户名</label>
                                                        <input name="username" type="text" class="form-control" id="validationTooltip03" placeholder="新用户名" required="">
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
<?}else{Notifications("./","参数出现无效","d");}?>
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
<?php include 'footer.php';?>