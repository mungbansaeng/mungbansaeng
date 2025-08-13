<div class="sub_container">
    <form id="reviewRegForm" name="form">
        <input type="hidden" name="page" value="mypage">
        <input type="hidden" name="act" value="reviewWrite">
        <input type="hidden" name="table" value="review">
        <input type="hidden" name="orderProductCode" value="<?=$_GET['orderProductCode']?>">
        <input type="hidden" name="productCode" value="">
        <div class="mypage_marginBox reviewWrite_box">
            <div class="order_list">
                <div class="oroder_infobox flex-vc-hsb-container">
                    <div class="order_thumbBox"></div>
                    <div class="order_titbox flex-vc-hsb-container">
                        <div>
                            <p class="product_tit"></p>
                            <p class="option_tit"></p>
                            <p class="option_pq"><span class="option_pirce"></span>원 x <span class="review_optionQty"></span>개</p>
                        </div>
                        <div class="orderDetail_pricebox">
                            <p><span class="review_totalPrice"></span>원</p>
                        </div>
                    </div>
                </div>
            </div>
            <p class="reviewWrite_tit">받아보신 상품은 어떠셨나요?</p>
            <div class="reviewWrite_starBox flex-vc-hc-container">
                <div class="review_star">
                    <img src="<?=$frontImgSrc?>/reviewWriteStar.png" alt="후기별점">
                    <ul class="reviewStar_clickBox flex-vc-hl-container">
                        <?
                        
                            for($rs=0; $rs < 10; $rs++){
                        
                        ?>
                        <li onclick="reviewStarClick(this);"></li>
                        <?}?>
                    </ul>
                    <p class="reviewStar_active">
                        <img src="<?=$frontImgSrc?>/reviewWriteStar_active.png" alt="후기별점">
                        <input type="hidden" name="reviewStar" id="reviewStar" class="review_star">
                    </p>
                </div>
            </div>
            <div class="reviewWrite_textBox">
                <div class="reviewWrite_textCon">
                    <textarea name="reviewDescription" id="reviewDescription" placeholder="생생한 후기를 입력해주세요."></textarea>
                </div>
            </div>
            <div class="reviewWrite_photoBox">
                <div class="reviewWrite_photoCon">
                    <div class="attachfile_box reviewWrite_photoBox flex-vc-hl-container">
                        <input type="hidden" class="fileTotalNum" value="1"> <!-- 첨부파일 가능 개수 -->
                            <div class="attach_descbox reviewFiles_desc flex-vc-hl-container"><p class="attach_placeholder">이미지 또는 동영상을 첨부해주세요.</p></div>
                            <input type="file" id="reviewFiles" class="reviewFiles_input" onchange="attachClick(this, 'review', 'review', 'front');">
                            <label for="reviewFiles" class="reviewFiles_btn flex-vc-hc-container">
                                <span class="file_design">파일첨부</span>
                            </label>
                            <p class="reviewFiles_sdesc">* 5MB 이하 파일을 업로드하세요.</p>
                        </div>
                    </div>
                </div>
                <div class="reviewWrite_btnbox flex-vc-hc-container">
                    <input type="button" value="돌아가기" onclick="" class="fo_btn fo_backBtn">
                    <input type="button" value="등록하기" class="fo_btn fo_okBtn reg_btn">
                </div>
            </div>
        </div>
    </form>
</div>

<script>

    gnbLoad('reviewWrite');

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/mypageController",
        global: false,
        data: {
            "page": "mypage",
            "act": "reviewWriteView",
            "orderProductCode": "<?=$_GET['orderProductCode']?>"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            $(".order_thumbBox").html("<img src='" + adminImgSrc + "/" + data[1]['fileName'] + "' alt='제품썸네일'>");

            let totalPrice = parseInt(data[1]['price']) * parseInt(data[1]['qty']);

            $(".product_tit").text(data[1]['title']);
            $(".option_tit").text(data[1]['optionTitle']);
            $(".option_pirce").text(comma(data[1]['price']));
            $(".review_optionQty").text(data[1]['qty']);
            $(".review_totalPrice").text(comma(totalPrice));

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

    $(".reg_btn").click(function() {

        const form = $("#reviewRegForm");

        // 유효성 체크
        if (!$("#reviewStar").val()) {

            cmAlert("별점을 선택해주세요.");

            return false;

        } else if (!$("#reviewDescription").val()) {

            cmAlert("후기 내용을 작성해주세요.");

            $("#reviewDescription").focus();

            return false;

        }

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/front/controller/mypageController",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                if (data[0] == "success") {

                    gnbLoad("reviewWriteFinish"); 
                    
                    window.location.href="/mypage?orderProductCode=<?=$_GET['orderProductCode']?>";

                }

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    });

</script>

<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/footer.php"; // 푸터
    
?>	