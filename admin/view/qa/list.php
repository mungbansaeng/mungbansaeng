<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">QA 리스트 (아직 개발 X)</h3>
        <form id="orderForm">
            <div class="admin_infobox flex-vc-hsb-container">
                <input type="hidden" class="page" name="page" value="order">
                <input type="hidden" class="act" name="act" value="orderList">
                <input type="hidden" class="limitStart" name="limitStart" value="">
                <input type="hidden" class="showNum" name="showNum" value="10">
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
                            <div class="col-title-list">회원아이디</div>
                            <div class="col-ip-list">주문번호</div>
                            <div class="col-ip-list">결제방식</div>
                            <div class="col-ip-list">실결제금액</div>
                            <div class="col-ip-list">상태</div>
                            <div class="col-ip-list">주문일시</div>
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

        const form = $("#orderForm");

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
            url: "/admin/controller/orderController.php",
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
                        
                        // 실결제금액
                        let payPrice = parseInt(data[2][ol]['totalPrice']) + parseInt(data[2][ol]['dlvPrice']) - parseInt(data[2][ol]['usePointPrice']) - parseInt(data[2][ol]['couponPrice']);

                        // 주문일자
                        let date = data[2][ol]['date'].substr(0, 10);

                        contentList += "<div class='admin_tbody_list'><a href='./orderModify.php?orderNo=" + data[2][ol]['orderNo'] + "' class='flex-vc-hsb-container'><div class='col-num-list flex-vc-hc-container'><input type='checkbox' class='checkEach' id='check" + data[2][ol]['idx'] + "'><label for='check" + data[2][ol]['idx'] + "' onclick='checkEach(this);'><p class='vb_designCheck'><span class='vb_designChecked'></span></p></label></div><div class='col-num-list flex-vc-hc-container'>" + sort + "</div><div class='col-title-list flex-vc-hc-container'>" + data[2][ol]['id'] + "</div><div class='col-ip-list flex-vc-hc-container'>" + data[2][ol]['orderNo'] + "</div><div class='col-ip-list flex-vc-hc-container'>" + data[2][ol]['payTypeName'] + "</div><div class='col-ip-list flex-vc-hc-container'>" + comma(payPrice) + "원</div><div class='col-ip-list flex-vc-hc-container'>" + data[2][ol]['status'] + "</div><div class='col-ip-list flex-vc-hc-container'>" + date + "</div></a></div>";

                        sort--;

                    }

                    pagenationSet(data[1]['totalCount']);

                    $(".admin_tbody").html(""); // 리스트 초기화

                } else {

                    contentList = "<div class='admin_tbody_list flex-vc-hsb-container'><div class='empty_list flex-vc-hc-container'>게시물이 없습니다.</div></div>";

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

</script>