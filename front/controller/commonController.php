<?php

    // ajax로 넘어오는 데이터 $page로 통일시키기

    if ($_POST['page']) {

        $page = $_POST['page'];

    }

    if ($_POST["act"]) {

        include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";

    }

    include_once dirname(dirname(dirname(__FILE__)))."/front/service/commonService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/memberService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/orderService.php";

    $result = array("success");

    // 메타태그
    try {

        $metaSerice = new MetaService();

        // 메타태그 조회
        $meta = $metaSerice -> metaSelect();

        if(!$meta){

            throw new Exception("service error : metaSelect");

        }

    } catch (Exception $errorMsg) {

        echo $errorMsg;

        exit;

    }

    // config
    try {

        $configSerice = new ConfigService();

        // config 조회
        $config = $configSerice -> configSelect();

        if (!$config) {

            throw new Exception("error : configSelect");

        }

        $connectIp = explode("◈", $config['adminIp']);

        if (!in_array($userIp, $connectIp)) {
    
            // 접속 가능 ip가 아닐때 에러페이지로 이동
            header("Location: ".$_SERVER['SERVER_NAME']."?error=401");
    
        }

    } catch (Exception $errorMsg) {

        echo $errorMsg;

        exit;

    }

    // 사이트 카테고리
    try {

        $categoryService = new CategoryService();

        // 사이트 카테고리 조회
        $category = $categoryService -> categorySelect();

        if(!$category){

            throw new Exception("service error : categorySelect");

        }

    } catch (Exception $errorMsg) {

        echo $errorMsg;

        exit;

    }

    // 헤더
    try {

        $orderService = new OrderService();

        // 장바구니 조회
        $cartSelect = $orderService -> cartSelect($userNo, "", "cart");

        // 좋아요 조회
        $wishSelect = $orderService -> wishSelect($userNo);

    } catch (Exception $errorMsg) {

        echo $errorMsg;

        exit;

    }

    if ($page == "search") {

        // 검색
        try {

            if ($_POST['act'] == "productSearch") {

                $searchService = new SearchService();

                // 상품 갯수 카운트
                $productSearchCount = $searchService -> productSearchCount();
    
                array_push($result, $productSearchCount);

                // 상품 조회
                $productSearchSelect = $searchService -> productSearchSelect();

                array_push($result, $productSearchSelect);

            }

            echo json_encode($result);

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    }

?>