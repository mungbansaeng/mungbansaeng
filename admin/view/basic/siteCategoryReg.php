<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/controller/commonController.php";

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">사이트 카테고리 등록</h3>
        <form id="siteCategoryRegForm" name="form">
            <input type="hidden" name="page" value="siteCategory">
            <input type="hidden" name="act" value="reg">
            <div class="admin_infobox flex-vc-hsb-container">
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">첫번째 카테고리명</span>
                    </div>
                    <div>
                        <input type="text" name="title" class="input_fullDesign" placeholder="카테고리명을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">첫번째 카테고리 파일명</span>
                        <div class="help_box">
                            <span class="help_icon flex-vc-hc-container" onclick="openHelp(this);">?</span>
                            <div class="help_descBox">
                                <div class="help_descTit">카테고리 파일명</div>
                                <div class="help_desc">
                                    카테고리 파일명은 도메인 뒤에 붙는 파일명 입니다.<br>파일명을 testpage로 등록할 경우 https://www.test.com/testpage로 주소가 나옵니다.
                                </div>
                                <div class="help_descClose" onclick="closeHelp();">닫기</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="text" name="file" class="input_fullDesign" placeholder="파일명을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">카테고리 타입</span>
                    </div>
                    <div>
                        <div class="selectbox">
                            <input type="hidden" class="selectedValue" name="depthType">
                            <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                <span class="selectbox_text">카테고리 타입 선택</span>
                                <span class="select_arrow"></span>
                            </p>
                            <ul class="selectbox_depth">
                                <li data-val="100" class="flex-vc-hl-container" onclick="selectboxClick(this);">소개 페이지</li>
                                <li data-val="201" class="flex-vc-hl-container" onclick="selectboxClick(this);">리스트 게시판</li>
                                <li data-val="202" class="flex-vc-hl-container" onclick="selectboxClick(this);">작은 이미지 게시판</li>
                                <li data-val="203" class="flex-vc-hl-container" onclick="selectboxClick(this);">큰 이미지 게시판</li>
                                <li data-val="204" class="flex-vc-hl-container" onclick="selectboxClick(this);">웹진형 게시판</li>
                                <li data-val="205" class="flex-vc-hl-container" onclick="selectboxClick(this);">Q&A 게시판</li>
                                <li data-val="206" class="flex-vc-hl-container" onclick="selectboxClick(this);">문의 게시판</li>
                                <li data-val="207" class="flex-vc-hl-container" onclick="selectboxClick(this);">SNS 게시판</li>
                                <li data-val="208" class="flex-vc-hl-container" onclick="selectboxClick(this);">뉴스 게시판</li>
                                <li data-val="401" class="flex-vc-hl-container" onclick="selectboxClick(this);">상품 게시판</li>
                                <li data-val="402" class="flex-vc-hl-container" onclick="selectboxClick(this);">상품 베스트 게시판</li>
                                <li data-val="403" class="flex-vc-hl-container" onclick="selectboxClick(this);">후기 게시판</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="category_attachmentBox admin_fullbox" style="display: none;">
                    <div class="admin_info admin_fullbox">
                        <div class="admin_infoTit flex-vc-hl-container">
                            <span class="admin_infoTitText">PC 상세 이미지</span>
                        </div>
                        <div class="attachfile_box flex-vc-hl-container">
                            <input type="hidden" class="fileTotalNum" value="1"> <!-- 첨부파일 가능 개수 -->
                            <input type="file" id="attachment1" class="attach_btn" multiple onchange="attachClick(this, 'pc', 'siteCategory', 'admin');">
                            <label for="attachment1">
                                <span class="file_design">이미지 첨부</span>
                            </label>
                            <div class="attach_descbox flex-vc-hl-container"><p class="attach_placeholder">최대 1개까지 가능합니다.</p></div>
                            <p class="attach_sdesc">※ 가로 1920픽셀 X 세로 560픽셀 사이즈</p>
                        </div>
                    </div>
                    <div class="admin_info admin_fullbox">
                        <div class="admin_infoTit flex-vc-hl-container">
                            <span class="admin_infoTitText">Mobile 상세 이미지</span>
                        </div>
                        <div class="attachfile_box flex-vc-hl-container">
                            <input type="hidden" class="fileTotalNum" value="1"> <!-- 첨부파일 가능 개수 -->
                            <input type="file" id="attachment2" class="attach_btn" multiple onchange="attachClick(this, 'mobile', 'siteCategory', 'admin');">
                            <label for="attachment2">
                                <span class="file_design">이미지 첨부</span>
                            </label>
                            <div class="attach_descbox flex-vc-hl-container"><p class="attach_placeholder">최대 1개까지 가능합니다.</p></div>
                            <p class="attach_sdesc">※ 가로 480픽셀 X 세로 480픽셀 사이즈</p>
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">두번째 카테고리</span>
                    </div>
                    <div id="twoDepth" class="option_addBox">
                        <div class="option_addList flex-vc-hsb-container">
                            <div class='input_addDesignBox'>
                                <input type='hidden' class='subCategory_idx'>
                                <input type="text" class="input_addDesign input_value" value="" placeholder="카테고리명을 입력해주세요.">
                            </div>
                            <input type="button" class="admin_optionAddBtn" value="추가" onclick="addOption(this);">
                            <input type="button" class="admin_optionDelBtn" value="삭제" onclick="delOption(this);">
                        </div>
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

    /* 소개페이지 클릭시 첨부파일 show 시작 */

    $(".selectbox_depth li").click(function() {

        if ($(this).data("val") == 100) {

            $(".category_attachmentBox").show();

        } else {

            $(".category_attachmentBox").hide();

        }

    })

    /* 소개페이지 클릭시 첨부파일 show 끝 */

    $(".reg_btn").click(function() {

        // 유효성 체크
        if (!document.form.title.value) {

            alert("카테고리명을 입력하세요.");

            document.form.title.focus();

            return false;

        } else if (!document.form.file.value) {

            alert("카테고리 파일명을 입력하세요.");

            document.form.file.focus();

            return false;

        } else if (!document.form.depthType.value) {

            alert("카테고리 타입을 선택하세요.");

            return false;

        }

        const form = $("#siteCategoryRegForm");

        var inputParent = $("#twoDepth").find(".option_addList");

        $(".sub_depth").remove();

        for(ct2=0; ct2 < inputParent.length; ct2++) {

            if(inputParent.eq(ct2).find(".input_value").val() !== ""){

                form.append("<input type='hidden' class='sub_depth' name='twoDepth[]' value='" + inputParent.eq(ct2).find(".input_value").val() + "'>");

            }

        }

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/admin/controller/commonController.php",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                if(data == "success"){

                    if (confirm("리스트로 이동하시겠습니까?")) {

                        location.href = "/admin/view/basic/siteCategoryList";

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

    /* 옵션 추가 시작 */

    function addOption(object) {

        $(".option_addList").removeClass("newOption_addList");

        var optionHtml = $(object).parents(".option_addList").html();

        $(object).parents(".option_addList").after("<div class='option_addList newOption_addList flex-vc-hsb-container'>" + optionHtml + "</div>");

        $(".newOption_addList").find("input[type='hidden']").val("");
        $(".newOption_addList").find("input[type='text']").val("");

    }

    /* 옵션 추가 끝 */

    /* 옵션 삭제 시작 */

    function delOption(object) {

        if( $(object).parents(".option_addBox").find(".option_addList").length > 1) {
    
            $(object).parents(".option_addList").remove();
    
        } else {
    
            alert("최소 개수는 1개 입니다.");
    
        }

    }

    /* 옵션 삭제 끝 */

</script>