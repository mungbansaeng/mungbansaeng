<?php

    // ajax로 넘어오는 데이터 $page로 통일시키기

    if ($_POST['page']) {

        $page = $_POST['page'];

    }

    include_once dirname(dirname(dirname(__FILE__)))."/front/service/orderService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/productService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/memberService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/couponService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/pointService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/public/controller/frontLogController.php";

    $orderService = new OrderService();
    $productService = new ProductService();
    $memberService = new MemberService();
    $couponService = new CouponService();
    $pointService = new PointService();

    $result = array("success");

    if ($page == "cart") { // 장바구니

        try {

            if ($_POST["act"] == "insert") {

                // 일주일전 장바구니 전체 삭제
                $oldCartDate = date('Y-m-d H:i:s',strtotime($date." ".$time."-7 day"));
                $orderService -> oldCartDelete($oldCartDate);

                // 바로구매 상품 삭제
                $orderService -> cartTempDelete($userNo);

                // 장바구니에 해당 회원/비회원 상품이 있는지 확인
                $cartIssetSelect = $orderService -> cartSelect($userNo, "", "cart");

                // 해당 회원 모든 장바구니 전부 N 처리
                $cartOrderCartN = $orderService -> cartInitUpdate($userNo);
          
                $issetProduct = "Y";

                if ($_POST['type'] == "cart") { // 장바구니에서 구매만 장바구니 유무 체크

                    for ($cpc=0; $cpc < COUNT($cartIssetSelect); $cpc++) {

                        if ($cartIssetSelect[$cpc]['optionIdx'] == 0) { // 옵션 없을때

                            if ($cartIssetSelect[$cpc]['productCode'] == $_POST['productCode']) { // 상품코드가 같을때 업데이트

                                $qty = $cartIssetSelect[$cpc]['qty'] + $_POST['qty'];

                                $cartUpdate = $orderService -> cartUpdate($cartIssetSelect[$cpc]['idx'], $qty);

                                $issetProduct = "N";

                            }

                        } else { // 옵션 있을때

                            $optionIdx = explode("◈", $_POST['optionIdx']);
                            $qty = explode("◈", $_POST['qty']);
                            $stock = explode("◈", $_POST['stock']);
                            $optionTit = explode("◈", $_POST['optionTit']);

                            $optionIndex = array_search($cartIssetSelect[$cpc]['optionIdx'], $optionIdx);

                            if ($optionIndex > -1) { // 옵션코드가 같을때 업데이트

                                $eachQty = $cartIssetSelect[$cpc]['qty'] + $qty[$optionIndex];

                                $cartUpdate = $orderService -> cartUpdate($cartIssetSelect[$cpc]['idx'], $eachQty);

                                array_splice($optionIdx, $optionIndex, 1);
                                array_splice($qty, $optionIndex, 1);

                                if (COUNT($optionIdx) == 0) { // 옵션 idx가 없을때

                                    $issetProduct = "N";

                                }

                            }

                        }

                    }

                }
    
                // 장바구니에서 구매는 장바구니에 있는 idx는 삭제하고 insert, 바로 구매는 체크 없이 insert
                if (COUNT($optionIdx) > 0) {
    
                    for ($opc=0; $opc < COUNT($optionIdx); $opc++) {

                        if ($_POST['type'] == "cart") {

                            $orderCheck = "N";

                        } else {

                            $orderCheck = "Y";

                        }
                
                        // 장바구니에 담기
                        $cartInsert = $orderService -> cartInsert($userNo, $optionIdx[$opc], $qty[$opc], $_POST['type'], $orderCheck);

                        if ($cartInsert == "error") {

                            throw new Exception("service error : cartInsert");

                        }
        
                    }
    
                } else if ($issetProduct == "Y") {

                    // 장바구니에 담기
                    $cartInsert = $orderService -> cartInsert($userNo, 0, $_POST['qty'], $_POST['type'], "Y");

                }

                $cartCount = $orderService -> cartSelect($userNo, "", "cart");

                array_push($result, COUNT($cartCount));

            } else if ($_POST["act"] == "view") {

                $cartIssetSelect = $orderService -> cartSelect($userNo, "", "cart");

                array_push($result, $cartIssetSelect);

                $productList = array();
                $productInfo = array();
                $optionInfo = array();

                for ($pi=0; $pi < COUNT($cartIssetSelect); $pi++) {

                    array_push($productInfo, $productService -> productDetailSelect($cartIssetSelect[$pi]['productCode']));

                    array_push($optionInfo, $productService -> optionSelect($cartIssetSelect[$pi]['optionIdx']));

                }

                array_push($result, $productInfo); // 상품 리스트
                array_push($result, $optionInfo); // 옵션 리스트

                $memberSelect = $memberService -> memberSelect($_SESSION['userNo']);

                array_push($result, $memberSelect);

            } else if ($_POST["act"] == "modify") {

                $cartUpdate = $orderService -> cartUpdate($_POST['cartIdx'], $_POST['qty']);

                if ($cartUpdate == "error") {

                    throw new Exception("service error : cartUpdate");

                }

            } else if ($_POST["act"] == "del") {

                $cartDelete = $orderService -> cartDelete($_POST['cartIdx']);

                if ($cartDelete == "success") {

                    $cartSelect = $orderService -> cartSelect($userNo, "", "cart");

                    array_push($result, $cartSelect);

                }

                if ($cartDelete == "error") {

                    throw new Exception("service error : cartDelete");

                }

            } else if ($_POST["act"] == "cartOrder") { // 장바구니에서 구매하기

                // 장바구니 전체 상품 N 처리
                $cartOrderCartN = $orderService -> cartInitUpdate($userNo);

                if ($cartOrderCartN == "success") {

                    $cartIdx = explode("◈", $_POST['cartIdx']);
    
                    for ($co=0; $co < COUNT($cartIdx); $co++) {
    
                        // 선택된 상품만 Y 처리
                        $cartOrder = $orderService -> cartUpdate($cartIdx[$co], "", "Y");
    
                        if ($cartOrder == "error") {
        
                            throw new Exception("service error : cartOrder");
        
                        }
    
                    }

                }

            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    }

    if ($page == "wish") { // 좋아요

        try {

            if ($_POST["act"] == "insert") {

                // 좋아요 등록
                $wishInsert = $orderService -> wishInsert($userNo, $_POST['productCode']);
    
                if ($wishInsert == "error") {
    
                    throw new Exception("error : wishInsert");
    
                }
    
                // 좋아요 조회
                $wishSelect = $orderService -> wishSelect($userNo);
    
                array_push($result, $wishSelect);
    
            } else if ($_POST["act"] == "delete") {
    
                // 좋아요 취소
                $wishDelete = $orderService -> wishDelete($userNo, $_POST['productCode']);
    
                if ($wishDelete == "error") {
    
                    throw new Exception("error : wishDelete");
    
                }
    
                // 좋아요 조회
                $wishSelect = $orderService -> wishSelect($userNo);
    
                array_push($result, $wishSelect);
    
            } else if ($_POST["act"] == "view") {
    
                // 좋아요 조회
                $wishSelect = $orderService -> wishSelect($userNo);
    
                array_push($result, $wishSelect);

                $productInfo = array();

                for ($wc=0; $wc < COUNT($wishSelect); $wc++) {
                
                    // 상품 정보 조회
                    array_push($productInfo, $productService -> productDetailSelect($wishSelect[$wc]['productCode']));

                }

                array_push($result, $productInfo);
    
            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    }

    if ($page == "order") { // 주문,결제

        try {

            if ($_POST["act"] == "orderSheet") { // 주문/결제 페이지

                // 회원 조회
                $memberSelect = $memberService -> memberSelect($_SESSION['userNo']);

                array_push($result, $memberSelect);

                // 배송지 조회
                $orderDlvSelect = $memberService -> orderDlvSelect($userNo);

                array_push($result, $orderDlvSelect);

                // 장바구니 조회
                $orderCartSelect = $orderService -> cartSelect($userNo, "Y", $_POST['type']);

                array_push($result, $orderCartSelect);

                // 주문상품 조회
                $productList = array();
                $productInfo = array();
                $optionInfo = array();

                $totalPrice = 0;

                for ($pi=0; $pi < COUNT($orderCartSelect); $pi++) {

                    array_push($productInfo, $productService -> productDetailSelect($orderCartSelect[$pi]['productCode']));

                    array_push($optionInfo, $productService -> optionSelect($orderCartSelect[$pi]['optionIdx']));

                    if ($orderCartSelect[$pi]['optionIdx']) { // 옵션 상품

                        $totalPrice += $optionInfo[$pi]['price'] * $orderCartSelect[$pi]['qty'];

                    } else { // 옵션 없는 상품

                        $totalPrice += (int) $productInfo[$pi]['price'] * ((100 - (int) $productInfo[$pi]['discountPercent']) / 100) * (int) $orderCartSelect[$pi]['qty'];

                    }

                }

                array_push($result, $productInfo); // 상품 리스트
                array_push($result, $optionInfo); // 옵션 리스트

                // 쿠폰 조회
                $ableCouponDownloadSelect = $couponService -> ableCouponDownloadSelect($userNo, $totalPrice);

                if ($ableCouponDownloadSelect) {

                    array_push($result, $ableCouponDownloadSelect);

                } else {

                    array_push($result, "noCoupon");

                }

            } else if ($_POST["act"] == "orderDlvInsert") { // 신규 배송지 등록

                // 배송지 조회
                $orderDlvCountSelect = $memberService -> orderDlvSelect($userNo);

                if (COUNT($orderDlvCountSelect) > 2) {

                    $errorResult = array("full");

                    echo json_encode($errorResult);

                    exit;

                }

                if($_POST['defaltDlv'] == "Y"){

                    // 기본배송지 전체 N으로 수정
                    $orderDefaltDlvUpdate = $memberService -> orderDefaltDlvUpdate($userNo, "N");
        
                }

                $dlvCellphone = substr($_POST['dlvPopCellphone'], 0, 3)."◈".substr($_POST['dlvPopCellphone'], 3, 4)."◈".substr($_POST['dlvPopCellphone'], 7, 4);
                $dlvAddress = $_POST['dlvPopAddress1']."◈".$_POST['dlvPopAddress2'];
        
                // 배송지 등록
                $orderDlvInsert = $memberService -> orderDlvInsert($userNo, $_POST['dlvPopName'], $dlvCellphone, $_POST['popPostcode'], $dlvAddress, $_POST['defaltDlv']);

                if ($orderDlvInsert == "success") {

                    // 배송지 조회
                    $orderDlvSelect = $memberService -> orderDlvSelect($userNo);

                    array_push($result, $orderDlvSelect);

                } else {

                    throw new Exception("service error : orderDlvInsert");

                }

            } else if ($_POST["act"] == "orderDlvUpdate") { // 배송지 수정

                // 배송지 조회
                $orderDefaltDlvSelect = $memberService -> orderDlvSelect($userNo);

                if($_POST['defaltDlv'] == "Y"){

                    // 기본배송지 전체 N으로 수정
                    $orderDefaltDlvUpdate = $memberService -> orderDefaltDlvUpdate($userNo, "N");
        
                } else {

                    // POST로 넘어온 defaltDlv가 N일때 db에서 defaltDlv 체크 모두 N일 경우 exit (기본배송지는 무조건 1개 있어야함)
                    $defaltDlvCount = 0;

                    for ($dfd=0; $dfd < COUNT($orderDefaltDlvSelect); $dfd++) {

                        if ($orderDefaltDlvSelect[$dfd]['defaltDlv'] == "Y") {

                            $defaltDlvCount++;

                        }

                    }

                    if ($defaltDlvCount == 0) {

                        $errorResult = array("none");

                        echo json_encode($errorResult);

                        exit;

                    }

                }

                $dlvCellphone = substr($_POST['dlvPopCellphone'], 0, 3)."◈".substr($_POST['dlvPopCellphone'], 3, 4)."◈".substr($_POST['dlvPopCellphone'], 7, 4);
                $dlvAddress = $_POST['dlvPopAddress1']."◈".$_POST['dlvPopAddress2'];
        
                // 배송지 수정
                $orderDlvUpdate = $memberService -> orderDlvUpdate($_POST['idx'], $dlvCellphone, $dlvAddress);

                if ($orderDlvUpdate == "success") {

                    $orderDlvSelect = $memberService -> orderDlvSelect($userNo);

                    array_push($result, $orderDlvSelect);

                } else {

                    throw new Exception("service error : orderDlvUpdate");

                }

            } else if ($_POST["act"] == "orderDlvDelete") { // 배송지 삭제

                // 배송지 상세조회
                $orderDefaltDlvSelect = $memberService -> orderDlvDetailSelect($_POST['idx']);

                if($_POST['defaltDlv'] == "Y" || $orderDefaltDlvSelect['defaltDlv'] == "Y"){

                    // 기본배송지는 삭제 불가
                    $errorResult = array("none");

                    echo json_encode($errorResult);

                    exit;
        
                } else {

                    // 배송지 삭제
                    $orderDlvDelete = $memberService -> orderDlvDelete($_POST['idx']);

                    if ($orderDlvDelete == "success") {
    
                        $orderDlvSelect = $memberService -> orderDlvSelect($userNo);
    
                        array_push($result, $orderDlvSelect);
    
                    } else {
    
                        throw new Exception("service error : orderDlvDelete");
    
                    }

                }

            } else if ($_POST["act"] == "orderInsert") { // 주문 결제하기

                // 시작 로그
                $frontLogSerice -> orderLogInsert($userNo, "", "ajax", "orderInsert", "orderFinish", "start");

                // cart에서 주문 상품 관련 조회                
                $cartSelect = $orderService -> cartSelect($userNo, "Y", $_POST['type']);

                // 주문 등록

                // 장바구니 상품 조회
                $orderCartSelect = $orderService -> cartDetailSelect($userNo, "Y", $_POST['type']);

                // 주문명
                if (COUNT($orderCartSelect) == 1) {

                    $orderTitle = $orderCartSelect[0]['title'];
    
                } else {
    
                    $orderTitle = $orderCartSelect[0]['title']."외 ".(COUNT($cartSelect) - 1)."개";
    
                }

                // post로 넘어온 정상적인지 정보 정상적인지 체크
                $cartProductPrice = 0;
                $productStock = "";

                for ($cc=0; $cc < COUNT($orderCartSelect); $cc++) {

                    // 상품가격 조회
                    $cartProductPrice += (int)$orderCartSelect[$cc]['price'] * ((100 - (int)$orderCartSelect[$cc]['discountPercent']) / 100) * (int)$orderCartSelect[$cc]['qty'];
                    
                    // 재고 체크
                    if ($orderCartSelect[$cc]['stock'] == 0) {

                        // 실패 로그
                        $frontLogSerice -> orderLogInsert($userNo, $orderCartSelect[$cc]['title'], "ajax", "orderInsert", "orderFinish", "noStock");

                        $errorResult = array("noStock");

                        echo json_encode($errorResult);

                        exit;
        
                    }

                }

                // 회원 조회
                $memberSelect = $memberService -> memberSelect($userNo);

                // 특정 다운로드 쿠폰 조회
                $couponDownloadDetailSelect = $couponService -> couponDownloadDetailSelect($_POST['couponIdx'], $userNo);

                // 결제 관련 데이터 체크
                if ((int)$cartProductPrice !== (int)$_POST['productTotalPrice'] || (int)$_POST['usePointPrice'] > (int)$memberSelect['point'] || ((int)$_POST['dlvPrice'] <= 0 && (int)$_POST['deliveryMinPrice'] > (int)$cartProductPrice) || (int)$_POST['couponPrice'] > $couponDownloadDetailSelect['maxPrice']) { // 비정상

                    // 실패 로그
                    if ((int)$cartProductPrice !== (int)$_POST['productTotalPrice']) {

                        $frontLogSerice -> orderLogInsert($userNo, "db : ".$cartProductPrice."user : ".$_POST['productTotalPrice'], "ajax", "orderInsert", "orderFinish", "productPrice differentData");

                    } else if ((int)$_POST['usePointPrice'] > (int)$memberSelect['point']) {

                        $frontLogSerice -> orderLogInsert($userNo, "db : ".$memberSelect['point']."user : ".$_POST['usePointPrice'], "ajax", "orderInsert", "orderFinish", "point differentData");

                    } else if (((int)$_POST['dlvPrice'] <= 0 && (int)$_POST['deliveryMinPrice'] > (int)$cartProductPrice)) {

                        $frontLogSerice -> orderLogInsert($userNo, "productPrice : ".$cartProductPrice."user dlv : ".$_POST['dlvPrice']."user dlv min price : ".$_POST['deliveryMinPrice'], "ajax", "orderInsert", "orderFinish", "dlv differentData");

                    } else if ((int)$_POST['couponPrice'] > $couponDownloadDetailSelect['maxPrice']) {

                        $frontLogSerice -> orderLogInsert($userNo, "coupon max price : ".$couponDownloadDetailSelect['maxPrice']."user coupon price : ".$_POST['couponPrice'], "ajax", "orderInsert", "orderFinish", "coupon differentData");

                    }

                    $errorResult = array("differentData");

                    echo json_encode($errorResult);

                    exit;

                } else { // 모두 정상

                    // 주문번호 생성
                    $orderNo = "MB".time();

                    // 디바이스 체크
                    $mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";
            
                    if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])){
            
                        $device = "M";
            
                    }else{
            
                        $device = "P";
            
                    }

                    // 주소 병합        
                    $dlvAddress = $_POST['dlvAddress1']."◈".$_POST['dlvAddress2'];

                    // 주문자 핸드폰번호
                    $buyerCellNumber = numberOnly($_POST['buyerCell']);

                    $buyerCell[0] = mb_substr($buyerCellNumber, 0, 3, "UTF-8");
                    $buyerCell[1] = mb_substr($buyerCellNumber, 3, 4, "UTF-8");
                    $buyerCell[2] = mb_substr($buyerCellNumber, 7, 4, "UTF-8");
                
                    $buyerCell = $buyerCell[0]."◈".$buyerCell[1]."◈".$buyerCell[2];

                    // 배송지 핸드폰번호
                    $dlvCellNumber = numberOnly($_POST['dlvCell']);

                    $dlvCell[0] = mb_substr($dlvCellNumber, 0, 3, "UTF-8");
                    $dlvCell[1] = mb_substr($dlvCellNumber, 3, 4, "UTF-8");
                    $dlvCell[2] = mb_substr($dlvCellNumber, 7, 4, "UTF-8");
                
                    $dlvCell = $dlvCell[0]."◈".$dlvCell[1]."◈".$dlvCell[2];

                    if($_POST['payment'] == "bankpay"){
    
                        $status = "1";
    
                    }else{
    
                        $status = "2";
    
                    }

                    // 주문 등록
                    $orderInsert = $orderService -> orderInsert($userNo, $orderNo, $device, $orderTitle, $buyerCell, $_POST['buyerEmail'], $dlvCell, $dlvAddress, $status);

                    if ($orderInsert == "success") {

                        // 주문 상품 등록, 재고 수량 업데이트
                        for ($opc=0; $opc < COUNT($orderCartSelect); $opc++) {

                            $discountedPrice = $orderCartSelect[$opc]['price'] - round($orderCartSelect[$opc]['price'] * ($orderCartSelect[$opc]['discountPercent'] / 100));

                            $orderProductInsert = $orderService -> orderProductInsert($orderNo, $orderCartSelect[$opc]['productCode'], $orderCartSelect[$opc]['title'], $orderCartSelect[$opc]['optionIdx'], $orderCartSelect[$opc]['optionTitle'], $discountedPrice, $orderCartSelect[$opc]['qty'], $status);

                            if ($orderProductInsert == "error") {

                                $frontLogSerice -> orderLogInsert($userNo, $orderNo."◈".$orderCartSelect[$opc]['productCode']."◈".$orderCartSelect[$opc]['title']."◈".$orderCartSelect[$opc]['optionIdx']."◈".$orderCartSelect[$opc]['optionTitle']."◈".$discountedPrice."◈".$orderCartSelect[$opc]['qty']."◈".$status, "ajax", "orderInsert", "orderFinish", "service orderProductInsert");

                                throw new Exception("service error : orderProductInsert");

                            }

                            if ($orderCartSelect[$opc]['optionIdx'] > 0) { // 옵션이 있을때

                                // 옵션 업데이트
                                $orderProductOptionUpdate = $productService -> orderProductOptionUpdate($orderCartSelect[$opc]['optionIdx']);

                                if ($orderProductOptionUpdate == "error") {

                                    $frontLogSerice -> orderLogInsert($userNo, $orderCartSelect[$opc]['optionIdx'], "ajax", "orderInsert", "orderFinish", "service orderProductOptionUpdate");

                                    throw new Exception("service error : orderProductOptionUpdate");

                                }


                            } else { // 옵션이 없을때

                                // 상품 업데이트
                                $orderProductUpdate = $productService -> orderProductUpdate($orderCartSelect[$opc]['productCode']);

                                if ($orderProductUpdate == "error") {

                                    $frontLogSerice -> orderLogInsert($userNo, $orderCartSelect[$opc]['productCode'], "ajax", "orderInsert", "orderFinish", "service orderProductUpdate");

                                    throw new Exception("service error : orderProductUpdate");

                                }

                            }

                        }

                        // 회원일때
                        if ($memberSelect !== "nonMember") {

                            // 쿠폰 다운로드 사용처리 업데이트
                            $couponDownloadUpdate = $couponService -> couponDownloadUpdate($orderNo, $userNo, $_POST['couponIdx']);

                            if ((int) $_POST['usePointPrice'] > 0) {

                                // 사용 포인트
                                $memberPoint = (int) $memberSelect['point'] - (int)$_POST['usePointPrice'];
                                
                                // 사용 포인트 등록
                                $pointInsert = $pointService -> pointInsert($userNo, "상품구매 (".$orderNo.")", $_POST['usePointPrice'], "-", "system", $memberPoint);
    
                                if ($pointInsert == "error") {

                                    $frontLogSerice -> orderLogInsert($userNo, $userNo."◈상품구매 (".$orderNo.")◈".$_POST['usePointPrice']."◈-◈"."system".$memberPoint, "ajax", "orderInsert", "orderFinish", "service pointInsert");
            
                                    throw new Exception("error : pointInsert");
            
                                }
    
                                // 회원 포인트 업데이트
                                $memberPointUpdate = $memberService -> memberPointUpdate($userNo, $memberPoint);
            
                                if ($memberPointUpdate == "error") {

                                    $frontLogSerice -> orderLogInsert($userNo, $userNo."◈".$memberPoint, "ajax", "orderInsert", "orderFinish", "service memberPointUpdate");
            
                                    throw new Exception("error : memberPointUpdate");
            
                                }

                            }

                        }

                        // 장바구니 삭제
                        for ($odc=0; $odc < COUNT($cartSelect); $odc++) {

                            $orderCartDelete = $orderService -> cartDelete($cartSelect[$odc]['idx']);
    
                            if ($orderCartDelete == "error") {

                                $frontLogSerice -> orderLogInsert($userNo, $cartSelect[$odc]['idx'], "ajax", "orderInsert", "orderFinish", "service orderCartDelete");
        
                                throw new Exception("error : orderCartDelete");
        
                            }

                        }

                        // 주문 내역 조회
                        $orderSelect = $orderService -> orderSelect($orderNo);

                        $payPrice = $orderSelect['totalPrice'] + $orderSelect['dlvPrice'] - $orderSelect['usePointPrice'] - $orderSelect['couponPrice'];

                        $buyerCell = explode("◈", $orderSelect['buyerCell']);

                        $dlvAddress = explode("◈", $orderSelect['dlvAddress']);

                        include_once dirname(dirname(dirname(__FILE__)))."/public/controller/emailController.php";

                        array_push($result, $orderNo);

                    } else {

                        throw new Exception("service error : orderInsert");

                    }

                }
            
            } else if ($_POST["act"] == "orderFinish") { // 주문완료 페이지

                // 주문 내역 조회
                $orderSelect = $orderService -> orderSelect($_POST['orderNo']);

                array_push($result, $orderSelect);

                // 회원 조회
                $memberSelect = $memberService -> memberSelect($userNo);

                array_push($result, $memberSelect);
            
            } else if ($_POST["act"] == "orderCancel") { // 주문취소

                // pg 취소처리

                // 주문 상태 체크
                $orderProductSelect = $orderService -> orderProductSelect($_POST['orderNo']);

                $status = 9;

                for ($opc=0; $opc < COUNT($orderProductSelect); $opc++) {

                    // 상품준비중일때는 배송유무 체크를 위해 취소요청상태로 변경
                    if ($orderProductSelect[$opc]['status'] == 3) {

                        $status = 8;

                        $orderCancel = $orderService -> orderProductCancel($_POST['orderNo'], 8);

                        $result = array("check");

                    } else if ($orderProductSelect[$opc]['status'] > 3 && $orderProductSelect[$opc]['status'] !== 8) { // 배송중 이후는 주문 취소 불가 (취소요청상태 제외)

                        $errorResult = array("unable", $orderProductSelect[$opc]['status']);

                        echo json_encode($errorResult);

                        exit;

                    } else {                        

                        // 주문 취소
                        $orderCancel = $orderService -> orderCancel($_POST['orderNo']);

                        // 주문 상품 취소
                        $orderCancel = $orderService -> orderProductCancel($_POST['orderNo'], $status);
                        
                    }

                    // 상품 재고, 판매량 복구
                    if ($orderProductSelect[$opc]['optionIdx'] > 0) { // 옵션이 있을때

                        $productOptionCancelUpdate = $productService -> productOptionCancelUpdate($orderProductSelect[$opc]['optionIdx']);

                        if ($productOptionCancelUpdate == "error") {

                            throw new Exception("service error : productOptionCancelUpdate");

                        }

                    } else { // 옵션이 없을때

                        $productCancelUpdate = $productService -> productCancelUpdate($orderProductSelect[$opc]['productCode']);

                        if ($productCancelUpdate == "error") {

                            throw new Exception("service error : productCancelUpdate");

                        }

                    }

                    // 품절된 상품이면 정상으로 수정
                    $productDetailSelect = $productService -> productDetailSelect($orderProductSelect[$opc]['productCode']);

                    if ($productDetailSelect['status'] == 300 || $productDetailSelect['status'] == 400) {

                        $productService -> productStatusUpdate($productDetailSelect['idx']);

                    }

                }

                // 사용쿠폰 조회
                $usedCouponSelect = $couponService -> usedCouponSelect($userNo, $_POST['orderNo']);

                // 사용한 쿠폰이 있을 경우
                if (COUNT($usedCouponSelect) > 0) {

                    // 쿠폰 복구
                    $couponDownloadRestoreUpdate = $couponService -> couponDownloadRestoreUpdate($usedCouponSelect['idx']);

                }

                // 사용 포인트 조회
                $usePointSelect = $pointService -> pointDetailSelect($userNo, $_POST['orderNo'], "-");

                if ($usePointSelect['amount'] > 0) {

                    // 회원 조회
                    $memberSelect = $memberService -> memberSelect($userNo);

                    // 회원 포인트
                    $memberPoint = $memberSelect['point'] + $usePointSelect['amount'];

                    // 포인트 복구
                    $pointInsert = $pointService -> pointInsert($userNo, "주문취소 (".$_POST['orderNo'].")", $usePointSelect['amount'], "+", "system", $memberPoint);

                    if ($pointInsert == "error") {

                        throw new Exception("error : pointInsert");

                    }

                    // 회원 포인트 업데이트
                    $memberPointUpdate = $memberService -> memberPointUpdate($userNo, $memberPoint);

                    if ($memberPointUpdate == "error") {

                        throw new Exception("error : memberPointUpdates");

                    }

                }

                array_push($result, $status);
            
            } else if ($_POST["act"] == "finishOrder") { // 구매확정

                // 주문 상품 상태 업데이트
                $orderProductStatusUpdate = $orderService -> orderProductStatusUpdate($_POST['orderProductIdx'], 6);

                // 주문 상품 전체 조회
                $orderProductSelect = $orderService -> orderProductSelect($_POST['orderNo']);

                $orderProductStatusCount = COUNT($orderProductSelect);

                for ($ops=0; $ops < COUNT($orderProductSelect); $ops++) {

                    if ($orderProductSelect[$ops]['status'] == 6 || $orderProductSelect[$ops]['status'] == 7) {

                        $orderProductStatusCount--;

                    }

                }

                if ($orderProductStatusCount == 0) { // 모든 주문상품이 구매확정일때

                    // 회원 조회
                    $memberSelect = $memberService -> memberSelect($_SESSION['userNo']);

                    // 주문 내역 조회
                    $orderSelect = $orderService -> orderSelect($_POST['orderNo']);
    
                    // 적립 포인트
                    $memberPoint = (int)$memberSelect['point'] + (int)$orderSelect['addPointPrice'];
                    
                    // 포인트 등록
                    $pointInsert = $pointService -> pointInsert($userNo, "구매확정 (".$_POST['orderNo'].")", $orderSelect['addPointPrice'], "+", "system", $memberPoint);
    
                    if ($pointInsert == "error") {
    
                        throw new Exception("error : pointInsert");
    
                    }
    
                    // 회원 포인트 업데이트
                    $memberPointUpdate = $memberService -> memberPointUpdate($userNo, $memberPoint);
    
                    if ($memberPointUpdate == "error") {
    
                        throw new Exception("error : memberPointUpdate");
    
                    }

                }
            
            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    }

    echo json_encode($result);

?>