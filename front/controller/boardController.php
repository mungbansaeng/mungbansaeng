<?php

    // ajax로 넘어오는 데이터 $page로 통일시키기

    if ($_POST['page']) {

        $page = $_POST['page'];

    }

    if ($_POST["act"]) {

        include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";    

    }

    include_once dirname(dirname(dirname(__FILE__)))."/front/service/commonService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/service/boardService.php";

    $boardCommonService = new BoardCommonService();
    $categoryService = new CategoryService();

    $result = array("success");

    if ($page == "normalPage") { // 소개 게시판

        try{

            if ($_POST["act"] == "list") {

                // 소개 게시판 조회
                $normalPageSelect = $boardCommonService -> normalPageSelect();

                array_push($result, $normalPageSelect);

            }

        }catch(Exception $errorMsg){

            echo $errorMsg;

            exit;

        }

    } else if ($page == "board") {

        try{

            if ($_POST["act"] == "list") {

                // 게시판 조회
                $boardListSelect = $boardCommonService -> boardListSelect();

                array_push($result, $boardListSelect);

                // 카테고리 리스트 조회
                $categorySelect = $categoryService -> categorySelect();

                array_push($result, $categorySelect);

                // 서브카테고리 리스트 조회
                $subCategoryListSelect = $categoryService -> subCategoryListSelect();

                array_push($result, $subCategoryListSelect);

            }

        }catch(Exception $errorMsg){

            echo $errorMsg;

            exit;

        }

    }
    
    echo json_encode($result);

?>