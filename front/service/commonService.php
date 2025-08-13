<?php

    // config
    class ConfigService {

        // config 조회
        public function configSelect () {

            $configSelectSql = "SELECT * FROM config LEFT JOIN configUploadFile ON type = 'logo'";
            
            if ($row = assocQuery($configSelectSql)) {

                return $row;

            } else {

                return "error";

            }

        }

    }

    // 메타태그
    class MetaService {

        // 메타태그 조회
        public function metaSelect () {

            $metaSelectSql = "SELECT * FROM meta";
            
            $row = assocQuery($metaSelectSql);

            return $row;

        }

    }

    // 사이트 카테고리
    class CategoryService {

        public function categorySelect () {

            $categorySelect = "SELECT idx, title, file, showYn FROM siteCategory ORDER BY sort";
            
            $row = loopAssocQuery($categorySelect);

            return $row;

        }

        // 서브카테고리 리스트 조회
        public function subCategoryListSelect() {

            $subCategorySelect = "
                SELECT * FROM siteSubCategory WHERE categoryIdx = '".$_POST['categoryIdx']."' ORDER BY sort
            ";

            $row = loopAssocQuery($subCategorySelect);

            return $row;

        }

    }

    // 검색
    class SearchService {

        // 총 상품 갯수 조회
        public function productSearchCount () {
        
            $sql = "
                SELECT 
                    COUNT(p.idx) AS totalCount
                FROM product AS p
                WHERE 
                    p.showYn = 'Y'
                AND
                    p.keyword like '%".$_POST['searchWord']."%'
            ";

            $row = assocQuery($sql);

            return $row;

        }

        public function productSearchSelect () {

            $sql = "
                SELECT 
                    p.idx,
                    p.productCode,
                    p.title,
                    p.status,
                    p.price,
                    p.discountPercent,
                    p.reviewStar,
                    p.reviewCount,
                    puf.fileName
                FROM product AS p
                INNER JOIN productUploadFile AS puf
                ON p.idx = puf.boardIdx 
                WHERE 
                    p.showYn = 'Y'
                AND
                    p.keyword like '%".$_POST['searchWord']."%'
            ";
            
            $row = loopAssocQuery($sql);

            return $row;

        }

    }

?>