<?

function compress_image($source, $destination, $quality) {

    $info = getimagesize($source);

    if($info['mime'] == 'image/jpeg'){
        
        $image = imagecreatefromjpeg($source);
        
    }else if($info['mime'] == 'image/gif'){
        
        $image = imagecreatefromgif($source);
        
    }else if($info['mime'] == 'image/png'){
        
        $image = imagecreatefrompng($source);
        
    }

    imagejpeg($image, $destination, $quality);
    
    return $destination;
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES) && $_FILES['upload']['size'] > 0) {

    $path = $_POST['path'];

    $path = str_replace('../', '', $path).'/';

    $uploadsrc = '/ckeditor/tempUpload'.$path;

    $uploadpath = $_SERVER['DOCUMENT_ROOT'].$uploadsrc;

    if (!is_dir($uploadpath)){

        mkdir($uploadpath, 0707);

        chmod($uploadpath, 0707);

    }

    $filename = $_FILES['upload']['name'];

    $tmpname = $_FILES['upload']['tmp_name'];

    $ext = strtolower(substr(strrchr($filename,'.'), 1));

    $filename = strpos(rawurlencode($filename),'%') !== false ? (microtime(true)*10000).'.'.$ext : $filename;

    $newFileName = time().'_'.mt_rand(0,99999).$filename;
    
    $savefilename = $uploadpath.$newFileName;

    $uploaded_file = '';

    if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'png') {

        $image_info = getimagesize($tmpname);

        if ($image_info['mime'] == 'image/png' || $image_info['mime'] == 'image/jpeg' || $image_info['mime'] == 'image/gif'){
            
//            $savefilename = $uploadpath.$filename;
//            
//            $compressImg = compress_image($tmpname, $savefilename, 80);
//            
//            $buffer = file_get_contents($savefilename);
//            
//            if($buffer){
//                
//                $uploaded_file = $filename;
//                
//            }  압축하고 이미지 업로드(jpg로만 저장됨)
            
            // 압축안하고 이미지 그대로 업로드 시작
            
            if (move_uploaded_file($tmpname, iconv('utf-8', 'cp949', $savefilename))) {

                $uploaded_file = $newFileName;

            }  
            
            // 압축안하고 이미지 그대로 업로드 끝

        } else {

                echo json_encode(array(

                    'uploaded'=>'0',

                    'error'=>array('message'=>'이미지 파일의 형식이 올바르지 않습니다.')

                ));

                exit;

        }

    } else {

        echo json_encode(array(

            'uploaded'=>'0',

            'error'=>array('message'=>'jpg, jpeg, gif, png 파일만 업로드가 가능합니다.')

        ));

        exit;

    }

} else {

    echo json_encode(array(

        'uploaded'=>'0',

        'error'=>array('message'=>'업로드중 문제가 발생하였습니다.')

    ));

    exit;

}

echo json_encode(array(

    'uploaded'=>'1',

    'fileName'=>$uploaded_file,

    'url'=>$uploadsrc.$uploaded_file,

));

exit;

?>