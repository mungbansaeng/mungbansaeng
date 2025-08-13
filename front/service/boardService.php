<?php

    // 게시판 공통
    class BoardCommonService {

        // 소개 게시판 조회
        public function normalPageSelect() {

            $sql = "
                SELECT 
                    fileName
                FROM siteCategoryUploadFile
                WHERE
                    boardIdx = '".$_POST['idx']."'
                AND
                    type = '".$_POST['type']."'
            ";

            $row = assocQuery($sql);

            return $row;

        }

        // 게시판 조회
        public function boardListSelect() {

            $sql = "
                SELECT 
                    b.idx,
                    b.title AS boardTitle,
                    b.pcDescription,
                    b.mobileDescription,
                    b.startDate,
                    b.finishDate,
                    b.view,
                    b.notice,
                    b.keyword,
                    b.sort,
                    b.date,
                    ssc.title AS categoryTitle,
                    buf.fileName,
                    au.admin_id,
                    m.id
                FROM board AS b
                LEFT JOIN boardUploadFile AS buf
                ON b.idx = buf.boardIdx
                INNER JOIN siteCategory AS sc
                ON b.categoryIdx = sc.idx AND sc.depthType = '208'
                LEFT JOIN siteSubCategory AS ssc
                ON b.subCategoryIdx = ssc.idx AND b.categoryIdx = ssc.categoryIdx
                LEFT JOIN member AS m
                ON m.idx = b.regUserNo
                LEFT JOIN aduser AS au
                ON au.idx = b.regUserNo
                WHERE
                    b.categoryIdx = '".$_POST['categoryIdx']."'
                AND
                    b.showYn = 'Y'
                ORDER BY b.date DESC, buf.fileNum
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

    }

?>