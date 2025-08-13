<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/view/layouts/header.php"; // 헤더
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/admin/controller/productController.php";

?>
<div class="admin_container">
    <div class="admin_contentBox">
        <h3 class="admin_tit">상품 수정</h3>
        <form id="orderModifyForm" name="form">
            <input type="hidden" name="page" class="page" value="order">
            <input type="hidden" name="act" class="act" value="modifyView">
            <input type="hidden" name="orderNo" class="orderNo" value="<?=$_GET['orderNo']?>">
            <div class="admin_infobox flex-vc-hsb-container">
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">주문번호</span>
                    </div>
                    <div>
                        <input type="text" class="input_fullDesign orderNo" disabled>
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">주문일시</span>
                    </div>
                    <div>
                        <input type="text" class="input_fullDesign orderDate" disabled>
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">회원아이디</span>
                    </div>
                    <div>
                        <input type="text" class="input_fullDesign orderId" disabled>
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">받는분</span>
                    </div>
                    <div>
                        <input type="text" name="dlvName" class="input_fullDesign dlvName">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">받는분 핸드폰번호</span>
                    </div>
                    <div>
                        <input type="text" name="dlvCell" class="input_fullDesign dlvCell" maxLength="13">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">주문자 이메일</span>
                    </div>
                    <div>
                        <input type="text" name="buyerEmail" class="input_fullDesign buyerEmail">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">배송업체</span>
                    </div>
                    <div>
                        <input type="text" name="dlvCompany" class="input_fullDesign orderDlvCompany" value="로젠택배">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">운송장번호</span>
                    </div>
                    <div>
                        <input type="text" name="dlvCode" class="input_fullDesign orderDlvCode">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">받는분 주소</span>
                    </div>
                    <div>
                        <input type="text" name="dlvAddress1" class="input_fullDesign dlvAddress1">
                        <input type="hidden" name="dlvPostcode" class="input_fullDesign dlvPostcode">
                    </div>
                </div>
                <div class="admin_info admin_halfbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">나머지 주소</span>
                    </div>
                    <div>
                        <input type="text" name="dlvAddress2" class="input_fullDesign dlvAddress2">
                    </div>
                </div>
                <div class="admin_info admin_fullbox">
                    <div class="admin_infoTit flex-vc-hl-container">
                        <span class="admin_infoTitText">주문상품</span>
                    </div>
                    <div class="admin_board_top flex-vc-hr-container">
                        <div class="admin_board_top_btn flex-vc-hr-container">
                            <div class="admin_board_top_btn_list">
                                <input type="button" class="selectDel" onclick="orderStatusModi(this, 'all', '3');" value="전체 배송준비중">
                            </div>
                            <div class="admin_board_top_btn_list">
                                <input type="button" onclick="orderStatusModi(this, 'all', '4');" value="전체 배송중">
                            </div>
                            <div class="admin_board_top_btn_list">
                                <input type="button" onclick="orderStatusModi(this, 'all', '5');" value="전체 배송완료">
                            </div>
                            <div class="admin_board_top_btn_list">
                                <input type="button" onclick="orderStatusModi(this, 'all', '9');" value="전체 취소완료">
                            </div>
                        </div>
                    </div>
                    <div>
                        <ul class="adminOrder_infoBox flex-vc-hl-container">
                            <li>상품썸네일</li>
                            <li>상품명</li>
                            <li>상품금액</li>
                            <li>구매수량</li>
                            <li>총 주문금액</li>
                            <li>결제상태</li>
                        </ul>
                        <div class="order_list"></div>
                    </div>
                    <div class="orderDetail_infoBox">
                        <p class="orderDetail_tit">결제정보</p>
                        <div class="orderDetail_infoList">
                            <ul class="flex-vc-hl-container">
                                <li>결제방식</li>
                                <li class="payTypeName"></li>
                            </ul>
                            <ul class="flex-vc-hl-container">
                                <li>배송 요청사항</li>
                                <li class="dlvMemo"></li>
                            </ul>
                            <ul class="flex-vc-hl-container">
                                <li>주문금액</li>
                                <li class="orderPrice">원</li>
                            </ul>
                            <ul class="flex-vc-hl-container">
                                <li>쿠폰 할인금액</li>
                                <li class="couponPrice">원 </li>
                            </ul>
                            <ul class="flex-vc-hl-container">
                                <li>포인트 할인금액</li>
                                <li class="usePointPrice">원</li>
                            </ul>
                            <ul class="flex-vc-hl-container">
                                <li>배송비</li>
                                <li class="dlvPrice">원</li>
                            </ul>
                            <ul class="flex-vc-hl-container">
                                <li>실결제금액</li>
                                <li style="font-weight: bold;" class="payPrice">원</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="admin_btnBox">
                    <input type="button" class="admin_btn modify_btn" value="수정하기">
                    <input type="button" class="admin_backBtn" onclick="location.href='./orderList'" value="돌아가기">
                </div> 
            </div>
        </form>
    </div>
</div>

<script>

const form = $("#orderModifyForm");

