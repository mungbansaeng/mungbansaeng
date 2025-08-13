<footer id="footer" class="flex-vc-hc-container">
    <div class="w1400 flex-vc-hsb-container">
        <div class="footer_list footer_infoBox">
            <ul>
                <li class="footer_call">고객센터 : <span class="color_strong"><?=$config['companyCall']?></span></li>
                <li>
                    대표이사: <?=$config['ceoName']?> | 사업자등록번호: <?=$config['companyRegiNumber']?> | 통신판매업: <?=$config['onlineRegiNumber']?> | 개인정보보호책임자: <?=$config['privateProtectionName']?> | 주소: <?=$config['companyAddress']?>
                </li>
                <li>
                    <a href="/private" class="footer_tnc1">[개인정보취급방침]</a>
                    <a href="/tnc" class="footer_tnc2">[이용약관]</a>
                    <a href="/customer" class="footer_tnc2">[고객센터]</a>
                </li>
            </ul>
        </div>
        <div class="footer_list footer_logoBox">
            <ul>
                <li class="footer_logo"><img src="/admin/resources/upload/<?=$config['fileName']?>" alt="로고"></li>
                <li class="copy">
                    Copyright© <?=$config['companyName']?> Corporation. All rights reserved.
                </li>
                <? if ($_SESSION['userNo']) { ?>
                <li class="m_logout" onclick="logout();">로그아웃</li>
                <?}?>
            </ul>
        </div>
    </div>
</footer>

</div>

</body>
</html>