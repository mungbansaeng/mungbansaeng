<?php   

    // db 관련 클래스
    class DbService {

        // 해당 테이블 있는지 체크
        public function tableCheck ($table) {

            $tableCheckSql = "SHOW TABLES LIKE '".$table."'";

            $tableCheck = numQuery($tableCheckSql);

            if ($tableCheck == 0) {

                $this -> tableInsert($table);

            }

            return $tableCheck;

        }

        // 테이블 생성
        public function tableInsert ($table) {

            if ($table == "product") {

                $sql = "
                    CREATE TABLE ".$table." (
                        idx INT(11) NOT NULL AUTO_INCREMENT COMMENT '상품 고유번호',
                        productCode VARCHAR(50) NOT NULL COMMENT '상품코드',
                        title VARCHAR(1000) NOT NULL COMMENT '상품명',
                        brand INT(11) NOT NULL DEFAULT '0' COMMENT '브랜드 고유번호',
                        status INT(11) NOT NULL COMMENT '상품 상태',
                        pointPercent INT(11) NOT NULL DEFAULT '0' COMMENT '포인트퍼센트',
                        deliveryDate INT(11) NOT NULL DEFAULT '0' COMMENT '배송기간',
                        price INT(11) NOT NULL DEFAULT '0' COMMENT '상품가격',
                        discountPercent INT(11) NOT NULL DEFAULT '0' COMMENT '할인퍼센트',
                        pcDescription TEXT NOT NULL COMMENT '피씨 상품상세설명',
                        mobileDescription TEXT NOT NULL COMMENT '모바일 상품상세설명',
                        date DATETIME NOT NULL COMMENT '등록일',
                        showYn ENUM('Y','N') NOT NULL DEFAULT 'Y' COMMENT '노출유무',
                        view INT(11) NOT NULL DEFAULT '0' COMMENT '조회수',
                        reviewStar INT(11) NOT NULL DEFAULT '0' COMMENT '평점 총합',
                        reviewCount INT(11) NOT NULL DEFAULT '0' COMMENT '평점 총 개수',
                        stock INT(11) NOT NULL DEFAULT '0' COMMENT '재고수량',
                        buyLlimit INT(11) NOT NULL DEFAULT '0' COMMENT '주문한도',
                        soldCount INT(11) NOT NULL DEFAULT '0' COMMENT '판매량',
                        PRIMARY KEY (idx) USING BTREE
                    )
                ";

            } else if ($table == "siteCategory") {

                $sql = "
                    CREATE TABLE ".$table." (
                        idx int(11) NOT NULL AUTO_INCREMENT COMMENT '카테고리 고유번호',
                        sort int(11) NOT NULL COMMENT '카테고리 순서',
                        depthType int(11) NOT NULL COMMENT '카테고리 타입',
                        title VARCHAR(50) NOT NULL COMMENT '카테고리명',
                        file VARCHAR(50) NOT NULL COMMENT '카테고리 파일명',
                        adminId VARCHAR(20) NOT NULL COMMENT '등록아이디',
                        showYn ENUM('Y','N') NOT NULL DEFAULT 'Y' COMMENT '노출유무',
                        date DATETIME NOT NULL COMMENT '등록일',
                        PRIMARY KEY (idx) USING BTREE
                    )
                ";

            } else if ($table == "siteCategoryUploadFile") {

                $sql = "
                    CREATE TABLE ".$table." (
                        idx INT(11) NOT NULL AUTO_INCREMENT COMMENT '카테고리 파일 고유번호',
                        fileName VARCHAR(1000) NOT NULL COMMENT '업로드된 파일명',
                        originFileName VARCHAR(1000) NOT NULL COMMENT '원래 파일명',
                        type VARCHAR(50) NOT NULL COMMENT '파일구분',
                        boardIdx INT(11) NULL DEFAULT '0' COMMENT '상품 브랜드 고유번호',
                        fileNum VARCHAR(10) NOT NULL COMMENT '파일 순서',
                        date DATETIME NOT NULL COMMENT '등록일',
                        PRIMARY KEY (idx) USING BTREE
                    )
                ";

            } else if ($table == "siteSubCategory") {

                $sql = "
                    CREATE TABLE ".$table." (
                        idx int(11) NOT NULL AUTO_INCREMENT COMMENT '서브 카테고리 고유번호',
                        categoryIdx int(11) NOT NULL COMMENT '메인 카테고리 고유번호',
                        sort int(11) NOT NULL COMMENT '카테고리 순서',
                        title VARCHAR(50) NOT NULL COMMENT '카테고리명',
                        depth int(11) NOT NULL COMMENT '카테고리 뎁스',
                        adminId VARCHAR(20) NOT NULL COMMENT '등록아이디',
                        showYn ENUM('Y','N') NOT NULL DEFAULT 'Y' COMMENT '노출유무',
                        date DATETIME NOT NULL COMMENT '등록일',
                        PRIMARY KEY (idx) USING BTREE
                    )
                ";

            } else if ($table == "siteBanner") {

                $sql = "
                    CREATE TABLE ".$table." (
                        idx INT(11) NOT NULL AUTO_INCREMENT COMMENT '메인배너 고유번호',
                        sort INT(11) NOT NULL COMMENT '배너 순서',
                        title VARCHAR(50) NOT NULL COMMENT '메인배너명',
                        type INT(11) NOT NULL COMMENT '배너타입',
                        link VARCHAR(1000) NULL DEFAULT NULL COMMENT '연결링크',
                        adminId VARCHAR(20) NOT NULL COMMENT '등록아이디',
                        showYn ENUM('Y','N') NOT NULL DEFAULT 'Y' COMMENT '노출유무',
                        date DATETIME NOT NULL COMMENT '등록일',
                        PRIMARY KEY (idx) USING BTREE
                    )
                ";

            } else if ($table == "siteBannerUploadFile") {

                $sql = "
                    CREATE TABLE ".$table." (
                        idx INT(11) NOT NULL AUTO_INCREMENT COMMENT '배너파일 고유번호',
                        fileName VARCHAR(1000) NOT NULL COMMENT '업로드된 파일명',
                        originFileName VARCHAR(1000) NOT NULL COMMENT '원래 파일명',
                        type VARCHAR(50) NOT NULL COMMENT '파일구분',
                        boardIdx INT(11) NULL DEFAULT '0' COMMENT '상품 고유번호',
                        fileNum VARCHAR(10) NOT NULL COMMENT '파일 순서',
                        date DATETIME NOT NULL COMMENT '등록일',
                        PRIMARY KEY (idx) USING BTREE
                    )
                ";

            } else if ($table == "productCategory") {

                $sql = "
                    CREATE TABLE ".$table." (
                        idx INT(11) NOT NULL AUTO_INCREMENT COMMENT '상품 카테고리 고유번호',
                        productIdx INT(11) NOT NULL COMMENT '상품 고유번호',
                        sort INT(11) NOT NULL COMMENT '카테고리 순서',
                        type VARCHAR(5) NOT NULL COMMENT '카테고리 타입',
                        categoryIdx1 INT(11) NOT NULL COMMENT '첫번재 카테고리',
                        categoryIdx2 INT(11) NOT NULL COMMENT '두번재 카테고리',
                        categoryIdx3 INT(11) NOT NULL COMMENT '세번재 카테고리',
                        showYn ENUM('Y','N') NOT NULL DEFAULT 'Y' COMMENT '노출유무',
                        date DATETIME NOT NULL COMMENT '등록일',
                        PRIMARY KEY (idx) USING BTREE
                    )
                ";

            } else if ($table == "productOption") {

                $sql = "
                    CREATE TABLE ".$table." (
                        idx INT(11) NOT NULL AUTO_INCREMENT COMMENT '상품 옵션 고유번호',
                        productIdx INT(11) NOT NULL DEFAULT '0' COMMENT '상품 고유번호',
                        title VARCHAR(1000) NOT NULL COMMENT '옵션명',
                        price INT(8) NOT NULL DEFAULT '0' COMMENT '옵션가격',
                        stock INT(11) NOT NULL DEFAULT '0' COMMENT '옵션재고',
                        date DATETIME NOT NULL COMMENT '등록일',
                        PRIMARY KEY (idx) USING BTREE
                    )
                ";

            } else if ($table == "productBrand") {

                $sql = "
                    CREATE TABLE ".$table." (
                        idx INT(11) NOT NULL AUTO_INCREMENT COMMENT '상품 브랜드 고유번호',
                        sort int(11) NOT NULL COMMENT '상품 브랜드 순서',
                        title VARCHAR(1000) NOT NULL COMMENT '상품 브랜드명',
                        showYn ENUM('Y','N') NOT NULL DEFAULT 'Y' COMMENT '노출유무',
                        date DATETIME NOT NULL COMMENT '등록일',
                        PRIMARY KEY (idx) USING BTREE
                    )
                ";

            } else if ($table == "productBrandUploadFile") {

                $sql = "
                    CREATE TABLE ".$table." (
                        idx INT(11) NOT NULL AUTO_INCREMENT COMMENT '상품 브랜드 파일 고유번호',
                        fileName VARCHAR(1000) NOT NULL COMMENT '업로드된 파일명',
                        originFileName VARCHAR(1000) NOT NULL COMMENT '원래 파일명',
                        type VARCHAR(50) NOT NULL COMMENT '파일구분',
                        boardIdx INT(11) NULL DEFAULT '0' COMMENT '상품 브랜드 고유번호',
                        fileNum VARCHAR(10) NOT NULL COMMENT '파일 순서',
                        date DATETIME NOT NULL COMMENT '등록일',
                        PRIMARY KEY (idx) USING BTREE
                    )
                ";

            } else if ($table == "productExcelConfig") {

                $sql = "
                    CREATE TABLE ".$table." (
                        idx INT(11) NOT NULL AUTO_INCREMENT COMMENT '엑셀 설정 고유번호',
                        adminId VARCHAR(20) NOT NULL COMMENT '등록아이디',
                        updateAdminId VARCHAR(20) NOT NULL COMMENT '수정아이디',
                        date DATETIME NOT NULL COMMENT '등록일',
                        sort int(11) NOT NULL COMMENT '엑셀 순서',
                        title VARCHAR(100) NOT NULL COMMENT '엑셀 제목',
                        excelItemName VARCHAR(1000) NOT NULL COMMENT '엑셀 항목의 제목',
                        excelItem VARCHAR(1000) NOT NULL COMMENT '엑셀 항목',
                        PRIMARY KEY (idx) USING BTREE
                    )
                ";

            }

            query($sql);

        }

    }

    // config
    class ConfigService {

        // config 조회
        public function configSelect($page) {

            if ($page == "homepageConfig") {

                $configAdd = "*";

                $addConfigQuery = " LEFT JOIN configUploadFile ON type = 'logo'";

            } else {

                $configAdd = "*";

            }

            $sql = "SELECT $configAdd FROM config".$addConfigQuery;
            
            $row = assocQuery($sql);

            return $row;

        }

        // config 수정
        public function configUpdate($private, $tnc, $thirdParty, $privateUse) {

            if ($_POST['page'] == "ip") {

                $updateAdd = "adminIp = '".$_POST['adminIp']."'";

            } else if ($_POST['page'] == "homepageConfig") {

                $updateAdd = "
                    companyName = '".$_POST['companyName']."',
                    siteName = '".$_POST['siteName']."',
                    ceoName = '".$_POST['ceoName']."',
                    privateProtectionName = '".$_POST['privateProtectionName']."',
                    companyAddress = '".$_POST['companyAddress']."',
                    companyCall = '".$_POST['companyCall']."',
                    companyFax = '".$_POST['companyFax']."',
                    companyEmail = '".$_POST['companyEmail']."',
                    companyRegiNumber = '".$_POST['companyRegiNumber']."',
                    onlineRegiNumber = '".$_POST['onlineRegiNumber']."',
                    mainColor = '".$_POST['mainColor']."',
                    alertDesign = '".$_POST['alertDesign']."',
                    snsLoginDesign = '".$_POST['snsLoginDesign']."',
                    naverLoginUse = '".$_POST['naverLoginUse']."',
                    naverLoginClientId = '".$_POST['naverLoginClientId']."',
                    naverLoginClientSecret = '".$_POST['naverLoginClientSecret']."',
                    kakaoLoginUse = '".$_POST['kakaoLoginUse']."',
                    kakaoLoginClientId = '".$_POST['kakaoLoginClientId']."',
                    kakaoLoginClientSecret = '".$_POST['kakaoLoginClientSecret']."',
                    googleLoginUse = '".$_POST['googleLoginUse']."',
                    googleLoginClientId = '".$_POST['googleLoginClientId']."',
                    googleLoginClientSecret = '".$_POST['googleLoginClientSecret']."',
                    appleLoginUse = '".$_POST['appleLoginUse']."',
                    appleLoginClientId = '".$_POST['appleLoginClientId']."',
                    appleLoginClientSecret = '".$_POST['appleLoginClientSecret']."',
                    private = '".$private."',
                    tnc = '".$tnc."',
                    thirdParty = '".$thirdParty."',
                    privateUse = '".$privateUse."'
                ";

            }

            $sql = "
                UPDATE config
                SET
                    $updateAdd
            ";
            
            if(query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

    }

    // 메타태그
    class MetaService {

        // 메타태그 조회
        public function metaSelect() {

            $metaSql = "SELECT * FROM meta";
            
            $row = assocQuery($metaSql);

            return $row;

        }

        // 메타태그 수정
        public function metaUpdate() {

            $metaUpdateSql = "
                UPDATE meta
                SET
                    siteTit = '".$_POST['siteTit']."',
                    siteKeyword = '".$_POST['siteKeyword']."',
                    siteDescription = '".$_POST['siteDescription']."',
                    siteUrl = '".$_POST['siteUrl']."',
                    naverVerification = '".$_POST['naverVerification']."',
                    googleVerification = '".$_POST['googleVerification']."'
            ";
            
            if(query($metaUpdateSql)) {

                return "success";

            } else {

                return "error";

            }

        }

    }

    // 접속통계
    class statisticsService {

        // 월별 접속통계 조회
        public function monthstatisticsCount() {

            $counterInfoSql = "
                SELECT * FROM (
                    (SELECT COUNT(idx) as JanCount FROM counterInfo WHERE DATE_FORMAT(date,'%m') = '01') as JanCount,
                    (SELECT COUNT(idx) as FebCount FROM counterInfo WHERE DATE_FORMAT(date,'%m') = '02') as FebCount,
                    (SELECT COUNT(idx) as MarCount FROM counterInfo WHERE DATE_FORMAT(date,'%m') = '03') as MarCount,
                    (SELECT COUNT(idx) as AprCount FROM counterInfo WHERE DATE_FORMAT(date,'%m') = '04') as AprCount,
                    (SELECT COUNT(idx) as MayCount FROM counterInfo WHERE DATE_FORMAT(date,'%m') = '05') as MayCount,
                    (SELECT COUNT(idx) as JunCount FROM counterInfo WHERE DATE_FORMAT(date,'%m') = '06') as JunCount,
                    (SELECT COUNT(idx) as JulCount FROM counterInfo WHERE DATE_FORMAT(date,'%m') = '07') as JulCount,
                    (SELECT COUNT(idx) as AugCount FROM counterInfo WHERE DATE_FORMAT(date,'%m') = '08') as AugCount,
                    (SELECT COUNT(idx) as SepCount FROM counterInfo WHERE DATE_FORMAT(date,'%m') = '09') as SepCount,
                    (SELECT COUNT(idx) as OctCount FROM counterInfo WHERE DATE_FORMAT(date,'%m') = '10') as OctCount,
                    (SELECT COUNT(idx) as NovCount FROM counterInfo WHERE DATE_FORMAT(date,'%m') = '11') as NovCount,
                    (SELECT COUNT(idx) as DecCount FROM counterInfo WHERE DATE_FORMAT(date,'%m') = '12') as DecCount
                )
            ";
            
            $row = loopAssocQuery($counterInfoSql);

            return $row;

        }

        // 상세 접속분석 조회 카운트
        public function statisticsCount() {

            $statisticsCountSql = "
                SELECT 
                    COUNT(date) as totalCount
                FROM ".$_POST['act']."
                WHERE 
                    date >= '".$_POST['startYear']."-".$_POST['startMonth']."-".$_POST['startDay']."'
                AND 
                    date <= '".$_POST['endYear']."-".$_POST['endMonth']."-".$_POST['endDay']."'
            ";
            
            $row = assocQuery($statisticsCountSql);

            return $row;

        }

        // 상세 접속분석 조회
        public function detailStatisticsSelect() {

            $detailStatisticsSelectSql = "
                SELECT 
                    * 
                FROM ".$_POST['act']." 
                WHERE 
                    date >= '".$_POST['startYear']."-".$_POST['startMonth']."-".$_POST['startDay']."'
                AND 
                    date <= '".$_POST['endYear']."-".$_POST['endMonth']."-".$_POST['endDay']."'
                ORDER BY idx DESC 
                LIMIT ".$_POST['limitStart'].", ".$_POST['showNum'];
            
            $row = loopAssocQuery($detailStatisticsSelectSql);

            return $row;

        }

        // 기간별 접속분석 조회
        public function periodStatisticsSelect() {

            $periodStatisticsSelectSql = "
                SELECT 
                    * 
                FROM ".$_POST['act']." 
                WHERE 
                    date >= '".$_POST['startYear']."-".$_POST['startMonth']."-".$_POST['startDay']."'
                AND 
                    date <= '".$_POST['endYear']."-".$_POST['endMonth']."-".$_POST['endDay']."'
                ORDER BY date
            ";
            
            $row = loopAssocQuery($periodStatisticsSelectSql);

            return $row;

        }

    }

    // 파일첨부
    class AttachFileService {

        // 등록할때 이전에 첨부한 파일 있는지 체크
        public function attachFileSelectNum($table, $tempBoardIdx) {

            $attachFileSelectNum = "SELECT idx FROM ".$table."UploadFile WHERE boardIdxIdx = '".$tempBoardIdx."'";
            
            $fileNumCount = numQuery($attachFileSelectNum);

            return $fileNumCount;

        }

        // db fileNum 재설정
        public function attachFileUpdateNum($table, $attachIdx, $fileNum) {

            $attachFileUpdateNum = "UPDATE ".$table."UploadFile SET fileNum = '".$fileNum."' WHERE idx = '".$attachIdx."'";
            
            $fileUpdateNum = query($attachFileUpdateNum);

            return $fileUpdateNum;

        }

        // 등록된 첨부파일 조회
        public function attachFileSelect($table, $relationalIdx, $orderBy) {

            $attachFileSelect = "SELECT idx, fileName FROM ".$table."UploadFile WHERE boardIdx in (".$relationalIdx.") ORDER BY idx $orderBy";
            
            $attachFileInfo = loopAssocQuery($attachFileSelect);

            return $attachFileInfo;

        }

        // 파일첨부 등록
        public function attachFileInsert($table, $saveUplodName, $orginUplodName, $postIdxColum, $postIdx, $fileNum, $fileType, $tempBoardIdx) {

            $attachFileInsert = "
                INSERT INTO ".$table."UploadFile
                (fileName, originFileName, type, boardIdx, fileNum, date)
                VALUES(
                    '".$saveUplodName."',
                    '".$orginUplodName."',
                    '".$fileType."',
                    '".$tempBoardIdx."',
                    '".$fileNum."',
                    NOW()
                );
            ";
            
            query($attachFileInsert);

            return $tempBoardIdx;

        }

        // 파일첨부 삭제
        public function attachFileDelete($table, $fileIdx) {

            $attachFileDelete = "
                DELETE FROM ".$table."UploadFile
                WHERE
                    idx = '".$fileIdx."'
            ";
            
            if (query($attachFileDelete)) {

                return "success";

            } else {

                return "error";

            }

        }

    }

    // 에디터 이미지
    class EditorService {

        // 에디터 이미지 옮기기
        public function editorImagesMove($viewDescImg) {
    
            preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $viewDescImg, $matches);
        
            for($i=0; $i<count($matches[1]); $i++){
                
                $originFile = dirname(dirname(dirname(__FILE__))).$matches[1][$i];
                
                $imgOrinName = basename($originFile);
                
                $copyFile = dirname(dirname(dirname(__FILE__)))."/ckeditor/upload/".$imgOrinName;
                
                if(file_exists($originFile)){
                    
                    rename($originFile, $copyFile);
        
                }else{
                    
                    echo "실패";
                    
                }
                
            }

        }

        // 에디터 임시 파일저장소 지우기
        public function editorImagesDelete() {

            global $date;

            $tempImgDir = opendir(dirname(dirname(dirname(__FILE__)))."/ckeditor/tempUpload");
    
            while($tempImg = readdir($tempImgDir)){

                if($tempImg == "." || $tempImg == ".."){
                    continue;
                }

                $originFile = dirname(dirname(dirname(__FILE__)))."/ckeditor/tempUpload/".$tempImg;
                
                $tempImgTime = date("Y-m-d",filemtime($originFile));
                
                // 하루전 임시 파일 삭제
                if($date > $tempImgTime){
                    
                    unlink(dirname(dirname(dirname(__FILE__)))."/ckeditor/tempUpload/".$tempImg);
                    
                }
        
            }

        }

    }

    // 카테고리
    class CategoryService {

        // 카테고리 파일 생성
        public function categoryCreate() {

            if ($_POST['depthType'] == "100") { // 일반 페이지

                $contents = "
<?php 

include_once dirname(__FILE__).\"/front/view/board/normalPage.php\"; 

?>
                    ";

            } else if ($_POST['depthType'] == "201") { // 일반 게시판

                $contents = "
<?php 

include_once dirname(__FILE__).\"/front/view/board/normalBoard.php\"; 

?>
                    ";

                

            } else if ($_POST['depthType'] == "202") { // 작은 이미지 게시판

                $contents = "
<?php 

include_once dirname(__FILE__).\"/front/view/board/miniGallaryBoard.php\"; 

?>
                    ";

            } else if ($_POST['depthType'] == "203") { // 큰 이미지 게시판

                $contents = "
<?php 

include_once dirname(__FILE__).\"/front/view/board/bigGallaryBoard.php\"; 

?>
                    ";

                

            } else if ($_POST['depthType'] == "204") { // 웹진형 게시판

                $contents = "
<?php 

include_once dirname(__FILE__).\"/front/view/board/webZineBoard.php\"; 

?>
                    ";

                

            } else if ($_POST['depthType'] == "205") { // Q&A 게시판

                $contents = "
<?php 

include_once dirname(__FILE__).\"/front/view/board/qnaBoard.php\"; 

?>
                    ";

                

            } else if ($_POST['depthType'] == "206") { // 문의 게시판

                $contents = "
<?php 

include_once dirname(__FILE__).\"/front/view/board/inquiryBoard.php\"; 

?>
                    ";

                

            } else if ($_POST['depthType'] == "207") { // SNS형 게시판

                $contents = "
<?php 

include_once dirname(__FILE__).\"/front/view/board/snsBoard.php\"; 

?>
                    ";

                

            } else if ($_POST['depthType'] == "208") { // 뉴스형 게시판

                $contents = "
<?php 

include_once dirname(__FILE__).\"/front/view/board/newsBoard.php\"; 

?>
                    ";

                

            } else if ($_POST['depthType'] == "401") { // 상품 게시판

                $contents = "
<?php 

include_once dirname(__FILE__).\"/front/view/product/product.php\"; 

?>
<script>

$('#page').val('product');

viewList();

</script>
                    ";

            } else if ($_POST['depthType'] == "402") { // 상품 베스트 게시판

                $contents = "
<?php 

include_once dirname(__FILE__).\"/front/view/product/product.php\"; 

?>
<script>

$('#page').val('best');

viewList();

</script>
                    ";

            } else if ($_POST['depthType'] == "403") { // 후기 게시판

                $contents = "
<?php 

include_once dirname(__FILE__).\"/front/view/mypage/reviewList.php\"; 

?>
<script>

$('#page').val('review');

viewList();

</script>
                    ";

            }

            // w -> 새로 생성, a -> 만들어진 파일에 덮어씀
            $fp = fopen(dirname(dirname(dirname(__FILE__)))."/".$_POST['file'].".php", "w");

            $categoryFileCreate = fwrite($fp, $contents);

            fclose($fp);

            if ($categoryFileCreate) {

                return "success";

            } else {

                return "error";

            }

        }

        // 카테고리 등록
        public function categoryInsert() {

            $categoryInsert = "
                INSERT INTO siteCategory
                (sort, depthType, title, file, adminId, showYn, date)
                VALUES(
                    CASE WHEN (SELECT MAX(sc.sort) + 1 FROM siteCategory as sc) IS NULL THEN '1' ELSE (SELECT MAX(sc.sort) + 1 FROM siteCategory as sc) END,
                    '".$_POST['depthType']."',
                    '".$_POST['title']."',
                    '".$_POST['file']."',
                    '".$_SESSION['admin_id']."',
                    'Y',
                    NOW()
                );
            ";

            if (query($categoryInsert)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 서브 카테고리 등록
        public function subCategoryInsert($categoryIdx, $title, $depth) {

            $subCategoryInsert = "
                INSERT INTO siteSubCategory
                (categoryIdx, sort, title, depth, adminId, showYn, date)
                VALUES(
                    '".$categoryIdx."',
                    CASE WHEN (SELECT MAX(ssc.sort) + 1 FROM siteSubCategory as ssc WHERE categoryIdx = '".$categoryIdx."' AND depth = '".$depth."') IS NULL THEN '1' ELSE (SELECT MAX(ssc.sort) + 1 FROM siteSubCategory as ssc WHERE categoryIdx = '".$categoryIdx."' AND depth = '".$depth."') END,
                    '".$title."',
                    '".$depth."',
                    '".$_SESSION['admin_id']."',
                    'Y',
                    NOW()
                );
            ";

            if (query($subCategoryInsert)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 카테고리 리스트 조회
        public function categoryListSelect() {

            if ($_POST['page'] == "product") {

                if ($_POST['depth'] == 1) {

                    $sql = "
                        SELECT idx, title FROM siteCategory WHERE depthType like '40%' AND depthType != '402'
                    "; // 베스트 게시판은 노출 X

                } else {

                    $sql = "
                        SELECT idx, title FROM siteSubCategory WHERE categoryIdx = '".$_POST['categoryIdx']."'
                    ";
                
                }

            } else if ($_POST['page'] == "gnb") {

                $sql = "
                    SELECT idx, title FROM siteCategory WHERE depthType like '2%'
                ";

            } else {

                $sql = "
                    SELECT idx, title FROM siteCategory WHERE depthType in (".$_POST['categoryIdx'].") AND showYn = 'Y'
                ";

            }

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 카테고리 조회
        public function categorySelect($idx) {

            $sql = "
                SELECT * FROM siteCategory AS sc LEFT JOIN siteCategoryUploadFile AS scuf ON sc.idx = scuf.boardIdx WHERE sc.idx = '".$idx."'
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 서브카테고리 리스트 조회
        public function subCategoryListSelect($idx) {

            $subCategorySelect = "
                SELECT * FROM siteSubCategory WHERE categoryIdx = '".$idx."' ORDER BY sort
            ";

            $row = loopAssocQuery($subCategorySelect);

            return $row;

        }

        // 서브카테고리 조회
        public function subCategorySelect() {

            $subCategorySelect = "
                SELECT * FROM siteSubCategory WHERE idx = '".$_POST['idx']."'
            ";

            $row = assocQuery($subCategorySelect);

            return $row;

        }

        // 서브 카테고리 투뎁스 조회
        public function subCategoryIdxSelect($idx) {

            $subCategoryIdxSelect = "
                SELECT * FROM siteSubCategory WHERE categoryIdx in (".$idx.")
            ";

            $row = loopAssocQuery($subCategoryIdxSelect);

            return $row;

        }

        // 서브카테고리 전체 삭제
        public function subCategoryAllDelete($idx) {

            $subCategoryAllDelete = "
                DELETE FROM siteSubCategory
                WHERE categoryIdx in (".$idx.")
            ";

            if (query($subCategoryAllDelete)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 카테고리 수정
        public function categoryUpdate() {

            $categoryUpdate = "
                UPDATE siteCategory
                SET
                    depthType = '".$_POST['depthType']."',
                    title = '".$_POST['title']."',
                    file = '".$_POST['file']."'
                WHERE
                    idx = '".$_POST['idx']."'
            ";

            if (query($categoryUpdate)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 서브 카테고리 수정
        public function subCategoryUpdate($idx, $title) {

            $subCategoryUpdate = "
                UPDATE siteSubCategory
                SET
                    title = '".$title."'
                WHERE
                    idx = '".$idx."'
                ";

            if (query($subCategoryUpdate)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 서브카테고리 삭제
        public function subCategoryDelete() {

            $subCategoryDelete = "
                DELETE FROM siteSubCategory
                WHERE idx = ".$_POST['subCategoryIdx']."
            ";

            if (query($subCategoryDelete)) {

                return "success";

            } else {

                return "error";

            }

        }

    }

    // 엑셀
    class ExcelService {

        // 엑셀 컬럼 조회
        public function excelItem() {

            $excelItemSql = "SELECT excelItemName, excelItem FROM ".$_POST['ExcelType']." WHERE idx = '".$_POST['idx']."'";
            
            $row = assocQuery($excelItemSql);

            return $row;

        }

        // 엑셀 다운로드
        public function excelDownload($column) {

            $addQuery = "";

            if ($_POST['ExcelType'] == "productExcelConfig") {

                if ($_POST['categoryIdx3']) {

                    $addCategoryQuery = "pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND pc.categoryIdx2 = '".$_POST['categoryIdx2']."' AND pc.categoryIdx3 = '".$_POST['categoryIdx3']."' AND puf.fileNum = '1' GROUP BY p.productCode ORDER BY pc.sort3 DESC";

                } else if ($_POST['categoryIdx2']) {

                    $addCategoryQuery = "pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND pc.categoryIdx2 = '".$_POST['categoryIdx2']."' AND puf.fileNum = '1' GROUP BY p.productCode ORDER BY pc.sort2 DESC";

                } else if ($_POST['categoryIdx1']) {

                    $addCategoryQuery = "pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND puf.fileNum = '1' GROUP BY p.productCode ORDER BY pc.sort1 DESC";

                }

                if ($_POST['searchText']) { // 검색어가 있을때

                    $addQuery = " AS p INNER JOIN productUploadFile AS puf ON p.idx = puf.boardIdx INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE p.".$_POST['searchType']." like '%".$_POST['searchText']."%' AND ".$addCategoryQuery;

                } else { // 카테고리만 있을때

                    $addQuery = " AS p INNER JOIN productUploadFile AS puf ON p.idx = puf.boardIdx INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE ".$addCategoryQuery;

                }

                $table = $_POST['type'];

            } else if ($_POST['ExcelType'] == "static") {

                if ($_POST['ExcelTitle'] == "detailStatistics") {

                    $table = "counterInfo";
    
                    $addQuery = " WHERE date >= '".$_POST['startYear']."-".$_POST['startMonth']."-".$_POST['startDay']."' AND date <= '".$_POST['endYear']."-".$_POST['endMonth']."-".$_POST['endDay']."'";
    
                }

            } else {

                if ($_POST['searchText'] !== "") {
    
                    $addQuery .= " AND ".$_POST['searchType']." = '".$_POST['searchText']."'";
    
                }

            }

            $excelDownloadSql = "SELECT $column FROM ".$table.$addQuery;
            
            $row = loopRowQuery($excelDownloadSql);

            return $row;

        }

    }

?>