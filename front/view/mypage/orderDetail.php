<div class="sub_container">
    <ul class="orderDetail_top flex-vc-hsb-container">
        <li>주문번호 : <?=$_GET['orderNo']?></li>
        <li><?=$orderDate?></li>
    </ul>
    <div class="orderDetail_list">
        
    </div>
    <div class="orderDetail_infoBox">
        <p class="orderDetail_tit">배송정보</p>
        <div class="orderDetail_infoList">
            <ul class="flex-vc-hl-container dlv_name">
                <li>이름</li>
                <li></li>
            </ul>
            <ul class="flex-vc-hl-container dlv_cell">
                <li>연락처</li>
                <li></li>
            </ul>
            <ul class="flex-vc-hl-container dlv_address">
                <li>주소</li>
                <li></li>
            </ul>
            <ul class="flex-vc-hl-container dlv_memo">
                <li>배송메세지</li>
                <li></li>
            </ul>
        </div>
    </div>
    <div class="orderDetail_infoBox">
        <p class="orderDetail_tit">결제금액</p>
        <div class="orderDetail_infoList">
            <ul class="flex-vc-hl-container order_price">
                <li>상품금액</li>
                <li><span></span>원</li>
            </ul>
            <ul class="flex-vc-hl-container order_couponPrice">
                <li>쿠폰 할인금액</li>
                <li><span></span>원 <? if($couponName){ ?>( <?=$couponName?> ) <?}?></li>
            </ul>
            <ul class="flex-vc-hl-container order_pointPrice">
                <li>포인트 할인금액</li>
                <li><span></span>원</li>
            </ul>
            <ul class="flex-vc-hl-container order_dlvPrice">
                <li>배송비</li>
                <li><span></span>원</li>
            </ul>
            <ul class="flex-vc-hl-container order_payPrice">
                <li>결제금액</li>
                <li><span></span>원</li>
            </ul>
        </div>
    </div>
    <div class="orderDetail_infoBox">
        <p class="orderDetail_tit">결제정보</p>
        <div class="orderDetail_infoList">
            <ul class="flex-vc-hl-container payType">
                <li>결제방법</li>
                <li></li>
            </ul>
            <ul class="flex-vc-hl-container bank">
                <li>입금은행</li>
                <li></li>
            </ul>
            <ul class="flex-vc-hl-container bankName">
                <li>입금자명</li>
                <li></li>
            </ul>
            <ul class="flex-vc-hl-container cashReceipts">
                <li>현금영수증 발행</li>
                <li></li>
            </ul>
            <ul class="flex-vc-hl-container payDate">
                <li>결제 완료일시</li>
                <li></li>
            </ul>
        </div>
    </div>
    <div class="flex-vc-hc-container back_btn"></div>
</div>

