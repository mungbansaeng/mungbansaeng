<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">쿠폰 등록</h3>
        <form id="couponForm">
            <input type="hidden" name="page" class="page" value="coupon">
            <input type="hidden" name="act" class="act" value="modifyView">
            <input type="hidden" name="couponNo" class="couponNo" value="<?=$_GET['couponNo']?>">
            <div class="admin_infobox flex-vc-hsb-container">
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">쿠폰명</span>
                    </div>
                    <div>
                        <input type="text" name="couponName" class="input_fullDesign" value="" placeholder="쿠폰명을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">상태</span>
                    </div>
                    <div class="flex-vc-hl-container">
                        <div class="radio_list">
                            <input type="radio" name="status" id="status_100" value="100">
                            <label for="status_100">
                                <p class="o_designCheck">
                                    <span class="o_designChecked"></span>
                                </p>
                                <span class="o_designCheck_text">정상</span>
                            </label>
                        </div>
                        <div class="radio_list">
                            <input type="radio" name="status" id="status_200" value="200">
                            <label for="status_200">
                                <p class="o_designCheck">
                                    <span class="o_designChecked"></span>
                                </p>
                                <span class="o_designCheck_text">마감</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">쿠폰 유형</span>
                    </div>
                    <div id="couponType">
                        <div class="selectbox noMargin_selectbox">
                            <input type="hidden" class="selectedValue" name="couponType">
                            <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                <span class="selectbox_text">쿠폰유형 선택</span>
                                <span class="select_arrow"></span>
                            </p>
                            <ul class="selectbox_depth">
                                <li data-val="1" class="flex-vc-hl-container" onclick="selectboxClick(this);">관리자 발급</li>
                                <li data-val="2" class="flex-vc-hl-container" onclick="selectboxClick(this);">회원 다운로드</li>
                                <li data-val="3" class="flex-vc-hl-container" onclick="selectboxClick(this);">회원가입</li>
                                <li data-val="4" class="flex-vc-hl-container" onclick="selectboxClick(this);">생일쿠폰</li>
                                <li data-val="5" class="flex-vc-hl-container" onclick="selectboxClick(this);">쿠폰 코드</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">발급위치</span>
                    </div>
                    <div id="couponDownLocation">
                        <div class="selectbox noMargin_selectbox">
                            <input type="hidden" class="selectedValue" name="couponDownLocation">
                            <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                <span class="selectbox_text">발급위치 선택</span>
                                <span class="select_arrow"></span>
                            </p>
                            <ul class="selectbox_depth">
                                <li data-val="1" class="flex-vc-hl-container" onclick="selectboxClick(this);">관리자 발급</li>
                                <li data-val="2" class="flex-vc-hl-container" onclick="selectboxClick(this);">회원 다운로드</li>
                                <li data-val="3" class="flex-vc-hl-container" onclick="selectboxClick(this);">자동발급</li>
                                <li data-val="4" class="flex-vc-hl-container" onclick="selectboxClick(this);">회원가입시</li>
                                <li data-val="5" class="flex-vc-hl-container" onclick="selectboxClick(this);">로그인시</li>
                                <li data-val="6" class="flex-vc-hl-container" onclick="selectboxClick(this);">주문완료</li>
                                <li data-val="7" class="flex-vc-hl-container" onclick="selectboxClick(this);">쿠폰 코드</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">할인 금액</span>
                    </div>
                    <div>
                        <input type="text" name="discountPrice" class="input_fullDesign" placeholder="할인 금액을 입력하세요." oninput="inputonlyNum(this); liveNumberComma(this);" value="0">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">할인 퍼센트</span>
                    </div>
                    <div>
                        <input type="text" name="discountPercent" class="input_fullDesign" placeholder="할인 퍼센트를 입력하세요." oninput="inputonlyNum(this);" value="0">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">최소 구매금액</span>
                    </div>
                    <div>
                        <input type="text" name="minPrice" class="input_fullDesign" placeholder="가격을 입력하세요." oninput="inputonlyNum(this); liveNumberComma(this);" value="0">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">최대 할인금액</span>
                    </div>
                    <div>
                        <input type="text" name="maxPrice" class="input_fullDesign" placeholder="최대 할인 금액을 입력하세요." oninput="inputonlyNum(this); liveNumberComma(this);" value="0">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">만료날짜</span>
                        <div class="help_box">
                            <span class="help_icon flex-vc-hc-container" onclick="openHelp(this);">?</span>
                            <div class="help_descBox">
                                <div class="help_descTit">만료날짜 선택하기</div>
                                <div class="help_desc">
                                    쿠폰의 만료일이 고정 날짜일 경우 선택하시면 됩니다.<br><br>
                                    쿠폰의 만료일이 발급일로 부터 기간일 경우 만료날짜를 선택하지말고 유효기간을 선택하시면 됩니다.
                                </div>
                                <div class="help_descClose" onclick="closeHelp();">닫기</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="text" name="deadlineDate" class="input_fullDesign datepicker" value="" placeholder="날짜를 선택하세요." readonly>
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">유효기간</span>
                        <div class="help_box">
                            <span class="help_icon flex-vc-hc-container" onclick="openHelp(this);">?</span>
                            <div class="help_descBox">
                                <div class="help_descTit">유효기간 선택하기</div>
                                <div class="help_desc">
                                    쿠폰의 만료일이 쿠폰 발급일로부터 특정기간까지일때 선택하시면 됩니다.
                                </div>
                                <div class="help_descClose" onclick="closeHelp();">닫기</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-vc-hsb-container">
                        <input type="text" name="deadlineDay" class="input_halfDesign" value="" placeholder="유효기간을 입력하세요." oninput="inputonlyNum(this);">
                        <div id="deadlineDayUnit" class="admin_halfbox">
                            <div class="selectbox">
                                <input type="hidden" class="selectedValue" name="deadlineDayUnit">
                                <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                    <span class="selectbox_text">년/달/일 선택</span>
                                    <span class="select_arrow"></span>
                                </p>
                                <ul class="selectbox_depth">
                                    <li data-val="y" class="flex-vc-hl-container" onclick="selectboxClick(this);">년</li>
                                    <li data-val="m" class="flex-vc-hl-container" onclick="selectboxClick(this);">달</li>
                                    <li data-val="d" class="flex-vc-hl-container" onclick="selectboxClick(this);">일</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">쿠폰 발행량</span>
                        <div class="help_box">
                            <span class="help_icon flex-vc-hc-container" onclick="openHelp(this);">?</span>
                            <div class="help_descBox">
                                <div class="help_descTit">쿠폰 발행량</div>
                                <div class="help_desc">
                                    쿠폰의 발행 수량을 선택하시면 됩니다.
                                </div>
                                <div class="help_descClose" onclick="closeHelp();">닫기</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <ul class="coupon_listBox flex-vc-hl-container">
                            <li>
                                <input type="radio" id="publishType_PA" name="publishType" value="PA" checked>
                                <label for="publishType_PA">
                                    <p class="o_designCheck">
                                        <span class="o_designChecked"></span>
                                    </p>
                                    <span>제한없음</span>
                                </label>
                            </li>
                            <li class="coupon_rtList">
                                <input type="radio" id="publishType_PB" name="publishType" value="PB">
                                <label for="publishType_PB">
                                    <p class="o_designCheck">
                                        <span class="o_designChecked"></span>
                                    </p>
                                    <span>선착순</span>
                                </label>
                                <input type="text" class="input_fullDesign" name="publishTypeNum" oninput="inputonlyNum(this);">명
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">1인에 대한 쿠폰 제한</span>
                        <div class="help_box">
                            <span class="help_icon flex-vc-hc-container" onclick="openHelp(this);">?</span>
                            <div class="help_descBox">
                                <div class="help_descTit">1인에 대한 쿠폰 제한</div>
                                <div class="help_desc">
                                    회원별 쿠폰을 다운받을 수 있는 수량을 선택하시면 됩니다.
                                </div>
                                <div class="help_descClose" onclick="closeHelp();">닫기</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <ul class="coupon_listBox flex-vc-hl-container">
                            <li>
                                <input type="radio" id="couponLimit_CA" name="couponLimit" value="CA" checked>
                                <label for="couponLimit_CA">
                                    <p class="o_designCheck">
                                        <span class="o_designChecked"></span>
                                    </p>
                                    <span>무한</span>
                                </label>
                            </li>
                            <li class="coupon_rtList">
                                <input type="radio" id="couponLimit_CB" name="couponLimit" value="CB">
                                <label for="couponLimit_CB">
                                    <p class="o_designCheck">
                                        <span class="o_designChecked"></span>
                                    </p>
                                    <span>한정</span>
                                </label>
                                <input type="text" class="input_fullDesign" name="couponLimitNum" oninput="inputonlyNum(this);">장
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">쿠폰 이용정보</span>
                    </div>
                    <div>
                        <textarea placeholder="쿠폰 이용정보를 입력하세요." name="couponUseDesc"></textarea>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">쿠폰관련 메모</span>
                    </div>
                    <div>
                        <textarea name="description" id="couponDescription" placeholder="내용을 입력하세요."></textarea>
                        <?

                            $ckeditorId = "couponDescription";

                            include dirname(dirname(dirname(dirname(__FILE__))))."/ckeditor/ckeditor.php";

                        ?>	
                    </div>
                </div>
                <div class="admin_btnBox">
                    <input type="button" class="admin_btn modify_btn" value="수정하기">
                </div> 
            </div>
        </form>
    </div>
