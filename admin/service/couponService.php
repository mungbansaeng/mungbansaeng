<?php

    // 쿠폰
    class CouponService {

        // 쿠폰 등록
        public function couponInsert($couponNo, $discountPrice, $minPrice, $maxPrice, $deadline, $couponUseDesc, $newViewDesc, $adminNo) {

            $sql = "
                INSERT INTO coupon
                (couponNo, couponName, couponType, couponDownLocation, discountPrice, discountPercent, minPrice, maxPrice, publishType, publishTypeNum, couponLimit, couponLimitNum, deadline, couponUseDesc, description, status, date, regUserNo)
                VALUES(
                    '".$couponNo."',
                    '".$_POST['couponName']."',
                    '".$_POST['couponType']."',
                    '".$_POST['couponDownLocation']."',
                    '".$discountPrice."',
                    '".$_POST['discountPercent']."',
                    '".$minPrice."',
                    '".$maxPrice."',
                    '".$_POST['publishType']."',
                    '".$_POST['publishTypeNum']."',
                    '".$_POST['couponLimit']."',
                    '".$_POST['couponLimitNum']."',
                    '".$deadline."',
                    '".$couponUseDesc."',
                    '".$newViewDesc."',
                    '".$_POST['status']."',
                    NOW(),
                    '".$adminNo."'
                );
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }
    
        }

        // 쿠폰 리스트 카운트
        public function couponListCountSelect () {

            $sql = "
                SELECT
                    COUNT(idx) AS totalCount
                FROM coupon
            ";

            $row = assocQuery($sql);

            return $row;

        }
        
        // 쿠폰 리스트 조회
        public function couponListSelect() {

            $sql = "
                SELECT 
                    idx,
                    couponNo,
                    couponName,
                    deadline,
                    CASE
                        WHEN status = '100'
                        THEN '정상'
                        ELSE '마감'
                    END AS status,
                    date
                FROM coupon
            ";

            $row = loopAssocQuery($sql);

            return $row;
    
        }
        
        // 쿠폰 상세 조회
        public function couponSelect() {

            $sql = "
                SELECT 
                    idx,
                    couponNo,
                    couponName,
                    status,
                    couponType,
                    couponDownLocation,
                    discountPrice,
                    discountPercent,
                    minPrice,
                    maxPrice,
                    deadline,
                    publishType,
                    publishTypeNum,
                    couponLimit,
                    couponLimitNum,
                    couponUseDesc,
                    description,
                    date
                FROM coupon
                WHERE
                    couponNo = '".$_POST['couponNo']."'
            ";

            $row = assocQuery($sql);

            return $row;
    
        }

        // 쿠폰 수정
        public function couponUpdate($discountPrice, $minPrice, $maxPrice, $deadline, $couponUseDesc, $newViewDesc, $adminNo) {

            $sql = "
                UPDATE coupon
                SET
                    couponName = '".$_POST['couponName']."',
                    status = '".$_POST['status']."',
                    couponType = '".$_POST['couponType']."',
                    couponDownLocation = '".$_POST['couponDownLocation']."',
                    discountPrice = '".$discountPrice."',
                    discountPercent = '".$_POST['discountPercent']."',
                    minPrice = '".$minPrice."',
                    maxPrice = '".$maxPrice."',
                    publishType = '".$_POST['publishType']."',
                    publishTypeNum = '".$_POST['publishTypeNum']."',
                    couponLimit = '".$_POST['couponLimit']."',
                    couponLimitNum = '".$_POST['couponLimitNum']."',
                    deadline = '".$deadline."',
                    couponUseDesc = '".$couponUseDesc."',
                    description = '".$newViewDesc."',
                    modifyUserNo = '".$adminNo."',
                    modifyDate = NOW()
                WHERE
                    couponNo = '".$_POST['couponNo']."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 쿠폰 삭제
        public function couponDelete($idx) {

            $sql = "
                DELETE FROM coupon
                WHERE idx in (".$idx.")
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

    }

?>