
<div class="reviewFinish_img">
    <lottie-player src="<?=$frontImgSrc?>/finishCheck.json" background="transparent" style="width: 100%; height: 100%;" speed="1" loop autoplay></lottie-player>
</div>
<ul class="orderFinish_textBox reviewFinish_textBox">
    <li><span class="reviewType"></span>후기를 작성해주셔서 <span class="reviewPoint"></span>P가 적립되었습니다!</li>
    <li>고객님의 소중한 후기를 모아 신뢰할 수 있는 후기 서비스를 제공하겠습니다.</li>
</ul>
<div class="flex-vc-hsb-container">
    <input type="button" name="" class="product_btn product_btn1" value="확인" onclick="location.href='/index'">
    <input type="button" name="" class="product_btn product_btn2" value="후기보러가기" onclick="gnbLoad('reviewList'); location.href='/mypage'">
</div>

<script>

    gnbLoad('reviewWriteFinish');

    $.ajax({
        type: "POST", 
        dataType: "json",
        async: true,
        url: "/front/controller/mypageController",
        global: false,
        data: {
            "page": "mypage",
            "act": "reviewWriteFinish",
            "orderProductCode": "<?=$_GET['orderProductCode']?>"
        },
        traditional: true,
        beforeSend:function(xhr){
        },
        success:function(data){

            // console.log(data);

            if (data[0] == "success") {

                $(".reviewType").text(data[1]);
                $(".reviewPoint").text(data[2]);

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