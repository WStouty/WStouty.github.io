<?php
    //页面标题
    define('pageTittle', '搜索');
    include './header.php';
    include './public1.php';
    if (empty($_GET['searchcont'])) {
        Notifications("./","请输入搜索内容！","w");
    }
    if (mb_strlen($_GET['searchcont'], 'UTF8') > 30) {
        Notifications("./","搜索内容不得超出30个字符！","w");
    }
    $page_now_page = Escape($conn,$_GET['page']);
    $searchcont = Escape($conn,$_GET['searchcont']);
    if($_GET['search'] == "user"){
        $Sreturn = "用户 ".$searchcont;
        $sql = "select * from user where id like binary '%{$searchcont}%' or username like binary '%{$searchcont}%' or power like binary '%{$searchcont}%' or set_time like binary '%{$searchcont}%' or sign_time like binary '%{$searchcont}%'  or sign_ip like binary '%{$searchcont}%'";
        $limit = "id";
    }elseif($_GET['search'] == "contents"){
        $Sreturn = "文章 ".$searchcont;
        $sql = "select * from contents where id like binary '%{$searchcont}%' or tittle like binary '%{$searchcont}%' or user_id like binary '%{$searchcont}%' or top like binary '%{$searchcont}%' or ip like binary '%{$searchcont}%'  or time like binary '%{$searchcont}%'";
        $limit = "id";
    }elseif($_GET['search'] == "payorder"){
        if($_GET['key'] != 'trade_no' and $_GET['key'] != 'out_trade_no' and $_GET['key'] != 'name' and $_GET['key'] != 'realmoney' and $_GET['key'] != 'money' and $_GET['key'] != 'buyer'){
            Notifications("./","搜索字段类型错误！","w");
        }
        
        if($_GET['date'] != "0-0-0" && !empty($_GET['date'])){
            $vdate = Escape($conn,$_GET['date']);
            $date = " date = 'and {$vdate}'";
        }
        
        $key = Escape($conn,$_GET['key']);
        
        $Sreturn = $vdate."#".$searchcont;
        $sql = "select * from payorder where {$key} like binary '%{$searchcont}%'{$date}";
        $limit = "addtime";
    }elseif($_GET['search'] == "account"){
        $Sreturn = "账户 ".$searchcont;
        $sql = "select * from account where uid like binary '%{$searchcont}%' or email like binary '%{$searchcont}%' or username like binary '%{$searchcont}%' or sign_time like binary '%{$searchcont}%' or set_time like binary '%{$searchcont}%'";
        $limit = "uid";
    }else{
        Notifications("./","没有找到搜索的类型！","w");
    }
    
    $page_result = page($conn,$sql,$limit,1,15,$page_now_page,$page_totalPage);
?>
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">搜索</h4>
                                </div>
                            </div>
                        </div>
                        <?Vnotifications()?>
                        <!-- end page title -->
            
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm">
                                                <h4 class="card-title"><?echo $Sreturn;?> 的搜索结果</h4>
                                            </div>
                                            <div class="col-sm-auto">
                                                <div class="d-flex align-items-center gap-1 mb-4">
                                                    <form method="get" action="./search.php">
                                                        <div class="form-group m-0">
                                                            <div class="input-group">
<?
    if($_GET['search'] == "payorder"){
?>
                                                                <input name="search" style="display: none;" value="payorder" />
                                                                <input class="form-control" type="date" name="date" value="0-0-0" id="example-date-input">
                                                                <select class="form-select" name="key">
                                                                    <option value ="trade_no" >商户单号</option>
                                                                    <option value ="out_trade_no" >爱发电单号</option>
                                                                    <option value ="name" >商品名称</option>
                                                                    <option value ="money" >商品金额</option>
                                                                    <option value ="realmoney" >支付金额</option>
                                                                    <option value ="buyer" >购买用户</option>
                                                                </select>
                                                                <input name="searchcont" type="text" class="form-control" placeholder="Search ..." aria-label="Search Result">
                    
                                                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
<?
    }else{
?>
                                                                <input name="search" style="display: none;" value="<?echo $_GET['search'];?>" />
                                                                <input name="searchcont" type="text" class="form-control" placeholder="Search ..." aria-label="Search Result">
                    
                                                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
<?
    }
