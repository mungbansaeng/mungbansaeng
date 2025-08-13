<?php

    // 상품 페이지
    class ProductService {

        // 총 상품 갯수 조회
        public function productCount () {

            if ($_POST["categoryIdx1"] && $_POST["categoryIdx2"] == "" && $_POST["categoryIdx3"] == "") {

                $addQuery = " AND pc.categoryIdx1 = '".$_POST["categoryIdx1"]."'";

            } else if ($_POST["categoryIdx2"] && $_POST["categoryIdx3"] == "") {

                $addQuery = " AND pc.categoryIdx1 = '".$_POST["categoryIdx1"]."' AND pc.categoryIdx2 = '".$_POST["categoryIdx2"]."'";

                $addQuery .= " LIMIT 1";

            } else if ($_POST["categoryIdx3"]) {

                $addQuery = " AND pc.categoryIdx1 = '".$_POST["categoryIdx1"]."' AND pc.categoryIdx2 = '".$_POST["categoryIdx2"]."' AND pc.categoryIdx3 = '".$_POST["categoryIdx3"]."'";

            }

            if ($_POST['page'] == "best") {

                $addQuery = " ORDER BY p.soldCount DESC, p.date DESC LIMIT 12";

            }

            $sql = "
                SELECT 
                    COUNT(p.idx) AS totalCount
                FROM product AS p
                INNER JOIN productCategory AS pc
                ON p.idx = pc.productIdx
                WHERE 
                    p.showYn = 'Y'
                    $addQuery
            ";

            $row = assocQuery($sql);

            return $row;

        }

        // 상품 리스트 조회
        public function productListSelect () {

            if ($_POST['page'] == "best") {

                $addQuery = " AND pc.type = 'main' ORDER BY p.soldCount DESC, p.date DESC LIMIT 12";

            } else {

                if ($_POST["categoryIdx1"] && $_POST["categoryIdx2"] == "" && $_POST["categoryIdx3"] == "") {

                    $addQuery = " AND pc.categoryIdx1 = '".$_POST["categoryIdx1"]."'";

                } else if ($_POST["categoryIdx2"] && $_POST["categoryIdx3"] == "") {

                    $addQuery = " AND pc.categoryIdx1 = '".$_POST["categoryIdx1"]."' AND pc.categoryIdx2 = '".$_POST["categoryIdx2"]."'";

                } else if ($_POST["categoryIdx3"]) {

                    $addQuery = " AND pc.categoryIdx1 = '".$_POST["categoryIdx1"]."' AND pc.categoryIdx2 = '".$_POST["categoryIdx2"]."' AND pc.categoryIdx3 = '".$_POST["categoryIdx3"]."'";

                }

                $addQuery .= " ORDER BY p.date DESC LIMIT ".$_POST['limitStart'].", ".$_POST['limitEnd'];

            }

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
                INNER JOIN productCategory AS pc
                ON p.idx = pc.productIdx
                WHERE 
                    p.showYn = 'Y'
                    ".$addQuery."
            ";
            
            $row = loopAssocQuery($sql);

            return $row;

        }

        // 상품 상세 조회
        public function productDetailSelect ($productCode) {

            $sql = "
                SELECT 
                    p.idx,
                    p.title,
                    p.status,
                    p.price,
                    p.discountPercent,
                    p.stock,
                    p.reviewStar,
                    p.reviewCount,
                    p.pcDescription,
                    p.mobileDescription,
                    puf.fileName
                FROM product AS p
                INNER JOIN productUploadFile AS puf
                ON p.idx = puf.boardIdx
                WHERE 
                    p.productCode = '".$productCode."'
                AND
                    p.showYn = 'Y'
            ";
            
            $row = assocQuery($sql);

            return $row;

        }

        // 상품 옵션 조회
        public function productOptionSelect ($idx) {

            $sql = "
                SELECT 
                    po.idx,
                    po.title,
                    po.price,
                    po.stock
                FROM productOption AS po
                WHERE 
                    po.productIdx = '".$idx."'
                ORDER BY po.price
            ";
            
            $row = loopAssocQuery($sql);

            return $row;

        }

        // 옵션 상세 조회
        public function optionSelect ($idx) {

            $sql = "
                SELECT 
                    po.idx,
                    po.title,
                    po.price,
                    po.stock
                FROM productOption AS po
                WHERE 
                    po.idx = '".$idx."'
            ";
            
            $row = assocQuery($sql);

            return $row;

        }

        // 상품 업데이트
        public function orderProductUpdate ($productCode) {

            $sql = "
                UPDATE product
                SET
                    stock = 
                        CASE
                            WHEN
                                stock = -1
                            THEN
                                -1
                            ELSE
                                stock - 1
                        END,
                    status = 
                        CASE
                            WHEN
                                stock = 0
                            THEN
                                status + 200
                            ELSE
                                status + 0
                        END,
                    soldCount = soldCount + 1
                WHERE
                    productCode = '".$productCode."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 상품 옵션 업데이트
        public function orderProductOptionUpdate ($optionIdx) {

            $sql = "
                UPDATE productOption
                SET
                    stock = 
                        CASE
                            WHEN
                                stock = -1
                            THEN
                                -1
                            ELSE
                                stock - 1
                        END,
                    soldCount = soldCount + 1
                WHERE
                    idx = '".$optionIdx."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 주문 취소시 상품 업데이트
        public function productCancelUpdate ($productCode) {

            $sql = "
                UPDATE product
                SET
                    stock = 
                        CASE
                            WHEN
                                stock = -1
                            THEN
                                -1
                            ELSE
                                stock + 1
                        END,
                        soldCount = soldCount - 1
                WHERE
                    productCode = '".$productCode."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 주문 취소시 상품 옵션 업데이트
        public function productOptionCancelUpdate ($optionIdx) {

            $sql = "
                UPDATE productOption
                SET
                    stock = 
                        CASE
                            WHEN
                                stock = -1
                            THEN
                                -1
                            ELSE
                                stock + 1
                        END,
                    soldCount = soldCount - 1
                WHERE
                    idx = '".$optionIdx."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 상품 업데이트
        public function productStatusUpdate ($idx) {

            $sql = "
                UPDATE product
                SET
                    status = status - 200
                WHERE
                    idx = '".$idx."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 상품 업데이트
        public function productReviewInfoUpdate ($productCode) {

            $sql = "
                UPDATE product
                SET
                    reviewStar = reviewStar + ".$_POST['reviewStar'].",
                    reviewCount = reviewCount + 1
                WHERE
                    productCode = '".$productCode."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 상품문의 등록
        public function productQnaReg($userNo, $productCode, $productQnaDescription) {

            $sql = "
                INSERT INTO productQna
                (userNo, productCode, description, date)
                VALUES(
                    '".$userNo."',
                    '".$productCode."',
                    '".$productQnaDescription."',
                    NOW()
                );
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }
    
        }

        // 상품문의 조회
        public function productQnaSelect($productCode) {

            $sql = "
                SELECT 
                    pq.description,
                    m.id
                FROM productQna AS pq
                INNER JOIN member AS m
                ON pq.userNo = m.idx
                WHERE 
                    pq.productCode = '".$productCode."'
                AND
                    pq.showYn = 'Y'
                ORDER BY pq.date DESC
            ";

            $row = loopAssocQuery($sql);

            return $row;
    
        }

    }

?>