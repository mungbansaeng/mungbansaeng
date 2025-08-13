<div class="sub_container">
    <input type="hidden" id="limitStart" value="0">
    <input type="hidden" id="showBoardNum" value="8">
    <input type="hidden" id="boardOpenNum" value="4">
    <input type="hidden" id="totalBoardCount" value="">
    <div class="board_tablebox boardInquiry_tablebox mypage_marginBox">
        <ul class="boardNormal_listhead clearfix">
            <li class="col-4-box">사용일/적립일</li>
            <li class="col-4-box">포인트명</li>
            <li class="col-4-box">변동 포인트</li>
            <li class="col-4-box">현재 포인트</li>
        </ul>
        <div id="boardPostListBox" class="mypage_marginBox">
            <div id="boardConBox" class="boardGallary_listBox">
                
            </div>
        </div>
    </div>
</div>

<script>

    gnbLoad('pointList');

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/mypageController",
        global: false,
        data: {
            "page": "mypage",
            "act": "pointList"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            let pointList = "";
            let openClass = "";

            if (data[1].length > 0) {

                for (cl=0; cl < data[1].length; cl++) {

                    // console.log(data[1][cl]);

                    if (cl == $("#boardOpenNum").val()) {

                        openClass = "boardOpen";

                    }

                    let addPointClass = "";

                    if (data[1][cl]['type'] == "+") {

                        addPointClass = "color_strong point";

                    }

                    let pointRegDate = data[1][cl]['date'].slice(0, 10);

                    pointList += "<ul class='boardNormal_listbody clearfix board_postList " + openClass + "'><li class='col-4-box'>" + pointRegDate + "</li><li class='col-4-box'>" + data[1][cl]['pointTitle'] + "</li><li class='col-4-box " + addPointClass + "'>" + data[1][cl]['type'] + comma(data[1][cl]['amount']) + "</li><li class='col-4-box'>" + comma(data[1][cl]['remain']) + "P</li></ul>";

                }

                $("#boardConBox").append(pointList);

            } else {

                let emptyContent = "<div class='flex-vc-hc-container'><div class='empty_box'><lottie-player src='<?=$frontImgSrc?>/emptySearch.json' background='transparent' style='width: 100%; height: 100%;' speed='1' loop autoplay></lottie-player><p class='empty_tit'>아직 적립된 포인트가 없습니다.</p></div></div>";

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