<!-- 캘린더 css -->
<link href="<?=$publicCssSrc?>/calendar.css" rel="stylesheet">
<!-- //캘린더 css -->
<div class="calendar">
    <input type="hidden" id="totalDay">
    <input type="hidden" id="startWeek">
    <div class="calendar_head flex-vc-hsb-container">
        <a href="#void" class="calendar_arrow calendar_prev" id="calendarPrev"></a>
        <div class="calendar_ymBox flex-vc-hc-container">
            <div class="ym_con">
                <label for="yearSelect" id="yearSelectedText" class="year_text">년도만 보기</label>
            </div>
            <div class="ym_con">
                <label for="monthSelect" id="monthSelectedText" class="month_text">월만 보기</label>
            </div>
        </div>
        <a href="#void" class="calendar_arrow calendar_next" id="calendarNext"></a>
    </div>
    <div class="calendar_body" id="calendarBody">
        <ul class="calendar_top flex-vc-hc-container" style="display: none;">
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
</div>

<script>

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
                var monthText = data[4];
                var planDay = data[5].map(Number); // 문자배열을 숫자배열로 변환

                $("#yearSelectedText").text(year + "년");
                $("#yearSelect").val(year);
                $("#monthSelectedText").text(monthText + "월");
                $("#monthSelect").val(monthText);
                $("#totalDay").val(totalDay);
                $("#startWeek").val(startWeek);

                var totalColum = parseInt(startWeek) + parseInt(totalDay);

                for (cd=1; cd <= totalColum; cd++) {

                    if (monthText < 10) {

                        var month = "0" + monthText;

                    } else {

                        var month = monthText;

                    }

                    var calendarDayText = cd - startWeek;

                    if (calendarDayText < 10) {

                        var calendarDay = "0" + calendarDayText;

                    } else {

                        var calendarDay = calendarDayText;

                    }

                    if (cd - 1 < startWeek) { // 전달 날짜는 빈칸

                        var calendarDate = "<div id='dayCell" + cd + "' class='calendar_dayBox flex-vc-hc-container'></div>";


                    } else if (year == thisYear && monthText == thisMonth && calendarDay == thisDay) { // 오늘

                        var calendarDate = "<div id='dayCell" + cd + "' class='calendar_dayBox day" + calendarDay + " flex-vc-hc-container today'><div class='calendar_day flex-vc-hc-container' onclick='pickCalendarDate(this)'>" + calendarDayText + "</div></div>";

                    } else {

                        var calendarDate = "<div id='dayCell" + cd + "' class='calendar_dayBox day" + calendarDay + " flex-vc-hc-container'><div class='calendar_day flex-vc-hc-container' onclick='pickCalendarDate(this)'>" + calendarDayText + "</div></div>";

                    }

                    $("#calendarDayList").append(calendarDate);

                    // 클릭된 시작 날짜 색칠
                    if ($(".startYear").length > 0) {

                        if (year == $(".startYear").val() && month == $(".startMonth").val() && calendarDay == $(".startDay").val()) {

                            $("#dayCell" + cd + " .calendar_day").addClass("pick");

                        }

                    }

                    // 클릭된 마지막 날짜 색칠
                    if ($(".endYear").length > 0) {

                        if (year == $(".endYear").val() && month == $(".endMonth").val() && calendarDay == $(".endDay").val()) {

                            $("#dayCell" + cd + " .calendar_day").addClass("pick");

                        }

                    }

                }

                $("#dayCell7, #dayCell14, #dayCell21, #dayCell28, #dayCell35").addClass("saturday"); // 토요일

                $("#dayCell1, #dayCell8, #dayCell15, #dayCell22, #dayCell29, #dayCell36").addClass("holiday"); // 일요일

                // 클릭된 날짜 사이 색칠
                pickCalendarBack(year, month);

                // 날짜가 클릭되어 있을 경우 오늘 색 변경
                if ($(".startYear").length > 0) {

                    $(".today .calendar_day").css({

                        "background-color" : "#cdb9d9"

                    });

                }
    
            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    // 클릭한 날짜 (시작 - 끝)
    function pickCalendarDate (object) {

        var form = $("#statisticsForm");

        $(".today .calendar_day").css({

            "background-color" : "#cdb9d9"

        });

        const year = numberOnly($(".year_text").text());

        const month = numberOnly($(".month_text").text());

        if (month < 10) {

            var monthVal = "0" + month;

        } else {

            var monthVal = month;

        }

        if ($("#calendarDayList").data("val") == "start") { // 마지막 날짜 클릭

            $("#calendarDayList").data("val", "end");

            var endDay = $(object).text();

            if (endDay < 10) {

                var endDayVal = "0" + endDay;

            } else {

                var endDayVal = endDay;

            }

            if ($(".endYear").length == 0) {

                form.append("<input type='hidden' class='endYear' name='endYear' value='" + year + "'>");
                form.append("<input type='hidden' class='endMonth' name='endMonth' value='" + monthVal + "'>");
                form.append("<input type='hidden' class='endDay' name='endDay' value='" + endDayVal + "'>");

            } else {

                $(".endYear").val(year);
                $(".endMonth").val(monthVal);
                $(".endDay").val(endDayVal);

            }

            var startDate = $(".startYear").val() + "-" + $(".startMonth").val() + "-" + $(".startDay").val();

            var endDate = $(".endYear").val() + "-" + $(".endMonth").val() + "-" + $(".endDay").val();

            if (startDate > endDate) {

                alert("시작 날짜가 마지막 날짜보다 클 수 없습니다.");

                $(".today .calendar_day").css({

                    "background-color" : "var(--mainColor)"

                });

                $(".calendar_day").removeClass("pick");

                return false;

            } else if(startDate == endDate) {

                if ($(object).parents().attr("class").indexOf("today") !== -1) {

                    $(".today .calendar_day").css({

                        "background-color" : "var(--mainColor)"

                    });

                }

                $(object).addClass("pick");

            } else {

                $(object).addClass("pick");

                pickCalendarBack(year, monthVal);

            }

            setCookie("page", 0);

            $(".limitStart").val(0);

            viewList();

        } else { // 시작 날짜 클릭

            $("#calendarDayList").data("val", "start");

            var startDay = $(object).text();

            $(".calendar_day").removeClass("pick");
            $(".calendar_dayBox").removeClass("pick_back");
            $(".calendar_dayBox").removeClass("first_pick_back");
            $(".calendar_dayBox").removeClass("last_pick_back");
            $(".endYear").val("");
            $(".endMonth").val("");
            $(".endDay").val("");


            $(object).addClass("pick");

            if (startDay < 10) {

                var startDayVal = "0" + startDay;

            } else {

                var startDayVal = startDay;

            }

            if ($(".startYear").length == 0) {

                form.append("<input type='hidden' class='startYear' name='startYear' value='" + year + "'>");
                form.append("<input type='hidden' class='startMonth' name='startMonth' value='" + monthVal + "'>");
                form.append("<input type='hidden' class='startDay' name='startDay' value='" + startDayVal + "'>");

            } else {

                $(".startYear").val(year);
                $(".startMonth").val(monthVal);
                $(".startDay").val(startDayVal);

            }

        }

    }

    // 클릭된 날짜 사이 색칠
    function pickCalendarBack (year, month) {

        let nowDate = new Date(year + "-" + month);
        let startDate = new Date($(".startYear").val() + "-" + $(".startMonth").val());
        let endDate = new Date($(".endYear").val() + "-" + $(".endMonth").val());

        // 클릭한 월 전체 addClass
        if (nowDate >= startDate && nowDate <= endDate) {

            $(".calendar_dayBox").addClass("pick_back");

        }

        // 시작 월
        if (year == $(".startYear").val() && month == $(".startMonth").val()) {

            // 시작 날짜
            $(".day" + $(".startDay").val()).addClass("first_pick_back");

            // 시작 날짜 전은 removeClass
            var clickIdNum = $(".first_pick_back").attr("id").replace("dayCell", "");

            for (bcn=1; bcn < clickIdNum; bcn++) {

                $("#dayCell" + bcn).removeClass("pick_back");
                
            }

        }

        // 마지막 월
        if (year == $(".endYear").val() && month == $(".endMonth").val()) {

            // 마지막 날짜
            $(".day" + $(".endDay").val()).addClass("last_pick_back");

            // 마지막 날짜 후는 removeClass
            var clickIdNum = parseInt($(".last_pick_back").attr("id").replace("dayCell", ""));

            var totalColum = parseInt($("#startWeek").val()) + parseInt($("#totalDay").val());

            for (acn=clickIdNum + 1; acn <= totalColum; acn++) {

                $("#dayCell" + acn).removeClass("pick_back");
                
            }

        }

    }

</script>