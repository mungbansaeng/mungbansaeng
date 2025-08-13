<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/controller/commonController.php";

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">상품 엑셀 설정 등록</h3>
        <form id="productExcelForm" name="form">
            <input type="hidden" name="page" value="productExcelConfig">
            <input type="hidden" name="act" value="reg">
            <div class="admin_infobox flex-vc-hsb-container">
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">엑셀 제목</span>
                    </div>
                    <div>
                        <input type="text" name="title" class="input_fullDesign title" placeholder="엑셀 제목을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">엑셀 항목 선택</span>
                        <div class="help_box">
                            <span class="help_icon flex-vc-hc-container" onclick="openHelp(this);">?</span>
                            <div class="help_descBox">
                                <div class="help_descTit">엑셀 항목 선택</div>
                                <div class="help_desc">
                                    아래 항목중 엑셀에 필요한 항목을 선택해주세요.
                                </div>
                                <div class="help_descClose" onclick="closeHelp();">닫기</div>
                            </div>
                        </div>
                    </div>
                    <div class="admin_infoCheckbox">
                        
                    </div>
                </div>
                <div class="admin_btnBox">
                    <input type="button" class="admin_btn reg_btn" value="등록하기">
                    <input type="button" class="admin_backBtn" onclick="location.href='./productExcelConfigList'" value="돌아가기">
                </div> 
            </div>
        </form>
    </div>
</div>

<script>

    // 상품 db 내역 가져오기

    function productDbList () {

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/admin/controller/productController.php",
            global: false,
            data: {
                "page": "productExcelConfig",
                "act": "excelItem"
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                let excelItem = "";

                for (ei=1; ei < data.length; ei++) {                    

                    if (data[ei]['column_comment'] == "브랜드 고유번호" || data[ei]['column_comment'] == "상품 상태") {

                        excelItem += "";

                    } else {

                        excelItem += "<div class='admin_infoCheck'><input type='checkbox' class='excel_item'  id='excelItem" + ei + "' value='" + data[ei]['column_name'] + "'><label for='excelItem" + ei + "'><p class='v_designCheck'><span class='v_designChecked'></span></p>" + data[ei]['column_comment'] + "</label><input type='hidden' class='excel_itemName'  id='excelItemName" + ei + "' value='" + data[ei]['column_comment'] + "'></div>";

                    }

                }

                $(".admin_infoCheckbox").html(excelItem);

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    productDbList();

    $(".reg_btn").click(function() {

        const form = $("#productExcelForm");

        // 유효성 체크
        if (!document.form.title.value) {

            alert("엑셀 제목을 입력하세요.");

            document.form.title.focus();

            return false;

        }

        var eic = 0;

        var excelItem = "";
        var excelItemName = "";

        for (ei=0; ei < $(".admin_infoCheck").length; ei++) {

            if ($(".admin_infoCheck").eq(ei).find("input").prop("checked") == true) {

                excelItem += "◈p." + $(".admin_infoCheck").eq(ei).find("input[type='checkbox']").val();

                excelItemName += "◈" + $(".admin_infoCheck").eq(ei).find("input[type='hidden']").val();

                eic++;

            }

        }

        var excelItemVal = excelItem.substr(1);
        var excelItemNameVal = excelItemName.substr(1);

        form.append("<input type='hidden' name='excelItem' value='" + excelItemVal + "'>");

        form.append("<input type='hidden' name='excelItemName' value='" + excelItemNameVal + "'>");

        if (eic == 0){

            alert("엑셀 항목을 한개이상 선택해주세요.");

            return false;

        }

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/admin/controller/productController.php",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                if(data == "success"){

                    if (confirm("리스트로 이동하시겠습니까?")) {

                        location.href = "/admin/view/product/productExcelConfigList";

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