<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200 flex-vt-hsb-container m_orderConBox">
            <div class="w768 m_orderCon">
                <ul class="board_titBox orderSheet_titBox flex-vc-hsb-container">
                    <li>주문/결제</li>
                </ul>
                <input type="hidden" class="deliveryMinPrice" value="">
                <input type="hidden" class="deliveryPrice" value="<?=$config['deliveryPrice']?>">
                <input type="hidden" class="memberLevelPoint" value="">
                <div class="sub_container">
                    <div class="orderSheet_listBox">
                        <div class="buyer_infoBox">
                            <h2 class="orderSheet_tit">주문자 정보</h2>
                            <ul class="buyer_info flex-vc-hl-container">
                                <li>이름</li>
                                <li><input type="text" class="orderSheet_input1 buyer_name" value="" placeholder="이름을 입력하세요."></li>
                            </ul>
                            <ul class="buyer_info flex-vc-hl-container">
                                <li>핸드폰번호</li>
                                <li><input type="tel" class="orderSheet_input1 buyer_cell" oninput="inputonlyNum(this)" maxLength="11" value="" placeholder="숫자만 입력하세요."></li>
                            </ul>
                            <ul class="buyer_info flex-vc-hl-container">
                                <li>이메일</li>
                                <li class="flex-vc-hsb-container">
                                    <input type="text" class="orderSheet_input1 buyer_email" value="" placeholder="이메일을 입력하세요.">
                                    <select class="orderSheet_email_select buyer_email_address">
                                        <option value="">직접입력</option>
                                        <option value="naver.com">naver.com</option>
                                        <option value="hanmail.net">hanmail.net</option>
                                        <option value="daum.net">daum.net</option>
                                        <option value="gmail.com">gmail.com</option>
                                        <option value="nate.com">nate.com</option>
                                        <option value="hotmail.com">hotmail.com</option>
                                        <option value="hanmir.com">hanmir.com</option>
                                        <option value="lycos.co.kr">lycos.co.kr</option>
                                        <option value="yahoo.co.kr">yahoo.co.kr</option>
                                        <option value="freechal.com">freechal.com</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                        <div class="buyer_infoBox">
                            <div class="buyer_infoTit flex-vc-hsb-container">
                                <h2 class="orderSheet_tit">배송지 정보</h2>
                            </div>
                            <ul class="buyer_info flex-vc-hl-container">
                                <li>받는분</li>
                                <li><input type="text" class="orderSheet_input1 dlv_name" value="" placeholder="이름을 입력하세요."></li>
                            </ul>
                            <ul class="buyer_info flex-vc-hl-container">
                                <li>핸드폰번호</li>
                                <li><input type="tel" class="orderSheet_input1 dlv_cell" oninput="inputonlyNum(this)" maxLength="11" value="" placeholder="숫자만 입력하세요."></li>
                            </ul>
                            <ul class="buyer_info flex-vt-hl-container">
                                <li>주소</li>
                                <li class="flex-vc-hsb-container">
                                    <input type="text" class="orderSheet_input2 dlv_address1" id="orderAddress1" placeholder="주소를 입력해주세요." onclick="DaumPostcodePop('order')" readonly>
                                    <input type="text" class="orderSheet_input2 dlv_address2" id="address2" placeholder="상세주소를 입력해주세요." value="">
                                    <input type="hidden" name="dlvPostcode" id="dlvPostcode" value="">
                                </li>
                            </ul>
                            <ul class="buyer_info add_inputBox flex-vc-hl-container">
                                <li>배송시 요청사항</li>
                                <li>
                                    <select class="orderSheet_select dlv_memo" onchange="addInput(this);">
                                        <option value="">배송시 요청사항</option>
                                        <option value="안전 배송해주세요.">안전 배송해주세요.</option>
                                        <option value="빠른 배송해주세요.">빠른 배송해주세요.</option>
                                        <option value="문 앞에 놓아주세요.">문 앞에 놓아주세요.</option>
                                        <option value="경비(관리)실에 맡겨주세요.">경비(관리)실에 맡겨주세요.</option>
                                        <option value="부재시 경비(관리)실에 맡겨주세요.">부재시 경비(관리)실에 맡겨주세요.</option>
                                        <option value="부재시 문 앞에 놓아주세요.">부재시 문 앞에 놓아주세요.</option>
                                        <option value="부재시 연락주세요.">부재시 연락주세요.</option>
                                        <option value="배송 전에 연락 주세요.">배송 전에 연락 주세요.</option>
                                        <option value="직접입력">직접입력</option>
                                    </select>
                                    <input type="text" class="orderSheet_input3 add_input dlv_memo_text" placeholder="요청사항을 입력해주세요.">
                                </li>
                            </ul>
                        </div>
                        <div class="buyer_infoBox">
                            <h2 class="orderSheet_tit">주문상품</h2>
                            <ul class="order_listBox"></ul>
                        </div>
                        <div class="buyer_infoBox orderSheet_coupon"></div>
                        <div class="buyer_infoBox orderSheet_point">
                            <h2 class="orderSheet_tit">포인트</h2>
                        </div>
                        <div class="buyer_infoBox">
                            <h2 class="orderSheet_tit">결제방법</h2>
                            <ul class="orderSheet_paymentBox flex-vc-hl-container">
                                <li class="orderSheet_paymentList">
                                    <input type="radio" id="creditpay" name="payment" value="creditpay" onclick="paymentAddInfo(this)">
                                    <label for="creditpay">
                                        <div class="orderSheet_payment flex-vc-hc-container">신용카드</div>
                                    </label>
                                </li>
                                <li class="orderSheet_paymentList">
                                    <input type="radio" id="bankpay" name="payment" value="bankpay" onclick="paymentAddInfo(this)">
                                    <label for="bankpay">
                                        <div class="orderSheet_payment flex-vc-hc-container">무통장입금</div>
                                    </label>
                                </li>
                                <li class="orderSheet_paymentList">
                                    <input type="radio" id="naverpay" name="payment" value="naverpay" onclick="paymentAddInfo(this)">
                                    <label for="naverpay">
                                        <div class="orderSheet_payment flex-vc-hc-container">네이버페이</div>
                                    </label>
                                </li>
                                <li class="orderSheet_paymentList">
                                    <input type="radio" id="kakaopay" name="payment" value="kakaopay" onclick="paymentAddInfo(this)">
                                    <label for="kakaopay">
                                        <div class="orderSheet_payment flex-vc-hc-container">카카오페이</div>
                                    </label>
                                </li>
                                <li class="orderSheet_paymentList">
                                    <input type="radio" id="tosspay" name="payment" value="tosspay" onclick="paymentAddInfo(this)">
                                    <label for="tosspay">
                                        <div class="orderSheet_payment flex-vc-hc-container">토스페이</div>
                                    </label>
                                </li>
                                <li class="orderSheet_paymentList">
                                    <input type="radio" id="paycopay" name="payment" value="paycopay" onclick="paymentAddInfo(this)">
                                    <label for="paycopay">
                                        <div class="orderSheet_payment flex-vc-hc-container">페이코</div>
                                    </label>
                                </li>
                            </ul>
                            <!-- 무통장입금 일때 시작 -->
                            <div class="payment_addBox bankpay_addBox">
                                <ul class="buyer_info add_inputBox flex-vc-hl-container">
                                    <li>입금은행</li>
                                    <li>
                                        <select class="orderSheet_select bank">
                                            <option value="">입금은행</option>
                                            <option value="기업은행">기업은행</option>
                                            <option value="국민은행">국민은행</option>
                                            <option value="농협은행">농협은행</option>
                                            <option value="SC제일은행">SC제일은행</option>
                                            <option value="우리은행">우리은행</option>
                                            <option value="하나은행">하나은행</option>
                                            <option value="대구은행">대구은행</option>
                                            <option value="부산은행">부산은행</option>
                                            <option value="우체국">우체국</option>
                                            <option value="씨티은행">씨티은행</option>
                                            <option value="신한은행">신한은행</option>
                                        </select>
                                    </li>
                                </ul>
                                <ul class="buyer_info flex-vc-hl-container">
                                    <li>입금자명</li>
                                    <li>
                                        <input type="text" class="orderSheet_input2 bank_name" placeholder="입금자명을 입력해주세요.">
                                    </li>
                                </ul>
                                <ul class="buyer_info flex-vc-hl-container">
                                    <li>현금영수증</li>
                                    <li class="orderSheet_cashReceiptsList flex-vc-hsb-container">
                                        <div class="orderSheet_cashReceipts">
                                            <input type="radio" id="cashReceiptsY" name="cashReceipts" class="cash_receipts" value="Y">
                                            <label for="cashReceiptsY">
                                                <div class="orderSheet_payment flex-vc-hc-container">발행</div>
                                            </label>
                                        </div>
                                        <div class="orderSheet_cashReceipts">
                                            <input type="radio" id="cashReceiptsN" name="cashReceipts" class="cash_receipts" value="N" checked>
                                            <label for="cashReceiptsN">
                                                <div class="orderSheet_payment flex-vc-hc-container">미발행</div>
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                                <p class="payment_desc">* 24시간 이내 미입금 시, 주문이 자동 취소됩니다.</p>
                            </div>
                            <!-- 무통장입금 일때 끝 -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="payment_infoBox">
                <div class="payment_infoListBox payment_infoDeatilListBox">
                    <h3 class="payment_infoTit">결제금액</h3>
                    <ul class="payment_infoList flex-vc-hsb-container">
                        <li>총 상품 금액</li>
                        <li><span class="order_productTotalPrice"></span>원</li>
                    </ul>
                    <ul class="payment_infoList flex-vc-hsb-container">
                        <li>배송비</li>
                        <li><span class="order_dlvPrice"></span>원</li>
                    </ul>
                </div>
                <div class="payment_infoListBox payment_infoLastBox">
                    <ul class="payment_infoList total_payment flex-vc-hsb-container">
                        <li>총 결제금액</li>
                        <li><span class="total_price"></span>원</li>
                    </ul>
                </div>
                <div class="payment_infoListBox">
                    <ul class="payment_infoList flex-vc-hl-container">
                        <li class="order_tncBtn">
                            <input type="checkbox" id="orderTnc">
                            <label for="orderTnc">
                                <p class="v_designCheck">
                                    <span class="v_designChecked"></span>
                                </p>
                                <span class="order_tncTit">아래 내용에 모두 동의합니다. (필수)</span>
                            </label>
                        </li>
                    </ul>
                    <ul class="payment_infoList order_tncDesc flex-vc-hsb-container">
                        <li>개인정보 제 3자 제공 동의</li>
                        <li data-val="other"><a href="/thirdParty" target="_blank">내용보기</a></li>
                    </ul>
                    <ul class="payment_infoList order_tncDesc flex-vc-hsb-container">
                        <li>개인정보 수집 및 이용</li>
                        <li data-val="privateUse"><a href="/privateUse" target="_blank">내용보기</a></li>
                    </ul>
                </div>
                <div class="order_btnBox">
                    <div class="order_btn flex-vc-hc-container" onclick="order()">
                        <p><span class="order_btn_price"></span>원 결제하기</p>
                    </div>
                </div>
            </div>

            <!-- 배송지 변경 시작 -->

            <div class="dlv_addressBox">
                <!-- 배송지 선택 시작 -->
                <div class="dlv_addressListBox dlv_listBox">
                    <h3 class="dlv_addressTit">배송지 선택 (최대 3개)</h3>
                    <div class="dlv_addressListCon"></div>
                    <p class="dlv_newAddressBox"><input type="button" class="dlv_newAddressBtn" value="신규배송지 추가" onclick="dlvChange(this, 'writeOpen')"></p>
                    <div class="dlv_addressBtnBox">
                        <ul class="flex-vc-hc-container">
                            <li class="flex-vc-hc-container" onclick="dlvChange(this, 'listOk')">선택완료</li>
                            <li class="flex-vc-hc-container" onclick="dlvChange(this, 'listClose')">닫기</li>
                        </ul>
                    </div>
                </div>
                <!-- 배송지 선택 끝 -->

                <!-- 배송지 추가 시작 -->
                <div class="dlv_addressListBox dlv_writeBox">
                    <h3 class="dlv_addressTit">배송지 추가</h3>
                    <div class="dlv_addressListCon">
                        <ul class="buyer_info flex-vc-hl-container">
                            <li>받는분</li>
                            <li><input type="text" class="orderSheet_input2 dlv_popName" placeholder="이름을 입력해주세요."></li>
                        </ul>
                        <ul class="buyer_info flex-vt-hl-container">
                            <li>주소</li>
                            <li class="flex-vc-hsb-container">
                                <input type="text" class="orderSheet_input2 dlv_popAddress1" id="popAddress1" placeholder="주소를 입력해주세요." onclick="DaumPostcodePop('pop')" readonly="">
                                <input type="text" class="orderSheet_input2 dlv_popAddress2" id="address2" placeholder="상세주소를 입력해주세요.">
                                <input type="hidden" id="popPostcode">
                            </li>
                        </ul>
                        <ul class="buyer_info flex-vc-hl-container">
                            <li>핸드폰번호</li>
                            <li><input type="tel" class="orderSheet_input2 dlv_popCellphone" oninput="inputonlyNum(this)" maxLength="11" placeholder="숫자만 입력하세요."></li>
                        </ul>
                        <div class="regi_defaltDlv">
                            <input type="checkbox" id="regiDefaltDlv" class="defalt_dlv">
                            <label for="regiDefaltDlv">
                                <p class="v_designCheck">
                                    <span class="v_designChecked"></span>
                                </p>
                                <span class="order_tncTit">기본배송지로 등록</span>
                            </label>
                        </div>
                    </div>
                    <div class="dlv_addressBtnBox">
                        <ul class="flex-vc-hc-container">
                            <li class="flex-vc-hc-container" onclick="dlvChange(this, 'writeOk')">확인</li>
                            <li class="flex-vc-hc-container" onclick="dlvChange(this, 'writeClose')">취소</li>
                        </ul>
                    </div>
                </div>
                <!-- 배송지 추가 끝 -->

                <!-- 배송지 수정 시작 -->
                <div class="dlv_addressListBox dlv_modifyBox">
                    <h3 class="dlv_addressTit">배송지 수정</h3>
                    <input type="hidden" class="dlv_modiIdx">
                    <input type="hidden" class="dlv_modiDefalt">
                    <div class="dlv_addressListCon">
                        <ul class="buyer_info flex-vc-hl-container">
                            <li>받는분</li>
                            <li><input type="text" class="orderSheet_input2 dlv_popModiName"></li>
                        </ul>
                        <ul class="buyer_info flex-vt-hl-container">
                            <li>주소</li>
                            <li class="flex-vc-hsb-container">
                                <input type="text" class="orderSheet_input2 dlv_popModiAddress1" id="popModiAddress1" placeholder="주소를 입력해주세요." onclick="DaumPostcodePop('popModi')" readonly="">
                                <input type="text" class="orderSheet_input2 dlv_popModiAddress2" id="address2" placeholder="상세주소를 입력해주세요.">
                                <input type="hidden" class="dlv_popModiPostcode" id="popModiPostcode">
                            </li>
                        </ul>
                        <ul class="buyer_info flex-vc-hl-container">
                            <li>핸드폰번호</li>
                            <li><input type="tel" class="orderSheet_input2 dlv_popModiCellphone" oninput="inputonlyNum(this)" maxLength="11" placeholder="숫자만 입력하세요."></li>
                        </ul>
                        <div class="regi_defaltDlv">
                            <input type="checkbox" id="modifyDefaltDlv">
                            <label for="modifyDefaltDlv">
                                <p class="v_designCheck">
                                    <span class="v_designChecked"></span>
                                </p>
                                <span class="order_tncTit">기본배송지로 등록</span>
                            </label>
                        </div>
                    </div>
                    <div class="dlv_addressBtnBox">
                        <ul class="flex-vc-hc-container">
                            <li class="flex-vc-hc-container" onclick="dlvChange(this, 'modifyOk')">확인</li>
                            <li class="flex-vc-hc-container" onclick="dlvChange(this, 'modifyClose')">취소</li>
                        </ul>
                    </div>
                </div>
                <!-- 배송지 수정 끝 -->

                <p class="dlv_addressBg"></p>
            </div>

            <!-- 배송지 변경 끝 -->

            <!-- 쿠폰 사용 시작 -->

            <div class="coupon_choiceBox">
                <div class="coupon_choiceListBox">
                    <h3 class="coupon_choiceTit">쿠폰 선택</h3>
                    <div class="coupon_choiceListCon">
                        <div class="coupon_choiceList">
                            <div class="coupon_choiceListDesc">
                                <input type="radio" name="couponChoice" id="couponChoice0" checked>
                                <label for="couponChoice0">
                                    <div>
                                        <p class="o_designCheck">
                                            <span class="o_designChecked"></span>
                                        </p>
                                        적용안함
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- <p class="dlv_newAddressBox"><input type="button" class="dlv_newAddressBtn" value="쿠폰번호 등록" onclick="useCoupon(this, 'writeOpen')"></p> -->
                    <div class="dlv_addressBtnBox">
                        <ul class="flex-vc-hc-container">
                            <li class="flex-vc-hc-container" onclick="useCoupon(this, 'listOk')">쿠폰 적용</li>
                            <li class="flex-vc-hc-container" onclick="useCoupon(this, 'listClose')">닫기</li>
                        </ul>
                    </div>
                </div>
                <p class="coupon_choiceBg"></p>
            </div>
        </div>
    </div>
