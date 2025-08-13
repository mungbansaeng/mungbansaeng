<div id="pagenation">
    <div class="pagenation_con flex-vc-hc-container">
        
    </div>
</div>

<script>

    function pagenationSet (listCount) {

        $(".pagenation_con").html(""); // 페이징 초기화
        $("#pagenation").removeClass("pagenation_margin"); // 페이지 마진 초기화

        if (listCount > 0) {

            $("#pagenation").addClass("pagenation_margin"); // 페이지 마진 추가

            var limitStart = getCookie("page");
            var showNum = $(".showNum").val();

            var pageingBlockNum = 10; // 블럭별 수
            var firstPage = 1;
            var lastPage = Math.ceil(parseInt(listCount) / parseInt(showNum)); // 총 블럭 수
            var nowPage = Math.ceil((parseInt(limitStart) + 1) / parseInt(showNum)); // 현재페이지

            var nowBlockNum = Math.ceil(parseInt(nowPage) / parseInt(pageingBlockNum)); // 현재 블럭 숫자
            var lastBlockNum = nowBlockNum * pageingBlockNum; // 현재 블럭의 마지막 숫자
            var startBlockNum = lastBlockNum - (pageingBlockNum - 1); // 현재 블럭의 시작 숫자
            var prevBlock = lastBlockNum - pageingBlockNum; // 전 블럭의 마지막 숫자
            var nextBlock = lastBlockNum + 1; // 다음 블럭의 시작 숫자

            if (nowBlockNum == firstPage && lastPage <= pageingBlockNum) { // 첫번째 블럭이고 총 블럭이 pageingBlockNum보다 작거나 같을때

                lastBlockNum = lastPage; // 페이징 그리기 위해 필요함
                prevBlock = startBlockNum; // 이전버튼 첫번째 블럭의 첫번째 숫자로 변경
                nextBlock = lastPage; // 다음버튼 마지막 블럭의 마지막 숫자로 변경

            } else if (lastBlockNum <= pageingBlockNum) { // 첫번째 블럭 일때

                prevBlock = startBlockNum; // 이전버튼 첫번째 블럭의 첫번째 숫자로 변경

            } else if (lastBlockNum >= lastPage) { // 마지막 블럭 일때

                lastBlockNum = lastPage; // 페이징 그리기 위해 필요함
                nextBlock = lastPage; // 다음버튼 마지막 블럭의 마지막 숫자로 변경

            }

            for (p=startBlockNum; p <= lastBlockNum; p++) {

                // 해당 페이징
                if (p == nowPage) {

                    $(".pagenation_con").append("<div data-page='0' class='num num_active flex-vc-hc-container' onclick='goPage(this);'>" + p + "</div>");

                } else { // 일반 페이징

                    $(".pagenation_con").append("<div data-page='" + p + "' class='num flex-vc-hc-container' onclick='goPage(this);'>" + p + "</div>");

                }

            }

            $(".pagenation_con").prepend("<div data-page='1' class='arrow first_arrow flex-vc-hc-container' onclick='goPage(this);'><img src='/admin/resources/images/first_on.png' alt=''></div><div data-page='" + prevBlock + "' class='arrow prev_arrow flex-vc-hc-container' onclick='goPage(this);'><img src='/admin/resources/images/prev_on.png' alt=''></div>"); // 처음, 이전 화살표

            $(".pagenation_con").append("<div data-page='" + nextBlock + "' class='arrow next_arrow flex-vc-hc-container' onclick='goPage(this);'><img src='/admin/resources/images/next_on.png' alt=''></div><div data-page='" + lastPage + "' class='arrow last_arrow flex-vc-hc-container' onclick='goPage(this);'><img src='/admin/resources/images/last_on.png' alt=''></div>"); // 마지막, 다음 화살표

            // 첫페이지일때
            if (nowPage == 1) {

                // 이미지 수정
                $(".first_arrow").attr("src", "/admin/resources/images/first.png");
                $(".prev_arrow").attr("src", "/admin/resources/images/prev.png");

                // page 수정
                $(".first_arrow").attr("data-page", "0");
                $(".prev_arrow").attr("data-page", "0");

            } else if (nowPage > 1 && nowPage < lastPage) {

                firstImg = "first_on.png";
                prevImg = "prev_on.png";
                nextImg = "next_on.png";
                lastImg = "last_on.png";

            } else if (nowPage == lastPage) {

                // 이미지 수정
                $(".next_arrow").attr("src", "/admin/resources/images/next.png");
                $(".last_arrow").attr("src", "/admin/resources/images/last.png");

                // page 수정
                $(".next_arrow").attr("data-page", "0");
                $(".last_arrow").attr("data-page", "0");

            }

        }

    }

    function goPage (object) {

        var pageNum = parseInt($(object).data("page"));

        if (pageNum !== 0){

            var pageLimitStart = (pageNum - 1) * parseInt($(".showNum").val());

            setCookie("page", pageLimitStart);

            pageLimitStart = getCookie("page");

            $(".limitStart").val(pageLimitStart);

            history.replaceState({}, null, location.pathname);

            if ($(".searchText").val()) {

                viewList("search");

            } else {

                viewList();

            }

        }

        event.stopPropagation();

    }

</script>