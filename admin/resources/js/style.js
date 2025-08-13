// src
var frontImgSrc = "/front/resources/images";
var adminImgSrc = "/admin/resources/upload";

$(document).ready(function() {
        
    /* 아이디 기억하기 */ 
    var savedAdminId = getCookie("adminId");

    $("#adminId").val(savedAdminId);
    
    if($("#adminId").val() !== ""){

        $("#saveId").prop("checked", true); 

    }
    
    $("#saveId").click(function(){

        if($("#saveId").is(":checked")){ 

            setCookie("adminId", $("#adminId").val(), 7);

        }else{ 

            deleteCookie("adminId");

        }

    });

    $(".description_tab").click(function(){

        var editorId = $(this).data("val");

        $(".description_tab").removeClass("active");

        $(this).addClass("active");

        $(".editor_box").removeClass("show");

        $("#" + editorId + "Box").addClass("show");

    })

    $(".description_tab").eq(0).trigger("click");

});

/* 콤마 시작 */
function comma (num) {
    var len, point, str; 
       
    num = num + ""; 
    point = num.length % 3;
    len = num.length; 
   
    str = num.substring(0, point); 
    while (point < len) { 
        if (str != "") str += ","; 
        str += num.substring(point, point + 3); 
        point += 3; 
    } 
     
    return str;
 
}

/* 콤마 끝 */

/* 실시간 콤마 시작 */

function liveNumberComma(object){

    var number = object.value.toString().replace(/[^0-9]/g,"");
    
    object.value = number.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');

}

/* 실시간 콤마 끝 */

/* input 영어만 사용가능 */
 
function inputonlyEng(object){
    
    object.value = object.value.toString().replace(/[^A-z|a-z]/g,"");
    
}

/* input 한글만 사용가능 */
 
function inputonlyKor(object){
    
    object.value = object.value.toString().replace(/[^ㄱ-힣]/g,"");
    
}

/* input 숫자만 사용가능 */
 
function inputonlyNum(object){
    
    object.value = object.value.toString().replace(/[^0-9]/g,"");
    
}

/* 숫자만 추출 */
 
function numberOnly(text){
    
    const number = text.toString().replace(/[^0-9]/g,"");

    return number;
    
}

/* 쿠키 세팅 시작 */
 
function setCookie(cookieName, value, exdays){
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var cookieValue = escape(value) + ((exdays==null) ? "" : "; expires=" + exdate.toGMTString()) + "; path=/";
    document.cookie = cookieName + "=" + cookieValue;
}

/* 쿠키 세팅 끝 */

/* 쿠키 삭제 시작 */
 
function deleteCookie(cookieName){
    setCookie(cookieName, '', 0);
}

/* 쿠키 삭제 끝 */

/* 쿠키 받아오기 시작 */
 
function getCookie(cookieName) {
    cookieName = cookieName + '=';
    var cookieData = document.cookie;
    var start = cookieData.indexOf(cookieName);
    var cookieValue = '';
    if(start != -1){
        start += cookieName.length;
        var end = cookieData.indexOf(';', start);
        if(end == -1)end = cookieData.length;
        cookieValue = cookieData.substring(start, end);
    }
    return unescape(cookieValue);
}

/* 쿠키 받아오기 끝 */

/* get 파라미터 받아오기 시작 */
 
function getParams(paramName) {

    var url = new URL(window.location.href);

    var getPrams = url.searchParams;

    return getPrams.get(paramName);

}

/* get 파라미터 받아오기 끝 */
    
/* 셀렉트박스 시작 */

function selectboxOpen(object) {

    if ($(object).siblings('.selectbox_depth').html() !== "") {

        $(object).siblings('.selectbox_depth').slideToggle();

        $(object).find('.select_arrow').toggleClass('arrowMove');

    }

}