</div>

<script>

    $('body, html').animate({

        scrollTop : 0

    }, 40);

    gnbLoad('orderSheet');

    let orderType = getCookie("orderType");

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/orderController",
        global: false,
        data: {
            "page": "order",
            "act": "orderSheet",
            "type": orderType
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            // 주문상품
            let orderProductList = "";
            let optionTitCheck = "";
            let productPrice = 0;

            for (opc=0; opc < data[3].length; opc++) {

                if (data[5][opc] == null) { // 옵션 없는 상품

                    var cartInfo = data[4];

                    var originPrice = cartInfo[opc]['price'];
                    var discountedPrice = cartInfo[opc]['price'] - Math.round(cartInfo[opc]['price'] * (cartInfo[opc]['discountPercent'] / 100) / 100) * 100;
                    var totalCartPrice = discountedPrice * data[3][opc]['qty'];

                    var optionTitle = "";
                    var optionEachPrice = discountedPrice;
                    var stock = cartInfo[opc]['stock'];

                } else { // 옵션 있는 상품

                    var cartInfo = data[5];

                    var originPrice = cartInfo[opc]['price'];
                    var discountedPrice = originPrice;
                    var totalCartPrice = cartInfo[opc]['price'] * data[3][opc]['qty'];

                    var optionTitle = cartInfo[opc]['title'];
                    var optionEachPrice = cartInfo[opc]['price'];
                    var stock = cartInfo[opc]['stock'];

                    optionTitCheck = "<p class='option_tit'>" + optionTitle + "</p>";

                }

                productPrice = productPrice + totalCartPrice;

                orderProductList += "<li class='order_list'><div class='oroder_infobox flex-vc-hsb-container'><div class='order_thumbBox'><img src='" + adminImgSrc + "/" + data[4][opc]['fileName'] + "' alt='제품 썸네일'></div><div class='order_titbox flex-vc-hsb-container'><div><p class='product_tit'>" + data[4][opc]['title'] +"</p>" + optionTitCheck + "<p class='option_tit'>" + comma(discountedPrice) + "원 x " + data[3][opc]['qty'] + "개</p></div><p class='order_pricebox'><span class='option_price'>" + comma(totalCartPrice) + "</span>원</p></div></div></li>";

            }

            $(".order_listBox").append(orderProductList);

            // 상품금액
            $(".order_productTotalPrice").text(comma(productPrice));

            // 배송비
            if (data[1] == "nonMember") { // 비회원

                $(".deliveryMinPrice").val("<?=$config['deliveryMinPrice']?>");

                if (productPrice >= $(".deliveryMinPrice").val()) { // 무료배송 최소금액 이상일때

                    $(".order_dlvPrice").text("0");

                    var deliveryPrice = 0;

                } else {

                    $(".order_dlvPrice").text(comma(parseInt($(".deliveryPrice").val())));

                    var deliveryPrice = $(".deliveryPrice").val();

                }

            } else { // 회원

                let deliveryMinPrice = data[1]['memberLevelDeliveryMinPrice'];
                let memberLevelPoint = data[1]['memberLevelPoint'];
                
                $(".deliveryMinPrice").val(deliveryMinPrice);
                $(".memberLevelPoint").val(memberLevelPoint);

                // 회원별 무료배송 최소금액 확인
                if (productPrice >= $(".deliveryMinPrice").val()) { // 무료배송 최소금액 이상일때

                    $(".order_dlvPrice").text("0");

                    var deliveryPrice = 0;

                } else {

                    $(".order_dlvPrice").text(comma(parseInt($(".deliveryPrice").val())));

                    var deliveryPrice = $(".deliveryPrice").val();

                }

            }

            $(".total_price").text(comma(parseInt(productPrice) + parseInt(deliveryPrice)));
            $(".order_btn_price").text(comma(parseInt(productPrice) + parseInt(deliveryPrice)));

            // 회원일 경우 회원 정보 자동입력
            if (data[1] !== "nonMember") {

                let cellPhone = data[1]['cellPhone'].split("◈");
                let email = data[1]['email'].split("@");
                let address = data[1]['address'].split("◈");

                // 주문자 정보
                $(".buyer_name").val(data[1]['name']);
                $(".buyer_cell").val(cellPhone[0] + cellPhone[1] + cellPhone[2]);
                $(".buyer_email").val(email[0]);
                $(".buyer_email_address option[value='" + email[1] + "']").prop("selected", true);

                // 배송지 관리
                let orderDlvList = "";
                let defaltDlvName = "";
                let defaltDlvCellPhone = "";
                let defaltDlvAddress1 = "";
                let defaltDlvAddress2 = "";
                let defaltDlvPostcode = "";

                for (odc=0; odc < data[2].length; odc++) {

                    let defaltDlv = data[2][odc]['defaltDlv'] == "Y" ? "dlv_active" : "";
                    let defaltDlvText = data[2][odc]['defaltDlv'] == "Y" ? " (기본배송지)" : "";
                    let cellPhone = data[2][odc]['cellPhone'].split("◈");
                    let dlvAddress = data[2][odc]['address'].split("◈");
                    
                    orderDlvList += "<div class='dlv_addressList " + defaltDlv + "' onclick=\"dlvChange(this, 'listClick')\"><input type='hidden' class='dlv_idx' value='" + data[2][odc]['idx'] + "'><input type='hidden' class='dlv_defalt' value='" + data[2][odc]['defaltDlv'] + "'><ul class='dlv_addressListDesc'><li class='dlv_addressListName'><span class='dlv_popListName'>" + data[2][odc]['name'] + "</span><span>" + defaltDlvText + "</span></li><li class='dlv_addressListCell'>" + cellPhone[0] + cellPhone[1] + cellPhone[2] + "</li><li>" + dlvAddress[0] + " " + dlvAddress[1] + "<input type='hidden' class='dlv_addressListadd1' value='" + dlvAddress[0] + "'><input type='hidden' class='dlv_addressListadd2' value='" + dlvAddress[1] + "'><input type='hidden' class='dlv_addressPostcode' value='" + data[2][odc]['postcode'] + "'></li></ul><ul class='dlv_addressListBtn flex-vc-hc-container'><li class='flex-vc-hc-container' onclick=\"dlvChange(this, 'modifyOpen')\">수정</li><li class='flex-vc-hc-container' onclick=\"dlvChange(this, 'del')\">삭제</li></ul></div>";

                    // 기본 배송지 정보 저장
                    if (data[2][odc]['defaltDlv'] == "Y") {

                        defaltDlvName = data[2][odc]['name'];
                        defaltDlvCellPhone = cellPhone[0] + cellPhone[1] + cellPhone[2];
                        defaltDlvAddress1 = dlvAddress[0];
                        defaltDlvAddress2 = dlvAddress[1];
                        defaltDlvPostcode = data[2][odc]['postcode'];

                    }

                }

                $(".dlv_listBox .dlv_addressListCon").append(orderDlvList);

                // 배송지 정보
                $(".buyer_infoTit").append("<p class='dlv_changeBtn' onclick=\"dlvChange(this, 'listOpen')\">배송지 변경</p>");
                $(".dlv_name").val(defaltDlvName);
                $(".dlv_cell").val(defaltDlvCellPhone);
                $(".dlv_address1").val(defaltDlvAddress1);
                $(".dlv_address2").val(defaltDlvAddress2);
                $("#dlvPostcode").val(defaltDlvPostcode);

                // 쿠폰 노출
                if (data[6] == "noCoupon") { // 다운받은 쿠폰이 없을때

                    var couponContent = "<h2 class='orderSheet_tit'>쿠폰</h2><ul class='buyer_info flex-vc-hl-container'><li>쿠폰</li><li><input type='text' class='orderSheet_input1 coupon_name' placeholder='사용할 수 있는 쿠폰이 없습니다.' readonly><input type='button' class='ncp_btn' value='쿠폰 선택'>";

                    var couponCount = 0;

                } else { // 다운받은 쿠폰이 있을때

                    var couponContent = "<h2 class='orderSheet_tit'>쿠폰</h2><ul class='buyer_info flex-vc-hl-container'><li>쿠폰</li><li><input type='text' class='orderSheet_input1 coupon_name' placeholder='선택한 쿠폰이 없습니다.' readonly><input type='button' class='cp_btn' value='쿠폰 선택' onclick=\"useCoupon(this, 'listOpen')\"><input type='hidden' class='checked_couponIdx'>";

                    var couponCount = data[6].length;

                }

                couponContent += "</li></ul><p class='buyer_point'>사용 가능한 쿠폰 : <span>" + couponCount + "개</span></p>";

                $(".orderSheet_coupon").append(couponContent);

                // 쿠폰 팝업
                let couponList = "";

                for (cc=0; cc < data[6].length; cc++) {

                    couponList += "<div class='coupon_choiceList'><input type='hidden' class='coupon_idx' value='" + data[6][cc]['idx'] + "'><input type='hidden' class='coupon_discountPrice' value='" + data[6][cc]['discountPrice'] + "'><input type='hidden' class='coupon_discountPercent' value='" + data[6][cc]['discountPercent'] + "'><input type='hidden' class='coupon_maxPrice' value='" + data[6][cc]['maxPrice'] + "'><div class='coupon_choiceListDesc'><input type='radio' name='couponChoice' class='coupon_choice' id='couponChoice<?=$cc?>'><label for='couponChoice<?=$cc?>'><div><p class='o_designCheck'><span class='o_designChecked'></span></p><span class='couponChoice_name'>" + data[6][cc]['couponName'] + "</span></div></label></div></div>";

                }

                $(".coupon_choiceListCon").append(couponList);

                // 적립금 노출
                let pointContent = "<ul class='buyer_info flex-vc-hl-container'><li>포인트</li><li><input type='text' name='order_point' class='orderSheet_input1 use_point' onblur=\"usePoint(this, 'use');\" oninput='inputonlyNum(this); liveNumberComma(this);' value='0'><input type='button' class='cp_btn' onclick=\"usePoint(this, 'all')\" value='전액 사용'></li></ul><p class='buyer_point'>사용 가능 포인트 : <span class='max_point'>" + comma(data[1]['point']) + "P</span></p>";

                $(".orderSheet_point").append(pointContent);

                // 결제금액
                let paymentContent = "<ul class='payment_infoList flex-vc-hsb-container'><li>쿠폰 사용</li><li><span class='order_couponPrice'>0</span>원</li></ul><ul class='payment_infoList flex-vc-hsb-container'><li>포인트 사용</li><li><span class='order_pointPrice'>0</span>원</li></ul>";

                $(".payment_infoDeatilListBox").append(paymentContent);

                // 적립예정포인트
                let memberLevelPoint = Math.round(parseInt(productPrice) * parseInt($(".memberLevelPoint").val()) / 100);

                let memberLevelPointContent = "<ul class='payment_infoList total_pointBox flex-vc-hsb-container'><li>적립 예정포인트</li><li class='total_point'>" + comma(Math.floor(memberLevelPoint)) + "P</li></ul>";

                $(".payment_infoLastBox").append(memberLevelPointContent);

            } else {

                $(".orderSheet_coupon").remove();
                $(".orderSheet_point").remove();

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