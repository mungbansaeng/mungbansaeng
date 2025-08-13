<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/controller/commonController.php";

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">사이트 카테고리 수정</h3>
        <form id="siteCategoryModiForm" name="form">
            <input type="hidden" class="page" name="page" value="siteCategory">
            <input type="hidden" class="act" name="act" value="modifyView">
            <div class="admin_infobox flex-vc-hsb-container">
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">
                            <?
                            
                                if ($_GET['depth'] == 1) {

                                    echo "첫번째 카테고리";

                                } else if ($_GET['depth'] == 2) {

                                    echo "두번째 카테고리";

                                } else if ($_GET['depth'] == 3) {

                                    echo "세번째 카테고리";

                                }
                            
                            ?>
                        </span>
                    </div>
                    <div>
                        <input type="text" name="title" class="input_fullDesign" placeholder="카테고리명을 입력하세요.">
                    </div>
                </div>
                <?
                
                    if ($_GET['depth'] == 1) {
                
                ?>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">첫번째 파일명</span>
                    </div>
                    <div>
                        <input type="text" name="file" class="input_fullDesign" placeholder="파일명을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_fullbox category_type">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">카테고리 타입</span>
                    </div>
                    <div>
                        <div class="selectbox">
                            <input type="hidden" class="selectedValue" name="depthType">
                            <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                <span class="selectbox_text">카테고리 선택</span>
                                <span class="select_arrow"></span>
                            </p>
                            <ul class="selectbox_depth">
                                <li data-val="100" class="flex-vc-hl-container" onclick="selectboxClick(this);">소개 페이지</li>
                                <li data-val="201" class="flex-vc-hl-container" onclick="selectboxClick(this);">리스트 게시판</li>
                                <li data-val="202" class="flex-vc-hl-container" onclick="selectboxClick(this);">작은 이미지 게시판</li>
                                <li data-val="203" class="flex-vc-hl-container" onclick="selectboxClick(this);">큰 이미지 게시판</li>
                                <li data-val="207" class="flex-vc-hl-container" onclick="selectboxClick(this);">SNS형 게시판</li>
                                <li data-val="204" class="flex-vc-hl-container" onclick="selectboxClick(this);">웹진형 게시판</li>
                                <li data-val="205" class="flex-vc-hl-container" onclick="selectboxClick(this);">Q&A 게시판</li>
                                <li data-val="206" class="flex-vc-hl-container" onclick="selectboxClick(this);">문의 게시판</li>
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
                            <div class="attach_descbox pc_attach_descbox flex-vc-hl-container"><p class="attach_placeholder">최대 1개까지 가능합니다.</p></div>
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
                            <div class="attach_descbox mobile_attach_descbox flex-vc-hl-container"><p class="attach_placeholder">최대 1개까지 가능합니다.</p></div>
                            <p class="attach_sdesc">※ 가로 480픽셀 X 세로 480픽셀 사이즈</p>
                        </div>
                    </div>
                </div>
                <?}?>
                <?
                            
                    if ($_GET['depth'] < 3) {

                ?>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">
                            <?
                            
                                if ($_GET['depth'] == 1) {

                                    echo "두번째 카테고리";

                                } else if ($_GET['depth'] == 2) {

                                    echo "세번째 카테고리";

                                }
                            
                            ?>
                        </span>
                        <span id="optionListBtn" class="admin_smallBtn flex-vc-hc-container" onclick="subCategoryModify(this, 'modify');">수정</span>
                    </div>
                    <div id="subDepth" class="option_addBox">
                        
                    </div>
                </div>
                <?}?>
                <div class="admin_btnBox">
                    <input type="button" class="admin_btn reg_btn" value="수정하기">
                    <input type="button" class="admin_backBtn" onclick="location.href='./siteCategoryList'" value="돌아가기">
                </div> 
            </div>
        </form>
    </div>
</div>

