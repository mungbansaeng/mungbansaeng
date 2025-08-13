<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">상품 브랜드 목록</h3>
        <div class="admin_infobox flex-vc-hl-container">
            <div class="search_box flex-hsb-container">
                <div class="search_select">
                    <select>
                        <option value="title">상품 브랜드명</option>
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
        <form id="produtCategoryForm" data-proceeding="loading">
            <div class="admin_infobox flex-vc-hsb-container">
                <input type="hidden" class="page" name="page" value="productBrand">
                <input type="hidden" class="act" name="act" value="list">
                <input type="hidden" class="limitStart" name="limitStart" value="0">
                <input type="hidden" class="showNum" name="showNum" value="10">
                <div class="admin_board_top flex-vb-hsb-container">
                    <div class="admin_board_top_count">
                        총 <span class="totalCountText"></span>건
                    </div>
                    <div class="admin_board_top_btn flex-vc-hr-container">
                        <div class="admin_board_top_btn_list">
                            <input type="button" class="excelDownload" onclick="selectDel();" value="선택 삭제">
                        </div>
                        <div class="admin_board_top_btn_list">
                            <input type="button" onclick="location.href='./productBrandReg'" value="등록하기">
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
                            <div class="col-title-list">브랜드명</div>
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

    function viewList (type = "") {

        const form = $("#produtCategoryForm");

        if (type == "search") {

            $(".act").val(type);

            let searchType = $(".search_select select").val();
            let searchText = $(".search_text input[type='text']").val();

            $("#produtCategoryForm").append("<input type='hidden' class='searchType' name='searchType' value='" + searchType + "'>");

            $("#produtCategoryForm").append("<input type='hidden' class='searchText' name='searchText' value='" + searchText + "'>");

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
            url: "/admin/controller/boardController.php",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                var listCount = data[0]['totalCount'];

                $(".totalCountText").text(comma(listCount));

                var listData = data[1];
                var nowPageCount = listData.length;

                var listHtml = "";

                if (listCount > 0) {

                    let sort = listCount - parseInt($(".limitStart").val());

                    for (pcl=0; pcl < nowPageCount; pcl++) {

                        var showYnChecked = "";

                        if (listData[pcl]['showYn'] == "Y") {

                            showYnChecked = "checked";

                        }

                        listHtml += "<div class='admin_tbody_list flex-vc-hsb-container'><div class='col-num-list flex-vc-hc-container'><input type='checkbox' class='checkEach' id='check" + listData[pcl]['idx'] + "'><label for='check" + listData[pcl]['idx'] + "' onclick='checkEach(this);'><p class='vb_designCheck'><span class='vb_designChecked'></span></p></label></div><div class='col-num-list flex-vc-hc-container'>" + sort + "</div><div class='col-order-list flex-vc-hc-container'>썸네일</div><div class='col-title-list admin_tbody_title flex-vc-hl-container'><a href='./productBrandModify?idx=" + listData[pcl]['idx'] + "' class='flex-vc-hl-container'><p>" + listData[pcl]['title'] + "</p></a></div><div class='col-show-list flex-vc-hc-container'><input type='checkbox' name='showYn' id='showYn" + pcl + "' " + showYnChecked + "><label for='showYn" + pcl + "' onclick='boardShowYn(this);'><p class='switchCheck'><span class='switchChecked'></span></p><input type='hidden' class='boardFile' name='boardFile' value='" + listData[pcl]['file'] + "'></label></div><div class='col-order-list admin_tbody_order  flex-vc-hc-container'><ul class='order_arrow'><li onclick=\"sortChange(this, 'up', " + listData[pcl]['sort'] + ")\">▲</li><li onclick=\"sortChange(this, 'down', " + listData[pcl]['sort'] + ")\">▼</li></ul></div></div>";

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

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    viewList();

    function selectDel () {

        $(".del_idx").remove();
        $(".del_boardFile").remove();
        $(".act").val("selectDel");

        const form = $("#produtCategoryForm");

        const listLength = $(".admin_tbody_list").length;

        for (i=0; i < listLength; i++) {

            const checked = $(".admin_tbody_list").eq(i).find(".checkEach").prop('checked');

            if (checked == true) {

                let stringIdx = $(".admin_tbody_list").eq(i).find(".checkEach").attr("id");

                let idx = stringIdx.replace("check", "");

                let boardFile = $(".admin_tbody_list").eq(i).find(".boardFile").val();

                $("#produtCategoryForm").append("<input type='hidden' name='idx[]' class='del_idx' value='" + idx + "'>");

                $("#produtCategoryForm").append("<input type='hidden' name='boardFile[]' class='del_boardFile' value='" + boardFile + "'>");

            }

        }

        if ($(".del_idx").length > 0) {

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

                    if (data == "success") {

                        location.reload();

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

        const form = $("#produtCategoryForm");
        
        let stringIdx = $(object).parents(".admin_tbody_list").find(".checkEach").attr("id");

        let idx = stringIdx.replace("check", "");

        $("#produtCategoryForm").append("<input type='hidden' class='sortIdx' name='sortIdx' value='" + idx + "'>");

        $("#produtCategoryForm").append("<input type='hidden' class='sortType' name='sortType' value='" + type + "'>");

        $("#produtCategoryForm").append("<input type='hidden' class='sortNum' name='sortNum' value='" + sort + "'>");

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

                                listHtml += "<div class='admin_tbody_list flex-vc-hsb-container'><div class='col-num-list flex-vc-hc-container'><input type='checkbox' class='checkEach' id='check" + listData[pcl]['idx'] + "'><label for='check" + listData[pcl]['idx'] + "' onclick='checkEach(this);'><p class='vb_designCheck'><span class='vb_designChecked'></span></p></label></div><div class='col-num-list flex-vc-hc-container'>" + sort + "</div><div class='col-order-list flex-vc-hc-container'>썸네일</div><div class='col-title-list admin_tbody_title flex-vc-hl-container'><a href='./productBrandModify?idx=" + listData[pcl]['idx'] + "' class='flex-vc-hl-container'><p>" + listData[pcl]['title'] + "</p></a></div><div class='col-show-list flex-vc-hc-container'><input type='checkbox' name='showYn' id='showYn" + pcl + "' " + showYnChecked + "><label for='showYn" + pcl + "' onclick='boardShowYn(this);'><p class='switchCheck'><span class='switchChecked'></span></p><input type='hidden' class='boardFile' name='boardFile' value='" + listData[pcl]['file'] + "'></label></div><div class='col-order-list admin_tbody_order  flex-vc-hc-container'><ul class='order_arrow'><li onclick=\"sortChange(this, 'up', " + listData[pcl]['sort'] + ")\">▲</li><li onclick=\"sortChange(this, 'down', " + listData[pcl]['sort'] + ")\">▼</li></ul></div></div>";

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

        const form = $("#produtCategoryForm");
        
        let stringIdx = $(object).parents(".admin_tbody_list").find(".checkEach").attr("id");

        let idx = stringIdx.replace("check", "");

        $("#produtCategoryForm").append("<input type='hidden' class='showYnIdx' name='idx' value='" + idx + "'>");

        if ($(object).siblings("input[type='checkbox']").prop("checked") == true) {

            $("#produtCategoryForm").append("<input type='hidden' class='showYn' name='showYn' value='N'>");

        } else {

            $("#produtCategoryForm").append("<input type='hidden' class='showYn' name='showYn' value='Y'>");

        }

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

        if (type !== "reset") {

            if (!$(".search_text select").val() && $(".search_text select").attr("class") == "show") {

                alert("카테고리 타입을 선택해주세요.");

                return false;

            } else if (!$(".search_text input[type='text']").val()){

                alert("검색어를 입력해주세요.");

                return false;

            }

        }

        if (type == "reset") {

            $(".search_text select option[value='']").prop("selected", true);

            $(".search_text input[type='text']").val("");

            setCookie("page", 0);

            $(".act").val("list");

            viewList();

            return false;

        } else {

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