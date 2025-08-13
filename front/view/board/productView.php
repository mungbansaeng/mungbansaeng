<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/header.php"; // 헤더

?>	
<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <div class="product_top flex-vt-hsb-container">
                <div class="product_thumb">
                    <img src="" alt="제품 썸네일">
                </div>
                <div class="product_infoList">
                    <p class="product_tit"></p>
                    <div class="product_share flex-vc-hsb-container">
                        <div class="review_star">
                            <img src="<?=$frontImgSrc?>/reviewStar.png" alt="후기별점">
                            <span class="reviewStar_active"><img src="<?=$frontImgSrc?>/reviewStar_active.png" alt="후기별점"></span>
                        </div>
                        <div class="icon_box flex-vc-hc-container">
                            <div class="share_box" onclick="shareOpen();">
                                <img src="<?=$frontImgSrc?>/share.png" alt="공유 아이콘">
                            </div>
                            <div class="wish_box">
                                <p class="wish_click"></p>
                            </div>
                        </div>
                    </div>
                    <div class="product_brieflistbox">
                        <div class="product_brieflist product_discountYn flex-vc-hl-container">
                            <div class="product_brieftit">정가</div>
                            <div class="product_orginPrice"></div>
                        </div>
                        <div class="product_brieflist flex-vc-hl-container">
                            <div class="product_brieftit">판매가</div>
                            <div class="product_discountPriceBox flex-vc-hl-container">
                                <span class="product_discountPrice"></span>
                                <span class="product_discountPercent color_strong product_discountYn"></span>
                            </div>
                        </div>
                        <div class="product_brieflist product_maxPointBox flex-vc-hl-container">
                            <div class="product_brieftit">최대 적립금</div>
                            <div class="product_briefdesc product_maxPoint"></div>
                        </div>
                        <div class="product_brieflist flex-vc-hl-container">
                            <div class="product_brieftit">배송비</div>
                            <div class="product_briefdesc product_deliveryPrice"></div>
                        </div>
                    </div>
                    <div id="productOptionBox">
                        
                    </div>
                    <div class="product_totalpricebox">
                        <p class="product_totalpricetit">총 상품 금액</p>
                        <p class="product_totalprice"></p>
                    </div>
                    <form name="orderForm" id="orderForm" action="/order/order_sheet" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="lct" value="tempCart">
                        <div class="product_btnbox">
                            <input type="button" name="" class="product_btn product_btn1" value="장바구니" onclick="cartOrder(this, 'cart');">
                            <input type="button" name="" class="product_btn product_btn2" value="바로구매" onclick="cartOrder(this, 'tempCart');">
                        </div>
                    </form>
                </div>
            </div>
            <p class="productdetail_tabbpos"></p>
            <div class="productdetail_tabbox">
                <div class="productdetail_tab productdetail_tabactive" data-val="detail" onclick="productDetail(this);">상품정보</div>
                <div class="productdetail_tab" data-val="review" onclick="productDetail(this);">후기</div>
                <div class="productdetail_tab" data-val="qna" onclick="productDetail(this);">문의</div>
                <div class="productdetail_tab" data-val="crInfo" onclick="productDetail(this);">취소/환불</div>
            </div>
            <div class="product_detailBbox">
                
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="productCode" value="<?=$_GET['productCode']?>">

<div class="share_popBox">
    <div class="share_listBox">
        <p class="share_list flex-vc-hl-container" id="kakaoShare" onclick="kakaoShare();"><img src="<?=$frontImgSrc?>/share_kakao.png" alt="카카오 공유하기">카카오톡으로 공유하기</p>
        <!-- <p class="share_list flex-vc-hl-container"><img src="<?=$frontImgSrc?>/share_insta.png" alt="인스타그램 공유하기">인스타그램으로 공유하기</p> -->
        <p class="share_list flex-vc-hl-container" onclick="linkCopy();"><img src="<?=$frontImgSrc?>/share_link.png" alt="링크 복사하기">링크 복사하기</p>
    </div>
    <p class="share_bg" onclick="shareClose();"></p>
