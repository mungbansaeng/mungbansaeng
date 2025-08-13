<?php

    // ajax로 넘어오는 데이터 $page로 통일시키기

    if ($_POST['page']) {

        $page = $_POST['page'];

    }

    if ($_POST["act"]) { // 등록, 수정, 삭제일때 포함

        include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";
        include_once dirname(dirname(dirname(__FILE__)))."/front/service/commonService.php";
        include_once dirname(dirname(dirname(__FILE__)))."/front/service/pointService.php";
        include_once dirname(dirname(dirname(__FILE__)))."/front/service/couponService.php";

    }

    include_once dirname(dirname(dirname(__FILE__)))."/front/service/memberService.php";

    $configService = new ConfigService();
    $memberService = new MemberService();
    $pointService = new PointService();
    $couponService = new CouponService();

    $result = array("success");

    if ($page == "memberConfig") { // 회원 공통설정

        try {

            if ($_POST['act'] == "modifyView") {

                $memberCofigSelect = $memberService -> memberCofigSelect();
                
                if (!$memberCofigSelect) {

                    throw new Exception("error : memberCofigSelect");
    
                }

                array_push($result, $memberCofigSelect);

            } else if ($_POST['act'] == "modify") {

                $memberCofigModify = $memberService -> memberCofigModify();

            }

            echo json_encode($result);

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    }

    if ($page == "memberLogin") { // 로그인 / 로그아웃

        try{
    
            if ($_POST['act'] == "login") {

                // 로그인 오류 조회
                $memberLoginErrorSelect = $memberService -> memberLoginErrorSelect($_POST['id']);

                $loginErrorCount = 0;

                for ($lec=0; $lec < COUNT($memberLoginErrorSelect); $lec++) {

                    if ((int) $memberLoginErrorSelect[$lec]['loginResult'] > 0) {

                        $loginErrorCount++;

                    }

                }

                // 오류가 5회 이하일때 정상
                if ($loginErrorCount < 5) {

                    $memberIdSelect = $memberService -> memberIdSelect($_POST['id']);
                    
                    if ($memberIdSelect['id'] == $_POST['id']) {

                        $memberSelect = $memberService -> memberSelect($memberIdSelect['idx']);

                        if ($memberSelect['password'] !== hash("sha256", $_POST['password'])) {

                            // 로그인 로그 입력
                            $memberLoginLogInsert = $memberService -> memberLoginLogInsert($memberSelect['idx'], $memberSelect['id'], 2, $userIp);

                            $result[0] = "error";

                        } else {

                            // 로그인 로그 입력
                            $memberLoginLogInsert = $memberService -> memberLoginLogInsert($memberSelect['idx'], $memberSelect['id'], 0, $userIp);

                            // 로그인 날짜 업데이트
                            $memberLoginUpdate = $memberService -> memberLoginUpdate($memberSelect['idx']);
                            
                            // 자동로그인
                            if ($_POST['autoLogin'] == "Y") {

                                $autoLoginKey = base64_encode($memberSelect['idx']."◈".base64_encode($secretKey)."◈".$memberSelect['id']);

                                setcookie("al_uid", $autoLoginKey, time()+7776000, "/");

                            }

                            $_SESSION['userNo'] = $memberSelect['idx'];
                            $_SESSION['userId'] = $memberSelect['id'];

                        }
        
                    } else {

                        // 로그인 로그 입력
                        $memberLoginLogInsert = $memberService -> memberLoginLogInsert(0, $_POST['id'], 1, $userIp);

                        $result[0] = "error";

                    }

                } else { // 오류가 5회 이상일때 막힘

                    $result[0] = "block";

                }

            } else if ($_POST["act"] == "logout") {

                setcookie("al_uid", "", 0, "/");

                unset($_SESSION['userNo']);
                unset($_SESSION['userId']);

                if ($_SESSION['userNo'] || $_SESSION['userId']) {

                    $result[0] = "error";

                }

            }

            echo json_encode($result);
    
        }catch(Exception $errorMsg){
    
            echo $errorMsg;
    
            exit;
    
        }

    }

    if ($page == "memberJoin") { // 회원가입 / 탈퇴

        try{
    
            if ($_POST['act'] == "joinForm") {

                // 중복 아이디 체크
                $memberIdSelect = $memberService -> memberIdSelect($_POST['id']);

                if (COUNT($memberIdSelect) > 0) {

                    $errorResult = array("exist");

                    echo json_encode($errorResult);

                    exit;

                }

            } else if ($_POST['act'] == "join") {

                $cellPhone = $_POST['cellPhone1']."◈".$_POST['cellPhone2']."◈".$_POST['cellPhone3'];

                $birthday = $_POST['birthYear']."◈".$_POST['birthMonth']."◈".$_POST['birthDay'];

                $address = $_POST['address1']."◈".$_POST['address2'];

                $password = hash("sha256", $_POST['password']);

                $_POST['smsSubscribe'] == "" ? $smsSubscribe = "N" : $smsSubscribe = "Y";
            
                $_POST['emailSubscribe'] == "" ? $emailSubscribe = "N" : $emailSubscribe = "Y";

                // 중복 아이디 체크
                $memberIdSelect = $memberService -> memberIdSelect($_POST['id']);

                if (COUNT($memberIdSelect) > 0) {

                    $errorResult = array("existId");

                    echo json_encode($errorResult);

                    exit;

                }

                // 중복 핸드폰번호 체크
                $memberCellphoneSelect = $memberService -> memberCellphoneSelect($cellPhone);

                if (COUNT($memberCellphoneSelect) > 0) {

                    $errorResult = array("existCellphone");

                    echo json_encode($errorResult);

                    exit;

                }

                // 회원가입
                $memberJoinInsert = $memberService -> memberJoinInsert($cellPhone, $birthday, $address, $password, $smsSubscribe, $emailSubscribe);

                if ($memberJoinInsert == "success") {

                    $memberIdx = mysqli_insert_id($conn); // insert될때 pk값

                } else {

                    throw new Exception("error : memberJoinInsert");

                }

                $memberSelect = $memberService -> memberSelect($memberIdx);

                // 회원가입 포인트 지급
                $configSelect = $configService -> configSelect();
                
                if ($configSelect['memberJoinPoint'] > 0) {

                    // 회원 포인트
                    $memberPoint = $memberSelect['point'] + $configSelect['memberJoinPoint'];

                    // 포인트 지급
                    $pointInsert = $pointService -> pointInsert($memberSelect['idx'], "신규가입 축하 포인트", $configSelect['memberJoinPoint'], "+", "system", $memberPoint);

                    if ($pointInsert == "error") {

                        throw new Exception("error : pointInsert");

                    }

                    // 회원 포인트 업데이트
                    $memberPointUpdate = $memberService -> memberPointUpdate($memberSelect['idx'], $memberPoint);

                    if ($memberPointUpdate == "error") {

                        throw new Exception("error : memberPointUpdates");

                    }

                }
                
                // 회원가입 쿠폰 조회
                $couponNo = "";

                $couponSelect = $couponService -> couponSelect();

                for ($ci=0; $ci < COUNT($couponSelect); $ci++) {
    
                    if ($couponSelect[$ci]['couponType'] == 3) {

                        $couponNo = $couponSelect[$ci]['couponNo'];
                        $discountPrice = $couponSelect[$ci]['discountPrice'];
                        $discountPercent = $couponSelect[$ci]['discountPercent'];
                        $minPrice = $couponSelect[$ci]['minPrice'];
                        $maxPrice = $couponSelect[$ci]['maxPrice'];
    
                        break;
    
                    }

                }

                if ($couponNo !== "") {

                    // 회원가입 쿠폰 지급
                    $couponDownloadInsert = $couponService -> couponDownloadInsert($memberSelect['idx'], $couponNo, $discountPrice, $discountPercent, $minPrice, $maxPrice);

                    if ($couponDownloadInsert == "error") {
    
                        throw new Exception("error : couponDownloadInsert");
    
                    }

                }

                // 배송지를 기본배송지로 입력
                $orderDlvInsert = $memberService -> orderDlvInsert($memberSelect['idx'], $_POST['name'], $cellPhone, $_POST['postcode'], $address, "Y");

                if ($orderDlvInsert == "error") {
    
                    throw new Exception("error : orderDlvInsert");

                }

                $_SESSION['userNo'] = $memberSelect['idx'];
                $_SESSION['userId'] = $memberSelect['id'];

                // 로그인 로그 입력
                $memberLoginLogInsert = $memberService -> memberLoginLogInsert($memberSelect['idx'], $memberSelect['id'], 0, $userIp);

                // 로그인 날짜 업데이트
                $memberLoginUpdate = $memberService -> memberLoginUpdate($memberSelect['idx']);

                // 입력한 추천인이 유효한지 조회
                $recommenderMemberIdSelect = $memberService -> memberIdSelect($_POST['recommender']);

                if ($configSelect['recommenderPoint'] > 0 && $_POST['recommender'] !== "" && $recommenderMemberIdSelect !== NULL) { // 추천인이 올바르면 포인트 지급

                    // 추천인 입력한 회원 포인트
                    $memberPoint = $memberPoint + $configSelect['recommenderPoint'];

                    // 추천인 입력한 포인트 지급
                    $pointInsert = $pointService -> pointInsert($memberSelect['idx'], "신규가입 추천인 포인트", $configSelect['recommenderPoint'], "+", "system", $memberPoint);

                    if ($pointInsert == "error") {

                        throw new Exception("error : recommenderPointInsert1");

                    }

                    // 회원 포인트 업데이트
                    $memberPointUpdate = $memberService -> memberPointUpdate($memberSelect['idx'], $memberPoint);

                    if ($memberPointUpdate == "error") {

                        throw new Exception("error : recommenderMemberPointUpdates1");

                    }

                    // 추천인 회원 포인트
                    $recommenderMemberPoint = $recommenderMemberIdSelect['point'] + $configSelect['recommenderPoint'];

                    // 추천인 포인트 지급
                    $pointInsert = $pointService -> pointInsert($recommenderMemberIdSelect['idx'], "피추천인 포인트 (".$recommenderMemberIdSelect['id'].")", $configSelect['recommenderPoint'], "+", "system", $recommenderMemberPoint);

                    if ($pointInsert == "error") {

                        throw new Exception("error : recommenderPointInsert2");

                    }

                    // 회원 포인트 업데이트
                    $memberPointUpdate = $memberService -> memberPointUpdate($recommenderMemberIdSelect['idx'], $recommenderMemberPoint);

                    if ($memberPointUpdate == "error") {

                        throw new Exception("error : recommenderMemberPointUpdates2");

                    }

                }

            }

            echo json_encode($result);
    
        }catch(Exception $errorMsg){
    
            echo $errorMsg;
    
            exit;
    
        }

    }

?>