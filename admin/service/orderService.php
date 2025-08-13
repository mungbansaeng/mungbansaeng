<?php

    // 주문
    class OrderService {

        // 주문리스트 카운트
        public function orderListCountSelect () {

            $sql = "
                SELECT
                    COUNT(orderNo) AS totalCount
                FROM orderList
            ";

            $row = assocQuery($sql);

            return $row;

        }

        // 주문리스트 조회
        public function orderListSelect () {

            $sql = "
                SELECT
                    m.id,
                    ol.orderNo,
                    ol.payType,
                    (CASE 
                        WHEN ol.payType = 'creditpay' THEN '신용카드' 
                        WHEN ol.payType = 'bankpay' THEN '무통장입금' 
                        WHEN ol.payType = 'naverpay' THEN '네이버페이' 
                        WHEN ol.payType = 'kakaopay' THEN '카카오페이' 
                        WHEN ol.payType = 'tosspay' THEN '토스페이' 
                        WHEN ol.payType = 'paycopay' THEN '페이코' 
                        ELSE ''
                    END) AS payTypeName,
                    ol.totalPrice,
                    ol.dlvPrice,
                    ol.usePointPrice,
                    ol.couponPrice,
                    (
                        SELECT 
                            (CASE 
                                WHEN sopl.status = '1' THEN '주문(미입금)' 
                                WHEN sopl.status = '2' THEN '입금완료' 
                                WHEN sopl.status = '3' THEN '배송준비중' 
                                WHEN sopl.status = '4' THEN '배송중' 
                                WHEN sopl.status = '5' THEN '배송완료' 
                                WHEN sopl.status = '6' THEN '구매확정' 
                                WHEN sopl.status = '7' THEN '후기작성완료' 
                                WHEN sopl.status = '8' THEN '취소요청' 
                                WHEN sopl.status = '9' THEN '취소완료' 
                                WHEN sopl.status = '10' THEN '반품요청' 
                                WHEN sopl.status = '11' THEN '반품수거중' 
                                WHEN sopl.status = '12' THEN '반품수거완료' 
                                WHEN sopl.status = '13' THEN '반품완료' 
                                WHEN sopl.status = '14' THEN '환불요청' 
                                WHEN sopl.status = '15' THEN '환불완료' 
                                WHEN sopl.status = '16' THEN '교환요청' 
                                WHEN sopl.status = '17' THEN '교환수거중' 
                                WHEN sopl.status = '18' THEN '교환수거완료' 
                                WHEN sopl.status = '19' THEN '교환재배송중' 
                                WHEN sopl.status = '20' THEN '교환완료' 
                                ELSE ''
                            END)
                        FROM orderProductList AS sopl 
                        WHERE 
                            ol.orderNo = sopl.orderNo 
                        ORDER BY status LIMIT 1
                    ) AS status,
                    ol.date
                FROM orderList AS ol
                INNER JOIN member AS m
                ON m.idx = ol.userNo
                GROUP BY ol.orderNo
                ORDER BY ol.date DESC
                LIMIT ".$_POST['limitStart'].", ".$_POST['showNum']."
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 주문 상세조회
        public function orderDetailSelect () {

            $sql = "
                SELECT
                    m.id,
                    ol.orderNo,
                    ol.dlvName,
                    ol.dlvCell,
                    ol.buyerEmail,
                    ol.dlvCompany,
                    ol.dlvCode,
                    ol.dlvPostcode,
                    ol.dlvAddress,
                    ol.dlvMemo,
                    ol.totalPrice,
                    ol.couponPrice,
                    ol.usePointPrice,
                    ol.dlvPrice,
                    ol.payType,
                    (CASE 
                        WHEN ol.payType = 'creditpay' THEN '신용카드' 
                        WHEN ol.payType = 'bankpay' THEN '무통장입금' 
                        WHEN ol.payType = 'naverpay' THEN '네이버페이' 
                        WHEN ol.payType = 'kakaopay' THEN '카카오페이' 
                        WHEN ol.payType = 'tosspay' THEN '토스페이' 
                        WHEN ol.payType = 'paycopay' THEN '페이코' 
                        ELSE ''
                    END) AS payTypeName,
                    ol.date,
                    puf.fileName,
                    opl.idx AS orderProductIdx,
                    opl.title,
                    opl.optionTitle,
                    opl.price,
                    opl.qty,
                    opl.status,
                    opl.optionIdx,
                    opl.productCode
                FROM orderList AS ol
                LEFT JOIN orderProductList AS opl
                ON ol.orderNo = opl.orderNo
                INNER JOIN product AS p
                ON opl.productCode = p.productCode
                LEFT JOIN productOption AS po
                ON opl.optionIdx = po.idx
                INNER JOIN productUploadFile AS puf
                ON p.idx = puf.boardIdx
                INNER JOIN member AS m
                ON ol.userNo = m.idx
                WHERE
                    ol.orderNo = '".$_POST['orderNo']."'
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 상품별 배송상태 변경
        public function orderStatusUpdate($orderProductIdx, $status) {

            $sql = "
                UPDATE orderProductList
                SET
                    status = '".$status."',
                    date".$status." = NOW()
                WHERE
                    idx in (".$orderProductIdx.")
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 주문 취소
        public function orderCancel ($orderNo) {

            global $conn;

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

        // 주문 내역 수정
        public function orderInfoUpdate($dlvAddress, $dlvCell, $orderNo) {

            $sql = "
                UPDATE orderList
                SET
                    dlvName = '".$_POST['dlvName']."',
                    dlvCell = '".$dlvCell."',
                    buyerEmail = '".$_POST['buyerEmail']."',
                    dlvCompany = '".$_POST['dlvCompany']."',
                    dlvCode = '".$_POST['dlvCode']."',
                    dlvAddress = '".$dlvAddress."'
                WHERE
                    orderNo = '".$orderNo."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 주문 내역 수정
        public function orderProductDlvInfoUpdate() {

            $sql = "
                UPDATE orderProductList
                SET
                    dlvCompany = '".$_POST['dlvCompany']."',
                    dlvCode = '".$_POST['dlvCode']."'
                WHERE
                    orderNo = '".$_POST['orderNo']."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

    }

?>