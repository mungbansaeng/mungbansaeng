<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/header.php"; // 헤더

?>

<p class="filterDetail"></p>
<div class="userlogin_container">
    <div class="userlogin_conbox">
        <h3 class="userlogin_tit"><img src="/admin/resources/upload/<?=$config['fileName']?>" alt="로고"></h3>
        <div class="userlogin_wrap">
            <form name="form" id="loginForm">
                <div class="userlogin">
                    <div>
                        <input type="text" id="userId" placeholder="이메일" onkeyup="enterkey(this, 'N');">
                    </div>
                    <div>
                        <input type="password" id="userPassword" placeholder="비밀번호" onkeyup="enterkey(this, 'N');">
                    </div>
                </div>
                <div class="btn_wrap">
                    <div class="userlogin_ip_box">
                        <div class="flex-vc-hl-container">
                            <div class="userLogin_auto">
                                <input type="checkbox" name="autoLogin" id="autoLogin" value="Y" checked>
                                <label for="autoLogin">
                                    <p class="design_check"><span class="design_checked"></span></p>
                                    <p class="checkbox_text">자동로그인</p>
                                </label>
                            </div>
                            <div class="userLogin_idSave">
                                <input type="checkbox" name="saveId" id="saveId">
                                <label for="saveId">
                                    <p class="design_check"><span class="design_checked"></span></p>
                                    <p class="checkbox_text">아이디저장</p>
                                </label>
                            </div>
                        </div>
                        <div class="userlogin_findip">
                            <a href="/findId">아이디 찾기</a>
                            <span class="finip_bar">|</span>
                            <a href="/findPw">비밀번호 찾기</a>
                        </div>
                    </div>
                    <input type="button" class="mainColor_btn enterkeySubmit" value="로그인" onclick="loginFieldCheck();">
                    <input type="button" class="white_btn" value="회원가입" onclick="location.href='/join'">
                    <input type="button" class="white_btn" value="비회원 주문조회" onclick="deleteCookie('nonMemberorderSearch'); gnbLoad('nonMemberOrderSearch'); location.href='/mypage'">
                    <?
                    
                        if ($config['naverLoginUse'] == 'Y' || $config['kakaoLoginUse'] == 'Y' || $config['googleLoginUse'] == 'Y' || $config['appleLoginUse'] == 'Y') {
                    
                    ?>
                    <div id="snsLoginBox">
                        <p class="snsLoginBox_tit">SNS 간편 로그인</p>
                        <div class="snslogin_iconbox <?if ($config['snsLoginDesign'] == 'C') {?>flex-vc-hc-container<?}?>">
                            <?
                            
                                if ($config['kakaoLoginUse'] == 'Y') {
                            
                            ?>
                            <!-- 카카오 로그인 -->
                            <div class="snslogin_icon kakao_loginbox">
                                <a id="<?if ($config['snsLoginDesign'] == 'C') {?>kakaoLoginCircleBtn<?} else {?>kakaoLoginBoxBtn<?}?>"></a>
                                <a href="http://developers.kakao.com/logout"></a>
                                <script type='text/javascript'>

                                    Kakao.init('760a6f68d245af8ac71b82b8a0f4e9bd');
                                    // 카카오 로그인 버튼 생성
                                    Kakao.Auth.createLoginButton({
                                        container: '#kakaoLoginBtn',
                                        success: function(authObj) {

                                            // 로그인 성공시, API를 호출합니다.
                                            Kakao.API.request({
                                                url: '/v2/user/me',
                                                success: function(res) {

                                                    var userID = res.id;
                                                    var userNickName = res.properties.nickname;
                                                    var userEmail = res.kakao_account.email;
                                                    var userBirthday = res.kakao_account.birthday;
                                                    var userAgeRange = res.kakao_account.age_range;
                                                    var userGender = res.kakao_account.gender;
                                                    var joinRoute = "kakao";

                                                    var month = userBirthday.split("")[0] + userBirthday.split("")[1];

                                                    var day = userBirthday.split("")[2] + userBirthday.split("")[3];

                                                    $.ajax({
                                                        type: "POST", 
                                                        dataType: "html",
                                                        async: true,
                                                        url: "/web/join/process_join",
                                                        data:{
                                                            "id": userID,
                                                            "name": userNickName,
                                                            "email": userEmail,
                                                            "month": month,
                                                            "day": day,
                                                            "joinRoute": joinRoute
                                                        },
                                                        traditional: true,
                                                        beforeSend:function(xhr){
                                                        },
                                                        success:function(msg){

                                                            $("#dataArea").html(msg);

                                                        },
                                                        error:function(){
                                                            alert("실패!!!!");
                                                        }
                                                    });

                                                },
                                                fail: function(error) {

                                                    alert(JSON.stringify(error));

                                                }
                                            });
                                        },
                                        fail: function(err) {
                                            alert(JSON.stringify(err));
                                        }
                                    });

                                </script>
                            </div>
                            <!-- //카카오 로그인 -->
                            <?
                                }
                            
                                if ($config['naverLoginUse'] == 'Y') {
                            
                            ?>
                            <!-- 네이버 로그인 -->
                            <div class="snslogin_icon naver_loginbox">
                                <script type="text/javascript" src="https://static.nid.naver.com/js/naveridlogin_js_sdk_2.0.0.js" charset="utf-8"></script>
                                <div id="<?if ($config['snsLoginDesign'] == 'C') {?>naverLoginCircleBtn<?} else {?>naverLoginBoxBtn<?}?>">
                                    <div id="naverIdLogin"></div>
                                </div>
                                <script type="text/javascript">
                                    var naverLogin = new naver.LoginWithNaverId({
                                        
                                        clientId: "NZZCuq3VnWMS6Zlb3fTY",
                                        callbackUrl: "http://bokslib.cafe24.com/web/login/naver/callback.php",
                                        isPopup: false, /* 팝업을 통한 연동처리 여부 */
                                        loginButton: {color: "green", type: 1, height: 64} /* 로그인 버튼의 타입을 지정 */

                                    });

                                    /* 설정정보를 초기화하고 연동을 준비 */
                                    naverLogin.init();
                                </script>
                            </div>
                            <!-- //네이버 로그인 -->
                            <?
                                }
                            
                                if ($config['googleLoginUse'] == 'Y') {
                            
                            ?>
                            <!-- 구글 로그인 -->
                            <!-- <div class="snslogin_icon google_loginbox">
                                <a id="<?if ($config['snsLoginDesign'] == 'C') {?>googleLoginCircleBtn<?} else {?>googleLoginBoxBtn<?}?>"></a>
                                <a href="http://developers.kakao.com/logout"></a>
                            </div> -->
                            <!-- //구글 로그인 -->
                            <?
                                }
                            
                                if ($config['appleLoginUse'] == 'Y') {
                            
                            ?>
                            <!-- 애플 로그인 -->
                            <!-- <div class="snslogin_icon apple_loginbox">
                                <a id="<?if ($config['snsLoginDesign'] == 'C') {?>appleLoginCircleBtn<?} else {?>appleLoginBoxBtn<?}?>"></a>
                                <a href="http://developers.kakao.com/logout"></a>
                            </div> -->
                            <!-- //애플 로그인 -->
                            <?
                                }
                            ?>
                        </div>
                    </div>
                    <?}?>
                </div>
            </form>
        </div>
    </div>
</div>

<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/footer.php"; // 푸터
    
?>	