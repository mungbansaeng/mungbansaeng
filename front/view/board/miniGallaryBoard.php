<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/header.php"; // 헤더

?>

<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <div class="sub_container">
                <ul class="board_titBox flex-vc-hsb-container">
                    <li class="board_tit"></li>
                </ul>
                <div class="sub_container">
                    <input type="hidden" id="page" value="">
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
    $("#categoryIdx").val($("#header .gnb .active").siblings(".categoryIdx").val());

    $(".limitStart").val(0);

</script>

<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/footer.php"; // 푸터
    
?>	