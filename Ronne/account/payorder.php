<?php
    define('pageTittle', '订单列表');
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
                                        <th>申领物资</th>
                                        <th>申请日期</th>
                                        <th>理由</th>
                                        <th>邮寄地址</th>
                                        <th>状态</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $current_username = $account_data['username'];
                                    $sql = "SELECT * FROM dingdan WHERE yonghu = '$current_username'";
                                    $page_result = page($conn, $sql, "id", 1, 10, $page_now_page, $page_totalPage);

                                    while ($page_data = mysqli_fetch_array($page_result)) { 
                                ?>
                                    <tr>
                                        <td><?php echo $page_data['id']; ?></td>
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
                                                <!-- ... -->
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                        <!-- 分页代码 -->
                                        <!-- ... -->
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