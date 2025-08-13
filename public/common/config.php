<?php

    session_start();

    // 데이터 베이스 연결
    $db_host = "127.0.0.1";
    $db_user = "nconnet";
    $db_password = "Dkakwhs!2";
    $db_name = "nconnet";
    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

    // if (mysqli_connect_errno($conn)) {
    //     echo "데이터베이스 연결 실패: " . mysqli_connect_error();
    // }else {
    //     echo "데이터베이스 연결 성공!!";
    // }

    // public src 모음    
    $publicCssSrc = "/public/resources/css";// public scc src
    $publicJsSrc = "/public/resources/js";// public js src
    $publicPluginSrc = "/public/resources/plugin";// public plugin src
    $publicImgSrc = "/public/resources/images";// public img src

    // admin src 모음    
    $adminSrc = "/admin/view";// front 퍼블 링크

    $adminCssSrc = "/admin/resources/css";// admin scc src
    $adminJsSrc = "/admin/resources/js";// admin js src
    $adminPluginSrc = "/admin/resources/plugin";// admin plugin src
    $adminImgSrc = "/admin/resources/images";// admin img src
    $adminUploadSrc = "/admin/resources/upload";// admin upload src

    $adminLayoutsSrc = "/admin/view/layouts";// admin layouts src

    // front src 모음    
    $frontSrc = "/front/view";// front 퍼블 링크

    $frontCssSrc = "/front/resources/css";// front scc src
    $frontJsSrc = "/front/resources/js";// front js src
    $frontPluginSrc = "/front/resources/plugin";// front plugin src
    $frontImgSrc = "/front/resources/images";// front img src
    $frontUploadSrc = "/front/resources/upload";// front upload src
    
    $frontPwaSrc = "/front/pwa";// front pwa src
    $frontPwaImgSrc = "/front/pwa/images";// front pwa img src
    $frontLayoutsSrc = "/front/view/layouts";// front layouts src

    // 공통변수 모음

    /* 전역변수 */

    $adminStartFolder = "admin";

    /* 현재 페이지 */

    $nowPage = basename($_SERVER['PHP_SELF']);

    $nowPageArr = explode(".", $nowPage);

    $nowPageName = $nowPageArr[0];

    /* 현재 언어 폴더 */

    $pageUrl = $_SERVER['PHP_SELF'];

    $pageUrlArr = explode("/", $pageUrl);

    $NowFolder = $pageUrlArr[1]; // 현재 폴더

    if($NowFolder == "admin"){

        $NowLangPage = $_GET['root'];

    }else{

        $NowLangPage = $NowFolder;

    }

    // 쿼리
    function query($sql) {

        global $conn;

        $result = mysqli_query($conn, $sql);

        return $result;

    }

    function arrayQuery($sql) {

        global $conn;

        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($result);

        return $row;

    }

    function assocQuery($sql) {

        global $conn;
        
        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_assoc($result);

        return $row;

    }

    function numQuery($sql) {

        global $conn;
        
        $result = mysqli_query($conn, $sql);

        $row = mysqli_num_rows($result);

        return $row;

    }

    function loopAssocQuery($sql) {

        global $conn;

        $loopArray = array();
        
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)){

            array_push($loopArray, $row);

        };

        return $loopArray;

    }

    function loopRowQuery($sql) {

        global $conn;

        $loopArray = array();
        
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_row($result)){

            array_push($loopArray, $row);

        };

        return $loopArray;

    }

    function loopArrayQuery($sql) {

        global $conn;

        $loopArray = array();
        
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_array($result)){

            array_push($loopArray, $row);

        };

        return $loopArray;

    }

    // 공통 함수 모음

    /* 숫자만 추출 */

    function numberOnly($parameter){

        $number = preg_replace("/[^0-9]*/s", "", $parameter); 

        return $number;

    }

    /* 문자만 추출 */

    function textOnly($parameter){

        $text = preg_replace("/[0-9]/","", $parameter);

        return $text;

    }

    /* 랜덤값 생성 */
    
    function GenerateString($length){ 

        // $characters  = "0123456789";  
        // $characters .= "abcdefghijklmnopqrstuvwxyz";
        $characters .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";  
        // $characters .= "_";  

        $string_generated = "";  

        $nmr_loops = $length;  
        while ($nmr_loops--){  
            $string_generated .= $characters[mt_rand(0, strlen($characters) - 1)];  
        }  

        return $string_generated;

    }

    // 게시글 자동 오픈

    $listId = 0;

    if ($_GET['limitStart']) {

        $limitStart = (int)$_GET['limitStart'];

    } else {

        $limitStart = 0;

    }

    $boardOpenNum = (int)$_GET['boardOpenNum'];

    $showBoardNum = (int)$_GET['showBoardNum'];
        
    // 아이피 체크
    if ($_SERVER['HTTP_CLIENT_IP']) {

        $userIp = $_SERVER['HTTP_CLIENT_IP'];

    } else if($_SERVER['HTTP_X_FORWARDED_FOR']) {

        $userIp = $_SERVER['HTTP_X_FORWARDED_FOR'];

    } else if($_SERVER['HTTP_X_FORWARDED']) {

        $userIp = $_SERVER['HTTP_X_FORWARDED'];

    } else if($_SERVER['HTTP_FORWARDED_FOR']) {

        $userIp = $_SERVER['HTTP_FORWARDED_FOR'];

    } else if($_SERVER['HTTP_FORWARDED']) {

        $userIp = $_SERVER['HTTP_FORWARDED'];

    } else if($_SERVER['REMOTE_ADDR']) {

        $userIp = $_SERVER['REMOTE_ADDR'];

    } else {

        $userIp = 'Unknown';

    }

    // 로그인 체크
    if ($_SESSION['userNo']) { // 회원

        $userNo = $_SESSION['userNo'];

    } else if ($_SESSION['admin_no']) {

        $adminNo = $_SESSION['admin_no'];

    } else { // 비회원

        $userNo = $userIp;

    }

    // 아이피로 지역 찾기

    // https://newstroyblog.tistory.com/231#Ipgelocation%20Api%20%EC%82%AC%EC%9A%A9%ED%95%98%EA%B8%B0-1

    // 레퍼러 체크

    if ($_SERVER['HTTP_REFERER'] == "" || $_SERVER['HTTP_REFERER'] == NULL) {

        $referer = 'Unknown';

    } else {

        $referer = $_SERVER['HTTP_REFERER'];

    }

    // 피씨, 모바일 체크

    $checkDevice = "/(iPad|iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

    if (preg_match($checkDevice, $_SERVER['HTTP_USER_AGENT'])) {

        $checkBrowser = "Mobile";

    } else {

        $checkBrowser = "PC";

    }

    // 날짜, 시간 모음
    $now = time();
    $date = date("Y-m-d");
    $time = date("H:i:s");
    $year = date("Y");
    $month = date("m");
    $day = date("d");
    $hours = date("H");
    $week = date("w");

    // secretKey
    $secretKey = "MbS9CWk2KpH0bpNtaCVcHtzHht4TMCZ3Vp1r0z9LCMyTxNB6yFNMCy";

    // 자동로그인
    if ($_COOKIE["al_uid"]) {

        $autoLoginUidArr = explode("◈", base64_decode($_COOKIE["al_uid"]));

        if (base64_decode($autoLoginUidArr[1]) == $secretKey) {

            $_SESSION['userNo'] = $autoLoginUidArr[0];
            $_SESSION['userId'] = $autoLoginUidArr[2];

        }

    }
        
    // 접속 로그

    // 봇 리스트
    $checkBot = "/(Yeti|YandexBot|Googlebot|Cowbot|NaverBot|Daum|Daumoa|TechnoratiSnoop|Allblog\.net|CazoodleBot|nhn\/1noon|Feedfetcher\-Google|Yahoo\! Slurp|msnbot|bingbot|MSNBot|Technoratibot|sproose|CazoodleBot|ONNET\-OPENAPI|UCLA CS Dept|Snapbot|DAUM RSS Robot|RMOM|S20 Wing|FeedBurner|xMind|openmaru feed aggregator|ColFeed|MJ12bot|Twiceler|ia_archiver|BingPreview|NetcraftSurveyAgent|Bot|bot)/";

?>