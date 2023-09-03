<?php
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
<?
    if($_GET['state'] == "editUser" && !empty($_GET['id'])){
        $id = Escape($conn,$_GET['id']);
        $sql = Execute($conn,"select * from user where id = '{$id}'");//查询数据
        if(mysqli_num_rows($sql) !== 1){Notifications("./","用户不存在","w");}
        $user_data = mysqli_fetch_assoc($sql);
?>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">编辑 管理员ID:<?echo $user_data['id'];?></h4>
                                        <p class="card-title-desc">
                                            注意:密码留空默认不修改<code>(用户名,密码字符限制6-24)</code>
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        
                                        <form method="post" action="./api.php" class="needs-validation" novalidate="">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <input name="state" style="display: none;" value="editUser" />
                                                        <input name="id" style="display: none;" value="<?echo $user_data['id'];?>" />
                                                        <label class="form-label" for="validationTooltip01">用户名</label>
                                                        <input name="username" type="text" class="form-control" id="validationTooltip01" placeholder="username" value="<?echo $user_data['username'];?>" required="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 position-relative">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">权限</label>
                                                            <select name="power" required="" class="form-control form-select">
                                                                <?if($user_data['power'] == "2"){?>
                                                                <option value="2">管理员</option>
                                                                <option value="1">站长</option>
                                                                <?}else{?>
                                                                <option value="1">站长</option>
                                                                <option value="2">管理员</option>
                                                                <?}?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3 position-relative">
                                                        <label class="form-label" for="validationTooltip03">密码</label>
                                                        <input name="password" type="password" class="form-control" id="validationTooltip03" placeholder="password" required="">
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
<?
    }elseif($_GET['state'] == "editContents"){
        $id = Escape($conn,$_GET['id']);
        $sql = Execute($conn,"select * from contents where id = '{$id}'");//查询数据
        if(mysqli_num_rows($sql) !== 1){Notifications("./","文章不存在","w");}
        $contents_data = mysqli_fetch_assoc($sql);
?>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">编辑 文章ID:<?echo $contents_data['id'];?></h4>
                                        <p class="card-title-desc">注意:请不要在"*"项中填入HTML代码</p>
                                    </div>
                                    <div class="card-body">
                                        
                                        <form method="post" action="./api.php" class="needs-validation" novalidate="">
                                            <div class="row">
                                                <div class="row">                                                            
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="formrow-email-input">标题</label>
                                                            <input name="tittle" type="text" class="form-control" id="validationTooltip01" placeholder="tittle" value="<?echo $contents_data['tittle'];?>" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="formrow-password-input">*封面图</label>
                                                            <input name="oneimg" type="text" class="form-control" id="validationTooltip01" placeholder="http://xxx.xxx.xxx/img.jpg" value="<?echo $contents_data['oneimg'];?>" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">置顶</label>
                                                            <select name="top" required="" class="form-control form-select">
                                                                <?if($contents_data['top'] == "1"){?>
                                                                <option value="1">设置</option>
                                                                <option value="0">取消</option>
                                                                <?}else{?>
                                                                <option value="0">取消</option>
                                                                <option value="1">设置</option>
                                                                <?}?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3 position-relative">
                                                        <input name="state" style="display: none;" value="editContents" />
                                                        <input name="id" style="display: none;" value="<?echo $contents_data['id'];?>" />
                                                        <div id="test-editor">
                                                            <textarea name="content" style="display:none;"><?echo $contents_data['content'];?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit"> 提 交 </button>
                                        </form>
                                    </div>
                                </div>
<?
    }elseif($_GET['state'] == "editAccount"){
        $uid = Escape($conn,$_GET['uid']);
        $sql = Execute($conn,"select * from account where uid = '{$uid}'");//查询数据
        if(mysqli_num_rows($sql) !== 1){Notifications("./","账户不存在","w");}
        $account_data = mysqli_fetch_assoc($sql);
?>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">编辑 账户UID:<?echo $account_data['uid'];?></h4>
                                        <p class="card-title-desc">注意:密码留空默认不修改<code>(用户名,密码字符限制6-24,token限制1-32)</code></p>
                                    </div>
                                    <div class="card-body">
                                        
                                        <form method="post" action="./api.php" class="needs-validation" novalidate="">
                                            <input name="state" style="display: none;" value="editAccount" />
                                            <input name="uid" style="display: none;" value="<?echo $_GET['uid']?>" />
                                            <div class="row">
                                                <div class="row">                                                            
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="formrow-email-input">用户名</label>
                                                            <input name="username" type="text" class="form-control" id="validationTooltip01" placeholder="username" value="<?echo $account_data['username'];?>" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="formrow-password-input">密码</label>
                                                            <input name="password" type="text" class="form-control" id="validationTooltip01" placeholder="password" value="" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">用户状态</label>
                                                            <select name="status" required="" class="form-control form-select">
                                                                <?if($account_data['status'] == "0"){?>
                                                                <option value="0">封禁</option>
                                                                <option value="1">正常</option>
                                                                <?}else{?>
                                                                <option value="1">正常</option>
                                                                <option value="0">封禁</option>
                                                                <?}?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">                                                            
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="formrow-email-input">邮箱</label>
                                                            <input name="email" type="email" class="form-control" id="validationTooltip01" placeholder="email" value="<?echo $account_data['email'];?>" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="formrow-email-input">游戏内ID</label>
                                                            <input name="afd_id" type="text" class="form-control" id="validationTooltip01" placeholder="id" value="<?echo $account_data['afd_id'];?>" required="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="formrow-email-input">二次确认Token(请复制下方随机生成的)</label>
                                                            <input name="afd_tk" type="text" class="form-control" id="validationTooltip01" placeholder="token" value="<?echo $account_data['afd_tk'];?>" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">                                                            
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="formrow-email-input">确认Token</label>
                                                            <input name="tk" type="text" class="form-control" id="validationTooltip01" placeholder="tittle" value="<?echo $account_data['tk'];?>" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="formrow-email-input">所属城镇</label>
                                                            <input name="by_town" type="text" class="form-control" id="validationTooltip01" placeholder="by_town" value="<?echo $account_data['by_town'];?>" required="">
                                                        </div>
                                                    </div>
                                                </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="formrow-email-input">常用语言</label>
                                                            <input name="isProfile" type="text" class="form-control" id="validationTooltip01" placeholder="isProfile" value="<?echo $account_data['isProfile'];?>" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label">Discord</label>
                                                            <select name="isDiscord" required="" class="form-control form-select">
                                                                <?if($account_data['isDiscord'] == "0"){?>
                                                                <option value="0">未加入</option>
                                                                <option value="1">已加入</option>
                                                                <?}else{?>
                                                                <option value="1">已加入</option>
                                                                <option value="0">未加入</option>
                                                                <?}?>
                                                            </select>
                                                        </div>
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
<?
    }else{
        Notifications("./","参数出现无效","d");
    }
?>
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
<?php include 'footer.php';?>