<?php
    //判断是否登入
    if (empty($_SESSION['id'])) {
        Notifications("login.php","请先登录","w");
    }
    
    function page($conn,$sql,$by,$desc,$page_per_number,&$page_now_page,&$page_totalPage){
        
        $page_sql_whole = Execute($conn,$sql); //获得记录总数
        $page_rs = mysqli_num_rows($page_sql_whole);
            
        $page_totalPage = ceil($page_rs/$page_per_number);
        if (empty($page_now_page)) {$page_now_page = 1;}
        if ($desc == 1) {$desc = "desc";}else{$desc = "";}
        if (empty($by)) {$by = "id";}        
        $page_start_count = ($page_now_page-1)*$page_per_number;

        $page_result =  Execute($conn,$sql." order by {$by} {$desc} limit {$page_start_count},{$page_per_number}");
        return $page_result;
    }
?>