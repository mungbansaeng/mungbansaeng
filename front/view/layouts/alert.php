<!-- alert 사용방법 시작 -->

<!--

    ※ 텍스트만 있는 alert
    cmAlert('원하는 텍스트 (필수)', '사용할 곳 (선택)', '클릭 후 이동할 위치 (선택)');

    사용할 곳
    장바구니 -> cart
    실행파일 -> act
    이동할 곳이 있을때 -> location

    ※ confirm alert


-->

<!-- alert 사용방법 끝 -->

<?

    if ($config['alertDesign'] == "A") { // 기본 디자인

?>
<!-- 일반 alert -->
<div id="alertContainer" class="alertCon" style="display:none;" onkeyup="enterClose();">
    <div class="alert_box">
        <p class="alert_logo"><img src="<?=$frontImgSrc?>/logo.png" alt=""></p>
        <p class="alert_tit"></p>
        <p class="alert_btn flex-vc-hc-container" onclick="cmAlertClose()">확인</p>
    </div>
    <p class="alert_bg"></p>
</div>

<!-- 장바구니 alert -->
<div id="cartAlertContainer" class="alertCon" style="display:none;">
    <div class="alert_box">
        <p class="alert_logo"><img src="<?=$frontImgSrc?>/logo.png" alt=""></p>
        <p class="alert_tit"></p>
        <div class="cartAlert_btnBox flex-vc-hc-container">
            <p class="cartAlert_btn cartAlert_cancelBtn flex-vc-hc-container" onclick="cmAlertClose()">취소</p>
            <p class="cartAlert_btn cartAlert_okBtn flex-vc-hc-container" onclick="location.href='/order/cart'">확인</p>
        </div>     
    </div>
    <p class="alert_bg"></p>
</div>

<!-- 이동 alert -->
<div id="linkAlertContainer" class="alertCon" style="display:none;">
    <div class="alert_box">
        <p class="alert_logo"><img src="<?=$frontImgSrc?>/logo.png" alt=""></p>
        <p class="alert_tit"></p>
        <p class="alert_btn flex-vc-hc-container" onclick="cmAlertClose('link')">확인</p>
    </div>
    <p class="alert_bg"></p>
</div>

<!-- confirm alert -->
<div id="confirmAlert" class="alertCon" style="display:none;">
    <div class="alert_box">
        <p class="alert_logo"><img src="<?=$frontImgSrc?>/logo.png" alt=""></p>
        <p class="alert_tit"></p>
        <div class="cartAlert_btnBox flex-vc-hc-container">
            <p class="cartAlert_btn cartAlert_cancelBtn flex-vc-hc-container" onclick="cmConfirmAlertCancel()">취소</p>
            <p class="cartAlert_btn cartAlert_okBtn flex-vc-hc-container" onclick="cmConfirmAlertOk();">확인</p>
        </div>
    </div>
    <p class="alert_bg"></p>
</div>

<input type="hidden" id="checkInput" value="">
<p id="hiddenContent_bg"></p>

<style>
    .alertCon{position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 5;}
    .alert_box{position: absolute; top: 50%; right: 50%; transform: translate(50%, -50%); width: 420px; min-height: 140px; border-radius: 20px; box-sizing: border-box; background-color: var(--white); z-index: 3; overflow: hidden;}
    .alert_bg{position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.4); z-index: 2;}
    #hiddenContent_bg{position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: #fff; z-index: 4; display: none;}
    .alert_logo{text-align: center; margin-bottom: 20px; padding-top: 20px;}
    .alert_logo img{width: 120px;}
    /* .alert_tit{font-size: 18px; line-height: 1.4; margin-bottom: 20px; padding: 0 40px;} */
    .alert_tit{font-size: 18px; line-height: 1.4; margin-bottom: 20px; padding: 0 22px;}
    .alert_btn{background-color: var(--mainColor); height: 46px; color: var(--white); cursor: pointer;}

    .cartAlert_btnBox{width: 100%;}
    .cartAlert_btn{width: 50%; height: 46px; cursor: pointer;}
    .cartAlert_okBtn{background-color: var(--mainColor); color: var(--white);}
    .cartAlert_cancelBtn{border: 1px solid var(--mainColor); color: var(--mainColor); box-sizing: border-box;}

    @media screen and (max-width:480px){

        /* alert */
        .alert_box{width: 80%; min-height: 100px;}
        .alert_logo{margin-bottom: 16px; padding-top: 16px;}
        .alert_logo img{width: 80px;}
        .alert_tit{font-size: 16px; margin-bottom: 16px; padding: 0 16px;}
        .alert_btn{height: 42px;}

    }
