<?php

    // 포인트
    class PointService {

        // 포인트 지급
        public function pointInsert($userNo, $pointTitle, $amount, $type, $adminId, $remain) {

            global $conn;

            $sql = "
                INSERT INTO pointLog
                    (userNo, pointTitle, amount, type, adminId, remain, date)
                    VALUES(
                        '".$userNo."',
                        '".$pointTitle."',
                        '".$amount."',
                        '".$type."',
                        '".$adminId."',
                        '".$remain."',
                        NOW()
                    );
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 전체 포인트 조회
        public function pointSelect($userNo) {

            global $conn;

            $sql = "
                SELECT 
                    pointTitle,
                    amount,
                    type,
                    remain,
                    date
                FROM pointLog 
                WHERE 
                    userNo = '".$userNo."'
                ORDER BY date DESC
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 특정 사용 포인트 조회
        public function pointDetailSelect($userNo, $reason, $type) {

            global $conn;

            $sql = "
                SELECT amount FROM pointLog WHERE userNo = '".$userNo."' AND pointTitle like '%".$reason."%' AND type = '".$type."';
            ";

            $row = assocQuery($sql);

            return $row;

        }

        // 전체 포인트 조회
        public function pointListSelect($userNo, $start, $end) {

            global $conn;

            $sql = "
                SELECT 
                    pointTitle,
                    amount,
                    type,
                    remain,
                    date
                FROM pointLog 
                WHERE 
                    userNo = '".$userNo."'
                ORDER BY date DESC
                LIMIT ".$start.", ".$end."
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

    }

?>