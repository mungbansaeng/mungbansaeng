<?php

    // 게시판 공통
    class BoardCommonService {

        // 게시판 등록
        public function boardInsert($pcDescription, $mobileDescription) {

            if ($_POST['page'] == "siteBanner") {

                $sql = "
                    INSERT INTO siteBanner
                    (sort, title, type, link, adminId, showYn, date)
                    VALUES(
                        CASE WHEN (SELECT MAX(sc.sort) + 1 FROM siteBanner AS sc WHERE sc.type = '".$_POST['type']."') IS NULL THEN '1' ELSE (SELECT MAX(sc.sort) + 1 FROM siteBanner AS sc WHERE sc.type = '".$_POST['type']."') END,
                        '".$_POST['title']."',
                        '".$_POST['type']."',
                        '".$_POST['link']."',
                        '".$_SESSION['admin_id']."',
                        'Y',
                        NOW()
                    );
                ";

            } else {

                $sql = "
                    INSERT INTO board
                    (title, pcDescription, mobileDescription, startDate, finishDate, date, modifyDate, view, notice, keyword, categoryIdx, subCategoryIdx, showYn, regUserNo, sort)
                    VALUES(
                        '".$_POST['title']."',
                        '".$pcDescription."',
                        '".$mobileDescription."',
                        '".$_POST['startDate']."',
                        '".$_POST['finishDate']."',
                        NOW(),
                        NOW(),
                        '0',
                        '".$_POST['notice']."',
                        '".$_POST['keyword']."',
                        '".$_POST['categoryIdx']."',
                        '".$_POST['subCategoryIdx']."',
                        '".$_POST['showYn']."',
                        '".$_SESSION['admin_no']."',
                        CASE WHEN (SELECT MAX(ab.sort) + 1 FROM board AS ab WHERE ab.categoryIdx = '".$_POST['categoryIdx']."') IS NULL THEN '1' ELSE (SELECT MAX(ab.sort) + 1 FROM board AS ab WHERE ab.categoryIdx = '".$_POST['categoryIdx']."') END
                    );
                ";

            }

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 첨부파일 idx 업데이트
        public function boardIdxUpdate($idx, $boardTempIdx) {

            $sql = "
                UPDATE ".$_POST['page']."UploadFile
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

        // 게시판 리스트 카운트
        public function boardListCount($type = "") {

            $column = "COUNT(idx)";

            if ($type == "search") { // 검색

                if ($_POST['page'] == "product") {

                    $column = "COUNT(DISTINCT(p.idx))";

                    if ($_POST['categoryIdx3']) {

                        $addCategoryQuery = "pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND pc.categoryIdx2 = '".$_POST['categoryIdx2']."' AND pc.categoryIdx3 = '".$_POST['categoryIdx3']."' AND puf.fileNum = '1'";

                    } else if ($_POST['categoryIdx2']) {

                        $addCategoryQuery = "pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND pc.categoryIdx2 = '".$_POST['categoryIdx2']."' AND puf.fileNum = '1'";

                    } else if ($_POST['categoryIdx1']) {

                        $addCategoryQuery = "pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND puf.fileNum = '1'";

                    }

                    if ($_POST['searchText']) { // 검색어가 있을때

                        $addQuery = " AS p INNER JOIN productUploadFile AS puf ON p.idx = puf.boardIdx INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE p.".$_POST['searchType']." like '%".$_POST['searchText']."%' AND ".$addCategoryQuery;

                    } else { // 카테고리만 있을때

                        $addQuery = " AS p INNER JOIN productUploadFile AS puf ON p.idx = puf.boardIdx INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE ".$addCategoryQuery;

                    }

                } else {

                    $addQuery = " WHERE ".$_POST['searchType']." like '%".$_POST['searchText']."%'";

                }

            } else if ($type == "productSort") { // 상품 순서변경

                $column = "COUNT(DISTINCT(p.idx))";

                if ($_POST['categoryIdx3']) {

                    $addCategoryQuery = "pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND pc.categoryIdx2 = '".$_POST['categoryIdx2']."' AND pc.categoryIdx3 = '".$_POST['categoryIdx3']."' AND puf.fileNum = '1'";

                } else if ($_POST['categoryIdx2']) {

                    $addCategoryQuery = "pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND pc.categoryIdx2 = '".$_POST['categoryIdx2']."' AND puf.fileNum = '1'";

                } else if ($_POST['categoryIdx1']) {

                    $addCategoryQuery = "pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND puf.fileNum = '1'";

                }

                if ($_POST['searchText']) { // 검색어가 있을때

                    $addQuery = " AS p INNER JOIN productUploadFile AS puf ON p.idx = puf.boardIdx INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE p.".$_POST['searchType']." like '%".$_POST['searchText']."%' AND ".$addCategoryQuery;

                } else { // 카테고리만 있을때

                    $addQuery = " AS p INNER JOIN productUploadFile AS puf ON p.idx = puf.boardIdx INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE ".$addCategoryQuery;

                }

            }

            $sql = "
                SELECT ".$column." as totalCount FROM ".$_POST['page'].$addQuery."
            ";

            $row = assocQuery($sql);

            return $row;

        }

        // 게시판 리스트 조회
        public function boardListSelect($type, $idx = "", $categoryIdx = "", $category = "") {

            $column = "*";

            if ($type == "list") { // 리스트 조회

                $addQuery = " ORDER BY sort DESC LIMIT ".$_POST['limitStart'].", ".$_POST['showNum'];

            } else if ($type == "subCategoryList") { // 서브 카테고리 리스트 조회

                $addQuery = " WHERE categoryIdx = '".$_POST['idx']."' ORDER BY sort DESC";

            } else if ($type == "selectDel") { // 선택삭제

                if ($_POST['page'] == "product") {

                    if ($category == "category3") {

                        $column = "pc.idx AS idx";

                        $addQuery = " AS p INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE pc.sort3 > '".$idx."' AND pc.categoryIdx3 = '".$categoryIdx."' ORDER BY pc.sort3";

                    } else if ($category == "category2") {

                        $column = "pc.idx AS idx";

                        $addQuery = " AS p INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE pc.sort2 > '".$idx."' AND pc.categoryIdx2 = '".$categoryIdx."' ORDER BY pc.sort2";

                    } else if ($category == "category1") {

                        $column = "pc.idx AS idx";

                        $addQuery = " AS p INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE pc.sort1 > '".$idx."' AND pc.categoryIdx1 = '".$categoryIdx."' ORDER BY pc.sort1";

                    }

                } else {

                    $addQuery = " WHERE sort > '".$idx."' ORDER BY sort DESC";

                }

            } else if ($type == "sortChange") { // 순서 위아래로 변경

                if ($_POST['page'] == "product") {

                    if ($_POST['categoryIdx3']) {

                        $addQuery = " AS p INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE pc.sort2 = '".$idx."' AND pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND pc.categoryIdx2 = '".$_POST['categoryIdx2']."' AND pc.categoryIdx3 = '".$_POST['categoryIdx3']."'";

                    } else if ($_POST['categoryIdx2']) {

                        $addQuery = " AS p INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE pc.sort2 = '".$idx."' AND pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND pc.categoryIdx2 = '".$_POST['categoryIdx2']."'";

                    } else if ($_POST['categoryIdx1']) {

                        $addQuery = " AS p INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE pc.sort1 = '".$idx."' AND pc.categoryIdx1 = '".$_POST['categoryIdx1']."'";

                    }

                } else {

                    $addQuery = " WHERE sort = '".$idx."'";

                }

                if ($_POST['searchText']) { // 검색했을때 검색한 것 중 조회

                    $addQuery .= " AND ".$_POST['searchType']." like '%".$_POST['searchText']."%'";

                }

            } else if ($type == "search") { // 검색

                if ($_POST['page'] == "product") {

                    if ($_POST['categoryIdx3']) {

                        $column = "p.*, puf.fileName, pc.sort3 AS sort, pc.idx AS sortIdx";

                        $addCategoryQuery = "pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND pc.categoryIdx2 = '".$_POST['categoryIdx2']."' AND pc.categoryIdx3 = '".$_POST['categoryIdx3']."' AND puf.fileNum = '1' GROUP BY p.productCode ORDER BY pc.sort3 DESC";

                    } else if ($_POST['categoryIdx2']) {

                        $column = "p.*, puf.fileName, pc.sort2 AS sort, pc.idx AS sortIdx";

                        $addCategoryQuery = "pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND pc.categoryIdx2 = '".$_POST['categoryIdx2']."' AND puf.fileNum = '1' GROUP BY p.productCode ORDER BY pc.sort2 DESC";

                    } else if ($_POST['categoryIdx1']) {

                        $column = "p.*, puf.fileName, pc.sort1 AS sort, pc.idx AS sortIdx";

                        $addCategoryQuery = "pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND puf.fileNum = '1' GROUP BY p.productCode ORDER BY pc.sort1 DESC";

                    }

                    if ($_POST['searchText']) { // 검색어가 있을때

                        $addQuery = " AS p INNER JOIN productUploadFile AS puf ON p.idx = puf.boardIdx INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE p.".$_POST['searchType']." like '%".$_POST['searchText']."%' AND ".$addCategoryQuery." LIMIT ".$_POST['limitStart'].", ".$_POST['showNum'];

                    } else { // 카테고리만 있을때

                        $addQuery = " AS p INNER JOIN productUploadFile AS puf ON p.idx = puf.boardIdx INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE ".$addCategoryQuery." LIMIT ".$_POST['limitStart'].", ".$_POST['showNum'];

                    }

                } else {

                    $addQuery = " WHERE ".$_POST['searchType']." like '%".$_POST['searchText']."%' ORDER BY sort DESC LIMIT ".$_POST['limitStart'].", ".$_POST['showNum'];

                }

            } else if ($type == "productSort") { // 상품 순서변경 후 리스트

                if ($_POST['page'] == "product") {

                    if ($_POST['categoryIdx3']) {

                        $column = "p.*, puf.fileName, pc.sort3 AS sort, pc.idx AS sortIdx";

                        $addCategoryQuery = "pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND pc.categoryIdx2 = '".$_POST['categoryIdx2']."' AND pc.categoryIdx3 = '".$_POST['categoryIdx3']."' AND puf.fileNum = '1' GROUP BY p.productCode ORDER BY pc.sort3 DESC";

                    } else if ($_POST['categoryIdx2']) {

                        $column = "p.*, puf.fileName, pc.sort2 AS sort, pc.idx AS sortIdx";

                        $addCategoryQuery = "pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND pc.categoryIdx2 = '".$_POST['categoryIdx2']."' AND puf.fileNum = '1' GROUP BY p.productCode ORDER BY pc.sort2 DESC";

                    } else if ($_POST['categoryIdx1']) {

                        $column = "p.*, puf.fileName, pc.sort1 AS sort, pc.idx AS sortIdx";

                        $addCategoryQuery = "pc.categoryIdx1 = '".$_POST['categoryIdx1']."' AND puf.fileNum = '1' GROUP BY p.productCode ORDER BY pc.sort1 DESC";

                    }

                    if ($_POST['searchText']) { // 검색어가 있을때

                        $addQuery = " AS p INNER JOIN productUploadFile AS puf ON p.idx = puf.boardIdx INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE p.".$_POST['searchType']." like '%".$_POST['searchText']."%' AND ".$addCategoryQuery." LIMIT ".$_POST['limitStart'].", ".$_POST['showNum'];

                    } else { // 카테고리만 있을때

                        $addQuery = " AS p INNER JOIN productUploadFile AS puf ON p.idx = puf.boardIdx INNER JOIN productCategory AS pc ON p.idx = pc.productIdx WHERE ".$addCategoryQuery." LIMIT ".$_POST['limitStart'].", ".$_POST['showNum'];

                    }

                } else {

                    $addQuery = " WHERE ".$_POST['searchType']." like '%".$_POST['searchText']."%' ORDER BY sort DESC LIMIT ".$_POST['limitStart'].", ".$_POST['showNum'];

                }

            }

            $sql = "
                SELECT $column FROM ".$_POST['page'].$addQuery."
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 게시판 리스트 선택 삭제
        public function boardListDelete($idx) {

            $sql = "
                DELETE FROM ".$_POST['page']."
                WHERE idx in (".$idx.")
            ";
            
            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 게시판 순서 조회
        public function boardNumCheck($idx) {

            $sql = "
                SELECT MIN(sort) AS minSort FROM ".$_POST['page']." WHERE idx in (".$idx.")
            ";

            if ($row = assocQuery($sql)) {

                return $row;

            } else {

                return "error";

            }

        }

        // 게시판 순서 재배치
        public function boardNumChange($sort, $idx, $etc = "") {

            if ($_POST['page'] == "product") {

                if ($etc == "category3") {

                    $column = "sort3 = '".$sort."'";

                } else if ($etc == "category2") {

                    $column = "sort2 = '".$sort."'";

                } else if ($etc == "category1") {

                    $column = "sort1 = '".$sort."'";

                }

                $sql = "
                    UPDATE productCategory
                    SET
                        ".$column."
                    WHERE
                        idx = '".$idx."'".$addQuery."
                ";

            } else {

                $sql = "
                    UPDATE ".$_POST['page']."
                    SET
                        sort = '".$sort."'
                    WHERE
                        idx = '".$idx."'
                ";

            }

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 게시판 수정
        public function boardUpdate($pcDescription = "", $mobileDescription = "") {

            if ($_POST['act'] == "showYn") {

                $updatecolumn = "showYn = '".$_POST['showYn']."'";

            } else if ($_POST['page'] == "siteBanner") {

                $updatecolumn = "
                    title = '".$_POST['title']."',
                    type = '".$_POST['type']."',
                    link = '".$_POST['link']."'
                ";

            } else if ($_POST['page'] == "productBrand") {

                $updatecolumn = "
                    title = '".$_POST['title']."'
                ";

            } else if ($_POST['page'] == "productExcelConfig") {

                $updatecolumn = "
                    updateAdminId = '".$_SESSION['admin_id']."',
                    date = NOW(),
                    title = '".$_POST['title']."',
                    excelItemName = '".$_POST['excelItemName']."',
                    excelItem = '".$_POST['excelItem']."'
                ";

            } else if ($_POST['page'] == "board") {

                $updatecolumn = "
                    title = '".$_POST['title']."',
                    pcDescription = '".$pcDescription."',
                    mobileDescription = '".$mobileDescription."',
                    startDate = '".$_POST['startDate']."',
                    finishDate = '".$_POST['finishDate']."',
                    modifyDate = NOW(),
                    notice = '".$_POST['notice']."',
                    keyword = '".$_POST['keyword']."',
                    categoryIdx = '".$_POST['categoryIdx']."',
                    subCategoryIdx = '".$_POST['subCategoryIdx']."',
                    showYn = '".$_POST['showYn']."'
                ";

            }

            $sql = "
                UPDATE ".$_POST['page']."
                SET
                    ".$updatecolumn."
                WHERE
                    idx = '".$_POST['idx']."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 게시판 상세조회
        public function boardSelect() {

            if ($_POST['page'] == "product") {

                $sql = "
                    SELECT 
                        p.*,
                        pc.type,
                        (SELECT idx FROM siteCategory AS sc WHERE sc.idx = pc.categoryIdx1) AS categoryIdx1,
                        (SELECT idx FROM siteSubCategory AS ssc WHERE ssc.idx = pc.categoryIdx2) AS categoryIdx2,
                        (SELECT idx FROM siteSubCategory AS ssc WHERE ssc.idx = pc.categoryIdx3) AS categoryIdx3,
                        (SELECT title FROM siteCategory AS sc WHERE sc.idx = pc.categoryIdx1) AS categoryTitle1,
                        (SELECT title FROM siteSubCategory AS ssc WHERE ssc.idx = pc.categoryIdx2) AS categoryTitle2,
                        (SELECT title FROM siteSubCategory AS ssc WHERE ssc.idx = pc.categoryIdx3) AS categoryTitle3
                    FROM product AS p 
                    LEFT JOIN productCategory AS pc 
                    ON p.idx = pc.productIdx
                    WHERE 
                        p.idx = '".$_POST['idx']."'
                ";

                $row = loopAssocQuery($sql);

            } else {

                $sql = "
                    SELECT * FROM ".$_POST['page']." WHERE idx = '".$_POST['idx']."'
                ";

                $row = assocQuery($sql);

            }

            return $row;

        }

        // 게시판 첨부파일 조회
        public function boardAttachSelect() {

            $sql = "
                SELECT * FROM ".$_POST['page']."UploadFile WHERE boardIdx = '".$_POST['idx']."'
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

    }

?>