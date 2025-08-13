<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/header.php"; // 헤더
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/controller/mainController.php";

?>
<div class="main_visbox">
    <div class="slide_box">
        <div class="swiper mainVis_slide">
            <div class="swiper-wrapper mainVis_slideCon"></div>
            <div class='slide_apBox'></div>
        </div>
    </div>
</div>
<div class="main_container">
    <div class="main_best main_con flex-vc-hc-container">
        <div class="w1200">
            <div class="main_tit">
                제일 잘 나가는 멍!간식
            </div>
            <div class="slide_box">
                <div class="swiper mainBest_slide">
                    <div class="swiper-wrapper mainBest_slideCon"></div>
                </div>
                <div class="slide_arrowBox flex-vc-hsb-container">
                    <button id="mainBest_prevBtn" class="slide_arrow slide_prevArrow"><img src="<?=$frontImgSrc?>/slide_blackPrev.png" alt="이전버튼"></button>
                    <button id="mainBest_nextBtn" class="slide_arrow slide_nextArrow"><img src="<?=$frontImgSrc?>/slide_blackNext.png" alt="다음버튼"></button>
                </div>
            </div>
        </div>
    </div>
    <div class="main_news main_con flex-vc-hc-container">
        <div class="w1200">
            <div class="flex-vc-hsb-container">
                <div class="main_tit">
                    이런 멍!뉴스 어떠세요?
                </div>
                <p>더보기</p>
            </div>
            <div class="flex-vc-hl-container boardNews_listBox">
                
            </div>
        </div>
    </div>
    <!-- <div class="main_allergy flex-vc-hc-container">
        <div class="w1200">
            <div class="main_tit">
                알러지별 맞춤간식 멍!조합
            </div>
            <div class="mainAllergy_Box">
                <div class="mainAllergy_listBox flex-vc-hl-container">
                    <a href="#void" class="mainAllergy_list">
                        <ul>
                            <li style="background-image: url('<?=$frontImgSrc?>/temp/dodam.jpg');"></li>
                            <li>닭</li>
                        </ul>
                    </a>
                    <a href="#void" class="mainAllergy_list">
                        <ul>
                            <li style="background-image: url('<?=$frontImgSrc?>/temp/dodam.jpg');"></li>
                            <li>소고기</li>
                        </ul>
                    </a>
                    <a href="#void" class="mainAllergy_list">
                        <ul>
                            <li style="background-image: url('<?=$frontImgSrc?>/temp/dodam.jpg');"></li>
                            <li>오리고기</li>
                        </ul>
                    </a>
                    <a href="#void" class="mainAllergy_list">
                        <ul>
                            <li style="background-image: url('<?=$frontImgSrc?>/temp/dodam.jpg');"></li>
                            <li>비숑</li>
                        </ul>
                    </a>
                    <a href="#void" class="mainAllergy_list">
                        <ul>
                            <li style="background-image: url('<?=$frontImgSrc?>/temp/dodam.jpg');"></li>
                            <li>비숑</li>
                        </ul>
                    </a>
                    <a href="#void" class="mainAllergy_list">
                        <ul>
                            <li style="background-image: url('<?=$frontImgSrc?>/temp/dodam.jpg');"></li>
                            <li>비숑</li>
                        </ul>
                    </a>
                    <a href="#void" class="mainAllergy_list">
                        <ul>
                            <li style="background-image: url('<?=$frontImgSrc?>/temp/dodam.jpg');"></li>
                            <li>비숑</li>
                        </ul>
                    </a>
                    <a href="#void" class="mainAllergy_list">
                        <ul>
                            <li style="background-image: url('<?=$frontImgSrc?>/temp/dodam.jpg');"></li>
                            <li>비숑</li>
                        </ul>
                    </a>
                    <a href="#void" class="mainAllergy_list">
                        <ul>
                            <li style="background-image: url('<?=$frontImgSrc?>/temp/dodam.jpg');"></li>
                            <li>비숑</li>
                        </ul>
                    </a>
                    <a href="#void" class="mainAllergy_list">
                        <ul>
                            <li style="background-image: url('<?=$frontImgSrc?>/temp/dodam.jpg');"></li>
                            <li>비숑</li>
                        </ul>
                    </a>
                </div>
            </div>
        </div>
    </div> -->
    <div class="main_review flex-vc-hc-container">
        <div class="w1200">
            <div class="main_tit">
                실사용자들의 사용 후기가 궁금하신가요?
            </div>
            <div class="slide_box">
                <div class="swiper mainReview_slide">
                    <div class="swiper-wrapper mainReview_slideCon"></div>
                </div>
                <div class="slide_arrowBox flex-vc-hsb-container">
                    <button id="mainReview_prevBtn" class="slide_arrow slide_prevArrow"><img src="<?=$frontImgSrc?>/slide_blackPrev.png" alt="이전버튼"></button>
                    <button id="mainReview_nextBtn" class="slide_arrow slide_nextArrow"><img src="<?=$frontImgSrc?>/slide_blackNext.png" alt="다음버튼"></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="mainReviewPopupBox"></div>

