<body>
<?

    if($_SESSION['userId']){

?>
<input type="hidden" name="sessionId" class="login_id" value="<?=$_SESSION['userId']?>">
<?

    }else{

?>
<input type="hidden" name="sessionId" class="login_id" value="<?=$_SESSION['userId']?>">
<input type="hidden" name="connectIp" class="connect_ip" value="<?=$userIp?>">
<?}?>
<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/resources/js/winScroll.php";
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/alert.php";
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/confirmAlert.php";
    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/ajaxLoading.php";

    if($NowPage == "view.php"){

        include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/gnb_sub.php";

    }else{

        include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/gnb.php";

    }

?>
<div id="contentBox">