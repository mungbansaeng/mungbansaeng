<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더

?>

<script>

    if (getParams("gnb") == "Y") {

        setCookie("page", 0);

        $(".limitStart").val(0);

        // history.replaceState({}, null, location.pathname);

    } else {

        $(".limitStart").val(getCookie("page"));

    }

    function viewList () {

        var form = $("#statisticsForm");

        $.ajax({
            type: "POST",
            dataType: "json",
            async: true,
            url: "/admin/controller/commonController.php",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                // 분석 결과 초기화
                $(".statistics_result_list").html("");

                var listCount = data[0]['totalCount'];

                if (listCount == 0) {

                    $(".statistics_result_list").html("<div class='empty_list flex-vc-hc-container'>해당기간에 데이터가 없습니다.</div>");

                } else {

                    let resultList = "";

                    var listData = data[1];
                    var nowPageCount = listData.length;

                    let sort = listCount - parseInt($(".limitStart").val());

                    if ($(".act").val() == "counterInfo") {

                        resultList += "<div class='admin_table'>";

                        resultList += "<div class='admin_thead flex-vc-hsb-container'>";

                        resultList += "<div class='col-num-list'>순번</div><div class='col-ip-list'>아이피</div><div class='col-title-list'>접속경로</div><div class='col-show-list'>디바이스</div><div class='col-show-list'>접속일시</div>";

                        resultList += "</div>";

                        resultList += "<div class='admin_tbody flex-vc-hsb-container'>";

                        for (rl=0; rl < nowPageCount; rl++) {

                            // 접속경로

                            if (data[1][rl]["referer"] == "Unknown") {

                                var referer = "즐겨찾기, 주소창 입력";

                            } else {

                                var referer = data[1][rl]["referer"];

                            }

                            // 디바이스

                            if (data[1][rl]["browser"] == "PC") {

                                var device = "PC";

                            } else {

                                if (data[1][rl]["agent"].indexOf("iPhone") > -1 || data[1][rl]["agent"].indexOf("iPad") > -1 || data[1][rl]["agent"].indexOf("iPod") > -1){ // 아이폰

                                    var device = "IOS";

                                } else if (data[1][rl]["agent"].indexOf('Android') > -1){ // 안드로이드

                                    var device = "AOS";

                                } else { // 나머지

                                    var device = "MOBILE";

                                }

                            }

                            resultList += "<div class='admin_tbody_list flex-vc-hsb-container'><div class='col-num-list flex-vc-hc-container'>" + sort + "</div><div class='col-ip-list flex-vc-hc-container'>" + data[1][rl]["userIp"] + "</div><div class='col-title-list flex-vc-hc-container'>" + referer + "</div><div class='col-show-list flex-vc-hc-container'>" + device + "</div><div class='col-show-list flex-vc-hc-container'>" + data[1][rl]["date"] + "<br>" + data[1][rl]["time"] + "</div></div>";

                            sort--;

                        }

                        resultList += "</div>";

                        resultList += "</div>";

                    }

                    $(".statistics_result_list").html(resultList); // 분석 결과 그리기

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

                }

                pagenationSet(listCount);

                $(".admin_infoTit").text($(".startYear").val() + "년 " + $(".startMonth").val() + "월 " + $(".startDay").val() + "일 " + "~ " + $(".endYear").val() + "년 " + $(".endMonth").val() + "월 " + $(".endDay").val() + "일 상세 분석 결과");

                $(".statistics_result").show();

                $("body, html").animate({

                    scrollTop : $(".statistics_result").offset().top

                }, 400);

                // 엑셀 다운로드
                let excelItems = "userIp, referer, agent, date, time";

                $(".excelDownload").attr("onclick", "excelDownload('statisticsForm', 'static', 'statistics', '" + excelItems + "', 'detailStatistics');");

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }   

</script>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">상세 접속분석</h3>
        <div class="admin_infobox flex-vc-hl-container">
            <div class="admin_info admin_fullbox">
                <form id="statisticsForm">
                    <input type="hidden" class="page" name="page" value="statistics">
                    <input type="hidden" class="act" name="act" value="counterInfo">
                    <input type="hidden" class="limitStart" name="limitStart" value="0">
                    <input type="hidden" class="showNum" name="showNum" value="10">
                    <?include_once dirname(dirname(dirname(dirname(__FILE__))))."/public/view/calendar/searchCalendar.php";?>
                </form> 
            </div>
            <div class="admin_info admin_fullbox statistics_result">
                <div class="admin_board_top flex-vc-hsb-container">
                    <div class="admin_board_top_count">
                    <p class="admin_infoTit"></p>
                    </div>
                    <div class="admin_board_top_btn flex-vc-hr-container">
                        <div class="admin_board_top_btn_list admin_board_excel_btn">
                            <input type="button" class="excelDownload" value="엑셀 다운로드" onclick="">
                        </div>
                    </div>
                </div>
                <div class="statistics_result_list">
                    
                </div>
                <? include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/pagenation.php"; ?>
            </div>
        </div>
    </div>
</div>