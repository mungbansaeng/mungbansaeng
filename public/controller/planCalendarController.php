<?php

    include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";
    include_once dirname(dirname(dirname(__FILE__)))."/public/service/planCalendarService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/public/controller/adminLogController.php";

    // calendar
    try {

        header('Content-Type: json; charset=UTF-8');

        $planSerice = new PlanService();

        // 일정 등록
        if ($_GET["act"] == "planRegi") {

            $planInsert = $planSerice -> planInsert();

            if (!$planInsert) {

                throw new Exception("service error : planInsert");
    
            } else {
                
                $logMonth = $_GET['month'] < 10 ? "0".$_GET['month'] : $_GET['month'];
                $logDay = $_GET['day'] < 10 ? "0".$_GET['day'] : $_GET['day'];

                $description = "일정 등록한 캘린더 날짜 : ".$_GET['year']."-".$logMonth."-".$logDay.", 내용 : ".$_GET['description'];
                $tableIdx = mysqli_insert_id($conn); // insert될때 pk값
                $updateTable = "plan";
                $act = "insert";

                $adminLog = $adminLogSerice -> insertLog($description, $tableIdx, $updateTable, $act);

                if (!$adminLog) {
        
                    throw new Exception("service error : planInsertLog");
        
                }

            }

        } else if ($_GET["act"] == "planModi") {

            $planUpdate = $planSerice -> planUpdate();

            if (!$planUpdate) {

                throw new Exception("service error : planUpdate");
    
            } else {

                $logMonth = $_GET['month'] < 10 ? "0".$_GET['month'] : $_GET['month'];
                $logDay = $_GET['day'] < 10 ? "0".$_GET['day'] : $_GET['day'];

                $description = "일정 등록한 캘린더 날짜 : ".$_GET['year']."-".$logMonth."-".$logDay.", 이전 내용 : ".$_GET['beforeDescription'];
                $tableIdx = $_GET['idx'];
                $updateTable = "plan";
                $act = "update";

                $adminLog = $adminLogSerice -> insertLog($description, $tableIdx, $updateTable, $act);

                if (!$adminLog) {
        
                    throw new Exception("service error : planUpdateLog");
        
                }

            }

        } else if ($_GET["act"] == "planDel") {

            $planDelete = $planSerice -> planDelete();

            if (!$planDelete) {

                throw new Exception("service error : planDelete");
    
            } else {

                $logMonth = $_GET['month'] < 10 ? "0".$_GET['month'] : $_GET['month'];
                $logDay = $_GET['day'] < 10 ? "0".$_GET['day'] : $_GET['day'];

                $description = "일정 등록한 캘린더 날짜 : ".$_GET['year']."-".$logMonth."-".$logDay.", 이전 내용 : ".$_GET['beforeDescription'];
                $tableIdx = $_GET['idx'];
                $updateTable = "plan";
                $act = "delete";

                $adminLog = $adminLogSerice -> insertLog($description, $tableIdx, $updateTable, $act);

                if (!$adminLog) {
        
                    throw new Exception("service error : planDeleteLog");
        
                }

            }

        }

        $resultArr = array();

        // 캘린더 날짜 생성

        $getMonth = $_GET['month'] < 10 ? "0".$_GET['month'] : $_GET['month'];

        $date = $_GET['year']."-".$getMonth."-01"; // 날짜
        $time = strtotime($date); // 타임스탬프
        $startWeek = date('w', $time); // 시작 요일
        $totalDay = date('t', $time); // 현재 달의 총 날짜

        // 캘린더 일정 조회
        $planInfoArr = array(); // service에서 받아온 데이터 넣을 배열
        $planInfoList = array(); // fo에 사용할 배열
        $planIdx = array(); // fo에 사용할 배열

        if ($_GET["act"] == "planListCheck") {

            $planInfoArr = $planSerice -> selectPlan(); // 캘린더 일정 조회

        } else if ($_GET["act"] == "planList" || $_GET["act"] == "planRegi" || $_GET["act"] == "planModi" || $_GET["act"] == "planDel") {

            $planInfoArr = $planSerice -> selectPlanList(); // 캘린더 일정 상세 리스트 조회

        }
        
        if ($planInfoArr) {

            $result = "success";

        } else {

            $result = "empty";

        }

        // fo에 필요하게 데이터 수정
        for ($pd=0; $pd < COUNT($planInfoArr); $pd++) {

            if ($_GET["act"] == "planListCheck") {

                array_push($planInfoList, $planInfoArr[$pd]['day']);
    
            } else if ($_GET["act"] == "planList" || $_GET["act"] == "planRegi" || $_GET["act"] == "planModi" || $_GET["act"] == "planDel") {
    
                array_push($planIdx, $planInfoArr[$pd]['idx']);
                array_push($planInfoList, $planInfoArr[$pd]['description']);
    
            }

        }

        $resultArr = array($result, $startWeek, $totalDay, $_GET['year'], $_GET['month'], $planInfoList, $planIdx);

        echo json_encode($resultArr);

    } catch (Exception $errorMsg) {

        echo $errorMsg;

        exit;

    }

?>