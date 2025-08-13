// src
var frontImgSrc = "/front/resources/images";
var adminImgSrc = "/admin/resources/upload";

$(document).ready(function(){
        
    /* 아이디 기억하기 */ 
    var savedAdminId = atob(getCookie("saveId"));

    $("#userId").val(savedAdminId);
    
    if ($("#userId").val() !== "") {

        $("#saveId").prop("checked", true); 

    }
    
    $("#saveId").click(function() {

        if ($("#saveId").is(":checked")) { 

            let userId = btoa($("#userId").val());

            setCookie("saveId", userId, 7);

        } else {

            deleteCookie("saveId");

        }

    });

    if ($("#userId").val() == "") {

        $("#userId").focus();

    } else if ($("#userPassword").val() == "") {

        $("#userPassword").focus();

    };

    // 검색창 열기 시작

    $(".header_searchBox, .headerActive_searchBtn, .mobileSearch_btn").click(function() {

        $("#searchWord").val("");

        $(".headerActive_searchBox").addClass("active");

        $(".headerActive_searchText").focus();

    });

    // 검색창 열기 끝

    // 검색창 닫기 시작

    $(".close_btn").click(function() {

        $(".headerActive_searchBox").removeClass("active");

    });

    // 검색창 닫기 끝

    $(".recommend_searchList").mouseover(function() {

        let thisText = $(this).text();

        let recommendSearchWord = thisText.replace("#", "");

        $(".headerActive_searchText").val(recommendSearchWord);

    });

    $(".recommend_searchList").mouseleave(function() {

        $(".headerActive_searchText").val("");

    });

    $(".recommend_searchList").click(function() {

        checkSearch();

    });

    if ($('body').width() < 600) {

        var mainAllergy_listCount = $(".mainAllergy_list").length;
        var mainAllergy_listWidth = $(".mainAllergy_list").width() + 20;

        var mainAllergy_listTotlaWidth = mainAllergy_listWidth * mainAllergy_listCount;

        $(".mainAllergy_listBox").width(mainAllergy_listTotlaWidth);

    }

    /* 좋아요 시작 */
    
    $(".wish_click").click(function(){

        $(this).html("");

        let wishAni = bodymovin.loadAnimation({
            container: $(".wish_click")[0],
            renderer: 'svg',
            loop: false,
            autoplay: false,
            path: frontImgSrc + "/wish.json"
        });
    
        if($(this).hasClass("active")){ // 좋아요 취소
    
            $.ajax({
                type: "POST", 
                dataType: "json",
                async: true,
                url: "/front/controller/orderController",
                global: false,
                data:{
                    "page": "wish",
                    "act": "delete",
                    "productCode": $(".productCode").val()
                },
                traditional: true,
                beforeSend:function(xhr){
                },
                success:function(data){
    
                    // console.log(data);

                    $(".hearder_wish_count").text(data[1].length);
                
                    $(".hearderActive_wish_count").text(data[1].length);
    
                    $(".wish_click").removeClass("active");
            
                    wishAni.playSegments([0, 41], true);
        
                },
                error:function(request,status,error){

                    console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                    
                }
                
            });
    
        }else{ // 좋아요 클릭
    
            $.ajax({
                type: "POST", 
                dataType: "json",
                async: true,
                url: "/front/controller/orderController",
                global: false,
                data:{
                    "page": "wish",
                    "act": "insert",
                    "productCode": $(".productCode").val()
                },
                traditional: true,
                beforeSend:function(xhr){
                },
                success:function(data){

                    $(".hearder_wish_count").text(data[1].length);
                
                    $(".hearderActive_wish_count").text(data[1].length);
    
                    $(".wish_click").addClass("active");
            
                    wishAni.playSegments([86, 142], true);
        
                },
                error:function(request,status,error){

                    console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                    
                }
                
            });
    
        }
    
    });
    
    /* 좋아요 끝 */

});
    
/* 셀렉트박스 시작 */

function selectboxOpen(object) {

    if ($(object).siblings('.selectbox_depth').html() !== "") {

        $(object).siblings('.selectbox_depth').slideToggle();

        $(object).find('.select_arrow').toggleClass('arrowMove');

    }

}

function selectboxClick(object) {

    $('.selectbox_tit .select_arrow').removeClass('arrowMove');

    $('.selectbox_depth').hide();

    if($(object).attr("id") !== "soldOut"){

        $(object).parents('.selectbox').find('.selectedValue').val($(object).data("val"));

        if ($(object).find(".optionList_titBox p").length > 0) {

            $(object).parents('.selectbox').find('.selectbox_text').text($(object).find(".optionList_tit").text() + " (" + $(object).find(".optionList_price").text() + ")");

        } else {

            $(object).parents('.selectbox').find('.selectbox_text').text($(object).find(".optionList_tit").text());

        }

    }

}

/* 셀렉트박스 끝 */

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
 
