<?php

    // 접속 로그
    class AccessLogService {

        // 해당 아이피 금일 접속 유무
        public function checkLog ($userIp) {

            global $conn;

            $sql = "SELECT * FROM counterInfo WHERE userIp = '".$userIp."' AND date = '".date("Y-m-d")."'";
            
            $row = assocQuery($sql);

            return $row;

        }

        // 접속 로그 등록
        public function accessLogInsert ($date, $time, $userIp, $referer, $checkBrowser) {

            global $conn;

            $sql = "
                INSERT INTO counterInfo
                (date, time, userIp, referer, agent, browser)
                VALUES(
                    '".$date."',
                    '".$time."',
                    '".$userIp."',
                    '".$referer."',
                    '".$_SERVER['HTTP_USER_AGENT']."',
                    '".$checkBrowser."'
                );
            ";
            
            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 접속 카운트
        public function accessCountUpdate () {

            global $conn;

            $sql = "
                UPDATE counter
                SET
                    todayCount = todayCount + 1,
                    totalCount = totalCount + 1
            ";
            
            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 접속 카운트 리셋
        public function accessCountReset () {

            global $conn;

            $sql = "
                UPDATE counter
                SET
                    todayCount = 0
            ";
            
            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 해당날짜가 있는지 없는지 확인
        public function accessLogCheck ($date) {

            global $conn;

            $sql = "SELECT date FROM counterLog WHERE date = '".$date."'";
            
            $row = numQuery($sql);

            return $row;

        }

        // 해당날짜가 있으면 update
        public function accessLogCountUpdate ($date, $week, $hours) {

            global $conn;

            $sql = "
                UPDATE counterLog
                SET
                    week".$week." = week".$week." + 1,
                    hours".$hours." = hours".$hours." + 1,
                    count = count + 1
                WHERE date = '".$date."'
            ";
            
            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 해당날짜가 없으면 insert
        public function accessLogCountInsert ($date, $week, $hours) {

            global $conn;

            $sql = "
                INSERT INTO counterLog
                (date, week".$week.", hours".$hours.", count)
                VALUES(
                    '".$date."',
                    '1',
                    '1',
                    '1'
                );
            ";
            
            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

    }

?>