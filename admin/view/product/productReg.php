<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/controller/productController.php";

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">상품 등록</h3>
        <form id="produtRegForm" name="form">
            <input type="hidden" name="page" value="product">
            <input type="hidden" name="act" value="reg">
            <div class="admin_infobox flex-vc-hsb-container">
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">상품 메인 썸네일</span>
                    </div>
                    <div class="attachfile_box flex-vc-hl-container">
                        <input type="hidden" class="fileTotalNum" value="20"> <!-- 첨부파일 가능 개수 -->
                        <input type="file" id="attachment" class="attach_btn" multiple onchange="attachClick(this, 'product', 'product', 'admin');">
                        <label for="attachment">
                            <span class="file_design">이미지 첨부</span>
                        </label>
                        <div class="attach_descbox flex-vc-hl-container"><p class="attach_placeholder">최대 20개까지 가능합니다.</p></div>
                        <p class="attach_sdesc">※ 가로 600픽셀 X 세로 600픽셀 사이즈</p>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">상품명</span>
                    </div>
                    <div>
                        <input type="text" name="title" class="input_fullDesign" placeholder="상품명을 입력하세요.">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">브랜드</span>
                    </div>
                    <div>
                        <div class="selectbox" id="brand">
                            <input type="hidden" class="selectedValue" name="brandIdx">
                            <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                <span class="selectbox_text">카테고리 선택</span>
                                <span class="select_arrow"></span>
                            </p>
                            <ul class="selectbox_depth"></ul>
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">상품 검색 키워드</span>
                    </div>
                    <div>
                        <input type="text" name="keyword" class="input_fullDesign" placeholder="키워드는 #으로 구분합니다.">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">판매상태</span>
                        <div class="help_box">
                            <span class="help_icon flex-vc-hc-container" onclick="openHelp(this);">?</span>
                            <div class="help_descBox">
                                <div class="help_descTit">판매상태 선택하기</div>
                                <div class="help_desc">
                                    정상 (일시품절) : 정상 판매되는 상태입니다. 재고가 없을때 일시품절로 자동으로 변경됩니다.<br><br>
                                    정상 (품절) : 정상 판매되는 상태입니다. 재고가 없을때 품절로 자동으로 변경됩니다.<br><br>
                                    일시품절 : 재입고가 예정된 상품입니다. 재고가 있어도 일시품절로 변경할 경우 재고수량과 상관없이 해당 상품은 일시품절로 변경됩니다. 일시품절일 경우 재입고예정 팝업이 상품 썸네일 위에 뜹니다.<br><br>
                                    품절 : 재입고 예정이 확정이 안된 상품입니다. 재고가 있어도 품절로 변경할 경우 재고수량과 상관없이 해당 상품은 품절로 변경됩니다. 품절일 경우 품절 팝업이 상품 썸네일 위에 뜹니다.
                                </div>
                                <div class="help_descClose" onclick="closeHelp();">닫기</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-vc-hl-container">
                        <div class="radio_list">
                            <input type="radio" name="status" id="status_100" value="100" checked>
                            <label for="status_100">
                                <p class="o_designCheck">
                                    <span class="o_designChecked"></span>
                                </p>
                                <span class="o_designCheck_text">정상 (일시품절)</span>
                            </label>
                        </div>
                        <div class="radio_list">
                            <input type="radio" name="status" id="status_200" value="200">
                            <label for="status_200">
                                <p class="o_designCheck">
                                    <span class="o_designChecked"></span>
                                </p>
                                <span class="o_designCheck_text">정상 (품절)</span>
                            </label>
                        </div>
                        <div class="radio_list">
                            <input type="radio" name="status" id="status_300" value="300">
                            <label for="status_300">
                                <p class="o_designCheck">
                                    <span class="o_designChecked"></span>
                                </p>
                                <span class="o_designCheck_text">일시품절</span>
                            </label>
                        </div>
                        <div class="radio_list">
                            <input type="radio" name="status" id="status_400" value="400">
                            <label for="status_400">
                                <p class="o_designCheck">
                                    <span class="o_designChecked"></span>
                                </p>
                                <span class="o_designCheck_text">품절</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">카테고리</span>
                    </div>
                    <div class="multi_selectbox product_selectbox main_category flex-vc-hsb-container" id="mainCategory">
                        <div class="selectbox selectbox0">
                            <input type="hidden" class="selectedValue" name="categoryIdx1">
                            <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                <span class="selectbox_text">카테고리 선택</span>
                                <span class="select_arrow"></span>
                            </p>
                            <ul class="selectbox_depth oneDepth"></ul>
                        </div>
                        <div class="selectbox selectbox1">
                            <input type="hidden" class="selectedValue" name="categoryIdx2">
                            <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                <span class="selectbox_text">카테고리 선택</span>
                                <span class="select_arrow"></span>
                            </p>
                            <ul class="selectbox_depth twoDepth"></ul>
                        </div>
                        <div class="selectbox selectbox2">
                            <input type="hidden" class="selectedValue" name="categoryIdx3">
                            <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                <span class="selectbox_text">카테고리 선택</span>
                                <span class="select_arrow"></span>
                            </p>
                            <ul class="selectbox_depth threeDepth"></ul>
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">추가 카테고리</span>
                        <div class="help_box">
                            <span class="help_icon flex-vc-hc-container" onclick="openHelp(this);">?</span>
                            <div class="help_descBox">
                                <div class="help_descTit">추가 카테고리 선택하기</div>
                                <div class="help_desc">
                                    다른 카테고리에 상품을 추가할때 선택하시면 됩니다<br>예시) 해당 상품이 상품 카테고리와 베스트 상품 카테고리에 들어가길 원할때 선택하시면 됩니다.
                                </div>
                                <div class="help_descClose" onclick="closeHelp();">닫기</div>
                            </div>
                        </div>
                    </div>
                    <div class="option_addBox">
                        <div class="option_addList flex-vc-hsb-container">
                            <div class='input_addDesignBox'>
                                <div class="multi_selectbox product_selectbox sub_category flex-vc-hsb-container" id="subCategory">
                                    <div class="selectbox selectbox0">
                                        <input type="hidden" class="selectedValue" name="subCategoryIdx1[]">
                                        <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                            <span class="selectbox_text">카테고리 선택</span>
                                            <span class="select_arrow"></span>
                                        </p>
                                        <ul class="selectbox_depth oneDepth"></ul>
                                    </div>
                                    <div class="selectbox selectbox1">
                                        <input type="hidden" class="selectedValue" name="subCategoryIdx2[]">
                                        <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                            <span class="selectbox_text">카테고리 선택</span>
                                            <span class="select_arrow"></span>
                                        </p>
                                        <ul class="selectbox_depth twoDepth"></ul>
                                    </div>
                                    <div class="selectbox selectbox2">
                                        <input type="hidden" class="selectedValue" name="subCategoryIdx3[]">
                                        <p class="selectbox_tit flex-vc-hl-container" onclick="selectboxOpen(this);">
                                            <span class="selectbox_text">카테고리 선택</span>
                                            <span class="select_arrow"></span>
                                        </p>
                                        <ul class="selectbox_depth threeDepth"></ul>
                                    </div>
                                </div>
                            </div>
                            <input type="button" class="admin_optionAddBtn" value="추가" onclick="addOption(this);">
                            <input type="button" class="admin_optionDelBtn" value="삭제" onclick="delOption(this);">
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">가격</span>
                    </div>
                    <div>
                        <input type="text" name="price" class="input_fullDesign" placeholder="가격을 입력하세요." oninput="inputonlyNum(this); liveNumberComma(this);">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">할인 퍼센트</span>
                        <div class="help_box">
                            <span class="help_icon flex-vc-hc-container" onclick="openHelp(this);">?</span>
                            <div class="help_descBox">
                                <div class="help_descTit">할인 퍼센트</div>
                                <div class="help_desc">
                                    할인 퍼센트를 입력하면 가격에서 자동으로 입력한 %만큼 계산이 됩니다.<br>소수점 한자리에서 반올림 됩니다.
                                </div>
                                <div class="help_descClose" onclick="closeHelp();">닫기</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="text" name="discountPercent" class="input_fullDesign" placeholder="할인 퍼센트를 입력하세요." oninput="inputonlyNum(this);">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">옵션</span>
                        <div class="help_box">
                            <span class="help_icon flex-vc-hc-container" onclick="openHelp(this);">?</span>
                            <div class="help_descBox">
                                <div class="help_descTit">옵션 입력하기</div>
                                <div class="help_desc">
                                    옵션이 있을 경우에만 입력하시면 됩니다.<br><br>옵션명 : 옵션에 나올 옵션명입니다.<br><br>옵션가격 : 기본가격에서 추가될 가격을 입력하시면 됩니다.<br><br>옵션 재고수량 : 옵션별 재고수량이 기본상품 재고수량과 다를 경우에만 입력하시면 됩니다. 옵션 재고수량을 입력 안 할 경우 상품의 재고수량 기준으로 재고가 계산이 됩니다.
                                </div>
                                <div class="help_descClose" onclick="closeHelp();">닫기</div>
                            </div>
                        </div>
                    </div>
                    <div class="option_addBox">
                        <div class="option_addList multiOption_addList flex-vc-hsb-container">
                            <div class='input_addDesignBox flex-vc-hsb-container'>
                                <input type="text" name="optionName[]" class="input_addDesign" placeholder="옵션명을 입력하세요.">
                                <input type="text" name="optionPrice[]" class="input_addDesign" placeholder="옵션 가격을 입력하세요." oninput="inputonlyNum(this); liveNumberComma(this);">
                                <input type="text" name="optionStock[]" class="input_addDesign lastInput_addDesign" placeholder="옵션 재고수량을 입력하세요." oninput="inputonlyNum(this); liveNumberComma(this);">
                            </div>
                            <input type="button" class="admin_optionAddBtn" value="추가" onclick="addOption(this);">
                            <input type="button" class="admin_optionDelBtn" value="삭제" onclick="delOption(this);">
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">적립금 퍼센트</span>
                        <div class="help_box">
                            <span class="help_icon flex-vc-hc-container" onclick="openHelp(this);">?</span>
                            <div class="help_descBox">
                                <div class="help_descTit">적립금 퍼센트</div>
                                <div class="help_desc">
                                    적립금 퍼센트가 다를 경우에만 입력하시면 됩니다.<br>적립금 퍼센트를 입력 안 할 경우 기본 적립금 퍼센트이 적용됩니다.<br>기본 적립금 퍼센트은 상품공통메뉴에서 수정가능합니다.
                                </div>
                                <div class="help_descClose" onclick="closeHelp();">닫기</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="text" name="pointPercent" class="input_fullDesign" placeholder="적립금 퍼센트를 입력하세요." oninput="inputonlyNum(this); liveNumberComma(this);">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">재고수량</span>
                        <div class="help_box">
                            <span class="help_icon flex-vc-hc-container" onclick="openHelp(this);">?</span>
                            <div class="help_descBox">
                                <div class="help_descTit">재고수량</div>
                                <div class="help_desc">
                                    재고수량이 있을 경우 입력하세요.<br>재고수량을 입력안할 경우 재고수량은 무제한이 됩니다.
                                </div>
                                <div class="help_descClose" onclick="closeHelp();">닫기</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="text" name="stock" class="input_fullDesign" placeholder="재고수량을 입력하세요." oninput="inputonlyNum(this); liveNumberComma(this);">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">배송기간</span>
                        <div class="help_box">
                            <span class="help_icon flex-vc-hc-container" onclick="openHelp(this);">?</span>
                            <div class="help_descBox">
                                <div class="help_descTit">배송기간</div>
                                <div class="help_desc">
                                    배송기간이 다를 경우에만 입력하시면 됩니다.<br>배송기간을 입력 안 할 경우 기본 배송기간이 적용됩니다.<br>기본 배송기간은 상품공통메뉴에서 수정가능합니다.
                                </div>
                                <div class="help_descClose" onclick="closeHelp();">닫기</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="text" name="deliveryDate" class="input_fullDesign" placeholder="배송기간을 입력하세요." oninput="inputonlyNum(this);">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">주문한도</span>
                        <div class="help_box">
                            <span class="help_icon flex-vc-hc-container" onclick="openHelp(this);">?</span>
                            <div class="help_descBox">
                                <div class="help_descTit">주문한도</div>
                                <div class="help_desc">
                                    해당제품을 구매할 수 있는 구매 가능한 한도입니다.<br>아이디로 주문한도를 비교하기때문에 회원만 상품 구매가 가능합니다.<br>주문 한도가 1일 경우 한 아이디당 해당상품 한개씩만 구매가 가능합니다.
                                </div>
                                <div class="help_descClose" onclick="closeHelp();">닫기</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="text" name="buyLlimit" class="input_fullDesign" placeholder="주문한도를 입력하세요.">
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
                    <input type="button" class="admin_btn reg_btn" value="등록하기">
                    <input type="button" class="admin_backBtn" onclick="location.href='./productList'" value="돌아가기">
                </div> 
            </div>
        </form>
    </div>