$.ajax({
    type: "POST", 
    dataType: "json",
    async: true,
    url: "/admin/controller/orderController.php",
    global: false,
    data: form.serialize(),
    traditional: true,
    beforeSend:function(xhr){
    },
    success:function(data){

        // console.log(data);

        // 주문번호
        $(".orderNo").val(data[1][0]['orderNo']);

        // 주문일자
        let date = data[1][0]['date'].substr(0, 10);
        $(".orderDate").val(date);

        // 회원아이디
        $(".orderId").val(data[1][0]['id']);

        // 받는분
        $(".dlvName").val(data[1][0]['dlvName']);

        // 받는분 핸드폰번호
        let dlvCell = data[1][0]['dlvCell'].split("◈");
        $(".dlvCell").val(dlvCell[0] + "-" + dlvCell[1] + "-" + dlvCell[2]);

        // 주문자 이메일
        $(".buyerEmail").val(data[1][0]['buyerEmail']);

        // 배송업체
        if (data[1][0]['dlvCompany'] !== "") {

            $(".orderDlvCompany").val(data[1][0]['dlvCompany']);

        }

        // 운송장번호
        $(".orderDlvCode").val(data[1][0]['dlvCode']);

        let dlvAddress = data[1][0]['dlvAddress'].split("◈");

        // 받는분 우편번호
        $(".dlvPostcode").val(data[1][0]['dlvPostcode']);

        // 받는분 주소
        $(".dlvAddress1").val(dlvAddress[0]);

        // 나머지 주소
        $(".dlvAddress2").val(dlvAddress[1]);

        let contentList = "";
        let statusArr = [];

        for (ol=0; ol < data[1].length; ol++) {

            contentList += "<ul class='adminOrder_infoBox flex-vc-hl-container'><li class='orderThumbnail'><img src='" + adminImgSrc + "/" + data[1][ol]['fileName'] + "'></li><li class='orderTitle'><p style='margin-bottom: 12px;'>" +  data[1][ol]['title'] + "</p><p>" +  data[1][ol]['optionTitle'] + "</p></li><li class='orderPrice'>" +  comma(data[1][ol]['price']) + "원</li><li class='orderQty'>" + comma(data[1][ol]['qty']) + "개</li><li class='orderPrice'>" + comma(data[1][ol]['price'] * data[1][ol]['qty']) + "원</li><li><select id='orderStatus" + ol + "' onchange='orderStatusModi(this);'><option value='1'>입금대기</option><option value='2'>입금완료</option><option value='3'>배송준비중</option><option value='4'>배송중</option><option value='5'>배송완료</option><option value='6'>구매확정</option><option value='7'>후기작성완료</option><option value='8'>취소요청</option><option value='9'>취소완료</option><option value='10'>반품요청</option><option value='11'>반품수거중</option><option value='12'>반품수거완료</option><option value='13'>반품완료</option><option value='14'>환불요청</option><option value='15'>환불완료</option><option value='16'>교환요청</option><option value='17'>교환수거중</option><option value='18'>교환수거완료</option><option value='19'>교환재배송중</option><option value='20'>교환완료</option></select><div class='orderInfo_hidden'><input type='hidden' class='orderProductIdx' value='" + data[1][ol]['orderProductIdx'] + "'></div></li></ul>";

            statusArr.push(data[1][ol]['status']);

        }

        $(".order_list").html(""); // 리스트 초기화

        $(".order_list").append(contentList);

        for (sa=0; sa < statusArr.length; sa++) {

            $("#orderStatus" + sa).val(statusArr[sa]).prop("selected", true);

        }

        // 결제방식
        $(".payTypeName").text(data[1][0]['payTypeName']);

        // 배송 요청사항
        $(".dlvMemo").text(data[1][0]['dlvMemo']);

        // 주문금액
        $(".orderPrice").text(data[1][0]['totalPrice'] + "원");

        // 쿠폰 할인금액
        if (data[1][0]['couponPrice'] && data[1][0]['couponPrice'] > 0) {

            $(".couponPrice").text("- " + data[1][0]['couponPrice'] + "원");

        } else {

            $(".couponPrice").text("0원");

        }

        // 포인트 할인금액
        if (data[1][0]['usePointPrice'] && data[1][0]['usePointPrice'] > 0) {

            $(".usePointPrice").text("- " + data[1][0]['usePointPrice'] + "원");

        } else {

            $(".usePointPrice").text("0원");

        }

        // 배송비
        if (data[1][0]['dlvPrice'] && data[1][0]['dlvPrice'] > 0) {

            $(".dlvPrice").text("+ " + data[1][0]['dlvPrice'] + "원");

        } else {

            $(".dlvPrice").text("0원");

        }

        // 실결제금액
        let payPrice = parseInt(data[1][0]['totalPrice']) - parseInt(data[1][0]['couponPrice']) - parseInt(data[1][0]['usePointPrice']) + parseInt(data[1][0]['dlvPrice']);

        $(".payPrice").text(payPrice + "원");

        // 제목 width 자동 조절
        var totalWidth = 0;

        for (lw=0; lw < $(".admin_thead div").length; lw++) {

            if ($(".admin_thead div").eq(lw).attr("class") !== "col-title-list") {

                let listWidth = $(".admin_thead div").eq(lw).width();

                totalWidth += listWidth;

            }

        }

        $(".admin_thead .col-title-list").css({

            width : "calc(100% - " + totalWidth + "px)"

        });

        $(".admin_tbody_list .col-title-list").css({

            width : "calc(100% - " + totalWidth + "px)"

        });

    },
    error:function(request,status,error){

        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        
    }
    
});

$(".modify_btn").click(function() {

    const form = $("#orderModifyForm");

    $(".act").val("modify");

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/admin/controller/orderController.php",
        global: false,
        data: form.serialize(),
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            if(data == "success"){

                if (confirm("현재 페이지를 닫으시겠습니까?")) {

                    location.href = "/admin/view/order/orderList";

                } else {

                    location.reload();    

                }

            }else{

                document.write(data);

            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

});

</script>