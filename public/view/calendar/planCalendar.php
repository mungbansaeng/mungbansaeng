<!-- 캘린더 css -->
<link href="<?=$publicCssSrc?>/calendar.css" rel="stylesheet">
<!-- //캘린더 css -->
<div class="calendar">
    <div class="calendar_head flex-vc-hsb-container">
        <a href="#void" onclick="setCalendar('prev');" class="calendar_arrow calendar_prev" id="calendarPrev"><img src="/public/resources/images/cal_prev.png"></a>
        <div class="calendar_ymBox flex-vc-hc-container">
            <div class="ym_con">
                <label for="yearSelect" id="yearSelectedText" class="ym_text year_text"></label>
                <select id="yearSelect" class="calendar_ym calendar_year" onchange="setCalendar();">
                    <?
                    
                        for($y=2000; $y <= 2101; $y++){
                    
                    ?>
                    <option value="<?=$y?>"><?=$y?>년</option>
                    <?}?>
                </select>
            </div>
            <div class="ym_con">
                <label for="monthSelect" id="monthSelectedText" class="ym_text month_text"></label>
                <select id="monthSelect" class="calendar_ym calendar_month" onchange="setCalendar();">
                    <?
                    
                        for($m=1; $m <= 12; $m++){
                    
                    ?>
                    <option value="<?=$m?>"><?=$m?>월</option>
                    <?}?>
                </select>
            </div>
            <div class="ym_con">
                <p onclick="setCalendar('today');" id="goToday">오늘</p>
            </div>
        </div>
        <a href="#void" onclick="setCalendar('next');" class="calendar_arrow calendar_next" id="calendarNext"><img src="/public/resources/images/cal_next.png"></a>
    </div>
    <div class="calendar_body" id="calendarBody">
        <ul class="calendar_top flex-vc-hc-container">
            <li class="holiday">일</li>
            <li>월</li>
            <li>화</li>
            <li>수</li>
            <li>목</li>
            <li>금</li>
            <li class="saturday">토</li>
        </ul>
        <div class="calendar_bottom flex-vc-hl-container" id="calendarDayList"></div>
    </div>

    <!-- 캘린더 리스트 팝업 시작 -->
    <div id="calendar_listPopup" class="calendar_popup flex-vc-hc-container">
        <div class="calendar_popBox">
            <div class="calendar_popTop flex-vc-hsb-container">
                <p class="calendar_popDate"></p>
                <p class="calendar_popClose" onclick="calendarPopupClose();"><img src="/public/resources/images/calendar_popClose.png"></p>
            </div>
            <div class="calendar_popBottom"></div>
            <div class="calendar_popBtnBox flex-vc-hc-container">
                <input type="button" class="calendar_regiBtn" value="등록하기" onclick="calendarRegiPopupOpen();">
            </div>
        </div>
    </div>
    <!-- 캘린더 리스트 팝업 끝 -->

    <!-- 캘린더 등록 팝업 시작 -->
    <div id="calendar_regiPopup" class="calendar_popup flex-vc-hc-container">
        <div class="calendar_popBox">
            <div class="calendar_popTop flex-vc-hsb-container">
                <p class="calendar_popDate"></p>
                <p class="calendar_popClose" onclick="calendarPopupClose();"><img src="/public/resources/images/calendar_popClose.png"></p>
            </div>
            <div class="calendar_popBottom">
                <textarea id="regiDesc" maxlength="100" placeholder="최대 100자 입니다."></textarea>
            </div>
            <div class="calendar_popBtnBox flex-vc-hc-container">
                <input type="button" class="calendar_regiBtn" value="등록하기" onclick="regiCalendar();">
                <input type="button" class="calendar_backBtn" value="돌아가기" onclick="calendarBack();">
            </div>
        </div>
    </div>
    <!-- 캘린더 등록 팝업 끝 -->

    <!-- 캘린더 수정 팝업 시작 -->
    <div id="calendar_modiPopup" class="calendar_popup flex-vc-hc-container">
        <div class="calendar_popBox">
            <div class="calendar_popTop flex-vc-hsb-container">
                <p class="calendar_popDate"></p>
                <p class="calendar_popClose" onclick="calendarPopupClose();"><img src="/public/resources/images/calendar_popClose.png"></p>
            </div>
            <div class="calendar_popBottom">
                <textarea id="modiDesc" maxlength="100" placeholder="최대 100자 입니다."></textarea>
                <input type="hidden" id="planIdx" value="">
                <input type="hidden" id="beforeDesc" value="">
            </div>
            <div class="calendar_popBtnBox flex-vc-hc-container">
                <input type="button" class="calendar_regiBtn" value="수정하기" onclick="modiCalendar();">
                <input type="button" class="calendar_backBtn" value="돌아가기" onclick="calendarBack();">
            </div>
        </div>
    </div>
    <!-- 캘린더 수정 팝업 끝 -->
