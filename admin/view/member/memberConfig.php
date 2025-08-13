<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">회원 공통 설정</h3>
        <form id="memberConfigForm">
            <input type="hidden" name="page" class="page" value="memberConfig">
            <input type="hidden" name="act" class="act" value="modifyView">
            <div class="admin_infobox">
                <div class="admin_info">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">회원등급 설정</span>
                    </div>
                    <p class="admin_infoTit_sdesc">※ 회원등급은 한번 설정하면 수정만 가능하며 추가, 삭제가 불가합니다.</p>
                    <p class="admin_infoTit_sdesc">※ 회원등급은 가장 낮은 등급부터 입력하시고 임직원을 제일 먼저 입력해주시기 바랍니다.</p>
                    <div class="option_addList flex-vc-hsb-container">
                        <div class="input_addDesignFullBox input_addDesignBoxTit flex-vc-hsb-container">
                            <p>회원등급명</p>
                            <p>할인율</p>
                            <p>적립퍼센트</p>
                            <p>무료배송 최소금액</p>
                            <p>등급 달성 금액</p>
                            <p>수정/삭제</p>
                        </div>
                    </div>
                    <div class="option_addBox">
                        <div class="option_addList flex-vc-hsb-container">
                            <div class="input_addDesignBox flex-vc-hsb-container">
                                <input type="text" class="input_addDesign five_input memberLevelName" value="" placeholder="회원등급명을 입력해주세요.">
                                <input type="text" class="input_addDesign five_input memberLevelDiscount" oninput="inputonlyNum(this);" value="" placeholder="할인율을 입력해주세요.">
                                <input type="text" class="input_addDesign five_input memberLevelPoint" oninput="inputonlyNum(this);" value="" placeholder="적립퍼센트를 입력해주세요.">
                                <input type="text" class="input_addDesign five_input memberLevelDeliveryMinPrice" oninput="inputonlyNum(this); liveNumberComma(this);" value="" placeholder="무료배송 최소금액을 입력해주세요.">
                                <input type="text" class="input_addDesign five_input memberLevelMinPrice" oninput="inputonlyNum(this); liveNumberComma(this);" value="" placeholder="등급 달성 금액을 입력해주세요.">
                            </div>
                            <input type="button" class="admin_optionAddBtn" value="추가" onclick="addOption(this);">
                            <input type="button" class="admin_optionDelBtn" value="삭제" onclick="delOption(this);">
                        </div>
                    </div>
                </div>
                <div class="admin_info">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">회원가입시 지급 포인트</span>
                    </div>
                    <div>
                        <input type="text" name="memberJoinPoint" class="input_fullDesign memberJoinPoint" value="0" placeholder="회원가입시 지급 포인트를 입력하세요." oninput="inputonlyNum(this); liveNumberComma(this);">
                    </div>
                </div>
                <div class="admin_info">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">회원가입시 추천인 지급 포인트</span>
                    </div>
                    <div>
                        <input type="text" name="recommenderPoint" class="input_fullDesign recommenderPoint" value="0" placeholder="회원가입시 추천인 지급 포인트를 입력하세요." oninput="inputonlyNum(this); liveNumberComma(this);">
                    </div>
                </div>
                <div class="admin_btnBox">
                    <input type="button" class="admin_btn reg_btn" value="등록하기">
                </div> 
            </div>
        </form>
    </div>
</div>

