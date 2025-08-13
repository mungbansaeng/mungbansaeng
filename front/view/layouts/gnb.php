<header id="header">
    <div class="flex-vc-hc-container">
        <div class="header_top w1200 flex-vc-hsb-container">
            <h1 class="logo">
                <a href="<?=$meta['siteUrl']?>"><img src="/admin/resources/upload/<?=$config['fileName']?>" alt="로고"></a>
            </h1>
            <div class="header_searchBox">
                <input type="text" name="" class="header_searchText" value="<?=$_GET['searchWord']?>" placeholder="검색어를 입력하세요." readonly>
                <input type="button" class="header_searchBtn" title="검색버튼">
            </div>
            <div class="login_infoBox">
                <ul class="login_infoList flex-vc-hc-container">
                    <?
                    
                        if (!$_SESSION['userNo']) {
                    
                    ?>
                    <li><a href="/login"><img src="<?=$frontImgSrc?>/mypage_icon.png" alt="로그인"></a></li>
                    <?
                    
                        } else {
                    
                    ?>
                    <li class="pc_myapgeGnb">
                        <a href="#void" onclick="gnbLoad('orderList'); location.href='/mypage'"><img src="<?=$frontImgSrc?>/mypage_icon.png" alt="마이페이지"></a>
                        <p class="mypagePop_bct"></p>
                        <div class="mypage_popListBox">
                            <ul class="mypage_popList">
                                <li>
                                    <a href="#void" onclick="gnbLoad('orderList'); location.href='/mypage'">
                                        <span>주문/배송</span>
                                        <span class="mypage_popArrow"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#void" onclick="gnbLoad('couponList'); location.href='/mypage'">
                                        <span>쿠폰</span>
                                        <span class="mypage_popArrow"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#void" onclick="gnbLoad('reviewList'); location.href='/mypage'">
                                        <span>후기</span>
                                        <span class="mypage_popArrow"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/customer">
                                        <span>고객센터</span>
                                        <span class="mypage_popArrow"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#void" onclick="gnbLoad('userInfoChangeView'); location.href='/mypage'">
                                        <span>회원정보수정</span>
                                        <span class="mypage_popArrow"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#void" onclick="logout();">
                                        <span>로그아웃</span>
                                        <span class="mypage_popArrow"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="mobile_myapgeGnb">
                        <a href="#void" onclick="gnbLoad('orderList'); location.href='/mypage'"><img src="<?=$frontImgSrc?>/mypage_icon.png" alt="마이페이지"></a>
                    </li>
                    <?}?>
                    <li>
                        <a href="/order" onclick="gnbLoad('wish');"><img src="<?=$frontImgSrc?>/favorite_icon.png" alt="">
                            <p class="top_count hearder_wish_count flex-vc-hc-container"><?=COUNT($wishSelect)?></p>
                        </a>
                    </li>
                    <li>
                        <a href="/order" onclick="gnbLoad('cart');"><img src="<?=$frontImgSrc?>/shopping_icon.png" alt="">
                            <p class="top_count hearder_cart_count flex-vc-hc-container"><?=COUNT($cartSelect)?></p>
                        </a>
                    </li>
                    <li class="headerMobile_searchBtn headerActive_searchBtn"><img src="<?=$frontImgSrc?>/search_blackBtn.png" alt="검색버튼"></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="gnb">
        <ul class="flex-vc-hc-container">
            <?php

                for ($cc=0; $cc < COUNT($category); $cc++) {

                    if ($category[$cc]['showYn'] == "Y") {

                        echo "<li><a href='/".$category[$cc]['file']."' class='one_depth flex-vc-hc-container";
                        if ($nowPage == $category[$cc]['file'].".php") {
    
                            echo " active'>";
    
                        } else {
    
                            echo "'>";
    
                        }
                            
                        echo $category[$cc]['title']."</a><input type='hidden' class='categoryIdx' value='".$category[$cc]['idx']."'></li>";

                    }

                }
            
            ?>
        </ul>
    </div>
    <p class="header_pos"></p>
</header>

