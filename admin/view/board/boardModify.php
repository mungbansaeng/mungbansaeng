<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">게시물 수정 (개발중)</h3>
        <form id="boardRegForm" name="form">
            <input type="hidden" name="page" class="page" value="board">
            <input type="hidden" name="act" class="act" value="modifyView">
            <input type="hidden" name="categoryIdx" value="<?=$_GET['categoryIdx']?>">
            <input type="hidden" name="idx" value="<?=$_GET['idx']?>">
            <div class="admin_infobox flex-vc-hsb-container">
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">썸네일</span>
                    </div>
                    <div class="attachfile_box flex-vc-hl-container">
                        <input type="hidden" class="fileTotalNum" value="20"> <!-- 첨부파일 가능 개수 -->
                        <input type="file" id="attachment" class="attach_btn" multiple onchange="attachClick(this, 'board', 'board', 'admin');">
                        <label for="attachment">
                            <span class="file_design">썸네일 첨부</span>
                        </label>
                        <div class="attach_descbox flex-vc-hl-container"><p class="attach_placeholder">최대 20개까지 가능합니다.</p></div>
                        <p class="attach_sdesc">※ 가로 600픽셀 X 세로 600픽셀 사이즈</p>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">제목</span>
                    </div>
                    <div>
                        <input type="text" name="title" class="input_fullDesign" placeholder="제목을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_fullbox category_list" style="display: none;">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">카테고리 선택</span>
                    </div>
                    <div class="category_selectBox"></div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">노출 유무</span>
                    </div>
                    <div class="flex-vc-hl-container">
                        <div class="radio_list">
                            <input type="radio" name="showYn" id="showY" value="Y" checked="">
                            <label for="showY">
                                <p class="o_designCheck">
                                    <span class="o_designChecked"></span>
                                </p>
                                <span class="o_designCheck_text">노출</span>
                            </label>
                        </div>
                        <div class="radio_list">
                            <input type="radio" name="showYn" id="showN" value="N">
                            <label for="showN">
                                <p class="o_designCheck">
                                    <span class="o_designChecked"></span>
                                </p>
                                <span class="o_designCheck_text">미노출</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">공지 유무</span>
                    </div>
                    <div class="flex-vc-hl-container">
                        <div class="radio_list">
                            <input type="radio" name="notice" id="noticeN" value="N" checked="">
                            <label for="noticeN">
                                <p class="o_designCheck">
                                    <span class="o_designChecked"></span>
                                </p>
                                <span class="o_designCheck_text">일반글</span>
                            </label>
                        </div>
                        <div class="radio_list">
                            <input type="radio" name="notice" id="noticeY" value="Y">
                            <label for="noticeY">
                                <p class="o_designCheck">
                                    <span class="o_designChecked"></span>
                                </p>
                                <span class="o_designCheck_text">공지</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">키워드</span>
                    </div>
                    <div>
                        <input type="text" name="keyword" class="input_fullDesign" placeholder="키워드는 #으로 구분합니다.">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">시작날짜</span>
                    </div>
                    <div>
                        <input type="text" name="startDate" class="datepicker input_fullDesign" placeholder="시작 날짜를 선택하세요." readonly>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">종료날짜</span>
                    </div>
                    <div>
                        <input type="text" name="finishDate" class="datepicker input_fullDesign" placeholder="종료 날짜를 선택하세요." readonly>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">내용</span>
                    </div>
                    <div class="description_tabBox flex-vc-hc-container">
                        <div class="description_tab flex-vc-hc-container" data-val="pcDescription">PC</div>
                        <div class="description_tab flex-vc-hc-container" data-val="mobileDescription">모바일</div>
                    </div>
                    <div>
                        <div id="pcDescriptionBox" class="editor_box">
                            <textarea name="pcDescription" id="pcDescription" placeholder="내용을 입력하세요."></textarea>
                            <?

                                $ckeditorId = "pcDescription";

                                include dirname(dirname(dirname(dirname(__FILE__))))."/ckeditor/ckeditor.php";

                            ?>	
                        </div>
                        <div id="mobileDescriptionBox" class="editor_box">
                            <textarea name="mobileDescription" id="mobileDescription" placeholder="내용을 입력하세요."></textarea>
                            <?

                                $ckeditorId = "mobileDescription";

                                include dirname(dirname(dirname(dirname(__FILE__))))."/ckeditor/ckeditor.php";

                            ?>	
                        </div>
                    </div>
                </div>
                <div class="admin_btnBox">
                    <input type="button" class="admin_btn modify_btn" value="수정하기">
                    <input type="button" class="admin_backBtn" onclick="location.href='./list?idx=<?=$_GET['idx']?>'" value="돌아가기">
                </div> 
            </div>
        </form>
    </div>
