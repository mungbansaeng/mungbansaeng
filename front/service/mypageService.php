<?php

    // 마이페이지
    class MypageService {

        // 주문내역 조회
        public function orderListSelect($userNo) {

            $sql = "
                SELECT
                    orderNo,
                    date
                FROM orderList
                WHERE 
                    userNo = '".$userNo."'
                ORDER BY date DESC
                LIMIT ".$_POST['limitStart'].", ".$_POST['showNum']."
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 특정 주문내역 조회
        public function orderInfoSelect($orderNo) {

            $sql = "
                SELECT
                    dlvName,
                    dlvCell,
                    dlvAddress,
                    dlvCompany,
                    dlvCode,
                    dlvMemo,
                    totalPrice,
                    couponPrice,
                    usePointPrice,
                    dlvPrice,
                    payType,
                    (CASE 
                        WHEN payType = 'creditpay' THEN '신용카드' 
                        WHEN payType = 'bankpay' THEN '무통장입금' 
                        WHEN payType = 'naverpay' THEN '네이버페이' 
                        WHEN payType = 'kakaopay' THEN '카카오페이' 
                        WHEN payType = 'tosspay' THEN '토스페이' 
                        WHEN payType = 'paycopay' THEN '페이코' 
                        ELSE ''
                    END) AS payTypeName,
                    bank,
                    bankName,
                    bankAccount,
                    cashReceipts,
                    payDate
                FROM orderList
                WHERE 
                    orderNo = '".$orderNo."'
            ";

            $row = assocQuery($sql);

            return $row;

        }

        // 주문상품 조회
        public function orderProductSelect($orderNo) {

            $sql = "
                SELECT
                    ol.orderNo,
                    ol.date,
                    opl.idx AS orderProductIdx,
                    opl.title,
                    opl.optionTitle,
                    opl.qty,
                    opl.status AS statusNum,
                    (CASE 
                        WHEN opl.status = '1' THEN '주문(미입금)' 
                        WHEN opl.status = '2' THEN '입금완료' 
                        WHEN opl.status = '3' THEN '배송준비중' 
                        WHEN opl.status = '4' THEN '배송중' 
                        WHEN opl.status = '5' THEN '배송완료' 
                        WHEN opl.status = '6' THEN '구매확정' 
                        WHEN opl.status = '7' THEN '후기작성완료' 
                        WHEN opl.status = '8' THEN '취소요청' 
                        WHEN opl.status = '9' THEN '취소완료' 
                        WHEN opl.status = '10' THEN '반품요청' 
                        WHEN opl.status = '11' THEN '반품수거중' 
                        WHEN opl.status = '12' THEN '반품수거완료' 
                        WHEN opl.status = '13' THEN '반품완료' 
                        WHEN opl.status = '14' THEN '환불요청' 
                        WHEN opl.status = '15' THEN '환불완료' 
                        WHEN opl.status = '16' THEN '교환요청' 
                        WHEN opl.status = '17' THEN '교환수거중' 
                        WHEN opl.status = '18' THEN '교환수거완료' 
                        WHEN opl.status = '19' THEN '교환재배송중' 
                        WHEN opl.status = '20' THEN '교환완료' 
                        ELSE ''
                    END) AS status,
                    opl.dlvCode,
                    opl.productCode,
                    opl.price,
                    puf.fileName,
                    CASE
                        WHEN
                            opl.optionIdx = 0
                        THEN
                            p.discountPercent
                        ELSE
                            0
                    END AS discountPercent
                FROM orderProductList AS opl
                INNER JOIN orderList AS ol
                ON opl.orderNo = ol.orderNo
                INNER JOIN product AS p
                ON opl.productCode = p.productCode
                LEFT JOIN productOption AS po
                ON opl.optionIdx = po.idx
                INNER JOIN productUploadFile AS puf
                ON p.idx = puf.boardIdx
                WHERE 
                    ol.orderNo = '".$orderNo."'
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 특정 주문상품 조회
        public function orderProductDetailSelect($orderProductIdx) {

            $sql = "
                SELECT
                    puf.fileName,
                    opl.idx,
                    opl.orderNo,
                    opl.productCode,
                    opl.title,
                    opl.optionIdx,
                    opl.optionTitle,
                    opl.price,
                    opl.qty
                FROM orderProductList AS opl
                INNER JOIN product AS p
                ON opl.productCode = p.productCode
                INNER JOIN productUploadFile AS puf
                ON p.idx = puf.boardIdx
                WHERE
                    opl.idx = '".$orderProductIdx."'
            ";

            $row = assocQuery($sql);

            return $row;

        }

        // 후기 등록
        public function reviewInsert($userNo, $orderNo, $productCode, $orderProductIdx, $optionIdx, $optionTitle, $reviewDescription, $reviewType) {

            $sql = "
                INSERT INTO review
                (userNo, orderNo, productCode, orderProductIdx, optionIdx, optionTitle, reviewDescription, reviewStar, reviewType, date)
                VALUES(
                    '".$userNo."',
                    '".$orderNo."',
                    '".$productCode."',
                    '".$orderProductIdx."',
                    '".$optionIdx."',
                    '".$optionTitle."',
                    '".$reviewDescription."',
                    '".$_POST['reviewStar']."',
                    '".$reviewType."',
                    NOW()
                );

            ";

            $row = assocQuery($sql);

            return $row;

        }

        // 후기 조회
        public function reviewSelect($userNo) {

            $sql = "
                SELECT
                    r.*,
                    ruf.fileName
                FROM review as r
                LEFT JOIN reviewUploadFile as ruf
                ON r.idx = ruf.boardIdx
                WHERE
                    r.userNo = '".$userNo."'
                ORDER BY r.date DESC
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 특정 후기 조회
        public function reviewDetailSelect($userNo, $orderProductIdx) {

            $sql = "
                SELECT
                    *
                FROM review
                WHERE
                    userNo = '".$userNo."'
                AND
                    orderProductIdx = '".$orderProductIdx."'
            ";

            $row = assocQuery($sql);

            return $row;

        }

        // 특정 상품별 후기 조회
        public function productReviewSelect($productCode) {

            $sql = "
                SELECT
                    r.*,
                    ruf.fileName
                FROM review as r
                LEFT JOIN reviewUploadFile as ruf
                ON r.idx = ruf.boardIdx
                WHERE
                    r.productCode = '".$productCode."'
                ORDER BY r.date DESC
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 비회원 주문 조회
        public function nonMemberOrderSelect($buyerName, $buyerCell, $orderNo) {

            $sql = "
                SELECT
                    COUNT(*) AS orderCount
                FROM orderList
                WHERE
                    buyerName = '".$buyerName."'
                AND
                    buyerCell = '".$buyerCell."'
                AND
                    orderNo = '".$orderNo."'
            ";

            $row = assocQuery($sql);

            return $row;

        }

    }

?>