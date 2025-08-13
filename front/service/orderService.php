<?php

    // 주문
    class OrderService {

        // 장바구니 조회
        public function cartSelect ($userNo, $orderCheck = "", $type = "") {

            $addQuery = "";

            if ($orderCheck == "Y") {

                $addQuery .= "AND orderCheck = '".$orderCheck."'";

            }

            if ($type) {

                $addQuery .= "AND type = '".$type."'";

            }

            $sql = "
                SELECT * FROM cart WHERE userNo = '".$userNo."' ".$addQuery." ORDER BY date DESC
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 장바구니 상품 조회
        public function cartDetailSelect ($userNo, $orderCheck = "", $type = "") {

            $addQuery = "";

            if ($orderCheck == "Y") {

                $addQuery .= "AND c.orderCheck = '".$orderCheck."'";

            }

            if ($type) {

                $addQuery .= "AND c.type = '".$type."'";

            }

            $sql = "
                SELECT 
                    p.title,
                    c.productCode,
                    c.qty,
                    c.optionIdx,
                    po.title AS optionTitle,
                    CASE
                        WHEN
                            c.optionIdx = 0
                        THEN
                            p.discountPercent
                        ELSE
                            0
                    END AS discountPercent,
                    CASE
                        WHEN
                            c.optionIdx = 0
                        THEN
                            p.price
                        ELSE
                            po.price
                    END AS price,
                    CASE
                        WHEN
                            c.optionIdx = 0
                        THEN
                            p.stock
                        ELSE
                            po.stock
                    END AS stock
                FROM cart AS c
                INNER JOIN product AS p
                ON c.productCode = p.productCode
                LEFT JOIN productOption AS po
                ON c.optionIdx = po.idx
                WHERE 
                    c.userNo = '".$userNo."' 
                    ".$addQuery." 
                ORDER BY c.date DESC
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 장바구니에 담기
        public function cartInsert ($userNo, $optionIdx, $qty, $type, $orderCheck) {

            $sql = "
                INSERT INTO cart
                (userNo, productCode, optionIdx, qty, type, orderCheck, date)
                VALUES(
                    '".$userNo."',
                    '".$_POST['productCode']."',
                    '".$optionIdx."',
                    '".$qty."',
                    '".$type."',
                    '".$orderCheck."',
                    NOW()
                )
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 장바구니 업데이트
        public function cartUpdate ($cartIdx, $qty = "", $orderCheck = "") {

            if ($qty !== "") {

                $addColumn = "qty = '".$qty."'";

            } 
            
            if ($orderCheck !== "") {

                $addColumn = "orderCheck = '".$orderCheck."'";
                
            }

            $sql = "
                UPDATE cart
                SET
                    $addColumn
                WHERE
                    idx = '".$cartIdx."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 장바구니 orderCheck 초기화
        public function cartInitUpdate ($userNo) {

            $sql = "
                UPDATE cart
                SET
                    orderCheck = 'N'
                WHERE
                    userNo = '".$userNo."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 장바구니 삭제
        public function cartDelete ($cartIdx) {

            $sql = "
                DELETE FROM cart WHERE idx = '".$cartIdx."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 일주일 전 장바구니 삭제
        public function oldCartDelete ($oldCartDate) {

            $sql = "
                DELETE FROM cart WHERE date < '".$oldCartDate."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 바로구매 삭제
        public function cartTempDelete ($userNo) {

            $sql = "
                DELETE FROM cart WHERE userNo = '".$userNo."' AND type = 'tempCart'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 좋아요 조회
        public function wishSelect ($userNo) {

            $sql = "
                SELECT 
                    productCode
                FROM productWish
                WHERE 
                    userNo = '".$userNo."'
            ";
            
            $row = loopAssocQuery($sql);

            return $row;

        }

        // 좋아요 등록
        public function wishInsert ($userNo, $productCode) {

            $sql = "
                INSERT INTO productWish
                (userNo, productCode, date)
                VALUES(
                    '".$userNo."',
                    '".$productCode."',
                    NOW()
                )
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 좋아요 삭제
        public function wishDelete ($userNo, $productCode) {

            $sql = "
                DELETE FROM productWish
                WHERE
                    userNo = '".$userNo."' 
                AND 
                    productCode = '".$productCode."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 주문 등록
        public function orderInsert ($userNo, $orderNo, $device, $orderTitle, $buyerCell, $buyerEmail, $dlvCell, $dlvAddress, $status) {

            if ($status == "2") {

                $addColumn = ", payDate";

                $addValue = ", NOW()";

            }

            $sql = "
                INSERT INTO orderList
                (userNo, orderNo, device, orderTitle, buyerName, buyerCell, buyerEmail, dlvName, dlvCell, dlvPostcode, dlvAddress, dlvMemo, totalPrice, dlvPrice, usePointPrice, addPointPrice, couponPrice, payType, bank, bankName, cashReceipts, date ".$addColumn.")
                VALUES(
                    '".$userNo."',
                    '".$orderNo."',
                    '".$device."',
                    '".$orderTitle."',
                    '".$_POST['buyerName']."',
                    '".$buyerCell."',
                    '".$buyerEmail."',
                    '".$_POST['dlvName']."',
                    '".$dlvCell."',
                    '".$_POST['dlvPostcode']."',
                    '".$dlvAddress."',
                    '".$_POST['dlvMemo']."',
                    '".$_POST['productTotalPrice']."',
                    '".$_POST['dlvPrice']."',
                    '".$_POST['usePointPrice']."',
                    '".$_POST['addPointPrice']."',
                    '".$_POST['couponPrice']."',
                    '".$_POST['payment']."',
                    '".$_POST['bank']."',
                    '".$_POST['bankName']."',
                    '".$_POST['cashReceipts']."',
                    NOW()
                    ".$addValue."
                )
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 주문 조회
        public function orderSelect ($orderNo) {

            $sql = "
                SELECT 
                    orderTitle,
                    buyerName,
                    buyerCell,
                    buyerEmail,
                    totalPrice,
                    dlvPrice,
                    usePointPrice,
                    couponPrice,
                    dlvName,
                    dlvCell,
                    dlvAddress,
                    dlvMemo,
                    addPointPrice,
                    payType,
                    (CASE 
                        WHEN payType = 'creditpay' THEN '신용카드' 
                        WHEN payType = 'bankpay' THEN '무통장입금' 
                        WHEN payType = 'naverpay' THEN '네이버페이' 
                        WHEN payType = 'kakaopay' THEN '카카오페이' 
                        WHEN payType = 'tosspay' THEN '토스페이' 
                        WHEN payType = 'paycopay' THEN '페이코' 
                        ELSE ''
                    END) AS payTypeName
                FROM orderList
                WHERE
                    orderNo = '".$orderNo."'
            ";

            $row = assocQuery($sql);

            return $row;

        }

        // 주문 상품 등록
        public function orderProductInsert ($orderNo, $productCode, $productTitle, $optionIdx, $optionTitle, $price, $qty, $status) {

            if ($status == "2") {

                $addColumn = ", date2";

                $addValue = ", NOW()";

            }

            $sql = "
                INSERT INTO orderProductList
                (orderNo, productCode, title, optionIdx, optionTitle, price, qty, status, date1 ".$addColumn.")
                VALUES(
                    '".$orderNo."',
                    '".$productCode."',
                    '".$productTitle."',
                    '".$optionIdx."',
                    '".$optionTitle."',
                    '".$price."',
                    '".$qty."',
                    '".$status."',
                    NOW()
                    ".$addValue."
                )
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 주문 상품 조회
        public function orderProductSelect ($orderNo) {

            $sql = "
                SELECT 
                    status,
                    optionIdx,
                    productCode
                FROM orderProductList
                WHERE
                    orderNo = '".$orderNo."'
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 주문 취소
        public function orderCancel ($orderNo) {

            $sql = "
                UPDATE orderList
                SET
                    cancelDate = NOW()
                WHERE
                    orderNo = '".$orderNo."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 주문 상품 취소
        public function orderProductCancel ($orderNo, $status) {

            $sql = "
                UPDATE orderProductList
                SET
                    status = '".$status."',
                    date".$status." = NOW()
                WHERE
                    orderNo = '".$orderNo."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 주문 상품 상태 수정
        public function orderProductStatusUpdate ($idx, $status) {

            $sql = "
                UPDATE orderProductList
                SET
                    status = '".$status."',
                    date".$status." = NOW()
                WHERE
                    idx = '".$idx."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

    }

?>