<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/header.php"; // 헤더

?>
<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <ul class="board_titBox flex-vc-hsb-container">
                <li>찜한 상품</li>
                <li>전체 <span class="wish_count board_strong"></span>개</li>
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

    setCookie("load", "wish");

    setCookie("page", 0);

    $(".limitStart").val(0);

    $(".limitStart").val(getCookie("page"));

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/orderController",
        global: false,
        data: {
            "page": "wish",
            "act": "view"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            if (data[0] == "success") {

                $(".wish_count").text(data[1].length);

                let productListbox = "";
                let openClass = "";

                const rgb = hexToRgb('<?=$config['mainColor']?>');
                const color = new Color(rgb[0], rgb[1], rgb[2]);
                const solver = new Solver(color);
                const result = solver.solve();

                if (data[1].length > 0) {

                    for (wl=0; wl < data[1].length; wl++) {

                        if (wl == $("#boardOpenNum").val()) {

                            openClass = "boardOpen";

                        }


                        let wishList = "";
                        let productPrice = comma(data[2][wl]['price'] - Math.round(data[2][wl]['price'] * (data[2][wl]['discountPercent'] / 100) / 100) * 100);
                        let reviewStar = data[2][wl]['reviewStar'] / data[2][wl]['reviewCount'];
                        let originPrice = "";

                        productListbox += "<div class='boardGallary_list " + openClass + "'><div class='boardGallary_listCon'>";

                        if (data[2][wl]['status'] == 400) { // 품절 일때

                            wishList += "<a href='#void'><div class='boardGallary_thumnail'><p class='soldOut flex-vc-hc-container'>품절 되었습니다.</p><img src='" + adminImgSrc + "/" + data[2][wl]['fileName'] + "' alt='제품이미지'></div><ul class='boardGallary_descList'><li>" + data[2][wl]['title'] + "</li><li class='price_box'><span class='last_price'>" + productPrice + "원</span>" + originPrice + "</li><li class='review_star'><img src='" + frontImgSrc + "/reviewStar.png' alt='후기별점'><span class='reviewStar_active' style='width: " + reviewStar + "%;'><img src='" + frontImgSrc + "/reviewStar_active.png' alt='후기별점'></span></li></ul></a>";

                        } else if (data[2][wl]['status'] == 300) { // 일시품절 일때

                            wishList += "<a href='#void'><div class='boardGallary_thumnail'><p class='soldOut flex-vc-hc-container'>재입고 예정입니다.</p><img src='" + adminImgSrc + "/" + data[2][wl]['fileName'] + "' alt='제품이미지'></div><ul class='boardGallary_descList'><li>" + data[2][wl]['title'] + "</li><li class='price_box'><span class='last_price'>" + productPrice + "원</span>" + originPrice + "</li><li class='review_star'><img src='" + frontImgSrc + "/reviewStar.png' alt='후기별점'><span class='reviewStar_active' style='width: " + reviewStar + "%;'><img src='" + frontImgSrc + "/reviewStar_active.png' alt='후기별점'></span></li></ul></a>";

                        } else { // 정상 일때

                            wishList += "<a href='/view?productCode=" + data[1][wl]['productCode'] + "'><div class='boardGallary_thumnail'><img src='" + adminImgSrc + "/" + data[2][wl]['fileName'] + "' alt='제품이미지'></div><ul class='boardGallary_descList'><li>" + data[2][wl]['title'] + "</li><li class='price_box'><span class='last_price'>" + productPrice + "원</span>" + originPrice + "</li><li class='review_star'><img src='" + frontImgSrc + "/reviewStar.png' alt='후기별점'><span class='reviewStar_active' style='width: " + reviewStar + "%;'><img src='" + frontImgSrc + "/reviewStar_active.png' alt='후기별점'></span></li></ul></a>";

                        }

                        productListbox += wishList;

                        productListbox += "</div></div>";

                    }

                    $("#boardConBox").append(productListbox);

                } else {

                    let emptyContent = "<div class='flex-vc-hc-container'><div class='emptyWish_box'><lottie-player src='<?=$frontImgSrc?>/emptyWish.json' background='transparent' style='width: 100%; height: 100%;' speed='1' loop autoplay></lottie-player><p class='emptyWish_tit'>찜한 상품이 없습니다.</p></div></div>";

                    $(".sub_container").html(emptyContent);

                }

            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

    // boardListAjax("<?=$nowPageName?>");

    if($('body').width() < 480){

        var reviewStar_percent = $(".reviewStar_active").width();

    }

</script>

<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/footer.php"; // 푸터
    
?>	