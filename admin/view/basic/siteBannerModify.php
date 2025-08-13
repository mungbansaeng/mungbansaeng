<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">배너 수정</h3>
        <form id="siteBannerModiForm" name="form">
            <input type="hidden" class="page" name="page" value="siteBanner">
            <input type="hidden" class="act" name="act" value="modifyView">
            <div class="admin_infobox flex-vc-hsb-container">
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">배너 타입</span>
                    </div>
                    <div>
                        <div class="selectbox">
                            <input type="hidden" class="selectedValue" name="type">
                            <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                <span class="selectbox_text">배너 타입 선택</span>
                                <span class="select_arrow"></span>
                            </p>
                            <ul class="selectbox_depth">
                                <li data-val="101" class="flex-vc-hl-container" onclick="selectboxClick(this);">메인 최상단 배너</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">PC 배너 이미지</span>
                    </div>
                    <div class="attachfile_box flex-vc-hl-container">
                        <input type="hidden" class="fileTotalNum" value="1"> <!-- 첨부파일 가능 개수 -->
                        <input type="file" id="attachment1" class="attach_btn" multiple onchange="attachClick(this, 'pc', 'siteBanner', 'admin');">
                        <label for="attachment1">
                            <span class="file_design">이미지 첨부</span>
                        </label>
                        <div class="attach_descbox flex-vc-hl-container"><p class="attach_placeholder">최대 1개까지 가능합니다.</p></div>
                        <p class="attach_sdesc">※ 가로 1920픽셀 X 세로 560픽셀 사이즈</p>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">Mobile 배너 이미지</span>
                    </div>
                    <div class="attachfile_box flex-vc-hl-container">
                        <input type="hidden" class="fileTotalNum" value="1"> <!-- 첨부파일 가능 개수 -->
                        <input type="file" id="attachment2" class="attach_btn" multiple onchange="attachClick(this, 'mobile', 'siteBanner', 'admin');">
                        <label for="attachment2">
                            <span class="file_design">이미지 첨부</span>
                        </label>
                        <div class="attach_descbox flex-vc-hl-container"><p class="attach_placeholder">최대 1개까지 가능합니다.</p></div>
                        <p class="attach_sdesc">※ 가로 480픽셀 X 세로 480픽셀 사이즈</p>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">배너명</span>
                    </div>
                    <div>
                        <input type="text" name="title" class="input_fullDesign nameTitle" placeholder="배너명을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">연결링크</span>
                        <div class="help_box">
                            <span class="help_icon flex-vc-hc-container" onclick="openHelp(this);">?</span>
                            <div class="help_descBox">
                                <div class="help_descTit">연결링크 입력하기</div>
                                <div class="help_desc">
                                    배너를 클릭했을때 이동할 페이지 링크를 입력하는 곳입니다.<br>링크를 입력할때는 도메인 뒤부터 입력하시면 됩니다.<br>도메인이 https://www.test.com/testpage일 경우 https://www.test.com뒤인 /testpage만 입력
                                </div>
                                <div class="help_descClose" onclick="closeHelp();">닫기</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="text" name="link" class="input_fullDesign nameLink" placeholder="도메인 뒤부터 주소를 입력하세요.">
                    </div>
                </div>
                <div class="admin_btnBox">
                    <input type="button" class="admin_btn reg_btn" value="등록하기">
                    <input type="button" class="admin_backBtn" onclick="location.href='./siteCategoryList'" value="돌아가기">
                </div> 
            </div>
        </form>
    </div>
</div>

<script>

    const form = $("#siteBannerModiForm");
    
    form.append("<input type='hidden' name='idx' value='<?=$_GET['idx']?>'>");

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/admin/controller/boardController.php",
        global: false,
        data: form.serialize(),
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            // 배너 타입
            for (sd=0; sd < $(".selectbox_depth li").length; sd++) {

                if ($(".selectbox_depth li").eq(sd).attr("data-val") == data[0]['type']) {

                    $(".selectbox_text").text($(".selectbox_depth li").eq(sd).text());

                }

            }

            $(".selectedValue").val(data[0]['type']);

            // 배너명
            $(".nameTitle").val(data[0]['title']);

            // 연결링크
            $(".nameLink").val(data[0]['link']);

            // 첨부파일
            var attachArray = data[1];
            var attachDescWith = 100 / (attachArray.length / 2);
            var table = $(".page").val();

            if (attachArray.length > 0) {

                for (ac=0; ac < attachArray.length; ac++) {

                    if (attachArray[ac]['type'] == "pc") {

                        $("#attachment1").siblings('.attach_descbox').find(".attach_placeholder").hide();

                        $("#attachment1").siblings('.attach_descbox').append("<div class='attach_desclist' style='width: calc(" + attachDescWith + "% - 10px);'><input type='text' name='uploadName' readonly value='" + attachArray[ac]['originFileName'] + "'><input type='hidden' name='transfileName' class='transfileName' value='" + attachArray[ac]['fileName'] + "'><input type='hidden' id='pcfileIdx" + ac + "' class='file_idx' name='fileIdx' value='" + attachArray[ac]['idx'] + "'><p class='attach_del' onclick=\"attachDel(this, '" + table + "', 'admin');\"><img src='../../resources/images/attach_del.png' alt=''></p></div>");

                    } else if (attachArray[ac]['type'] == "mobile") {

                        $("#attachment2").siblings('.attach_descbox').find(".attach_placeholder").hide();

                        $("#attachment2").siblings('.attach_descbox').append("<div class='attach_desclist' style='width: calc(" + attachDescWith + "% - 10px);'><input type='text' name='uploadName' readonly value='" + attachArray[ac]['originFileName'] + "'><input type='hidden' name='transfileName' class='transfileName' value='" + attachArray[ac]['fileName'] + "'><input type='hidden' id='pcfileIdx" + ac + "' class='file_idx' name='fileIdx' value='" + attachArray[ac]['idx'] + "'><p class='attach_del' onclick=\"attachDel(this, '" + table + "', 'admin');\"><img src='../../resources/images/attach_del.png' alt=''></p></div>");

                    }

                }
                
            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

    $(".reg_btn").click(function() {

        // 유효성 체크
        if (!document.form.type.value) {

            alert("배너 타입을 선택하세요.");

            return false;

        } else if (!document.form.title.value) {

            alert("배너명을 입력하세요.");

            document.form.title.focus();

            return false;

        }

        const form = $("#siteBannerModiForm");

        $(".act").val("modify");

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/admin/controller/boardController.php",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                console.log(data);

                if(data == "success"){

                    if (confirm("리스트로 이동하시겠습니까?")) {

                        location.href = "/admin/view/basic/siteBannerList";

                    } else {

                        location.reload();

                    }

                }else{

                    document.write(data);

                }

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    });

</script>