<?php

    // ajax로 넘어오는 데이터 $page로 통일시키기

    if ($_POST['page']) {

        $page = $_POST['page'];

    }

    include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/mainService.php";

    $mainService = new MainService();

    $result = array("success");

    // 메인페이지
    if ($page == "main") {

        try {

            // 메인 탑배너
            $mainTopBanner = $mainService -> mainTopBanner();

            array_push($result, $mainTopBanner);

            // 메인 베스트
            $mainBestList = $mainService -> mainBestList();

            array_push($result, $mainBestList);

            // 메인 후기
            $mainReviewList = $mainService -> mainReviewList();

            array_push($result, $mainReviewList);

            // 메인 뉴스
            $mainNewsList = $mainService -> mainNewsList();

            array_push($result, $mainNewsList);

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

        echo json_encode($result);

    }

?>