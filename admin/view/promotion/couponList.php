<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">쿠폰 조회</h3>
        <div class="admin_infobox flex-vc-hl-container">
            <div class="search_box flex-hsb-container">
                <div class="search_select">
                    <select>
                        <option value="couponName">쿠폰명</option>
                        <option value="couponNo">쿠폰코드</option>
                    </select>
                </div>
                <div class="search_text">
                    <input type="text" placeholder="검색어를 입력하세요." onkeydown="searchEnter();" class="show">
                </div>
                <div class="search_btn">
                    <input type="button" class="admin_btn" value="검색하기" onclick="search();">
                    <input type="button" class="admin_btn" value="초기화" onclick="search('reset');">
                </div>
            </div>
        </div>
        <form id="form">
            <div class="admin_infobox flex-vc-hsb-container">
                <input type="hidden" name="page" class="page" value="coupon">
                <input type="hidden" name="act" class="act" value="list">
                <input type="hidden" class="limitStart" name="limitStart" value="">
                <input type="hidden" class="showNum" name="showNum" value="10">
                <div class="admin_board_top flex-vb-hsb-container">
                    <div class="admin_board_top_count">
                        총 <span class="totalCountText"></span>건
                    </div>
                    <div class="admin_board_top_btn flex-vc-hr-container">
                        <div class="admin_board_top_btn_list">
                            <input type="button" class="selectDel" onclick="selectDel();" value="선택 삭제">
                        </div>
                        <div class="admin_board_top_btn_list">
                            <input type="button" class="selectDel" onclick="returnAllCoupon();" value="쿠폰 회수">
                        </div>
                        <div class="admin_board_top_btn_list">
                            <input type="button" onclick="location.href='./couponReg'" value="등록하기">
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
                            <div class="col-num-list">번호</div>
                            <div class="col-300-list">쿠폰코드</div>
                            <div class="col-title-list">쿠폰명</div>
                            <div class="col-ip-list">상태</div>
                            <div class="col-ip-list">등록일</div>
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

        const form = $("#form");

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
            url: "/admin/controller/couponController",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                $(".totalCountText").text(data[1]['totalCount']);

                let contentList = "";
                let sort = data[1]['totalCount'] - parseInt($(".limitStart").val());

                if (data[1]['totalCount'] > 0) {

                    for (ol=0; ol < data[2].length; ol++) {

                        // 주문일자
                        let date = data[2][ol]['date'].substr(0, 10);

                        contentList += "<div class='admin_tbody_list'><a href='./couponModify.php?couponNo=" + data[2][ol]['couponNo'] + "' class='flex-vc-hsb-container'><div class='col-num-list flex-vc-hc-container'><input type='checkbox' class='checkEach' id='check" + data[2][ol]['idx'] + "'><label for='check" + data[2][ol]['idx'] + "' onclick='checkEach(this);'><p class='vb_designCheck'><span class='vb_designChecked'></span></p></label></div><div class='col-num-list flex-vc-hc-container'>" + sort + "</div><div class='col-300-list flex-vc-hc-container'>" + data[2][ol]['couponNo'] + "</div><div class='col-title-list flex-vc-hc-container'>" + data[2][ol]['couponName'] + "</div><div class='col-ip-list flex-vc-hc-container'>" + data[2][ol]['status'] + "</div><div class='col-ip-list flex-vc-hc-container'>" + date + "</div></a></div>";

                        sort--;

                    }

                    pagenationSet(data[1]['totalCount']);

                    $(".admin_tbody").html(""); // 리스트 초기화

                } else {

                    contentList = "<div class='admin_tbody_list flex-vc-hsb-container'><div class='empty_list flex-vc-hc-container'>쿠폰이 없습니다.</div></div>";

                }

                $(".admin_tbody").append(contentList);

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

    function searchVal (object) {

        if ($(object).attr("class") == "show") {

            let searchSelectVal = $(".search_text select").val();

            $(".search_text input[type='text']").val(searchSelectVal);

        }

    }

    function returnAllCoupon () {

    }

</script>