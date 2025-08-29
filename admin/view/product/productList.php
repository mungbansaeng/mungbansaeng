<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">상품 조회</h3>
        <div class="admin_infobox flex-vc-hl-container">
            <div class="search_optionBox">
                <div class="multi_selectbox flex-vc-hsb-container">
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
            <div class="search_box flex-hsb-container">
                <div class="search_select">
                    <select>
                        <option value="title">상품명</option>
                        <option value="productCode">상품코드</option>
                        <option value="brand">브랜드</option>
                    </select>
                </div>
                <div class="search_text">
                    <input type="text" placeholder="검색어를 입력하세요." onkeydown="searchEnter();">
                </div>
                <div class="search_btn">
                    <input type="button" class="admin_btn" value="검색하기" onclick="search();">
                    <input type="button" class="admin_btn" value="초기화" onclick="search('reset');">
                </div>
            </div>
        </div>
        <form id="produtForm" data-proceeding="loading">
            <div class="admin_infobox flex-vc-hsb-container">
                <input type="hidden" class="page" name="page" value="product">
                <input type="hidden" class="act" name="act" value="productList">
                <input type="hidden" class="limitStart" name="limitStart" value="0">
                <input type="hidden" class="showNum" name="showNum" value="10">
                <div class="admin_board_top flex-vb-hsb-container">
                    <div class="admin_board_top_count">
                        총 <span class="totalCountText"></span>건
                    </div>
                    <div class="admin_board_top_btn flex-vc-hr-container">
                        <div class="admin_board_top_btn_list">
                            <input type="button" class="selectDel" onclick="selectDel();" value="선택 삭제">
                        </div>
                        <div class="admin_board_top_btn_list admin_board_excel_btn">
                            <input type="button" class="excelDownload" value="엑셀 다운로드" onclick="excelDownloadOpen(this);">
                            <div class="excel_downloadBox"></div>
                        </div>
                        <div class="admin_board_top_btn_list">
                            <input type="button" onclick="location.href='./productReg'" value="등록하기">
                        </div>
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_table">
                        <div class="admin_thead flex-vc-hsb-container">
                            <div class="col-num-list">
                                <input type="checkbox" id="checkAll">
                                <label for="checkAll" onclick="checkAll();">
                                    <p class="vb_designCheck">
                                        <span class="vb_designChecked"></span>
                                    </p>
                                </label>
                            </div>
                            <div class="col-num-list">순번</div>
                            <div class="col-order-list">썸네일</div>
                            <div class="col-title-list">상품명</div>
                            <div class="col-show-list">가격</div>
                            <div class="col-show-list">상태</div>
                            <div class="col-show-list">판매량</div>
                            <div class="col-show-list">재고</div>
                            <div class="col-show-list">노출유무</div>
                            <div class="col-order-list">순서변경</div>
                        </div>
                        <div class="admin_tbody">
                            
                        </div>
                    </div>
                    <? include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/pagenation.php"; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<script>

    let categoryIdx1 = "<?=$_GET['categoryIdx1']?>";
    let categoryIdx2 = "<?=$_GET['categoryIdx2']?>";
    let categoryIdx3 = "<?=$_GET['categoryIdx3']?>";

    if (categoryIdx1 != "") {

            $(".selectbox0 input[name='categoryIdx1']").val(categoryIdx1);
            $(".selectbox1 input[name='categoryIdx2']").val(categoryIdx2);
            $(".selectbox2 input[name='categoryIdx3']").val(categoryIdx3);

        categoryListSelect(1);

        setTimeout(() => {

            if (categoryIdx1 != "") {

                $(".selectbox0 .selectbox_text").text($(".selectbox0 .selectbox_depth li[data-val='" + categoryIdx1 + "']").text());

            } else if (categoryIdx2 != "") {

                $(".selectbox1 .selectbox_text").text($(".selectbox1 .selectbox_depth li[data-val='" + categoryIdx2 + "']").text());

            } else if (categoryIdx3 != "") {

                $(".selectbox2 .selectbox_text").text($(".selectbox2 .selectbox_depth li[data-val='" + categoryIdx3 + "']").text());

            }
        
        }, 40);

        viewList("search");

        $(".act").val("list");

    } else {

        categoryListSelect(1);

        viewList();

    }

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

    function viewList (type = "") {

        const form = $("#produtForm");

        if (type == "search") {

            $(".act").val(type);

            let searchType = $(".search_select select").val();
            let searchText = $(".search_text input[type='text']").val();
            let categoryIdx1 = $(".selectbox0 input[type='hidden']").val();
            let categoryIdx2 = $(".selectbox1 input[type='hidden']").val();
            let categoryIdx3 = $(".selectbox2 input[type='hidden']").val();

            form.append("<input type='hidden' class='searchType' name='searchType' value='" + searchType + "'>");

            form.append("<input type='hidden' class='searchText' name='searchText' value='" + searchText + "'>");

            form.append("<input type='hidden' class='categoryIdxValue1' name='categoryIdx1' value='" + categoryIdx1 + "'>");

            if (categoryIdx2 == "") {

                form.append("<input type='hidden' class='categoryIdxValue2' name='categoryIdx2' value='0'>");

            } else {

                form.append("<input type='hidden' class='categoryIdxValue2' name='categoryIdx2' value='" + categoryIdx2 + "'>");

            }

            if (categoryIdx3 == "") {

                form.append("<input type='hidden' class='categoryIdxValue3' name='categoryIdx3' value='0'>");

            } else {

                form.append("<input type='hidden' class='categoryIdxValue3' name='categoryIdx3' value='" + categoryIdx3 + "'>");

            }

        }

        if (getParams("gnb") == "Y") {

            setCookie("page", 0);

            $(".limitStart").val(0);

            // history.replaceState({}, null, location.pathname);

        } else {

            $(".limitStart").val(getCookie("page"));

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

                var listCount = data[1]['totalCount'];

                $(".totalCountText").text(comma(listCount));

                var listData = data[2];
                var nowPageCount = listData.length;

                var listHtml = "";

                if (listCount > 0) {

                    let sort = listCount - parseInt($(".limitStart").val());

                    for (pcl=0; pcl < nowPageCount; pcl++) {

                        var showYnChecked = "";
                        let status = "";
                        let stock = listData[pcl]['stock'];

                        let price = comma(listData[pcl]['price']); // 가격

                        // 상품 상태
                        if (listData[pcl]['status'] == 100) {

                            status = "정상 (일시품절)";

                        } else if (listData[pcl]['status'] == 200) {

                            status = "정상 (품절)";

                        } else if (listData[pcl]['status'] == 300) {

                            status = "일시품절";

                        } else if (listData[pcl]['status'] == 400) {

                            status = "품절";

                        }

                        // 재고
                        if (listData[pcl]['stock'] == -1) {

                            stock = "무제한";

                        }

                        // 판매량
                        let soldCount = comma(listData[pcl]['soldCount']); // 가격

                        if (listData[pcl]['showYn'] == "Y") {

                            showYnChecked = "checked";

                        }

                        listHtml += "<div class='admin_tbody_list flex-vc-hsb-container'><div class='col-num-list flex-vc-hc-container'><input type='checkbox' class='checkEach' id='check" + listData[pcl]['idx'] + "'><label for='check" + listData[pcl]['idx'] + "' onclick='checkEach(this);'><p class='vb_designCheck'><span class='vb_designChecked'></span></p></label></div><div class='col-num-list flex-vc-hc-container'>" + sort + "</div><div class='col-order-list flex-vc-hc-container'><img src='/admin/resources/upload/" + listData[pcl]['fileName'] + "' alt='상품썸네일' style='width: 100%; height: 100%;'></div><div class='col-title-list admin_tbody_title flex-vc-hl-container'><a href='./productModify?idx=" + listData[pcl]['idx'] + "&categoryIdx1=" + $(".categoryIdxValue1").val() + "&categoryIdx2=" + $(".categoryIdxValue2").val() + "&categoryIdx3=" + $(".categoryIdxValue3").val() + "&searchType=" + $(".searchType").val() + "&searchText=" + $(".searchText").val() + "' class='flex-vc-hl-container'><p>" + listData[pcl]['title'] + "</p></a></div><div class='col-show-list flex-vc-hc-container'>" + price + "원</div><div class='col-show-list flex-vc-hc-container'>" + status + "</div><div class='col-show-list flex-vc-hc-container'>" + soldCount + "</div><div class='col-show-list flex-vc-hc-container'>" + stock + "</div><div class='col-show-list flex-vc-hc-container'><input type='checkbox' name='showYn' id='showYn" + pcl + "' " + showYnChecked + "><label for='showYn" + pcl + "' onclick='boardShowYn(this);'><p class='switchCheck'><span class='switchChecked'></span></p><input type='hidden' class='boardFile' name='boardFile' value='" + listData[pcl]['file'] + "'></label></div><div class='col-order-list admin_tbody_order  flex-vc-hc-container'><ul class='order_arrow'><li onclick=\"sortChange(this, 'up', " + listData[pcl]['sort'] + ")\">▲</li><li onclick=\"sortChange(this, 'down', " + listData[pcl]['sort'] + ")\">▼</li></ul><input type='hidden' class='sortIdxValue' value='" + listData[pcl]['sortIdx'] + "'></div></div>";

                        sort--;

                    }

                } else if (listData == "searchProduct") {

                    listHtml += "<div class='admin_tbody_list flex-vc-hsb-container'><div class='empty_list flex-vc-hc-container'>카테고리를 선택해주세요.</div></div>";

                } else {

                    listHtml += "<div class='admin_tbody_list flex-vc-hsb-container'><div class='empty_list flex-vc-hc-container'>게시물이 없습니다.</div></div>";

                }

                pagenationSet(listCount);

                $(".admin_tbody").html(""); // 리스트 초기화
                    
                $(".admin_tbody").html(listHtml); // 리스트 그리기

                // 제목 width 자동 조절
                var totalWidth = 0;

                for (lw=0; lw < $(".admin_thead div").length; lw++) {

                    if ($(".admin_thead div").eq(lw).attr("class") !== "col-title-list") {

                        let listWidth = $(".admin_thead div").eq(lw).width();

                        totalWidth += listWidth;

                    }

                }

                $(".admin_thead .col-title-list").css({

                    width : "calc(100% - " + totalWidth + "px)"

                });

                $(".admin_tbody_list .col-title-list").css({

                    width : "calc(100% - " + totalWidth + "px)"

                });

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    function selectDel () {

        $(".del_idx").remove();
        $(".del_boardFile").remove();
        $(".act").val("selectDel");

        const form = $("#produtForm");

        const listLength = $(".admin_tbody_list").length;

        for (i=0; i < listLength; i++) {

            const checked = $(".admin_tbody_list").eq(i).find(".checkEach").prop('checked');

            if (checked == true) {

                let stringIdx = $(".admin_tbody_list").eq(i).find(".checkEach").attr("id");

                let idx = stringIdx.replace("check", "");

                form.append("<input type='hidden' name='idx[]' class='del_idx' value='" + idx + "'>");

            }

        }

        if ($(".del_idx").length > 0) {

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

                    if (data == "success") {

                        setCookie("page", 0);

                        $("#checkAll").prop('checked', false);

                        viewList("search");

                        $(".act").val("list");

                    } else {

                        alert("오류가 발생했습니다. 개발자에게 문의해주세요.");

                    }

                },
                error:function(request,status,error){

                    console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                    
                }
                
            });

        } else {

            alert("최소 1개 이상 선택해주세요.");

        }

    }

    function sortChange (object, type, sort) {

        $(".act").val("sortChange");

        $(".sortIdx").remove();

        $(".sortType").remove();

        $(".sortNum").remove();

        const form = $("#produtForm");
        
        let stringIdx = $(object).parents(".admin_tbody_list").find(".checkEach").attr("id");

        let idx = stringIdx.replace("check", "");

        form.append("<input type='hidden' class='sortIdx' name='sortIdx' value='" + idx + "'>");

        form.append("<input type='hidden' class='sortType' name='sortType' value='" + type + "'>");

        form.append("<input type='hidden' class='sortNum' name='sortNum' value='" + sort + "'>");

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

                if (data[0] == "success") {

                    // 검색했을때 검색한것 기준으로 나오게 하기

                    if ($(".searchText").val()) {

                        viewList("search");

                    } else {

                        var listData = data[2];
                        var listCount = data[1]['totalCount'];

                        var listHtml = "";

                        if (listData.length > 0) {

                            let sort = listCount - parseInt($(".limitStart").val());

                            for (pcl=0; pcl < listData.length; pcl++) {

                                var showYnChecked = "";

                                if (listData[pcl]['showYn'] == "Y") {

                                    showYnChecked = "checked";

                                }

                                listHtml += "<div class='admin_tbody_list flex-vc-hsb-container'><div class='col-num-list flex-vc-hc-container'><input type='checkbox' class='checkEach' id='check" + listData[pcl]['idx'] + "'><label for='check" + listData[pcl]['idx'] + "' onclick='checkEach(this);'><p class='vb_designCheck'><span class='vb_designChecked'></span></p></label></div><div class='col-num-list flex-vc-hc-container'>" + sort + "</div><div class='col-title-list admin_tbody_title flex-vc-hl-container'><a href='./siteCategoryModify?depth=1&idx=" + listData[pcl]['idx'] + "' class='flex-vc-hl-container'><p>" + listData[pcl]['title'] + "</p></a></div><div class='col-show-list flex-vc-hc-container'><input type='checkbox' name='showYn' id='showYn" + pcl + "' " + showYnChecked + "><label for='showYn" + pcl + "' onclick='boardShowYn(this);'><p class='switchCheck'><span class='switchChecked'></span></p><input type='hidden' class='boardFile' name='boardFile' value='" + listData[pcl]['file'] + "'></label></div><div class='col-order-list admin_tbody_order  flex-vc-hc-container'><ul class='order_arrow'><li onclick=\"sortChange(this, 'up', " + listData[pcl]['sort'] + ")\">▲</li><li onclick=\"sortChange(this, 'down', " + listData[pcl]['sort'] + ")\">▼</li></ul></div></div>";

                                sort--;

                            }

                        } else {

                            listHtml += "<div class='admin_tbody_list flex-vc-hsb-container'><div class='empty_list flex-vc-hc-container'>게시물이 없습니다.</div></div>";

                        }

                        pagenationSet(listCount);

                        $(".admin_tbody").html(""); // 리스트 초기화
                            
                        $(".admin_tbody").html(listHtml); // 리스트 그리기

                        // 제목 width 자동 조절
                        var totalWidth = 0;

                        for (lw=0; lw < $(".admin_thead div").length; lw++) {

                            if ($(".admin_thead div").eq(lw).attr("class") !== "col-title-list") {

                                let listWidth = $(".admin_thead div").eq(lw).width();

                                totalWidth += listWidth;

                            }

                        }

                        $(".admin_thead .col-title-list").css({

                            width : "calc(100% - " + totalWidth + "px)"

                        });

                        $(".admin_tbody_list .col-title-list").css({

                            width : "calc(100% - " + totalWidth + "px)"

                        });

                        $(".act").val("list");

                    }

                } else if (data == "last") {

                    alert("마지막 게시물 입니다.");

                    $(".act").val("list");

                } else if (data == "first") {

                    alert("첫번째 게시물 입니다.");

                    $(".act").val("list");

                } else {

                    alert("오류가 발생했습니다. 개발자에게 문의해주세요.");

                }

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    function boardShowYn (object) {

        $(".act").val("showYn");

        $(".showYnIdx").remove();

        $(".showYn").remove();

        const form = $("#produtForm");
        
        let stringIdx = $(object).parents(".admin_tbody_list").find(".checkEach").attr("id");

        let idx = stringIdx.replace("check", "");

        form.append("<input type='hidden' class='showYnIdx' name='idx' value='" + idx + "'>");

        if ($(object).siblings("input[type='checkbox']").prop("checked") == true) {

            form.append("<input type='hidden' class='showYn' name='showYn' value='N'>");

        } else {

            form.append("<input type='hidden' class='showYn' name='showYn' value='Y'>");

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

                if (data !== "success") {

                    alert("오류가 발생했습니다. 개발자에게 문의해주세요.");

                }

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    function search (type = "") {

        $(".searchType").remove();
        $(".searchText").remove();
        $(".categoryIdxValue1").remove();
        $(".categoryIdxValue2").remove();
        $(".categoryIdxValue3").remove();

        if (type == "reset") {

            $(".selectbox_text").text("카테고리 선택");

            $(".selectedValue").val("");

            $(".selectbox_depth").html("");

            $(".search_text select option[value='']").prop("selected", true);

            $(".search_text input[type='text']").val("");

            $("#checkAll").prop('checked', false);

            categoryListSelect(1);

            setCookie("page", 0);

            $(".act").val("productList");

            viewList();

            return false;

        } else {

            if (!$(".selectbox0 input[name='categoryIdx1']").val()) {

                alert("카테고리를 선택해주세요.");

                return false;

            }

            setCookie("page", 0);

            viewList("search");

            $(".act").val("list");

        }

    }

    function searchEnter () {

        if (event.keyCode === 13) {

            search();

        }

    }

</script>