</div>

<script>

    const form = $("#boardRegForm");

    $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/admin/controller/boardController",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                let html = "";
                let subCatgory = "";
                let subCatgoryTitle = "";

                // 썸네일
                var attachArray = data[1];
                var attachDescWith = 100 / (attachArray.length / 2);
                var table = $(".page").val();

                if (attachArray.length > 0) {

                    for (ac=0; ac < attachArray.length; ac++) {

                        $("#attachment").siblings('.attach_descbox').find(".attach_placeholder").hide();

                        $("#attachment").siblings('.attach_descbox').append("<div class='attach_desclist' style='width: calc(" + attachDescWith + "% - 10px);'><input type='text' name='uploadName' readonly value='" + attachArray[ac]['originFileName'] + "'><input type='hidden' name='transfileName[]' class='transfileName' value='" + attachArray[ac]['fileName'] + "'><input type='hidden' id='fileIdx" + ac + "' class='file_idx' name='fileIdx[]' value='" + attachArray[ac]['idx'] + "'><p class='attach_del' onclick=\"attachDel(this, '" + table + "', 'admin');\"><img src='../../resources/images/attach_del.png' alt=''></p></div>");

                    }
                    
                }

                if (data[3][0]['depthType'] == "208") {

                    for (cc=0; cc < data[4].length; cc++) {

                        subCatgory += "<li data-val='" + data[4][cc]['idx'] + "' class='flex-vc-hl-container' onclick='selectboxClick(this);'>" + data[4][cc]['title'] + "</li>";

                        if (data[2]['subCategoryIdx'] == data[4][cc]['idx']) {

                            subCatgoryTitle = data[4][cc]['title'];

                        }

                    }

                    html += "<div class='selectbox' id='category'><input type='hidden' class='selectedValue' name='subCategoryIdx'><p class='selectbox_tit flex-vc-hl-container' onclick='selectboxOpen(this);'><span class='selectbox_text'>카테고리 선택</span><span class='select_arrow'></span></p><ul class='selectbox_depth' style='display: none;'>" + subCatgory + "</ul></div>";

                    $(".category_selectBox").append(html);

                    $(".category_list").show();

                    $("input[name='subCategoryIdx']").val(data[2]['subCategoryIdx']);
                    $("#category .selectbox_text").text(subCatgoryTitle);

                }

                // 상품명
                $("input[name='title']").val(data[2]['title']);

                // 노출 유무
                $("#show" + data[2]['showYn']).prop("checked", true);

                // 공지
                $("#notice" + data[2]['notice']).prop("checked", true);

                // 키워드
                $("input[name='keyword']").val(data[2]['keyword']);

                // 시작날짜
                if (data[2]['startDate'] !== "") {

                    var startDate = data[2]['startDate'].substr(0, 10);
                    $("input[name='startDate']").val(startDate);

                }

                // 종료날짜
                if (data[2]['finishDate'] !== "") {

                    var finishDate = data[2]['finishDate'].substr(0, 10);
                    $("input[name='finishDate']").val(finishDate);

                }

                // 내용 (PC)
                pcDescriptionobjEditor.setData(data[2]['pcDescription']);

                // 내용 (Mobile)
                mobileDescriptionobjEditor.setData(data[2]['mobileDescription']);

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    $(".modify_btn").click(function() {

        $(".act").val("modify");

        $("#pcDescription").val(pcDescriptionobjEditor.getData()); // ck에디터 내용 가져와서 textarea value에 넣기

        $("#mobileDescription").val(mobileDescriptionobjEditor.getData()); // ck에디터 내용 가져와서 textarea value에 넣기

        // 유효성 체크
        if (!document.form.title.value) {

            alert("제목을 입력하세요.");

            document.form.title.focus();

            return false;

        } else if (!document.form.keyword.value) {

            alert("키워드를 입력하세요.");

            return false;

        } else if (!document.form.pcDescription.value || !document.form.mobileDescription.value) {

            alert("내용을 입력하세요.");

            document.form.description.focus();

            return false;

        }

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/admin/controller/boardController",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                if(data == "success"){

                    if (confirm("현재 페이지를 닫으시겠습니까?")) {

                        location.href = "/admin/view/board/boardList?idx=" + $("input[name='categoryIdx']").val();

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