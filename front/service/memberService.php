<?php

    // 회원
    class MemberService {

        // 회원관련 기본 정보
        public function memberSelect ($userNo) {

            $sql = "
                SELECT
                    m.*,
                    ml.memberLevel,
                    ml.memberLevelName,
                    ml.memberLevelDiscount,
                    ml.memberLevelPoint,
                    ml.memberLevelMinPrice,
                    ml.memberLevelDeliveryMinPrice
                FROM member AS m
                INNER JOIN memberLevel AS ml
                ON m.level = ml.memberLevel
                WHERE 
                    m.idx = '".$userNo."'
            ";

            if ($row = assocQuery($sql)) {

                return $row;

            } else {

                return "nonMember";

            }
    
        }

        // 회원가입
        public function memberJoinInsert ($cellPhone, $birthday, $address, $password, $smsSubscribe, $emailSubscribe) {

            $sql = "
                INSERT INTO member 
                (joinRoute, id, password, name, birthday, gender, cellPhone, email, postcode, address, level, recommender, withdraw, date, smsSubscribe, emailSubscribe, ci)
                VALUES(
                    '".$_POST['joinRoute']."',
                    '".$_POST['id']."',
                    '".$password."',
                    '".$_POST['name']."',
                    '".$birthday."',
                    '".$_POST['gender']."',
                    '".$cellPhone."',
                    '".$_POST['id']."',
                    '".$_POST['postcode']."',
                    '".$address."',
                    '200',
                    '".$_POST['recommender']."',
                    'N',
                    NOW(),
                    '".$smsSubscribe."',
                    '".$emailSubscribe."',
                    '".$_POST['ci']."'
                )
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }
    
        }

        // 회원정보 수정
        public function memberInfoUpdate ($userNo, $changePassword, $address, $smsSubscribe, $emailSubscribe) {

            $sql = "
                UPDATE member
                SET
                    password = '".$changePassword."',
                    address = '".$address."',
                    postcode = '".$_POST['postcode']."',
                    smsSubscribe = '".$smsSubscribe."',
                    emailSubscribe = '".$emailSubscribe."'
                WHERE
                    idx = '".$userNo."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 아이디 조회
        public function memberIdSelect ($id) {

            $sql = "
                SELECT
                    *
                FROM member
                WHERE 
                    id = '".$id."'
            ";

            $row = assocQuery($sql);

            return $row;
    
        }

        // 핸드폰번호 조회
        public function memberCellphoneSelect ($cellPhone) {

            $sql = "
                SELECT
                    *
                FROM member
                WHERE 
                    cellPhone = '".$cellPhone."'
            ";

            $row = assocQuery($sql);

            return $row;
    
        }

        // 로그인 로그
        public function memberLoginLogInsert ($userNo, $memberId, $result, $userIp) {

            $sql = "
                INSERT INTO memberLoginLog
                (userNo, loginId, loginResult, ip, date)
                VALUES(
                    '".$userNo."',
                    '".$memberId."',
                    '".$result."',
                    '".$userIp."',
                    NOW()
                )
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }
    
        }

        // 로그인 오류횟수 조회
        public function memberLoginErrorSelect ($memberId) {

            $sql = "
                SELECT
                    loginResult
                FROM memberLoginLog
                WHERE 
                    loginId = '".$memberId."'
                ORDER BY idx DESC
                LIMIT 5
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 로그인 날짜 업데이트
        public function memberLoginUpdate ($userNo) {

            $sql = "
                UPDATE member
                SET
                    loginDate = NOW()
                WHERE
                    idx = '".$userNo."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 포인트 업데이트
        public function memberPointUpdate ($userNo, $point) {

            $sql = "
                UPDATE member
                SET
                    point = ".$point."
                WHERE
                    idx = '".$userNo."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 배송지 전체 조회
        public function orderDlvSelect ($userNo) {

            $sql = "
                SELECT * FROM orderDlv WHERE userNo = '".$userNo."' ORDER BY idx DESC
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 배송지 상세 조회
        public function orderDlvDetailSelect ($idx) {

            $sql = "
                SELECT * FROM orderDlv WHERE idx = '".$idx."'
            ";

            $row = assocQuery($sql);

            return $row;

        }

        // 배송지 등록
        public function orderDlvInsert ($userNo, $dlvPopName, $dlvCellphone, $popPostcode, $dlvAddress, $defaltDlv) {

            $sql = "
                INSERT INTO orderDlv
                (userNo, name, cellPhone, postcode, address, defaltDlv)
                VALUES(
                    '".$userNo."',
                    '".$dlvPopName."',
                    '".$dlvCellphone."',
                    '".$popPostcode."',
                    '".$dlvAddress."',
                    '".$defaltDlv."'
                )
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 배송지 수정
        public function orderDlvUpdate ($idx, $dlvCellphone, $dlvAddress) {

            $sql = "
                UPDATE orderDlv
                SET
                    name = '".$_POST['dlvPopName']."',
                    cellPhone = '".$dlvCellphone."',
                    postcode = '".$_POST['popPostcode']."',
                    address = '".$dlvAddress."',
                    defaltDlv = '".$_POST['defaltDlv']."'
                WHERE
                    idx = '".$idx."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 기본배송지 수정
        public function orderDefaltDlvUpdate ($userNo, $defaltDlv) {

            $sql = "
                UPDATE orderDlv
                SET
                    defaltDlv = '".$defaltDlv."'
                WHERE
                    userNo = '".$userNo."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 배송지 삭제
        public function orderDlvDelete ($idx) {

            $sql = "
                DELETE FROM orderDlv WHERE idx = '".$idx."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

    }

?>