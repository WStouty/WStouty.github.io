<?php
    //页面标题
    define('pageTittle', '订单管理');
    include './header.php';
    include './public1.php';
?>
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">订单管理</h4>
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
                                            <div class="col-sm-auto">
                                                <div class="d-flex align-items-center gap-1 mb-4">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="table-responsive">
                                            <table class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>订单ID</th>
                                                        <th>用户</th>
                                                        <th>申领物资</th>
                                                        <th>申请日期</th>
                                                        <th>理由</th>
                                                        <th>邮寄地址</th>
                                                        <th>状态</th>
                                                        <th>操作</th>
                                                    </tr>
                                                </thead>
<tbody>
<?php
    $sql = "SELECT * FROM dingdan";
    $page_result = page($conn, $sql, "id", 1, 10, $page_now_page, $page_totalPage);
    
    while ($page_data = mysqli_fetch_array($page_result)) { 
?>
    <tr>
        <td><?php echo $page_data['id']; ?></td>
        <th scope="row"><?php echo $page_data['yonghu']; ?></th>
        <td><?php echo $page_data['wupin']; ?></td>
        <td><?php echo $page_data['riqi']; ?></td>
        <td><?php echo $page_data['rfield']; ?></td>
        <td><?php echo $page_data['weizhi']; ?></td>
        <td>
            <?php
            $zhuangtai = $page_data['zhuangtai'];
            if ($zhuangtai == 'dengdai') {
                echo "待审核";
            } elseif ($zhuangtai == 'chuli') {
                echo "处理中";
            } elseif ($zhuangtai == 'wancheng') {
                echo "已完成";
            } elseif ($zhuangtai == 'buxing') {
                echo "驳回";
            } else {
                echo "未知";
            }
            ?>
        </td>
        <td>
            <div class="dropdown">
                <!-- 下拉菜单的代码 -->

                                                            <div class="dropdown">
                                                                <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a class="dropdown-item" href="update_order.php?action=approve&id=<?php echo $page_data['id']; ?>">审核通过</a></li>
                                                                    <li><a class="dropdown-item" href="update_order.php?action=complete&id=<?php echo $page_data['id']; ?>">订单完成</a></li>
                                                                    <li><a class="dropdown-item" href="update_order.php?action=reject&id=<?php echo $page_data['id']; ?>">驳回订单</a></li>
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