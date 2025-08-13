<div class="sub_container">
    <div class="sub_conBox flex-vc-hc-container">
        <div class="w768">
            <div class="member_conBox">
                <p class="member_tit">회원정보수정</p>
                <form name="userInfoChangeForm" id="userInfoChangeForm">
                    <input type="hidden" name="page" value="mypage">
                    <input type="hidden" name="act" value="userInfoChange">
                    <input type="hidden" name="smsSubscribe" value="">
                    <input type="hidden" name="emailSubscribe" value="">
                    <div class="join_listBox">
                        <ul class="join_list joinFixed_list flex-hl-container">
                            <li class="flex-vc-hl-container">이름</li>
                            <li class="flex-vc-hl-container">
                                <input type="text" name="name" id="name" value="" readonly>
                            </li>
                        </ul>
                        <ul class="join_list joinFixed_list flex-hl-container">
                            <li class="flex-vc-hl-container">생년월일</li>
                            <li class="flex-vc-hl-container">
                                <input type="text" name="birthday" id="birthday" value="" readonly>
                                <input type="hidden" name="birthYear" value="">
                                <input type="hidden" name="birthMonth" value="">
                                <input type="hidden" name="birthDay" value="">
                            </li>
                        </ul>
                        <ul class="join_list joinFixed_list flex-hl-container">
                            <li class="flex-vc-hl-container">성별</li>
                            <li class="flex-vc-hl-container">
                                <input type="text" name="gender" id="gender" value="" readonly>
                            </li>
                        </ul>
                        <ul class="join_list joinFixed_list flex-hl-container">
                            <li class="flex-vc-hl-container">휴대폰 번호</li>
                            <li class="flex-vc-hl-container">
                                <input type="text" name="cellPhone" id="cellPhone" value="<?=$_POST['phoneNumber']?>" readonly>
                                <input type="hidden" name="cellPhone1" value="">
                                <input type="hidden" name="cellPhone2" value="">
                                <input type="hidden" name="cellPhone3" value="">
                            </li>
                        </ul>
                        <ul class="join_list joinFixed_list flex-hl-container">
                            <li class="flex-vc-hl-container">아이디</li>
                            <li class="flex-vc-hl-container">
                                <input type="text" name="id" id="id" placeholder="이메일을 입력해주세요." readonly>
                            </li>
                        </ul>
                        <ul class="join_list flex-hl-container">
                            <li class="flex-vc-hl-container">기존 비밀번호</li>
                            <li class="flex-vc-hl-container">
                                <input type="password" name="originPassword" id="originPassword" placeholder="기존 비밀번호를 입력해주세요." onblur="passwordDupliCheck(this);">
                            </li>
                        </ul>
                        <ul class="join_list flex-hl-container">
                            <li class="flex-vc-hl-container">비밀번호 변경</li>
                            <li class="flex-vc-hl-container">
                                <input type="password" name="password" id="password" placeholder="수정하실 비밀번호를 입력해주세요." onblur="passwordDupliCheck(this);">
                            </li>
                        </ul>
                        <ul class="join_list flex-hl-container">
                            <li class="flex-vc-hl-container">변경 비밀번호 확인</li>
                            <li class="flex-vc-hl-container">
                                <input type="password" name="repassword" id="repassword" placeholder="수정하실 비밀번호를 입력해주세요." onblur="passwordDupliCheck(this, 're');">
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
                    </div>
                    <div class="modiTnc_listBox">
                        <div class="tnc_list tnc_list3 tnc_checkEach">
                            <input type="checkbox" name="smsSubscribe" id="smsSubscribe">
                            <label for="smsSubscribe">
                                <div>
                                    <p class="ov_designCheck">
                                        <span class="ov_designChecked"></span>
                                    </p>
                                    <span>[선택]</span> SMS 및 카카오톡 수신 동의 (안내문자 및 광고문자 발송)
                                </div>
                            </label>
                        </div>
                        <div class="tnc_list tnc_list3 tnc_checkEach">
                            <input type="checkbox" name="emailSubscribe" id="emailSubscribe">
                            <label for="emailSubscribe">
                                <div>
                                    <p class="ov_designCheck">
                                        <span class="ov_designChecked"></span>
                                    </p>
                                    <span>[선택]</span> 이메일수신동의 (안내메일 및 광고메일 발송)
                                </div>
                            </label>
                        </div>
                    </div>
                    <p class="flex-vc-hc-container">
                        <input type="button" class="submit_btn" onclick="infoModifyFieldCheck();" value="수정하기">
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    gnbLoad('userInfoChangeView');

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/mypageController",
        global: false,
        data: {
            "page": "mypage",
            "act": "userInfoChangeView"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            $("#name").val(data[1]['name']);

            let birthDay = data[1]['birthday'].split("◈");

            $("#birthday").val(birthDay[0] + "-" + birthDay[1] + "-" + birthDay[2]);
            $("input[name='birthYear']").val(birthDay[0]);
            $("input[name='birthMonth']").val(birthDay[1]);
            $("input[name='birthDay']").val(birthDay[2]);

            let gender = data[1]['gender'] == "M" ? "남자" : "여자";
            $("#gender").val(gender);

            let cellPhone = data[1]['cellPhone'].split("◈");

            $("#cellPhone").val(cellPhone[0] + "-" + cellPhone[1] + "-" + cellPhone[2]);
            $("input[name='cellPhone1']").val(cellPhone[0]);
            $("input[name='cellPhone2']").val(cellPhone[1]);
            $("input[name='cellPhone3']").val(cellPhone[2]);

            $("#id").val(data[1]['id']);

            let address = data[1]['address'].split("◈");

            $("#joinAddress1").val(address[0]);
            $("#address2").val(address[1]);
            $("#joinPostcode").val(data[1]['postcode']);

            $("#recommender").val(data[1]['recommender']);

            if (data[1]['emailSubscribe'] == "Y") {

                $("#emailSubscribe").prop("checked", true);

            }

            if (data[1]['smsSubscribe'] == "Y") {

                $("#smsSubscribe").prop("checked", true);

            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });



</script>

<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/footer.php"; // 푸터
    
?>	