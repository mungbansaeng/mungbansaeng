<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/controller/productController.php";

?>

<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">상품 브랜드 수정</h3>
        <form id="produtModifyForm" name="form">
            <input type="hidden" name="page" class="page" value="productBrand">
            <input type="hidden" name="act" class="act" value="modifyView">
            <div class="admin_infobox flex-vc-hsb-container">
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">상품 브랜드 이미지</span>
                    </div>
                    <div class="attachfile_box flex-vc-hl-container">
                        <input type="hidden" class="fileTotalNum" value="1"> <!-- 첨부파일 가능 개수 -->
                        <input type="file" id="attachment" class="attach_btn" multiple onchange="attachClick(this, 'productBrand', 'productBrand', 'admin');">
                        <label for="attachment">
                            <span class="file_design">이미지 첨부</span>
                        </label>
                        <div class="attach_descbox flex-vc-hl-container"><p class="attach_placeholder">최대 1개까지 가능합니다.</p></div>
                        <p class="attach_sdesc">※ 가로 600픽셀 X 세로 600픽셀 사이즈</p>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">브랜드명</span>
                    </div>
                    <div>
                        <input type="text" name="title" class="input_fullDesign title" placeholder="브랜드명을 입력하세요.">
                    </div>
                </div>
                </div>
                <div class="admin_btnBox">
                    <input type="button" class="admin_btn reg_btn" value="수정하기">
                    <input type="button" class="admin_backBtn" onclick="location.href='./productBrandList'" value="돌아가기">
                </div> 
            </div>
        </form>
    </div>
</div>

<script>

    const form = $("#produtModifyForm");
    
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

            // 브랜드명
            $(".title").val(data[0]['title']);

            // 첨부파일
            var attachArray = data[1];
            var attachDescWith = 100 / (attachArray.length / 2);
            var table = $(".page").val();

            if (attachArray.length > 0) {

                for (ac=0; ac < attachArray.length; ac++) {

                    $("#attachment").siblings('.attach_descbox').find(".attach_placeholder").hide();

                    $("#attachment").siblings('.attach_descbox').append("<div class='attach_desclist' style='width: calc(" + attachDescWith + "% - 10px);'><input type='text' name='uploadName' readonly value='" + attachArray[ac]['originFileName'] + "'><input type='hidden' name='transfileName' class='transfileName' value='" + attachArray[ac]['fileName'] + "'><input type='hidden' id='fileIdx" + ac + "' class='file_idx' name='fileIdx' value='" + attachArray[ac]['idx'] + "'><p class='attach_del' onclick=\"attachDel(this, '" + table + "', 'admin');\"><img src='../../resources/images/attach_del.png' alt=''></p></div>");

                }
                
            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

    $(".reg_btn").click(function() {

        // 유효성 체크
        if (!document.form.title.value) {

            alert("브랜드명을 입력하세요.");

            document.form.title.focus();

            return false;

        }

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

                // console.log(data);

                if(data == "success"){

                    if (confirm("현재 페이지를 닫으시겠습니까?")) {

                        location.href = "/admin/view/product/productBrandList";

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

        $(object).parents(".option_addList").after("<div class='option_addList multiOption_addList newOption_addList flex-vc-hsb-container'>" + optionHtml + "</div>");

        $(".newOption_addList").find("input[type='hidden']").val("");
        $(".newOption_addList").find("input[type='text']").val("");

        $(".newOption_addList .selectbox_text").html("카테고리 선택");
        $(".newOption_addList .twoDepth").html("");
        $(".newOption_addList .threeDepth").html("");
        $(".newOption_addList .selectedValue").val("");

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