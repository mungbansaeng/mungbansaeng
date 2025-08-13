<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">기간별 접속분석</h3>
        <div class="admin_infobox flex-vc-hl-container">
            <div class="admin_info admin_fullbox">
                <form id="statisticsForm">
                    <input type="hidden" class="page" name="page" value="statistics">
                    <input type="hidden" class="act" name="act" value="counterLog">
                    <input type="hidden" class="pickLimitDay" name="pickLimitDay" value="1">
                    <input type="hidden" class="pickLimitUnit" name="pickLimitUnit" value="m">
                    <!-- 아래 하나 새로 만들어서 리미트를 최소만 걸지 최소 최대 다 걸지 해서 searchCalendar에서 수정하기 이거랑 데이랑 다 봐야함 -->
                    <input type="hidden" class="pickLimit" name="pickLimit" value="min">
                    <?include_once dirname(dirname(dirname(dirname(__FILE__))))."/public/view/calendar/searchCalendar.php";?>
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
            </div>
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

                    // 년도별 차트 (2년이상일때)
                    if (parseInt($(".endYear").val()) - parseInt($(".startYear").val()) > 0) {

                        $(".statistics_result_list").append("<p class='admin_infoTit' style='margin-bottom: 20px;'>년도별</p><div id='yearChartBox' style='margin-bottom: 40px;'><canvas id='yearChart'></canvas></div>");

                        let ycLable = [];

                        let ycDataset = [];

                        // label 만들기
                        for (yc=parseInt($(".startYear").val()); yc <= parseInt($(".endYear").val()); yc++) {

                            ycLable.push(yc);
                            ycDataset.push(0);

                        }

                        // 들어온 데이터 년도와 검색한 년도 체크
                        for (dyc=0; dyc < data[1].length; dyc++) {

                            let yearDataIndex = ycLable.indexOf(parseInt(data[1][dyc]['date'].substr(0, 4)));

                            if (yearDataIndex > -1) {

                                let ycDataCount = ycDataset[yearDataIndex] + parseInt(data[1][dyc]['count']);

                                ycDataset[yearDataIndex] = ycDataCount;

                            }

                        }

                        var ycd = document.getElementById("yearChart");

                        var yearChart = new Chart(ycd, {
                            type: 'line',
                            data: {
                                labels: ycLable,
                                datasets: [{
                                    data: ycDataset,
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

                    // 월별 차트 (2달이상일때)
                    if (parseInt($(".endYear").val()) - parseInt($(".startYear").val()) > 0 || parseInt($(".endMonth").val()) - parseInt($(".startMonth").val()) > 0) {

                        $(".statistics_result_list").append("<p class='admin_infoTit' style='margin-bottom: 20px;'>월별</p><div id='monthChartBox' style='margin-bottom: 40px;'><canvas id='monthChart'></canvas></div>");

                        let mcLable = [];

                        let mcDataset = [];

                        // label 만들기
                        let startDate = new Date($(".startYear").val() + "-" + $(".startMonth").val());

                        let endDate = new Date($(".endYear").val() + "-" + $(".endMonth").val());
                        
                        const diffDate = endDate.getTime() - startDate.getTime();
                        
                        let monthCount = Math.floor(Math.abs(diffDate / (1000 * 60 * 60 * 24 * 30))); // 총 몇달인지 계산

                        let startMonth = parseInt($(".startMonth").val());
                        let startYear = parseInt($(".startYear").val().substr(2, 2));

                        for (mc=0; mc <= monthCount; mc++) {

                            if (startMonth == 13) {

                                startMonth = 1;

                                startYear = startYear + 1;

                            }

                            if (startMonth < 10) {

                                startMonth = "0" + startMonth;

                            } else {

                                startMonth = startMonth;

                            }

                            mcLable.push(startYear + "/" + startMonth);
                            mcDataset.push(0);

                            startMonth++;

                        }

                        // 들어온 데이터 월과 검색한 월 체크
                        for (dmc=0; dmc < data[1].length; dmc++) {

                            let yearData = data[1][dmc]['date'].substr(2, 2);
                            let monthData = data[1][dmc]['date'].substr(5, 2);

                            let dateData = yearData + "/" + monthData;

                            let monthDataIndex = mcLable.indexOf(dateData);

                            if (monthDataIndex > -1) {

                                let mcDataCount = mcDataset[monthDataIndex] + parseInt(data[1][dmc]['count']);

                                mcDataset[monthDataIndex] = mcDataCount;

                            }

                        }

                        var mcd = document.getElementById("monthChart");

                        var monthChart = new Chart(mcd, {
                            type: 'line',
                            data: {
                                labels: mcLable,
                                datasets: [{
                                    data: mcDataset,
                                    fill: false,
                                    borderColor: '#9eb3c6'
                                }]
                            },
                            options: {
                                legend: { 
                                    display: false
                                }
                            }
                        });

                    }

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

</script>