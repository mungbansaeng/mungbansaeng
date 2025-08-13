<div class="pc_header fixed_top">
    <div class="logo">
        <a href="<?=$adminSrc?>/main/dashboard"><img src="<?=$adminImgSrc?>/admin_logo.png"></a>
    </div>
    <div class="gnb">
        <div class="gnb_listbox flex-vc-hc-container">
            <div class="gnb_list">
                <a href="<?=$adminSrc?>/basic/ip?gnb=Y" class="flex-vc-hc-container">사이트 설정</a>
                <div class="sticky_gnb flex-vc-hc-container">
                    <div class="sticky_gnbListBox flex-vc-hl-container">
                        <a href="<?=$adminSrc?>/basic/homepageConfig">홈페이지 설정</a>
                        <a href="<?=$adminSrc?>/basic/ip?gnb=Y">접속ip 설정</a>
                        <a href="<?=$adminSrc?>/basic/meta?gnb=Y">메타태그 설정</a>
                        <a href="<?=$adminSrc?>/basic/siteCategoryList?gnb=Y">사이트 메뉴 관리</a>
                        <a href="<?=$adminSrc?>/basic/siteBannerList?gnb=Y">배너 관리</a>
                    </div>
                </div>
            </div>
            <div class="gnb_list">
                <a href="#void" class="flex-vc-hc-container">상품관리</a>
                <div class="sticky_gnb flex-vc-hc-container">
                    <div class="sticky_gnbListBox flex-vc-hl-container">
                        <a href="<?=$adminSrc?>/product/productConfig">상품 공통 설정</a>
                        <a href="<?=$adminSrc?>/product/productBrandList?gnb=Y">상품 브랜드 관리</a>
                        <a href="<?=$adminSrc?>/product/productList?gnb=Y">상품 조회</a>
                        <a href="<?=$adminSrc?>/product/productReg?gnb=Y">상품 등록</a>
                        <a href="<?=$adminSrc?>/product/productExcelConfigList?gnb=Y">상품 엑셀 설정</a>
                    </div>
                </div>
            </div>
            <div class="gnb_list">
                <a href="#void" class="flex-vc-hc-container">주문관리</a>
                <div class="sticky_gnb flex-vc-hc-container">
                    <div class="sticky_gnbListBox flex-vc-hl-container">
                        <a href="<?=$adminSrc?>/order/orderList?gnb=Y">주문조회</a>
                    </div>
                </div>
            </div>
            <div class="gnb_list">
                <a href="#void" class="flex-vc-hc-container">고객관리</a>
                <div class="sticky_gnb flex-vc-hc-container">
                    <div class="sticky_gnbListBox flex-vc-hl-container">
                        <a href="<?=$adminSrc?>/member/memberConfig">회원 공통 설정</a>
                        <a href="<?=$adminSrc?>/member/memberList?gnb=Y">회원조회</a>
                        <a href="<?=$adminSrc?>/member/groupPointInsert?gnb=Y">포인트 일괄지급</a>
                        <a href="<?=$adminSrc?>/member/productQnaList?gnb=Y">상품문의 조회</a>
                    </div>
                </div>
            </div>
            <div class="gnb_list">
                <a href="#void" class="flex-vc-hc-container">게시판</a>
                <div class="sticky_gnb flex-vc-hc-container">
                    <div class="sticky_gnbListBox board_gnbList flex-vc-hl-container"></div>
                </div>
            </div>
            <div class="gnb_list">
                <a href="#void" class="flex-vc-hc-container">프로모션</a>
                <div class="sticky_gnb flex-vc-hc-container">
                    <div class="sticky_gnbListBox flex-vc-hl-container">
                        <a href="<?=$adminSrc?>/promotion/couponReg">쿠폰 등록</a>
                        <a href="<?=$adminSrc?>/promotion/couponList?gnb=Y">쿠폰 조회</a>
                        <a href="<?=$adminSrc?>/promotion/groupCouponInsert?gnb=Y">쿠폰 일괄 지급</a>
                    </div>
                </div>
            </div>
            <div class="gnb_list">
                <a href="#void" class="flex-vc-hc-container">통계</a>
                <div class="sticky_gnb flex-vc-hc-container">
                    <div class="sticky_gnbListBox flex-vc-hl-container">
                        <a href="<?=$adminSrc?>/statistics/uvStatistics">접속분석</a>
                        <a href="<?=$adminSrc?>/statistics/periodStatistics">기간별 접속분석</a>
                        <a href="<?=$adminSrc?>/statistics/dayStatistics">요일별 접속분석</a>
                        <a href="<?=$adminSrc?>/statistics/detailStatistics?gnb=Y">상세 접속분석</a>
                    </div>
                </div>
            </div>
            <div class="gnb_list">
                <a href="#void" class="flex-vc-hc-container">인트라넷</a>
                <div class="sticky_gnb flex-vc-hc-container">
                    <div class="sticky_gnbListBox flex-vc-hl-container">
                        <a href="<?=$adminSrc?>/qa/list">QA (개발X)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="gnb_info">
        <p>"<span><?=$_SESSION['admin_name']?></span>"님의 방문을 환영합니다.</p>
        <a href="#void" onclick="logout();"> Log out</a>
    </div>
</div>

<div class="m_header">
    <div class="logo">
        <a href="<?=$adminSrc?>/main/dashboard"><img src="<?=$adminImgSrc?>/admin_logo.png"></a>
    </div>
    <div class="mmenu_btn">
        <span class="mmenubtn_bar1"></span>
        <span class="mmenubtn_bar2"></span>
        <span class="mmenubtn_bar3"></span>
    </div>
</div>

<script>

$.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/admin/controller/commonController",
        global: false,
        data: {
            "page": "gnb",
            "act": "board"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            if (data[0] == "success") {

                // 게시판 카테고리 조회
                let gnbBoardList = "";
                
                for (gb=0; gb < data[1].length; gb++) {

                    gnbBoardList += "<a href='<?=$adminSrc?>/board/boardList?gnb=Y&idx=" + data[1][gb]['idx'] + "'>" + data[1][gb]['title'] + "</a>";

                }

                $(".board_gnbList").append(gnbBoardList);
                
            }

        },
        error:function(request,status,error){

            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            
        }
        
    });

</script>