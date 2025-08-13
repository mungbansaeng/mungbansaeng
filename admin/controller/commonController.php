<?php

    // ajax로 넘어오는 데이터 $page로 통일시키기

    if ($_POST['page']) {

        $page = $_POST['page'];

    }

    if ($_POST["act"]) { // 등록, 수정, 삭제일때 포함

        include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";

    }

    include_once dirname(dirname(dirname(__FILE__)))."/admin/service/commonService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/admin/service/boardService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/public/controller/adminLogController.php";

    $boardCommonService = new BoardCommonService();
    $configSerice = new ConfigService();

    $uploadTablePage = array("siteCategory"); // 업로드 테이블이 필요한 페이지명 배열

    // 메타태그
    try {

        $metaSerice = new MetaService();

        if ($_POST["act"] == "modify" && $page == "meta") { // 수정은 meta 페이지에서만

            // 메타태그 수정
            $metaUpdate = $metaSerice -> metaUpdate();

            if ($metaUpdate == "error") {

                throw new Exception("error : metaUpdate");

            } else {

                echo "success";

            }

        } else {

            // 메타태그 조회
            $meta = $metaSerice -> metaSelect();

            if (!$meta) {

                throw new Exception("error : metaSelect");

            }

        }

    } catch (Exception $errorMsg) {

        echo $errorMsg;

        exit;

    }

    // config
    try {

        if ($_POST["act"] == "modify" && ($_POST['page'] == "ip" || $_POST['page'] == "homepageConfig")) {

            $private = mysqli_real_escape_string($conn, $_POST['private']);
            $tnc = mysqli_real_escape_string($conn, $_POST['tnc']);
            $thirdParty = mysqli_real_escape_string($conn, $_POST['thirdParty']);
            $privateUse = mysqli_real_escape_string($conn, $_POST['privateUse']);

            // config 수정
            $configUpdate = $configSerice -> configUpdate($private, $tnc, $thirdParty, $privateUse);

            if ($configUpdate == "error") {

                throw new Exception("error : configUpdate");

            } else {

                echo "success";

            }

        } else {

            // config 조회
            $config = $configSerice -> configSelect($page);

            if (!$config) {

                throw new Exception("error : configSelect");

            }

            $connectIp = explode("◈", $config['adminIp']);

            // 관리자 접속 체크

            if (in_array($userIp, $connectIp) && $_SESSION['admin_id'] && $_SERVER['PHP_SELF'] == "/admin/index.php") {

                // 접속 가능 ip이고 세션이 있으면 로그인페이지 통과
                header("Location: /admin/view/main/dashboard");
        
            } else if (in_array($userIp, $connectIp) && !$_SESSION['admin_id']) {

                // 접속 가능 ip이고 세션이 없으면 로그인페이지로 이동
                if ($_SERVER['PHP_SELF'] == "/admin/index.php") {

                    include_once dirname(dirname(dirname(__FILE__)))."/admin/view/common/login.php";

                }else{

                    header("Location: /admin");

                }
        
            } else if (!in_array($userIp, $connectIp)) {
        
                // 접속 가능 ip가 아닐때 에러페이지로 이동
                header("Location: ".$_SERVER['SERVER_NAME']."?error=404");
        
            }

        }

    } catch (Exception $errorMsg) {

        echo $errorMsg;

        exit;

    }

    // 홈페이지 설정
    // if ($page == "homepageConfig") {

    //     try {
    
    //         if ($_POST["act"] == "reg") {
    
    //             // config 수정
    //             $homepageConfigUpdate = $configSerice -> configUpdate();
    
    //             if ($homepageConfigUpdate == "error") {
    
    //                 throw new Exception("error : homepageConfigUpdate");
    
    //             } else {
    
    //                 echo "success";
    
    //             }
    
    //         } else {
    
    //             // 로고 조회
    //             // $config = $configSerice -> configSelect();
    
    //             // if (!$config) {
    
    //             //     throw new Exception("error : configSelect");
    
    //             // }
    
    //         }
    
    //     } catch (Exception $errorMsg) {
    
    //         echo $errorMsg;
    
    //         exit;
    
    //     }

    // }

    // 접속통계
    if ($page == "statistics") {

        try {

            header('Content-Type: json; charset=UTF-8');

            $statisticsSerice = new statisticsService();

            $listArray = array();

            if ($_POST["act"] == "monthstatisticsCount") {

                $monthstatisticsCount = $statisticsSerice -> monthstatisticsCount();

                if (!$monthstatisticsCount) {

                    throw new Exception("error : monthstatisticsCount");

                } else {

                    $result = array("success");

                    array_push($result, $monthstatisticsCount);

                    echo json_encode($result);

                }

            } else if ($_POST["act"] == "counterInfo") {

                // 게시판 리스트 카운트
                $statisticsCount = $statisticsSerice -> statisticsCount();
    
                array_push($listArray, $statisticsCount);

                // 리스트 조회
                $detailStatisticsSelect = $statisticsSerice -> detailStatisticsSelect();

                if ($statisticsCount["totalCount"] == 0) {

                    echo json_encode($listArray);

                } else if (!$detailStatisticsSelect) {

                    throw new Exception("error : detailStatisticsSelect");

                } else {

                    array_push($listArray, $detailStatisticsSelect);

                    echo json_encode($listArray);

                }

            } else if ($_POST["act"] == "counterLog") {

                // 게시판 리스트 카운트
                $statisticsCount = $statisticsSerice -> statisticsCount();
    
                array_push($listArray, $statisticsCount);

                // 리스트 조회
                $periodStatisticsSelect = $statisticsSerice -> periodStatisticsSelect();

                if ($statisticsCount["totalCount"] == 0) {

                    echo json_encode($listArray);

                } else if (!$periodStatisticsSelect) {

                    throw new Exception("error : periodStatisticsSelect");

                } else {

                    array_push($listArray, $periodStatisticsSelect);

                    echo json_encode($listArray);

                }

            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    }

    // 카테고리
    if ($page == "siteCategory" || $page == "siteSubCategory") {

        try {
                
            $dbService = new DbService();
            $categoryService = new CategoryService();

            $result = array("success");

            if ($_POST["act"] == "reg") {

                // 해당 테이블 있는지 체크
                $dbService -> tableCheck("siteCategory");

                // 카테고리 등록
                $categoryInsert = $categoryService -> categoryInsert();

                $categoryIdx = mysqli_insert_id($conn); // insert될때 pk값

                if ($categoryInsert == "success") {
    
                    for ($btc=0; $btc < COUNT($_POST['boardTempIdx']); $btc++) {
    
                        $boardTempIdx = $_POST['boardTempIdx'][$btc];
    
                        // 첨부파일 idx 업데이트
                        $categoryIdxUpdate = $boardCommonService -> boardIdxUpdate($categoryIdx, $boardTempIdx);
    
                        if ($categoryIdxUpdate == "error") {
    
                            throw new Exception("error : categoryIdxUpdate");
    
                        }
    
                    }
    
                } else {
    
                    throw new Exception("error : categoryInsert");
    
                }

                // twodepth가 있을때
                if (COUNT($_POST['twoDepth']) > 0) {

                    // 해당 테이블 있는지 체크
                    $dbService -> tableCheck("siteSubCategory");

                    for ($tdc=0; $tdc < COUNT($_POST['twoDepth']); $tdc++) {

                        $subCategoryInsert = $categoryService -> subCategoryInsert($categoryIdx, $_POST['twoDepth'][$tdc], 2);

                        if ($subCategoryInsert == "error") {

                            echo json_encode("error");
        
                            throw new Exception("error : subCategoryInsert");
        
                        }

                    }

                }

                if ($categoryInsert == "error") {

                    echo json_encode("error");

                    throw new Exception("error : siteCategoryInsert");

                } else {

                    // 카테고리 파일 생성
                    $categoryFileCreate = $categoryService -> categoryCreate();

                    if (!$categoryFileCreate) {
    
                        throw new Exception("error : categoryFileCreate");
            
                    }

                    $description = "사이트 카테고리 등록 : ".$_POST['title'];
                    $tableIdx = $categoryIdx; // insert될때 pk값
                    $updateTable = "siteCategory";
                    $act = "insert";

                    $adminLog = $adminLogSerice -> insertLog($description, $tableIdx, $updateTable, $act);

                    if (!$adminLog) {
            
                        throw new Exception("error : siteCategoryInsertLog");
            
                    }

                    echo json_encode("success");

                }

            } else if ($_POST["act"] == "modifyView") {

                if ($_POST['depth'] == 1) {

                    // 카테고리 조회
                    $categorySelect = $categoryService -> categorySelect($_POST['idx']);

                    array_push($result, $categorySelect);

                } else {

                    // 서브카테고리 조회
                    $categorySelect = $categoryService -> subCategorySelect();

                    array_push($result, $categorySelect);

                }

                // 서브카테고리 리스트 조회
                $subCategoryListSelect = $categoryService -> subCategoryListSelect($_POST['idx']);

                array_push($result, $subCategoryListSelect);

                echo json_encode($result);

            } else if ($_POST["act"] == "modify") {

                if ($_POST['depth'] == 1) {

                    // 파일명 체크 다르면 삭제 후 재생성
                    $categorySelect = $categoryService -> categorySelect($_POST['idx']);

                    if ($categorySelect[0]['file'] !== $_POST['file'] || $categorySelect[0]['depthType'] !== $_POST['depthType']) {

                        // 기존 파일 삭제
                        $boardFileDelete = unlink(dirname(dirname(dirname(__FILE__)))."/".$categorySelect[0]['file'].".php");

                        if (!$boardFileDelete) {
        
                            throw new Exception("error : boardFileDelete");
                
                        }
                        
                        // 새로운 카테고리 파일 생성
                        $categoryFileCreate = $categoryService -> categoryCreate();

                        if (!$categoryFileCreate) {
        
                            throw new Exception("error : categoryFileCreate");
                
                        }

                    }

                    // 카테고리 수정
                    $categoryUpdate = $categoryService -> categoryUpdate();

                    if ($categoryUpdate == "success") {

                        if ($_POST['boardTempIdx']) { // 새 첨부파일이 있을때
        
                            for ($btc=0; $btc < COUNT($_POST['boardTempIdx']); $btc++) {
            
                                $boardTempIdx = $_POST['boardTempIdx'][$btc];
            
                                // 첨부파일 idx 업데이트
                                $categoryIdxUpdate = $boardCommonService -> boardIdxUpdate($_POST['idx'], $boardTempIdx);
            
                                if ($categoryIdxUpdate == "error") {
            
                                    throw new Exception("error : categoryIdxUpdate");
            
                                }
            
                            }
        
                        }
        
                    } else {
        
                        throw new Exception("error : categoryUpdate");
        
                    }

                } else {

                    $idx = $_POST['idx'];
                    $title = $_POST['title'];

                    // 서브 카테고리 수정
                    $subCategoryUpdate = $categoryService -> subCategoryUpdate($idx, $title);

                    if (!$subCategoryUpdate) {
    
                        throw new Exception("error : subCategoryUpdate");
            
                    }

                }

                // subDepth가 있을때
                for ($tdc=0; $tdc < COUNT($_POST['subDepthTitle']); $tdc++) {

                    if ($_POST['subDepthTitle'][$tdc] && !$_POST['subDepthIdx'][$tdc] ) { // 새로 추가된 서브 카테고리

                        if ($_POST['depth'] == 1) {

                            $depth = 2;

                        } else if ($_POST['depth'] == 2) {

                            $depth = 3;

                        }

                        // 서브 카테고리 등록
                        $subCategoryInsert = $categoryService -> subCategoryInsert($_POST['idx'], $_POST['subDepthTitle'][$tdc], $depth);

                        if ($subCategoryInsert == "error") {

                            echo json_encode("error");
        
                            throw new Exception("error : subCategoryInsert");
        
                        }

                    } else if ($_POST['subDepthTitle'][$tdc] && $_POST['subDepthIdx'][$tdc] ) { // 수정된 서브 카테고리

                        $idx = $_POST['subDepthIdx'][$tdc];
                        $title = $_POST['subDepthTitle'][$tdc];

                        // 서브 카테고리 수정
                        $subCategoryUpdate = $categoryService -> subCategoryUpdate($idx, $title);

                        if (!$subCategoryUpdate) {
        
                            throw new Exception("error : subCategoryUpdate");
                
                        }

                    }
                
                }

                $description = "사이트 카테고리 수정 : ".$_POST['title'];
                $tableIdx = $_POST['idx']; // insert될때 pk값
                $updateTable = "siteCategory";
                $act = "update";

                $adminLog = $adminLogSerice -> insertLog($description, $tableIdx, $updateTable, $act);

                if (!$adminLog) {
        
                    throw new Exception("error : siteCategoryUpdateLog");
        
                }

                echo json_encode("success");

            } else if ($_POST["act"] == "subCategoryDelete") {

                $subCategoryIdx = "'".$_POST['subCategoryIdx']."'";

                // 게시판 순서 조회
                $boardNumCheck = $boardCommonService -> boardNumCheck($subCategoryIdx);

                // 서브 카테고리 삭제
                $subCategoryDelete = $categoryService -> subCategoryDelete();

                if (!$subCategoryDelete) {

                    throw new Exception("error : subCategoryDelete");
        
                }
    
                // 관련 쓰리뎁스 삭제

                $subCategoryAllDelete = $categoryService -> subCategoryAllDelete($subCategoryIdx);

                if (!$subCategoryAllDelete) {
        
                    throw new Exception("error : subCategoryAllDelete");
        
                }

                $description = "사이트 카테고리 삭제";
                $tableIdx = $_POST['subCategoryIdx'];
                $updateTable = "siteSubCategory";
                $act = "delete";
    
                $adminLog = $adminLogSerice -> insertLog($description, $tableIdx, $updateTable, $act);
    
                if (!$adminLog) {
        
                    throw new Exception("error : siteCategoryDeleteLog");
        
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

                echo json_encode("success");

            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    }

    // 엑셀
    if ($page == "excel") {

        try {

            $excelService = new ExcelService();

            $result = array("success");

            if ($_POST["act"] == "download") {

                if ($_POST['ExcelTitle'] == "detailStatistics") { // 상세 접속분석

                    // 엑셀 다운로드
                    $excelDownload = $excelService -> excelDownload($_POST['idx']);

                    $excelDownloadItemNameArr = array("아이피", "접속경로", "디바이스", "접속일자", "접속시간");

                } else {

                    // 엑셀 컬럼 조회
                    $excelDownloadItemList = $excelService -> excelItem();
    
                    $excelDownloadItemArr = explode("◈", $excelDownloadItemList['excelItem']);
    
                    $excelDownloadItemNameArr = explode("◈", $excelDownloadItemList['excelItemName']);
    
                    $excelDownloadItem = "";
    
                    for ($edi=0; $edi < COUNT($excelDownloadItemArr); $edi++) {
    
                        $excelDownloadItem .= $edi + 1 == COUNT($excelDownloadItemArr) ? $excelDownloadItemArr[$edi] : $excelDownloadItemArr[$edi].", ";
    
                    }

                    // 엑셀 다운로드
                    $excelDownload = $excelService -> excelDownload($excelDownloadItem);

                }

                if (!$excelDownload) {
        
                    throw new Exception("error : excelDownload");
        
                } else {

                    $EXCEL_FILE = "<table border='1'>";

                    // tr 제작
                    $EXCEL_FILE .= "<tr>";

                    for ($edin=0; $edin < COUNT($excelDownloadItemNameArr); $edin++) {

                        $EXCEL_FILE .= "<th>".$excelDownloadItemNameArr[$edin]."</th>";

                    }

                    $EXCEL_FILE .= "</tr>";

                    // td 제작
                    for ($er=0; $er < COUNT($excelDownload); $er++) {

                        $EXCEL_FILE .= "<tr>";

                        for ($ed=0; $ed < COUNT($excelDownload[$er]); $ed++) {

                            // 변환되야할 데이터
                            if ($_POST['ExcelTitle'] == "detailStatistics") { // 상세 접속분석

                                // referer 데이터 변환
                                if ($excelDownload[$er][1] == "Unknown") {

                                    $excelDownload[$er][1] = "즐겨찾기, 주소창 입력";
    
                                }

                                // agent 데이터 변환
                                if (preg_match($checkDevice, $excelDownload[$er][2]) || $excelDownload[$er][2] == "IOS" || $excelDownload[$er][2] == "AOS" || $excelDownload[$er][2] == "MOBILE") {

                                    if (strpos($excelDownload[$er][2], "iPhone") || strpos($excelDownload[$er][2], "iPad") || strpos($excelDownload[$er][2], "iPod") || $excelDownload[$er][2] == "IOS") {

                                        $excelDownload[$er][2] = "IOS";
        
                                    } else if (strpos($excelDownload[$er][2], "Android") || $excelDownload[$er][2] == "AOS") {
        
                                        $excelDownload[$er][2] = "AOS";
        
                                    } else {
        
                                        $excelDownload[$er][2] = "MOBILE";
        
                                    }

                                } else {

                                    $excelDownload[$er][2] = "PC";

                                }

                            }

                            // 마스킹 처리
                            if ($_SESSION['admin_level'] == ""){

                                // 정관리자 이상은 전체 보이기
                                $EXCEL_FILE .= "<td>".$excelDownload[$er][$ed]."</td>";    

                            } else {

                                // 부관리자는 마스킹 보이기
                                $EXCEL_FILE .= "<td>".$excelDownload[$er][$ed]."</td>";

                            }

                        }

                        $EXCEL_FILE .= "</tr>";

                    }
                        
                    $EXCEL_FILE .= "</table>";
                        
                    // 엑셀 파일 내용
                    array_push($result, $EXCEL_FILE);

                    // 엑셀 sheet 제목
                    array_push($result, $_POST['type']);

                    array_push($result, $_POST['type']."_".$_POST['ExcelTitle']."_".date("Ymd"));

                    echo json_encode($result);

                }

            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    }

    // gnb
    if ($page == "gnb") {

        $categoryService = new CategoryService();

        try {

            $result = array("success");
    
            if ($_POST["act"] == "board") {
    
                // 게시판 카테고리 조회
                $categoryListSelect = $categoryService -> categoryListSelect();
    
                if ($categoryListSelect) {

                    array_push($result, $categoryListSelect);
    
                } else {
    
                    throw new Exception("error : gnbCategoryListSelect");
    
                }
    
                echo json_encode($result);
    
            }
    
        } catch (Exception $errorMsg) {
    
            echo $errorMsg;
    
            exit;
    
        }

    }

?>