</div>

<div class="productQna_box">
    <div class="productQna_textArea">
        <p class="productQna_tit">문의내용</p>
        <div class="productQna_textCon">
            <textarea name="productQnaDescription" id="productQnaDescription" placeholder="문의내용을 입력하세요."></textarea>
        </div>
        <div class="productQna_info">
            <ul>
                <li>- 배송,결제,교환/반품 문의는 고객센터로 문의 바랍니다.</li>
                <li>- 상품과 관련 없거나 부적합한 내용을 기재하시는 경우, 사전 고지 없이 삭제 또는 차단될 수 있습니다.</li>
            </ul>
        </div>
        <p class="mainColor_btn flex-vc-hc-container" onclick="productQnaReg();">등록하기</p>
        <div class="small_close_btn productQna_close_btn" onclick="closeProductQna();">
            <span></span>
            <span></span>
        </div>
    </div>
    <p class="productQna_bg"></p>
</div>

<script>

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/productController",
        global: false,
        data: {
            "page": "product",
            "act": "view",
            "productCode": $(".productCode").val()
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            //상품 썸네일
            $(".product_thumb img").prop("src", adminImgSrc + "/" + data[1]['fileName']);

            // 상품명
            $(".product_tit").text(data[1]["title"]);

            // 정가
            $(".product_orginPrice").text(comma(data[1]['price']) + "원");

            // 판매가
            let productPrice = data[1]['price'] - Math.round(data[1]['price'] * (data[1]['discountPercent'] / 100) / 100) * 100;

            $(".product_discountPrice").text(comma(productPrice) + "원");

            // 판매가 퍼센트
            $(".product_discountPercent").text(data[1]['discountPercent'] + "%");

            if (data[1]['discountPercent'] > 0) {

                $(".product_discountYn").css({

                    display : "flex"

                });

            };

            // 회원등급별 데이터
            let memberLevel = "<?=$config['memberLevel']?>";

            let memberLevelArr = memberLevel.split("◈");

            var memberLevelIdx = 0;

            for (ml=0; ml < memberLevelArr.length; ml++) {

                if (memberLevelArr[ml] == data[3]['level']) {

                    memberLevelIdx = ml

                }

            }

            // 최대 적립금
            if (data[3] == "nonMember") { // 상품에 포인트가 따로 없을때 비회원 포인트 체크

                $(".product_maxPoint").html("<span style='color: var(--mainColor); font-weight: var(--baseFontExtraBold);'>회원가입하고 적립금을 받으세요!</span>");

            } else if (data[1]['pointPercent'] > 0) { // 상품에 포인트가 따로 정해져 있을때

                var point = comma(Math.round(productPrice * data[1]['pointPercent'] + parseInt(<?=$config['videoReviewPoint']?>)));

                $(".product_maxPoint").text(comma(point) + "원 적립");

            } else { // 상품에 포인트가 따로 없을때 회원등급별 포인트 체크

                let configMemberLevelPoint = "<?=$config['memberLevelPoint']?>";

                let memberLevelPoint = configMemberLevelPoint.split("◈");

                var point = comma(Math.round(productPrice * (memberLevelPoint[memberLevelIdx] / 100)) + parseInt(<?=$config['videoReviewPoint']?>));

                $(".product_maxPoint").text(comma(point) + "원 적립");

            }

            // 배송비
            $(".product_deliveryPrice").text(comma(<?=$config['deliveryPrice']?>)+ "원");

            // 상품 옵션
            let productOption = "";
            let productIntiPrice = "";

            // 옵션이 있을때
            if (data[2].length > 0) {

                productOption += "<div class='product_optionBox'><div class='selectbox'><p class='selectbox_tit flex-vc-hl-container' onclick='selectboxOpen(this);'><span class='selectbox_text'>상품옵션선택</span><span class='select_arrow'></span></p><ul class='selectbox_depth'>";

                for (oc=0; oc < data[2].length; oc++){

                    if(data[2][oc]['stock'] == 0){ // 품절
                
                        productOption += "<li class='flex-vc-hl-container' id='soldOut' onclick=\"cmAlert('품절된 상품입니다.');\">" + data[2][oc]['title'] + " (품절)</li>";
            
                    }else{ // 정상

                        productOption += "<li class='flex-vc-hl-container' onclick='optionProductAdd(this); selectboxClick(this);'><input type='hidden' class='option_idx' value='" + data[2][oc]['idx'] + "'><input type='hidden' class='option_backprice' value='" + data[2][oc]['price'] + "'><input type='hidden' name='stock' class='stock' value='" + data[2][oc]['stock'] + "'><div class='optionList_titBox'><p class='optionList_tit'>" + data[2][oc]['title'] + "</p><p class='optionList_price'>" + comma(data[2][oc]['price']) + "원</p></div></li>";

                    }

                }

                productOption += "</ul></div></div><div class='option_listbox'></div>";

                productIntiPrice += "<input type='button' class='total_price' name='total_price' value='0'> <span>원</span>";

            } else { // 옵션이 없을때

                productOption += "<div class='option_listbox'><div class='option_list optionOne_list'><div class='option_infobox product_brieflist flex-vc-hl-container'><div class='product_brieftit'>수량</div><div class='option_pricecount'><p class='option_qty'><input type='button' class='qty_pm qty_minus' name='qtyMinus' onclick='optionQtyMinus(this)'><input type='text' class='qty' onchange='optionQtyMultiply(this)' value='1'><input type='button' class='qty_pm qty_plus' name='qtyPlus' onclick='optionQtyPlus(this)'></p><input type='hidden' class='option_price' value='" + productPrice + "'><input type='hidden' name='option_backprice' class='option_backprice' value='" + productPrice + "'></div><div class='cart_info'><input type='hidden' name='stock' class='stock' value='" + data[1]['stock'] + "'><input type='hidden' name='qty' class='qty' value='1'><input type='hidden' name='optionIdx' class='optionIdx' value='0'></div></div></div></div>";

                productIntiPrice += "<input type='button' class='total_price' name='total_price' value='" + comma(productPrice) + "'> <span>원</span>";

            }

            $("#productOptionBox").html(productOption);
            $(".product_totalprice").html(productIntiPrice);

            if ($(".device").val() == "pc") {

                // PC 상품 상세
                $(".product_detailBbox").html("<div class='productview_descbox'><pre>" + data[1]['pcDescription'] + "</pre></div>");

            } else {

                // 모바일 상품 상세
                $(".product_detailBbox").html("<div class='productview_descbox'><pre>" + data[1]['mobileDescription'] + "</pre></div>");

            }

            // 좋아요 체크
            let wishCheck = 0;

            if (data[4].length > 0) { // 좋아요가 있을때

                for ($wc=0; $wc < data[4].length; $wc++) {

                    if (data[4][$wc]['productCode'] == $(".productCode").val()) {

                        $(".wish_click").addClass("active");

                        wishCheck++;

                    }

                }

            }

            let wishAni = bodymovin.loadAnimation({
                container: $(".wish_click")[0],
                renderer: 'svg',
                loop: false,
                autoplay: false,
                path: frontImgSrc + "/wish.json"
            });

            if (wishCheck > 0) {
    
                wishAni.goToAndStop(142, true);

            } else {

                wishAni.goToAndStop(41, true);

            }

            // 후기
            let reviewStar = data[1]['reviewStar'] / data[1]['reviewCount'];

            $(".reviewStar_active").css({

                width : reviewStar + "%"

            });

            // 후기 개수
            $(".productdetail_tab[data-val='review']").text("후기 (" + data[5].length + ")");

            // 상품문의 개수
            $(".productdetail_tab[data-val='qna']").text("문의 (" + data[6].length + ")");

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

    function productDetail (object, actType) {

        // 초기화
        $(".product_detailBbox").html("");

        $(".productdetail_tab").removeClass("productdetail_tabactive");
        $(object).addClass("productdetail_tabactive");

        if (!actType) {

            var type = $(object).data("val");
            $(object).addClass("productdetail_tabactive");

        } else {

            var type = actType;
            $(".productdetail_tab[data-val='" + actType + "']").addClass("productdetail_tabactive");

        }

        if (type == "detail") {

            $.ajax({
                type: "POST", 
                dataType: "json",
                async: true,
                url: "/front/controller/productController",
                global: false,
                data: {
                    "page": "product",
                    "act": "view",
                    "productCode": $(".productCode").val()
                },
                traditional: true,
                beforeSend:function(xhr){
                },
                success:function(data){

                    // console.log(data);

                    if ($(".device").val() == "pc") {

                        // PC 상품 상세
                        $(".product_detailBbox").html("<div class='productview_descbox'><pre>" + data[1]['pcDescription'] + "</pre></div>");

                    } else {

                        // 모바일 상품 상세
                        $(".product_detailBbox").html("<div class='productview_descbox'><pre>" + data[1]['mobileDescription'] + "</pre></div>");

                    }

                },
                error:function(request,status,error){

                    console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                    
                }
                
            });

        } else if (type == "review") {

            $.ajax({
                type: "POST", 
                dataType: "json",
                async: true,
                url: "/front/controller/mypageController",
                global: false,
                data: {
                    "page": "mypage",
                    "act": "productReviewList",
                    "productCode": $(".productCode").val()
                },
                traditional: true,
                beforeSend:function(xhr){
                },
                success:function(data){

                    // console.log(data);

                    let contentsList = "";

                    if (data[1].length > 0) {

                        // 후기 개수
                        $(".productdetail_tab[data-val='review']").text("후기 (" + data[1].length + ")");

                        for(cl=0; cl < data[1].length; cl++) {

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

                            // 아이디
                            let userId = data[2][cl]['id'].slice(0, 3) + "****";

                            contentsList += "<div class='ordered_list review_list board_postList'><ul class='ordered_list_top flex-vc-hsb-container'><li>" + userId + "</li><li class='review_star'><img src='<?=$frontImgSrc?>/reviewStar.png' alt='후기별점'><span class='reviewStar_active' style='width: " + data[1][cl]['reviewStar'] + "%;'><img src='<?=$frontImgSrc?>/reviewStar_active.png' alt='후기별점'></span></li></ul><div class='review_product_listBox'><div class='review_product_list'>" + reviewFile + "<ul><li class='review_optionTitle'>" + data[1][cl]['optionTitle'] + "</li><li class='review_description'><pre style='white-space: pre-wrap;'>" + data[1][cl]['reviewDescription'] + "</pre></li><li class='review_bottom flex-vc-hsb-container'><p>" + reviewDate + "</p><!-- <p class=''>신고하기</p> --></li></ul></div></div></div><div id='reviewPopup' class='review_popup'><div class='reviewPopup_desc'>" + reviewPopFile + "</div><p class='reviewPopup_bg' onclick='reviewPopClose();'></p></div>";

                        }

                    } else {

                        contentsList += "<p class='empty_tit'>등록된 구매후기가 없습니다.</p>";

                    }

                    $(".product_detailBbox").append(contentsList);

                },
                error:function(request,status,error){

                    console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                    
                }
                
            });

        } else if (type == "qna") {

            $.ajax({
                type: "POST", 
                dataType: "json",
                async: true,
                url: "/front/controller/mypageController",
                global: false,
                data: {
                    "page": "mypage",
                    "act": "productQnaList",
                    "productCode": $(".productCode").val()
                },
                traditional: true,
                beforeSend:function(xhr){
                },
                success:function(data){

                    // console.log(data);

                    // 상품문의 개수
                    $(".productdetail_tab[data-val='qna']").text("문의 (" + data[1].length + ")");

                    let contentsList = "<div class='flex-vc-hr-container'><div class='productQna_btn mainColor_btn flex-vc-hc-container' onclick='showProductQna();'>문의하기</div></div><div class='product_qna flex-vc-hsb-container'>";

                    if (data[1].length > 0) {

                        for(cl=0; cl < data[1].length; cl++) {

                            // 아이디
                            let userId = data[1][cl]['id'].slice(0, 3) + "****";

                            contentsList += "<div class='faq_box updownSlide_box'><div class='faq_question productFaq_question updownSlide_title flex-vc-hsb-container' onclick='updownSlide(this);'><div class='faq_questionDesc flex-vt-hl-container'><span class='faqQuestion_icon flex-vc-hc-container'>Q</span><pre>" + data[1][cl]['description'] + "</pre></div><p>" + userId + "</p></div><div class='faq_answer updownSlide_desc'>상품 배송 기간은 배송 유형에 따라 출고 일자 차이가 있습니다. 자세한 사항은 구매하신 상품의 상세 페이지에서 확인 가능합니다.</div></div>";

                        }

                        contentsList += "</div>";

                    } else {

                        contentsList += "<p class='empty_tit'>등록된 문의가 없습니다.</p>";

                    }

                    $(".product_detailBbox").append(contentsList);

                },
                error:function(request,status,error){

                    console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                    
                }
                
            });

        } else if (type == "crInfo") {

            var contents = "<div class='productview_descbox'><h2 class='cr_tit'>취소/교환/반품 안내</h2><ul class='cr_list'><li>취소</li><li>· 입금하신 상품은 '입금대기, 입금완료' 단계에서만 취소가 가능합니다. <br>· 주문취소는 '마이페이지 > 주문조회 > 주문취소'를 통해 직접 취소하실 수 있습니다.</li></ul><ul class='cr_list'><li>교환/반품</li><li>· 교환 및 반품은 배송완료일 기준으로 7일 이내 가능합니다. <br>· 교환하려는 상품은 처음 배송한 택배사에서 수거하므로 다른 택배사 이용은 불가능합니다. <br>· 업체배송 상품은 제공 업체와 상품에 따라 배송비가 다르고, 상품의 도착지가 처음 발송한 주소와 다를 수 있으므로 고객센터(<?=$config['companyCall']?>)로 먼저 연락주시기 바랍니다.</li></ul><ul class='cr_list'><li>교환/반품이 불가능한 경우</li><li>· 주문제작 상품으로 재판매가 불가능한 경우 <br>· 포장이 훼손되어 상품 가치가 감소한 경우 <br>· 상품을 사용한 경우 <br>· 고객님의 부주의로 인한 파손/고장/오염으로 재판매가 불가능한 경우</li></ul><ul class='cr_list'><li>교환/반품 배송비</li><li>· 단순변심으로 인한 교환/반품은 고객님께서 배송비를 부담하셔야 합니다. <br>· 상품의 불량 또는 파손, 오배송의 경우에는 멍반생에서 배송비를 부담합니다. <br>· 제주, 도서산간 지역은 추가 배송비가 발생할 수 있습니다.</li></ul></div>";

            $(".product_detailBbox").append(contents);

        }

    }

    function showProductQna() {

        if ($(".login_id").val() == "") {

            cmConfirmAlert("로그인이 필요한 서비스입니다.", "로그인 하기", "취소하기", "", "/login");

        } else {

            $(".productQna_box").fadeIn();

        }

    }

    function closeProductQna() {

        $(".productQna_box").fadeOut();

    }

    function productQnaReg() {

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/front/controller/mypageController",
            global: false,
            data: {
                "page": "mypage",
                "act": "productQnaReg",
                "productCode": $(".productCode").val(),
                "productQnaDescription": $("#productQnaDescription").val()
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                if (data == "success") {

                    closeProductQna();

                    productDetail(this, "qna");

                }

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

</script>

<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/footer.php"; // 푸터
    
?>	