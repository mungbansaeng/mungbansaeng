<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/controller/commonController.php";

?>

<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">대시보드</h3>
        <div class="flex-vc-hsb-container">
            <div class="admin_infobox admin_halfbox">
                <div class="admin_info">
                    <p class="admin_infoTit">접속 통계</p>
                    <div id="chartBox">
                        <canvas id="counterChart"></canvas>
                    </div>
                    <script>

                        $.ajax({
                            type: "POST", 
                            dataType: "html",
                            async: true,
                            url: "/admin/controller/commonController.php",
                            global: false,
                            data: {
                                "page": "statistics",
                                "act": "monthstatisticsCount"
                            },
                            traditional: true,
                            beforeSend:function(xhr){
                            },
                            success:function(msg){

                                var data = JSON.parse(msg);

                                if(data[0] == "success"){

                                    var ctx = document.getElementById("counterChart");

                                    var counterChart = new Chart(ctx, {
                                        type: 'pie',
                                        data: {
                                            labels: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
                                            datasets: [{
                                                data: [
                                                    data[1][0]["JanCount"],
                                                    data[1][0]["FebCount"],
                                                    data[1][0]["MarCount"],
                                                    data[1][0]["AprCount"],
                                                    data[1][0]["MayCount"],
                                                    data[1][0]["JunCount"],
                                                    data[1][0]["JulCount"],
                                                    data[1][0]["AugCount"],
                                                    data[1][0]["SepCount"],
                                                    data[1][0]["OctCount"],
                                                    data[1][0]["NovCount"],
                                                    data[1][0]["DecCount"]
                                                ],
                                                backgroundColor: [
                                                    '#b0a0c7',
                                                    '#9ea4c6',
                                                    '#9eb3c6',
                                                    '#9fb6c7',
                                                    '#9fc7ac',
                                                    '#bcc79f',
                                                    '#bcbaa2',
                                                    '#c6a56c',
                                                    '#c8b190',
                                                    '#b9734b',
                                                    '#bf8185',
                                                    '#c194ba'
                                                ]
                                            }]
                                        },
                                        options: {
                                            legend: { 
                                                display: false
                                            },
                                            maintainAspectRatio: false
                                        }
                                    });

                                }else{

                                    document.write(data);

                                }

                            },
                            error:function(request,status,error){

                                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                                
                            }
                            
                        });
                        
                    </script>
                </div>
            </div>
            <div class="admin_infobox admin_halfbox">
                <div class="admin_info">
                    <p class="admin_infoTit">일정</p>
                    <?include_once dirname(dirname(dirname(dirname(__FILE__))))."/public/view/calendar/planCalendar.php";?>
                </div>
            </div>
            <div class="admin_infobox admin_fullbox">
                <div class="admin_info">
                    <p class="admin_infoTit">매출 통계</p>
                    
                </div>
            </div>
        </div>
    </div>
</div>