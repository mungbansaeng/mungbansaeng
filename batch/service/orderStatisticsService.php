<?php

    // 주문 통계 배치
    class OrderStatisticsService {

        // 주문 로그 등록
        public function orderStatisticsDayInsert() {

            $sql = "
                INSERT INTO orderStatisticsDay
                (date, time, pc, mobile, app, userY, userN, genderM, genderF, orderPrice, dlvPrice, usePointPrice, addPointPrice, couponPrice, payPrice, cancelPrice, payCard, payBank, payNaver, payKakao, payToss, payCellPhone)
                SELECT 
                    date_format(date_add(NOW(), INTERVAL -1 MONTH), '%Y-%m'),
                    date_format(date_add(NOW(), INTERVAL -1 HOUR), '%H'),
                    IFNULL(SUM(CASE WHEN ol.device = 'p' THEN 1 END), 0),
                    IFNULL(SUM(CASE WHEN ol.device = 'm' THEN 1 END), 0),
                    IFNULL(SUM(CASE WHEN ol.device = 'a' THEN 1 END), 0),
                    IFNULL(SUM(CASE WHEN ol.userNo NOT LIKE '%.%' THEN 1 ELSE 0 END), 0),
                    IFNULL(SUM(CASE WHEN ol.userNo LIKE '%.%' THEN 1 ELSE 0 END), 0),
                    IFNULL(SUM(CASE WHEN m.gender = 'M' THEN 1 ELSE 0 END), 0),
                    IFNULL(SUM(CASE WHEN m.gender = 'F' THEN 1 ELSE 0 END), 0),
                    IFNULL(SUM(ol.totalPrice), 0),
                    IFNULL(SUM(ol.dlvPrice), 0),
                    IFNULL(SUM(ol.usePointPrice), 0),
                    IFNULL(SUM(ol.addPointPrice), 0),
                    IFNULL(SUM(ol.couponPrice), 0),
                    IFNULL(SUM(ol.totalPrice + ol.dlvPrice - ol.usePointPrice - ol.couponPrice - ol.cancelPrice), 0)
                FROM orderProductList AS opl
                INNER JOIN orderList AS ol
                ON opl.orderNo = ol.orderNo
                INNER JOIN member AS m
                ON m.idx = ol.userNo
                WHERE
                    opl.status in ('2', '3', '4', '5', '6', '7')
                AND
                    opl.date6 > date_add(date_format(NOW(), '%Y-%m-01'), INTERVAL -1 MONTH)
                AND
                    opl.date6 < date_add(date_format(NOW(), '%Y-%m-01'), INTERVAL -1 SECOND)
            ";
            
            $row = query($sql);

        }

    }

?>