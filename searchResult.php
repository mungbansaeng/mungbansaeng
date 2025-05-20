<?

    include_once dirname(__FILE__)."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <ul class="board_titBox flex-vc-hsb-container">
                <li>검색 결과</li>
                <li>전체 <span class="product_count board_strong"></span>개</li>
            </ul>
            <div class="sub_container">
                <input type="hidden" id="page" value="">
                <input type="hidden" id="boardOpenNum" value="4">
                <!-- <input type="hidden" id="boardAct" value="<?=$frontSrc?>/board/productList.php">
                <input type="hidden" id="categoryIdx" value="">
                <input type="hidden" id="loading" value="0">
                <input type="hidden" id="limitStart" value="0">
                <input type="hidden" id="showBoardNum" value="9">
                <input type="hidden" id="totalBoardCount" value=""> -->
                <div id="boardPostListBox" class="ordered_listBox">
                    <div id="boardConBox" class="boardGallary_listBox flex-vc-hl-container">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/commonController.php",
        global: false,
        data: {
            "page": "search",
            "act": "productSearch",
            "searchWord": "<?=$_GET['searchWord']?>"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            if (data[0] == "success") {

                $(".product_count").text(data[1]['totalCount']);

                let productListbox = "";

                if (data[1]['totalCount'] > 0) {
                    let openClass = "";

                    for (pl=0; pl < data[2].length; pl++) {

                        if (pl == $("#boardOpenNum").val()) {

                            openClass = "boardOpen";

                        }

                        let productList = "";
                        let productPrice = comma(data[2][pl]['price'] - Math.round(data[2][pl]['price'] * (data[2][pl]['discountPercent'] / 100) / 100) * 100);
                        let reviewStar = data[2][pl]['reviewStar'] / data[2][pl]['reviewCount'];
                        let originPrice = "";

                        if (data[2][pl]['discountPercent'] > 0) {

                            originPrice = "<span class='origin_price'>" + comma(data[2][pl]['price']) + "원</span><span class='discount_percent'>" + data[2][pl]['discountPercent'] + "%</span>";

                        }

                        productListbox += "<div class='boardGallary_list " + openClass + "'><div class='boardGallary_listCon'>";

                        if (data[2][pl]['status'] == 400) { // 품절 일때

                            productList += "<a href='#void'><div class='boardGallary_thumnail'><p class='soldOut flex-vc-hc-container'>품절 되었습니다.</p><img src='" + adminImgSrc + "/" + data[2][pl]['fileName'] + "' alt='제품이미지'></div><ul class='boardGallary_descList'><li>" + data[2][pl]['title'] + "</li><li class='price_box'><span class='last_price'>" + productPrice + "원</span>" + originPrice + "</li><li class='review_star'><img src='" + frontImgSrc + "/reviewStar.png' alt='후기별점'><span class='reviewStar_active' style='width: " + reviewStar + "%;'><img src='" + frontImgSrc + "/reviewStar_active.png' alt='후기별점'></span></li></ul></a>";

                        } else if (data[2][pl]['status'] == 300) { // 일시품절 일때

                            productList += "<a href='#void'><div class='boardGallary_thumnail'><p class='soldOut flex-vc-hc-container'>재입고 예정입니다.</p><img src='" + adminImgSrc + "/" + data[2][pl]['fileName'] + "' alt='제품이미지'></div><ul class='boardGallary_descList'><li>" + data[2][pl]['title'] + "</li><li class='price_box'><span class='last_price'>" + productPrice + "원</span>" + originPrice + "</li><li class='review_star'><img src='" + frontImgSrc + "/reviewStar.png' alt='후기별점'><span class='reviewStar_active' style='width: " + reviewStar + "%;'><img src='" + frontImgSrc + "/reviewStar_active.png' alt='후기별점'></span></li></ul></a>";

                        } else { // 정상 일때

                            productList += "<a href='/view?productCode=" + data[2][pl]['productCode'] + "'><div class='boardGallary_thumnail'><img src='" + adminImgSrc + "/" + data[2][pl]['fileName'] + "' alt='제품이미지'></div><ul class='boardGallary_descList'><li>" + data[2][pl]['title'] + "</li><li class='price_box'><span class='last_price'>" + productPrice + "원</span>" + originPrice + "</li><li class='review_star'><img src='" + frontImgSrc + "/reviewStar.png' alt='후기별점'><span class='reviewStar_active' style='width: " + reviewStar + "%;'><img src='" + frontImgSrc + "/reviewStar_active.png' alt='후기별점'></span></li></ul></a>";

                        }

                        productListbox += productList;

                        productListbox += "</div></div>";

                    }
                } else {

                    productListbox = "<div class='flex-vc-hc-container' style='margin: 0 auto;'><div class='empty_box'><lottie-player src='<?=$frontImgSrc?>/emptySearch.json' background='transparent' style='width: 100%; height: 100%;' speed='1' loop autoplay></lottie-player><p class='empty_tit'>검색된 상품이 없습니다.</p></div></div>";

                }

                $("#boardConBox").append(productListbox);

            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

</script>

<?

    include_once dirname(__FILE__)."/front/view/layouts/footer.php"; // 푸터
    
?>	