<div class="sub_container">
    <input type="hidden" id="limitStart" value="0">
    <input type="hidden" id="showBoardNum" value="8">
    <input type="hidden" id="boardOpenNum" value="4">
    <input type="hidden" id="totalBoardCount" value="">
    <div id="boardPostListBox" class="mypage_marginBox">
        <div id="boardConBox" class="boardGallary_listBox">
            
        </div>
    </div>
</div>

<script>

    gnbLoad('couponList');

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/mypageController",
        global: false,
        data: {
            "page": "mypage",
            "act": "couponList",
            "orderNo": "<?=$_GET['orderNo']?>"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            let couponList = "";
            let openClass = "";

            if (data[1].length > 0) {

                for (cl=0; cl < data[1].length; cl++) {

                    // console.log(data[1][cl]);

                    if (cl == $("#boardOpenNum").val()) {

                        openClass = "boardOpen";

                    }

                    // 할인퍼센트, 할인금액
                    if (data[1][cl]['discountPercent'] == 0) {

                        var discount = data[1][cl]['discountPrice'] + "원";

                    } else {

                        var discount = data[1][cl]['discountPercent'] + "%";

                    }

                    // 사용기간
                    const downloadDate = new Date(data[1][cl]['date']);

                    let deadlineArr = data[1][cl]['deadline'].split("◈");

                    if (deadlineArr[1] == "d") {

                        downloadDate.setDate(downloadDate.getDate() + parseInt(deadlineArr[0]));

                    } else if (deadlineArr[1] == "m") {

                        downloadDate.setMonth(downloadDate.getMonth() + parseInt(deadlineArr[0]));

                    } else if (deadlineArr[1] == "y") {

                        downloadDate.setFullYear(downloadDate.getFullYear() + parseInt(deadlineArr[0]));

                    }

                    couponDeadline = downloadDate.getFullYear() + "-" + ("0" + (downloadDate.getMonth() + 1)).slice(-2) + "-" + ("0" + downloadDate.getDate()).slice(-2);

                    // 쿠폰 사용여부
                    let usedDesc = "";
                    if (data[1][cl]['used'] == "Y" && data[1][cl]['usedDate'] !== "" && data[1][cl]['usedOrderNo'] !== "") { // 사용한 쿠폰

                        usedDesc = "<div class='finish_coupon flex-vc-hc-container'><p>사&nbsp&nbsp&nbsp용&nbsp&nbsp&nbsp완&nbsp&nbsp&nbsp료</p></div>";

                    } else if (data[1][cl]['used'] == "Y" && data[1][cl]['usedDate'] == "" && data[1][cl]['usedOrderNo'] == "") { // 만료된 쿠폰

                        usedDesc = "<div class='finish_coupon flex-vc-hc-container'><p>만&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp료</p></div>";

                    }

                    couponList += "<div class='coupon_list board_postList frontTurn " + openClass + "' onclick='turnCoupon(this);'><div class='coupon_front flex-vt-hsb-container'><ul class='coupon_listTop flex-vc-hsb-container'><li>" + data[1][cl]['couponName'] + "</li><li>" + discount + "</li></ul><ul class='coupon_listDesc'><li>최소주문금액 : " + comma(data[1][cl]['minPrice']) + "원</li><li>사용기간 : " + couponDeadline + " 까지</li></ul></div><div class='coupon_back'><pre style='white-space: pre-wrap;'>" + data[1][cl]['couponUseDesc'] + "</pre></div>" + usedDesc + " </div>";

                }

                $("#boardConBox").append(couponList);

            } else {

                let emptyContent = "<div class='flex-vc-hc-container'><div class='empty_box'><lottie-player src='<?=$frontImgSrc?>/emptySearch.json' background='transparent' style='width: 100%; height: 100%;' speed='1' loop autoplay></lottie-player><p class='empty_tit'>아직 발급된 쿠폰이 없습니다.</p></div></div>";

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