function getCookie (cookieName) {
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
 
function getParams (paramName) {

    var url = new URL(window.location.href);

    var getPrams = url.searchParams;

    return getPrams.get(paramName);

}

/* get 파라미터 받아오기 끝 */

/* 슬라이드 토글 시작 */

function updownSlide(object) {

    let updownSlideBox = $(object).parents(".updownSlide_box");

    if (updownSlideBox.attr("class").indexOf("show") > 0) {

        $(".updownSlide_box").removeClass("show");

    } else {

        $(object).parents(".updownSlide_box").siblings().removeClass("show");

        $(object).parents(".updownSlide_box").addClass("show");

    }

}

/* 슬라이드 토글 끝 */

/* 직접입력시 input 생성 시작 */

function addInput(object){

    if($(object).val() == "직접입력"){

        $(".add_input").show();

        $(object).parents(".add_inputBox").removeClass("flex-vc-hl-container");

        $(object).parents(".add_inputBox").addClass("flex-vt-hl-container");

    }else{

        $(".add_input").hide();

        $(object).parents(".add_inputBox").removeClass("flex-vt-hl-container");

        $(object).parents(".add_inputBox").addClass("flex-vc-hl-container");

    }

}

/* 직접입력시 input 생성 끝 */

/* 전체동의 */

function tncCheckAll(){
    
    if($("#checkAll").prop("checked")){

        $(".tnc_list").find("input[type='checkbox']").prop("checked", true);

    }else if(!$("#checkAll").prop("checked")){

        $(".tnc_list").find("input[type='checkbox']").prop("checked", false);

    }

}

/* 개별동의 */

function tncCheckEach(){
    
    let CheckEachLength = $(".tnc_checkEach").length;

    let CheckEachCheckedLength = 0;

    for(ce = 0; ce < CheckEachLength; ce++){

        let CheckEachChecked = $(".tnc_checkEach").eq(ce).find("input[type='checkbox']").prop("checked");

        if(CheckEachChecked == true){

            CheckEachCheckedLength++;

        }

    }

    if(CheckEachCheckedLength == CheckEachLength){

        $("#checkAll").prop("checked", true);

    }else{

        $("#checkAll").prop("checked", false);

    }

}


/* 회원가입 약관동의 */

function tncFieldCheck(){
    
    if(!$("#tnc1").prop("checked")){

        alert('개인정보 취급방침에 동의해주세요.');
        
        return false;

    }else if(!$("#tnc2").prop("checked")){

        alert('이용약관에 동의해주세요.');
        
        return false;

    }else{

        // 해당부분은 휴대폰 인증 연동하면서 수정하기 우선은 테스트로 해놓은것

        $(".cert").val("Y");

        $("#joinTermForm").submit();

        // openKMCISWindow();

    }

}

/* 아이디 중복 체크 */

function idDupliCheck (object) {

    var checkEmail = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;

    if (checkEmail.test(object.value) === false) {

        cmAlert("이메일 형식이 맞지 않습니다.");

        return false;

    } else {

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: false,
            url: "/front/controller/memberController",
            global: false,
            data:{
                "page": "memberJoin",
                "act": "joinForm",
                "id": $('#id').val()
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){
    
                // console.log(data);

                if (data[0] == "exist") {

                    cmAlert("이미 사용중이거나 탈퇴한 아이디입니다.");

                } else {

                    cmAlert("사용할 수 있는 아이디입니다.");

                }
    
            },
            error:function(request,status,error){
    
                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

}

/* 비밀번호 형식 체크 */

function passwordDupliCheck(object, type){

    var passwordCheckNum = object.value.search(/[0-9]/g);
    var passwordCheckEng = object.value.search(/[a-zA-Z]/g);
    var passwordCheckExp = object.value.search(/[\{\}\[\]\/?.,;:|\)*~`!^\-_+<>@\#$%&\\\=\(\'\"]/g);

    if ($(object).attr("id") == "password" && $("#password").val() == "") { // 회원가입 비밀번호를 입력안했을때

        cmAlert("비밀번호를 입력해주세요.");

        return false;

    } else if ($(object).attr("id") == "originPassword" && $("#originPassword").val() == "") { // 회원정보수정 비밀번호를 입력안했을때

        cmAlert("비밀번호를 입력해주세요.");

        return false;

    } else if (passwordCheckNum < 0 || passwordCheckEng < 0 || passwordCheckExp < 0) {

        cmAlert("비밀번호는 영문,숫자,특수문자 조합이어야 합니다.");

        return false;

    } else if (type == "re") { // 비밀번호와 비밀번호 확인 체크

        if ($("#password").val() == $(object).val()) { // 같을때

            cmAlert("비밀번호가 확인되었습니다.");
            
        } else { // 다를때

            cmAlert("비밀번호가 다릅니다.");

            return false;

        }

    } else if ($(object).attr("id") !== "originPassword") {

        cmAlert("사용가능한 비밀번호 입니다.");

    }

}

/* 회원가입 입력 체크 */

function joinFieldCheck(){

    let form = $("#joinForm");

    let passwordCheckNum = document.joinForm.password.value.search(/[0-9]/g);
    let passwordCheckEng = document.joinForm.password.value.search(/[a-zA-Z]/g);
    let passwordCheckExp = document.joinForm.password.value.search(/[\{\}\[\]\/?.,;:|\)*~`!^\-_+<>@\#$%&\\\=\(\'\"]/g);

    if (!document.getElementById("ci").value) {

        cmAlert("본인인증을 진행해주세요.", "link", "/join");
        
        return false;

    } else if(!document.getElementById("id").value) {

        cmAlert("아이디를 입력하세요.", "focus", "id");

        return false;

    } else if (!document.getElementById("password").value) {

        cmAlert("비밀번호를 입력하세요.", "focus", "password");

        return false;

    } else if (passwordCheckNum < 0 || passwordCheckEng < 0 || passwordCheckExp < 0) {

        cmAlert("비밀번호는 영문,숫자,특수문자 조합이어야 합니다.", "focus", "password");

        return false;
 
    } else if (!document.getElementById("repassword").value) {

        cmAlert("비밀번호를 재입력하세요.", "focus", "repassword");

        return false;

    } else if (document.getElementById("password").value !== document.getElementById("repassword").value) {

        cmAlert("비밀번호가 다릅니다.", "focus", "repassword");

        return false;

    } else if (!document.getElementById("joinAddress1").value) {

        cmAlert("주소를 검색하세요.", "focus", "joinAddress1");

        return false;

    } else if (!document.getElementById("address2").value) {

        cmAlert("상세주소를 입력하세요.", "focus", "address2");

        return false;

    } else {

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: false,
            url: "/front/controller/memberController",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){
    
                // console.log(data);

                if (data[0] == "existId") {

                    cmAlert("이미 사용중이거나 탈퇴한 아이디입니다.");

                    return false;

                } else if (data[0] == "existCellphone") {

                    cmAlert("이미 사용중이거나 탈퇴한 핸드폰번호입니다.");

                    return false;

                } else if (data[0] == "success") {

                    window.location.href = "/";

                }
    
            },
            error:function(request,status,error){
    
                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

}

/* 회원정보 수정 입력 체크 */

function infoModifyFieldCheck(){

    let form = $("#userInfoChangeForm");

    let passwordCheckNum = document.userInfoChangeForm.password.value.search(/[0-9]/g);
    let passwordCheckEng = document.userInfoChangeForm.password.value.search(/[a-zA-Z]/g);
    let passwordCheckExp = document.userInfoChangeForm.password.value.search(/[\{\}\[\]\/?.,;:|\)*~`!^\-_+<>@\#$%&\\\=\(\'\"]/g);

    if (!document.getElementById("originPassword").value) {

        cmAlert("기존 비밀번호를 입력하세요.", "", "originPassword");

        return false;

    } else if (document.getElementById("password").value && (passwordCheckNum < 0 || passwordCheckEng < 0 || passwordCheckExp < 0)) {

        cmAlert("비밀번호는 영문,숫자,특수문자 조합이어야 합니다.", "", "originPassword");

        return false;
 
    } else if (document.getElementById("password").value && document.getElementById("originPassword").value == document.getElementById("password").value) {

        cmAlert("기존 비밀번호와 변경할 비밀번호가 같습니다.", "", "password");

        return false;
 
    } else if (document.getElementById("password").value && !document.getElementById("repassword").value) {

        cmAlert("수정하실 비밀번호를 재입력하세요.", "", "repassword");

        return false;
 
    } else {

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: false,
            url: "/front/controller/mypageController",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){
    
                console.log(data);

                if (data[0] == "noMatch") {

                    cmAlert("기존 비밀번호가 다릅니다.");

                    return false;

                } else if (data[0] == "notSame") {

                    cmAlert("수정하실 비밀번호가 다릅니다.");

                    return false;

                } else if (data[0] == "success") {

                    gnbLoad('orderList');

                    location.href = "/mypage";

                }
    
            },
            error:function(request,status,error){
    
                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

}

/* gnb 클릭시 로드될 쿠키 저장 시작 */

function gnbLoad (loadName) {

    setCookie("load", loadName);

}

/* gnb 클릭시 로드될 쿠키 저장 끝 */

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

/* 검색 시작 */

function checkSearch () {

    document.getElementById("searchForm").submit();

}

/* 검색 끝 */

/* 로그인 체크 시작 */

function loginFieldCheck () {
    
    if (!$("#userId").val()) {

        cmAlert("이메일을 입력하세요.", "", "userPassword");

        return false;

    }

    if (!$("#userPassword").val()) {

        cmAlert("비밀번호를 입력하세요.", "", "userPassword");

        return false;

    }

    let autoLogin = "N";

    if ($("#autoLogin").is(":checked") == true) {

        autoLogin = "Y";

    }

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/memberController",
        data:{
            "page": "memberLogin",
            "act": "login",
            "id": $("#userId").val(),
            "password": $("#userPassword").val(),
            "autoLogin": autoLogin
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            if (data[0] == "success") {

                if (getCookie("returnUrl")) {

                    let returnUrl = getCookie("returnUrl");

                    deleteCookie("returnUrl");

                    location.href = returnUrl;

                } else {

                    location.href = "/";

                }

            } else if (data[0] == "block") {

                cmAlert("비밀번호 5회 오류로 인하여 계정이 잠겼습니다.\r\n고객센터로 문의해주세요.");

            } else {

                cmAlert("이메일 또는 비밀번호를 확인해 주세요.", "", "userPassword");

            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
    });

}

/* 로그인 체크 끝 */

/* 로그아웃 시작 */

function logout () {

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/memberController",
        global: false,
        data:{
            "page": "memberLogin",
            "act": "logout"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            if(data[0] == "success"){

                location.href = "/";

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

/* 쿠폰 주의사항 js 시작 */

function turnCoupon(object){

    if($(object).attr("class").indexOf("frontTurn") > 0){

        $(object).addClass("backTurn");
        $(object).removeClass("frontTurn");

    }else{

        $(object).addClass("frontTurn");
        $(object).removeClass("backTurn");

    }

}

/* 쿠폰 주의사항 js 끝 */

/* 메인 후기 팝업 시작 */

function mainReviewPop(count){

    $(".review_popup").hide();

    $(".mainReview_popup" + count).fadeIn();

    $(".mainReview_popup" + count).find(".reviewPopup_descText").fadeIn();

}

function reviewPopClose(){

    $(".review_popup").fadeOut();

}

function reviewDescClose(object){

    $(object).parents(".reviewPopup_descText").fadeOut();

}

/* 메인 후기 팝업 끝 */

/* 후기 팝업 시작 */

function reviewPop(object){

    $(object).parents(".board_postList").next("#reviewPopup").fadeIn();

}

function reviewPopClose(){

    $(".review_popup").fadeOut();

}

/* 후기 팝업 끝 */

/* 자동 리스트 오픈 시작 */

function boardListShow(nowPage, searchCate, searchWord, nowShow){

    var nowScroll = $(window).scrollTop();

    var loading = $("#loading").val(); // 함수가 진행중인지 아닌지 체크 (0: 미진행, 1: 진행중)

    var boardCount = $("#totalBoardCount").val(); // 게시물 총 개수

    var listBottom = $(".boardOpen").offset().top; // 게시물 추가 시점 게시물 개수

    var limitStart = $("#limitStart").val(); // limit 시작
    
    var limitEnd = $("#limitEnd").val(); // 게시물 출력 수

    if((parseInt(nowScroll) > parseInt(listBottom) && parseInt(boardCount) > parseInt(limitStart) || nowShow == "Y") && loading == 0){

        $("#loading").val(1); // 진행중

        $(".board_postList").removeClass("boardOpen");

        var listLodingDiv = document.createElement("div");
        listLodingDiv.setAttribute("id","postLoading");

        var listLodingP = document.createElement("p");
        listLodingDiv.setAttribute("class","loadingAni");

        listLodingDiv.appendChild(listLodingP);
        document.getElementById("boardPostListBox").appendChild(listLodingDiv);

        $(".loadingAni").html("<lottie-player src='" + frontImgSrc + "/postLoading.json' style='width: 100%; height: 100%;' background='transparent'  speed='1' loop autoplay></lottie-player>");

        $("#limitStart").val(parseInt(limitStart) + parseInt(limitEnd));

        viewList();

        $("#postLoading").remove();

        $("#loading").val(0); // 완료

    }

}

/* 자동 리스트 오픈 끝 */

/* 공유하기 시작 */

function shareOpen(){

    $(".share_popBox").fadeIn();

}

function linkCopy(){ // 링크복사

    var textarea = document.createElement("textarea");
    var url = window.document.location.href;

    document.body.appendChild(textarea);
    textarea.value = url;
    textarea.select();
    document.execCommand("copy");
    document.body.removeChild(textarea);

    $(".share_popBox").fadeOut();
    
    cmAlert("주소가 복사되었습니다.");

}

function kakaoShare(){ // 카톡 공유하기  확인하기

    if (!Kakao.isInitialized()) {

        Kakao.init('efc1001e80f14bde76b510db0a368a48');

    }

    var url = window.location;

    var urlProtocol = url.protocol;

    var baseUrl = url.host;

    var imgUrl = urlProtocol + "//" + baseUrl + $(".product_thumb img").attr("src");
    
    Kakao.Link.sendDefault({
        objectType: 'feed',
        content: {
            title: $(".product_tit").text(),
            description: '강아지를 위해 건강한 간식을 만드는 멍반생',
            imageUrl: imgUrl,
            imageWidth: 1200,
            imageHeight: 630,
            link: {
            mobileWebUrl: window.document.location.href,
            androidExecutionParams: '',
            },
        },
        buttons: [
            {
            title: '상품보러가기',
            link: {
                mobileWebUrl: window.document.location.href,
                webUrl: window.document.location.href,
            },
            },
        ],
    });

    $(".share_popBox").fadeOut();

}

function shareClose(){

    $(".share_popBox").fadeOut();

}

/* 공유하기 끝 */

/* 옵션 추가 시작 */
function optionProductAdd(object){
    
    var option = "";
    var optionListCheck = 0;
    var optionListNum = $(".option_list").length;
    var optionTit = $(object).find(".optionList_tit").text().trim();
    var optionPrice = $(object).find(".option_backprice").val();
    var optionIdx = $(object).find(".option_idx").val();
    var stock = $(object).find(".stock").val();

    if(optionPrice == 0){

        optionPrice = parseInt($(".product_discountPrice").text().replace(/[^0-9]/g,""));

    }
    
    /* 옵션 추가 */
    
    for(i=0; i<optionListNum; i++){
        
        var optionCheckOptionIdx = $(".option_list").eq(i).find(".optionIdx").val();
        
		if(optionIdx == optionCheckOptionIdx){
            
			++optionListCheck;
            
		}
        
	}

	if(optionListCheck > 0){
        
        cmAlert("이미 선택하신 옵션입니다.");

	}else{
        
        option = "<div class='option_list'><div class='option_infobox'><div class='option_titbox'><p class='option_tit'>" + optionTit + "</p><p class='option_del' onclick='optionProductDel(this);'><img src='" + frontImgSrc + "/option_del.png'></p></div><div class='option_pricecount'><p class='option_qty'><input type='button' class='qty_pm qty_minus' name='qtyMinus' onclick='optionQtyMinus(this)'><input type='text' class='qty' onchange='optionQtyMultiply(this)' value='1'><input type='button' class='qty_pm qty_plus' name='qtyPlus' onclick='optionQtyPlus(this)'></p><p class='option_pricebox'><span class='option_price'>" + comma(optionPrice) + "</span>원</p><input type='hidden' name='option_backprice' class='option_backprice' value='" + optionPrice + "'></div><div class='cart_info'><input type='hidden' name='qty' class='qty' value='1'><input type='hidden' name='stock' class='stock' value='" + stock + "'><input type='hidden' name='optionIdx' class='optionIdx' value='" + optionIdx + "'></div></div></div>";
    
    
	   $('.option_listbox').append(option);
        
    
        /* 총 금액 */
        var originOptionPrice = parseInt($(object).find('.option_backprice').val());

        if(originOptionPrice == ""){

            originOptionPrice = parseInt($(".product_discountPrice").text().replace(/[^0-9]/g,""));

        }
        
        var totalPriceComma = $('.total_price').val().replace(/,/g, "");
        var totalPrice = originOptionPrice + parseInt(totalPriceComma);

        $('.total_price').val(comma(totalPrice));
        
    }
    
    /* //옵션 추가 */
    
}

/* 옵션 추가 끝 */

/* 옵션 수량 시작 */

function optionQtyPlus(object, act){

    // 옵션 수량
    let qty = $(object).siblings('.qty').val();

    // 재고 수량
    let stock = $(object).parents(".option_infobox").find('.stock').val();

    if(parseInt(qty) >= parseInt(stock) && parseInt(stock) !== -1){ // 수량이 재고 초과

        cmAlert("구매 수량이 재고보다 많습니다.");

        return false;

    }
    
    let plusQty = parseInt(qty) + 1;
        
    $(object).siblings('.qty').val(plusQty);

    // 옵션 가격 (기본가격 * 수량)
    
    let originQtyPrice = $(object).parents('.option_infobox').find('.option_backprice').val();
    
    let plusQtyPrice = parseInt(originQtyPrice) * plusQty;
        
    $(object).parents('.option_infobox').find('.option_price').text(comma(plusQtyPrice));

    if(act == "cart"){ // 장바구니

        // 상품금액
        let optionTotalCommaPrice = $(".cart_productPrice").text();
            
        let optionTotalPrice = optionTotalCommaPrice.replace(/,/g, "");

        let cartProductPrice = parseInt(optionTotalPrice) + parseInt(originQtyPrice);

        $(".cart_productPrice").text(comma(cartProductPrice));

        // 배송비
        if (cartProductPrice >= parseInt($(".deliveryMinPrice").val())) {

            $(".cart_deleveryPrice").text("0");

            var deliveryPrice = 0;

        } else {

            $(".cart_deleveryPrice").text(comma($(".deliveryPrice").val()));

            var deliveryPrice = $(".deliveryPrice").val();

        }
        
        // 총 결제금액
        var cartTotalPrice = cartProductPrice + parseInt(deliveryPrice);

        $(".total_price").val(comma(cartTotalPrice));

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/front/controller/orderController",
            global: false,
            data:{
                "page": "cart",
                "act": "modify",
                "qty": $(object).siblings('.qty').val(),
                "cartIdx": $(object).parents(".option_titbox").siblings(".cart_hiddenBox").find(".cartNum").val()
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);
    
            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }else{ // 상품상세

        // 총 금액    
        var optionListNum = $('.option_list').length;
        var eachPrice = 0;
        
        for(i=0; i<optionListNum; i++){
            
            var optionPriceCommaText = $('.option_list').eq(i).find('.option_price').text();
            
            var optionPriceText = optionPriceCommaText.replace(/,/g, "");

            var checkOptionPriceText = optionPriceText.replace(/[^0-9]/g,"");

            if(checkOptionPriceText == ""){

                var IntOptionPriceText = 0;

            }else{

                var IntOptionPriceText = parseInt(optionPriceText);

            }

            eachPrice += IntOptionPriceText;
            
            $('.total_price').val(comma(eachPrice));
            
        }

    }
    
}

function optionQtyMinus(object, act){

    // 옵션 수량    
    var qty = $(object).siblings('.qty').val();
    
    if(parseInt(qty) == 1){
        
        cmAlert("최소 구매 수량은 1개 입니다.");
        
        return false;
        
    }
    
    var minusQty = parseInt(qty) - 1;
    
    $(object).siblings('.qty').val(minusQty);

    // 옵션 가격 (기본가격 * 수량)
    
    var originQtyPrice = $(object).parents('.option_infobox').find('.option_backprice').val();
    
    var minusQtyPrice = parseInt(originQtyPrice) * minusQty;
        
    $(object).parents('.option_infobox').find('.option_price').text(comma(minusQtyPrice));

    if(act == "cart"){

        // 상품금액
        let optionTotalCommaPrice = $(".cart_productPrice").text();
            
        let optionTotalPrice = optionTotalCommaPrice.replace(/,/g, "");

        let cartProductPrice = parseInt(optionTotalPrice) - parseInt(originQtyPrice);

        $(".cart_productPrice").text(comma(cartProductPrice));

        // 배송비
        if (cartProductPrice >= parseInt($(".deliveryMinPrice").val())) {

            $(".cart_deleveryPrice").text("0");

            var deliveryPrice = 0;

        } else {

            $(".cart_deleveryPrice").text(comma($(".deliveryPrice").val()));

            var deliveryPrice = $(".deliveryPrice").val();

        }
        
        // 총 결제금액
        var cartTotalPrice = cartProductPrice + parseInt(deliveryPrice);

        $(".total_price").val(comma(cartTotalPrice));

        $.ajax({
            type: "POST", 
            dataType: "html",
            async: true,
            url: "/front/controller/orderController",
            global: false,
            data:{
                "page": "cart",
                "act": "modify",
                "qty": $(object).siblings('.qty').val(),
                "cartIdx": $(object).parents(".option_titbox").siblings(".cart_hiddenBox").find(".cartNum").val()
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);
    
            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }else{

        // 총 금액    
        var optionListNum = $('.option_list').length;
        var eachPrice = 0;
        
        for(i=0; i<optionListNum; i++){
            
            var optionPriceCommaText = $('.option_list').eq(i).find('.option_price').text();
            
            var optionPriceText = optionPriceCommaText.replace(/,/g, "");

            var checkOptionPriceText = optionPriceText.replace(/[^0-9]/g,"");

            if(checkOptionPriceText == ""){

                var IntOptionPriceText = 0;

            }else{

                var IntOptionPriceText = parseInt(optionPriceText);

            }

            eachPrice += IntOptionPriceText;
            
            $('.total_price').val(comma(eachPrice));
            
        }

    }
    
}

function optionQtyMultiply(object, act){

    // 옵션 수량
    var qty = $(object).val();

    // 재고 수량
    var stock = $(object).parents(".option_infobox").find('.stock').val();
    
    var originQtycommaPrice = $(object).parents('.option_infobox').find('.option_backprice').val();
        
    var originQtyPrice = originQtycommaPrice.replace(/,/g, "");
    
    if(parseInt(qty) < 1 || qty == ""){
        
        cmAlert("최소 구매 수량은 1개 입니다.");
        
        $(object).val(1);

        qty = 1;
        
    }else if(parseInt(qty) > parseInt(stock) && parseInt(stock) !== -1){

        cmAlert("구매 수량이 재고보다 많습니다.");

        $(object).val(stock);

        qty = stock;

    }

    // 옵션 가격 (기본가격 * 수량)    
    var MultiplyQtyPrice = parseInt(originQtyPrice) * parseInt(qty);
    
    $(object).parents('.option_infobox').find('.option_price').text(comma(MultiplyQtyPrice));

    // 총 금액    
    var optionListNum = $('.option_list').length;
    var eachPrice = 0;
    
    for(i=0; i<optionListNum; i++){
        
        var optionPriceCommaText = $('.option_list').eq(i).find('.option_price').text();
        
        var optionPriceText = optionPriceCommaText.replace(/,/g, "");

        var checkOptionPriceText = optionPriceText.replace(/[^0-9]/g,"");

        if(checkOptionPriceText == ""){

            var IntOptionPriceText = 0;

        }else{

            var IntOptionPriceText = parseInt(optionPriceText);

        }

        eachPrice += IntOptionPriceText;
        
    }

    if(act == "cart"){ // 장바구니
            
        $('.cart_productPrice').text(comma(eachPrice));

        // 배송비
        if (eachPrice >= parseInt($(".deliveryMinPrice").val())) {

            $(".cart_deleveryPrice").text("0");

            var deliveryPrice = 0;

        } else {

            $(".cart_deleveryPrice").text(comma($(".deliveryPrice").val()));

            var deliveryPrice = $(".deliveryPrice").val();

        }

        let totalPrice = parseInt(eachPrice) + parseInt(deliveryPrice);
        
        $('.total_price').val(comma(totalPrice));

        $.ajax({
            type: "POST", 
            dataType: "html",
            async: true,
            url: "/front/controller/orderController",
            global: false,
            data:{
                "page": "cart",
                "act": "modify",
                "qty": qty,
                "cartIdx": $(object).parents(".option_titbox").siblings(".cart_hiddenBox").find(".cartNum").val()
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);
    
            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }else{ // 상품상세

        // 총 금액    
        var optionListNum = $('.option_list').length;
        var eachPrice = 0;
        
        for(i=0; i<optionListNum; i++){
            
            var optionPriceCommaText = $('.option_list').eq(i).find('.option_price').text();
            
            var optionPriceText = optionPriceCommaText.replace(/,/g, "");

            var checkOptionPriceText = optionPriceText.replace(/[^0-9]/g,"");

            if(checkOptionPriceText == ""){

                var IntOptionPriceText = 0;

            }else{

                var IntOptionPriceText = parseInt(optionPriceText);

            }

            eachPrice += IntOptionPriceText;
            
            $('.total_price').val(comma(eachPrice));
            
        }

    }
    
}

// 옵션 수량

// 옵션 삭제

function optionProductDel(object, act){
    
    // 총 금액

    var eachPrice = 0;

    if(act == "cart"){ // 장바구니에서 옵션 제거

        // 상품금액
        var optionTotalCommaPrice = $(".cart_productPrice").text();
            
        var optionTotalPrice = optionTotalCommaPrice.replace(/,/g, "");
    
        var cartOptionStandardPrice = $(object).parents('.option_infobox').find('.option_backprice').val();
        
        var cartOptionQty = $(object).parents('.option_infobox').find('.qty').val();

        var cartRemovePrice = parseInt(cartOptionStandardPrice) * parseInt(cartOptionQty);

        var cartLastProductPrice = parseInt(optionTotalPrice) - parseInt(cartRemovePrice);

        $(".cart_productPrice").text(comma(cartLastProductPrice));

        // 배송비
        if (cartLastProductPrice >= parseInt($(".deliveryMinPrice").val())) {

            $(".cart_deleveryPrice").text("0");

            var deliveryPrice = 0;

        } else {

            $(".cart_deleveryPrice").text(comma($(".deliveryPrice").val()));

            var deliveryPrice = $(".deliveryPrice").val();

        }
        
        // 총 결제금액
        var cartTotalPrice = cartLastProductPrice + parseInt(deliveryPrice);

        $(".total_price").val(comma(cartTotalPrice));

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/front/controller/orderController",
            global: false,
            data:{
                "page": "cart",
                "act": "del",
                "cartIdx": $(object).parents(".option_titbox").siblings(".cart_hiddenBox").find(".cartNum").val()
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                $(".hearder_cart_count").text(data[1].length);

                $(".hearderActive_cart_count").text(data[1].length);
    
            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

        // pc, m 같이 삭제
        var delClass = $(object).parents('.cartGallary_list').data("val");
        $(".cartDelList" + delClass).remove();

        /* 장바구니 개수 */

        var cartListCount = $('.cartGallary_list').length / 2;

        $(".board_strong").text(cartListCount);

        /* 장바구니에 상품이 없을때 */

        if(cartListCount == 0){

            $(".cart_titBox .board_strong").text(0);

            $(".cartGallary_listBox").remove();

            $(".sub_container").html("<div class='flex-vc-hc-container'><div class='emptyCart_box'><lottie-player src='" + frontImgSrc + "/emptyCart.json' background='transparent' style='width: 100%; height: 100%;' speed='1' loop autoplay></lottie-player><p class='emptyCart_tit'>장바구니에 담긴 상품이 없습니다.</p></div></div>");

        }

    }else{ // 상품 뷰페이지에서 옵션 제거
    
        $(object).parents('.option_list').remove();

        var optionListNum = $('.option_list').length;

        if(optionListNum > 0){

            for(i=0; i<optionListNum; i++){
            
                var optionPriceCommaText = $('.option_list').eq(i).find('.option_price').text();
                
                var optionPriceText = optionPriceCommaText.replace(/,/g, "");

                var checkOptionPriceText = optionPriceText.replace(/[^0-9]/g,"");
    
                if(checkOptionPriceText == ""){
    
                    var IntOptionPriceText = 0;
    
                }else{
    
                    var IntOptionPriceText = parseInt(optionPriceText);
    
                }
    
                eachPrice += IntOptionPriceText;
                
                $('.total_price').val(comma(eachPrice));
                
            }

        }else{

            $('.total_price').val(0);

            $(".selectbox_text").text("상품옵션선택");

        }

    }
    
}

/* //옵션 삭제 */

/* 상품 체크박스 금액 변경 시작 */

function cartCheckbox(object){

    var optionListCount = $(".option_list").length;

    var cartItemCheckbox = document.getElementsByName("cartItem");

    var checkedCount = 0;

    for(oc = 0; oc < optionListCount; oc++){
            
        if(!cartItemCheckbox[oc].checked){

            checkedCount++;

        }

    }

    if(optionListCount == checkedCount){

        cmAlert("최소 구매 수량은 1개 입니다.");

        $(object).prop("checked", true);

        return false;

    }

    /* 상품금액 */

    var productPrice = $(".cart_productPrice").text().replace(/[^0-9]/g,"");

    var optionBackprice = $(object).parents(".option_infobox").find(".option_backprice").val();

    var qty = $(object).parents(".option_infobox").find(".qty").val();

    var total_optionBackprice = optionBackprice * qty;

    if($(object).is(":checked") == true){

        /* 상품금액 계산 */

        var change_productPrice = parseInt(productPrice) + parseInt(total_optionBackprice);

    }else{

        /* 상품금액 계산 */

        var change_productPrice = parseInt(productPrice) - parseInt(total_optionBackprice);

    }

    /* 최종 상품금액 */

    $(".cart_productPrice").text(comma(change_productPrice));

    // 배송비
    if (change_productPrice >= parseInt($(".deliveryMinPrice").val())) {

        $(".cart_deleveryPrice").text("0");

        var deliveryPrice = 0;

    } else {

        $(".cart_deleveryPrice").text(comma($(".deliveryPrice").val()));

        var deliveryPrice = $(".deliveryPrice").val();

    }

    /* 최종 총 결제금액 */
    var change_totalPrice = change_productPrice + parseInt(deliveryPrice);

    $(".total_price").val(comma(change_totalPrice));

}

/* 상품 체크박스 금액 변경 끝 */

/* 장바구니, 주문서 이동 시작 */

function cartOrder(object, act){  

    deleteCookie("orderType");

    if (act == "orderSheet") { // 장바구니에서 주문

        insertLog("", "cart", "orderSheet", "success", "click");

        var optionListCount = $(".option_list").length;

        var cartItemCheckbox = document.getElementsByName("cartItem");

        var cartIdxData = "";
        var cartIdxIndex = 0;

        for (oc=0; oc < optionListCount; oc++) {
            
            if (cartItemCheckbox[oc].checked == true) {

                var cartIdx = $(".option_list").eq(oc).find(".cartNum").val();

                cartIdxData += cartIdxIndex == 0 ? cartIdx : "◈" + cartIdx;

                cartIdxIndex++;

            }

        }

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/front/controller/orderController",
            data:{
                "act": "cartOrder",
                "page": "cart",
                "cartIdx": cartIdxData
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                if (data == "success") {

                    setCookie("orderType", "cart");

                    location.reload();

                }
    
            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    } else { // 상품상세에서 장바구니 / 주문

        if (act == "cart") {

            var type = "cart";

        } else {

            var type = "tempCart";

        }

        var optionListCount = $(".option_list").length;

        var isOptionCount = $(".optionOne_list").length;

        if (optionListCount > 0) {
            
            if (isOptionCount == 0) { // 옵션이 있을때

                var optionIdxData = "";
                var qtyData = "";
                var stockData = "";
                var optionTitleData = "";
            
                for(plc = 0; plc < optionListCount; plc++){

                    let optionIdx = $(".option_list").eq(plc).find(".optionIdx").val();
                    let qty = $(".option_list").eq(plc).find(".qty").val();
                    let stock = $(".option_list").eq(plc).find(".stock").val();
                    let optionTitle = $(".option_list").eq(plc).find(".option_tit").text();

                    optionIdxData += plc == 0 ? optionIdx : "◈" + optionIdx;
                    qtyData += plc == 0 ? qty : "◈" + qty;
                    stockData += plc == 0 ? stock : "◈" + stock;
                    optionTitleData += plc == 0 ? optionTitle : "◈" + optionTitle;

                }
            
            } else {

                var optionIdxData = "";
                var optionTitleData = "";
                var qtyData = $(".option_list").find(".qty").val();
                var stockData = $(".option_list").find(".stock").val();

            }
        
            $.ajax({
                type: "POST", 
                dataType: "json",
                async: true,
                url: "/front/controller/orderController",
                global: false,
                data:{
                    "act": "insert",
                    "page": "cart",
                    "type": type,
                    "userIp": $(".connect_ip").val(),
                    "userId": $(".login_id").val(),
                    "productCode": $(".productCode").val(),
                    "optionIdx": optionIdxData,
                    "qty": qtyData,
                    "stock": stockData,
                    "optionTit": optionTitleData
                },
                traditional: true,
                beforeSend:function(xhr){
                },
                success:function(data){

                    // console.log(data);

                    if (act == "cart") {

                        $(".hearder_cart_count").text(data[1]);

                        $(".hearderActive_cart_count").text(data[1]);
        
                        cmConfirmAlert("장바구니에 상품을 담았습니다.", "장바구니 가기", "쇼핑 계속하기", "cart", "/order");

                    } else {

                        gnbLoad('orderSheet');

                        setCookie("orderType", "tempCart");

                        window.location.href = "/order";

                    }
        
                },
                error:function(request,status,error){

                    console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                    
                }
                
            });

        } else {

            cmAlert("옵션을 선택하세요.");

        }

    }

}

/* 장바구니, 주문서 이동 끝 */

/* 총 결제금액 계산 시작 */

function orderCalculate(){

    var order_productTotalPrice = $(".order_productTotalPrice").text().replace(/[^0-9]/g,"");
    var order_dlvPrice = $(".order_dlvPrice").text().replace(/[^0-9]/g,"");
    var order_couponPrice = $(".order_couponPrice").text().replace(/[^0-9]/g,"");
    var order_pointPrice = $(".order_pointPrice").text().replace(/[^0-9]/g,"");

    /* 총 결제금액 시작 */

    var order_totalPrice = parseInt(order_productTotalPrice) + parseInt(order_dlvPrice) - parseInt(order_couponPrice) - parseInt(order_pointPrice);

    /* 총 결제금액 끝 */

    /* 적립 예정포인트 시작 */

    var order_pointPrice = $(".order_pointPrice").text().replace(/[^0-9]/g,"");

    var order_totalPoint = Math.round((parseInt(order_productTotalPrice) - parseInt(order_couponPrice) - parseInt(order_pointPrice)) / 100);
    
    $(".total_point").text(comma(Math.floor(order_totalPoint)) + "P");
    
    /* 적립 예정포인트 끝 */

    $(".total_price").text(comma(order_totalPrice));
    $(".order_btn_price").text(comma(order_totalPrice));

}

/* 총 결제금액 계산 끝 */

/* 배송지 변경 시작 */

function dlvChange(object, act){

    if(act == "listOpen"){

        $(".dlv_addressBox").fadeIn();

    }else if(act == "listClose"){

        $(".dlv_addressBox").fadeOut();

    }else if(act == "listClick"){

        $(".dlv_addressList").removeClass("dlv_active");

        $(object).addClass("dlv_active");

    }else if(act == "listOk"){

        var dlvName = $(".dlv_active .dlv_addressListName .dlv_popListName").text();
        var dlvCell = $(".dlv_active .dlv_addressListCell").text();
        var dlvAdd1 = $(".dlv_active .dlv_addressListadd1").val();
        var dlvAdd2 = $(".dlv_active .dlv_addressListadd2").val();

        $(".dlv_name").val(dlvName);

        $(".dlv_cell").val(dlvCell);

        $(".dlv_address1").val(dlvAdd1);

        $(".dlv_address2").val(dlvAdd2);

        $(".dlv_addressBox").fadeOut();

    }else if(act == "writeOpen"){

        if ($(".dlv_addressList").length > 2) {

            cmAlert("배송지는 최대 3개까지 저장 가능합니다.");

            return false;

        }

        $(".dlv_listBox").hide();
        $(".dlv_writeBox").show();

    }else if(act == "writeOk"){

        if($("#regiDefaltDlv").prop("checked") == true){

            var defaltDlvVal = "Y";

        }else{

            var defaltDlvVal = "N";

        }

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/front/controller/orderController",
            global: false,
            data:{
                "page": "order",
                "act": "orderDlvInsert",
                "dlvPopName": $(".dlv_popName").val(),
                "popPostcode": $("#popPostcode").val(),
                "dlvPopAddress1": $(".dlv_popAddress1").val(),
                "dlvPopAddress2": $(".dlv_popAddress2").val(),
                "dlvPopCellphone": $(".dlv_popCellphone").val(),
                "defaltDlv": defaltDlvVal
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                if (data[0] == "full") {

                    cmAlert("배송지는 최대 3개까지 저장 가능합니다.");

                    return false;

                }

                $(".dlv_listBox .dlv_addressListCon").html("");

                let orderDlvList = "";

                for (odc=0; odc < data[1].length; odc++) {

                    let defaltDlv = data[1][odc]['defaltDlv'] == "Y" ? "dlv_active" : "";
                    let defaltDlvText = data[1][odc]['defaltDlv'] == "Y" ? " (기본배송지)" : "";
                    let cellPhone = data[1][odc]['cellPhone'].split("◈");
                    let dlvAddress = data[1][odc]['address'].split("◈");
                    
                    orderDlvList += "<div class='dlv_addressList " + defaltDlv + "' onclick=\"dlvChange(this, 'listClick')\"><input type='hidden' class='dlv_idx' value='" + data[1][odc]['idx'] + "'><input type='hidden' class='dlv_defalt' value='" + data[1][odc]['defaltDlv'] + "'><ul class='dlv_addressListDesc'><li class='dlv_addressListName'><span class='dlv_popListName'>" + data[1][odc]['name'] + "</span><span>" + defaltDlvText + "</span></li><li class='dlv_addressListCell'>" + cellPhone[0] + cellPhone[1] + cellPhone[2] + "</li><li>" + dlvAddress[0] + " " + dlvAddress[1] + "<input type='hidden' class='dlv_addressListadd1' value='" + dlvAddress[0] + "'><input type='hidden' class='dlv_addressListadd2' value='" + dlvAddress[1] + "'><input type='hidden' class='dlv_addressPostcode' value='" + data[1][odc]['postcode'] + "'></li></ul><ul class='dlv_addressListBtn flex-vc-hc-container'><li class='flex-vc-hc-container' onclick=\"dlvChange(this, 'modifyOpen')\">수정</li><li class='flex-vc-hc-container' onclick=\"dlvChange(this, 'del')\">삭제</li></ul></div>";

                }

                $(".dlv_listBox .dlv_addressListCon").append(orderDlvList);
    
                $(".dlv_listBox").show();
                $(".dlv_writeBox").hide();

                // 배송지 추가 입력폼 초기화
                $(".dlv_popName").val("");
                $(".dlv_popAddress1").val("");
                $(".dlv_popAddress2").val("");
                $(".dlv_popCellphone").val("");
                $("#regiDefaltDlv").prop("checked", false);
    
            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }else if(act == "writeClose"){

        $(".dlv_listBox").show();
        $(".dlv_writeBox").hide();

    }else if(act == "modifyOpen"){

        var dlv_nameData = $(object).parents(".dlv_addressList").find(".dlv_addressListName .dlv_popListName").text();

        var dlv_name = dlv_nameData.replace(/ /g,"");

        if (dlv_nameData.indexOf("(") > -1) {

            dlv_name = dlv_nameData.substring(dlv_nameData.indexOf("(") - 1, -1);

        }

        $(".dlv_popModiName").val(dlv_name);

        var dlv_cellData = $(object).parents(".dlv_addressList").find(".dlv_addressListCell").text();

        var dlv_cell = dlv_cellData.replace(/ /g,"");

        $(".dlv_popModiCellphone").val(dlv_cell);

        var dlv_address1 = $(object).parents(".dlv_addressList").find(".dlv_addressListadd1").val();
        var dlv_address2 = $(object).parents(".dlv_addressList").find(".dlv_addressListadd2").val();
        var dlv_postcode = $(object).parents(".dlv_addressList").find(".dlv_addressPostcode").val();

        $(".dlv_popModiAddress1").val(dlv_address1);
        $(".dlv_popModiAddress2").val(dlv_address2);
        $(".dlv_popModiPostcode").val(dlv_postcode);
        
        var dlv_idx = $(object).parents(".dlv_addressList").find(".dlv_idx").val();

        $(".dlv_modiIdx").val(dlv_idx);
        
        var dlv_defalt = $(object).parents(".dlv_addressList").find(".dlv_defalt").val();

        $(".dlv_modiDefalt").val(dlv_defalt);

        if($(".dlv_modiDefalt").val() == "Y"){

            $("#modifyDefaltDlv").prop("checked", true);

        }else{

            $("#modifyDefaltDlv").prop("checked", false);

        }

        $(".dlv_listBox").hide();
        $(".dlv_modifyBox").show();

    }else if(act == "modifyClose"){

        $(".dlv_listBox").show();
        $(".dlv_modifyBox").hide();

    }else if(act == "modifyOk"){

        if($("#modifyDefaltDlv").prop("checked") == true){

            var defaltDlvVal = "Y";

        }else{

            var defaltDlvVal = "N";

        }

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/front/controller/orderController",
            global: false,
            data:{
                "page": "order",
                "act": "orderDlvUpdate",
                "idx": $(".dlv_modiIdx").val(),
                "dlvPopName": $(".dlv_popModiName").val(),
                "popPostcode": $("#popModiPostcode").val(),
                "dlvPopAddress1": $(".dlv_popModiAddress1").val(),
                "dlvPopAddress2": $(".dlv_popModiAddress2").val(),
                "dlvPopCellphone": $(".dlv_popModiCellphone").val(),
                "defaltDlv": defaltDlvVal
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                if (data[0] == "none") {

                    cmAlert("기본 배송지는 필수 입니다.");

                    return false;

                }

                $(".dlv_listBox .dlv_addressListCon").html("");

                let orderDlvList = "";

                for (odc=0; odc < data[1].length; odc++) {

                    let defaltDlv = data[1][odc]['defaltDlv'] == "Y" ? "dlv_active" : "";
                    let defaltDlvText = data[1][odc]['defaltDlv'] == "Y" ? " (기본배송지)" : "";
                    let cellPhone = data[1][odc]['cellPhone'].split("◈");
                    let dlvAddress = data[1][odc]['address'].split("◈");
                    
                    orderDlvList += "<div class='dlv_addressList " + defaltDlv + "' onclick=\"dlvChange(this, 'listClick')\"><input type='hidden' class='dlv_idx' value='" + data[1][odc]['idx'] + "'><input type='hidden' class='dlv_defalt' value='" + data[1][odc]['defaltDlv'] + "'><ul class='dlv_addressListDesc'><li class='dlv_addressListName'><span class='dlv_popListName'>" + data[1][odc]['name'] + "</span><span>" + defaltDlvText + "</span></li><li class='dlv_addressListCell'>" + cellPhone[0] + cellPhone[1] + cellPhone[2] + "</li><li>" + dlvAddress[0] + " " + dlvAddress[1] + "<input type='hidden' class='dlv_addressListadd1' value='" + dlvAddress[0] + "'><input type='hidden' class='dlv_addressListadd2' value='" + dlvAddress[1] + "'><input type='hidden' class='dlv_addressPostcode' value='" + data[1][odc]['postcode'] + "'></li></ul><ul class='dlv_addressListBtn flex-vc-hc-container'><li class='flex-vc-hc-container' onclick=\"dlvChange(this, 'modifyOpen')\">수정</li><li class='flex-vc-hc-container' onclick=\"dlvChange(this, 'del')\">삭제</li></ul></div>";

                }

                $(".dlv_listBox .dlv_addressListCon").append(orderDlvList);
    
                $(".dlv_listBox").show();
                $(".dlv_modifyBox").hide();

                // 배송지 추가 입력폼 초기화
                $(".dlv_popName").val("");
                $(".dlv_popAddress1").val("");
                $(".dlv_popAddress2").val("");
                $(".dlv_popCellphone").val("");
                $("#regiDefaltDlv").prop("checked", false);
    
            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }

        });

    }else if(act == "del"){

        if($(object).parents(".dlv_addressList").find(".dlv_defalt").val() == "Y"){

            cmAlert("기본배송지는 삭제할 수 없습니다.");

        }else{

            $.ajax({
                type: "POST", 
                dataType: "json",
                async: true,
                url: "/front/controller/orderController",
                global: false,
                data:{
                    "page": "order",
                    "act": "orderDlvDelete",
                    "idx": $(object).parents(".dlv_addressList").find(".dlv_idx").val()
                },
                traditional: true,
                beforeSend:function(xhr){
                },
                success:function(data){

                    // console.log(data);

                    $(".dlv_listBox .dlv_addressListCon").html("");
    
                    let orderDlvList = "";
    
                    for (odc=0; odc < data[1].length; odc++) {
    
                        let defaltDlv = data[1][odc]['defaltDlv'] == "Y" ? "dlv_active" : "";
                        let defaltDlvText = data[1][odc]['defaltDlv'] == "Y" ? " (기본배송지)" : "";
                        let cellPhone = data[1][odc]['cellPhone'].split("◈");
                        let dlvAddress = data[1][odc]['address'].split("◈");
                        
                        orderDlvList += "<div class='dlv_addressList " + defaltDlv + "' onclick=\"dlvChange(this, 'listClick')\"><input type='hidden' class='dlv_idx' value='" + data[1][odc]['idx'] + "'><input type='hidden' class='dlv_defalt' value='" + data[1][odc]['defaltDlv'] + "'><ul class='dlv_addressListDesc'><li class='dlv_addressListName'><span class='dlv_popListName'>" + data[1][odc]['name'] + "</span><span>" + defaltDlvText + "</span></li><li class='dlv_addressListCell'>" + cellPhone[0] + cellPhone[1] + cellPhone[2] + "</li><li>" + dlvAddress[0] + " " + dlvAddress[1] + "<input type='hidden' class='dlv_addressListadd1' value='" + dlvAddress[0] + "'><input type='hidden' class='dlv_addressListadd2' value='" + dlvAddress[1] + "'><input type='hidden' class='dlv_addressPostcode' value='" + data[1][odc]['postcode'] + "'></li></ul><ul class='dlv_addressListBtn flex-vc-hc-container'><li class='flex-vc-hc-container' onclick=\"dlvChange(this, 'modifyOpen')\">수정</li><li class='flex-vc-hc-container' onclick=\"dlvChange(this, 'del')\">삭제</li></ul></div>";
    
                    }
    
                    $(".dlv_listBox .dlv_addressListCon").append(orderDlvList);
    
                    // 배송지 추가 입력폼 초기화
                    $(".dlv_popName").val("");
                    $(".dlv_popAddress1").val("");
                    $(".dlv_popAddress2").val("");
                    $(".dlv_popCellphone").val("");
                    $("#regiDefaltDlv").prop("checked", false);
        
                },
                error:function(request,status,error){

                    console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                    
                }
            });

        }

    }

}

/* 배송지 변경 끝 */

/* 포인트 사용 시작 */

function usePoint(object, act){

    var maxPoint = $(".max_point").text().replace(/[^0-9]/g,"");

    var usePoint = $(object).val().replace(/[^0-9]/g,"");

    var order_productTotalPrice = $(".order_productTotalPrice").text().replace(/[^0-9]/g,"");
    var order_couponPrice = $(".order_couponPrice").text().replace(/[^0-9]/g,"");

    var checkOrder_totalPrice = parseInt(order_productTotalPrice) - parseInt(order_couponPrice);
    
    $(".order_pointPrice").val("");

    if(usePoint == ""){

        usePoint = 0;

    }

    if(act == "use"){

        if(parseInt(usePoint) > parseInt(maxPoint)){

            cmAlert("포인트가 부족합니다.");
    
            $(".use_point").val("0");
        
            $(".order_pointPrice").text("0");
    
        }else if(parseInt(usePoint) > parseInt(checkOrder_totalPrice)){

            cmAlert("총 상품금액보다 사용 적립금이 많습니다.");
    
            $(".use_point").val("0");
        
            $(".order_pointPrice").text("0");
    
        }else{
        
            $(".order_pointPrice").text(comma(usePoint));
    
        }
    
        orderCalculate();

    }else if(act == "all"){

        if(parseInt(maxPoint) > parseInt(checkOrder_totalPrice)){

            var maxPoint = $(".max_point").text().replace(/[^0-9]/g,"");
    
            $(".use_point").val(comma(checkOrder_totalPrice));
        
            $(".order_pointPrice").text(comma(checkOrder_totalPrice));
    
        }else{

            var maxPoint = $(".max_point").text().replace(/[^0-9]/g,"");
    
            $(".use_point").val(comma(maxPoint));
        
            $(".order_pointPrice").text(comma(maxPoint));

        }
        
        orderCalculate();
        
    }

}

/* 포인트 사용 끝 */

/* 쿠폰 사용 시작 */

function useCoupon(object, act){

    if (act == "listOpen") {

        $(".coupon_choiceBox").fadeIn();

    } else if (act == "listClose") {

        $(".coupon_choiceBox").fadeOut();

    } else if (act == "listOk") {

        var couponChoiceRadio = document.getElementsByName("couponChoice");
        var couponIdx =  $(".checked_couponIdx").val();
        var couponPriceChecked;
        var couponPercentChecked;
        var coupon_maxPrice;

        for (i = 0; i < couponChoiceRadio.length; i++) {
            
            if (couponChoiceRadio[i].checked) {

                couponPriceChecked = $(".coupon_choiceList").eq(i).find(".coupon_discountPrice").val();

                couponPercentChecked = $(".coupon_choiceList").eq(i).find(".coupon_discountPercent").val();

                couponCheckedName = $(".coupon_choiceList").eq(i).find(".couponChoice_name").text();

                couponCheckedIdx = $(".coupon_choiceList").eq(i).find(".coupon_idx").val();
                coupon_maxPrice =  $(".coupon_choiceList").eq(i).find(".coupon_maxPrice").val();

            }

        }

        if (couponIdx !== couponCheckedIdx) { // 쿠폰이 변경 됐을때

            $(".checked_couponIdx").val("");

            $(".order_couponPrice").text("0");

            orderCalculate();
        
            $(".coupon_name").val("");

            var order_productTotalPrice = $(".order_productTotalPrice").text().replace(/[^0-9]/g,"");
            var order_pointPrice = $(".order_pointPrice").text().replace(/[^0-9]/g,"");

            var checkOrder_totalPrice = parseInt(order_productTotalPrice) - parseInt(order_pointPrice);

            if (couponPriceChecked > 0) { // 금액

                if (parseInt(couponPriceChecked) > parseInt(checkOrder_totalPrice)) {

                    $("#couponChoice0").prop("checked", true);

                    cmAlert("상품 결제금액보다 쿠폰 할인액이 많습니다.");

                } else {

                    if (checkOrder_totalPrice > 0) {

                        $(".order_couponPrice").text(comma(couponPriceChecked));

                        var couponName = couponCheckedName.replace(/ /g,"");
                
                        $(".coupon_name").val(couponName);
            
                        $(".checked_couponIdx").val(couponCheckedIdx);

                        orderCalculate();

                    } else {

                        $("#couponChoice0").prop("checked", true);

                    }

                }

            } else if (couponPercentChecked > 0) { // 퍼센트

                var couponPercent_price = order_productTotalPrice * (couponPercentChecked / 100);

                if (parseInt(couponPercent_price) > parseInt(checkOrder_totalPrice)) {

                    $("#couponChoice0").prop("checked", true);

                    cmAlert("상품 결제금액보다 쿠폰 할인액이 많습니다.");

                } else {

                    if (checkOrder_totalPrice > 0) {

                        if (couponPercent_price > coupon_maxPrice) { // 할인금액이 최대할인금액보다 클 경우

                            couponPercent_price = coupon_maxPrice;

                        }

                        $(".order_couponPrice").text(comma(couponPercent_price));

                        var couponName = couponCheckedName.replace(/ /g,"");
                
                        $(".coupon_name").val(couponName);
            
                        $(".checked_couponIdx").val(couponCheckedIdx);

                        orderCalculate();

                    } else {

                        $("#couponChoice0").prop("checked", true);

                    }

                }

            }

        }

        $(".coupon_choiceBox").fadeOut();

    }

}

/* 쿠폰 사용 끝 */

/* 결제방법 클릭 시작 */

function paymentAddInfo(object){

    var paymentType = $(object).val();

    if(paymentType + "_addBox" !== "bankpay_addBox"){

        $(".payment_addBox").hide();

        $(".payment_addBox").find("input, select").val("");

    }

    $("." + paymentType + "_addBox").show();

}

/* 결제방법 클릭 끝 */

/* 주문서 결제 시작 */

function order(){

    var orderTnc = document.getElementById("orderTnc");
    var paymentRadio = document.getElementsByName("payment");
    var paymentChecked;

    for(var i = 0; i < paymentRadio.length; i++){
        
        if(paymentRadio[i].checked){

            paymentChecked = paymentRadio[i].value;
        }
    }
        
    if(!$(".buyer_name").val()){

        cmAlert('주문자 이름을 입력해주세요.');
        
        return false;

    }else if(!$(".buyer_cell").val()){

        cmAlert('주문자 핸드폰번호를 입력해주세요.');
        
        return false;

    }else if(!$(".buyer_email").val()){

        cmAlert('이메일을 입력해주세요.');
        
        return false;

    }else if(!$(".dlv_name").val()){

        cmAlert('받는분 이름을 입력해주세요.');
        
        return false;

    }else if(!$(".dlv_cell").val()){

        cmAlert('받는분 핸드폰번호를 입력해주세요.');
        
        return false;

    }else if(!$(".dlv_address1").val()){

        cmAlert('배송지 주소를 입력해주세요.');
        
        return false;

    }else if(!$(".dlv_address2").val()){

        cmAlert('배송지 상세주소를 입력해주세요.');
        
        return false;

    }else if(!paymentChecked){

        cmAlert('결제방법을 선택해주세요.');
        
        return false;

    }else if(!orderTnc.checked){

        cmAlert('필수사항에 동의해주세요.');
        
        return false;

    }else{

        if($(".dlv_memo").val() == "직접입력"){

            var dlv_memo = $(".dlv_memo_text").val();

        }else{

            var dlv_memo = $(".dlv_memo").val();

        }

        var dlv_price = $(".order_dlvPrice").text().replace(/[^0-9]/g,"");
        var coupon_price = $(".order_couponPrice").text().replace(/[^0-9]/g,"");
        var usePoint_price = $(".order_pointPrice").text().replace(/[^0-9]/g,"");
        var addPoint_price = $(".total_point").text().replace(/[^0-9]/g,"");
        var product_totalPrice = $(".order_productTotalPrice").text().replace(/[^0-9]/g,"");

        if($(".buyer_email_address").val() == ""){

            var buyer_email = $(".buyer_email").val()

        }else{

            var buyer_email = $(".buyer_email").val() + "@" + $(".buyer_email_address").val();

        }

        let orderType = getCookie("orderType");

        if($(".login_id").val() == ""){ // 비회원

            insertLog("", "cart", "orderSheet", "success", "click");

            $.ajax({
                type: "POST", 
                dataType: "json",
                async: true,
                url: "/front/controller/orderController",
                global: false,
                data:{
                    "page": "order",
                    "act": "orderInsert",
                    "userNo": $(".connect_ip").val(),
                    "buyerName": $(".buyer_name").val(),
                    "buyerCell": $(".buyer_cell").val(),
                    "buyerEmail": buyer_email,
                    "dlvName": $(".dlv_name").val(),
                    "dlvCell": $(".dlv_cell").val(),
                    "dlvAddress1": $(".dlv_address1").val(),
                    "dlvAddress2": $(".dlv_address2").val(),
                    "dlvPostcode": $("#dlvPostcode").val(),
                    "dlvMemo": dlv_memo,
                    "couponIdx": $(".checked_couponIdx").val(),
                    "dlvPrice": dlv_price,
                    "productTotalPrice": product_totalPrice,
                    "payment": paymentChecked,
                    "bank": $(".bank").val(),
                    "bankName": $(".bank_name").val(),
                    "cashReceipts": $(".cash_receipts").val()
                },
                traditional: true,
                beforeSend:function(xhr){
                },
                success:function(data){

                    // console.log(data);

                    if (data[0] == "differentData") {

                        cmAlert("주문정보가 다릅니다.");

                    } else if (data[0] == "noStock") {

                        cmAlert("재고가 없는 상품 또는 옵션이 포함되어 있습니다.");

                    } else if (data[0] == "error") {

                        cmAlert("주문하는 과정에서 오류가 생겼습니다. 관리자에게 문의 바랍니다.");

                    } else if (data[0] == "success") {

                        gnbLoad('orderFinish');

                        window.location.href = "/order?orderNo=" + data[1];

                    }
        
                },
                error:function(request,status,error){

                    console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                    
                }
                
            });

        }else{ // 회원

            $.ajax({
                type: "POST", 
                dataType: "json",
                async: true,
                url: "/front/controller/orderController",
                global: false,
                data:{
                    "page": "order",
                    "act": "orderInsert",
                    "type": orderType,
                    "userNo": $(".login_id").val(),
                    "buyerName": $(".buyer_name").val(),
                    "buyerCell": $(".buyer_cell").val(),
                    "buyerEmail": buyer_email,
                    "dlvName": $(".dlv_name").val(),
                    "dlvCell": $(".dlv_cell").val(),
                    "dlvAddress1": $(".dlv_address1").val(),
                    "dlvAddress2": $(".dlv_address2").val(),
                    "dlvPostcode": $("#dlvPostcode").val(),
                    "dlvMemo": dlv_memo,
                    "couponIdx": $(".checked_couponIdx").val(),
                    "couponPrice": coupon_price,
                    "usePointPrice": usePoint_price,
                    "addPointPrice": addPoint_price,
                    "dlvPrice": dlv_price,
                    "productTotalPrice": product_totalPrice,
                    "payment": paymentChecked,
                    "bank": $(".bank").val(),
                    "bankName": $(".bank_name").val(),
                    "cashReceipts": $(".cash_receipts").val(),
                    "deliveryMinPrice": $(".deliveryMinPrice").val()
                },
                traditional: true,
                beforeSend:function(xhr){
                },
                success:function(data){

                    // console.log(data);

                    if (data[0] == "differentData") {

                        cmAlert("주문정보가 다릅니다.");

                    } else if (data[0] == "noStock") {

                        cmAlert("재고가 없는 상품 또는 옵션이 포함되어 있습니다.");

                    } else if (data[0] == "error") {

                        cmAlert("주문하는 과정에서 오류가 생겼습니다. 관리자에게 문의 바랍니다.");

                    } else if (data[0] == "success") {

                        gnbLoad('orderFinish');

                        window.location.href = "/order?orderNo=" + data[1];

                    }
        
                },
                error:function(request,status,error){

                    console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                    
                }
                
            });

        }

    }

}

/* 주문서 결제 끝 */

/* 주문취소 시작 */

// 취소했을때 사유 나오기

function orderCancel(object, orderNo){

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/orderController",
        global: false,
        data:{
            "page": "order",
            "act": "orderCancel",
            "orderNo": orderNo
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            if (data[0] == "check") {

                cmAlert("상품준비중인 상품이 있어 취소요청 상태로 변경되었습니다.");

            } else if (data[0] == "unable") {

                if (data[1] == 4) {

                    var status = "배송중";

                } else if (data[1] == 5) {

                    var status = "배송완료";

                } else if (data[1] == 6) {

                    var status = "구매확정";

                } else if (data[1] == 7) {

                    var status = "후기작성완료";

                }

                cmAlert(status + "인 상품이 있어 취소처리가 불가합니다.");

                return false;

            }

            if (data[1] == 8) {

                var status = "취소요청";

            } else if (data[1] == 9) {

                var status = "취소완료";

            }

            $(object).parents(".ordered_list").find(".orderStatus span").text(status);

            $(object).remove();

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

    event.preventDefault();

}

/* 주문취소 끝 */

/* 구매확정 시작 */

function finishOrder(object, orderNo){

    let orderProductIdx = $(object).parents(".ordered_product_list").find(".orderProductIdx").val();

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/orderController",
        global: false,
        data:{
            "page": "order",
            "act": "finishOrder",
            "orderNo": orderNo,
            "orderProductIdx": orderProductIdx
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            $(object).parents(".ordered_product_list").find(".orderStatus span").text("구매확정");

            $(object).parents(".ordered_product_list").find(".deliveryCheck_btn").html("<p onclick=\"gnbLoad('reviewWrite'); window.location.href='/mypage?orderProductCode=" + orderProductIdx + "';\">후기작성</p>");

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

    event.preventDefault();

}

/* 구매확정 끝 */

/* 후기 클릭 시작 */

function reviewStarClick(object){

    var reviewStarPrecent = ($(object).index() + 1) * 10;

    $(".reviewStar_active").width(reviewStarPrecent + "%");

    $(".review_star").val(reviewStarPrecent);

}

/* 후기 클릭 끝 */

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
            
            if($(object)[0].files[i]['size'] > 5242880){

                alert("5MB 이하 파일만 등록할 수 있습니다.\n\n용량 초과 파일명 : " + $(object)[0].files[i]['name']);

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

                $(object).parents(".attachfile_box").find('.attach_descbox').append("<div class='attach_desclist flex-vc-hl-container' style='width: calc(" + attachDescWith + "% - 10px);'><input type='text' name='uploadName' readonly value='" + uploadName + "'><input type='hidden' name='transfileName[]' class='transfileName' value='" + uploadTransFile + "'><input type='hidden' id='" + fileIdxName + idxEq + "' class='file_idx' name='fileIdx[]'><input type='hidden' id='" + fileTempIdxName + idxEq + "' name='boardTempIdx[]'><p class='attach_del' onclick=\"attachDel(this, '" + table + "');\"><img src='/admin/resources/images/attach_del.png' alt=''></p></div>");
        
            }

        }
                
        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/public/controller/commonController",
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

                    cmAlert("등록 중 에러가 발생했습니다.");

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

function attachDel (object, table) {

    $.ajax({
        type: "POST", 
        dataType: "html",
        async: true,
        url: "/admin/controller/commonController",
        global: false,
        data:{
            "page": "attachFile",
            "act": "del",
            "table": table,
            "transfileName": $(object).siblings('.transfileName').val(),
            "fileIdx": $(object).siblings('.file_idx').val()
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

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

/* 배송조회 시작 */

function deliveryCheck (deliveryNo) {

    event.preventDefault();

    window.open("https://www.ilogen.com/web/personal/trace/" + deliveryNo + "", "", "scrollbars=yes", "resizeable=0", "status=0", "directories=0", "toolbar=0"); // cj대한통운 배송조회
 
}

/* 배송조회 끝 */

/* 더보기 시작 */

function descriptionMore (object) {

    $(object).parents(".description").css({

        height: "100%",
        overflow: "visible"

    });

    $(object).remove();

}

/* 더보기 끝 */

/*  클릭 로그 시작 */

// 로그부터 시작하기
function insertLog(data, page, destination, result, event) {

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/public/controller/frontLogController",
        global: false,
        data:{
            "data": data,
            "startPage": page,
            "destination": destination,
            "result": result,
            "event": event
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            console.log(data);

            // if (data == "success") {

            //     var fileIdName = $(object).parents(".attachfile_box").find("input[type='file']").attr("id");

            //     $(object).parents(".attach_desclist").remove();

            //     var fileLength = $("#" + fileIdName).siblings(".attach_descbox").find(".attach_desclist").length;

            //     // id 숫자 재설정
            //     for (i=0; i < fileLength; i++) {
            
            //         $(".attach_desclist").eq(i).find(".file_idx").attr("id", "fileIdx" + i);

            //     }

            //     // 첨부파일 없을경우             
            //     if(fileLength == 0){

            //         $("#" + fileIdName).siblings(".attach_descbox").find(".attach_placeholder").show();
            
            //     }

            // } else {

            //     alert("삭제 중 에러가 발생했습니다.");

            // }

        },
        error:function (request,status,error) {

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);

        }
        
    });

}
/* 클릭 로그 끝 */