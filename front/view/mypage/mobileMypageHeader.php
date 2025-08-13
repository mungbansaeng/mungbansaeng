<div class="mypage_infoBox flex-vc-hsb-container">
    <div class="mypage_info flex-vc-hl-container">
        <div class="member_picture"style="background-image: url('<?=$frontImgSrc?>/mypage_picture.png');"></div>
        <ul class="member_info">
            <li><span class="memberName"></span>님 반갑습니다!</li>
            <li class="flex-vc-hl-container">
                <p class="memberLevel" onclick="location.href='/mypage/level'"></p>
                <p  onclick="gnbLoad('userInfoChangeView'); location.href='/mypage'">정보수정</p>
            </li>
        </ul>
    </div>
    <div class="mypage_info flex-vc-hsb-container">
        <div class="mypage_infoList" onclick="gnbLoad('orderList'); location.href='/mypage'" onselectstart="return false">
            <p>주문/배송</p>
            <p><span class="color_strong orderCount"></span>건</p>
        </div>
        <div class="mypage_infoList" onclick="gnbLoad('reviewList'); location.href='/mypage'" onselectstart="return false">
            <p>후기</p>
            <p><span class="color_strong reviewCount"></span>건</p>
        </div>
        <div class="mypage_infoList" onclick="gnbLoad('couponList'); location.href='/mypage'" onselectstart="return false">
            <p>쿠폰</p>
            <p><span class="color_strong couponCount"></span>건</p>
        </div>
        <div class="mypage_infoList" onclick="gnbLoad('pointList'); location.href='/mypage'" onselectstart="return false">
            <p>포인트</p>
            <p><span class="color_strong point"></span>P</p>
        </div>
    </div>
</div>

<script>
    
    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/mypageController",
        global: false,
        data: {
            "page": "mypage",
            "act": "mobileMypageHeader"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            // 회원등급
            $(".memberLevel").text(data[1]['memberLevelName']);

            // 회원명
            $(".memberName").text(data[1]['name']);

            // 주문/배송 건수
            $(".orderCount").text(comma(data[2]));

            // 후기 건수
            $(".reviewCount").text(comma(data[3]));

            // 쿠폰 건수
            $(".couponCount").text(comma(data[4]));

            // 포인트
            $(".point").text(comma(data[1]['point']));

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

</script>