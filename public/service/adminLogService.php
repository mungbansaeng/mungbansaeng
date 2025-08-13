<?php

    // 로그 
    class AdminLogService {

        // 로그 등록
        public function insertLog($description, $tableIdx, $updateTable, $act) {

            $adminLogSql = "
                INSERT INTO adminLog 
                (description, updateTable, act, tableIdx, adminId, date) 
                VALUES(
                    '".$description."',
                    '".$updateTable."',
                    '".$act."',
                    '".$tableIdx."',
                    '".$_SESSION['admin_id']."',
                    NOW()
                )
            ";
            
            $row = query($adminLogSql);

            return $row;

        }

    }

?>