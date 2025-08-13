<?php

    $page = "ip";

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/controller/commonController.php";

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">접속ip 설정</h3>
        <div class="admin_infobox">
            <div class="admin_info">
                <p class="admin_infoTit">접속 ip 추가</p>
                <div class="option_addBox">
                    <?

                        for($ci=0; $ci < COUNT($connectIp); $ci++){
                    
                    ?>
                    <div class="option_addList flex-vc-hsb-container">
                        <div class="input_addDesignBox">
                            <input type="text" class="input_addDesign connectIp" value="<?=$connectIp[$ci]?>" placeholder="ip를 입력해주세요.">
                        </div>
                        <input type="button" class="admin_optionAddBtn" value="추가" onclick="addOption(this);">
                        <input type="button" class="admin_optionDelBtn" value="삭제" onclick="delOption(this);">
                    </div>
                    <?}?>
                </div>
            </div>
            <div class="admin_btnBox">
                <input type="button" class="admin_btn modify_btn" value="등록하기">
            </div> 
        </div>
    </div>
</div>

<script>

    $(".modify_btn").click(function(){

        var adminIp = "";

        for(ic=0; ic < $(".connectIp").length; ic++) {

            if($(".connectIp").eq(ic).val() !== ""){

                adminIp += ic == 0 ? $(".connectIp").eq(ic).val() : "◈" + $(".connectIp").eq(ic).val();

            }

        }

        $.ajax({
            type: "POST", 
            dataType: "html",
            async: true,
            url: "/admin/controller/commonController.php",
            global: false,
            data: {
                "page": "ip",
                "act": "modify",
                "adminIp": adminIp
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(msg){

                if(msg == "success"){

                    location.reload();

                }else{

                    document.write(msg);

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

        $.ajax({
            type: "POST", 
            dataType: "html",
            async: true,
            url: "/admin/controller/commonController.php",
            global: false,
            data: {
                "page": "ip",
                "act": "modify",
                "adminIp": adminIp
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(msg){

                if(msg == "success"){

                    location.reload();

                }else{

                    document.write(msg);

                }

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    /* 옵션 삭제 끝 */

</script>