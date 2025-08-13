<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/public/common/config.php";
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/controller/commonController.php";

    $adminIpArr = explode("◈", $config['adminIp']);

    if (in_array($userIp, $adminIpArr) && $_SESSION['admin_id']) {

        // 접속 가능 ip이고 세션이 있으면 통과
        include_once dirname(dirname(__FILE__))."/admin/view/main/index.php";

    } else if (in_array($userIp, $adminIpArr) && !$_SESSION['admin_id']) {

        // 접속 가능 ip이고 세션이 없으면 로그인페이지로 이동
        include_once dirname(dirname(__FILE__))."/admin/view/main/login.php";

    } else {

        // 접속 가능 ip가 아닐때 에러페이지로 이동
        header("Location: ".$_SERVER['SERVER_NAME']."?error=404");

    }

?>