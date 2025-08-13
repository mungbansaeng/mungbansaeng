<?php

    // 메인페이지
    class MainService {

        // 배너 조회
        public function mainTopBanner() {

            $sql = "
                SELECT 
                    sb.title,
                    sb.link,
                    sbuf.fileName
                FROM siteBanner AS sb 
                LEFT JOIN siteBannerUploadFile AS sbuf
                ON sb.idx = sbuf.boardIdx
                WHERE
                    sb.showYn = 'Y'
                AND
                    sbuf.type = '".$_POST['type']."'
                ORDER BY sb.sort
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 메인 뉴스
        public function mainNewsList() {

            $sql = "
                SELECT 
                    b.title AS newsTitle,
                    b.pcDescription,
                    b.mobileDescription,
                    b.date,
                    ssc.title AS categoryTitle,
                    buf.fileName
                FROM board AS b
                INNER JOIN siteCategory AS sc
                ON b.categoryIdx = sc.idx AND sc.depthType = '208'
                LEFT JOIN siteSubCategory AS ssc
                ON b.subCategoryIdx = ssc.idx AND b.categoryIdx = ssc.categoryIdx
                LEFT JOIN boardUploadFile AS buf
                ON b.idx = buf.boardIdx
                WHERE b.showYn = 'Y'
                ORDER BY b.date DESC
                LIMIT 4
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 메인 베스트
        public function mainBestList() {

            $sql = "
                SELECT 
                    p.productCode,
                    p.title,
                    puf.fileName
                FROM product AS p
                LEFT JOIN productUploadFile AS puf
                ON p.idx = puf.boardIdx
                ORDER BY 
                    reviewStar / reviewCount DESC, 
                    reviewStar DESC 
                LIMIT 8
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 메인 후기
        public function mainReviewList() {

            $sql = "
                SELECT
                    r.*,
                    ruf.fileName,
                    p.title AS productName,
                    m.id AS id
                FROM review AS r
                LEFT JOIN reviewUploadFile AS ruf
                ON r.idx = ruf.boardIdx
                INNER JOIN product AS p
                ON r.productCode = p.productCode
                INNER JOIN member AS m
                ON r.userNo = m.idx
                ORDER BY r.reviewStar DESC
                LIMIT 8
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

    }

?>