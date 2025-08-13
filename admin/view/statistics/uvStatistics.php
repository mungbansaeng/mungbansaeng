<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">접속분석</h3>
        <div class="admin_infobox flex-vc-hl-container">
            <div class="admin_info admin_fullbox flex-vc-hsb-container">
                <p>조회 기간 : <span></span></p>
                <ul class="admin_tabBox flex-vc-hr-container">
                    <li class="tabBtn flex-vc-hc-container active" onclick="tabClick(this); changePeriod('day');">요일별</li>
                    <li class="tabBtn flex-vc-hc-container" onclick="tabClick(this); changePeriod('week');">주별</li>
                    <li class="tabBtn flex-vc-hc-container" onclick="tabClick(this); changePeriod('month');">월별</li>
                </ul>
            </div>
            <!-- <div class="admin_info admin_fullbox">
                <form id="statisticsForm">
                    <input type="hidden" class="page" name="page" value="statistics">
                    <input type="hidden" class="act" name="act" value="counterLog">
                    <input type="hidden" class="pickLimitDay" name="pickLimitDay" value="6">
                    <input type="hidden" class="pickLimitUnit" name="pickLimitUnit" value="d">
                    <input type="hidden" class="pickLimit" name="pickLimit" value="both">
                    <?//include_once dirname(dirname(dirname(dirname(__FILE__))))."/public/view/calendar/searchCalendar.php";?>
                </form> 
            </div>
            <div class="admin_info admin_fullbox statistics_result">
                <div class="admin_board_top flex-vc-hsb-container">
                    <div class="admin_board_top_count">
                    <p class="admin_infoTit"></p>
                    </div>
                </div>
                <div class="statistics_result_list">
                    
                </div>
            </div> -->
        </div>
    </div>
</div>

<script>

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

                    $(".admin_infoTit").text($(".startYear").val() + "년 " + $(".startMonth").val() + "월 " + $(".startDay").val() + "일 " + "~ " + $(".endYear").val() + "년 " + $(".endMonth").val() + "월 " + $(".endDay").val() + "일 분석 결과");

                    $(".statistics_result_list").append("<div id='weekChartBox' style='margin-bottom: 40px;'><canvas id='weekChart'></canvas></div>");

                    // 요일별 차트

                    let dcLable = [];

                    let dcDataset = [];

                    let weekList = ['일', '월', '화', '수', '목', '금', '토'];

                    // label 만들기
                    let startWeek = parseInt($(".startWeek").val());
                    let weekCount = startWeek;
                    
                    for (wc=startWeek; wc < startWeek + 7; wc++) {

                        if (weekCount == 7) {

                            weekCount = 0;

                        }

                        let week = weekList[weekCount];

                        dcLable.push(week);

                        dcDataset.push(0);

                        weekCount++;

                    }

                    // 들어온 데이터 요일과 검색한 요일 체크
                    for (dc=0; dc < data[1].length; dc++) {

                        // 요일 통계 테스트 해보기
                        
                        if (data[1][dc]['week0'] > 0) {

                            let weekDay = 0 - weekCount;

                            if (weekDay < 0) {

                                weekDay = 7 - weekCount;

                            } else {

                                weekDay = weekDay;

                            }

                            dcDataset[weekDay] = data[1][dc]['week0'];

                        } else if (data[1][dc]['week1'] > 0) {

                            let weekDay = 1 - weekCount;

                            if (weekDay < 0) {

                                weekDay = 7 - weekCount + 1;

                            } else {

                                weekDay = weekDay;

                            }

                            dcDataset[weekDay] = data[1][dc]['week1'];

                        } else if (data[1][dc]['week2'] > 0) {

                            let weekDay = 2 - weekCount;

                            if (weekDay < 0) {

                                weekDay = 7 - weekCount + 2;

                            } else {

                                weekDay = weekDay;

                            }

                            dcDataset[weekDay] = data[1][dc]['week2'];

                        } else if (data[1][dc]['week3'] > 0) {

                            let weekDay = 3 - weekCount;

                            if (weekDay < 0) {

                                weekDay = 7 - weekCount + 3;

                            } else {

                                weekDay = weekDay;

                            }

                            dcDataset[weekDay] = data[1][dc]['week3'];

                        } else if (data[1][dc]['week4'] > 0) {

                            let weekDay = 4 - weekCount;

                            if (weekDay < 0) {

                                weekDay = 7 - weekCount + 4;

                            } else {

                                weekDay = weekDay;

                            }

                            dcDataset[weekDay] = data[1][dc]['week4'];

                        } else if (data[1][dc]['week5'] > 0) {

                            let weekDay = 5 - weekCount;

                            if (weekDay < 0) {

                                weekDay = 7 - weekCount + 5;

                            } else {

                                weekDay = weekDay;

                            }

                            dcDataset[weekDay] = data[1][dc]['week5'];

                        } else if (data[1][dc]['week6'] > 0) {

                            let weekDay = 6 - weekCount;

                            if (weekDay < 0) {

                                weekDay = 7 - weekCount + 6;

                            } else {

                                weekDay = weekDay;

                            }

                            dcDataset[weekDay] = data[1][dc]['week6'];

                        }

                    }

                    var dcd = document.getElementById("weekChart");

                    var weekChart = new Chart(dcd, {
                        type: 'line',
                        data: {
                            labels: dcLable,
                            datasets: [{
                                data: dcDataset,
                                fill: false,
                                borderColor: '#b0a0c7'
                            }]
                        },
                        options: {
                            legend: { 
                                display: false
                            }
                        }
                    });

                }

                $(".statistics_result").show();

                $("body, html").animate({

                    scrollTop : $(".statistics_result").offset().top

                }, 400);

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }
    
    function changePeriod(period) {

        if (period == "week") {



        } else if (period == "month") {

        }

    }

</script>