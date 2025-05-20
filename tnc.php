<?

    include_once dirname(__FILE__)."/front/view/layouts/header.php"; // 헤더

?>
<div class="board_container">
    <div class="flex-vc-hc-container">
        <div class="w1200">
            <h1 class="privateTnc_title">이용약관</h1>
            <div class="privateTnc_box">
                <?=nl2br($config['tnc'])?>
            </div>
        </div>
    </div>
</div>

<?

    include_once dirname(__FILE__)."/front/view/layouts/footer.php"; // 푸터
    
?>	