<script type="text/javascript">

    let device = $(".device").val();

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/mainController",
        global: false,
        data: {
            "page": "main",
            "type": device
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            if (data[0] == "success") {

                // 메인 최상단 배너
                if (data[1].length > 0) {

                    let bannerHtml = "";
                    let bannerApHtml = "";

                    for (mtb=0; mtb < data[1].length; mtb++) {

                        if (data[1][mtb]['link'] == "") {

                            bannerHtml += "<div class='swiper-slide'><img src='<?=$adminUploadSrc?>/" + data[1][mtb]['fileName'] + "' alt='" + data[1][mtb]['title'] + "'></div>";

                            bannerApHtml += "<div class='slide_arrowBox flex-vc-hsb-container'><button id='mainVis_prevBtn' class='slide_arrow slide_prevArrow'><img src='<?=$frontImgSrc?>/slide_blackPrev.png' alt='이전버튼'></button><button id='mainVis_nextBtn' class='slide_arrow slide_nextArrow'><img src='<?=$frontImgSrc?>/slide_blackNext.png' alt='다음버튼'></button></div><div class='slide_pagination'><div class='swiper-pagination mainVis_pagination'><span class='swiper-pagination-current'></span> / <span class='swiper-pagination-total'></span></div></div>";

                        } else {

                            bannerHtml += "<div class='swiper-slide'><a href='" + data[1][mtb]['link'] + "'><img src='<?=$adminUploadSrc?>/" + data[1][mtb]['fileName'] + "' alt='" + data[1][mtb]['title'] + "'></a></div>";

                            bannerApHtml += "<a href='" + data[1][mtb]['link'] + "'><div class='slide_arrowBox flex-vc-hsb-container'><button id='mainVis_prevBtn' class='slide_arrow slide_prevArrow'><img src='<?=$frontImgSrc?>/slide_blackPrev.png' alt='이전버튼'></button><button id='mainVis_nextBtn' class='slide_arrow slide_nextArrow'><img src='<?=$frontImgSrc?>/slide_blackNext.png' alt='다음버튼'></button></div><div class='slide_pagination'><div class='swiper-pagination mainVis_pagination'><span class='swiper-pagination-current'></span> / <span class='swiper-pagination-total'></span></div></div></a>";

                        }

                    }

                    $(".mainVis_slideCon").html(bannerHtml); // 리스트 그리기
                    $(".slide_apBox").html(bannerApHtml);

                    const swiper = new Swiper(".mainVis_slide", {
                        speed : 1200,
                        effect: "fade",
                        loop: false,
                        autoplay: {
                            delay: 4000,
                        },
                        pagination: {
                            el: ".swiper-pagination",
                            type: "fraction"
                        },
                        navigation: {
                            nextEl: "#mainVis_nextBtn",
                            prevEl: "#mainVis_prevBtn"
                        }
                    });

                }

                // 메인 베스트
                if (data[2].length > 0) {

                    let bestHtml = "";

                    for (mbb=0; mbb < data[2].length; mbb++) {

                        bestHtml += "<div class='swiper-slide'><a href='/view?productCode=" + data[2][mbb]['productCode'] + "'><img src='<?=$adminUploadSrc?>/" + data[2][mbb]['fileName'] + "' alt='" + data[2][mbb]['title'] + "'></a></div>";

                    }

                    $(".mainBest_slideCon").html(bestHtml); // 리스트 그리기

                    const swiper = new Swiper(".mainBest_slide", {
                            slidesToScroll: 1,
                            navigation: {
                                nextEl: "#mainBest_nextBtn",
                                prevEl: "#mainBest_prevBtn"
                            },
                            breakpoints: {        
                                320: {
                                    slidesPerView: 2,  // 320보다 클 때
                                    spaceBetween: 20,
                                },
                                1024: {
                                    slidesPerView: 4,  // 1024보다 클 때
                                    spaceBetween: 30,
                                },
                            }
                    });

                }

                // 메인 후기
                if (data[3].length > 0) {

                    let reviewHtml = "";
                    let reviewPopHtml = "";

                    for (mrc=0; mrc < data[3].length; mrc++) {

                        // 후기 사진
                        let reviewFile = "";

                        if (data[3][mrc]['reviewType'] == "photo") {

                            reviewFile = "<p class=\"mainReview_product_img\" style=\"background-image: url('<?=$frontUploadSrc?>/" + data[3][mrc]['fileName'] + "');\"></p>";

                            reviewPopFile = "<p class=\"reviewPop_product_img\"><img src='<?=$frontUploadSrc?>/" + data[3][mrc]['fileName'] + "' alt='후기이미지'></p>";

                        } else if (data[3][mrc]['reviewType'] == "video") {

                            reviewFile = "<p class=\"mainReview_product_video\"><video src=\"<?=$frontUploadSrc?>/" + data[3][mrc]['fileName'] + "\" preload=\"auto\" loop=\"\" playsinline=\"\" webkit-playsinline=\"\" x5-playsinline=\"\" autoplay muted></video></p>";

                            reviewPopFile = "<p class=\"reviewPop_product_video\"><video src=\"<?=$frontUploadSrc?>/" + data[3][mrc]['fileName'] + "\" preload=\"auto\" loop=\"\" playsinline=\"\" webkit-playsinline=\"\" x5-playsinline=\"\" autoplay muted></video></p>";

                        }

                        // 날짜
                        let regDate = data[3][mrc]['date'].slice(0, 10);

                        // 아이디
                        let userId = data[3][mrc]['id'].slice(0, 3) + "****";

                        reviewHtml += "<div class='swiper-slide'><ul onclick=\"mainReviewPop('" + mrc + "');\"><li>" + reviewFile + "</li><li>" + data[3][mrc]['productName'] + "</li><li class='mainReview_desc'>" + data[3][mrc]['reviewDescription'] + "</li></ul></div>";

                        reviewPopHtml += "<div id='reviewPopup' class='review_popup mainReview_popup" + mrc + "'><div class='reviewPopup_desc'>" + reviewPopFile + "<div class='reviewPopup_descText'><p class='user_id'>" + userId + "</p><pre style='white-space: pre-wrap;'>" + data[3][mrc]['reviewDescription'] + "</pre><p class='popClose' onclick='reviewDescClose(this);'></p></div><p class='popClose' onclick='reviewPopClose();'></p></div><p class='reviewPopup_bg'></p></div>";

                    }

                    $(".mainReview_slideCon").html(reviewHtml); // 리스트 그리기
                    $("#mainReviewPopupBox").html(reviewPopHtml); // 리스트 그리기

                    const swiper = new Swiper(".mainReview_slide", {
                            slidesToScroll: 1,
                            navigation: {
                                nextEl: "#mainReview_nextBtn",
                                prevEl: "#mainReview_prevBtn"
                            },
                            breakpoints: {        
                                320: {
                                    slidesPerView: 2,  // 320보다 클 때
                                    spaceBetween: 20,
                                },
                                1024: {
                                    slidesPerView: 4,  // 1024보다 클 때
                                    spaceBetween: 30,
                                },
                            }
                    });

                }
                
            }

            // 메인 뉴스
            if (data[4].length > 0) {

                let mainNewsHtml = "";

                for (mn=0; mn < data[4].length; mn++) {

                    let date = data[4][mn]['date'].slice(0, 10);
                    let description = "";

                    if ($("body, html").width() > 768) {

                        description = data[4][mn]['pcDescription'];

                    } else {

                        description = data[4][mn]['mobileDescription'];

                    }

                    if (data[4][mn]['fileName'] == "" || data[4][mn]['fileName'] == null) {

                        fileName = "<?=$frontImgSrc?>/noimage.jpg";

                    } else {

                        fileName = "<?=$adminUploadSrc?>/" + data[4][mn]['fileName'];

                    }

                    mainNewsHtml += "<div class='boardNews_list'><div class='boardNews_listCon'><a href='#void' class='flex-vc-hsb-container'><div class='boardNews_thumnail' style=\"background-image: url('" + fileName + "'); background-size: cover; background-position: center;\"></div><ul class='boardNews_descList'><li class='boardNews_top'>" + data[4][mn]['newsTitle'] + "</li><li class='boardNews_dc'><p>" + data[4][mn]['categoryTitle'] + " / " + date + "</p></li><li class='boardNews_desc'>" + description + "</li></ul></a></div></div>";

                }

                $(".boardNews_listBox").html(mainNewsHtml); // 리스트 그리기

            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });
    
    // // 타임세일
    // function countDown(){

    //     var countDownDate = new Date();

    //     // 시간
    //     var countDownHours = 23 - countDownDate.getHours();

    //     if(countDownHours < 10){

    //         countDownHours = "0" + countDownHours;

    //     }

    //     // 분 
    //     var countDownMinutes = 59 - countDownDate.getMinutes();

    //     if(countDownMinutes < 10){

    //         countDownMinutes = "0" + countDownMinutes;

    //     }

    //     // 초

    //     var countDownSeconds = 59 - countDownDate.getSeconds();

    //     if(countDownSeconds < 10){

    //         countDownSeconds = "0" + countDownSeconds;

    //     }

    //     $("#countDownToday").html("<span class='countDownTime'>" + countDownHours + "</span>시간 <span class='countDownTime'>" + countDownMinutes + "</span>분 <span class='countDownTime'>" + countDownSeconds + "</span>초 남았습니다.");

    // }

    // countDown();

    // setInterval(countDown, 1000);

</script>

<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/footer.php"; // 푸터
    
?>	