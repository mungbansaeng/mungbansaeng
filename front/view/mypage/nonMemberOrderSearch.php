<div class="sub_container">
    <form id="checkForm" name="form">
        <input type="hidden" name="page" value="mypage">
        <input type="hidden" name="act" value="nonMemberOrderSearch">
        <input type="hidden" name="table" value="review">
        <input type="hidden" name="orderProductCode" value="<?=$_GET['orderProductCode']?>">
        <input type="hidden" name="productCode" value="">
        <div class="mypage_marginBox reviewWrite_box flex-vc-hc-container">
            <div class="w540">
                <p class="nonMemberOrderSearch_tit">비회원으로 구매하신 고객님께서는 아래 항목을 입력하여 조회해주세요.</p>
                <div>
                    <input type="text" id="buyerName" name="buyerName" placeholder="주문자명을 입력하세요.">
                </div>
                <div>
                    <input type="text" id="buyerCell" name="buyerCell" placeholder="핸드폰번호를 입력하세요.">
                </div>
                <div>
                    <input type="text" id="orderNo" name="orderNo" placeholder="주문번호를 입력하세요.">
                </div>
                <input type="button" class="mainColor_btn check_btn" value="조회하기">
            </div>
        </div>
    </form>
</div>

<script>

    deleteCookie("nonMemberorderSearch");

    gnbLoad('nonMemberOrderSearch');

    $(".check_btn").click(function() {

        const form = $("#checkForm");

        // 유효성 체크
        if (!$("#buyerName").val()) {

            cmAlert("주문자명을 입력하세요.");

            $("#buyerName").focus();

            return false;

        } else if (!$("#buyerCell").val()) {

            cmAlert("핸드폰번호를 입력하세요.");

            $("#buyerCell").focus();

            return false;

        } else if (!$("#orderNo").val()) {

            cmAlert("주문번호를 입력하세요.");

            $("#orderNo").focus();

            return false;

        }

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/front/controller/mypageController",
            global: false,
            data: form.serialize(),
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                if (data == "noFound") {

                    cmAlert("정보와 일치하는 주문이 없습니다.");

                } else {

                    setCookie("nonMemberorderSearch", "Y");

                    if (getCookie('nonMemberorderSearch') == "Y") {

                        gnbLoad('nonMemberorderDetail');

                        window.location.href = "/mypage?orderNo=" + $("#orderNo").val();

                    }
                    
                }

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    });

</script>

<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/footer.php"; // 푸터
    
?>	