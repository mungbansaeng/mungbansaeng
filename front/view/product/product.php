<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <ul class="board_titBox flex-vc-hsb-container">
                <li class="board_tit"></li>
                <li>전체 <span class="product_count board_strong"></span>개</li>
            </ul>
            <div class="sub_container">
                <input type="hidden" id="page" value="">
                <input type="hidden" id="limitStart" value="0"> <!-- 리미트 시작 -->
                <input type="hidden" id="limitEnd" value="12"> <!-- 게시물 출력 수 -->
                <input type="hidden" id="showNum" value="8"> <!-- 오픈되는 곳 시작 -->
                <input type="hidden" id="loading" value="0"> <!-- 함수가 진행중인지 아닌지 체크 -->
                <input type="hidden" id="totalBoardCount" value=""> <!-- 게시물 총 개수 -->
                <div id="boardPostListBox">
                    <div id="boardConBox" class="boardGallary_listBox flex-vc-hl-container">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(".board_tit").text($("#header .gnb .active").text());
    $("#categoryIdx").val($("#header .gnb .active").siblings(".categoryIdx").val());

    $(".limitStart").val(0);

    function viewList () {

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/front/controller/productController",
            global: false,
            data: {
                "page": $("#page").val(),
                "act": "list",
                "limitStart": $("#limitStart").val(),
                "limitEnd": $("#limitEnd").val(),
                "categoryIdx1": $(".one_depth.active").siblings(".categoryIdx").val(),
                "categoryIdx2": "",
                "categoryIdx3": ""
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                if (data[0] == "success") {

                    // if ($("#page").val() == "best") {

                    //     var totalCount = $("#limitEnd").val();

                    // } else {

                    //     var totalCount = data[1]['totalCount'];

                    // }

                    var totalCount = data[1]['totalCount'];

                    $(".product_count").text(totalCount);
                    $("#totalBoardCount").val(totalCount);

                    let productListbox = "";

                    for (pl=0; pl < data[2].length; pl++) {

                        let openClass = "";

                        if (pl == $("#showNum").val() - 1 && $("#page").val() !== "best") {

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

                    $("#boardConBox").append(productListbox);

                }

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    if($('body').width() < 480){

        var reviewStar_percent = $(".reviewStar_active").width();

    }

</script>

<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/footer.php"; // 푸터
    
?>	