</style>

<script>

/* alert 시작 */

function cmAlert(title, kind, target){

    $(".alert_tit").text(title);

    if(kind == "cart"){

        $("#cartAlertContainer").fadeIn();

    }else if(kind == "link"){

        $("#hiddenContent_bg").show();

        $("#linkAlertContainer").fadeIn();

    }else{

        $("#alertContainer").fadeIn();

    }

    if(target){

        $("#checkInput").val(target);

    }else{

        $("#checkInput").val("");

    }

}

function cmAlertClose(type){

    var target = $("#checkInput").val();

    if(type == "link"){ // 이동 링크가 있을때

        window.location.href = "" + target + "";

    }else{ // 일반 alert일때

        $(".alertCon").fadeOut();

        $("#" + target).focus();

    }

}

function enterClose(){

    if(event.keyCode == 13){

        cmAlertClose();

        return false;

    }

};

/* alert 끝 */

/* confirm alert 시작 */

function cmConfirmAlert(title, kind){

    $(".alert_tit").html(title);

    if (kind == "cart") {

        $(".cartAlert_okBtn").text("장바구니 가기");

        $(".cartAlert_cancelBtn").text("쇼핑 계속하기");

        $(".cartAlert_okBtn").attr("onclick", "cmConfirmAlertOk('cart');");

    } else if (kind == "dormant") {

        $(".cartAlert_okBtn").text("휴면해제 하기");

    }

    $("#hiddenContent_bg").show();

    $("#confirmAlert").fadeIn();

}

function cmConfirmAlertOk(type){

    if (type == "cart") {

        gnbLoad('cart');

        window.location.href = "/order";

    }

}

function cmConfirmAlertCancel(){

    $(".alertCon").fadeOut();
    $("#hiddenContent_bg").fadeOut();

}

/* confirm alert 끝 */

</script>

