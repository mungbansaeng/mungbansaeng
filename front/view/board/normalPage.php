<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <div class="sub_container">
                <div class="normalPage">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    let device = $(".device").val();

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/boardController",
        global: false,
        data: {
            "page": "normalPage",
            "act": "list",
            "idx": $(".one_depth.active").siblings(".categoryIdx").val(),
            "type": device
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            if (data[0] == "success") {

                $(".normalPage").html("<img src='/admin/resources/upload/" + data[1]['fileName'] + "' alt='게시판이미지'>");

            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

</script>

<!-- <div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <ul class="board_titBox flex-vc-hsb-container">
                <li>멍반생이 천만 아이들의 부모님과 약속합니다!</li>
            </ul>
            <div class="sub_container">
                <div class="intro_con1">
                    <ul>
                        <li class="introCon1_text1">"우리 아이를 위해"</li>
                        <li class="introCon1_text2">안전하고 건강한 간식만 만듭니다!</li>
                    </ul>
                    <p class="introCon1_bg"></p>
                    <p class="introCon1_bgWhite"></p>
                    <div class="introCon1_bgWrap">
                        <p class="introCon1_bg"></p>
                        <p class="introCon1_bgWhite"></p>
                    </div>
                </div>
                <div class="intro_con2 flex-vc-hc-container">
                    <p class="introCon2_title">멍반생의 3가지 <span class="color_strong">약속</span></p>
                    <ul class="w768 intro_conBox">
                        <li class="intro_title">첫번째, <span class="color_strong">안전한 간식</span></li>
                        <li class="intro_description">
                            멍반생은 저희 아이에게 먹일 안전하고 건강한 간식을 만들기위해 시작했습니다. <span class="lb_1920"></span>
                            항상 재료선정부터 포장까지 저희 아이에게 걱정없이 먹일 수 있는 퀄리티를 유지할 것입니다. <span class="lb_1920"></span>
                            저희 아이를 포함한 모든 아이들이 먹는 음식이기에 항상 깨끗하고 건강한 간식만 만들겠습니다.
                        </li>
                    </ul>
                    <ul class="w768 intro_conBox">
                        <li class="intro_title">두번째, <span class="color_strong">합리적인 가격</span></li>
                        <li class="intro_description">
                            저렴한 가격을 위해 질 좋지않은 재료를 사용하지 않겠습니다. <span class="lb_1920"></span>
                            질이 좋은 재료라고 비싼 가격으로 판매하지 않겠습니다. <span class="lb_1920"></span>
                            항상 고심하며 좋은 재료와 저렴한 가격의 균형과 조화를 유지하겠습니다. <span class="lb_1920"></span>
                        </li>
                    </ul>
                    <ul class="w768 intro_conBox">
                        <li class="intro_title">세번째, <span class="color_strong">경청하는 자세</span></li>
                        <li class="intro_description">
                            저희 멍반생을 이용해주시는 모든 분들의 얘기에 경청하겠습니다. <span class="lb_1920"></span>
                            좋은 얘기를 활력삼아 더 좋은 재료를 찾고 더 좋은 레시피를 만들겠습니다. <span class="lb_1920"></span>
                            쓴 소리를 바탕으로 다시 돌아보고 수정해서 더 만족하는 멍반생을 이용하실 수 있도록 하겠습니다. 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> -->

<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/footer.php"; // 푸터
    
?>	