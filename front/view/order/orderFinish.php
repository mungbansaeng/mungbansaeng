<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w768">
            <div class="orderFinish_img">
                <lottie-player src="<?=$frontImgSrc?>/orderFinish.json" background="transparent" style="width: 100%; height: 100%;" speed="1" loop autoplay></lottie-player>
            </div>
            <ul class="orderFinish_textBox">
                <li><?=$config['companyName']?>을 믿고 주문해주셔서 감사합니다!</li>
                <li><?=$orderNameDesc?></li>
                <li>아래에서 주문 상세내역을 확인해주세요.</li>
            </ul>
            <ul class="orderFinish_infoBox">
                <li class="orderFinish_info flex-vc-hc-container">
                    <p class="flex-vc-hl-container">주문번호</p>
                    <p class="flex-vc-hl-container"><?=$_GET['orderNo']?></p>
                </li>
                <li class="orderFinish_info flex-vc-hc-container">
                    <p class="flex-vc-hl-container">총 결제금액</p>
                    <p class="flex-vc-hl-container"><span class="total_price"></span>원</p>
                </li>
                <li class="orderFinish_info flex-vc-hc-container">
                    <p class="flex-vc-hl-container">받는분</p>
                    <p class="flex-vc-hl-container buyer_name"></p>
                </li>
                <li class="orderFinish_info flex-vc-hc-container">
                    <p class="flex-vc-hl-container">받는 분 핸드폰 번호</p>
                    <p class="flex-vc-hl-container buyer_cell"></p>
                </li>
                <li class="orderFinish_info flex-vc-hc-container">
                    <p class="flex-vc-hl-container">받는분 주소</p>
                    <p class="flex-vc-hl-container buyer_address"></p>
                </li>
                <li class="orderFinish_info flex-vc-hc-container">
                    <p class="flex-vc-hl-container">배송시 요청사항</p>
                    <p class="flex-vc-hl-container dlv_memo"></p>
                </li>
            </ul>
            <div class="flex-vc-hsb-container">
                <input type="button" name="" class="product_btn product_btn1" value="계속쇼핑하기" onclick="location.href='/index'">
                <input type="button" name="" class="product_btn product_btn2" value="주문조회하기" onclick="gnbLoad('orderList'); location.href='/mypage'">
            </div>
        </div>
    </div>
</div>

<script>

    gnbLoad('orderFinish');

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/orderController",
        global: false,
        data: {
            "page": "order",
            "act": "orderFinish",
            "orderNo": "<?=$_GET['orderNo']?>"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            // 총 결제금액
            let payPrice = parseInt(data[1]['totalPrice']) + parseInt(data[1]['dlvPrice']) - parseInt(data[1]['usePointPrice']) - parseInt(data[1]['couponPrice']);

            $(".total_price").text(comma(payPrice));

            // 받는분
            $(".buyer_name").text(comma(data[1]['dlvName']));

            // 받는분 핸드폰번호
            let cellPhone = data[1]['dlvCell'].split("◈");

            $(".buyer_cell").text(cellPhone[0] + "-" + cellPhone[1] + "-" + cellPhone[2]);

            // 받는분 주소
            let dlvAddress = data[1]['dlvAddress'].split("◈");

            $(".buyer_address").text(dlvAddress[0] + " " + dlvAddress[1]);

            // 배송메세지
            $(".dlv_memo").text(data[1]['dlvMemo']);

            // 주문조회 회원/비회원 분기
            if (data[2] == "nonMember") {

                // onclick 수정
                $(".product_btn2").attr("onclick", "gnbLoad('nonMemberOrderSearch'); location.href='/mypage'");

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