?>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="table-responsive">
                                            <table class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                                                <thead class="table-light">
                                                    <tr>
<?
    if($_GET['search'] == "user"){
?>
                                                        <th>ID</th>
                                                        <th>用户名</th>
                                                        <th>权限</th>
                                                        <th>登陆时间</th>
                                                        <th>登录IP</th>
                                                        <th>编辑时间</th>
                                                        <th>操作</th>
<?
    }elseif($_GET['search'] == "contents"){
?>
                                                        <th>ID</th>
                                                        <th>发布者ID</th>
                                                        <th>置顶状态</th>
                                                        <th>标题</th>
                                                        <th>编辑IP</th>
                                                        <th>编辑时间</th>
                                                        <th>操作</th>
<?
    }elseif($_GET['search'] == "payorder"){
?>
                                                        <th>商户单号</th>
                                                        <th>爱发电单号</th>
                                                        <th>商户UID</th>
                                                        <th>支付方式</th>
                                                        <th>商品名称</th>
                                                        <th>商品金额</th>
                                                        <th>实付金额</th>
                                                        <th>创建时间</th>
                                                        <th>完成时间</th>
                                                        <th>购买用户</th>
                                                        <th>商户域名</th>
                                                        <th>购买用户IP</th>
                                                        <th>支付状态</th>
                                                        <th>回调状态</th>
                                                        <th>操作</th>
<?
    }elseif($_GET['search'] == "account"){
?>
                                                        <th>UID</th>
                                                        <th>用户名</th>
                                                        <th>EMAIL</th>
                                                        <th>注册时间</th>
                                                        <th>登陆时间</th>
                                                        <th>登录IP</th>
                                                        <th>封禁状态</th>
                                                        <th>操作</th>
<?
    }
?>
                                                    </tr>
                                                </thead>
                                                <tbody>
