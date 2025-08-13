<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/header.php"; // 헤더

?>

<div class="sub_container">
    <div class="sub_conBox flex-vc-hc-container">
        <div class="w768">
            <div class="member_conBox">
                <p class="member_tit">회원가입</p>
                <form name="joinForm" id="joinForm">
                    <input type="hidden" name="page" value="memberJoin">
                    <input type="hidden" name="act" value="join">
                    <input type="hidden" name="joinRoute" value="homepage">
                    <input type="hidden" name="ci" id="ci" value="test">
                    <input type="hidden" name="smsSubscribe" value="<?=$_GET['smsSubscribe']?>">
                    <input type="hidden" name="emailSubscribe" value="<?=$_GET['emailSubscribe']?>">
                    <div class="join_listBox">
                        <ul class="join_list joinFixed_list flex-hl-container">
                            <li class="flex-vc-hl-container">이름</li>
                            <li class="flex-vc-hl-container">
                                <!-- <input type="text" name="name" id="name" value="<?=$_POST['name']?>" readonly> -->
                                <input type="text" name="name" id="name" value="복근호" readonly>
                            </li>
                        </ul>
                        <ul class="join_list joinFixed_list flex-hl-container">
                            <li class="flex-vc-hl-container">생년월일</li>
                            <li class="flex-vc-hl-container">
                                <!-- <input type="text" name="birthday" id="birthday" value="<?=$_POST['birthday']?>" readonly>
                                <input type="hidden" name="birthYear" value="<?=$birthYear?>">
                                <input type="hidden" name="birthMonth" value="<?=$birthMonth?>">
                                <input type="hidden" name="birthDay" value="<?=$birthDay?>"> -->
                                <input type="text" name="birthday" id="birthday" value="1989-04-10" readonly>
                                <input type="hidden" name="birthYear" value="1989">
                                <input type="hidden" name="birthMonth" value="04">
                                <input type="hidden" name="birthDay" value="10">
                            </li>
                        </ul>
                        <ul class="join_list joinFixed_list flex-hl-container">
                            <li class="flex-vc-hl-container">성별</li>
                            <li class="flex-vc-hl-container">
                                <!-- <input type="text" name="gender" id="gender" value="<?=$gender?>" readonly> -->
                                <input type="text" name="gender" id="gender" value="M" readonly>
                            </li>
                        </ul>
                        <ul class="join_list joinFixed_list flex-hl-container">
                            <li class="flex-vc-hl-container">휴대폰 번호</li>
                            <li class="flex-vc-hl-container">
                                <!-- <input type="text" name="cellPhone" id="cellPhone" value="<?=$_POST['phoneNumber']?>" readonly>
                                <input type="hidden" name="cellPhone1" value="<?=$call1?>">
                                <input type="hidden" name="cellPhone2" value="<?=$call2?>">
                                <input type="hidden" name="cellPhone3" value="<?=$call3?>"> -->
                                <input type="text" name="cellPhone" id="cellPhone" value="010-5788-6970" readonly>
                                <input type="hidden" name="cellPhone1" value="010">
                                <input type="hidden" name="cellPhone2" value="5788">
                                <input type="hidden" name="cellPhone3" value="6970">
                            </li>
                        </ul>
                        <ul class="join_list flex-hl-container">
                            <li class="flex-vc-hl-container">아이디</li>
                            <li class="flex-vc-hl-container">
                                <input type="text" name="id" id="id" placeholder="이메일을 입력해주세요." onblur="idDupliCheck(this);">
                            </li>
                        </ul>
                        <ul class="join_list flex-hl-container">
                            <li class="flex-vc-hl-container">비밀번호</li>
                            <li class="flex-vc-hl-container">
                                <input type="password" name="password" id="password" placeholder="비밀번호를 입력해주세요." onblur="passwordDupliCheck(this);">
                            </li>
                        </ul>
                        <ul class="join_list flex-hl-container">
                            <li class="flex-vc-hl-container">비밀번호 확인</li>
                            <li class="flex-vc-hl-container">
                                <input type="password" name="repassword" id="repassword" placeholder="비밀번호를 입력해주세요." onblur="passwordDupliCheck(this, 're');">
                            </li>
                        </ul>
                        <ul class="join_list joinAddress_list flex-hl-container">
                            <li class="flex-vc-hl-container">주소</li>
                            <li class="flex-vc-hl-container">
                                <input type="text" name="address1" id="joinAddress1" placeholder="주소를 입력해주세요." onclick="DaumPostcodePop('join')" readonly>
                                <input type="text" name="address2" id="address2" placeholder="상세주소를 입력해주세요.">
                                <input type="hidden" name="postcode" id="joinPostcode">
                            </li>
                        </ul>
                        <ul class="join_list flex-hl-container">
                            <li class="flex-vc-hl-container">추천인</li>
                            <li class="flex-vc-hl-container">
                                <input type="text" name="recommender" id="recommender" placeholder="추천인 아이디를 입력해주세요.">
                                <p class="sub_info">* 추천인은 회원가입시에만 입력 가능합니다.</p>
                            </li>
                        </ul>
                    </div>
                    <p class="flex-vc-hc-container">
                        <input type="button" class="submit_btn" onclick="joinFieldCheck();" value="회원가입 완료">
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/footer.php"; // 푸터
    
?>