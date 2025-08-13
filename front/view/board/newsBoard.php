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
                        
                        boardListbox = "<div class='boardNews_listBox flex-vc-hl-container'>";

                        for (pl=0; pl < data[1].length; pl++) {

                            if (pl == $("#boardOpenNum").val()) {

                                openClass = "boardOpen";

                            }

                            boardListbox += "<div class='boardNews_list " + openClass + "  flex-vc-hc-container'><div class='boardNews_listCon'>";

                            let boardList = "";

                            if (device == "pc") {

                                var description = data[1][pl]['pcDescription'];

                            } else {

                                var description = data[1][pl]['mobileDescription'];

                            }

                            if (data[1][pl]['fileName'] == "" || data[1][pl]['fileName'] == null) {

                                fileName = "<?=$frontImgSrc?>/noimage.jpg";

                            } else {

                                fileName = "<?=$adminUploadSrc?>/" + data[1][pl]['fileName'];

                            }

                            let date = data[1][pl]['date'].slice(0, 10);

                            boardList += "<a href='#void' class='flex-vc-hsb-container'><div class='boardNews_thumnail' style=\"background-image: url('" + fileName + "'); background-size: cover; background-position: center;\"></div><ul class='boardNews_descList'><li class='boardNews_top'>" + data[1][pl]['boardTitle'] + "</li><li class='boardNews_dc'><p>" + data[1][pl]['categoryTitle'] + " / " + date + "</p></li><li class='boardNews_desc'>" + description + "</li></ul></a>";

                            boardListbox += boardList;

                            boardListbox += "</div></div>";

                        }

                        boardListbox += "</div>";

                    } else {

                        let boardListbox = "<div class='flex-vc-hc-container'><div class='empty_box'><lottie-player src='<?=$frontImgSrc?>/emptySearch.json' background='transparent' style='width: 100%; height: 100%;' speed='1' loop autoplay></lottie-player><p class='empty_tit'>아직 작성한 글이 없습니다.</p></div></div>";
                        
                    }

                    $("#boardConBox").append(boardListbox);

                    // 카테고리 조회
                    if (data[3].length > 0) {

                        let url = new URL(location.href);
                        let urlParams = url.searchParams;
                        let cate = urlParams.get('cate');
                        let subCategoryListbox = "";
                        let categoryName = "";

                        for (cl=0; cl < data[2].length; cl++) {

                            if (data[2][cl]['idx'] == data[3][0]['categoryIdx']) {

                                categoryName = data[2][cl]['file']; 

                            }

                        }

                        if (cate == null) {

                            subCategoryListbox = "<li class='subCategory_tit active' onclick=\"location.href='/" + categoryName + "'\">전체</li>";

                        } else {

                            subCategoryListbox = "<li class='subCategory_tit' onclick=\"location.href='/" + categoryName + "'\">전체</li>";

                        }

                        for (scl=0; scl < data[3].length; scl++) {

                            if (cate == data[3][scl]['idx']) {

                                subCategoryListbox += "<li class='subCategory_tit active' onclick=\"location.href='?cate=" + data[3][scl]['idx'] + "'\">" + data[3][scl]['title'] + "</li>";

                            } else {

                                subCategoryListbox += "<li class='subCategory_tit' onclick=\"location.href='?cate=" + data[3][scl]['idx'] + "'\">" + data[3][scl]['title'] + "</li>";

                            }

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