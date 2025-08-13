<div class="sub_container">
    <input type="hidden" id="limitStart" value="0">
    <input type="hidden" id="showNum" value="10">
    <input type="hidden" id="boardOpenNum" value="4">
    <input type="hidden" id="totalBoardCount" value="">
    <div id="boardPostListBox" class="mypage_marginBox">
        <div id="boardConBox" class="boardGallary_listBox">
            
        </div>
    </div>
</div>

<script>

    gnbLoad('orderList');

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/mypageController",
        global: false,
        data: {
            "page": "mypage",
            "act": "orderList",
            "limitStart": $("#limitStart").val(),
            "showNum": $("#showNum").val(),
            "orderNo": "<?=$_GET['orderNo']?>"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            $("#totalBoardCount").val(data[1].length);

            let orderList = "";
            let openClass = "";

            // 주문정보
            if (data[1].length > 0) {

                for (ol=0; ol < data[1].length; ol++) {

                    let orderProductList = "";
                    let orderCancelBtn = "";
                    let orderCancelCount = 0;

                    if (ol == $("#boardOpenNum").val()) {

                        openClass = "boardOpen";

                    }

                    let orderDate = data[1][ol]['date'].substr(0, 10);

                    // 상품 정보
                    for (opl=0; opl < data[2][ol].length; opl++) {

                        let dlvBtn = "";

                        let discountedPrice = data[2][ol][opl]['price'] - Math.round(data[2][ol][opl]['price'] * (data[2][ol][opl]['discountPercent'] / 100) / 100) * 100;

                        let status = "<span>" + data[2][ol][opl]['status'] + "</span>";

                        // 주문상태
                        if (data[2][ol][opl]['statusNum'] > 3) {

                            orderCancelCount++;

                        }

                        // 배송조회 버튼
                        if(data[2][ol][opl]['statusNum'] > 3 && data[2][ol][opl]['statusNum'] < 5){

                            dlvBtn += "<li class='deliveryCheck_btn'><p class='deliveryCheck flex-vc-hc-container' onclick=\"deliveryCheck('" + data[2][ol][opl]['dlvCode'] + "');\">배송조회</p></li>";

                        } else if(data[2][ol][opl]['statusNum'] == 5){

                            dlvBtn += "<li class='deliveryCheck_btn'><p onclick=\"finishOrder(this, '" + data[1][ol]['orderNo'] + "');\">구매확정</p></li>";

                        } else if(data[2][ol][opl]['statusNum'] == 6){

                            dlvBtn += "<li class='deliveryCheck_btn'><p onclick=\"gnbLoad('reviewWrite'); window.location.href='/mypage?orderProductCode=" + data[2][ol][opl]['orderProductIdx'] + "';\">후기작성</p></li>";

                        }

                        orderProductList += "<div class='ordered_product_listBox'><div class='ordered_product_list flex-vc-hsb-container'><input type='hidden' class='orderProductIdx' value='" + data[2][ol][opl]['orderProductIdx'] + "'><p class='ordered_product_img' style=\"background-image: url('" + adminImgSrc + "/" + data[2][ol][opl]['fileName'] + "');\"></p><ul class='ordered_product_info1'><li>" + data[2][ol][opl]['title'] + "</li><li>" + data[2][ol][opl]['optionTitle'] + "</li><li>" + comma(discountedPrice) + "원 x " + data[2][ol][opl]['qty'] + "개</li></ul><ul class='ordered_product_info2'><li><p class='orderStatus'>" + status + "</p></li>" + dlvBtn + "</ul></div></div>";

                    }

                    if (orderCancelCount == 0) {

                        orderCancelBtn = "<p class='orderCancel flex-vc-hc-container' onclick=\"orderCancel(this, '" + data[1][ol]['orderNo'] + "');\">주문취소</p>";

                    }

                    orderList += "<div id='" + data[1][ol]['orderNo'] + "' class='ordered_list board_postList " + openClass + "'><input type='hidden' class='orderNo' value='" + data[1][ol]['orderNo'] + "'><ul class='ordered_list_top flex-vc-hsb-container'><li class='flex-vc-hl-container'><p><span>" + orderDate + "</span><span> / </span><span>" + data[1][ol]['orderNo'] + "</span></p>" + orderCancelBtn + "</li><li onclick=\"gnbLoad('orderDetail'); location.href='/mypage?orderNo=" + data[1][ol]['orderNo'] + "'\">주문 상세보기 ></li></ul>" + orderProductList + "</div>";

                }

                $("#boardConBox").append(orderList);

            } else {

                let emptyContent = "<div class='flex-vc-hc-container'><div class='empty_box'><lottie-player src='<?=$frontImgSrc?>/emptySearch.json' background='transparent' style='width: 100%; height: 100%;' speed='1' loop autoplay></lottie-player><p class='empty_tit'>아직 주문한 상품이 없습니다.</p></div></div>";

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