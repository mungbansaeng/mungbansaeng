<?php   

    // db 관련 클래스
    class DbService {

        // 해당 테이블 있는지 체크
        public function tableCheck ($table) {

            global $conn;

            $tableCheckSql = "SHOW TABLES LIKE '".$table."'";

            $tableCheck = numQuery($tableCheckSql);

            if ($tableCheck == 0) {

                $this -> tableInsert($table);

            }

            return $tableCheck;

        }

        // 테이블 생성
        public function tableInsert ($table) {

            global $conn;

            if ($table == "product") {

                $tableInsertSql = "
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

                $tableInsertSql = "
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

                $tableInsertSql = "
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

                $tableInsertSql = "
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

                $tableInsertSql = "
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

                $tableInsertSql = "
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

                $tableInsertSql = "
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

                $tableInsertSql = "
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

                $tableInsertSql = "
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

                $tableInsertSql = "
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

                $tableInsertSql = "
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

            } else if ($table == "review") {

                $tableInsertSql = "
                    CREATE TABLE ".$table." (
                        idx INT(11) NOT NULL AUTO_INCREMENT COMMENT '후기고유번호',
                        userNo VARCHAR(50) NOT NULL COMMENT '회원고유번호' COLLATE 'utf8_general_ci',
                        orderNo VARCHAR(20) NOT NULL COMMENT '주문고유번호' COLLATE 'utf8_general_ci',
                        productCode VARCHAR(255) NOT NULL COMMENT '상품코드' COLLATE 'utf8_general_ci',
                        orderProductIdx INT(11) NOT NULL COMMENT '주문명',
                        optionIdx INT(11) NOT NULL COMMENT '옵션고유번호',
                        optionTitle VARCHAR(255) NULL DEFAULT NULL COMMENT '옵션명' COLLATE 'utf8_general_ci',
                        reviewDescription TEXT NOT NULL COMMENT '후기내용' COLLATE 'utf8_general_ci',
                        reviewStar INT(11) NOT NULL DEFAULT '0' COMMENT '후기별점',
                        reviewType VARCHAR(10) NOT NULL COMMENT 'normal 일반, photo 이미지, video 동영상' COLLATE 'utf8_general_ci',
                        date DATETIME NOT NULL COMMENT '등록일',
                        PRIMARY KEY (idx) USING BTREE
                    )
                ";

            } else if ($table == "reviewUploadFile") {

                $tableInsertSql = "
                    CREATE TABLE ".$table." (
                        idx INT(11) NOT NULL AUTO_INCREMENT COMMENT '후기 이미지 고유번호',
                        fileName VARCHAR(1000) NOT NULL COMMENT '업로드된 파일명',
                        originFileName VARCHAR(1000) NOT NULL COMMENT '원래 파일명',
                        type VARCHAR(50) NOT NULL COMMENT '파일구분',
                        boardIdx INT(11) NULL DEFAULT '0' COMMENT '후기 고유번호',
                        fileNum VARCHAR(10) NOT NULL COMMENT '파일 순서',
                        date DATETIME NOT NULL COMMENT '등록일',
                        PRIMARY KEY (idx) USING BTREE
                    )
                ";

            }

            query($tableInsertSql);

        }

    }

    // 파일첨부
    class AttachFileService {

        // 등록할때 이전에 첨부한 파일 있는지 체크
        public function attachFileSelectNum($table, $tempBoardIdx) {

            global $conn;

            $attachFileSelectNum = "SELECT idx FROM ".$table."UploadFile WHERE boardIdx = '".$tempBoardIdx."'";
            
            $fileNumCount = numQuery($attachFileSelectNum);

            return $fileNumCount;

        }

        // db fileNum 재설정
        public function attachFileUpdateNum($table, $attachIdx, $fileNum) {

            global $conn;

            $attachFileUpdateNum = "UPDATE ".$table."UploadFile SET fileNum = '".$fileNum."' WHERE idx = '".$attachIdx."'";
            
            $fileUpdateNum = query($attachFileUpdateNum);

            return $fileUpdateNum;

        }

        // 등록된 첨부파일 조회
        public function attachFileSelect($table, $relationalIdx, $orderBy) {

            global $conn;

            $attachFileSelect = "SELECT idx, fileName, type FROM ".$table."UploadFile WHERE boardIdx in (".$relationalIdx.") ORDER BY idx ".$orderBy;
            
            $attachFileInfo = loopAssocQuery($attachFileSelect);

            return $attachFileInfo;

        }

        // 파일첨부 등록
        public function attachFileInsert($table, $saveUplodName, $orginUplodName, $postIdxColum, $postIdx, $fileNum, $fileType, $tempBoardIdx) {

            global $conn;

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

            global $conn;

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

        // 첨부파일 idx 업데이트
        public function attachFileIdxUpdate($table, $idx, $boardTempIdx) {

            global $conn;

            $sql = "
                UPDATE ".$table."UploadFile
                SET
                    boardIdx = '".$idx."'
                WHERE
                    boardIdx = '".$boardTempIdx."'
            ";

            if (query($sql)) {

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

?>