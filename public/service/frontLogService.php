<?php

    // 로그 
    class FrontLogService {

        // 주문 로그 등록
        public function orderLogInsert($userNo, $data, $event, $startPage, $destination, $result) {

            $sql = "
                INSERT INTO orderLog 
                (userNo, data, event, startPage, destination, result, date) 
                VALUES(
                    '".$userNo."',
                    '".$data."',
                    '".$event."',
                    '".$startPage."',
                    '".$destination."',
                    '".$result."',
                    NOW()
                )
            ";
            
            $row = query($sql);

        }

    }

?>