<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/public/common/config.php";
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/controller/commonController.php";
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/controller/accessLogController.php"; // 접속 로그

?>
<!DOCTYPE html>
<html lang="ko">
<head>

    <title><?=$meta['siteTit']?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0, minimum-scale=1.0, width=device-width">
    <meta name="format-detection" content="telephone=no, address=no, email=no">
    <meta name="generator" content="vscode">
    <meta name="keywords" content="<?=$meta['siteKeyword']?>">
    <meta name="description" content="<?=$meta['siteDescription']?>">
    <meta name="naver-site-verification" content="<?=$meta['naverVerification']?>">
    <meta property="og:url" content="<?=$meta['siteUrl']?>">
    <meta property="og:title" content="<?=$meta['siteTit']?>">
    <meta property="og:description" content="<?=$meta['siteDescription']?>">
    <meta property="og:site_name" content="<?=$meta['siteTit']?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="/images/common/thum_logo.jpg">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="canonical" href="<?=$meta['siteUrl']?>">
    <link rel="shortcut icon" href="<?=$publicImgSrc?>/favicon.ico">


    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?=$publicCssSrc?>/fonts.css?v=241219" media="all">
    <link rel="stylesheet" type="text/css" href="<?=$publicCssSrc?>/base.css?v=241219" media="all">
    <link rel="stylesheet" type="text/css" href="<?=$frontCssSrc?>/style.css?v=241219" media="all">
    <link rel="stylesheet" type="text/css" href="<?=$frontCssSrc?>/mediaquery.css?v=241220" media="all">
    <link rel="stylesheet" type="text/css" href="<?=$frontCssSrc?>/swiper.min.css" media="all">
    <link rel="stylesheet" type="text/css" href="<?=$frontCssSrc?>/swiper-bundle.css" media="all">
    <!-- <link rel="stylesheet" type="text/css" href="<?=$frontCssSrc?>/aos.css" media="all"> -->

    <!-- lottiefiles js -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.14/lottie.min.js" integrity="sha512-G1R66RZMhyLDEcAu92/Kv4sWNypnEiJcM6yhe0PNyiYDaMAKpMrJ6ZLR67xC/RMNGRa8Pm9TxtO8a98F6Ct+Gw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- JS -->
    <script type="text/javascript" src="<?=$publicPluginSrc?>/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="<?=$publicPluginSrc?>/daumPost.js"></script>
    <script type="text/javascript" src="<?=$publicPluginSrc?>/jquery-ui.js"></script>
    <script type="text/javascript" src="<?=$publicPluginSrc?>/datapicker.js"></script>
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    
    <script type="text/javascript" src="<?=$frontJsSrc?>/style.js?v=241118"></script>
    <script type="text/javascript" src="<?=$frontPluginSrc?>/swiper.min.js"></script>
    <script type="text/javascript" src="<?=$frontPluginSrc?>/swiper-bundle.js"></script>
    <script type="text/javascript" src="<?=$frontPluginSrc?>/aos.js"></script>
    <!-- <script src="https://kit.fontawesome.com/164b8f0776.js" crossorigin="anonymous"></script> 삭제예정 -->
    <!-- <script type="text/javascript" src="/front/resources/libs/libs.js"></script> 삭제예정 -->
    <!-- <script type="text/javascript" src="/front/resources/libs/datapicker.js"></script> 삭제예정 -->
    <!-- <script type="text/javascript" src="<?=$frontPluginSrc?>/ckeditor.js"></script> -->

    <script type="text/javascript" src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>

    <!-- crypto js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/hmac-sha256.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/components/enc-base64-min.js'></script>
    
    <!-- PWA -->

    <meta name="theme-color" content="#ffffff">
    <link rel="manifest" href="<?=$frontPwaSrc?>/manifest.json">

    <!-- PWA for ios -->

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="<?=$config['companyName']?>">
    <link rel="apple-touch-icon" href="<?=$frontPwaImgSrc?>/icon_152.png" media="all">
    <link rel="apple-touch-icon" sizes="128x128" href="<?=$frontPwaImgSrc?>/icon_128.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=$frontPwaImgSrc?>/icon_144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=$frontPwaImgSrc?>/icon_152.png">
    <link rel="apple-touch-icon" sizes="192x192" href="<?=$frontPwaImgSrc?>/icon_192.png">
    <link rel="apple-touch-icon" sizes="256x256" href="<?=$frontPwaImgSrc?>/icon_256.png">
    <link rel="apple-touch-icon" sizes="512x512" href="<?=$frontPwaImgSrc?>/icon_512.png">

    <!-- //PWA for ios -->

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="<?=$config['companyName']?>">
    <link rel="apple-touch-icon" href="<?=$frontPwaImgSrc?>/icon_152.png" media="all">

    <!-- //PWA -->

</head>
<body>
<?

    if($_SESSION['userNo']){

?>
<input type="hidden" name="login_id" class="login_id" value="<?=$_SESSION['userId']?>">
<?

    }else{

?>
<input type="hidden" name="sessionId" class="login_id" value="">
<input type="hidden" name="connectIp" class="connect_ip" value="<?=$userIp?>">
<?}?>
<input type="hidden" name="device" class="device" value="">
<?

    include_once dirname(dirname(dirname(dirname(__FILE__)))).$frontJsSrc."/winScroll.php";
    include_once dirname(dirname(dirname(dirname(__FILE__)))).$frontLayoutsSrc."/alert.php";
    // include_once dirname(dirname(dirname(dirname(__FILE__)))).$frontLayoutsSrc."/confirmAlert.php";
    include_once dirname(dirname(dirname(dirname(__FILE__)))).$frontLayoutsSrc."/ajaxLoading.php";

    if($nowPage == "view.php"){

        include_once dirname(dirname(dirname(dirname(__FILE__)))).$frontLayoutsSrc."/gnb_sub.php";

    }else{

        include_once dirname(dirname(dirname(dirname(__FILE__)))).$frontLayoutsSrc."/gnb.php";

    }

?>
<script>

    let chekcWidth = $("body,html").width();

    if (chekcWidth > 1024) {

        $(".device").val("pc");

    } else {

        $(".device").val("mobile");

    }

    deleteCookie("load") // gnb 로드될 쿠키 삭제

</script>
<style>

/**************************** 변수 ****************************/
    :root{

        --mainColor: <?=$config['mainColor']?>;
        --red: #ff425c;
        --white: #fff;
        --offWhite: #f1f1f1;
        --black: #171a18;
        --lightGray: #eeeeee;
        --gray: #7a7a7a;
        --baseFontFamily: 'NanumSquare','Malgun Gothic','Dotum', sans-serif;
        --baseFontRegular: 400;
        --baseFontBold: 700;
        --baseFontExtraBold: 800;

        --listMarginRight2: 12px;
        --listMarginRight3: 26px;
        --listMarginRight4: 20px;

    }

/**************************** // 변수 ****************************/

</style>
<div id="contentBox">