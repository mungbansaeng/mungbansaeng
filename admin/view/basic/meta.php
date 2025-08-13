<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">메타태그 설정</h3>
        <form id="metaForm">
            <input type="hidden" name="page" value="meta">
            <input type="hidden" name="act" value="modify">
            <div class="admin_infobox">
                <div class="admin_info">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">사이트 타이틀</span>
                    </div>
                    <div>
                        <input type="text" name="siteTit" class="input_fullDesign" value="<?=$meta['siteTit']?>" placeholder="홈페이지 제목">
                    </div>
                </div>
                <div class="admin_info">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">Keyword</span>
                    </div>
                    <div>
                        <input type="text" name="siteKeyword" class="input_fullDesign" value="<?=$meta['siteKeyword']?>" placeholder="홈페이지 키워드">
                    </div>
                </div>
                <div class="admin_info">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">Description</span>
                    </div>
                    <div>
                        <input type="text" name="siteDescription" class="input_fullDesign" value="<?=$meta['siteDescription']?>" placeholder="홈페이지 설명">
                    </div>
                </div>
                <div class="admin_info">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">사이트 주소</span>
                    </div>
                    <div>
                        <input type="text" name="siteUrl" class="input_fullDesign" value="<?=$meta['siteUrl']?>" placeholder="사이트 주소">
                    </div>
                </div>
                <div class="admin_info">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">네이버 검색엔진 정보</span>
                    </div>
                    <div>
                        <input type="text" name="naverVerification" class="input_fullDesign" value="<?=$meta['naverVerification']?>" placeholder="네이버 검색등록">
                    </div>
                </div>
                <div class="admin_info">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">구글 검색엔진 정보</span>
                    </div>
                    <div>
                        <input type="text" name="googleVerification" class="input_fullDesign" value="<?=$meta['googleVerification']?>" placeholder="구글 검색등록">
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

    $(".modify_btn").click(function(){

        const form = $("#metaForm");

        $.ajax({
            type: "POST", 
            dataType: "html",
            async: true,
            url: "/admin/controller/commonController.php",
            global: false,
            data: form.serialize(),
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

</script>