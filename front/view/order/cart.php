<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/header.php"; // 헤더

?>
<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <ul class="board_titBox cart_titBox flex-vc-hsb-container">
                <li>장바구니</li>
                <li>전체 <span class="cart_count board_strong"></span>개</li>
            </ul>
            <form name="orderForm" id="orderForm" action="/order/order_sheet" method="post" enctype="multipart/form-data">
                <input type="hidden" class="deliveryMinPrice" value="">
                <input type="hidden" class="deliveryPrice" value="<?=$config['deliveryPrice']?>">
                <div class="sub_container subCart_container">
                    <ul class="cartGallary_listBox">
                        
                    </ul>
                    <div class="cart_priceListBox flex-vc-hc-container">
                        <ul class="cart_priceList">
                            <li>상품금액</li>
                            <li><span class="cart_productPrice"></span>원</li>
                        </ul>
                        <ul class="cart_priceList">
                            <li>배송비</li>
                            <li>
                                <span class="cart_deleveryPrice"></span>원
                            </li>
                        </ul>
                        <ul class="cart_priceList">
                            <li>총 결제금액</li>
                            <li class="cart_lastPrice flex-vc-hc-container">
                                <input type="button" class="total_price" name="total_price" value="<?=number_format($totalOriginPrice - $totalDiscountPrice + $deliveryPrice)?>">원
                            </li>
                        </ul>
                    </div>
                    <div class="cart_btnbox flex-vc-hsb-container">
                        <input type="button" name="" class="product_btn product_btn1 cart_send" value="계속쇼핑하기" onclick="location.href='/index'">
                        <input type="button" name="" class="product_btn product_btn2" value="구매하기" onclick="gnbLoad('orderSheet'); cartOrder(this, 'orderSheet');">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    setCookie("load", "cart");

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/orderController",
        global: false,
        data: {
            "page": "cart",
            "act": "view"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            if (data[0] == "success") {

                $(".cart_count").text(data[1].length);

                if (data[1].length > 0) {

                    let cartList = "";
                    let cartProductPrice = 0;

                    for (cl=0; cl < data[1].length; cl++) {

                        let discountPrice = Math.round(data[2][cl]['price'] * (data[2][cl]['discountPercent'] / 100) / 100) * 100;

                        if (data[3][cl] == null) { // 옵션 없는 상품

                            var cartInfo = data[2];

                            var originPrice = cartInfo[cl]['price'];
                            var discountedPrice = cartInfo[cl]['price'] - discountPrice;
                            var totalCartPrice = discountedPrice * data[1][cl]['qty'];

                            var optionTitle = "";
                            var optionEachPrice = discountedPrice;
                            var stock = cartInfo[cl]['stock'];

                        } else { // 옵션 있는 상품

                            var cartInfo = data[3];

                            var originPrice = cartInfo[cl]['price'];
                            var discountedPrice = originPrice;
                            var totalCartPrice = cartInfo[cl]['price'] * data[1][cl]['qty'];

                            var optionTitle = cartInfo[cl]['title'];
                            var optionEachPrice = cartInfo[cl]['price'];
                            var stock = cartInfo[cl]['stock'];

                        }

                        if (cartInfo[cl]['stock'] == 0) {

                            var stockChecked = "disabled";

                            var qtyPm = "<input type='button' class='qty_pm qty_minus' name='qtyMinus'><input type='text' class='qty' value='0' readonly><input type='button' class='qty_pm qty_plus' name='qtyPlus'>";

                            var discountedPrice = 0;

                            var optionPrice = "품절";

                        } else {

                            var stockChecked = "checked";

                            var qtyPm = "<input type='button' class='qty_pm qty_minus' name='qtyMinus' onclick=\"optionQtyMinus(this, 'cart')\"><input type='text' class='qty' onchange=\"optionQtyMultiply(this, 'cart')\" value='" + data[1][cl]['qty'] + "'><input type='button' class='qty_pm qty_plus' name='qtyPlus' onclick=\"optionQtyPlus(this, 'cart')\">";

                            var optionPrice = "<span class='option_price'>" + comma(totalCartPrice) + "</span>원";

                            cartProductPrice += parseInt(optionEachPrice * data[1][cl]['qty']);

                        }

                        cartList += "<li class='cartGallary_list pc_cartGallary_list cartDelList" + cl + "' data-val='" + cl + "'><div class='option_list'><div class='option_infobox flex-vc-hl-container'><div class='cart_checkbox'><input type='checkbox' name='cartItem' class='cart_item_checkbox' id='cartItem" + cl + "' onclick='cartCheckbox(this);' " + stockChecked + "><label for='cartItem" + cl + "'><p class='vb_designCheck'><span class='vb_designChecked'></span></p></label></div><div class='option_thumbBox'><a href='/view?productCode=" + data[1][cl]['productCode'] + "' class='option_thumb'><img src='" + adminImgSrc + "/" + data[2][cl]['fileName'] + "' alt='제품 썸네일'></a></div><div class='option_titbox'><a href='/view?productCode=" + data[1][cl]['productCode'] + "'><p class='product_tit'>" + data[2][cl]['title'] + "</p><p class='option_tit'>" + optionTitle + "</p><p class='option_eq_price'>" + comma(optionEachPrice) + "원</p></a><p class='option_qty'>" + qtyPm + "</p><p class='option_pricebox'>" + optionPrice + "</p><p class='option_del' onclick=\"optionProductDel(this, 'cart');\"><img src='" + frontImgSrc + "/option_del.png'></p></div><div class='cart_hiddenBox'><input type='hidden' name='option_backprice' class='option_backprice' value='" + discountedPrice + "'><input type='hidden' name='option_standardPrice' class='option_standardPrice' value='" + originPrice + "'><input type='hidden' name='stock' class='stock' value='" + stock + "'><input type='hidden' name='qty' class='qty' value='" + data[1][cl]['qty'] + "'><input type='hidden' class='cartNum' value='" + data[1][cl]['idx'] + "'><input type='hidden' class='productCode' value='<?=$productCode?>'><input type='hidden' class='optionIdx' value='<?=$optionIdx?>'></div></div></div></li>";

                    }

                    $(".cartGallary_listBox").append(cartList);

                    // 상품금액
                    $(".cart_productPrice").text(comma(cartProductPrice));

                    // 배송비
                    if (data[4] == "nonMember") { // 비회원

                        $(".deliveryMinPrice").val("<?=$config['deliveryMinPrice']?>");

                        if (cartProductPrice >= $(".deliveryMinPrice").val()) { // 무료배송 최소금액 이상일때

                            $(".cart_deleveryPrice").text("0");

                            var deliveryPrice = 0;

                        } else {

                            $(".cart_deleveryPrice").text(comma(parseInt($(".deliveryPrice").val())));

                            var deliveryPrice = $(".deliveryPrice").val();

                        }

                    } else { // 회원

                        // 회원등급별 무료배송 최소금액 조회
                        let deliveryMinPriceArr = "<?=$config['memberLevelDeliveryMinPrice']?>";
                        let memberLevelArr = "<?=$config['memberLevel']?>";

                        let deliveryMinPrice = deliveryMinPriceArr.split("◈");
                        let memberLevel = memberLevelArr.split("◈");

                        for (dmp=0; dmp < deliveryMinPrice.length; dmp++) {

                            if (memberLevel[dmp] == data[4]['level']) {

                                $(".deliveryMinPrice").val(deliveryMinPrice[dmp]);

                                break;

                            }

                        }

                        if (cartProductPrice >= $(".deliveryMinPrice").val()) { // 무료배송 최소금액 이상일때

                            $(".cart_deleveryPrice").text("0");

                            var deliveryPrice = 0;

                        } else {

                            $(".cart_deleveryPrice").text(comma(parseInt($(".deliveryPrice").val())));

                            var deliveryPrice = $(".deliveryPrice").val();

                        }

                    }

                    // 총 결제금액
                    $(".total_price").val(comma(parseInt(cartProductPrice) + parseInt(deliveryPrice)));

                } else {

                    let emptyContent = "<div class='flex-vc-hc-container'><div class='emptyCart_box'><lottie-player src='<?=$frontImgSrc?>/emptyCart.json' background='transparent' style='width: 100%; height: 100%;' speed='1' loop autoplay></lottie-player><p class='emptyCart_tit'>장바구니에 담긴 상품이 없습니다.</p></div></div>";

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