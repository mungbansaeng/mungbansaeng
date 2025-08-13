<?php

    // ajax로 넘어오는 데이터 $page로 통일시키기

    if ($_POST['page']) {

        $page = $_POST['page'];

    }

    if ($_POST["act"]) { // 등록, 수정, 삭제일때 포함

        include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";
        include_once dirname(dirname(dirname(__FILE__)))."/front/service/memberService.php";
        include_once dirname(dirname(dirname(__FILE__)))."/front/service/orderService.php";
        include_once dirname(dirname(dirname(__FILE__)))."/front/service/mypageService.php";
        // include_once dirname(dirname(dirname(__FILE__)))."/public/controller/adminLogController.php";

    }

    include_once dirname(dirname(dirname(__FILE__)))."/front/service/productService.php";

    $productService = new ProductService();
    $memberService = new MemberService();
    $orderService = new OrderService();
    $mypageService = new MypageService();

    $result = array("success");

    try {

        if ($_POST["act"] == "list") {

            // 상품 갯수 카운트
            $productCount = $productService -> productCount();

            array_push($result, $productCount);

            // 상품 리스트 조회
            $productList = $productService -> productListSelect();

            array_push($result, $productList);

        } else if ($_POST["act"] == "view") {

            // 상품 조회
            $productDetailSelect = $productService -> productDetailSelect($_POST['productCode']);

            array_push($result, $productDetailSelect);

            // 상품 옵션 조회
            $productOptionSelect = $productService -> productOptionSelect($productDetailSelect['idx']);

            array_push($result, $productOptionSelect);

            // 회원 조회
            $member = $memberService -> memberSelect($_SESSION['userNo']);

            array_push($result, $member);

            // 좋아요 조회
            $wishSelect = $orderService -> wishSelect($userNo);

            array_push($result, $wishSelect);

            // 상품후기 조회
            $reviewDetailSelect = $mypageService -> productReviewSelect($_POST['productCode']);

            array_push($result, $reviewDetailSelect);

            // 상품문의 조회
            $productQnaSelect = $productService -> productQnaSelect($_POST['productCode']);

            array_push($result, $productQnaSelect);

        }

        echo json_encode($result);

    } catch (Exception $errorMsg) {

        echo $errorMsg;

        exit;

    }

    // 상품
    // try{
                    
    //     $productService = new ProductService();

    //     // 상품 카운트
    //     $totlaCount = $productService -> productCount();

    //     // return $totlaCount;
        
    //     // 상품 리스트
    //     if(strpos($_SERVER['PHP_SELF'], "productList")){

    //         $productArray = array(); // service에서 받아온 데이터 넣을 배열
    //         $productList = array(); // fo에 사용할 배열

    //         // 상품 리스트            
    //         $productService = new ProductService();
    //         $productArray = $productService -> productList($productListSql);
    
    //         // fo에 필요하게 데이터 수정
    //         for($mr=0; $mr < COUNT($productArray); $mr++){
    
    //             if($productArray[$mr]['fileName'] == ''){
            
    //                 $fileDir = $frontImgSrc."/common/noimage.jpg";
                    
    //             }else{
        
    //                 $imgDir = $frontUploadSrc.$productArray[$mr]['fileName']."";
        
    //                 $imgData = exif_read_data($imgDir);
        
    //                 if($imgData['Orientation'] == "2"){
        
    //                     $imageSource = imagecreatefromjpeg($imgDir);
    //                     $flipImage = imageflip($imageSource, IMG_FLIP_HORIZONTAL);
    //                     $fileDir = imagejpeg($flipImage, $imgDir);
        
    //                 }else if($imgData['Orientation'] == "3"){
        
    //                     $imageSource = imagecreatefromjpeg($imgDir);
    //                     $rotateImage = imagerotate($imageSource, 180, 0);
    //                     $fileDir = imagejpeg($rotateImage, $imgDir);
        
    //                 }else if($imgData['Orientation'] == "4"){
        
    //                     $imageSource = imagecreatefromjpeg($imgDir);
    //                     $flipImage = imageflip($imageSource, IMG_FLIP_VERTICAL);
    //                     $fileDir = imagejpeg($flipImage, $imgDir);
        
    //                 }else if($imgData['Orientation'] == "5"){
        
    //                     $imageSource = imagecreatefromjpeg($imgDir);
    //                     $rotateImage = imagerotate($imageSource, -90, 0);
    //                     $flipImage = imageflip($rotateImage, IMG_FLIP_HORIZONTAL);
    //                     $fileDir = imagejpeg($flipImage, $imgDir);
        
    //                 }else if($imgData['Orientation'] == "6"){
        
    //                     $imageSource = imagecreatefromjpeg($imgDir);
    //                     $rotateImage = imagerotate($imageSource, -90, 0);
    //                     $fileDir = imagejpeg($rotateImage, $imgDir);
        
    //                 }else if($imgData['Orientation'] == "7"){
        
    //                     $imageSource = imagecreatefromjpeg($imgDir);
    //                     $rotateImage = imagerotate($imageSource, 90, 0);
    //                     $flipImage = imageflip($rotateImage, IMG_FLIP_HORIZONTAL);
    //                     $fileDir = imagejpeg($flipImage, $imgDir);
        
    //                 }else if($imgData['Orientation'] == "8"){
        
    //                     $imageSource = imagecreatefromjpeg($imgDir);
    //                     $rotateImage = imagerotate($imageSource, 90, 0);
    //                     $fileDir = imagejpeg($rotateImage, $imgDir);
        
    //                 }
        
    //                 $fileDir = $frontUploadSrc."/".$productArray[$mr]['fileName'];
                    
    //             }
        
    //             $soldOut = "N";
        
    //             if($productArray[$mr]['stock'] == 0 && $productArray[$mr]['optionStock'] == NULL){ // 옵션 없는 상품 재고
        
    //                 $soldOut = "Y";
        
    //             }else if($productArray[$mr]['stock'] == 0 && $productArray[$mr]['optionStock'] == 0){ // 옵션 있는 상품 재고
        
    //                 $soldOut = "Y";
        
    //             }
        
    //             $reviewStarPer = $productArray[$mr]['reviewStar'] / $productArray[$mr]['reviewCount'];
        
    //             $rankCount = $mr + $_GET['limitStart'] + 1;
                
    //             array_push($productList,
    //                 [
    //                     "boardFolder" => $productArray[$mr]['boardFolder'],
    //                     "boardCode" => $productArray[$mr]['boardCode'],
    //                     "boardCate" => $productArray[$mr]['boardCate'],
    //                     "root" => $productArray[$mr]['root'],
    //                     "idx" => $productArray[$mr]['idx'],
    //                     "productListThumb" => $fileDir,
    //                     "rankCount" => $rankCount,
    //                     "soldOut" => $soldOut,
    //                     "reviewStarPer" => $reviewStarPer,
    //                     "productTitle" => $productArray[$mr]['productTitle'],
    //                     "price" => $productArray[$mr]['price']
    
    //                 ]
    //             );
    
    //         }
    
    //         return $productList;
    
    //         // echo "<pre>";
    //         // print_r($mungRankInfo);
    //         // echo "</pre>";

    //     }
        
    //     // 상품 뷰 페이지
    //     if(strpos($_SERVER['PHP_SELF'], "view")){

    //         $productView = array(); // service에서 받아온 데이터 넣을 배열

    //         $productViewService = new ProductViewService();
    //         $productView = $productViewService -> productView($productViewSql);

    //         if($productView[0]['fileName'] == ''){
                                    
    //             $fileDir = "/common/noimage.jpg";
                
    //         }else{

    //             $imgDir = "../../upload/".$productView[0]['fileName']."";

    //             $imgData = exif_read_data($imgDir);

    //             if($imgData['Orientation'] == "2"){

    //                 $imageSource = imagecreatefromjpeg($imgDir);
    //                 $flipImage = imageflip($imageSource, IMG_FLIP_HORIZONTAL);
    //                 $fileDir = imagejpeg($flipImage, $imgDir);

    //             }else if($imgData['Orientation'] == "3"){

    //                 $imageSource = imagecreatefromjpeg($imgDir);
    //                 $rotateImage = imagerotate($imageSource, 180, 0);
    //                 $fileDir = imagejpeg($rotateImage, $imgDir);

    //             }else if($imgData['Orientation'] == "4"){

    //                 $imageSource = imagecreatefromjpeg($imgDir);
    //                 $flipImage = imageflip($imageSource, IMG_FLIP_VERTICAL);
    //                 $fileDir = imagejpeg($flipImage, $imgDir);

    //             }else if($imgData['Orientation'] == "5"){

    //                 $imageSource = imagecreatefromjpeg($imgDir);
    //                 $rotateImage = imagerotate($imageSource, -90, 0);
    //                 $flipImage = imageflip($rotateImage, IMG_FLIP_HORIZONTAL);
    //                 $fileDir = imagejpeg($flipImage, $imgDir);

    //             }else if($imgData['Orientation'] == "6"){

    //                 $imageSource = imagecreatefromjpeg($imgDir);
    //                 $rotateImage = imagerotate($imageSource, -90, 0);
    //                 $fileDir = imagejpeg($rotateImage, $imgDir);

    //             }else if($imgData['Orientation'] == "7"){

    //                 $imageSource = imagecreatefromjpeg($imgDir);
    //                 $rotateImage = imagerotate($imageSource, 90, 0);
    //                 $flipImage = imageflip($rotateImage, IMG_FLIP_HORIZONTAL);
    //                 $fileDir = imagejpeg($flipImage, $imgDir);

    //             }else if($imgData['Orientation'] == "8"){

    //                 $imageSource = imagecreatefromjpeg($imgDir);
    //                 $rotateImage = imagerotate($imageSource, 90, 0);
    //                 $fileDir = imagejpeg($rotateImage, $imgDir);

    //             }

    //             $fileDir = $frontUploadSrc."/".$productView[0]['fileName'];
                
    //         }

    //         $productTitle = $productView[0]['productTitle'];

    //         $price = $productView[0]['price'];

    //         $discountPrice = $price * ((100 - $productView[0]['discountPercent']) / 100);

    //         $roundDiscountPrice = round($discountPrice, -2); // 10원 단위에서 반올림

    //         $point = $discountPrice * ($config['pointPercent'] / 100);

    //         $reviewStarPer = $productView[0]['reviewStar'] / $productView[0]['reviewCount'];

    //         $productCode = $productView[0]['productCode'];

    //         $discountPercent = $productView[0]['discountPercent'];

    //         $brief = $productView[0]['brief'];

    //         // 옵션 유무 체크
    //         $isOption = COUNT($productView[0]['optionIdx']);

    //         print_r($productView);

    //     }

    // }catch(Exception $errorMsg){

    //     echo "<pre>";
    //     echo $errorMsg;
    //     echo "</pre>";

    //     exit;

    // }

?>