</div>

<script>

    const form = $("#produtRegForm");

    // 카테고리 리스트 가져오기

    function categoryListSelect (depth, object) {

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/admin/controller/productController",
            global: false,
            data: {
                "page": "product",
                "act": "category",
                "depth": depth,
                "categoryIdx": $(object).data("val")
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                var nextDepth = parseInt(depth) + 1;

                var categoryList = "";

                var selectboxIndex = $(object).parents(".selectbox").index();

                var selectboxStart = selectboxIndex + 1;

                if (depth == 3) {

                    for (sc=0; sc < data.length; sc++) {

                        categoryList += "<li data-val='" + data[sc]["idx"] + "' class='flex-vc-hl-container' onclick='selectboxClick(this, " + selectboxStart + ");'>" + data[sc]["title"] + "</li>";

                    }

                } else {

                    for (sc=0; sc < data.length; sc++) {

                        categoryList += "<li data-val='" + data[sc]["idx"] + "' class='flex-vc-hl-container' onclick='selectboxClick(this, " + selectboxStart + "); categoryListSelect(" + nextDepth + ", this);'>" + data[sc]["title"] + "</li>";

                    }

                }

                if (depth == 1) {

                    $(".oneDepth").append(categoryList);

                } else if (depth == 2) {

                    $(object).parents(".multi_selectbox").find(".twoDepth").html("");

                    $(object).parents(".multi_selectbox").find(".threeDepth").html("");

                    $(object).parents(".multi_selectbox").find(".twoDepth").append(categoryList);

                } else if (depth == 3) {

                    $(object).parents(".multi_selectbox").find(".threeDepth").html("");

                    $(object).parents(".multi_selectbox").find(".threeDepth").append(categoryList);

                }

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    categoryListSelect(1);

    // 상품 브랜드 리스트 가져오기

    function productBrandListSelect (object) {

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/admin/controller/productController",
            global: false,
            data: {
                "page": "productBrand",
                "act": "brandList"
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                var productBrandList = "";

                for (sc=0; sc < data.length; sc++) {

                    productBrandList += "<li data-val='" + data[sc]['idx'] + "' class='flex-vc-hl-container' onclick='selectboxClick(this);'>" + data[sc]['title'] + "</li>";

                }

                $("#brand .selectbox_depth").append(productBrandList);

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    productBrandListSelect();

    $(".reg_btn").click(function() {

        $("#pcDescription").val(pcDescriptionobjEditor.getData()); // ck에디터 내용 가져와서 textarea value에 넣기

        $("#mobileDescription").val(mobileDescriptionobjEditor.getData()); // ck에디터 내용 가져와서 textarea value에 넣기

        // 유효성 체크
        if (!document.form.title.value) {

            alert("상품명을 입력하세요.");

            document.form.title.focus();

            return false;

        } else if (!document.form.categoryIdx1.value) {

            alert("카테고리를 선택하세요.");

            return false;

        } else if (!document.form.price.value) {

            alert("상품 가격을 입력하세요.");

            document.form.price.focus();

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
            url: "/admin/controller/productController",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                if(data == "success"){

                    if (confirm("현재 페이지를 닫으시겠습니까?")) {

                        location.href = "/admin/view/product/productList";

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