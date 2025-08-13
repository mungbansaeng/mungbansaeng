<?php

    include_once dirname(dirname(dirname(__FILE__)))."/public/service/emailService.php";
    include_once dirname(dirname(dirname(__FILE__)))."/front/controller/commonController.php";

    // $header .= "Cc: ".$emailCc."\r\n"; // 참조

    // 보내는사람
    $payHeader = "From: ".$config['companyName']." <mungbansaeng@naver.com>\r\n";

    // 버전
    $header .= "MIME-Version: 1.0\r\n";

    // charset
    $header .= "Content-Type: text/html; charset=UTF-8\r\n";

    if ($page == "order") {

        try {

            if ($_POST['act'] == "orderInsert") { // 주문완료 메일

                // 주문내역 메일 발송
                $subject = "[".$config['companyName']."] ".$memberSelect['name']."님의 주문 내역을 확인해주세요.";

                $emailTo = $orderSelect['buyerEmail']; // 받는 사람

                if ($orderSelect['dlvMemo']) {

                    $emailContnetsAdd = "
                        <div>
                            <div style='margin-bottom: 10px; font-size: 16px;'>배송시 요청사항 : ".$orderSelect['dlvMemo']."</div>
                        </div>
                    ";

                }

                $contents = "
                    <html>
                        <body>
                            <div style=\"width: 180px; height: 66px; text-align: center; margin: 0 auto; margin-bottom: 60px; background-image: url('https://nconnet.cafe24.com/admin/resources/upload/".$config['fileName']."');\"></div>
                            <div>
                                <p style='font-size: 32px; color: #202020; font-weight: bold; text-align: center; margin-bottom: 20px;'>주문하신 상품의<br><span style='color: #8572d6; font-weight: bold; vertical-align: baseline;'>구매가 정상적으로 완료되었습니다.</span></p>
                                <p style='font-size: 24px; color: #202020; text-align: center; margin-bottom: 20px;'>".$config['companyName']."을 이용해주셔서 감사합니다.</p>
                                <p style='text-align: center; margin-bottom: 60px; color: #7a7a7a'>주문내역에 대한 상세 정보는 [마이페이지 > 주문/배송]을 이용해주세요.</p>
                            </div>
                            <div style='width: 700px; margin: 0 auto;'>
                                <div>
                                    <p style='font-size: 20px; color: #202020; font-weight: bold; margin-bottom: 20px; border-bottom: 1px solid #000; padding-bottom: 20px'>주문정보</p>
                                    <div>
                                        <div style='margin-bottom: 10px; font-size: 16px; color: #202020;'>주문번호 : ".$orderNo."</div>
                                        <div style='margin-bottom: 10px; font-size: 16px; color: #202020;'>주문내용 : ".$orderSelect['orderTitle']."</div>
                                        <div style='margin-bottom: 10px; font-size: 16px; color: #202020;'>결제수단 : ".$orderSelect['payTypeName']."</div>
                                        <div style='margin-bottom: 40px; font-size: 16px; color: #202020;'>결제금액 : ".number_format($payPrice)."원</div>
                                    </div>
                                </div>
                                <div>
                                    <p style='font-size: 20px; color: #202020; font-weight: bold; margin-bottom: 20px; border-bottom: 1px solid #000; padding-bottom: 20px'>배송지 정보</p>
                                    <div>
                                        <div style='font-size: 16px; color: #202020; margin-bottom: 10px; font-size: 16px;'>받는분 : ".$orderSelect['buyerName']."</div>
                                    </div>
                                    <div>
                                        <div style='font-size: 16px; color: #202020; margin-bottom: 10px; font-size: 16px;'>핸드폰번호 : ".$buyerCell[0]."-".$buyerCell[1]."-".$buyerCell[2]."</div>
                                    </div>
                                    <div>
                                        <div style='font-size: 16px; color: #202020; margin-bottom: 10px; font-size: 16px;'>주소 : ".$dlvAddress[0]." ".$dlvAddresss[1]."</div>
                                    </div>
                                    ".$emailContnetsAdd."
                                </div>
                                <p style='margin-top: 60px; color: #7a7a7a'>본 메일은 발신전용 메일로 회신이 되지 않습니다. 문의사항이 있으시면 고객센터로 문의해 주시길 바랍니다.</p>
                            </div>
                        </body>
                    </html>
                ";

                // 회원일 경우 결제내역 메일 발송
                if ($memberSelect['email']) {

                    $paySubject = "[".$config['companyName']."] 결제하신 내역을 안내해드립니다.";

                    $payEmailTo = $memberSelect['email']; // 받는 사람

                    $payContents = "
                        <html>
                            <body>
                                <div style=\"width: 180px; height: 66px; text-align: center; margin: 0 auto; margin-bottom: 60px; background-image: url('https://nconnet.cafe24.com/admin/resources/upload/".$config['fileName']."');\"></div>
                                <div>
                                    <p style='font-size: 32px; color: #202020; font-weight: bold; text-align: center; margin-bottom: 20px;'>".$config['companyName']."에서<br><span style='color: #8572d6; font-weight: bold; vertical-align: baseline;'>결제하신 내역 안내드립니다.</span></p>
                                    <p style='text-align: center; margin-bottom: 60px; color: #7a7a7a'>결제내역에 대한 상세 정보는 [마이페이지 > 주문/배송]을 이용해주세요.</p>
                                </div>
                                <div style='width: 700px; margin: 0 auto;'>
                                    <div>
                                        <p style='font-size: 20px; color: #202020; font-weight: bold; margin-bottom: 20px; border-bottom: 1px solid #000; padding-bottom: 20px'>결제정보</p>
                                        <div>
                                            <div style='margin-bottom: 10px; font-size: 16px; color: #202020;'>고객명 : ".$memberSelect['name']."</div>
                                            <div style='margin-bottom: 10px; font-size: 16px; color: #202020;'>결제수단 : ".$orderSelect['payTypeName']."</div>
                                            <div style='margin-bottom: 40px; font-size: 16px; color: #202020;'>결제금액 : ".number_format($payPrice)."원</div>
                                        </div>
                                    </div>
                                    <p style='margin-top: 60px; color: #7a7a7a'>본 메일은 발신전용 메일로 회신이 되지 않습니다. 문의사항이 있으시면 고객센터로 문의해 주시길 바랍니다.</p>
                                </div>
                            </body>
                        </html>
                    ";

                    $payMail = mail($payEmailTo, $paySubject, $payContents, $header);

                    if (!$payMail) {

                        $frontLogSerice -> orderLogInsert($userNo, $cartSelect[$odc]['idx'], "ajax", "orderInsert", "orderFinish", "payMailFail");

                    }

                }

                // $memberCofigSelect = $memberService -> memberCofigSelect();
                
                // if (!$memberCofigSelect) {

                //     throw new Exception("error : memberCofigSelect");
    
                // }

                // array_push($result, $memberCofigSelect);

            } else if ($_POST['act'] == "modify") {

                $memberCofigModify = $memberService -> memberCofigModify();

            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

    }

    // 메일발송
    $orderMail = mail($emailTo, $subject, $contents, $header);

    if (!$orderMail) {

        $frontLogSerice -> orderLogInsert($userNo, $cartSelect[$odc]['idx'], "ajax", "orderInsert", "orderFinish", "payMailFail");

    }

?>