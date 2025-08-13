<?php

    // ajax로 넘어오는 데이터 $page로 통일시키기

    if ($_POST['page']) {

        $page = $_POST['page'];

    }

    if ($_POST["act"]) {

        include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";    

    }

    include_once dirname(dirname(dirname(__FILE__)))."/admin/service/mainService.php";

    // 어드민 로그인
    if ($page == "counterInfo") {

        try {

            $adminLoginService = new AdminLoginService();

            print_r($_POST);

            exit;

            if ($_POST["act"] == "search") {

                $adminId = $_POST['id'];
                $adminPassword = hash("SHA256", $_POST['password']);

                $loginInfo = $adminLoginService -> adminLogin($adminId, $adminPassword);

                if($loginInfo){

                    $_SESSION['admin_id'] = $loginInfo['admin_id'];
                    $_SESSION['admin_name'] = $loginInfo['admin_name'];
                    $_SESSION['admin_level'] = $loginInfo['admin_level'];
        
                    echo "success";
                    
                } else {
        
                    echo "error";
        
                }

            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    }

?>