<script>

    const form = $("#memberConfigForm");

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/admin/controller/memberController.php",
        global: false,
        data: form.serialize(),
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            if (data[0] == "success") {

                let memberConfigList = "";
                
                if (data[2]['memberLevelName'] !== "") {

                    $(".option_addBox").html("") // 초기화

                    for (mc=0; mc < data[2].length; mc++) {

                        memberConfigList += "<div class='option_addList flex-vc-hsb-container'><div class='input_addDesignBox flex-vc-hsb-container'><input type='text' class='input_addDesign five_input memberLevelName' value='" + data[2][mc]['memberLevelName'] + "' placeholder='회원등급명을 입력해주세요.'><input type='text' class='input_addDesign five_input memberLevelDiscount' oninput='inputonlyNum(this);' value='" + data[2][mc]['memberLevelDiscount'] + "' placeholder='할인율을 입력해주세요.'><input type='text' class='input_addDesign five_input memberLevelPoint' oninput='inputonlyNum(this);' value='" + data[2][mc]['memberLevelPoint'] + "' placeholder='적립퍼센트를 입력해주세요.'><input type='text' class='input_addDesign five_input memberLevelDeliveryMinPrice' oninput='inputonlyNum(this); liveNumberComma(this);' value='" + comma(data[2][mc]['memberLevelDeliveryMinPrice']) + "' placeholder='무료배송 최소금액을 입력해주세요.'><input type='text' class='input_addDesign five_input memberLevelMinPrice' oninput='inputonlyNum(this); liveNumberComma(this);' value='" + comma(data[2][mc]['memberLevelMinPrice']) + "' placeholder='등급 달성 금액을 입력해주세요.'></div><input type='button' class='admin_optionAddBtn' value='추가' onclick='addOption(this);'><input type='button' class='admin_optionDelBtn' value='삭제' onclick='delOption(this);'></div>";

                    }

                    $(".option_addBox").html(memberConfigList);

                }

                $(".memberJoinPoint").val(data[1]['memberJoinPoint']);

                $(".recommenderPoint").val(data[1]['recommenderPoint']);

            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

    $(".reg_btn").click(function(){

        var memberLevel = "";
        var memberLevelName = "";
        var memberLevelDiscount = "";
        var memberLevelPoint = "";
        var memberLevelDeliveryMinPrice = "";
        var memberLevelMinPrice = "";

        for(ic=0; ic < $(".memberLevelName").length; ic++) {

            if($(".memberLevelName").eq(ic).val() !== ""){

                let memberLevelDeliveryMinPriceReplace = $(".memberLevelDeliveryMinPrice").eq(ic).val().replace(",", "");

                let memberLevelMinPriceReplace = $(".memberLevelMinPrice").eq(ic).val().replace(",", "");

                memberLevel += ic == 0 ? (ic + 1) * 100 : "◈" + (ic + 1) * 100;
                memberLevelName += ic == 0 ? $(".memberLevelName").eq(ic).val() : "◈" + $(".memberLevelName").eq(ic).val();
                memberLevelDiscount += ic == 0 ? $(".memberLevelDiscount").eq(ic).val() : "◈" + $(".memberLevelDiscount").eq(ic).val();
                memberLevelPoint += ic == 0 ? $(".memberLevelPoint").eq(ic).val() : "◈" + $(".memberLevelPoint").eq(ic).val();
                memberLevelDeliveryMinPrice += ic == 0 ? memberLevelDeliveryMinPriceReplace : "◈" + memberLevelDeliveryMinPriceReplace;
                memberLevelMinPrice += ic == 0 ? memberLevelMinPriceReplace : "◈" + memberLevelMinPriceReplace;

            }

        }

        let memberJoinPoint = $(".memberJoinPoint").val().replace(",", "");

        let recommenderPoint = $(".recommenderPoint").val().replace(",", "");

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/admin/controller/memberController.php",
            global: false,
            data: {
                "page": "memberConfig",
                "act": "modify",
                "memberLevel": memberLevel,
                "memberLevelName": memberLevelName,
                "memberLevelDiscount": memberLevelDiscount,
                "memberLevelPoint": memberLevelPoint,
                "memberLevelDeliveryMinPrice": memberLevelDeliveryMinPrice,
                "memberLevelMinPrice": memberLevelMinPrice,
                "memberJoinPoint": memberJoinPoint,
                "recommenderPoint": recommenderPoint
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                console.log(data);

                // if (data == "success") {

                //     location.reload();

                // } else {

                //     alert("오류가 발생했습니다. 개발자에게 문의해주세요.");

                // }

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

        $(".newOption_addList").find("input[type='text']").val("");
        $(".newOption_addList").find(".admin_optionDelBtn").attr("onclick", "delOption(this);");

    }

    /* 옵션 추가 끝 */

    /* 옵션 삭제 시작 */

    function delOption(object) {

        if( $(object).parents(".option_addBox").find(".option_addList").length > 1) {

            $(object).parents(".option_addList").remove();
    
        } else {
    
            alert("최소 개수는 1개 입니다.");
    
        }

        var adminIp = "";

        for(ic=0; ic < $(".connectIp").length; ic++) {

            if($(".connectIp").eq(ic).val() !== ""){

                adminIp += ic == 0 ? $(".connectIp").eq(ic).val() : "◈" + $(".connectIp").eq(ic).val();

            }

        }

        // $.ajax({
        //     type: "POST", 
        //     dataType: "html",
        //     async: true,
        //     url: "/admin/controller/commonController.php",
        //     global: false,
        //     data: {
        //         "page": "ip",
        //         "act": "modify",
        //         "adminIp": adminIp
        //     },
        //     traditional: true,
        //     beforeSend:function(xhr){
        //     },
        //     success:function(msg){

        //         if(msg == "success"){

        //             location.reload();

        //         }else{

        //             document.write(msg);

        //         }

        //     },
        //     error:function(request,status,error){

        //         console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
        //     }
            
        // });

    }

    /* 옵션 삭제 끝 */    

</script>