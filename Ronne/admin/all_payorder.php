<?php
    //页面标题
    $usernamex = $account_data['username'];
    define('pageTittle', '整合订单管理');
    include './header.php';
    include './public1.php';
    $sql = "SELECT * FROM dingdan WHERE yonghu = '{$usernamex}'";
    
    $mergedData = array();

foreach ($data as $order) {
    $riqi = $order['riqi'];
    $yonghu = $order['yonghu'];

    // 将 riqi 和 yonghu 作为联合键来合并数据
    $key = $riqi . '|' . $yonghu;

    if (array_key_exists($key, $mergedData)) {
        // 已存在相同键值的数据，累加数量
        $mergedData[$key]['shuliang'] += $order['shuliang'];
    } else {
        // 否则添加新的合并数据项
        $mergedData[$key] = $order;
    }
}

foreach ($mergedData as $mergedOrder) {
    echo '<tr>';
    echo '<td>' . $mergedOrder['id'] . '</td>';
    echo '<td>' . $mergedOrder['yonghu'] . '</td>';
    echo '<td>' . $mergedOrder['wupin'] . '</td>';
    echo '<td>' . $mergedOrder['shuliang'] . '</td>';
    echo '<td>' . $mergedOrder['riqi'] . '</td>';
    // ... （其他列数据）
    echo '</tr>';
}
?>
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18"><?echo $usernamex['username'];?>整合订单管理</h4>
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
                                                        <th>数量</th>
                                                        <th>申请日期</th>
                                                        <th>状态</th>
                                                    </tr>
                                                </thead>
<tbody>
<?php
    
    while ($page_data = mysqli_fetch_array($page_result)) { 
?>
    <tr>
        <td><?php echo $page_data['id']; ?></td>
        <th scope="row"><?php echo $page_data['yonghu']; ?></th>
        <td><?php echo $page_data['wupin']; ?></td>
        <td><?php echo $page_data['shuliang']; ?></td>
        <td><?php echo $page_data['riqi']; ?></td>
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