</div>

<script>

    const form = $("#couponForm");

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/admin/controller/couponController.php",
        global: false,
        data: form.serialize(),
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            if (data[0] == "success") {

                // 쿠폰명
                $("input[name='couponName']").val(data[1]['couponName']);

                // 쿠폰 상태
                $("#status_" + data[1]['status']).prop("checked", true);

                // 쿠폰 유형
                $("#couponType .selectedValue").val(data[1]['couponType']);

                $("#couponType .selectbox_text").text($("#couponType .selectbox .selectbox_depth li[data-val='" + data[1]['couponType'] + "']").text());

                // 발급위치
                $("#couponDownLocation .selectedValue").val(data[1]['couponDownLocation']);

                $("#couponDownLocation .selectbox_text").text($("#couponDownLocation .selectbox .selectbox_depth li[data-val='" + data[1]['couponDownLocation'] + "']").text());

                // 할인금액
                $("input[name='discountPrice']").val(comma(data[1]['discountPrice']));

                // 할인퍼센트
                $("input[name='discountPercent']").val(data[1]['discountPercent']);

                // 최소 구매금액
                $("input[name='minPrice']").val(comma(data[1]['minPrice']));

                // 최대 할인금액
                $("input[name='maxPrice']").val(comma(data[1]['maxPrice']));

                // 만료날짜, 유효기간
                if (data[1]['deadline'].indexOf("◈") > -1) { // 유효기간

                    let deadline = data[1]['deadline'].split("◈");

                    $("input[name='deadlineDay']").val(deadline[0]);
                    $("#deadlineDayUnit .selectedValue").val(deadline[1]);
                    $("#deadlineDayUnit .selectbox_text").text($("#deadlineDayUnit .selectbox .selectbox_depth li[data-val='" + deadline[1] + "']").text());

                } else { // 만료날짜

                    $("input[name='deadlineDate']").val(data[1]['deadline']);

                }
                
                // 쿠폰 발행량
                $("#publishType_" + data[1]['publishType']).prop("checked", true);
                $("input[name='publishTypeNum']").val(data[1]['publishTypeNum']);
                
                // 1인에 대한 쿠폰 제한
                $("#couponLimit_" + data[1]['couponLimit']).prop("checked", true);
                $("input[name='couponLimitNum']").val(data[1]['couponLimitNum']);

                // 쿠폰 이용정보
                $("textarea[name='couponUseDesc']").val(data[1]['couponUseDesc']);

                // 쿠폰관련 메모
                couponDescriptionobjEditor.setData(data[1]['description']);

            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

    $(".modify_btn").click(function(){

        $(".act").val("modify");

        $("#couponDescription").val(couponDescriptionobjEditor.getData()); // ck에디터 내용 가져와서 textarea value에 넣기

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/admin/controller/couponController.php",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                if (data[0] == "success") {

                    if (confirm("현재 페이지를 닫으시겠습니까?")) {

                        location.href = "/admin/view/promotion/couponList";

                    } else {

                        location.reload();    

                    }

                } else {

                    document.write(data);

                }

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    });

</script>