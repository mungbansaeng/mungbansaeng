<?php

    // ajax로 넘어오는 데이터 $page로 통일시키기

    if ($_POST['page']) {

        $page = $_POST['page'];

    }

    include_once dirname(dirname(dirname(__FILE__)))."/public/common/config.php";
    include_once dirname(dirname(dirname(__FILE__)))."/public/service/commonService.php";

    $dbService = new DbService();
    $attachFileService = new AttachFileService();

    $result = array("success");

    // 파일첨부
    if ($page == "attachFile") {

        try {

            if ($_POST["act"] == "reg") {

                $dbService -> tableCheck($_POST['table']."UploadFile");

                $error = 0;

                $attachFileIdxArr = array();
                $tempBoardIdxArr = array();
                $tempBoardIdx = time();

                // 등록할때 이전에 첨부한 파일 개수 체크
                $fileNumCount = $attachFileService -> attachFileSelectNum($_POST['table'], $tempBoardIdx);

                if ($fileNumCount > 0) {

                    $fileNum = $fileNumCount;

                } else {

                    $fileNum = 0;

                }

                for ($ac=0; $ac < COUNT($_POST['uploadTransFileName']); $ac++) {

                    if ($_POST['table'] == "review") {

                        if (($_FILES['uploadFiles']['type'][$ac] == "image/jpg")
                        || ($_FILES['uploadFiles']['type'][$ac] == "image/jpeg")
                        || ($_FILES['uploadFiles']['type'][$ac] == "image/gif")
                        || ($_FILES['uploadFiles']['type'][$ac] == "image/png")
                        || ($_FILES['uploadFiles']['type'][$ac] == "image/bmp")) {
                    
                            $_POST['type'] = "photo";
                    
                        } else {
                    
                            $_POST['type'] = "video";
                    
                        }

                    }
            
                    $fileDir = "../../".$_POST['officeType']."/resources/upload/".$_POST['uploadTransFileName'][$ac];
                
                    $movedAttach = move_uploaded_file($_FILES['uploadFiles']['tmp_name'][$ac], $fileDir); // 파일 업로드

                    // 파일이 업로드 됐을때
                    if($movedAttach){

                        $saveUplodName = $_POST['uploadTransFileName'][$ac];
                        $orginUplodName = $_POST['uploadOriginFileName'][$ac];
                        $fileType = $_POST['type'];

                        array_push($tempBoardIdxArr, $tempBoardIdx);

                        $fileNum++;

                        // 파일첨부 등록
                        $attachFileTempIdx = $attachFileService -> attachFileInsert($_POST['table'], $saveUplodName, $orginUplodName, $postIdxColum, $postIdx, $fileNum, $fileType, $tempBoardIdx);

                        if (!$attachFileTempIdx) {

                            $error++;

                        } else {

                            $attachFileIdx = mysqli_insert_id($conn); // insert될때 pk값

                            array_push($tempBoardIdxArr, $attachFileTempIdx);
                            array_push($attachFileIdxArr, $attachFileIdx);

                        }

                    }

                }

                array_push($result, $attachFileIdxArr);
                array_push($result, $tempBoardIdxArr);

                if ($error !== 0) {

                    throw new Exception("error : attachUploadFail");

                }

            } else if ($_POST["act"] == "del") {

                $fileDir = "../../".$_POST['officeType']."/resources/upload/".$_POST['transfileName'];

                unlink($fileDir); // 파일 삭제

                // db 삭제
                $delAttach = $attachFileService -> attachFileDelete($_POST['table'], $_POST['fileIdx']);

                if ($delAttach == "success") {

                    // 등록된 첨부파일 조회
                    $attachFileInfo = $attachFileService -> attachFileSelect($_POST['table'], "0", "ASC");

                    for ($rn=0; $rn < COUNT($attachFileInfo); $rn++) {

                        $fileNum = $rn + 1;

                        // fileNum 재설정
                        $fileUpdateNum = $attachFileService -> attachFileUpdateNum($_POST['table'], $attachFileInfo[$rn]['idx'], $fileNum);

                        if (!$fileUpdateNum) {

                            throw new Exception("error : attachFileUpdateNum");
            
                        }

                    }
    
                } else {

                    throw new Exception("error : attachDelFail");

                }

            }

        } catch (Exception $errorMsg) {

            echo $errorMsg;

            exit;

        }

        echo json_encode($result);

    }

?>