<?php

require_once("lib/UploadImage.php");

$upload = new UploadImage();

if (!$upload->upload('./uploads/')) {
    exit(json_encode([
        'code' => 0,
        'message' => $upload->getErrorMsg()
    ]));
} else {
    $info = $upload->getUploadFileInfo();

    exit(json_encode([
        'code' => 1,
        'url' => "uploads/{$info[0]['savename']}",
        'name' => $info[0]['savename']
    ]));
}