<?

    } else if ($config['alertDesign'] == "B") { // 글자 디자인

?>

<script>

    function cmAlert(title, kind, target){

        $("#textAlert").remove();

        $("#" + target).after("<p style='font-size: 12px; color: #ff1515; padding-bottom: 10px;' id='textAlert'>" + title + "</p>");

    }

</script>

<?

    } else if ($config['alertDesign'] == "C") { // 위 -> 아래 디자인

?>

<div id="alertContainer" class="alertCon" style="display:none;">
    <div class="alert_box">
        <p class="alert_tit flex-vc-hc-container"></p>
    </div>
</div>

<style>

    #alertContainer{position: fixed; top: 0; right: 50%; transform: translateX(50%); width: 500px; height: 42px; background-color: var(--mainColor); border-radius: 6px; opacity: 0; transition: all 0.6s; z-index: 4;}
    #alertContainer.active{top: 20px; opacity: 1;}
    .alert_box{height: 100%;}
    .alert_tit{height: 100%; color: var(--white);}

</style>

<script>

    function cmAlert(title, kind, target){

        $(".alert_tit").text(title);

        $("#alertContainer").show();

        $("#alertContainer").addClass("active");

        if (kind == "focus") {

            $("#" + target).focus();

        } else if (kind == "link") {

            setTimeout(function(){

                window.location.href = target;

            }, 1000);

        }

        setTimeout(function(){

            $("#alertContainer").removeClass("active");

        }, 2000);

        setTimeout(function(){

            $("#alertContainer").hide();
            
        }, 3000);

    }

</script>

<?

    } else if ($config['alertDesign'] == "D") { // 아래 -> 위 디자인

?>

<div id="alertContainer" class="alertCon" style="display:none;">
    <div class="alert_box">
        <p class="alert_tit flex-vc-hc-container"></p>
    </div>
</div>

<!-- confirm alert -->
<div id="confirmAlert" class="alertCon" style="display:none;">
    <div class="alert_box">
        <p class="alert_tit flex-vc-hc-container"></p>
        <div class="cartAlert_btnBox flex-vc-hc-container">
            <p class="cartAlert_btn cartAlert_cancelBtn flex-vc-hc-container" onclick="cmConfirmAlertCancel();">취소</p>
            <p class="cartAlert_btn cartAlert_okBtn flex-vc-hc-container" onclick="cmConfirmAlertOk();">확인</p>
        </div>
    </div>
</div>

<style>

    #alertContainer{position: fixed; bottom: 0; right: 50%; transform: translateX(50%); width: 500px; height: 42px; background-color: var(--mainColor); border-radius: 6px; opacity: 0; transition: all 0.6s; z-index: 4;}
    #alertContainer.active{bottom: 20px; opacity: 1;}
    .alert_box{height: 100%;}
    .alert_tit{height: 100%; color: var(--white); line-height: 1.4; margin-bottom: 20px;}

    #confirmAlert{position: fixed; bottom: 0; right: 50%; transform: translateX(50%); width: 500px; background-color: var(--mainColor); border-radius: 6px; opacity: 0; transition: all 0.6s; z-index: 4; padding: 20px 10px;}
    #confirmAlert.active{bottom: 20px; opacity: 1;}

    .cartAlert_btn{width: 160px; height: 40px; border-radius: 6px; cursor: pointer;}
    .cartAlert_cancelBtn{border: 1px solid var(--white); margin-right: 10px; color: var(--white);}
    .cartAlert_okBtn{background-color: var(--white);}

    @media screen and (max-width:1024px){

        #alertContainer{z-index: 11;}

    }

    @media screen and (max-width:600px){

        #alertContainer{width: 90%;}
        .alert_tit{font-size: 14px;}

    }

</style>

<script>

    function cmAlert(title, kind, target){

        $("#alertContainer").hide();

        $(".alert_tit").text(title);

        $("#alertContainer").show();

        $("#alertContainer").addClass("active");

        if (kind == "focus") {

            $("#" + target).focus();

        } else if (kind == "link") {

            setTimeout(function(){

                window.location.href = target;

            }, 1000);

        }

        setTimeout(function(){

            $("#alertContainer").removeClass("active");

        }, 2000);

        setTimeout(function(){

            $("#alertContainer").hide();
            
        }, 3000);

    }

    /* confirm alert 시작 */

    function cmConfirmAlert(title, okText, cancelText, type, target){

        $(".alert_tit").html(title);

        $("#confirmAlert").show();

        $("#confirmAlert").addClass("active");

        $(".cartAlert_okBtn").text(okText);

        $(".cartAlert_cancelBtn").text(cancelText);

        $(".cartAlert_okBtn").attr("onclick", "cmConfirmAlertOk('" + type +"', '" + target +"');");

    }

    function cmConfirmAlertCancel() {

        $("#confirmAlert").removeClass("active");

        setTimeout(function(){

            $("#confirmAlert").hide();
            
        }, 1000);

    }

    function cmConfirmAlertOk(type, target) {

        if (type !== "") {

            gnbLoad(type);

        }

        if (target !== "") {

            setCookie("returnUrl", window.location.href);

            window.location.href = target;

        }

    }

    /* confirm alert 끝 */

</script>

<?}?>