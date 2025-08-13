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
    <meta name="publisher" content="">
    <meta name="generator" content="Visual Studio">
    <meta name="author" content="">
    <meta name="keywords" content="<?=$meta['siteKeyword']?>">
    <meta name="description" content="<?=$meta['siteDescription']?>">
    <meta name="naver-site-verification" content="<?=$meta['naverVerification']?>">
    <meta property="og:url" content="<?=$meta['siteUrl']?>">
    <meta property="og:title" content="<?=$meta['siteTit']?>">
    <meta property="og:description" content="<?=$meta['siteDescription']?>">
    <meta property="og:site_name" content="<?=$meta['siteTit']?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="">
    <link rel="canonical" href="">
    <link rel="shortcut icon" href="<?=$publicImgSrc?>/favicon.ico">
    
    <!--  css  -->
    <link href="<?=$publicCssSrc?>/base.css" rel="stylesheet">
    <link href="<?=$publicCssSrc?>/fonts.css" rel="stylesheet">
    <link href="<?=$adminCssSrc?>/style.css" rel="stylesheet">
    <link href="<?=$adminCssSrc?>/mediaquery.css" rel="stylesheet">
    <!--  //css  -->

    <!-- crypto js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/sha256.js"></script>
    
    <!--  script  -->
    <script type="text/javascript" src="<?=$publicPluginSrc?>/jquery-3.3.1.min.js"></script>
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
<div class="login_container">
    <div class="login_bg"></div>
    <div class="login_logobox flex-vc-hc-container">
        <p class="login_logo"><img src="<?=$adminImgSrc?>/logo.png"></p>
        <p class="login_tit">Welcome to admin page</p>
    </div>
    <div class="login_box">
        <div class="login_wrap flex-vc-hc-container">
            <div class="login_conBox">
                <div class="login_listbox">
                    <div class="login_list">
                        <input type="text" id="adminId" placeholder="아이디를 입력하세요" onkeyup="enterkey(this, 'N');">
                    </div>
                    <div class="login_list">
                        <input type="password" id="adminPassword" placeholder="비밀번호를 입력하세요." onkeyup="enterkey(this, 'N');"><br>
                    </div>
                </div>
                <div class="login_ip_box flex-vc-hsb-container">
                    <div class="login_idsave">
                        <input type="checkbox" name="saveId" id="saveId">
                        <label for="saveId">
                            <p class="design_check"><span class="design_checked"></span></p>
                            <p class="checkbox_text">아이디 기억하기</p>
                        </label>
                    </div>
                    <div class="login_findip">
                        <a href="<?=$adminSrc?>/login/findId.php">아이디 찾기</a>
                        <span class="finip_bar">|</span>
                        <a href="<?=$adminSrc?>/login/findPw.php">비밀번호 찾기</a>
                    </div>
                </div>
                <div class="btn_wrap">
                    <input type="button" class="mainColor_btn enterkeySubmit" value="로그인" onclick="login_check();">
                </div>
            </div>
        </div>
        <p class="copyright">COPYRIGHT <?=$config['companyName']?> ALL RIGHTS RESERVED.</p>
    </div>
</div>  
<script>

    $(document).ready(function() {

        if ($("#adminId").val() == "") {

            $("#adminId").focus();    

        } else if ($("#adminPassword").val() == "") {

            $("#adminPassword").focus();    

        }

    });

</script>
</body>
</html>