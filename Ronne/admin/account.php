<?php
    //页面标题
    define('pageTittle', '账户管理');
    include './header.php';
    include './public1.php';
    $page_now_page = Escape($conn,$_GET['page']);
    $page_result = page($conn,'select * from account',"uid",1,15,$page_now_page,$page_totalPage);
?>
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">账户管理</h4>
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
                                                <div class="mb-4">
                                                    <a href="./api.php?state=addAccount">
                                                    <button type="button" class="btn btn-light waves-effect waves-light"><i class="bx bx-plus me-1"></i> 添加账户</button>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-sm-auto">
                                                <div class="d-flex align-items-center gap-1 mb-4">
                                                    <form method="get" action="./search.php">
                                                        <div class="form-group m-0">
                                                            <div class="input-group">
                                                                <input name="search" style="display: none;" value="account" />
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
                                                        <th>UID</th>
                                                        <th>用户名</th>
                                                        <th>EMAIL</th>
                                                        <th>注册时间</th>
                                                        <th>登陆时间</th>
                                                        <th>登录IP</th>
                                                        <th>城镇</th>
                                                        <th>封禁状态</th>
                                                        <th>Discord</th>
                                                        <th>常用语言</th>
                                                        <th>操作</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
<?
    while ($page_data = mysqli_fetch_array($page_result)){ 
?>
                                                    <tr>
                                                        <th scope="row"><?echo $page_data['uid'];?></th>
                                                        <td><?echo $page_data['username'];?></td>
                                                        <td><?echo $page_data['email'];?></td>
                                                        <td><?echo $page_data['set_time'];?></td>
                                                        <td><?echo $page_data['sign_time'];?></td>
                                                        <td><?echo $page_data['sign_ip'];?></td>
                                                        <td><?echo $page_data['by_town'];?></td>
                                                        <td>
                                                        <?if($page_data['status'] == "1"){?>
                                                        <button type="button" class="btn btn-soft-success waves-effect waves-light"><i class="bx bx-check-double font-size-16 align-middle"></i></button>
                                                        <?}else{?>
                                                        <button type="button" class="btn btn-soft-danger waves-effect waves-light"><i class="bx bx-block font-size-16 align-middle"></i></button>
                                                        <?}?>
                                                        </td>
                                                        <td>
                                                        <?if($page_data['isDiscord'] == "1"){?>
                                                        <button type="button" class="btn btn-soft-success waves-effect waves-light"><i class="bx bx-check-double font-size-16 align-middle"></i></button>
                                                        <?}else{?>
                                                        <button type="button" class="btn btn-soft-danger waves-effect waves-light"><i class="bx bx-block font-size-16 align-middle"></i></button>
                                                        <?}?>
                                                        </td>
                                                        <td><?echo $page_data['isProfile'];?></td>
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
                                                                <a href="?page=1" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">首页</a>
                                                            </li>
                                                            <?if(!empty($_GET['page']) && $_GET['page'] !== "1"){ ?>
                                                            <li class="paginate_button page-item next" id="DataTables_Table_0_next">
                                                                <a href="?page=<?echo $page_now_page - 1;?>" aria-controls="DataTables_Table_0" data-dt-idx="3" tabindex="0" class="page-link link-instanted">上一页</a>
                                                            </li>
                                                            <?}?>
                                                            <li class="paginate_button page-item ">
                                                                <a aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" class="page-link"><?echo $page_now_page."/".$page_totalPage;?></a>
                                                            </li>
                                                            <?if($page_totalPage > $page_now_page){?>
                                                            <li class="paginate_button page-item next" id="DataTables_Table_0_next">
                                                                <a href="?page=<?echo $page_now_page + 1;?>" aria-controls="DataTables_Table_0" data-dt-idx="3" tabindex="0" class="page-link link-instanted">下一页</a>
                                                            </li>
                                                            <?}?>
                                                            <li class="paginate_button page-item previous" id="DataTables_Table_0_previous">
                                                                <a href="?page=<?echo $page_totalPage;?>" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link">尾页</a>
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