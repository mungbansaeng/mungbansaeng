<?php

    include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/accessLogService.php";

    // 접속 로그
    try {

        $accessLogSerice = new AccessLogService();

        // 해당 아이피 금일 접속 유무
        $checkLog = $accessLogSerice -> checkLog($userIp);

        // 해당날짜가 있는지 없는지 확인
        $accessLogCheck = $accessLogSerice -> accessLogCheck($date);

        // 오늘 접속자 초기화
        if ($accessLogCheck == 0) {

            $accessLogSerice -> accessCountReset();

        }

        if ($checkLog['date'] !== $date && preg_match($checkBot, $_SERVER['HTTP_USER_AGENT']) == 0) { // 해당 아이피가 금일 접속 X, bot이 아닐때

            // 접속 로그 등록
            $accessLog = $accessLogSerice -> accessLogInsert($date, $time, $userIp, $referer, $checkBrowser);

            if (!$accessLog) {

                throw new Exception("service error : accessLogInsert");

            } else {

                // 접속 카운트
                $accessLogSerice -> accessCountUpdate();

                if ($accessLogCheck > 0) { // 해당날짜가 있으면 update

                    $accessLogSerice -> accessLogCountUpdate($date, $week, $hours);
                    
                } else { // 해당날짜가 있으면 insert

                    $accessLogSerice -> accessLogCountInsert($date, $week, $hours);

                }

            }

        }

    } catch (Exception $errorMsg) {

        echo $errorMsg;

        exit;

    }

?>