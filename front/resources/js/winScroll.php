<script>

    $(window).scroll(function(){

        var nowScroll = $(window).scrollTop();
        var headerPos = $(".header_pos").offset().top;

        if(nowScroll > headerPos){

            $("#header_active").addClass("active");

        }else if(nowScroll <= headerPos){

            $("#header_active").removeClass("active");

        }

        if ($(".boardOpen").length > 0) {

            boardListShow("<?=$NowPageName?>", "<?=$_GET['searchCate']?>", "<?=$_GET['searchWord']?>");

        }

        <?if($NowPage == "view.php"){?>
        
            var productdetailPos = $('.productdetail_tabbpos').offset().top;

            if(nowScroll > productdetailPos){
                
                $('.productdetail_tabbox').addClass('tabfixed');
                $('.product_detailBbox').addClass('tabfixed');
                
            }else{
                
                $('.productdetail_tabbox').removeClass('tabfixed');
                $('.product_detailBbox').removeClass('tabfixed');
                
            }
            
        <?}?>

    });

</script>