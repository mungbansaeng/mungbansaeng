<?php

    // ajax로 넘어오는 데이터 $page로 통일시키기

    if ($_POST['page']) {

        $page = $_POST['page'];

    }

    if ($_POST["act"]) {

        include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php"; 
        include_once dirname(dirname(dirname(__FILE__)))."/front/service/productService.php";
        include_once dirname(dirname(dirname(__FILE__)))."/front/service/memberService.php";
        include_once dirname(dirname(dirname(__FILE__)))."/front/service/couponService.php";
        include_once dirname(dirname(dirname(__FILE__)))."/front/service/pointService.php";

    }

    include_once dirname(dirname(dirname(__FILE__)))."/admin/service/orderService.php";

    $orderService = new OrderService();
    $productService = new ProductService();
    $memberService = new MemberService();
    $couponService = new CouponService();
    $pointService = new PointService();

    $result = array("success");

    // 주문관리
    if ($page == "order") {

        try {

            if ($_POST["act"] == "orderList") { // 주문 리스트페이지

                // 주문리스트 카운트 조회
                $orderListCountSelect = $orderService -> orderListCountSelect();

                array_push($result, $orderListCountSelect);

                // 주문리스트 조회
                $orderListSelect = $orderService -> orderListSelect();

                array_push($result, $orderListSelect);

            } else if ($_POST["act"] == "modifyView") { // 주문 수정페이지

                // 주문 상세조회
                $orderDetailSelect = $orderService -> orderDetailSelect();

                array_push($result, $orderDetailSelect);

            } else if ($_POST["act"] == "statusModify") { // 주문 상태변경

                // 취소완료
                if ($_POST['status'] == "9") {

                    // 주문 상태 체크
                    $orderProductSelect = $orderService -> orderDetailSelect($_POST['orderNo']);

                    for ($opc=0; $opc < COUNT($orderProductSelect); $opc++) {

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

                    // 주문 취소
                    $orderCancel = $orderService -> orderCancel($_POST['orderNo']);

                    // 사용쿠폰 조회
                    $usedCouponSelect = $couponService -> usedCouponSelect($userNo, $_POST['orderNo']);

                    // 사용한 쿠폰이 있을 경우
                    if (COUNT($usedCouponSelect) > 0) {

                        // 쿠폰 복구
                        $couponDownloadRestoreUpdate = $couponService -> couponDownloadRestoreUpdate($usedCouponSelect['idx']);

                    }

                    // 사용 포인트 조회
                    $usePointSelect = $pointService -> pointDetailSelect($userNo, $_POST['orderNo'], "-");

                    if ($usePointSelect > 0) {

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

                }

                // 상품별 배송상태 변경
                $orderStatusUpdate = $orderService -> orderStatusUpdate($_POST['orderProductIdx'], $_POST['status']);

            } else if ($_POST["act"] == "modify") {

                // 주소 병합        
                $dlvAddress = $_POST['dlvAddress1']."◈".$_POST['dlvAddress2'];

                // 핸드폰번호 새로 병함
                $dlvCellArr = explode("-", $_POST['dlvCell']);

                $dlvCell = $dlvCellArr[0]."◈".$dlvCellArr[1]."◈".$dlvCellArr[2];

                // 주문 정보 수정
                $orderService -> orderInfoUpdate($dlvAddress, $dlvCell, $_POST['orderNo']);

                // 주문 상품별 배송업체, 운송장 번호 업데이트
                $orderService -> orderProductDlvInfoUpdate();

            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

        echo json_encode($result);

    }

?>