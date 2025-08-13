<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <div class="sub_container">
                <ul class="board_titBox flex-vb-hl-container">
                    <li class="board_tit"></li>
                </ul>
                <div class="sub_container">
                    <input type="hidden" id="page" value="board">
                    <input type="hidden" id="limitStart" value="0"> <!-- 리미트 시작 -->
                    <input type="hidden" id="limitEnd" value="12"> <!-- 게시물 출력 수 -->
                    <input type="hidden" id="showNum" value="8"> <!-- 오픈되는 곳 시작 -->
                    <input type="hidden" id="loading" value="0"> <!-- 함수가 진행중인지 아닌지 체크 -->
                    <input type="hidden" id="totalBoardCount" value=""> <!-- 게시물 총 개수 -->
                    <div id="boardPostListBox">
                        <div id="boardConBox" class="boardGallary_listBox flex-vc-hl-container">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(".board_tit").text($("#header .gnb .active").text());

    $(".limitStart").val(0);

    let device = $(".device").val();

    viewList();

    function viewList () {

        $.ajax({
            type: "POST", 
            dataType: "json",
            async: true,
            url: "/front/controller/boardController",
            global: false,
            data: {
                "page": $("#page").val(),
                "act": "list",
                "categoryIdx" : $("#header .gnb .active").siblings(".categoryIdx").val()
            },
            traditional: true,
            beforeSend:function(xhr){
            },
            success:function(data){

                // console.log(data);

                if (data[0] == "success") {

                    let boardListbox = "";

                    if (data[1].length > 0) {

                        let openClass = "";
                        
                        boardListbox = "<div class='boardSns flex-vc-hc-container'>";

                        for (pl=0; pl < data[1].length; pl++) {

                            if (pl == $("#boardOpenNum").val()) {

                                openClass = "boardOpen";

                            }

                            boardListbox += "<div class='boardSns_list " + openClass + "  flex-vc-hc-container'><div class='boardSns_listCon'>";

                            let boardList = "";

                            if (data[1][pl]['admin_id'] !== "") { // 관리자일때

                                var userName = "멍반생";
                                var imageStyle = "style=\"background-image: url('/admin/resources/upload/15354040_91971.png'); background-size: 100%; background-repeat: no-repeat; background-position: center\"";

                            } else {

                                var userName = data[1][cl]['nickName'];
                                var imageStyle = "style=\"background-image: url(''); background-size: cover;\"";

                            }

                            if (device == "pc") {

                                var description = data[1][pl]['pcDescription'];

                            } else {

                                var description = data[1][pl]['mobileDescription'];

                            }

                            boardList += "<div><p class='profile_box flex-vc-hl-container'><span class='profile_img s_profile_img flex-vc-hc-container' " + imageStyle + "></span><span class='profile_name'>" + userName + "</span></p><img src='/admin/resources/upload/" + data[1][pl]['fileName'] + "' alt='게시판이미지'></div><div class='description'>" + description + "<div class='description_more flex-vc-hc-container' onclick='descriptionMore(this);'><p class='description_moreBtn flex-vc-hc-container'>더보기</p></div></div>";

                            boardListbox += boardList;

                            boardListbox += "</div></div>";

                        }

                        boardListbox += "</div>";

                    } else {

                        let boardListbox = "<div class='flex-vc-hc-container'><div class='empty_box'><lottie-player src='<?=$frontImgSrc?>/emptySearch.json' background='transparent' style='width: 100%; height: 100%;' speed='1' loop autoplay></lottie-player><p class='empty_tit'>아직 작성한 글이 없습니다.</p></div></div>";
                        
                    }

                    $("#boardConBox").append(boardListbox);

                    // 카테고리 조회
                    if (data[2].length > 0) {

                        // let subCategoryActive = "";

                        // if () {

                        // }

                        let subCategoryListbox = "<li class='subCategory_tit' onclick=\"params.delete('cate');\">전체</li>";

                        for (cl=0; cl < data[2].length; cl++) {

                            subCategoryListbox += "<li class='subCategory_tit' onclick=\"location.href='?cate=" + data[2][cl]['idx'] + "'\">" + data[2][cl]['title'] + "</li>";

                        }

                        $(".board_titBox").append(subCategoryListbox);

                    }

                }

            },
            error:function(request,status,error){

                console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                
            }
            
        });

    }

    if($('body').width() < 480){

        var reviewStar_percent = $(".reviewStar_active").width();

    }

</script>

<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/footer.php"; // 푸터
    
?>	