</div>

<script>

    setCalendar("today"); // 로딩시 오늘 날짜

    function setCalendar (set) {

        var date = new Date();

        var thisYear = date.getFullYear();

        var thisMonth = date.getMonth() + 1;

        var thisDay = date.getDate();

        if (set == "today") { // 오늘일때

            changeYear = thisYear;
            changeMonth = thisMonth;

        } else if (set == "prev") { // 이전 버튼일때

            changeYear = parseInt($("#monthSelect").val()) - 1 == 0 ? parseInt($("#yearSelect").val()) - 1 : parseInt($("#yearSelect").val());
            
            changeMonth = parseInt($("#monthSelect").val()) - 1 == 0 ? 12 : parseInt($("#monthSelect").val()) - 1;

        } else if (set == "next") { // 다음 버튼일때

            changeYear = parseInt($("#monthSelect").val()) + 1 > 12 ? parseInt($("#yearSelect").val()) + 1 : parseInt($("#yearSelect").val());
            
            changeMonth = parseInt($("#monthSelect").val()) + 1 > 12 ? 1 : parseInt($("#monthSelect").val()) + 1;

        } else { // 날짜 변경일때

            changeYear = $("#yearSelect").val();
            changeMonth = $("#monthSelect").val();

        }

        $.ajax({
            type: "GET", 
            dataType: "json",
            async: true,
            url: "/public/controller/planCalendarController",
            global: false,
            data:{
                "act": "planListCheck",
                "year": changeYear,
                "month": changeMonth,
                "day": thisDay
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                $("#calendarDayList").html("");

                var startWeek = data[1]; // 시작 요일
                var totalDay = data[2]; // 현재 달의 총 날짜
                var year = data[3];
                var month = data[4];
                var planDay = data[5].map(Number); // 문자배열을 숫자배열로 변환

                $("#yearSelectedText").text(year + "년");
                $("#yearSelect").val(year);
                $("#monthSelectedText").text(month + "월");
                $("#monthSelect").val(month);

                var totalColum = parseInt(startWeek) + parseInt(totalDay);

                for (cd=1; cd <= totalColum; cd++) {

                    calendarDay = cd - startWeek;

                    if (cd - 1 < startWeek) { // 전달 날짜는 빈칸

                        var calendarDate = "<div id='dayCell" + cd + "' class='calendar_dayBox flex-vc-hc-container'></div>";


                    } else if (year == thisYear && month == thisMonth && calendarDay == thisDay) { // 오늘

                        if (planDay.indexOf(calendarDay) > -1) { // 일정 있을때

                            var calendarDate = "<div id='dayCell" + cd + "' class='calendar_dayBox flex-vc-hc-container today'><div class='calendar_day flex-vc-hc-container' onclick='calendarPopupOpen(this)'>" + calendarDay + "</div><p class='plan_check'></p></div>";

                        } else {

                            var calendarDate = "<div id='dayCell" + cd + "' class='calendar_dayBox flex-vc-hc-container today'><div class='calendar_day flex-vc-hc-container' onclick='calendarPopupOpen(this)'>" + calendarDay + "</div></div>";

                        }

                    } else {

                        if (planDay.indexOf(calendarDay) > -1) { // 일정 있을때

                            var calendarDate = "<div id='dayCell" + cd + "' class='calendar_dayBox flex-vc-hc-container'><div class='calendar_day flex-vc-hc-container' onclick='calendarPopupOpen(this)'>" + calendarDay + "</div><p class='plan_check'></p></div>";

                        } else {

                            var calendarDate = "<div id='dayCell" + cd + "' class='calendar_dayBox flex-vc-hc-container'><div class='calendar_day flex-vc-hc-container' onclick='calendarPopupOpen(this)'>" + calendarDay + "</div></div>";

                        }

                    }

                    $("#calendarDayList").append(calendarDate);

                }

                $("#dayCell7, #dayCell14, #dayCell21, #dayCell28, #dayCell35").addClass("saturday"); // 토요일

                $("#dayCell1, #dayCell8, #dayCell15, #dayCell22, #dayCell29, #dayCell36").addClass("holiday"); // 일요일
    
            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    function calendarPopupOpen (object) {

        $planList = "";

        // 일정 리스트 조회

        $.ajax({
            type: "GET", 
            dataType: "json",
            async: true,
            url: "/public/controller/planCalendarController",
            global: false,
            data:{
                "act": "planList",
                "year": $("#yearSelect").val(),
                "month": $("#monthSelect").val(),
                "day": $(object).text()
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                if (data[0] == "success") {

                    for (pl=0; pl < data[5].length; pl++) {

                        $planList += "<div class='calendar_planList'><div class='calendar_planDesc' onclick='calendarModiPopupOpen(this)'>" + data[5][pl] + "</div><div class='calendar_planBtn' onclick='delCalendar(" + data[6][pl] + ")'><p><img src='/public/resources/images/calendar_delBtn.png' alt=''></p></div></div>";
                        
                    }

                } else if (data[0] == "empty") {

                    $planList = "<div class='calendar_planList calendar_noPlan'><p class='calendar_planDesc'>일정이 없습니다.</p></div>";

                }

                $("#calendar_listPopup .calendar_popBottom").html($planList);

                const year = $("#yearSelect").val();
                const stringMonth = $("#monthSelect").val();
                const stringDay = $(object).text();

                month = parseInt(stringMonth) < 10 ? "0" + stringMonth : stringMonth;

                day = parseInt(stringDay) < 10 ? "0" + stringDay : stringDay;

                $(".calendar_popDate").text(year + "-" + month + "-" + day);  

                $('#calendar_listPopup').animate({

                    height : "100%",
                    opacity: 1

                }, 200);
    
            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    function calendarPopupClose (object) {

        $('.calendar_popup').animate({

            height : 0,
            opacity: 0

        }, 200);

    }

    // 클릭한 날짜 가져오기
    function clickCalendarDate () {

        var calendarDate = $(".calendar_popDate").text();

        var year = calendarDate.substr(0, 4);
        var calndarMonth = calendarDate.substr(5, 2);
        var calndarDay = calendarDate.substr(8, 2);

        if (calndarMonth < 10) {

            var month = calendarDate.substr(6, 1);

        } else {

            var month = calndarMonth;

        }

        if (calndarDay < 10) {

            var day = calendarDate.substr(9, 1);

        } else {

            var day = calndarDay;

        }

        var dateArr = [year, month, day];

        return dateArr;

    }

    // 일정 등록 팝업
    function calendarRegiPopupOpen (object) {

        // textarea 초기화
        $("#regiDesc").val("");

        $("#calendar_listPopup").animate({

            height : 0,
            opacity: 0

        }, 0);

        $("#calendar_regiPopup").animate({

            height : "100%",
            opacity: 1

        }, 0);

    }

    // 일정 등록
    function regiCalendar () {

        var date = clickCalendarDate();

        var descriptionVal = $("#regiDesc").val();
        var changeDescription = descriptionVal.replace(/'/g, "\\\'");
        var description = changeDescription.replace(/"/g, "\\\"");

        $planList = "";

        // 일정 등록

        $.ajax({
            type: "GET", 
            dataType: "json",
            async: true,
            url: "/public/controller/planCalendarController",
            global: false,
            data:{
                "act": "planRegi",
                "year": date[0],
                "month": date[1],
                "day": date[2],
                "description": description
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                setCalendar();

                if (data[0] == "success") {

                    for (pl=0; pl < data[5].length; pl++) {

                        $planList += "<div class='calendar_planList'><div class='calendar_planDesc' onclick='calendarModiPopupOpen(this)'>" + data[5][pl] + "</div><div class='calendar_planBtn' onclick='delCalendar(" + data[6][pl] + ")'><p><img src='/public/resources/images/calendar_delBtn.png' alt=''></p></div></div>";
                        
                    }

                }

                $("#calendar_listPopup .calendar_popBottom").html($planList);

                $("#calendar_listPopup").animate({

                    height : "100%",
                    opacity: 1

                }, 0);

                $("#calendar_regiPopup").animate({

                    height : 0,
                    opacity: 0

                }, 0);
    
            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    // 일정 수정 팝업
    function calendarModiPopupOpen (object) {

        var date = clickCalendarDate();

        // 내용 가져오기
        $.ajax({
            type: "GET", 
            dataType: "json",
            async: true,
            url: "/public/controller/planCalendarController",
            global: false,
            data:{
                "act": "planList",
                "year": date[0],
                "month": date[1],
                "day": date[2]
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                var planDescCount = $(object).parents(".calendar_planList").index();

                $("#modiDesc").val(data[5][planDescCount]);
                $("#beforeDesc").val(data[5][planDescCount]);
                $("#planIdx").val(data[6][planDescCount]);

                $("#calendar_listPopup").animate({

                    height : 0,
                    opacity: 0

                }, 0);

                $("#calendar_modiPopup").animate({

                    height : "100%",
                    opacity: 1

                }, 0);
    
            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    // 일정 수정
    function modiCalendar () {

        var date = clickCalendarDate();

        // 수정할 내용
        var descriptionVal = $("#modiDesc").val();
        var changeDescription = descriptionVal.replace(/'/g, "\\\'");
        var description = changeDescription.replace(/"/g, "\\\"");

        // 수정전 내용
        var beforeDescriptionVal = $("#beforeDesc").val();
        var beforeDescription = beforeDescriptionVal.replace(/'/g, "\\\'");
        var newBeforeDescription = beforeDescription.replace(/"/g, "\\\"");

        $planList = "";

        // 일정 수정

        $.ajax({
            type: "GET", 
            dataType: "json",
            async: true,
            url: "/public/controller/planCalendarController",
            global: false,
            data:{
                "act": "planModi",
                "year": date[0],
                "month": date[1],
                "day": date[2],
                "idx": $("#planIdx").val(),
                "description": description,
                "beforeDescription": newBeforeDescription
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                if (data[0] == "success") {

                    for (pl=0; pl < data[5].length; pl++) {

                        $planList += "<div class='calendar_planList'><div class='calendar_planDesc' onclick='calendarModiPopupOpen(this)'>" + data[5][pl] + "</div><div class='calendar_planBtn' onclick='delCalendar(" + data[6][pl] + ")'><p><img src='/public/resources/images/calendar_delBtn.png' alt=''></p></div></div>";
                        
                    }

                }

                $("#calendar_listPopup .calendar_popBottom").html($planList);

                $("#calendar_listPopup").animate({

                    height : "100%",
                    opacity: 1

                }, 0);

                $("#calendar_modiPopup").animate({

                    height : 0,
                    opacity: 0

                }, 0);
    
            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    // 일정 삭제
    function delCalendar (idx) {

        var date = clickCalendarDate();

        // 수정할 내용
        var descriptionVal = $("#modiDesc").val();
        var changeDescription = descriptionVal.replace(/'/g, "\\\'");
        var description = changeDescription.replace(/"/g, "\\\"");

        // 수정전 내용
        var beforeDescriptionVal = $("#beforeDesc").val();
        var beforeDescription = beforeDescriptionVal.replace(/'/g, "\\\'");
        var newBeforeDescription = beforeDescription.replace(/"/g, "\\\"");

        $planList = "";

        // 일정 삭제

        $.ajax({
            type: "GET", 
            dataType: "json",
            async: true,
            url: "/public/controller/planCalendarController",
            global: false,
            data:{
                "act": "planDel",
                "year": date[0],
                "month": date[1],
                "day": date[2],
                "idx": idx,
                "description": description,
                "beforeDescription": newBeforeDescription
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                setCalendar();

                if (data[0] == "success") {

                    for (pl=0; pl < data[5].length; pl++) {

                        $planList += "<div class='calendar_planList'><div class='calendar_planDesc' onclick='calendarModiPopupOpen(this)'>" + data[5][pl] + "</div><div class='calendar_planBtn' onclick='delCalendar(" + data[6][pl] + ")'><p><img src='/public/resources/images/calendar_delBtn.png' alt=''></p></div></div>";
                        
                    }

                } else if (data[0] == "empty") {

                    $planList = "<div class='calendar_planList calendar_noPlan'><p class='calendar_planDesc'>일정이 없습니다.</p></div>";

                }

                $("#calendar_listPopup .calendar_popBottom").html($planList);

                var planDay = data[5].map(Number); // 문자배열을 숫자배열로 변환
    
            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    // 돌아가기 버튼
    function calendarBack () {

        $(".calendar_popup").animate({

            height : 0,
            opacity: 0

        }, 0);

        $("#calendar_listPopup").animate({

            height : "100%",
            opacity: 1

        }, 0);

    }

</script>