function selectboxClick(object, selectboxStart) {

    // 셀렉트박스 클릭시 하위 셀렉트 박스 초기화

    var multiSlectbox = $(object).parents(".multi_selectbox");

    for (sbc = selectboxStart; sbc < multiSlectbox.find(".selectbox").length; sbc++) {

        multiSlectbox.find(".selectbox" + sbc).find(".select_arrow").removeClass("arrowMove");

        multiSlectbox.find(".selectbox" + sbc).find(".selectbox_text").html("카테고리 선택");

        multiSlectbox.find(".selectbox" + sbc).find(".selectedValue").val("");

    }

    // 해당 셀렉트박스
    $(object).parents(".selectbox").find(".select_arrow").removeClass('arrowMove');

    $(object).parents(".selectbox").find('.selectbox_depth').hide();

    $(object).parents('.selectbox').find('.selectedValue').val($(object).data("val"));

    $(object).parents('.selectbox').find('.selectbox_text').text($(object).text());

}

/* 셀렉트박스 끝 */

/* 로그인 체크 시작 */

function login_check () {

    if ($("#adminId").val() == "") {

        alert("아이디를 입력하세요.");

        $("#adminId").focus();

        return false;

    } else if ($("#adminPassword").val() == "") {

        alert("비밀번호를 입력하세요.");

        $("#adminPassword").focus();

        return false;

    } else {

        $.ajax({
            type: "POST", 
            dataType: "html",
            async: true,
            url: "/admin/controller/mainController.php",
            global: false,
            data:{
                "page": "login",
                "act": "login",
                "id": $("#adminId").val(),
                "password": $("#adminPassword").val()
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(msg){

                // console.log(msg);

                if(msg == "success"){

                    location.href = "/admin/view/main/dashboard.php";

                }else{

                    alert("계정을 확인해주세요.");

                }
    
            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

}

/* 로그인 체크 끝 */

/* 로그아웃 시작 */

function logout () {

    $.ajax({
        type: "POST", 
        dataType: "html",
        async: true,
        url: "/admin/controller/mainController.php",
        global: false,
        data:{
            "page": "login",
            "act": "logout"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(msg){

            // console.log(msg);

            if(msg == "success"){

                location.href = "/admin";

            }else{

                alert("에러가 발생했습니다. 개발자에게 문의해주세요.");

            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

}

/* 로그아웃 끝 */

/* 엔터 submit 시작 */

function enterkey(object, form) {

    if(window.event.keyCode == 13) {
    	
        if(form == "Y") {

            $(object).parents("form").submit();

        } else {

            $(".enterkeySubmit").trigger("click");

        }

    }

}

/* 엔터 submit 끝 */

/* 전체 체크박스 시작 */

function checkAll() {

    if ($("#checkAll").prop('checked') == false) {

        $(".checkEach").prop('checked', true);

    } else {

        $(".checkEach").prop('checked', false);

    }

}

/* 전체 체크박스 끝 */

/* 개별 체크박스 시작 */

function checkEach(object) {

    var checkedCount = 0;
    var listLength = $(".admin_tbody_list").length;

    for (i=0; i < listLength; i++) {

        const checked = $(".admin_tbody_list").eq(i).find(".checkEach").prop('checked');

        if (checked == true) {

            checkedCount++;

        }

    }

    var listCheckedLength = listLength - 1;

    if ($(object).siblings("input").prop("checked") == false && checkedCount == listCheckedLength) {

        $("#checkAll").prop('checked', true);

    } else {

        $("#checkAll").prop('checked', false);

    }

}

/* 개별 체크박스 끝 */

/* 첨부파일 등록 시작 */

var uploadFileArray = new Array();
var transFileNameArray = new Array();

todayDate = new Date();

var hours = todayDate.getHours();
var minutes = todayDate.getMinutes();
var seconds = todayDate.getSeconds();
var milliseconds = todayDate.getMilliseconds();

function attachClick(object, type, table, officeType){

    var fileFormData = new FormData();

    fileFormData.append('page', 'attachFile');
    fileFormData.append('act', 'reg');
    fileFormData.append('type', type);
    fileFormData.append('table', table);
    fileFormData.append('officeType', officeType);

    var uploadFileCount = $(object)[0].files;

    var fileLength = $(object).parents(".attachfile_box").find('.attach_desclist').length; // 등록된 파일 개수

    var uploadFileNum = fileLength + uploadFileCount.length;

    var fileTotalNum = $(object).siblings('.fileTotalNum').val(); // 첨부할 수 있는 총 개수

    if(uploadFileNum <= fileTotalNum){

        for(i=0; i<uploadFileCount.length; i++){
    
            var uploadFile = $(object)[0].files[i];
            
            if($(object)[0].files[i]['size'] > 20971520){

                alert("20MB 이하 파일만 등록할 수 있습니다.\n\n용량 초과 파일명 : " + $(object)[0].files[i]['name']);

            }else{

                $(object).parents(".attachfile_box").find('.attach_placeholder').hide();
        
                var uploadTime = hours + "" + minutes + "" + seconds + "" + milliseconds;
        
                var uploadTransName = uploadTime + "_" + Math.floor(Math.random() * 100000);
        
                var uploadFileExtPos = uploadFile.name.lastIndexOf('.');
        
                var uploadFileExt = uploadFile.name.substring(uploadFileExtPos + 1, uploadFile.name.length);
        
                var uploadTransFile = uploadTransName + "." + uploadFileExt;

                var uploadQuotName = uploadFile.name;
        
                var uploadName = uploadQuotName.replace(/\'/g,"&#39;");

                fileFormData.append('uploadFiles[]', uploadFile);
                fileFormData.append('uploadTransFileName[]', uploadTransFile);
                fileFormData.append('uploadOriginFileName[]', uploadName);

                var attachDescWith = 100 / uploadFileNum;

                $(".attach_desclist").css({

                    width : "calc(" + attachDescWith + "% - 10px)"
                    
                });

                var idxEq = i + fileLength;

                var fileIdxName = "";

                // transfileName -> 삭제할때 파일명
                // fileIdx -> 등록할때 파일 pk값

                if (type == "") {

                    fileIdxName = "fileIdx";
                    fileTempIdxName = "fileTempIdx";

                } else {

                    fileIdxName = type + "fileIdx";
                    fileTempIdxName = type + "fileTempIdx";

                }

                $(object).parents(".attachfile_box").find('.attach_descbox').append("<div class='attach_desclist' style='width: calc(" + attachDescWith + "% - 10px);'><input type='text' name='uploadName' readonly value='" + uploadName + "'><input type='hidden' name='transfileName[]' class='transfileName' value='" + uploadTransFile + "'><input type='hidden' id='" + fileIdxName + idxEq + "' class='file_idx' name='fileIdx[]'><input type='hidden' id='" + fileTempIdxName + idxEq + "' name='boardTempIdx[]'><p class='attach_del' onclick=\"attachDel(this, '" + table + "', 'admin');\"><img src='../../resources/images/attach_del.png' alt=''></p></div>");
        
            }

        }
                
        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/public/controller/commonController.php",
            processData: false,
            contentType: false,
            data: fileFormData,
            traditional: true,
            global: false,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                if (data[0] == "success") {

                    for (i=0; i < data[1].length; i++) {
                
                        $("#" + fileIdxName + i).val(data[1][i]);
                        $("#" + fileTempIdxName + i).val(data[2][i]);

                    }

                } else {

                    alert("등록 중 에러가 발생했습니다.");

                    $(".attach_desclist").remove();

                    $('.attach_placeholder').show();

                }

            },
            error:function (request,status,error) {

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);

            }
        });

    }else{

        alert("최대 " + fileTotalNum + "개까지 가능합니다.");

    }

}

/* 첨부파일 등록 끝 */

/* 첨부파일 삭제 시작 */

function attachDel (object, table, officeType) {

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/public/controller/commonController.php",
        global: false,
        data:{
            "page": "attachFile",
            "act": "del",
            "table": table,
            "officeType": officeType,
            "transfileName": $(object).siblings('.transfileName').val(),
            "fileIdx": $(object).siblings('.file_idx').val()
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            console.log(data);

            if (data == "success") {

                var fileIdName = $(object).parents(".attachfile_box").find("input[type='file']").attr("id");

                $(object).parents(".attach_desclist").remove();

                var fileLength = $("#" + fileIdName).siblings(".attach_descbox").find(".attach_desclist").length;

                // id 숫자 재설정
                for (i=0; i < fileLength; i++) {
            
                    $(".attach_desclist").eq(i).find(".file_idx").attr("id", "fileIdx" + i);

                }

                // 첨부파일 없을경우             
                if(fileLength == 0){

                    $("#" + fileIdName).siblings(".attach_descbox").find(".attach_placeholder").show();
            
                }

            } else {

                alert("삭제 중 에러가 발생했습니다.");

            }

        },
        error:function (request,status,error) {

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);

        }
        
    });

}

/* 첨부파일 삭제 끝 */

/* 도움말 오픈 시작 */

function openHelp (object) {

    let titWidth = $(object).parents(".admin_infoTit").find(".admin_infoTitText").width() + 10;

    let helpBoxWidth = "";

    if (helpBoxWidth < 420) {

        helpBoxWidth = "420px";

    } else {

        helpBoxWidth = "calc(100% - " + titWidth + "px)";

    }

    $(".help_box").css({

        width : helpBoxWidth

    });

    $(object).siblings(".help_descBox").show();

}

function closeHelp () {

    $(".help_descBox").hide();

}

/* 도움말 오픈 끝 */

/* 엑셀 다운로드 시작 */

function excelDownloadOpen(object){

    if ($(".selectbox0 input[name='categoryIdx1']").length > 0 && !$(".selectbox0 input[name='categoryIdx1']").val()) {

        alert("카테고리를 선택해주세요.");

        return false;

    }

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/admin/controller/boardController.php",
        global: false,
        data: {
            "page" : "productExcelConfig",
            "act" : "list",
            "limitStart" : 0,
            "showNum" : 99999999
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            var excelList = "";

            for (el=0; el < data[1].length; el++) {

                excelList += "<p onclick=\"excelDownload('" + $(object).parents("form").attr("id") + "', 'productExcelConfig', 'product', '" + data[1][el]['idx'] + "', '" + data[1][el]['title'] + "');\">" + data[1][el]['title'] + "</p>";

            }

            $(".excel_downloadBox").html(excelList);

            $(".excel_downloadBox").toggle();

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

}

function excelDownload(formId, ExcelType, type, idx, ExcelTitle){

    const form = $("#" + formId);

    $(".page").val("excel");

    $(".act").val("download");

    form.append("<input type='hidden' class='ExcelType' name='formId' value='" + formId + "'>");

    form.append("<input type='hidden' class='ExcelType' name='ExcelType' value='" + ExcelType + "'>");

    form.append("<input type='hidden' class='type' name='type' value='" + type + "'>");
    
    form.append("<input type='hidden' class='idx' name='idx' value=\"" + idx + "\">");
    
    form.append("<input type='hidden' class='ExcelTitle' name='ExcelTitle' value='" + ExcelTitle + "'>");

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

            if (data[0] == "success") {

                let html = "";
                    
                html += "<html xmlns:x='urn:schemas-microsoft-com:office:excel' >";
                html += "   <haed>";
                html += "       <meta http-equiv='content-type' content='application/vnd.ms-excel; charset=UTF-8'>";
                html += "       <xml>";
                html += "           <x:ExcelWorkbook>";
                html += "               <x:ExcelWorksheets>";
                html += "                   <x:ExcelWorksheets>";
                html += "                       <x:name>"+data[2]+"</x:name>";
                html += "                       <x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions>";
                html += "                   </x:ExcelWorksheets>";
                html += "               </x:ExcelWorksheets>";
                html += "           </x:ExcelWorkbook>";
                html += "       </xml>";
                html += "   </haed>";
                html += "   <body>";
                html += data[1];
                html += "   </body>";
                html += "</html>";
        
                let blob = new Blob([html], {type: "application/csv; charset=utf-8"});
        
                let anchor = window.document.createElement('a');
        
                anchor.href = window.URL.createObjectURL(blob);
                anchor.download = data[3] + ".xls";
                document.body.appendChild(anchor);
                anchor.click();
                
                //다운로드 후 제거
                document.body.removeChild(anchor);

                $(".excel_downloadBox").hide();

                $(".page").val("statistics");
            
                $(".act").val("counterInfo");

            }

        },
        error:function (request,status,error) {

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);

        }
        
    });

}

/* 엑셀 다운로드 끝 */

/* 상품별 배송상태 변경 시작 */

function orderStatusModi (object, type, status) {

    if (type == "all") {

        var statusData = status;
        var orderProductIdxData = "";

        for (ol=0; ol < $(".order_list ul").length; ol++) {

            orderProductIdxData += ol == 0 ? "'" + $(".order_list ul").eq(ol).find(".orderProductIdx").val() + "'" : ",'" + $(".order_list ul").eq(ol).find(".orderProductIdx").val() + "'";

        }

    } else {

        var statusData = $(object).val();
        var orderProductIdxData =  $(object).siblings(".orderInfo_hidden").find(".orderProductIdx").val();

    }

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/admin/controller/orderController.php",
        global: false,
        data: {
            page: "order",
            act: "statusModify",
            orderNo: $(".orderNo").val(),
            status: statusData,
            orderProductIdx: orderProductIdxData
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            if (data == "success") {

                if (type == "all") {

                    for (olr=0; olr < $(".order_list ul").length; olr++) {

                        $("#orderStatus" + olr).val(status).prop("selected", true);

                    }

                }

            } else {

                document.write(data);

            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

}

/* 상품별 배송상태 변경 끝 */

/* 선택삭제 시작 */

function selectDel () {
    
    $(".del_idx").remove();
    $(".del_boardFile").remove();
    $(".act").val("selectDel");

    const form = $("#form");

    const listLength = $(".admin_tbody_list").length;

    for (i=0; i < listLength; i++) {

        const checked = $(".admin_tbody_list").eq(i).find(".checkEach").prop('checked');

        if (checked == true) {

            let stringIdx = $(".admin_tbody_list").eq(i).find(".checkEach").attr("id");

            let idx = stringIdx.replace("check", "");

            form.append("<input type='hidden' name='idx[]' class='del_idx' value='" + idx + "'>");

        }

    }

    if (form.find(".page").val() == "coupon") {

        if(!confirm("이미 발급받은 쿠폰은 회수가 불가합니다. 쿠폰을 삭제하시겠습니까?")) {
            
            return false;

        }

    }

    if ($(".del_idx").length > 0) {

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/admin/controller/boardController.php",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                if (data == "success") {

                    setCookie("page", 0);

                    $("#checkAll").prop('checked', false);

                    $(".act").val("list");

                    $(".admin_tbody").html(""); // 리스트 초기화

                    viewList();

                } else {

                    alert("오류가 발생했습니다. 개발자에게 문의해주세요.");

                }

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    } else {

        alert("최소 1개 이상 선택해주세요.");

    }

}

/* 선택삭제 끝 */

/* 검색 시작 */

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

/* 검색 끝 */

/* 검색 엔터 시작 */

function searchEnter () {

    if (event.keyCode === 13) {

        search();

    }

}

/* 검색 엔터 끝 */

/* 검색 input 변경 시작 */

function searchVal (object) {

    if ($(object).attr("class") == "show") {

        let searchSelectVal = $(".search_text select").val();

        $(".search_text input[type='text']").val(searchSelectVal);

    }

}

/* 검색 input 변경 끝 */

/* 공통 탭 시작 */

function tabClick (object) {

    $(".tabBtn").removeClass("active");
    $(object).addClass("active");

}

/* 공통 탭 끝 */