<?php

    // 쿠폰
    class CouponService {

        // 모든 쿠폰 조회
        public function couponSelect () {

            $sql = "
                SELECT * FROM coupon
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 회원별 다운로드된 쿠폰 조회
        public function couponDownloadSelect ($userNo) {

            $sql = "
                SELECT 
                    cd.*,
                    c.couponName,
                    c.deadline,
                    c.couponUseDesc
                FROM couponDownload AS cd 
                INNER JOIN coupon AS c 
                ON cd.couponNo = c.couponNo
                WHERE 
                    cd.userNo = '".$userNo."' 
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 사용 가능한 쿠폰 다운로드 조회
        public function ableCouponDownloadSelect ($userNo, $totalPrice) {

            $sql = "
                SELECT 
                    cd.*,
                    c.couponName
                FROM couponDownload AS cd 
                INNER JOIN coupon AS c 
                ON cd.couponNo = c.couponNo
                WHERE 
                    cd.userNo = '".$userNo."' 
                AND 
                    cd.minPrice < '".$totalPrice."' 
                AND 
                    cd.used = 'N'
            ";

            $row = loopAssocQuery($sql);

            return $row;

        }

        // 특정 다운로드 쿠폰 조회
        public function couponDownloadDetailSelect ($couponIdx, $userNo) {

            $sql = "
                SELECT 
                    c.maxPrice
                FROM couponDownload AS cd 
                INNER JOIN coupon AS c 
                ON cd.couponNo = c.couponNo
                WHERE 
                    c.idx = '".$couponIdx."' 
                AND 
                    cd.userNo = '".$userNo."' 
                AND 
                    cd.used = 'N' 
                AND 
                    cd.usedOrderNo = '' 
                AND 
                    CASE
                        WHEN
                            SUBSTRING_INDEX(SUBSTRING_INDEX(c.deadline, '◈', 2), '◈', -1) = 'y'
                        THEN
                            DATE_ADD(cd.date, interval +SUBSTRING_INDEX(SUBSTRING_INDEX(deadline, '◈', 1), '◈', -1) year)
                        WHEN
                            SUBSTRING_INDEX(SUBSTRING_INDEX(c.deadline, '◈', 2), '◈', -1) = 'm'
                        THEN
                            DATE_ADD(cd.date, interval +SUBSTRING_INDEX(SUBSTRING_INDEX(deadline, '◈', 1), '◈', -1) month)
                        ELSE
                            DATE_ADD(cd.date, interval +SUBSTRING_INDEX(SUBSTRING_INDEX(deadline, '◈', 1), '◈', -1) day)
                    END > NOW()
            ";

            $row = assocQuery($sql);

            return $row;

        }

        // 쿠폰 다운로드 등록
        public function couponDownloadInsert ($userNo, $couponNo, $discountPrice, $discountPercent, $minPrice, $maxPrice) {

            $sql = "
                INSERT INTO couponDownload
                    (userNo, couponNo, discountPrice, discountPercent, minPrice, maxPrice, used, usedOrderNo, usedDate, date)
                    VALUES(
                        '".$userNo."',
                        '".$couponNo."',
                        '".$discountPrice."',
                        '".$discountPercent."',
                        '".$minPrice."',
                        '".$maxPrice."',
                        'N',
                        '',
                        '0000-00-00 00:00:00',
                        NOW()
                    );
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 쿠폰 다운로드 사용처리 업데이트
        public function couponDownloadUpdate ($orderNo, $userNo, $couponNo) {

            $sql = "
                UPDATE couponDownload
                SET
                    used = 'Y',
                    usedOrderNo = '".$orderNo."',
                    usedDate = NOW()
                WHERE
                    idx = '".$couponNo."'
                AND
                    userNo = '".$userNo."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

        // 사용쿠폰 조회
        public function usedCouponSelect ($userNo, $orderNo) {

            $sql = "
                SELECT 
                    idx
                FROM couponDownload
                WHERE 
                    usedOrderNo = '".$orderNo."'
                AND
                    userNo = '".$userNo."'
            ";

            $row = assocQuery($sql);

            return $row;

        }

        // 쿠폰 복구 업데이트
        public function couponDownloadRestoreUpdate ($couponIdx) {

            $sql = "
                UPDATE couponDownload
                SET
                    used = 'N',
                    usedOrderNo = '',
                    usedDate = NULL
                WHERE
                    idx = '".$couponIdx."'
            ";

            if (query($sql)) {

                return "success";

            } else {

                return "error";

            }

        }

    }

?>