<header id="header_active">
    <div class="flex-vc-hc-container">
        <div class="header_top w1200 flex-vc-hsb-container">
            <h1 class="logo">
                <a href="<?=$meta['siteUrl']?>"><img src="/admin/resources/upload/<?=$config['fileName']?>" alt="로고"></a>
            </h1>
            <div class="gnb">
                <ul class="flex-vc-hc-container">
                    <?php

                        for ($acc=0; $acc < COUNT($category); $acc++) {

                            if ($category[$acc]['showYn'] == "Y") {

                                echo "<li><a href='/".$category[$acc]['file']."' class='one_depth flex-vc-hc-container";
                                if ($nowPage == $category[$acc]['file'].".php") {
            
                                    echo " active'>";
            
                                } else {
            
                                    echo "'>";
            
                                }
                                    
                                echo $category[$acc]['title']."</a><input type='hidden' class='categoryIdx' value='".$category[$acc]['idx']."'></li>";

                            }

                        }
                    
                    ?>
                </ul>
            </div>
            <div class="login_infoBox">
                <ul class="login_infoList flex-vc-hc-container">
                    <?
                    
                        if(!$_SESSION['userNo']){
                    
                    ?>
                    <li><a href="/login"><img src="<?=$frontImgSrc?>/mypage_icon.png" alt="로그인"></a></li>
                    <?
                    
                        }else{
                    
                    ?>
                    <li class="pc_myapgeGnb">
                        <a href="#void" onclick="gnbLoad('orderList'); location.href='/mypage'"><img src="<?=$frontImgSrc?>/mypage_icon.png" alt="마이페이지"></a>
                        <p class="mypagePop_bct"></p>
                        <div class="mypage_popListBox">
                            <ul class="mypage_popList">
                                <li>
                                    <a href="#void" onclick="gnbLoad('orderList'); location.href='/mypage'">
                                        <span>주문/배송</span>
                                        <span class="mypage_popArrow"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#void" onclick="gnbLoad('couponList'); location.href='/mypage'">
                                        <span>쿠폰</span>
                                        <span class="mypage_popArrow"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#void" onclick="gnbLoad('reviewList'); location.href='/mypage'">
                                        <span>후기</span>
                                        <span class="mypage_popArrow"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/customer">
                                        <span>고객센터</span>
                                        <span class="mypage_popArrow"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#void" onclick="gnbLoad('userInfoChangeView'); location.href='/mypage'">
                                        <span>회원정보수정</span>
                                        <span class="mypage_popArrow"></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#void" onclick="logout();">
                                        <span>로그아웃</span>
                                        <span class="mypage_popArrow"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="mobile_myapgeGnb">
                        <a href="#void" onclick="gnbLoad('orderList'); location.href='/mypage'"><img src="<?=$frontImgSrc?>/mypage_icon.png" alt="마이페이지"></a>
                    </li>
                    <?}?>
                    <li>
                        <a href="/order" onclick="gnbLoad('wish');"><img src="<?=$frontImgSrc?>/favorite_icon.png" alt="">
                            <p class="top_count hearderActive_wish_count flex-vc-hc-container"><?=COUNT($wishSelect)?></p>
                        </a>
                    </li>
                    <li>
                        <a href="/order" onclick="gnbLoad('cart');"><img src="<?=$frontImgSrc?>/shopping_icon.png" alt="">
                            <p class="top_count hearderActive_cart_count flex-vc-hc-container"><?=COUNT($cartSelect)?></p>
                        </a>
                    </li>
                    <li class="headerActive_searchBtn"><img src="<?=$frontImgSrc?>/search_blackBtn.png" alt="검색버튼"></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="headerActive_searchBox">
        <div class="headerActive_searchCon flex-vt-hc-container">
            <div class="w768">
                <form name="searchForm" id="searchForm" action="./searchResult" method="GET">
                    <div class="headerActive_search">
                        <input type="text" name="searchWord" id="searchWord" class="headerActive_searchText" value="<?=$_GET['searchWord']?>" placeholder="검색어를 입력하세요." onkeydown="inputEnter()">
                        <input type="button" class="headerActive_searchBtn headerFixed_searchBtn" title="검색버튼" onclick="checkSearch(this);">
                    </div>
                </form>
                <div class="mRecommend_searchListBox">
                    <ul class="recommend_searchListBox flex-vc-hc-container">
                        <li class="recommend_searchList">#육포</li>
                        <li class="recommend_searchList">#빵</li>
                        <li class="recommend_searchList">#테스트2</li>
                        <li class="recommend_searchList">#추천검색어4</li>
                    </ul>
                </div>
            </div>
            <div class="close_btn">
                <span></span>
                <span></span>
            </div>
        </div>
        <p class="headerActive_searchBg"></p>
    </div>
</header>

<div id="mobileBottomMenu">
    <div class="mobileBottomMenu_listBox">
        <ul class="mobileBottomMenu_list flex-vc-hsb-container">
            <li>
                <a href="/order" onclick="gnbLoad('wish');" class="<?if($NowPage == "wish.php"){?>active<?}?>">
                    <p class="mobileBottomMenu_icon">
                        <img src="<?=$frontImgSrc?>/favorite_icon.png" alt="">
                    </p>
                    <p class="mobileBottomMenu_text">찜</p>
                </a>
            </li>
            <li>
                <a href="#void" class="mobileSearch_btn <?if($nowPage == "search_result.php"){?>active<?}?>">
                    <p class="mobileBottomMenu_icon">
                        <img src="<?=$frontImgSrc?>/search_blackBtn.png" alt="">
                    </p>
                    <p class="mobileBottomMenu_text">검색</p>
                </a>
            </li>
            <li class="mobileBottomMenu_homeIcon">
                <a href="/index" class="<?if($nowPage == "index.php"){?>active<?}?>">
                    <p class="mobileBottomMenu_icon">
                        <img src="<?=$frontImgSrc?>/home_icon_on.png" alt="">
                    </p>
                </a>
            </li>
            <li>
                <a href="/order" onclick="gnbLoad('cart');" class="<?if($NowPage == "cart.php"){?>active<?}?>">
                    <p class="mobileBottomMenu_icon">
                        <img src="<?=$frontImgSrc?>/shopping_icon.png" alt="">
                    </p>
                    <p class="mobileBottomMenu_text">장바구니</p>
                </a>
            </li>
            <?
                    
                if(!$_SESSION['userId']){
            
            ?>
            <li>
                <a href="/login" class="<?if($nowPage == "login.php"){?>active<?}?>">
                    <p class="mobileBottomMenu_icon">
                        <img src="<?=$frontImgSrc?>/mypage_icon.png" alt="">
                    </p>
                    <p class="mobileBottomMenu_text">로그인</p>
                </a>
            </li>
            <?
            
                }else{
            
            ?>
            <li>
                <a href="#void" onclick="gnbLoad('orderList'); location.href='/mypage'" class="<?if($NowPage == "mypage.php"){?>active<?}?>">
                    <p class="mobileBottomMenu_icon">
                        <img src="<?=$frontImgSrc?>/mypage_icon.png" alt="">
                    </p>
                    <p class="mobileBottomMenu_text">마이페이지</p>
                </a>
            </li>
            <?}?>
        </ul>
    </div>
</div>