<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/controller/productController.php";

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">상품공통 설정</h3>
        <form id="productConfigForm">
            <input type="hidden" name="page" class="page" value="productConfig">
            <input type="hidden" name="act" class="act" value="modifyView">
            <div class="admin_infobox flex-vc-hsb-container">
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">무료배송 최소금액 (단위 원)</span>
                    </div>
                    <div>
                        <input type="text" name="deliveryMinPrice" class="input_fullDesign deliveryMinPrice" value="" placeholder="무료배송 최소금액을 입력해주세요." oninput="inputonlyNum(this); liveNumberComma(this);">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">배송비 (단위 원)</span>
                    </div>
                    <div>
                        <input type="text" name="deliveryPrice" class="input_fullDesign deliveryPrice" value="" placeholder="배송비를 입력하세요." oninput="inputonlyNum(this); liveNumberComma(this);">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">배송기간 (단위 일)</span>
                    </div>
                    <div>
                        <input type="text" name="deliveryDate" class="input_fullDesign deliveryDate" value="" placeholder="기본 배송기간을 입력하세요." oninput="inputonlyNum(this);">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">일반 후기 적립금 (단위 원)</span>
                    </div>
                    <div>
                        <input type="text" name="reviewPoint" class="input_fullDesign reviewPoint" value="" placeholder="일반 후기 적립금을 입력하세요." oninput="inputonlyNum(this);">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">포토 후기 적립금 (단위 원)</span>
                    </div>
                    <div>
                        <input type="text" name="photoReviewPoint" class="input_fullDesign photoReviewPoint" value="" placeholder="포토 후기 적립금을 입력하세요." oninput="inputonlyNum(this);">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">동영상 후기 적립금 (단위 원)</span>
                    </div>
                    <div>
                        <input type="text" name="videoReviewPoint" class="input_fullDesign videoReviewPoint" value="" placeholder="동영상 후기 적립금을 입력하세요." oninput="inputonlyNum(this);">
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

    const form = $("#productConfigForm");

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

            if (data[0] == "success") {

                $(".deliveryMinPrice").val(comma(data[1]['deliveryMinPrice']));
                $(".deliveryPrice").val(comma(data[1]['deliveryPrice']));
                $(".deliveryDate").val(data[1]['deliveryDate']);
                $(".buyPoint").val(data[1]['buyPoint']);
                $(".reviewPoint").val(data[1]['reviewPoint']);
                $(".photoReviewPoint").val(data[1]['photoReviewPoint']);
                $(".videoReviewPoint").val(data[1]['videoReviewPoint']);

            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

    $(".modify_btn").click(function(){

        $(".act").val("modify");

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

                if(data[0] == "success"){

                    location.reload();

                }

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    });

</script>