<script>
    
    var nonMemberorderSearch = getCookie('nonMemberorderSearch');

    if (nonMemberorderSearch == "Y") {

        gnbLoad("nonMemberorderDetail");

    } else {

        gnbLoad("orderDetail");

    }

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/mypageController",
        global: false,
        data: {
            "page": "mypage",
            "act": "orderDetail",
            "orderNo": "<?=$_GET['orderNo']?>"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            let orderProductList = "";

            for (opl=0; opl < data[1].length; opl++) {

                let dlvBtn = "";

                // 주문상태
                var status = "<span>" + data[1][opl]['status'] + "</span>";

                // 배송조회 버튼
                if(data[1][opl]['statusNum'] > 3 && data[1][opl]['statusNum'] < 5){

                    dlvBtn += "<div class='deliveryCheck_btn'><p class='deliveryCheck flex-vc-hc-container' onclick=\"deliveryCheck('" + data[2]['dlvCode'] + "');\">배송조회</p></div>";

                } else if(data[1][opl]['statusNum'] == 5){

                    dlvBtn += "<div class='deliveryCheck_btn'><p onclick='finishOrder(this, '<?=$_GET['orderNo']?>');'>구매확정</p></div>";

                } else if(data[1][opl]['statusNum'] == 6){

                    dlvBtn += "<div class='deliveryCheck_btn'><p onclick='location.href='/mypage/reviewWrite?productCode=" + data[1][opl]['productCode'] + "'>후기작성</p></div>";

                }

                orderProductList += "<a href='/view?productCode=" + data[1][opl]['productCode'] + "' class='option_thumb'><div class='order_list'><div class='oroder_infobox flex-vc-hsb-container'><div class='order_thumbBox'><img src='" + adminImgSrc + "/" + data[1][opl]['fileName'] + "' alt='제품 썸네일'></div><div class='order_titbox flex-vc-hsb-container'><div class='orderProduct_titBox'><p class='product_tit'>" + data[1][opl]['title'] + "</p><p class='option_tit'>" + data[1][opl]['optionTitle'] + "</p><p class='option_tit'>" + comma(data[1][opl]['price']) + "원 x " + data[1][opl]['qty'] + "개</p></div><div class='orderDetail_pricebox flex-vc-hr-container'><p class='option_price'>" + comma(data[1][opl]['price'] * data[1][opl]['qty']) + "원</p><div class='flex-vc-hr-container'><p class='option_status'>" + status + "</p>" + dlvBtn + "</div></div></div></div></div></a>";

            }

            $(".orderDetail_list").append(orderProductList);

            // 배송정보
            let dlvCell = data[2]['dlvCell'].split("◈");
            let dlvAddress = data[2]['dlvAddress'].split("◈");

            $(".dlv_name li:nth-child(2)").text(data[2]['dlvName']);
            $(".dlv_cell li:nth-child(2)").text(dlvCell[0] + "-" + dlvCell[1] + "-" + dlvCell[2]);
            $(".dlv_address li:nth-child(2)").text(dlvAddress[0] + " " + dlvAddress[1]);
            $(".dlv_memo li:nth-child(2)").text(data[2]['dlvMemo']);

            // 상품금액
            $(".order_price li:nth-child(2) span").text(comma(data[2]['totalPrice']));

            // 쿠폰 할인금액
            if (data[2]['couponPrice'] > 0) {

                var couponPrice = "-" + comma(data[2]['couponPrice']);

            } else {

                var couponPrice = 0;

            }

            $(".order_couponPrice li:nth-child(2) span").text(couponPrice);

            // 포인트 할인금액
            if (data[2]['usePointPrice'] > 0) {

                var usePointPrice = "-" + comma(data[2]['usePointPrice']);

            } else {

                var usePointPrice = 0;

            }

            $(".order_pointPrice li:nth-child(2) span").text(usePointPrice);

            // 배송비
            if (data[2]['dlvPrice'] > 0) {

                var dlvPrice = "+" + comma(data[2]['dlvPrice']);

            } else {

                var dlvPrice = 0;

            }

            $(".order_dlvPrice li:nth-child(2) span").text(dlvPrice);

            // 결제금액
            let payPrice = parseInt(data[2]['totalPrice']) - parseInt(data[2]['couponPrice']) - parseInt(data[2]['usePointPrice']) + parseInt(data[2]['dlvPrice']);

            $(".order_payPrice li:nth-child(2) span").text(comma(payPrice));

            // 결제정보

            // 결제방법
            $(".payType li:nth-child(2)").text(data[2]['payTypeName']);

            if (data[2]['payType'] == "bankpay") {

                // 입금은행
                $(".bank li:nth-child(2)").text(data[2]['bank']);

                // 입금자명
                $(".bankName li:nth-child(2)").text(data[2]['bankName']);

                if (data[2]['cashReceipts'] == "Y") {

                    var cashReceipts = "발행";

                } else {

                    var cashReceipts = "미발행";

                }

                // 현금영수증 발행 여부
                $(".cashReceipts li:nth-child(2)").text(cashReceipts);

            } else {

                $(".bank").remove();
                $(".bankName").remove();
                $(".cashReceipts").remove();

            }

            // 결제 완료일시
            if (data[2]['payType'] == "bankpay" && data[2]['payDate'] == "0000-00-00 00:00:00") {

                var payDate = data[2]['bankAccount'];

                $(".payDate li:nth-child(1)").text("입금 계좌번호");

            } else {

                var payDate = data[2]['payDate'].substr(0, 10);

            }

            $(".payDate li:nth-child(2)").text(payDate);

            // 돌아가기 버튼
            if (nonMemberorderSearch == "Y") {

                var backBtn = "<a href='#void' onclick=\"deleteCookie('nonMemberorderSearch'); location.href='/'\" class='one_lastBtn'>메인으로 이동하기</a>";

            } else {

                var backBtn = "<a href='#void' onclick=\"gnbLoad('orderList'); location.href='/mypage'\" class='one_lastBtn'>돌아가기</a>";

            }

            $(".back_btn").append(backBtn);

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

</script>

<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/footer.php"; // 푸터
    
?>	