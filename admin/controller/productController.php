<?php

    // ajax로 넘어오는 데이터 $page로 통일시키기

    if ($_POST['page']) {

        $page = $_POST['page'];

    }

    if ($_POST["act"]) { // 등록, 수정, 삭제일때 포함

        include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";
        include_once dirname(dirname(dirname(__FILE__)))."/admin/service/commonService.php";
        include_once dirname(dirname(dirname(__FILE__)))."/admin/service/boardService.php";
        include_once dirname(dirname(dirname(__FILE__)))."/public/controller/adminLogController.php";

    }

    include_once dirname(dirname(dirname(__FILE__)))."/admin/service/productService.php";

    $dbService = new DbService();
    $productService = new ProductService();
    $boardCommonService = new BoardCommonService();
    $editorService = new EditorService();
    $categoryService = new CategoryService();

    if ($page == "productBrand") { // 상품 브랜드

        try{

            if ($_POST["act"] == "reg") {

                // 상품 브랜드 등록
                $productBrandInsert = $productService -> productBrandInsert();

                $productBrandIdx = mysqli_insert_id($conn); // insert될때 pk값

                for ($btc=0; $btc < COUNT($_POST['boardTempIdx']); $btc++) {

                    // 첨부파일 idx 업데이트
    
                    $boardTempIdx = $_POST['boardTempIdx'][$btc];
    
                    $productBrandIdxUpdate = $boardCommonService -> boardIdxUpdate($productBrandIdx, $boardTempIdx);
    
                    if ($productBrandIdxUpdate == "error") {
    
                        throw new Exception("error : productBrandIdxUpdate");
    
                    }

                }

                echo json_encode("success");

            } else if ($_POST["act"] == "brandList") {

                // 상품 브랜드 조회
                $productBrandListSelect = $boardCommonService -> boardListSelect("");

                echo json_encode($productBrandListSelect);

            } else if ($_POST["act"] == "list") {



            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    } else if ($page == "product") { // 상품

        try{

            // 해당 테이블 있는지 체크
            $dbService -> tableCheck("product");

            if ($_POST["act"] == "category") {

                // 카테고리 조회
                $categorySelect = $categoryService -> categoryListSelect();

                echo json_encode($categorySelect);

            } else if ($_POST["act"] == "reg") {

                // 상품코드 생성
                $productCode = "P".date("ymd").GenerateString(6);

                // 가격 콤마 제거
                $price = str_replace(",", "", $_POST['price']);

                // 상세설명
                $replacePcDesc = str_replace("/tempUpload/", "/upload/", $_POST['pcDescription']);

                // 에디터 이미지 옮기기
                $editorService -> editorImagesMove($_POST['pcDescription']);

                $pcDescription = mysqli_real_escape_string($conn, $replacePcDesc);

                $replaceMobileDesc = str_replace("/tempUpload/", "/upload/", $_POST['mobileDescription']);

                // 에디터 이미지 옮기기
                $editorService -> editorImagesMove($_POST['mobileDescription']);

                // 에디터 임시 파일저장소 지우기
                $editorService -> editorImagesDelete();

                $mobileDescription = mysqli_real_escape_string($conn, $replaceMobileDesc);

                // 재고수량
                if ($_POST['stock'] == "") {

                    $stock = -1;

                } else {

                    $stock = $_POST['stock'];

                }

                // 상품 등록
                $productInsert = $productService -> productInsert($productCode, $price, $stock, $pcDescription, $mobileDescription);

                $productIdx = mysqli_insert_id($conn); // insert될때 pk값

                if ($productInsert == "success") {

                    // 해당 테이블 있는지 체크
                    $dbService -> tableCheck("productCategory");

                    $categoryIdx1 = $_POST['categoryIdx1'] == "" ? 0 : (int) $_POST['categoryIdx1'];
                    $categoryIdx2 = $_POST['categoryIdx2'] == "" ? 0 : (int) $_POST['categoryIdx2'];
                    $categoryIdx3 = $_POST['categoryIdx3'] == "" ? 0 : (int) $_POST['categoryIdx3'];

                    // 상품 메인카테고리 등록
                    $productCategoryInsert = $productService -> productCategoryInsert("main", "", "", "", $categoryIdx1, $categoryIdx2, $categoryIdx3, $productIdx);

                    if ($productCategoryInsert == "error") {

                        throw new Exception("error : productMainCategoryInsert");

                    }

                    // 상품 추가카테고리 등록
                    if ($_POST['subCategoryIdx1'][0] !== "") {

                        for ($btc=0; $btc < COUNT($_POST['subCategoryIdx1']); $btc++) {
    
                            // 상품 추가카테고리 등록
                            $productSubCategoryInsert = $productService -> productCategoryInsert("sub", "", "", "", $_POST['subCategoryIdx1'][$btc], $_POST['subCategoryIdx2'][$btc], $_POST['subCategoryIdx3'][$btc], $productIdx);
    
                            if ($productSubCategoryInsert == "error") {
    
                                throw new Exception("error : productSubCategoryInsert");
    
                            }
    
                        }

                    }

                    if ($_POST['optionName'][0] !== "") {

                        // 해당 테이블 있는지 체크
                        $dbService -> tableCheck("productOption");

                        // 상품 옵션 등록
                        for ($on=0; $on < COUNT($_POST['optionName']); $on++) {

                            // 옵션 가격 콤마 제거
                            $optionPrice = str_replace(",", "", $_POST['optionPrice'][$on]);

                            // 옵션 재고수량 콤마 제거
                            if ($_POST['optionStock'][$on] == 00) {

                                $optionStock = -1;
            
                            } else {
            
                                $optionStock = str_replace(",", "", $_POST['optionStock'][$on]);
            
                            }

                            // 상품 옵션 등록
                            $productOptionInsert = $productService -> productOptionInsert($productIdx, $_POST['optionName'][$on], $optionPrice, $optionStock);

                            if ($productOptionInsert == "error") {

                                throw new Exception("error : productOptionInsert");

                            }

                        }

                    }

                    for ($btc=0; $btc < COUNT($_POST['boardTempIdx']); $btc++) {

                        // 첨부파일 idx 업데이트

                        $boardTempIdx = $_POST['boardTempIdx'][$btc];

                        $productIdxUpdate = $boardCommonService -> boardIdxUpdate($productIdx, $boardTempIdx);
        
                        if ($productIdxUpdate == "error") {
        
                            throw new Exception("error : productIdxUpdate");
        
                        }

                    }

                    $description = "상품 등록 : ".json_encode($_POST);
                    $tableIdx = $productCategoryIdx; // insert될때 pk값
                    $updateTable = "product";
                    $act = "insert";
        
                    $adminLog = $adminLogSerice -> insertLog($description, $tableIdx, $updateTable, $act);

                } else {

                    throw new Exception("error : productInsert");

                }

                echo json_encode("success");

            } else if ($_POST["act"] == "modify") {

                if ($_POST['boardTempIdx']) { // 새 첨부파일이 있을때

                    for ($btc=0; $btc < COUNT($_POST['boardTempIdx']); $btc++) {
    
                        $boardTempIdx = $_POST['boardTempIdx'][$btc];
    
                        // 첨부파일 idx 업데이트
                        $boardIdxUpdate = $boardCommonService -> boardIdxUpdate($_POST['idx'], $boardTempIdx);
    
                        if ($boardIdxUpdate == "error") {
    
                            throw new Exception("error : boardIdxUpdate");
    
                        }
    
                    }

                }

                // 상세설명
                $replacePcDesc = str_replace("/tempUpload/", "/upload/", $_POST['pcDescription']);

                // 에디터 이미지 옮기기
                $editorService -> editorImagesMove($_POST['pcDescription']);

                $pcDescription = mysqli_real_escape_string($conn, $replacePcDesc);

                $replaceMobileDesc = str_replace("/tempUpload/", "/upload/", $_POST['mobileDescription']);

                // 에디터 이미지 옮기기
                $editorService -> editorImagesMove($_POST['mobileDescription']);

                // 에디터 임시 파일저장소 지우기
                $editorService -> editorImagesDelete();

                $mobileDescription = mysqli_real_escape_string($conn, $replaceMobileDesc);

                // 가격 콤마 제거
                $price = str_replace(",", "", $_POST['price']);

                // 재고수량
                if ($_POST['stock'] == 00) {

                    $stock = -1;

                } else {

                    $stock = $_POST['stock'];

                }

                // 상품 수정
                $productUpdate = $productService -> productUpdate($price, $stock, $pcDescription, $mobileDescription);

                if ($productUpdate == "success") {

                    $productCategorySelect = $productService -> productCategorySelect($_POST['idx']);

                    $mainCategoryIdx = "";
                    $productMainCategory = array();
                    $productSubCategorySort1 = array();
                    $productSubCategorySort2 = array();
                    $productSubCategorySort3 = array();

                    for ($pcc=0; $pcc < COUNT($productCategorySelect); $pcc++) {

                        if ($productCategorySelect[$pcc]['type'] == "main") {

                            array_push($productMainCategory, (int) $productCategorySelect[$pcc]['categoryIdx1']);
                            array_push($productMainCategory, (int) $productCategorySelect[$pcc]['categoryIdx2']);
                            array_push($productMainCategory, (int) $productCategorySelect[$pcc]['categoryIdx3']);

                            $mainSort1 = (int) $productCategorySelect[$pcc]['sort1'];
                            $mainSort2 = (int) $productCategorySelect[$pcc]['sort2'];
                            $mainSort3 = (int) $productCategorySelect[$pcc]['sort3'];

                            $mainCategoryIdx = (int) $productCategorySelect[$pcc]['idx'];

                        } else {

                            array_push($productSubCategory1, (int) $productCategorySelect[$pcc]['categoryIdx1']);
                            array_push($productSubCategory2, (int) $productCategorySelect[$pcc]['categoryIdx2']);
                            array_push($productSubCategory3, (int) $productCategorySelect[$pcc]['categoryIdx3']);

                            array_push($productSubCategorySort1, (int) $productCategorySelect[$pcc]['sort1']);
                            array_push($productSubCategorySort2, (int) $productCategorySelect[$pcc]['sort2']);
                            array_push($productSubCategorySort3, (int) $productCategorySelect[$pcc]['sort3']);

                        }

                    }

                    $categoryIdx1 = $_POST['categoryIdx1'] == "" ? 0 : (int) $_POST['categoryIdx1'];
                    $categoryIdx2 = $_POST['categoryIdx2'] == "" ? 0 : (int) $_POST['categoryIdx2'];
                    $categoryIdx3 = $_POST['categoryIdx3'] == "" ? 0 : (int) $_POST['categoryIdx3'];

                    // 상품 메인카테고리 수정시 삭제 및 재등록
                    if ($productMainCategory[0] !== $categoryIdx1 || $productMainCategory[1] !== $categoryIdx2 || $productMainCategory[2] !== $categoryIdx3) {

                        if ($productMainCategory[0] == $categoryIdx1) {

                            $sort1 = $mainSort1;

                        }

                        if ($productMainCategory[1] == $categoryIdx2) {

                            $sort2 = $mainSort2;

                        }

                        if ($productMainCategory[2] == $categoryIdx3) {

                            $sort3 = $mainSort3;

                        }

                        // 상품 메인카테고리 삭제
                        $productMainCategoryUpdateDelete = $productService -> productCategoryDelete($_POST['idx'], "main");

                        // 상품 메인카테고리 등록
                        $productMainCategoryUpdateInsert = $productService -> productCategoryInsert("main", $sort1, $sort2, $sort3, $categoryIdx1, $categoryIdx2, $categoryIdx3, $_POST['idx']);
    
                        if ($productMainCategoryUpdateInsert == "error" || $productMainCategoryUpdateDelete == "error") {
    
                            throw new Exception("error : productMainCategoryUpdateInsert");
    
                        }

                    }

                    // 상품 추가카테고리 수정시 삭제 및 재등록
                    if ($_POST['subCategoryIdx1'][0] !== "") { // 추가카테고리가 있을때

                        $productSubCategoryDelete = $productService -> productCategoryDelete($_POST['idx'], "sub");

                        if ($productSubCategoryDelete == "success") {

                            for ($btc=0; $btc < COUNT($_POST['subCategoryIdx1']); $btc++) {
        
                                if ($productSubCategory1[$btc] == $_POST['subCategoryIdx1']) {
        
                                    $sort1 = $productSubCategory1[$btc];
        
                                }
        
                                if ($productSubCategory2[$btc] == $_POST['subCategoryIdx2']) {
        
                                    $sort2 = $productSubCategory2[$btc];
        
                                }
        
                                if ($productSubCategory3[$btc] == $_POST['subCategoryIdx3']) {
        
                                    $sort3 = $productSubCategory3[$btc];
        
                                }

                                // 상품 추가카테고리 등록
                                $productSubCategoryInsert = $productService -> productCategoryInsert("sub", $sort1, $sort2, $sort3, $_POST['subCategoryIdx1'][$btc], $_POST['subCategoryIdx2'][$btc], $_POST['subCategoryIdx3'][$btc], $_POST['idx']);

                                if ($productSubCategoryInsert == "error") {

                                    throw new Exception("error : productSubCategoryInsert");

                                }

                            }

                        }

                    } else { // 추가카테고리가 없을경우 삭제

                        $productSubCategoryDelete = $productService -> productCategoryDelete($_POST['idx'], "sub");

                    }

                    // 상품 옵션 삭제 및 등록
                    $productOptionDelete = $productService -> productOptionDelete($_POST['idx']);

                    if ($productOptionDelete == "success") {

                        if ($_POST['optionName'][0] !== "") {

                            // 상품 옵션 등록
                            for ($on=0; $on < COUNT($_POST['optionName']); $on++) {

                                // 옵션 가격 콤마 제거
                                $optionPrice = str_replace(",", "", $_POST['optionPrice'][$on]);

                                // 옵션 재고수량 콤마 제거
                                if ($_POST['optionStock'][$on] == 00) {

                                    $optionStock = -1;
                
                                } else {
                
                                    $optionStock = str_replace(",", "", $_POST['optionStock'][$on]);
                
                                }

                                if ($_POST['optionName'][$on] !== "" || $_POST['optionPrice'][$on] !== "" || $_POST['optionStock'][$on] !== "") {

                                    // 상품 옵션 등록
                                    $productOptionInsert = $productService -> productOptionInsert($_POST['idx'], $_POST['optionName'][$on], $optionPrice, $optionStock);

                                    if ($productOptionInsert == "error") {
    
                                        throw new Exception("error : productOptionUpdateInsert");
    
                                    }

                                }

                            }

                        }

                    }

                    for ($btc=0; $btc < COUNT($_POST['boardTempIdx']); $btc++) {

                        // 첨부파일 idx 업데이트
                        $boardTempIdx = $_POST['boardTempIdx'][$btc];

                        $productIdxUpdate = $boardCommonService -> boardIdxUpdate($productIdx, $boardTempIdx);
        
                        if ($productIdxUpdate == "error") {
        
                            throw new Exception("error : productIdxUpdate");
        
                        }

                    }

                    $description = "상품 수정 : ".json_encode($_POST);
                    $tableIdx = $_POST['idx'];
                    $updateTable = "product";
                    $act = "update";
        
                    $adminLog = $adminLogSerice -> insertLog($description, $tableIdx, $updateTable, $act);

                } else {

                    throw new Exception("error : productUpdate");

                }

                echo json_encode("success");

            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    } else if ($page == "productConfig") { // 상품공통설정

        try {

            $result = array("success");

            if ($_POST['act'] == "modifyView") {

                $productCofigSelect = $productService -> productCofigSelect();
                
                if (!$productCofigSelect) {

                    throw new Exception("error : productCofigSelect");
    
                }

                array_push($result, $productCofigSelect);

            } else if ($_POST['act'] == "modify") {
                
                // 무료배송 최소금액 콤마 제거
                $deliveryMinPrice = str_replace(",", "", $_POST['deliveryMinPrice']);
                
                // 배송비 콤마 제거
                $deliveryPrice = str_replace(",", "", $_POST['deliveryPrice']);

                $productCofigModify = $productService -> productCofigModify($deliveryMinPrice, $deliveryPrice);

            }

            echo json_encode($result);

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    } else if ($page == "productExcelConfig") { // 상품 엑셀
    
        try{

            // 해당 테이블 있는지 체크
            $dbService -> tableCheck("productExcelConfig");
            
            if ($_POST["act"] == "list") {

                // 상품 엑셀 설정 전체 리스트 조회
                $excelListSelect = $productService -> excelListSelect();

                echo json_encode($excelListSelect);

            } else if ($_POST["act"] == "excelItem") {

                // 상품 엑셀 설정 항목 전체 조회
                $excelItemSelect = $productService -> excelItemSelect();

                echo json_encode($excelItemSelect);

            } else if ($_POST["act"] == "reg") {

                // 상품 엑셀 설정 등록
                $productInsert = $productService -> excelItemInsert();

                if ($productInsert == "success") {

                    echo json_encode("success");

                } else {

                    throw new Exception("error : excelItemInsert");

                }

            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }
    
    }

?>