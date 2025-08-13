<?php

    $page = "homepageConfig";

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/controller/commonController.php";

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">홈페이지 설정</h3>
        <form id="homepageConfigForm">
            <input type="hidden" name="page" class="page" value="homepageConfig">
            <input type="hidden" name="act" class="act" value="modifyView">
            <div class="admin_infobox flex-vc-hsb-container">
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">홈페이지 로고</span>
                    </div>
                    <div class="attachfile_box flex-vc-hl-container">
                        <input type="hidden" class="fileTotalNum" value="1"> <!-- 첨부파일 가능 개수 -->
                        <input type="file" id="attachment1" class="attach_btn" multiple onchange="attachClick(this, 'logo', 'config', 'admin');">
                        <label for="attachment1">
                            <span class="file_design">이미지 첨부</span>
                        </label>
                        <div class="attach_descbox flex-vc-hl-container">
                            <?
                            
                                if (!$config['fileName']) {
                            
                            ?>
                            <p class="attach_placeholder">최대 1개까지 가능합니다.</p>
                            <?
                            
                                } else {
                            
                            ?>
                            <p class="attach_placeholder" style="display: none;">최대 1개까지 가능합니다.</p>
                            <div class="attach_desclist" style="width: calc(100% - 10px);">
                                <input type="text" name="uploadName" readonly value="<?=$config['originFileName']?>">
                                <input type="hidden" name="transfileName[]" class="transfileName" value="<?=$config['fileName']?>">
                                <input type="hidden" id="fileIdx0" class="file_idx" name="fileIdx[]" value="<?=$config['idx']?>">
                                <p class="attach_del" onclick="attachDel(this, 'config', 'admin');">
                                    <img src="../../resources/images/attach_del.png" alt="">
                                </p>
                            </div>
                            <?}?>
                        </div>
                        <p class="attach_sdesc">※ 가로 최대 180픽셀 X 세로 최대 52픽셀 사이즈</p>
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">업체명</span>
                    </div>
                    <div>
                        <input type="text" name="companyName" class="input_fullDesign" value="<?=$config['companyName']?>" placeholder="업체명을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">사이트명</span>
                    </div>
                    <div>
                        <input type="text" name="siteName" class="input_fullDesign" value="<?=$config['siteName']?>" placeholder="사이트명을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">대표자명</span>
                    </div>
                    <div>
                        <input type="text" name="ceoName" class="input_fullDesign" value="<?=$config['ceoName']?>" placeholder="대표자명을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">정보보호책임자명</span>
                    </div>
                    <div>
                        <input type="text" name="privateProtectionName" class="input_fullDesign" value="<?=$config['privateProtectionName']?>" placeholder="정보보호책임자명을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">업체 주소</span>
                    </div>
                    <div>
                        <input type="text" name="companyAddress" class="input_fullDesign" value="<?=$config['companyAddress']?>" placeholder="업체 주소를 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">고객센터 전화번호</span>
                    </div>
                    <div>
                        <input type="text" name="companyCall" class="input_fullDesign" value="<?=$config['companyCall']?>" placeholder="고객센터 전화번호를 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">FAX</span>
                    </div>
                    <div>
                        <input type="text" name="companyFax" class="input_fullDesign" value="<?=$config['companyFax']?>" placeholder="FAX를 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">대표 이메일</span>
                    </div>
                    <div>
                        <input type="text" name="companyEmail" class="input_fullDesign" value="<?=$config['companyEmail']?>" placeholder="대표 이메일을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">사업자등록번호</span>
                    </div>
                    <div>
                        <input type="text" name="companyRegiNumber" class="input_fullDesign" value="<?=$config['companyRegiNumber']?>" placeholder="사업자등록번호를 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">통신판매업신고번호</span>
                    </div>
                    <div>
                        <input type="text" name="onlineRegiNumber" class="input_fullDesign" value="<?=$config['onlineRegiNumber']?>" placeholder="통신판매업신고번호를 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">홈페이지 메인 색상</span>
                    </div>
                    <div>
                        <input type="text" id="text-field" name="mainColor" class="color_picker input_fullDesign" value="<?=$config['mainColor']?>">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">알림 디자인 설정 (공통)</span>
                    </div>
                    <div>
                        <div class="selectbox">
                            <input type="hidden" class="selectedValue" name="alertDesign" value="<?if ($config['alertDesign'] == 'A') {?>C<?} else {?>B<?}?>">
                            <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                <span class="selectbox_text"><?if ($config['alertDesign'] == 'A') {?>기본<?} else if ($config['alertDesign'] == 'B') {?>글자<?} else if ($config['alertDesign'] == 'C') {?>위 -> 아래<?} else if ($config['alertDesign'] == 'D') {?>아래 -> 위<?}?></span>
                                <span class="select_arrow"></span>
                            </p>
                            <ul class="selectbox_depth oneDepth">
                                <li data-val="A" class="flex-vc-hl-container" onclick="selectboxClick(this);">기본</li>
                                <li data-val="B" class="flex-vc-hl-container" onclick="selectboxClick(this);">글자</li>
                                <li data-val="C" class="flex-vc-hl-container" onclick="selectboxClick(this);">위 -> 아래</li>
                                <li data-val="D" class="flex-vc-hl-container" onclick="selectboxClick(this);">아래 -> 위</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">SNS로그인 디자인 설정 (공통)</span>
                    </div>
                    <div>
                        <div class="selectbox">
                            <input type="hidden" class="selectedValue" name="snsLoginDesign" value="<?if ($config['snsLoginDesign'] == 'C') {?>C<?} else {?>B<?}?>">
                            <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                <span class="selectbox_text"><?if ($config['snsLoginDesign'] == 'C') {?>동그라미<?} else {?>박스<?}?></span>
                                <span class="select_arrow"></span>
                            </p>
                            <ul class="selectbox_depth oneDepth">
                                <li data-val="C" class="flex-vc-hl-container" onclick="selectboxClick(this);">동그라미</li>
                                <li data-val="B" class="flex-vc-hl-container" onclick="selectboxClick(this);">박스</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">SNS로그인 설정 (네이버)</span>
                    </div>
                    <div>
                        <div class="selectbox">
                            <input type="hidden" class="selectedValue" name="naverLoginUse" value="<?if ($config['naverLoginUse'] == 'Y') {?>Y<?} else {?>N<?}?>">
                            <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                <span class="selectbox_text"><?if ($config['naverLoginUse'] == 'Y') {?>사용<?} else if ($config['naverLoginUse'] == 'N') {?>미사용<?} else {?>사용유무 선택<?}?></span>
                                <span class="select_arrow"></span>
                            </p>
                            <ul class="selectbox_depth oneDepth">
                                <li data-val="Y" class="flex-vc-hl-container" onclick="selectboxClick(this);">사용</li>
                                <li data-val="N" class="flex-vc-hl-container" onclick="selectboxClick(this);">미사용</li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <input type="text" name="naverLoginClientId" class="input_fullDesign" value="<?=$config['naverLoginClientId']?>" placeholder="CLIENT_ID를 입력하세요.">
                    </div>
                    <div>
                        <input type="text" name="naverLoginClientSecret" class="input_fullDesign" value="<?=$config['naverLoginClientSecret']?>" placeholder="CLIENT_SECRET을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">SNS로그인 설정 (카카오톡)</span>
                    </div>
                    <div>
                        <div class="selectbox">
                            <input type="hidden" class="selectedValue" name="kakaoLoginUse" value="<?if ($config['kakaoLoginUse'] == 'Y') {?>Y<?} else {?>N<?}?>">
                            <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                <span class="selectbox_text"><?if ($config['kakaoLoginUse'] == 'Y') {?>사용<?} else if ($config['kakaoLoginUse'] == 'N') {?>미사용<?} else {?>사용유무 선택<?}?></span>
                                <span class="select_arrow"></span>
                            </p>
                            <ul class="selectbox_depth oneDepth">
                                <li data-val="Y" class="flex-vc-hl-container" onclick="selectboxClick(this);">사용</li>
                                <li data-val="N" class="flex-vc-hl-container" onclick="selectboxClick(this);">미사용</li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <input type="text" name="kakaoLoginClientId" class="input_fullDesign" value="<?=$config['kakaoLoginClientId']?>" placeholder="CLIENT_ID를 입력하세요.">
                    </div>
                    <div>
                        <input type="text" name="kakaoLoginClientSecret" class="input_fullDesign" value="<?=$config['kakaoLoginClientSecret']?>" placeholder="CLIENT_SECRET을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">SNS로그인 설정 (구글)</span>
                    </div>
                    <div>
                        <div class="selectbox">
                            <input type="hidden" class="selectedValue" name="googleLoginUse" value="<?if ($config['googleLoginUse'] == 'Y') {?>Y<?} else {?>N<?}?>">
                            <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                <span class="selectbox_text"><?if ($config['googleLoginUse'] == 'Y') {?>사용<?} else if ($config['googleLoginUse'] == 'N') {?>미사용<?} else {?>사용유무 선택<?}?></span>
                                <span class="select_arrow"></span>
                            </p>
                            <ul class="selectbox_depth oneDepth">
                                <li data-val="Y" class="flex-vc-hl-container" onclick="selectboxClick(this);">사용</li>
                                <li data-val="N" class="flex-vc-hl-container" onclick="selectboxClick(this);">미사용</li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <input type="text" name="googleLoginClientId" class="input_fullDesign" value="<?=$config['googleLoginClientId']?>" placeholder="CLIENT_ID를 입력하세요.">
                    </div>
                    <div>
                        <input type="text" name="googleLoginClientSecret" class="input_fullDesign" value="<?=$config['googleLoginClientSecret']?>" placeholder="CLIENT_SECRET을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">SNS로그인 설정 (애플)</span>
                    </div>
                    <div>
                        <div class="selectbox">
                            <input type="hidden" class="selectedValue" name="appleLoginUse" value="<?if ($config['appleLoginUse'] == 'Y') {?>Y<?} else {?>N<?}?>">
                            <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                <span class="selectbox_text"><?if ($config['appleLoginUse'] == 'Y') {?>사용<?} else if ($config['appleLoginUse'] == 'N') {?>미사용<?} else {?>사용유무 선택<?}?></span>
                                <span class="select_arrow"></span>
                            </p>
                            <ul class="selectbox_depth oneDepth">
                                <li data-val="Y" class="flex-vc-hl-container" onclick="selectboxClick(this);">사용</li>
                                <li data-val="N" class="flex-vc-hl-container" onclick="selectboxClick(this);">미사용</li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <input type="text" name="appleLoginClientId" class="input_fullDesign" value="<?=$config['appleLoginClientId']?>" placeholder="CLIENT_ID를 입력하세요.">
                    </div>
                    <div>
                        <input type="text" name="appleLoginClientSecret" class="input_fullDesign" value="<?=$config['appleLoginClientSecret']?>" placeholder="CLIENT_SECRET을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">개인정보취급방침</span>
                    </div>
                    <div>
                        <textarea name="private" placeholder="개인정보취급방침을 입력해주세요."><?=$config['private']?></textarea>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">이용약관</span>
                    </div>
                    <div>
                        <textarea name="tnc" placeholder="이용약관을 입력해주세요."><?=$config['tnc']?></textarea>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">개인정보 제 3자 제공 동의</span>
                    </div>
                    <div>
                        <textarea name="thirdParty" placeholder="개인정보 제 3자 제공 동의를 입력해주세요."><?=$config['thirdParty']?></textarea>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">개인정보 수집 및 이용</span>
                    </div>
                    <div>
                        <textarea name="privateUse" placeholder="개인정보 수집 및 이용을 입력해주세요."><?=$config['privateUse']?></textarea>
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
    $(document).ready( function() {
        
        $(".color_picker").minicolors({
            inline: $(this).attr('data-inline') === 'true',
            change: function(value, opacity) {
            if( !value ) return;
            if( opacity ) value += ', ' + opacity;
            if( typeof console === 'object' ) {
                // console.log(value);
            }
            },
            theme: 'bootstrap'
        });

    });

    const form = $("#homepageConfigForm");

    $(".modify_btn").click(function(){

        $(".act").val("modify");

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
            success:function(data){

                // console.log(data);

                if (data == "success") {

                    location.reload();

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