<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/public/common/config.php";
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/controller/commonController.php";

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <title><?=$meta['siteTit']?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"  content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no, address=no, email=no">
    <meta name="generator" content="Visual Studio">
    <meta name="keywords" content="<?=$meta['siteKeyword']?>">
    <meta name="description" content="<?=$meta['siteDescription']?>">
    <meta name="naver-site-verification" content="<?=$meta['naverVerification']?>">
    <meta property="og:url" content="<?=$meta['siteUrl']?>">
    <meta property="og:title" content="<?=$meta['siteTit']?>">
    <meta property="og:description" content="<?=$meta['siteDescription']?>">
    <meta property="og:site_name" content="<?=$meta['siteTit']?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="/images/common/thum_logo.jpg">
    <link rel="canonical" href="<?=$meta['siteUrl']?>">
    <link rel="shortcut icon" href="<?=$publicImgSrc?>/favicon.ico">
    
    <!--  css  -->
    <link href="<?=$publicCssSrc?>/base.css" rel="stylesheet">
    <link href="<?=$publicCssSrc?>/fonts.css" rel="stylesheet">
    <link href="<?=$adminCssSrc?>/style.css" rel="stylesheet">
    <link href="<?=$adminCssSrc?>/mediaquery.css" rel="stylesheet">
    <link href="<?=$adminCssSrc?>/jquery.minicolors.css" rel="stylesheet">
    <!--  //css  -->

    <!-- crypto js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/sha256.js"></script>
    
    <!--  script  -->
    <script type="text/javascript" src="<?=$publicPluginSrc?>/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="<?=$publicPluginSrc?>/jquery-ui.js"></script>
    <script type="text/javascript" src="<?=$adminPluginSrc?>/Chart.min.js"></script>
    <script type="text/javascript" src="<?=$adminPluginSrc?>/chartjs-plugin-datalabels.js"></script>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?=$adminPluginSrc?>/jquery.minicolors.js"></script>
    <script type="text/javascript" src="<?=$publicPluginSrc?>/datapicker.js"></script>
    <script type="text/javascript" src="<?=$adminJsSrc?>/style.js"></script>
    <!--  //script  -->

</head>
<body>
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
<?

    include_once dirname(dirname(dirname(dirname(__FILE__)))).$adminLayoutsSrc."/gnb.php";

?>