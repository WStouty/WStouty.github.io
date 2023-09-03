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
    if($_GET['key'] != 'trade_no' and $_GET['key'] != 'out_trade_no' and $_GET['key'] != 'name' and $_GET['key'] != 'realmoney' and $_GET['key'] != 'money' and $_GET['key'] != 'buyer'){
        Notifications("./","搜索字段类型错误！","w");
    }
    if($_GET['date'] != "0-0-0" && !empty($_GET['date'])){
        $vdate = Escape($conn,$_GET['date']);
        $date = " and date = '{$vdate}'";
    }
    
    $key = Escape($conn,$_GET['key']);
    $page_now_page = Escape($conn,$_GET['page']);
    $searchcont = Escape($conn,$_GET['searchcont']);
    
    if($_GET['search'] == "payorder"){
        $Sreturn = $vdate."#".$searchcont;
        $sql = "select * from payorder where uid = '{$account_data['uid']}'{$date} and {$key} like binary '%{$searchcont}%'";
    }else{
        Notifications("./","没有找到搜索的类型！","w");
    }
    
    $page_result = page($conn,$sql,"addtime",1,15,$page_now_page,$page_totalPage);
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
    if($_GET['search'] == "payorder"){
?>
                                                        <th>商户单号</th>
                                                        <th>爱发电单号</th>
                                                        <th>支付方式</th>
                                                        <th>商品名称</th>
                                                        <th>商品金额</th>
                                                        <th>实付金额</th>
                                                        <th>创建时间</th>
                                                        <th>完成时间</th>
                                                        <th>购买用户</th>
                                                        <th>支付状态</th>
                                                        <th>回调状态</th>
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
        if($_GET['search'] == "payorder"){
?>
                                                        <th scope="row"><?echo $page_data['trade_no'];?></th>
                                                        <td><?echo $page_data['out_trade_no'];?></td>
                                                        <td><?echo $page_data['type'];?></td>
                                                        <td><?echo $page_data['name'];?></td>
                                                        <td><?echo $page_data['money'];?></td>
                                                        <td><?echo $page_data['realmoney'];?></td>
                                                        <td><?echo $page_data['addtime'];?></td>
                                                        <td><?echo $page_data['endtime'];?></td>
                                                        <td><?echo $page_data['buyer'];?></td>
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