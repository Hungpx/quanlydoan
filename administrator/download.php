<?php
ob_start();
session_start();
include_once '../Model/Base/Function.php';
include_once '../Model/SinhvienThamgia.php';
include_once '../Model/SinhvienThamgiaMapper.php';
$maSV = $_GET['maSV'];
$maDoan = $_GET['maDoan'];
if (! $maSV || ! $maDoan){
    echo 'Not File';die;
}
$svThamgia = new Model\SinhvienThamgia();
$svThamgia->setMaDoan($maDoan);
$svThamgia->setMaSV($maSV);
$svThamgiaMapper = new Model\SinhvienThamgiaMapper($connect);
if (! $svThamgiaMapper->isExist($svThamgia)){
    echo 'File Error';die;
}
$fileName = $svThamgia->getFileName();
$savePath = 'doan'.'/'.$svThamgia->getMaDoan().'/'.$svThamgia->getMaSV();
$file = getSavePath($savePath).'/'.$fileName;
if ($file && !file_exists($file)) {
    die("File not found.");
}
$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
switch ($ext) {
    case "pdf": $ctype = "application/pdf";
    break;
    case "exe": $ctype = "application/octet-stream";
    break;
    case "zip": $ctype = "application/zip";
    break;
    case "doc":
    case "docx": $ctype = "application/msword";
    break;
    case "xls": $ctype = "application/vnd.ms-excel";
    break;
    case "xlsx": $ctype = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    break;
    case "ppt":
    case "pptx": $ctype = "application/vnd.ms-powerpoint";
    break;
    case "gif": $ctype = "image/gif";
    break;
    case "png": $ctype = "image/png";
    break;
    case "jpe":
    case "jpeg":
    case "jpg": $ctype = "image/jpg";
    break;
    default: $ctype = "application/force-download";
}
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: $ctype");
header("Content-Disposition: attachment; filename=\"" .$fileName . "\";");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . filesize($file));

readfile("$file") or die("File not found!");
exit();