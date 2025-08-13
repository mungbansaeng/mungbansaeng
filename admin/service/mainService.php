<?php

    // 어드민 로그인
    class AdminLoginService {

        public function adminLogin ($adminId, $adminPassword) {

            $adminLoginSql = "SELECT idx, admin_id, admin_name, admin_level FROM aduser WHERE admin_id = '".$adminId."' AND admin_password = '".$adminPassword."'";
            
            $row = assocQuery($adminLoginSql);

            return $row;

        }

    }

?>