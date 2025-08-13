<?php

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/header.php"; // 헤더

?>

<div class="sub_container">
    <div class="sub_conBox flex-vc-hc-container">
        <div class="w768">
            <div class="member_conBox">
                <p class="member_tit">서비스 약관 동의22</p>
                <form name="joinTermForm" id="joinTermForm" action="/join" method="get">
                    <input type="hidden" name="cert" class="cert" value="N">
                    <div class="tnc_listBox">
                        <div class="tnc_list tnc_checkaAll">
                            <input type="checkbox" id="checkAll" onclick="tncCheckAll();">
                            <label for="checkAll">
                                <div class="checkAll_checkBox">
                                    <p class="ov_designCheck">
                                        <span class="ov_designChecked"></span>
                                    </p>
                                    <span>모두 동의합니다.
                                </div>
                                <div class="checkAll_desc">
                                    전체 동의는 필수 및 선택정보에 대한 동의도 포함되어 있으며, 개별적으로도 동의를 선택하실 수 있습니다.<span class="lb_1920"></span>
                                    선택항목에 대한 동의를 거부하시는 경우에도 서비스는 이용이 가능합니다.
                                </div>
                            </label>
                        </div>
                        <div class="tnc_list tnc_must tnc_must1 tnc_checkEach">
                            <input type="checkbox" id="tnc1" data-val="private" onclick="tncCheckEach();">
                            <label for="tnc1">
                                <div>
                                    <p class="ov_designCheck">
                                        <span class="ov_designChecked"></span>
                                    </p>
                                    <span>[필수]</span> 개인정보 취급방침 내용에 동의합니다.
                                    <a href="/private" target="_blank">(보기)</a>
                                </div>
                            </label>
                        </div>
                        <div class="tnc_list tnc_must tnc_must2 tnc_checkEach">
                            <input type="checkbox" id="tnc2" data-val="tnc" onclick="tncCheckEach();">
                            <label for="tnc2">
                                <div>
                                    <p class="ov_designCheck">
                                        <span class="ov_designChecked"></span>
                                    </p>
                                    <span>[필수]</span> 이용약관 내용에 동의합니다.
                                    <a href="/tnc" target="_blank">(보기)</a>
                                </div>
                            </label>
                        </div>
                        <div class="tnc_list tnc_list3 tnc_checkEach">
                            <input type="checkbox" name="smsSubscribe" id="smsSubscribe" value="Y" onclick="tncCheckEach();">
                            <label for="smsSubscribe">
                                <div>
                                    <p class="ov_designCheck">
                                        <span class="ov_designChecked"></span>
                                    </p>
                                    <span>[선택]</span> SMS 및 카카오톡 수신 동의 (안내문자 및 광고문자 발송)
                                </div>
                            </label>
                        </div>
                        <div class="tnc_list tnc_list3 tnc_checkEach">
                            <input type="checkbox" name="emailSubscribe" id="emailSubscribe" value="Y" onclick="tncCheckEach();">
                            <label for="emailSubscribe">
                                <div>
                                    <p class="ov_designCheck">
                                        <span class="ov_designChecked"></span>
                                    </p>
                                    <span>[선택]</span> 이메일수신동의 (안내메일 및 광고메일 발송)
                                </div>
                            </label>
                        </div>
                    </div>
                    <p class="flex-vc-hc-container">
                        <input type="button" class="submit_btn" onclick="tncFieldCheck(); javascript:openKMCISWindow();" value="약관동의 및 휴대폰 본인인증(필수)">
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<?

    include_once dirname(dirname(dirname(dirname(__FILE__))))."/front/view/layouts/footer.php"; // 푸터
    
?>