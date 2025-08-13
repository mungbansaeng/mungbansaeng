<?php

    // 캘린더 
    class PlanService {

        // 캘린더 일정 조회
        public function selectPlan () {

            $planSql = "SELECT DISTINCT(day) FROM plan WHERE year = '{$_GET['year']}' AND month = '{$_GET['month']}'";
            
            $row = loopAssocQuery($planSql);

            return $row;

        }

        // 캘린더 일정 상세 리스트 조회
        public function selectPlanList () {

            $planListSql = "SELECT idx, description FROM plan WHERE year = '{$_GET['year']}' AND month = '{$_GET['month']}' AND day = '{$_GET['day']}'";
            
            $row = loopAssocQuery($planListSql);

            return $row;

        }

        // 캘린더 일정 등록
        public function planInsert () {

            $planInsertSql = "
                INSERT INTO plan 
                (year, month, day, description, adminId, date) 
                VALUES(
                    '{$_GET['year']}',
                    '{$_GET['month']}',
                    '{$_GET['day']}',
                    '{$_GET['description']}',
                    '{$_SESSION['admin_id']}',
                    NOW()
                )
            ";
            
            $row = query($planInsertSql);

            return $row;

        }

        // 캘린더 일정 수정
        public function planUpdate() {

            $planUpdateSql = "
                UPDATE plan
                SET
                    description = '{$_GET['description']}'
                WHERE
                    idx = '{$_GET['idx']}'
            ";
            
            $row = query($planUpdateSql);

            return $row;

        }

        // 캘린더 일정 삭제
        public function planDelete() {

            $planDeleteSql = "
                DELETE
                    FROM plan
                    WHERE idx = '{$_GET['idx']}'
            ";
            
            $row = query($planDeleteSql);

            return $row;

        }

    }

?>