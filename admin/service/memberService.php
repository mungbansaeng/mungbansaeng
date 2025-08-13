<?php

    // 회원 페이지
    class MemberService {

        // 회원 공통설정 조회
        public function memberCofigSelect() {

            $sql = "
                SELECT
                    memberJoinPoint,
                    recommenderPoint
                FROM config
            ";

            if ($row = assocQuery($sql)) {

                return $row;

            } else {

                return "error";

            }
    
        }

        // 회원 공통설정 수정
        public function memberCofigModify() {

            $sql = "
                UPDATE config
                SET
                    memberJoinPoint = '".$_POST['memberJoinPoint']."',
                    recommenderPoint = '".$_POST['recommenderPoint']."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }
    
        }

        // 회원 등급 조회
        public function memberLevelSelect () {

            $sql = "
                SELECT
                    *
                FROM memberLevel
                ORDER BY memberLevel
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 회원 등급 등록
        public function memberLevelInsert ($memberLevelName, $memberLevel, $memberLevelDiscount, $memberLevelPoint, $memberLevelMinPrice, $memberLevelDeliveryMinPrice) {

            $sql = "
                INSERT INTO memberLevel
                (memberLevel, memberLevelName, memberLevelDiscount, memberLevelPoint, memberLevelMinPrice, memberLevelDeliveryMinPrice)
                VALUES(
                    '".$memberLevel."',
                    '".$memberLevelName."',
                    '".$memberLevelDiscount."',
                    '".$memberLevelPoint."',
                    '".$memberLevelMinPrice."',
                    '".$memberLevelDeliveryMinPrice."'
                );
            ";

            if(query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 회원 등급 전체 삭제
        public function memberLevelAllDelete() {

            $sql = "
                DELETE FROM memberLevel
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // // 회원 카운트
        // public function memberCountSelect () {

        //     $sql = "
        //         SELECT
        //             COUNT(idx) AS totalCount
        //         FROM member
        //     ";

        //     $row = assocQuery($sql);

        //     return $row;

        // }

        // // 회원 조회
        // public function memberSelect() {

        //     $sql = "
        //         SELECT
        //             m.idx,
        //             m.id,
        //             m.name,
        //             CASE 
        //                 WHEN m.level = '100' THEN '임직원'
        //                 ELSE ''
        //             END
        //             m.level,
        //             m.cellPhone,
        //             m.date
        //         FROM member AS m
        //     ";

        //     $row = loopAssocQuery($sql);

        //     return $row;
    
        // }

    }

?>