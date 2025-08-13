<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit"></h3>
        <div class="admin_infobox flex-vc-hl-container">
            <div class="search_box flex-hsb-container">
                <div class="search_select">
                    <select>
                        <option value="title">제목</option>
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
                <input type="hidden" class="boardIdx" name="boardIdx" value="<?=$_GET['idx']?>">
                <input type="hidden" class="page" name="page" value="board">
                <input type="hidden" class="act" name="act" value="list">
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
                            <input type="button" onclick="location.href='./boardReg?idx=<?=$_GET['idx']?>'" value="등록하기">
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
                            <div class="col-title-list">제목</div>
                            <div class="col-ip-list">게시기간</div>
                            <div class="col-ip-list">공지유무</div>
                            <div class="col-ip-list">노출유무</div>
                            <div class="col-ip-list">등록일시</div>
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
            url: "/admin/controller/boardController",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                console.log(data);

                $(".admin_tit").text(data[3]);

                $(".totalCountText").text(data[1]['totalCount']);

                let contentList = "";

                if (data[1]['totalCount'] > 0) {

                    let sort = data[1]['totalCount'] - parseInt($(".limitStart").val());

                    for (ol=0; ol < data[2].length; ol++) {

                        let showDate = "무제한";

                        if (data[2][ol]['startDate'] !== "") {

                            var startDate = data[2][ol]['startDate'].substr(0, 10);
                            var finishDate = data[2][ol]['finishDate'].substr(0, 10);
                            showDate = startDate + " ~ " + finishDate;

                        }

                        let date = data[2][ol]['date'].substr(0, 10);

                        contentList += "<div class='admin_tbody_list'><a href='./boardModify.php?categoryIdx=<?=$_GET['idx']?>&idx=" + data[2][ol]['idx'] + "' class='flex-vc-hsb-container'><div class='col-num-list flex-vc-hc-container'><input type='checkbox' class='checkEach' id='check" + data[2][ol]['idx'] + "'><label for='check" + data[2][ol]['idx'] + "' onclick='checkEach(this);'><p class='vb_designCheck'><span class='vb_designChecked'></span></p></label></div><div class='col-num-list flex-vc-hc-container'>" + sort + "</div><div class='col-title-list flex-vc-hc-container'>" + data[2][ol]['title'] + "</div><div class='col-ip-list flex-vc-hc-container'>" + showDate + "</div><div class='col-ip-list flex-vc-hc-container'>" + data[2][ol]['notice'] + "</div><div class='col-ip-list flex-vc-hc-container'>" + data[2][ol]['showYn'] + "</div><div class='col-ip-list flex-vc-hc-container'>" + date + "</div></a></div>";

                        sort--;

                    }

                    pagenationSet(data[1]['totalCount']);

                } else {

                    contentList += "<div class='admin_tbody_list flex-vc-hsb-container'><div class='empty_list flex-vc-hc-container'>게시물이 없습니다.</div></div>";

                }

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

</script>