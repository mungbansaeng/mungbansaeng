<?php

    // ajax로 넘어오는 데이터 $page로 통일시키기

    if ($_POST['page']) {

        $page = $_POST['page'];

    }

    if ($_POST["act"]) { // 등록, 수정, 삭제일때 포함

        include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";
        include_once dirname(dirname(dirname(__FILE__)))."/admin/service/commonService.php";
        include_once dirname(dirname(dirname(__FILE__)))."/public/controller/adminLogController.php";

    }

    include_once dirname(dirname(dirname(__FILE__)))."/admin/service/memberService.php";

    $memberService = new MemberService();

    $result = array("success");

    if ($page == "memberConfig") { // 회원 공통설정

        try {

            if ($_POST['act'] == "modifyView") {

                $memberCofigSelect = $memberService -> memberCofigSelect();
                
                if (!$memberCofigSelect) {

                    throw new Exception("error : memberCofigSelect");
    
                }

                array_push($result, $memberCofigSelect);

                $memberLevelSelect = $memberService -> memberLevelSelect();
                
                if (!$memberLevelSelect) {

                    throw new Exception("error : memberLevelSelect");
    
                }

                array_push($result, $memberLevelSelect);

            } else if ($_POST['act'] == "modify") {

                $memberCofigModify = $memberService -> memberCofigModify();
                
                if ($memberCofigModify == "error") {

                    throw new Exception("error : memberCofigModify");
    
                }

                // post 배열로 나누기
                $memberLevel = explode("◈", $_POST['memberLevel']);
                $memberLevelName = explode("◈", $_POST['memberLevelName']);
                $memberLevelDiscount = explode("◈", $_POST['memberLevelDiscount']);
                $memberLevelPoint = explode("◈", $_POST['memberLevelPoint']);
                $memberLevelMinPrice = explode("◈", $_POST['memberLevelMinPrice']);
                $memberLevelDeliveryMinPrice = explode("◈", $_POST['memberLevelDeliveryMinPrice']);

                // 회원등급 테이블 조회
                $memberLevelSelect = $memberService -> memberLevelSelect();

                // 수정일때 전체삭제
                if (COUNT($memberLevelSelect) > 0) {

                    $memberLevelDelete = $memberService -> memberLevelAllDelete();
                    
                    if ($memberLevelDelete == "error") {
    
                        throw new Exception("error : memberLevelDelete");
        
                    }

                }

                // 수정일때 새로 등록
                if (COUNT($memberLevel) > 0) {

                    for ($mlc=0; $mlc < COUNT($memberLevel); $mlc++) {

                        $memberLevelInsert = $memberService -> memberLevelInsert($memberLevelName[$mlc], $memberLevel[$mlc], $memberLevelDiscount[$mlc], $memberLevelPoint[$mlc], $memberLevelMinPrice[$mlc], $memberLevelDeliveryMinPrice[$mlc]);
                    
                        if ($memberLevelInsert == "error") {
        
                            throw new Exception("error : memberLevelInsert");
            
                        }
    
                    }

                }

            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    } else if ($page == "member") { // 회원 관리

        try {

            if ($_POST['act'] == "memberList") {

                // 주문리스트 카운트 조회
                $memberCountSelect = $memberService -> memberCountSelect();

                array_push($result, $memberCountSelect);

                $memberSelect = $memberService -> memberSelect();
                
                if (!$memberSelect) {

                    throw new Exception("error : memberSelect");
    
                }

                array_push($result, $memberSelect);

            } else if ($_POST['act'] == "modify") {

                $memberCofigModify = $memberService -> memberCofigModify();

            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    }

    echo json_encode($result);

?>