<?
    while ($page_data = mysqli_fetch_array($page_result)){ 
?>
                                                    <tr>
<?
        if($_GET['search'] == "user"){
?>
                                                        <th scope="row"><?echo $page_data['id'];?></th>
                                                        <td><?echo $page_data['username'];?></td>
                                                        <td><?echo $page_data['power'];?></td>
                                                        <td><?echo $page_data['sign_time'];?></td>
                                                        <td><?echo $page_data['sign_ip'];?></td>
                                                        <td><?echo $page_data['set_time'];?></td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a class="dropdown-item" href="edit.php?state=editUser&id=<?echo $page_data['id'];?>">编辑</a></li>
                                                                    <li><a class="dropdown-item" href="api.php?state=deleteUser&id=<?echo $page_data['id'];?>">删除</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
<?
        }elseif($_GET['search'] == "contents"){
?>
                                                        <th scope="row"><?echo $page_data['id'];?></th>
                                                        <td><?echo $page_data['user_id'];?></td>
                                                        <td><?echo $page_data['top'];?></td>
                                                        <td><?echo $page_data['tittle'];?></td>
                                                        <td><?echo $page_data['ip'];?></td>
                                                        <td><?echo $page_data['time'];?></td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a class="dropdown-item" href="edit.php?state=editContents&id=<?echo $page_data['id'];?>">编辑</a></li>
                                                                    <li><a class="dropdown-item" href="api.php?state=deleteContents&id=<?echo $page_data['id'];?>">删除</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
<?
        }elseif($_GET['search'] == "payorder"){
?>
                                                        <th scope="row"><?echo $page_data['trade_no'];?></th>
                                                        <td><?echo $page_data['out_trade_no'];?></td>
                                                        <td><?echo $page_data['uid'];?></td>
                                                        <td><?echo $page_data['type'];?></td>
                                                        <td><?echo $page_data['name'];?></td>
                                                        <td><?echo $page_data['money'];?></td>
                                                        <td><?echo $page_data['realmoney'];?></td>
                                                        <td><?echo $page_data['addtime'];?></td>
                                                        <td><?echo $page_data['endtime'];?></td>
                                                        <td><?echo $page_data['buyer'];?></td>
                                                        <td><?echo $page_data['domain'];?></td>
                                                        <td><?echo $page_data['ip'];?></td>
                                                        <td><?if($page_data['status'] == 1){echo "成功";}else{echo "待付款";};?></td>
                                                        <td><?if($page_data['notify'] == 1){echo "成功";}else{echo "待回调";};?></td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a class="dropdown-item" href="api.php?state=notityOrder&trade_no=<?echo $page_data['trade_no'];?>">补单回调</a></li>
                                                                    <li><a class="dropdown-item" href="api.php?state=deleteOrder&trade_no=<?echo $page_data['trade_no'];?>">删除订单</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
<?
        }elseif($_GET['search'] == "account"){
?>
                                                        <th scope="row"><?echo $page_data['uid'];?></th>
                                                        <td><?echo $page_data['username'];?></td>
                                                        <td><?echo $page_data['email'];?></td>
                                                        <td><?echo $page_data['set_time'];?></td>
                                                        <td><?echo $page_data['sign_time'];?></td>
                                                        <td><?echo $page_data['sign_ip'];?></td>
                                                        <td>
                                                        <?if($page_data['status'] == "1"){?>
                                                        <button type="button" class="btn btn-soft-success waves-effect waves-light"><i class="bx bx-check-double font-size-16 align-middle"></i></button>
                                                        <?}else{?>
                                                        <button type="button" class="btn btn-soft-danger waves-effect waves-light"><i class="bx bx-block font-size-16 align-middle"></i></button>
                                                        <?}?>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a class="dropdown-item" href="edit.php?state=editAccount&uid=<?echo $page_data['uid'];?>">编辑</a></li>
                                                                    <li><a class="dropdown-item" href="api.php?state=deleteAccount&uid=<?echo $page_data['uid'];?>">删除</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
<?
        }
?>
                                                    </tr>
<?
    }
?>
                                                </tbody>
                                            </table>
                                            <div class="row">
                                                
                                                <div class="col-sm-12 col-md-7">
                                                    <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                                        <ul class="pagination">
                                                            
                                                            <li class="paginate_button page-item previous" id="DataTables_Table_0_previous">
                                                                <a href="?page=1<?echo '&searchcont='.$_GET['searchcont'].'&search='.$_GET['search'];?>" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">首页</a>
                                                            </li>
                                                            <?if(!empty($_GET['page']) && $_GET['page'] !== "1"){ ?>
                                                            <li class="paginate_button page-item next" id="DataTables_Table_0_next">
                                                                <a href="?page=<?$page = $page_now_page - 1;echo $page.'&searchcont='.$_GET['searchcont'].'&search='.$_GET['search'];?>" aria-controls="DataTables_Table_0" data-dt-idx="3" tabindex="0" class="page-link link-instanted">上一页</a>
                                                            </li>
                                                            <?}?>
                                                            <li class="paginate_button page-item ">
                                                                <a aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" class="page-link"><?echo $page_now_page."/".$page_totalPage;?></a>
                                                            </li>
                                                            <?if($page_totalPage > $page_now_page){?>
                                                            <li class="paginate_button page-item next" id="DataTables_Table_0_next">
                                                                <a href="?page=<?$page = $page_now_page + 1;echo $page.'&searchcont='.$_GET['searchcont'].'&search='.$_GET['search'];?>" aria-controls="DataTables_Table_0" data-dt-idx="3" tabindex="0" class="page-link link-instanted">下一页</a>
                                                            </li>
                                                            <?}?>
                                                            <li class="paginate_button page-item previous" id="DataTables_Table_0_previous">
                                                                <a href="?page=<?echo $page_totalPage.'&searchcont='.$_GET['searchcont'].'&search='.$_GET['search'];?>" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">尾页</a>
                                                            </li>
                                                            
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end table responsive -->
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

<?php include 'footer.php';?>