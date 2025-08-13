<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">회원조회</h3>
        <div class="admin_infobox flex-vc-hl-container">
            <div class="search_box flex-hsb-container">
                <div class="search_select">
                    <select>
                        <option value="id">회원아이디</option>
                        <option value="name">회원명</option>
                        <option value="email">이메일</option>
                        <option value="cellPhone">휴대폰번호</option>
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
        <form id="memberListForm">
            <div class="admin_infobox flex-vc-hsb-container">
                <input type="hidden" class="page" name="page" value="member">
                <input type="hidden" class="act" name="act" value="memberList">
                <input type="hidden" class="limitStart" name="limitStart" value="">
                <input type="hidden" class="showNum" name="showNum" value="10">
                <div class="admin_board_top flex-vb-hsb-container">
                    <div class="admin_board_top_count">
                        총 <span class="totalCountText"></span>건
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
                            <div class="col-title-list">회원아이디</div>
                            <div class="col-ip-list">회원명</div>
                            <div class="col-ip-list">등급</div>
                            <div class="col-ip-list">휴대폰번호</div>
                            <div class="col-ip-list">가입일시</div>
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

        const form = $("#memberListForm");

        if (type == "search") {

            $(".act").val(type);

            let searchType = $(".search_select select").val();
            let searchText = $(".search_text input[type='text']").val();

            $("#memberListForm").append("<input type='hidden' class='searchType' name='searchType' value='" + searchType + "'>");

            $("#memberListForm").append("<input type='hidden' class='searchText' name='searchText' value='" + searchText + "'>");

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
            url: "/admin/controller/memberController.php",
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

                for (ol=0; ol < data[2].length; ol++) {

                    // 가입일자
                    let date = data[2][ol]['date'].substr(0, 10);

                    // 휴대폰번호
                    let cellPhone = data[2][ol]['cellPhone'].substr(0, 3) + "-" + data[2][ol]['cellPhone'].substr(4, 4) + "-" + data[2][ol]['cellPhone'].substr(9, 4);

                    contentList += "<div class='admin_tbody_list'><a href='./orderModify.php?orderNo=" + data[2][ol]['idx'] + "' class='flex-vc-hsb-container'><div class='col-num-list flex-vc-hc-container'><input type='checkbox' class='checkEach' id='check" + data[2][ol]['idx'] + "'><label for='check" + data[2][ol]['idx'] + "' onclick='checkEach(this);'><p class='vb_designCheck'><span class='vb_designChecked'></span></p></label></div><div class='col-num-list flex-vc-hc-container'>" + sort + "</div><div class='col-title-list flex-vc-hc-container'>" + data[2][ol]['id'] + "</div><div class='col-ip-list flex-vc-hc-container'>" + data[2][ol]['name'] + "</div><div class='col-ip-list flex-vc-hc-container'>" + data[2][ol]['level'] + "</div><div class='col-ip-list flex-vc-hc-container'>" + cellPhone + "</div><div class='col-ip-list flex-vc-hc-container'>" + date + "</div></a></div>";

                    sort--;

                }

                pagenationSet(data[1]['totalCount']);

                $(".admin_tbody").html(""); // 리스트 초기화

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