<?php
    //页面标题
    define('pageTittle', '龙尼新闻');
    include './header.php';
    include './public1.php';

// 连接数据库
$servername = "127.0.0.1";
$username_db = "storr";
$password = "XfjJfw5DGNiMWX4b";
$dbname = "storr";

$conn = new mysqli($servername, $username_db, $password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
    die("连接数据库失败: " . $conn->connect_error);
}

// 获取 URL 参数中的 id
$id = $_GET["id"];

// 查询数据库获取指定 id 的新闻内容
$sql = "SELECT * FROM contents WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $tittle = $row["tittle"]; // 注意这里改为 tittle
    $content = $row["content"];
    $time = $row["time"];
} else {
    echo "找不到指定的新闻。";
}

// 关闭数据库连接
$conn->close();
?>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18"><?php echo $tittle; ?></h4><p><?php echo $time; ?></p> <!-- 使用 PHP 输出标题 -->
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

                        <!-- 新闻内容 -->
                        <div><?php echo $content; ?></div>

                        <div class="table-responsive">
                            <!-- 此处可以添加新闻内容对应的表格等 -->
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