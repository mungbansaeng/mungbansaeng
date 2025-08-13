<?php

    // ajax로 넘어오는 데이터 $page로 통일시키기

    if ($_POST['page']) {

        $page = $_POST['page'];

    }

    if ($_POST["act"]) { // 등록, 수정, 삭제일때 포함

        include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";
        include_once dirname(dirname(dirname(__FILE__)))."/front/service/commonService.php";

    }

    include_once dirname(dirname(dirname(__FILE__)))."/admin/service/couponService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/admin/service/memberService.php";

    $configService = new ConfigService();
    $couponService = new CouponService();
    $memberService = new MemberService();

    $result = array("success");

    if ($page == "coupon") { // 쿠폰

        try {

            if ($_POST['act'] == "view") {

                $memberLevelSelect = $memberService -> memberLevelSelect();

                array_push($result, $memberLevelSelect);

            } else if ($_POST['act'] == "reg") {

                $couponNo = GenerateString(2).strtotime(date("YmdHis")).GenerateString(2);
                $discountPrice = str_replace(',' ,'' , $_POST['discountPrice']);
                $minPrice = str_replace(',' ,'' , $_POST['minPrice']);
                $maxPrice = str_replace(',' ,'' , $_POST['maxPrice']);
                $deadline = $_POST['deadlineDate'] == "" ? $_POST['deadlineDay']."◈".$_POST['deadlineDayUnit'] : $_POST['deadlineDate'];
                $couponUseDesc = mysqli_real_escape_string($conn, $_POST['couponUseDesc']);
                $newViewDesc = mysqli_real_escape_string($conn, $_POST['description']);

                $couponInsert = $couponService -> couponInsert($couponNo, $discountPrice, $minPrice, $maxPrice, $deadline, $couponUseDesc, $newViewDesc, $adminNo);
                
                if (!$couponInsert) {

                    throw new Exception("error : couponInsert");
    
                }

            } else if ($_POST['act'] == "list") {

                // 쿠폰 리스트 카운트 조회
                $couponListCountSelect = $couponService -> couponListCountSelect();

                array_push($result, $couponListCountSelect);

                $couponListSelect = $couponService -> couponListSelect();

                array_push($result, $couponListSelect);

            } else if ($_POST['act'] == "modifyView") {

                // 쿠폰 상세 조회
                $couponSelect = $couponService -> couponSelect();

                array_push($result, $couponSelect);

            } else if ($_POST['act'] == "modify") {

                $couponNo = GenerateString(2).strtotime(date("YmdHis")).GenerateString(2);
                $discountPrice = str_replace(',' ,'' , $_POST['discountPrice']);
                $minPrice = str_replace(',' ,'' , $_POST['minPrice']);
                $maxPrice = str_replace(',' ,'' , $_POST['maxPrice']);
                $deadline = $_POST['deadlineDate'] == "" ? $_POST['deadlineDay']."◈".$_POST['deadlineDayUnit'] : $_POST['deadlineDate'];
                $couponUseDesc = mysqli_real_escape_string($conn, $_POST['couponUseDesc']);
                $newViewDesc = mysqli_real_escape_string($conn, $_POST['description']);

                // 쿠폰 수정
                $couponUpdate = $couponService -> couponUpdate($discountPrice, $minPrice, $maxPrice, $deadline, $couponUseDesc, $newViewDesc, $adminNo);

            }

            echo json_encode($result);

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    }

?>