<?php

    // ajax로 넘어오는 데이터 $page로 통일시키기

    if ($_POST['page']) {

        $page = $_POST['page'];

    }

    include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";
    include_once dirname(dirname(dirname(__FILE__)))."/public/service/commonService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/commonService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/mypageService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/productService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/orderService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/memberService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/pointService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/couponService.php";

    $dbService = new DbService();
    $configService = new ConfigService();
    $mypageService = new MypageService();
    $productService = new ProductService();
    $attachFileService = new AttachFileService();
    $orderService = new OrderService();
    $memberService = new MemberService();
    $pointService = new PointService();
    $couponService = new CouponService();

    $result = array("success");

    // 마이페이지
    if ($page == "mypage") {

        try {

            if ($_POST["act"] == "mobileMypageHeader") { // 모바일 마이페이지 헤더

                $memberSelect = $memberService -> memberSelect($userNo);

                array_push($result, $memberSelect); // 회원정보

                $orderListSelect = $mypageService -> orderListSelect($userNo);

                array_push($result, COUNT($orderListSelect)); // 주문/배송 건수

                $reviewSelect = $mypageService -> reviewSelect($userNo);

                array_push($result, COUNT($reviewSelect)); // 후기 건수

                $couponDownloadSelect = $couponService -> couponDownloadSelect($userNo);

                array_push($result, COUNT($couponDownloadSelect)); // 쿠폰 건수
            
            } else if ($_POST["act"] == "orderList") { // 주문조회 페이지

                $orderProductList = array();

                $orderListSelect = $mypageService -> orderListSelect($userNo);

                array_push($result, $orderListSelect);

                for ($olc=0; $olc < COUNT($orderListSelect); $olc++) {

                    $orderProductSelect = $mypageService -> orderProductSelect($orderListSelect[$olc]['orderNo']);

                    array_push($orderProductList, $orderProductSelect);

                }

                array_push($result, $orderProductList);

            } else if ($_POST["act"] == "orderDetail") { // 주문상세 페이지
            
                $orderProductSelect = $mypageService -> orderProductSelect($_POST['orderNo']);

                array_push($result, $orderProductSelect);

                $orderListSelect = $mypageService -> orderInfoSelect($_POST['orderNo']);

                array_push($result, $orderListSelect);
            
            } else if ($_POST["act"] == "reviewWriteView") { // 후기작성 페이지

                $orderProductDetailSelect = $mypageService -> orderProductDetailSelect($_POST['orderProductCode']);

                array_push($result, $orderProductDetailSelect);
            
            } else if ($_POST["act"] == "reviewWrite") { // 후기작성

                $orderProductDetailSelect = $mypageService -> orderProductDetailSelect($_POST['orderProductCode']);

                $dbService -> tableCheck("review");

                $reviewDescription = mysqli_real_escape_string($conn, $_POST['reviewDescription']);

                $reviewPoint = $configService -> configSelect();

                if ($_POST['boardTempIdx']) { // 첨부파일이 있을때

                    // 첨부파일 임시 idx 조회
                    for ($atic=0; $atic < COUNT($_POST['boardTempIdx']); $atic++) {

                        $boardTempIdx = $atic == 0 ? "'".$_POST['boardTempIdx'][$atic]."'" : ",'".$_POST['boardTempIdx'][$atic]."'";

                    }

                    // 후기 첨부파일 조회
                    $attachFileSelect = $attachFileService -> attachFileSelect("review", $boardTempIdx, "ASC");

                    $reviewTypeCount = 0;

                    // 첨부파일 종류 조회 (photo, video)
                    for ($at=0; $at < COUNT($attachFileSelect); $at++) {

                        if ($attachFileSelect[$at]['type'] == "video") {

                            $reviewTypeCount++; 

                        }

                    }

                    if ($reviewTypeCount > 0) {

                        $reviewType = "video";

                        $point = $reviewPoint['videoReviewPoint'];

                    } else {

                        $reviewType = "photo";

                        $point = $reviewPoint['photoReviewPoint'];

                    }

                } else {

                    $reviewType = "normal";

                    $point = $reviewPoint['reviewPoint'];

                }

                // 후기 등록
                $productInsert = $mypageService -> reviewInsert($userNo, $orderProductDetailSelect['orderNo'], $orderProductDetailSelect['productCode'], $orderProductDetailSelect['idx'], $orderProductDetailSelect['optionIdx'], $orderProductDetailSelect['optionTitle'], $reviewDescription, $reviewType);

                if ($_POST['boardTempIdx']) { // 첨부파일이 있을때

                    $reviewIdx = mysqli_insert_id($conn); // insert될때 pk값

                    for ($aic=0; $aic < COUNT($_POST['boardTempIdx']); $aic++) {
    
                        // 첨부파일 idx 업데이트
                        $attachFileIdxUpdate = $attachFileService -> attachFileIdxUpdate($_POST['table'], $reviewIdx, $_POST['boardTempIdx'][$aic]);

                        if ($attachFileIdxUpdate == "error") {
    
                            throw new Exception("error : attachFileIdxUpdate");
    
                        }

                    }
                
                }

                // 후기작성완료로 status 변경
                $orderProductStatusUpdate = $orderService -> orderProductStatusUpdate($_POST['orderProductCode'], 7);

                if ($orderProductStatusUpdate == "error") {

                    throw new Exception("error : orderProductStatusUpdate");

                }

                // 회원 조회
                $memberSelect = $memberService -> memberSelect($_SESSION['userNo']);

                // 적립 포인트
                $memberPoint = (int)$memberSelect['point'] + (int)$point;

                // 포인트 등록
                $pointInsert = $pointService -> pointInsert($userNo, "후기작성 (".$orderProductDetailSelect['orderNo'].")", $point, "+", "system", $memberPoint);
    
                if ($pointInsert == "error") {

                    throw new Exception("error : pointInsert");

                }

                // 회원 포인트 업데이트
                $memberPointUpdate = $memberService -> memberPointUpdate($userNo, $memberPoint);

                if ($memberPointUpdate == "error") {

                    throw new Exception("error : memberPointUpdate");

                }

                // 상품 후기관련 데이터 업데이트
                $productReviewInfoUpdate = $productService -> productReviewInfoUpdate($orderProductDetailSelect['productCode']);

                if ($productReviewInfoUpdate == "error") {

                    throw new Exception("error : productReviewInfoUpdate");

                }

            } else if ($_POST["act"] == "reviewWriteFinish") { // 후기작성 페이지

                $reviewDetailSelect = $mypageService -> reviewDetailSelect($userNo, $_POST['orderProductCode']);

                $reviewPoint = $configService -> configSelect();

                if ($reviewDetailSelect['reviewType'] == "normal") {

                    $reviewText = "일반";

                    $reviewPoint = $reviewPoint['reviewPoint'];

                } else if ($reviewDetailSelect['reviewType'] == "photo") {

                    $reviewText = "포토";

                    $reviewPoint = $reviewPoint['photoReviewPoint'];

                } else if ($reviewDetailSelect['reviewType'] == "video") {

                    $reviewText = "동영상";

                    $reviewPoint = $reviewPoint['videoReviewPoint'];

                }

                array_push($result, $reviewText);
                array_push($result, $reviewPoint);
            
            } else if ($_POST["act"] == "couponList") { // 쿠폰 리스트 페이지

                $couponDownloadSelect = $couponService -> couponDownloadSelect($userNo);

                array_push($result, $couponDownloadSelect);
            
            } else if ($_POST["act"] == "reviewList") { // 후기 리스트 페이지

                $reviewSelect = $mypageService -> reviewSelect($userNo);

                array_push($result, $reviewSelect);

                $productInfo = array();

                for ($rc=0; $rc < COUNT($reviewSelect); $rc++) {

                    array_push($productInfo, $productService -> productDetailSelect($reviewSelect[$rc]['productCode']));

                }

                array_push($result, $productInfo); // 상품 리스트
            
            } else if ($_POST["act"] == "productReviewList") { // 특정상품 후기 리스트 페이지

                $reviewDetailSelect = $mypageService -> productReviewSelect($_POST['productCode']);

                array_push($result, $reviewDetailSelect);

                $memberInfo = array();

                for ($rc=0; $rc < COUNT($reviewDetailSelect); $rc++) {

                    array_push($memberInfo, $memberService -> memberSelect($reviewDetailSelect[$rc]['userNo']));

                }

                array_push($result, $memberInfo); // 회원정보
            
            } else if ($_POST["act"] == "productQnaReg") { // 특정상품 문의

                $productQnaDescription = mysqli_real_escape_string($conn, $_POST['productQnaDescription']);
                
                $productQnaReg = $productService -> productQnaReg($userNo, $_POST['productCode'], $productQnaDescription);
            
            } else if ($_POST["act"] == "productQnaList") { // 특정상품 문의 리스트 페이지

                $productQnaSelect = $productService -> productQnaSelect($_POST['productCode']);

                array_push($result, $productQnaSelect);
            
            } else if ($_POST["act"] == "userInfoChangeView") { // 회원정보 수정 페이지

                $memberSelect = $memberService -> memberSelect($userNo);

                array_push($result, $memberSelect); // 회원정보
            
            } else if ($_POST["act"] == "userInfoChange") { // 회원정보 수정

                // 현재 비밀번호 체크
                $memberSelect = $memberService -> memberSelect($userNo);

                $password = hash("sha256", $_POST['originPassword']);

                if ($password !== $memberSelect['password']) {

                    $errorResult = array("noMatch");

                    echo json_encode($errorResult);

                    exit;

                }

                if ($_POST['password'] !== "") { // 비밀번호 변경

                    if ($_POST['password'] !== $_POST['repassword']) {

                        $errorResult = array("notSame");

                        echo json_encode($errorResult);

                        exit;

                    }

                    $changePassword = hash("sha256", $_POST['password']);

                } else { // 비밀번호 변경 X

                    $changePassword = $memberSelect['password'];

                }

                $address = $_POST['address1']."◈".$_POST['address2'];

                $_POST['smsSubscribe'] == "" ? $smsSubscribe = "N" : $smsSubscribe = "Y";
            
                $_POST['emailSubscribe'] == "" ? $emailSubscribe = "N" : $emailSubscribe = "Y";

                // 회원정보 수정
                $memberInfoUpdate = $memberService -> memberInfoUpdate($userNo, $changePassword, $address, $smsSubscribe, $emailSubscribe);

                if ($memberInfoUpdate == "error") {

                    throw new Exception("error : memberInfoUpdate");

                }
            
            } else if ($_POST["act"] == "pointList") { // 포인트 내역 페이지

                $pointSelect = $pointService -> pointSelect($userNo);

                array_push($result, $pointSelect); // 포인트 내역
            
            } else if ($_POST["act"] == "nonMemberOrderSearch") { // 비회원 주문조회 페이지

                $buyerCell = mb_substr($_POST['buyerCell'], 0, 3, "UTF-8")."◈".mb_substr($_POST['buyerCell'], 3, 4, "UTF-8")."◈".mb_substr($_POST['buyerCell'], 7, 4, "UTF-8");

                // 비회원 주문 체크
                $nonMemberOrderSelect = $mypageService -> nonMemberOrderSelect($_POST['buyerName'], $buyerCell, $_POST['orderNo']);

                if ($nonMemberOrderSelect['orderCount'] == 0) {

                    $errorResult = array("noFound");

                    echo json_encode($errorResult);

                    exit;

                }

            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

        echo json_encode($result);

    }

?>