<script>

    const form = $("#siteCategoryModiForm");

    form.append("<input type='hidden' name='depth' class='depth' value='<?=$_GET['depth']?>'>");
    form.append("<input type='hidden' name='idx' value='<?=$_GET['idx']?>'>");

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

            if (data[0] == "success") {

                if ($("input[name='depth']").val() == 1) {
                    
                    $depth = 2;

                    $("input[name='file']").val(data[1][0]['file']);

                    for (sd=0; sd < $(".selectbox_depth li").length; sd++) {

                        if ($(".selectbox_depth li").eq(sd).attr("data-val") == data[1][0]['depthType']) {

                            $(".selectbox_text").text($(".selectbox_depth li").eq(sd).text());

                            if (data[1][0]['depthType'] == 100) {

                                $(".category_attachmentBox").show();

                            } else {

                                $(".category_attachmentBox").hide();

                            }

                        }

                    }

                    $(".selectedValue").val(data[1][0]['depthType']);

                    // 첨부파일
                    var table = $(".page").val();

                    $('.attach_descbox').find(".attach_placeholder").hide();

                    for (ac=0; ac < data[1].length; ac++) {

                        $("." + data[1][ac]['type'] + "_attach_descbox").append("<div class='attach_desclist' style='width: calc(100% - 10px);'><input type='text' name='uploadName' readonly value='" + data[1][ac]['originFileName'] + "'><input type='hidden' name='transfileName' class='transfileName' value='" + data[1][ac]['fileName'] + "'><input type='hidden' id='fileIdx1' class='file_idx' name='fileIdx' value='" + data[1][ac]['idx'] + "'><p class='attach_del' onclick=\"attachDel(this, '" + table + "', 'admin');\"><img src='../../resources/images/attach_del.png' alt=''></p></div>");

                    }

                } else if ($("input[name='depth']").val() == 2) {

                    $depth = 3;

                }
                
                $("input[name='title']").val(data[1][0]['title']);

                var subDepthHtml = "";

                var subDepth = data[2];

                if (subDepth.length > 0) {

                    for (sd=0; sd < subDepth.length; sd++) {

                        subDepthHtml += "<div class='option_readList'><a href='?depth=" + $depth + "&idx=" + subDepth[sd]['idx'] + "'><input type='text' class='input_fullDesign' value='" + subDepth[sd]['title'] + "로 이동하기' readonly></a></div>";

                    }

                } else {

                    subDepthHtml += "<div class='flex-vc-hl-container'>카테고리가 없습니다.</div>";

                }

                $("#subDepth").html(subDepthHtml);

            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

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
        if (document.form.depth.value == 1) {

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

        } else {

            if (!document.form.title.value) {

                alert("카테고리명을 입력하세요.");

                document.form.title.focus();

                return false;

            }

        }

        const form = $("#siteCategoryModiForm");

        $(".act").val("modify");

        var inputParent = $("#subDepth").find(".option_addList");

        $(".sub_depth").remove();

        for(ct2=0; ct2 < inputParent.length; ct2++) {

            if(inputParent.eq(ct2).find(".input_value").val() !== ""){

                form.append("<input type='hidden' class='sub_depth' name='subDepthIdx[]' value='" + inputParent.eq(ct2).find(".subCategory_idx").val() + "'>");

                form.append("<input type='hidden' class='sub_depth' name='subDepthTitle[]' value='" + inputParent.eq(ct2).find(".input_value").val() + "'>");

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

    function subCategoryModify (object, type) {

        if (type == "modify") {

            $(object).attr("onclick", "subCategoryModify (this, 'cancel')");
            $(object).text("리스트");

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

                    if (data[0] == "success") {

                        var subDepthHtml = "";

                        var subDepth = data[2];

                        if (subDepth.length > 0) {

                            for (sd=0; sd < subDepth.length; sd++) {

                                subDepthHtml += "<div class='option_addList flex-vc-hsb-container'><div class='input_addDesignBox'><input type='hidden' class='subCategory_idx' value='" + subDepth[sd]['idx'] + "'><input type='text' class='input_addDesign input_value' value='" + subDepth[sd]['title'] + "' placeholder='카테고리명을 입력해주세요.'><ul class='order_arrow'><li onclick=\"sortChange(this, 'up', " + subDepth[sd]['sort'] + ")\">▲</li><li onclick=\"sortChange(this, 'down', " + subDepth[sd]['sort'] + ")\">▼</li></ul></div><input type='button' class='admin_optionAddBtn' value='추가' onclick='addOption(this);'><input type='button' class='admin_optionDelBtn' value='삭제' onclick='delOption(this);'></div>";

                            }

                        } else {

                            subDepthHtml += "<div class='option_addList flex-vc-hsb-container'><div class='input_addDesignBox'><input type='hidden' class='subCategory_idx'><input type='text' class='input_addDesign input_value' value='' placeholder='카테고리명을 입력해주세요.'></div><input type='button' class='admin_optionAddBtn' value='추가' onclick='addOption(this);'><input type='button' class='admin_optionDelBtn' value='삭제' onclick='delOption(this);'></div>";

                        }

                        $("#subDepth").html(subDepthHtml);

                    }

                },
                error:function(request,status,error){

                    console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                    
                }
                
            });

        } else {

            $(object).attr("onclick", "subCategoryModify (this, 'modify')");
            $(object).text("수정");

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

                    if (data[0] == "success") {

                        if ($("input[name='depth']").val() == 1) {

                            $depth = 2;

                        } else if ($("input[name='depth']").val() == 2) {

                            $depth = 3;

                        }

                        var subDepthHtml = "";

                        var subDepth = data[2];

                        if (subDepth.length > 0) {

                            for (sd=0; sd < subDepth.length; sd++) {

                                subDepthHtml += "<div class='option_readList'><a href='?depth=" + $depth + "&idx=" + subDepth[sd]['idx'] + "'><input type='text' class='input_fullDesign' value='" + subDepth[sd]['title'] + "로 이동하기' readonly></a></div>";

                            }

                        } else {

                            subDepthHtml += "<div class='flex-vc-hl-container'>카테고리가 없습니다.</div>";

                        }

                        $("#subDepth").html(subDepthHtml);

                    }

                },
                error:function(request,status,error){

                    console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                    
                }
                
            });

        }

    }

    function sortChange (object, type, sort) {

        $(".act").val("sortChange");

        $(".page").val("siteSubCategory");

        $(".sortIdx").remove();

        $(".sortType").remove();

        $(".sortNum").remove();

        const form = $("#siteCategoryModiForm");

        let idx = $(object).parents(".option_addList").find(".subCategory_idx").val();

        $("#siteCategoryModiForm").append("<input type='hidden' class='sortIdx' name='sortIdx' value='" + idx + "'>");

        $("#siteCategoryModiForm").append("<input type='hidden' class='sortType' name='sortType' value='" + type + "'>");

        $("#siteCategoryModiForm").append("<input type='hidden' class='sortNum' name='sortNum' value='" + sort + "'>");

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

                if (data[0] == "success") {

                    var subDepthHtml = "";

                    var subDepth = data[2];

                    for (sd=0; sd < subDepth.length; sd++) {

                        subDepthHtml += "<div class='option_addList flex-vc-hsb-container'><div class='input_addDesignBox'><input type='hidden' class='subCategory_idx' value='" + subDepth[sd]['idx'] + "'><input type='text' class='input_addDesign input_value' value='" + subDepth[sd]['title'] + "' placeholder='카테고리명을 입력해주세요.'><ul class='order_arrow'><li onclick=\"sortChange(this, 'up', " + subDepth[sd]['sort'] + ")\">▲</li><li onclick=\"sortChange(this, 'down', " + subDepth[sd]['sort'] + ")\">▼</li></ul></div><input type='button' class='admin_optionAddBtn' value='추가' onclick='addOption(this);'><input type='button' class='admin_optionDelBtn' value='삭제' onclick='delOption(this);'></div>";

                    }

                    $("#subDepth").html(subDepthHtml);

                } else if (data == "last") {

                    alert("마지막 카테고리 입니다.");

                } else if (data == "first") {

                    alert("첫번째 카테고리 입니다.");

                } else {

                    alert("오류가 발생했습니다. 개발자에게 문의해주세요.");

                }

                $(".act").val("modifyView");

                $(".page").val("siteCategory");

                $(".sortIdx").remove();

                $(".sortType").remove();

                $(".sortNum").remove();

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

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

        $(".act").val("subCategoryDelete");
        $(".page").val("siteSubCategory");

        let idx = $(object).parents(".option_addList").find(".subCategory_idx").val();

        $("#siteCategoryModiForm").append("<input type='hidden' name='subCategoryIdx' value='" + idx + "'>");

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

                    $(".act").val("modifyView");

                    $(object).parents(".option_addList").remove();
    
                    if( $(".option_addBox").find(".option_addList").length < 1) {

                        $("#subDepth").html("<div class='flex-vc-hl-container'>카테고리가 없습니다.</div>");

                        $("#optionListBtn").attr("onclick", "subCategoryModify (this, 'modify')");
                        $("#optionListBtn").text("수정");
                
                    }
    
                }else{
    
                    document.write(data);
    
                }
    
            },
            error:function(request,status,error){
    
                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    /* 옵션 삭제 끝 */

</script>