
<div class="sub_container">
    <input type="hidden" id="limitStart" value="0">
    <input type="hidden" id="showBoardNum" value="8">
    <input type="hidden" id="boardOpenNum" value="4">
    <input type="hidden" id="totalBoardCount" value="">
    <div id="boardPostListBox">
        <div id="boardConBox" class="boardGallary_listBox">
            
        </div>
    </div>
</div>

<script>

    gnbLoad('reviewList');

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/mypageController",
        global: false,
        data: {
            "page": "mypage",
            "act": "reviewList"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            let contentsList = "";
            let openClass = "";

            if (data[1].length > 0) {

                for (cl=0; cl < data[1].length; cl++) {

                    // console.log(data[1][cl]);

                    if (cl == $("#boardOpenNum").val()) {

                        openClass = "boardOpen";

                    }

                    // 후기 사진
                    let reviewFile = "";
                    let reviewPopFile = "";

                    if (data[1][cl]['reviewType'] == "photo") {

                        reviewFile = "<p class=\"review_product_img\" onclick='reviewPop(this);' style=\"background-image: url('<?=$frontUploadSrc?>/" + data[1][cl]['fileName'] + "');\"></p>";

                        reviewPopFile = "<p class=\"reviewPop_product_img\"><img src='<?=$frontUploadSrc?>/" + data[1][cl]['fileName'] + "' alt='후기이미지'></p>";

                    } else if (data[1][cl]['reviewType'] == "video") {

                        reviewFile = "<p class=\"review_product_video\" onclick='reviewPop(this);'><video src=\"<?=$frontUploadSrc?>/" + data[1][cl]['fileName'] + "\" preload=\"auto\" loop=\"\" playsinline=\"\" webkit-playsinline=\"\" x5-playsinline=\"\" autoplay muted></video></p>";

                        reviewPopFile = "<p class=\"reviewPop_product_video\"><video src=\"<?=$frontUploadSrc?>/" + data[1][cl]['fileName'] + "\" preload=\"auto\" loop=\"\" playsinline=\"\" webkit-playsinline=\"\" x5-playsinline=\"\" autoplay muted></video></p>";

                    }

                    // 날짜 수정
                    let reviewDate = data[1][cl]['date'].slice(0, 10);

                    contentsList += "<div class='ordered_list review_list board_postList' onclick='reviewPop(this);'><ul class='ordered_list_top flex-vc-hsb-container'><li>주문번호 : " + data[1][cl]['orderNo'] + "</li><li class='review_star'><img src='<?=$frontImgSrc?>/reviewStar.png' alt='후기별점'><span class='reviewStar_active' style='width: " + data[1][cl]['reviewStar'] + "%;'><img src='<?=$frontImgSrc?>/reviewStar_active.png' alt='후기별점'></span></li></ul><div class='review_product_listBox'><div class='review_product_list'>" + reviewFile + "<ul><li class='review_title'>" + data[2][cl]['title'] + "</li><li class='review_optionTitle'>" + data[1][cl]['optionTitle'] + "</li><li class='review_description'><pre style='white-space: pre-wrap;'>" + data[1][cl]['reviewDescription'] + "</pre></li><li class='review_bottom flex-vc-hsb-container'><p>" + reviewDate + "</p><!-- <p class=''>신고하기</p> --></li></ul></div></div></div><div id='reviewPopup' class='review_popup'><div class='reviewPopup_desc'>" + reviewPopFile + "</div><p class='reviewPopup_bg' onclick='reviewPopClose();'></p></div>";

                }

                $("#boardConBox").append(contentsList);

            } else {

                let emptyContent = "<div class='flex-vc-hc-container'><div class='empty_box'><lottie-player src='<?=$frontImgSrc?>/emptySearch.json' background='transparent' style='width: 100%; height: 100%;' speed='1' loop autoplay></lottie-player><p class='empty_tit'>아직 작성한 후기가 없습니다.</p></div></div>";

                $("#boardConBox").append(emptyContent);

            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

</script>

<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/footer.php"; // 푸터
    
?>	