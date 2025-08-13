<?php

    include_once dirname(dirname(dirname(__FILE__)))."/public/service/frontLogService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";

    // 로그
    $frontLogSerice = new FrontLogService();

    $startPage = $_POST['startPage'];
    $destination = $_POST['destination'];
    $result = $_POST['result'];

    if (!$_POST['startPage']) {

        $startPage = $_SERVER['HTTP_REFERER'];

    }
    
    if (!$_POST['destination']) {

        $destination = $_SERVER['PHP_SELF'];

    }

    if (!$_POST['result']) {

        $result = "success";

    }

    $frontLogSerice -> orderLogInsert($userNo, $_POST['data'], $_POST['event'], $startPage, $destination, $result);

?>