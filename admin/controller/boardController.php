<?php

    // ajax로 넘어오는 데이터 $page로 통일시키기

    if ($_POST['page']) {

        $page = $_POST['page'];

    }

    if ($_POST["act"]) { // 등록, 수정, 삭제일때 포함

        include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";
        include_once dirname(dirname(dirname(__FILE__)))."/admin/service/commonService.php";
        include_once dirname(dirname(dirname(__FILE__)))."/admin/service/productService.php";
        include_once dirname(dirname(dirname(__FILE__)))."/admin/service/couponService.php";
        include_once dirname(dirname(dirname(__FILE__)))."/public/controller/adminLogController.php";

    }

    include_once dirname(dirname(dirname(__FILE__)))."/admin/service/boardService.php";

    // 게시판
    try{

        $boardCommonService = new BoardCommonService();
        $attachFileService = new AttachFileService();
        $categoryService = new CategoryService();
        $productService = new ProductService();
        $couponService = new CouponService();
        $editorService = new EditorService();
        $dbService = new DbService();

        $uploadTablePage = array("siteCategory", "siteBanner", "productBrand", "product", "board", "config", "inquiry", "productQna"); // 업로드 테이블이 필요한 페이지명 배열

        $result = array("success");

        if ($_POST["act"] == "list") {

            // 해당 테이블 있는지 체크
            $dbService -> tableCheck($page);

            if (in_array($page, $uploadTablePage)) { // 업로드 테이블 있는지 체크

                // 해당 테이블 있는지 체크
                $dbService -> tableCheck($page."UploadFile");

            }

            // 게시판 리스트 카운트
            $boardListCount = $boardCommonService -> boardListCount();

            array_push($result, $boardListCount);

            // 리스트 조회
            $boardListSelect = $boardCommonService -> boardListSelect("list");

            array_push($result, $boardListSelect);

            // 게시판일 경우 제목 조회
            if ($_POST['boardIdx']) {

                // 게시판 제목 조회
                $boardTitleSelect = $categoryService -> categorySelect($_POST['boardIdx']);

                array_push($result, $boardTitleSelect[0]['title']);

            }

        } else if ($_POST["act"] == "productList") {

            // 해당 테이블 있는지 체크
            $dbService -> tableCheck($page);

            if (in_array($page, $uploadTablePage)) { // 업로드 테이블 있는지 체크

                // 해당 테이블 있는지 체크
                $dbService -> tableCheck($page."UploadFile");

            }

            // 게시판 리스트 카운트
            array_push($result, array("totalCount" => 0));

            array_push($result, "searchProduct");

        } else if ($_POST["act"] == "regView") {

            // 카테고리 조회
            $categorySelect = $categoryService -> categorySelect($_POST['categoryIdx']);

            array_push($result, $categorySelect);

            // 서브카테고리 조회
            $subCategorySelect = $categoryService -> subCategoryListSelect($_POST['categoryIdx']);

            array_push($result, $subCategorySelect);

        } else if ($_POST["act"] == "selectDel") {

            $idx = "";

            for ($di=0; $di < COUNT($_POST['idx']); $di++) {

                $idx .= $di + 1 == COUNT($_POST['idx']) ? "'".$_POST['idx'][$di]."'" : "'".$_POST['idx'][$di]."',";

                // 생성된 파일 삭제
                if ($page == "siteCategory") {
    
                    $boardFileDelete = unlink(dirname(dirname(dirname(__FILE__)))."/".$_POST['boardFile'][$di].".php");

                    if (!$boardFileDelete) {
    
                        throw new Exception("error : boardFileDelete : ".dirname(dirname(dirname(__FILE__)))."/".$_POST['boardFile'][$di].".php");
            
                    }
    
                }

                // 첨부파일 삭제
                if (in_array($page, $uploadTablePage)) { // 업로드 테이블 있는지 체크
    
                    // 해당 테이블 있는지 체크
                    $uploadTable = $dbService -> tableCheck($page."UploadFile");
    
                    if ($uploadTable > 0) { // 테이블이 있을때
    
                        // 등록된 첨부파일 조회
                        $attachFileInfo = $attachFileService -> attachFileSelect($page, $_POST['idx'][$di], "ASC");
                
                        for ($afc=0; $afc < COUNT($attachFileInfo); $afc++) {

                            $fileDir = "../resources/upload/".$attachFileInfo[$afc]['fileName'];
            
                            unlink($fileDir); // 파일 삭제
    
                            $attachFileDelete = $attachFileService -> attachFileDelete($page, $attachFileInfo[$afc]['idx']);
        
                            if (!$attachFileDelete) {
            
                                throw new Exception("error : attachFileDelete");
                    
                            }
            
                        }
    
                    }
    
                }

            }
                
            if ($page == "product") {

                // 상품 카테고리 순서 조회
                $productCategorySelect = $productService -> productCategorySelect($idx);

                // 상품 카테고리 삭제
                $productCategoryDelete = $productService -> productCategoryDelete($idx);

                if ($productCategoryDelete == "error") {

                    throw new Exception("error : productCategoryDelete");
        
                }

                // 카테고리별 최소값 배열에 넣기
                $category = array();

                for ($pc=0; $pc < COUNT($productCategorySelect); $pc++) {

                    // 카테고리1 배열
                    $category1Info = array(

                        "categoryIdx1" => $productCategorySelect[$pc]['categoryIdx1'],
                        "sort1" => $productCategorySelect[$pc]['sort1']

                    );

                    // 배열에 있는지 확인 있으면 인덱스 찾기
                    $isArray = in_array($productCategorySelect[$pc]['categoryIdx1'], array_column($category, "categoryIdx1"));

                    if($isArray == false) { // 같은 카테고리가 없을땐 배열에 추가

                        array_push($category, $category1Info);

                    } else { // 카테고리가 같을때 sort 확인

                        if ($category[$arrayIndex]['sort1'] > $productCategorySelect[$pc]['sort1']) {

                            $category[$arrayIndex]['sort1'] = $productCategorySelect[$pc]['sort1'];

                        }
                        
                    }

                    // 카테고리2 배열
                    $category2Info = array(

                        "categoryIdx2" => $productCategorySelect[$pc]['categoryIdx2'],
                        "sort2" => $productCategorySelect[$pc]['sort2']

                    );

                    // 배열에 있는지 확인 있으면 인덱스 찾기
                    $isArray = in_array($productCategorySelect[$pc]['categoryIdx2'], array_column($category, "categoryIdx2"));

                    if($isArray == false && $productCategorySelect[$pc]['categoryIdx2'] !== "0") { // 같은 카테고리가 없을땐 배열에 추가

                        array_push($category, $category2Info);

                    } else { // 카테고리가 같을때 sort 확인

                        if ($category[$arrayIndex]['sort2'] > $productCategorySelect[$pc]['sort2']) {

                            $category[$arrayIndex]['sort2'] = $productCategorySelect[$pc]['sort2'];

                        }
                        
                    }

                    // 카테고리3 배열
                    $category3Info = array(

                        "categoryIdx3" => $productCategorySelect[$pc]['categoryIdx3'],
                        "sort3" => $productCategorySelect[$pc]['sort3']

                    );

                    // 배열에 있는지 확인 있으면 인덱스 찾기
                    $isArray = in_array($productCategorySelect[$pc]['categoryIdx3'], array_column($category, "categoryIdx3"));

                    if($isArray == false && $productCategorySelect[$pc]['categoryIdx3'] !== "0") { // 같은 카테고리가 없을땐 배열에 추가

                        array_push($category, $category3Info);

                    } else { // 카테고리가 같을때 sort 확인

                        if ($category[$arrayIndex]['sort3'] > $productCategorySelect[$pc]['sort3']) {

                            $category[$arrayIndex]['sort3'] = $productCategorySelect[$pc]['sort3'];

                        }
                        
                    }
                    
                }

                for ($cc=0; $cc < COUNT($category); $cc++) {

                    if ($category[$cc]['categoryIdx1']) {
                    
                        // 게시판 리스트 조회
                        $changeIdx = $boardCommonService -> boardListSelect("selectDel", $category[$cc]['sort1'], $category[$cc]['categoryIdx1'], "category1");
            
                        $sort = $category[$cc]['sort1'];
            
                        for ($cs=0; $cs < COUNT($changeIdx); $cs++) {
            
                            // 카테고리1 순서 재배치
                            $category1NumChange = $boardCommonService -> boardNumChange($sort, $changeIdx[$cs]['idx'], "category1");
            
                            $sort++;
            
                            if ($category1NumChange == "error") {
                    
                                throw new Exception("error : category1NumChange");
                    
                            }
            
                        }
    
                    }
    
                    if ($category[$cc]['categoryIdx2']) {
                    
                        // 게시판 리스트 조회
                        $changeIdx = $boardCommonService -> boardListSelect("selectDel", $category[$cc]['sort2'], $category[$cc]['categoryIdx2'], "category2");
            
                        $sort = $category[$cc]['sort2'];
            
                        for ($cs=0; $cs < COUNT($changeIdx); $cs++) {
            
                            // 카테고리2 순서 재배치
                            $category2NumChange = $boardCommonService -> boardNumChange($sort, $changeIdx[$cs]['idx'], "category2");
            
                            $sort++;
            
                            if ($category2NumChange == "error") {
                    
                                throw new Exception("error : category2NumChange");
                    
                            }
            
                        }
    
                    }
    
                    if ($category[$cc]['categoryIdx3']) {
                    
                        // 게시판 리스트 조회
                        $changeIdx = $boardCommonService -> boardListSelect("selectDel", $category[$cc]['sort3'], $category[$cc]['categoryIdx3'], "category3");
            
                        $sort = $category[$cc]['sort3'];
            
                        for ($cs=0; $cs < COUNT($changeIdx); $cs++) {
            
                            // 카테고리3 순서 재배치
                            $category2NumChange = $boardCommonService -> boardNumChange($sort, $changeIdx[$cs]['idx'], "category3");
            
                            $sort++;
            
                            if ($category2NumChange == "error") {
                    
                                throw new Exception("error : category2NumChange");
                    
                            }
            
                        }
    
                    }

                }
                
                // 상품 삭제
                $productDelete = $productService -> productDelete($idx);

                if ($productDelete == "error") {

                    throw new Exception("error : productDelete");
        
                }
                
                // 상품 옵션 삭제
                $productOptionDelete = $productService -> productOptionDelete($idx);

                if ($productOptionDelete == "error") {

                    throw new Exception("error : productOptionDelete");
        
                }

            } else if ($page == "coupon") {

                // 쿠폰 삭제
                $couponDelete = $couponService -> couponDelete($idx);
    
                if (!$couponDelete) {
        
                    throw new Exception("error : boardListDelete");
        
                }

            } else {

                // 게시판 순서 조회
                $boardNumCheck = $boardCommonService -> boardNumCheck($idx);
    
                // 게시판 리스트 선택 삭제
                $boardListDelete = $boardCommonService -> boardListDelete($idx);
    
                if (!$boardListDelete) {
        
                    throw new Exception("error : boardListDelete");
        
                }
                
                // 게시판 리스트 조회
                $changeIdx = $boardCommonService -> boardListSelect("selectDel", $boardNumCheck['minSort']);
    
                $sort = $boardNumCheck['minSort'];
    
                for ($cs=0; $cs < COUNT($changeIdx); $cs++) {
    
                    // 게시판 순서 재배치
                    $boardNumChange = $boardCommonService -> boardNumChange($sort, $changeIdx[$cs]['idx']);
    
                    $sort++;
    
                    if (!$boardNumChange) {
            
                        throw new Exception("error : boardNumChange");
            
                    }
    
                }

            }

            // 메인 카테고리 삭제시 하위 카테고리 전체 삭제
            if ($page == "siteCategory") {

                // 서브 카테고리 투뎁스 조회
                $subCategoryIdxSelect = $categoryService -> subCategoryIdxSelect($idx);

                for ($scc=0; $scc < COUNT($subCategoryIdxSelect); $scc++) {

                    $scc + 1 == COUNT($subCategoryIdxSelect["idx"]) ? $idx .= "'".$subCategoryIdxSelect[$scc]["idx"]."'" : $idx .= ", '".$subCategoryIdxSelect[$scc]["idx"]."'";
    
                }

                $subCategoryAllDelete = $categoryService -> subCategoryAllDelete($idx);

                if (!$subCategoryAllDelete) {
        
                    throw new Exception("error : subCategoryAllDelete");
        
                }

                for ($di=0; $di < COUNT($_POST["idx"]); $di++) {

                    $description = "사이트 카테고리 삭제 (카테고리명 : ".$_POST["categoryTitle"][$di].")";
                    $tableIdx = $_POST["idx"][$di];
                    $updateTable = "siteCategory";
                    $act = "delete";
        
                    $adminLog = $adminLogSerice -> insertLog($description, $tableIdx, $updateTable, $act);
    
                }
    
                if (!$adminLog) {
        
                    throw new Exception("error : siteCategoryDeleteLog");
        
                }

            }

        } else if ($_POST["act"] == "sortChange") {
            
            if ($_POST["sortType"] == "up") {

                // 현재 게시글 sort + 1
                $sortNum = $_POST['sortNum'] + 1;

                // 다음글 정보 조회
                $nextBoardInfo = $boardCommonService -> boardListSelect("sortChange", $sortNum, $_POST['categoryIdx1'], $_POST['categoryIdx2'], $_POST['categoryIdx3']);

                if (!$nextBoardInfo[0]['idx']) {

                    echo json_encode("last");

                    exit;

                }

                if ($_POST['categoryIdx3']) {

                    $etc = "category3";

                } else if ($_POST['categoryIdx2']) {

                    $etc = "category2";

                } else if ($_POST['categoryIdx1']) {

                    $etc = "category1";

                }

                // 게시판 순서 재배치 (현재글)
                $boardNumChange = $boardCommonService -> boardNumChange($sortNum, $_POST['sortIdx'], $etc);

                if (!$boardNumChange) {
        
                    throw new Exception("error : boardNumChange");
        
                }

                // 게시판 순서 재배치 (다음글)
                $boardNextNumChange = $boardCommonService -> boardNumChange($_POST['sortNum'], $nextBoardInfo[0]['idx'], $etc);

                if (!$boardNextNumChange) {
        
                    throw new Exception("error : boardNextNumChange");
        
                }

            } else if ($_POST["sortType"] == "down") {

                // 현재 게시글 sort - 1
                $sortNum = $_POST['sortNum'] - 1;

                if($sortNum == 0){

                    echo json_encode("first");
    
                    exit;

                }else{

                    // 이전글 idx 조회
                    $beforeBoardInfo = $boardCommonService -> boardListSelect("sortChange", $sortNum, $_POST['categoryIdx1'], $_POST['categoryIdx2'], $_POST['categoryIdx3']);
    
                    if ($_POST['categoryIdx3']) {
    
                        $etc = "category3";
    
                    } else if ($_POST['categoryIdx2']) {
    
                        $etc = "category2";
    
                    } else if ($_POST['categoryIdx1']) {
    
                        $etc = "category1";
    
                    }
    
                    // 게시판 순서 재배치 (현재글)
                    $boardNumChange = $boardCommonService -> boardNumChange($sortNum, $_POST['sortIdx'], $etc);
    
                    if ($boardNumChange == "error") {
            
                        throw new Exception("error : boardNumChange");
            
                    }
    
                    // 게시판 순서 재배치 (이전글)
                    $boardBeforeNumChange = $boardCommonService -> boardNumChange($_POST['sortNum'], $beforeBoardInfo[0]['idx'], $etc);
    
                    if (!$boardBeforeNumChange) {
            
                        throw new Exception("error : boardBeforeNumChange");
            
                    }

                }

            }

            if ($page == "siteSubCategory") {

                // 게시판 리스트 카운트
                $boardListCount = $boardCommonService -> boardListCount();
    
                array_push($result, $boardListCount);

                $boardListSelect = $boardCommonService -> boardListSelect("subCategoryList");

            } else if ($_POST['page'] == "product") {

                // 게시판 리스트 카운트
                $boardListCount = $boardCommonService -> boardListCount("productSort");
    
                array_push($result, $boardListCount);
            
                $boardListSelect = $boardCommonService -> boardListSelect("productSort");

            } else {

                // 게시판 리스트 카운트
                $boardListCount = $boardCommonService -> boardListCount();
    
                array_push($result, $boardListCount);

                $boardListSelect = $boardCommonService -> boardListSelect("list");

            }

            array_push($result, $boardListSelect);

        } else if ($_POST["act"] == "showYn") {

            // 게시판 노출 유무
            $boardUpdate = $boardCommonService -> boardUpdate();

            if (!$boardUpdate) {
    
                throw new Exception("error : boardUpdate");
    
            }

        } else if ($_POST["act"] == "search") {

            // 게시판 리스트 카운트
            $boardListCount = $boardCommonService -> boardListCount("search");

            array_push($result, $boardListCount);

            // 리스트 조회
            $boardListSelect = $boardCommonService -> boardListSelect("search");

            array_push($result, $boardListSelect);

        } else if ($_POST["act"] == "reg") {

            // 피씨 상세설명
            $replacePcDesc = str_replace("/tempUpload/", "/upload/", $_POST['pcDescription']);

            // 에디터 이미지 옮기기
            $editorService -> editorImagesMove($_POST['pcDescription']);

            $pcDescription = mysqli_real_escape_string($conn, $replacePcDesc);

            // 모바일 상세설명
            $replaceMobileDesc = str_replace("/tempUpload/", "/upload/", $_POST['mobileDescription']);

            // 에디터 이미지 옮기기
            $editorService -> editorImagesMove($_POST['mobileDescription']);

            // 에디터 임시 파일저장소 지우기
            $editorService -> editorImagesDelete();

            $mobileDescription = mysqli_real_escape_string($conn, $replaceMobileDesc);

            // 서브카테고리가 없을때
            if ($_POST['subCategoryIdx'] !== "" || !$_POST['subCategoryIdx']) {

                $_POST['subCategoryIdx'] = 0;
                
            }

            if ($_POST['showYn'] == "" || !$_POST['showYn']) {

                $_POST['showYn'] = "Y";
                
            }

            // 게시판 등록
            $boardInsert = $boardCommonService -> boardInsert($pcDescription, $mobileDescription);

            $boardIdx = mysqli_insert_id($conn); // insert될때 pk값

            if ($boardInsert == "success") {

                for ($btc=0; $btc < COUNT($_POST['boardTempIdx']); $btc++) {

                    $boardTempIdx = $_POST['boardTempIdx'][$btc];

                    // 첨부파일 idx 업데이트
                    $boardIdxUpdate = $boardCommonService -> boardIdxUpdate($boardIdx, $boardTempIdx);

                    if ($boardIdxUpdate == "error") {

                        throw new Exception("error : boardIdxUpdate");

                    }

                }

            } else {

                throw new Exception("error : boardInsert");

            }

        } else if ($_POST["act"] == "modifyView") {

            // 게시판 첨부파일 조회
            $boardAttachSelect = $boardCommonService -> boardAttachSelect();

            array_push($result, $boardAttachSelect);

            // 게시판 상세조회
            $boardSelect = $boardCommonService -> boardSelect();

            array_push($result, $boardSelect);

            // 카테고리 조회
            $categorySelect = $categoryService -> categorySelect($_POST['categoryIdx']);

            array_push($result, $categorySelect);

            // 서브카테고리 조회
            $subCategorySelect = $categoryService -> subCategoryListSelect($_POST['categoryIdx']);

            array_push($result, $subCategorySelect);

            if ($_POST['page'] == "product") {

                // 상품 옵션 조회
                $productOptionSelect = $productService -> productOptionSelect($boardSelect[0]['idx']);

                if ($productOptionSelect == "error") {

                    array_push($result, "none");

                } else {

                    array_push($result, $productOptionSelect);

                }

            }

        } else if ($_POST["act"] == "modify") {

            // 피씨 상세설명
            $replacePcDesc = str_replace("/tempUpload/", "/upload/", $_POST['pcDescription']);

            // 에디터 이미지 옮기기
            $editorService -> editorImagesMove($_POST['pcDescription']);

            $pcDescription = mysqli_real_escape_string($conn, $replacePcDesc);

            // 모바일 상세설명
            $replaceMobileDesc = str_replace("/tempUpload/", "/upload/", $_POST['mobileDescription']);

            // 에디터 이미지 옮기기
            $editorService -> editorImagesMove($_POST['mobileDescription']);

            // 에디터 임시 파일저장소 지우기
            $editorService -> editorImagesDelete();

            $mobileDescription = mysqli_real_escape_string($conn, $replaceMobileDesc);

            // 서브카테고리가 없을때
            if ($_POST['subCategoryIdx'] == "" || !$_POST['subCategoryIdx']) {

                $_POST['subCategoryIdx'] = 0;
                
            }

            if ($_POST['showYn'] == "" || !$_POST['showYn']) {

                $_POST['showYn'] = "Y";
                
            }

            // 게시판 수정
            $boardUpdate = $boardCommonService -> boardUpdate($pcDescription, $mobileDescription);

            if ($boardUpdate == "success") {

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

            } else {

                throw new Exception("error : boardUpdate");

            }

            $description = "게시판 수정 : ".$_POST['title'];
            $tableIdx = $_POST['idx']; // insert될때 pk값
            $updateTable = $_POST['page'];
            $act = "update";

            $adminLog = $adminLogSerice -> insertLog($description, $tableIdx, $updateTable, $act);

            if (!$adminLog) {
    
                throw new Exception("error : boardUpdateLog");
    
            }

        }

    } catch (Exception $errorMsg) {

        echo $errorMsg;

        exit;

    }

    echo json_encode($result);

?>