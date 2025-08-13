<?php

    // 상품 페이지
    class ProductService {

        // 상품 브랜드 등록
        public function productBrandInsert() {

            $sql = "
                INSERT INTO productBrand
                (title, date)
                VALUES(
                    '".$_POST['title']."',
                    NOW()
                );
            ";

            if(query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 상품 등록
        public function productInsert($productCode, $price, $stock, $pcDescription, $mobileDescription) {

            $sql = "
                INSERT INTO product
                (productCode, title, keyword, brandIdx, status, pointPercent, deliveryDate, price, discountPercent, pcDescription, mobileDescription, date, view, stock, buyLlimit)
                VALUES(
                    '".$productCode."',
                    '".$_POST['title']."',
                    '".$_POST['keyword']."',
                    '".$_POST['brandIdx']."',
                    '".$_POST['status']."',
                    '".$_POST['pointPercent']."',
                    '".$_POST['deliveryDate']."',
                    '".$price."',
                    '".$_POST['discountPercent']."',
                    '".$pcDescription."',
                    '".$mobileDescription."',
                    NOW(),
                    '0',
                    '".$stock."',
                    '".$_POST['limit']."'
                );
            ";

            if(query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 상품 삭제
        public function productDelete($idx) {

            $sql = "
                DELETE FROM product
                WHERE idx in (".$idx.")
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 상품 수정
        public function productUpdate($price, $stock, $pcDescription, $mobileDescription) {

            $sql = "
                UPDATE product
                SET
                    title = '".$_POST['title']."',
                    keyword = '".$_POST['keyword']."',
                    brandIdx = '".$_POST['brandIdx']."',
                    status = '".$_POST['status']."',
                    pointPercent = '".$_POST['pointPercent']."',
                    deliveryDate = '".$_POST['deliveryDate']."',
                    price = '".$price."',
                    discountPercent = '".$_POST['discountPercent']."',
                    pcDescription = '".$pcDescription."',
                    mobileDescription = '".$mobileDescription."',
                    stock = '".$stock."',
                    buyLlimit = '".$_POST['limit']."'
                WHERE
                    idx = '".$_POST['idx']."'
            ";

            if(query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 상품 카테고리 등록
        public function productCategoryInsert($type, $sort1 = "", $sort2 = "", $sort3 = "", $categoryIdx1, $categoryIdx2, $categoryIdx3, $productIdx) {

            $sql = "
                INSERT INTO productCategory
                (sort1, sort2, sort3, type, categoryIdx1, categoryIdx2, categoryIdx3, productIdx, date)
                VALUES(
                    CASE 
                        WHEN 
                            '".$sort1."' != ''
                        THEN '".$sort1."'
                        WHEN 
                            (SELECT COUNT(1) FROM productCategory as pc WHERE pc.productIdx = '".$productIdx."' AND pc.categoryIdx1 = '".$categoryIdx1."') > 0 
                        THEN (SELECT pc.sort1 FROM productCategory as pc WHERE pc.productIdx = '".$productIdx."' AND pc.categoryIdx1 = '".$categoryIdx1."' LIMIT 1) 
                        WHEN 
                            (SELECT COUNT(pc.sort1) FROM productCategory as pc WHERE pc.categoryIdx1 = '".$categoryIdx1."') = 0 
                        THEN 1
                        ELSE
                            (SELECT MAX(pc.sort1) + 1 FROM productCategory as pc WHERE pc.categoryIdx1 = '".$categoryIdx1."') 
                    END,
                    CASE 
                        WHEN 
                            '".$sort2."' != ''
                        THEN '".$sort2."'
                        WHEN 
                            '".$categoryIdx2."' = ''
                        THEN 0
                        WHEN 
                            (SELECT COUNT(1) FROM productCategory as pc WHERE pc.productIdx = '".$productIdx."' AND pc.categoryIdx2 = '".$categoryIdx2."') > 0
                        THEN (SELECT pc.sort2 FROM productCategory as pc WHERE pc.productIdx = '".$productIdx."' AND pc.categoryIdx2 = '".$categoryIdx2."' LIMIT 1)
                        WHEN 
                            (SELECT COUNT(pc.sort2) FROM productCategory as pc WHERE pc.categoryIdx2 = '".$categoryIdx2."') = 0
                        THEN 1 
                        ELSE
                            (SELECT MAX(pc.sort2) + 1 FROM productCategory as pc WHERE pc.categoryIdx2 = '".$categoryIdx2."') 
                    END,
                    CASE 
                        WHEN 
                            '".$sort3."' != ''
                        THEN '".$sort3."'
                        WHEN 
                            '".$categoryIdx3."' = ''
                        THEN 0
                        WHEN 
                            (SELECT COUNT(1) FROM productCategory as pc WHERE pc.productIdx = '".$productIdx."' AND pc.categoryIdx3 = '".$categoryIdx3."') > 0
                        THEN (SELECT pc.sort3 FROM productCategory as pc WHERE pc.productIdx = '".$productIdx."' AND pc.categoryIdx3 = '".$categoryIdx3."' LIMIT 1)
                        WHEN 
                            (SELECT COUNT(pc.sort3) FROM productCategory as pc WHERE pc.categoryIdx3 = '".$categoryIdx3."') = 0
                        THEN 1 
                        ELSE
                            (SELECT MAX(pc.sort3) + 1 FROM productCategory as pc WHERE pc.categoryIdx3 = '".$categoryIdx3."') 
                    END,
                    '".$type."',
                    '".$categoryIdx1."',
                    '".$categoryIdx2."',
                    '".$categoryIdx3."',
                    '".$productIdx."',
                    NOW()
                );
            ";

            if(query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 상품 카테고리 삭제
        public function productCategoryDelete($idx, $type = "") {

            if ($type == "main") {

                $addCategoryQuery = " AND type = 'main'";

            } else if ($type == "sub") {

                $addCategoryQuery = " AND type = 'sub'";

            }

            $sql = "
                DELETE FROM productCategory
                WHERE productIdx in (".$idx.") ".$addCategoryQuery."
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 상품 카테고리 순서 재배치
        // public function productCategorySortChange($idx, $type) {

        //     global $conn;

        //     if ($type == "main") {

        //         $addCategoryQuery = " AND type = 'main'";

        //     } else if ($type == "sub") {

        //         $addCategoryQuery = " AND type = 'sub'";

        //     }

        //     $productCategorySortChange = "
        //         UPDATE productCategory
        //         SET
        //             CASE 
        //                 WHEN 
        //                     (SELECT COUNT(1) FROM productCategory as pc WHERE pc.categoryIdx1 = '".$categoryIdx1."') > 0
        //                 THEN (SELECT pc.sort1 FROM productCategory as pc WHERE pc.productIdx = '".$productIdx."' AND pc.categoryIdx1 = '".$categoryIdx1."' LIMIT 1) 
        //                 WHEN 
        //                     (SELECT COUNT(pc.sort1) FROM productCategory as pc WHERE pc.categoryIdx1 = '".$categoryIdx1."') = 0 
        //                 THEN 1
        //                 ELSE
        //                     (SELECT MAX(pc.sort1) + 1 FROM productCategory as pc WHERE pc.categoryIdx1 = '".$categoryIdx1."') 
        //             END
        //         WHERE
        //             idx = '".$_POST['idx']."'
        //         ".$addCategoryQuery."
        //     ";

        //     if (query($productCategorySortChange)) {

        //         return "success";

        //     } else {

        //         return "error";

        //     }

        // }

        // 상품 카테고리 조회
        public function productCategorySelect($idx) {

            $sql = "
                SELECT idx, categoryIdx1, categoryIdx2, categoryIdx3, sort1, sort2, sort3, type FROM productCategory WHERE productIdx in (".$idx.") ORDER BY idx
            ";

            if ($row = loopAssocQuery($sql)) {

                return $row;

            } else {

                return "error";

            }

        }

        // 상품 옵션 등록
        public function productOptionInsert($productIdx, $title, $price, $stock) {

            $sql = "
                INSERT INTO productOption
                (productIdx, title, price, stock, soldCount, date)
                VALUES(
                    '".$productIdx."',
                    '".$title."',
                    '".$price."',
                    '".$stock."',
                    '0',
                    NOW()
                );
            ";

            if(query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 상품 옵션 삭제
        public function productOptionDelete($idx) {
    
            $sql = "
                DELETE FROM productOption
                WHERE productIdx in (".$idx.")
            ";
    
            if (query($sql)) {
    
                return "success";
    
            } else {
    
                return "error";
    
            }
    
        }

        // 상품 옵션 조회
        public function productOptionSelect($productIdx) {

            $sql = "
                SELECT title AS productOptionTitle, price AS productOptionPrice, stock AS productOptionStock FROM productOption WHERE productIdx = '".$productIdx."' ORDER BY idx
            ";

            if($row = loopAssocQuery($sql)) {

                return $row;

            } else {

                return "error";

            }

        }

        // 상품 관련 엑셀 항목 등록
        public function excelItemInsert() {

            $sql = "
                INSERT INTO ".$_POST['page']."
                (adminId, updateAdminId, date, sort, title, excelItemName, excelItem)
                VALUES(
                    '".$_SESSION['admin_id']."',
                    '".$_SESSION['admin_id']."',
                    NOW(),
                    CASE WHEN (SELECT MAX(ec.sort) + 1 FROM ".$_POST['page']." as ec) IS NULL THEN '1' ELSE (SELECT MAX(ec.sort) + 1 FROM ".$_POST['page']." as ec) END,
                    '".$_POST['title']."',
                    '".$_POST['excelItemName']."',
                    '".$_POST['excelItem']."'
                );
            ";

            if(query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 상품 관련 엑셀 항목 전체 조회
        public function excelItemSelect() {

            $sql = "
                SELECT 
                    column_name,
                    column_comment 
                FROM information_schema.columns 
                WHERE table_name = 'product'";

            if ($row = loopAssocQuery($sql)) {

                return $row;

            } else {

                return "error";

            }
    
        }

        // 상품공통설정 조회
        public function productCofigSelect() {

            $sql = "
                SELECT
                    deliveryMinPrice, 
                    deliveryPrice, 
                    deliveryDate, 
                    reviewPoint, 
                    photoReviewPoint, 
                    videoReviewPoint 
                FROM config
            ";

            if ($row = assocQuery($sql)) {

                return $row;

            } else {

                return "error";

            }
    
        }

        // 상품공통설정 수정
        public function productCofigModify($deliveryMinPrice, $deliveryPrice) {

            $sql = "
                UPDATE config
                SET
                    deliveryMinPrice = '".$deliveryMinPrice."',
                    deliveryPrice = '".$deliveryPrice."',
                    deliveryDate = '".$_POST['deliveryDate']."',
                    reviewPoint = '".$_POST['reviewPoint']."',
                    photoReviewPoint = '".$_POST['photoReviewPoint']."',
                    videoReviewPoint = '".$_POST['videoReviewPoint']."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }
    
        }

    }

?>