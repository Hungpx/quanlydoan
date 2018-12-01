<?php

/*  $connect = new mysqli('localhost', 'id7542538_admin', 'admin', 'id7542538_doanviethung');
define ('BASE_URL','https://doanviethung.000webhostapp.com/'); */
$connect = new mysqli( 'localhost', 'root', '', 'quanlydoan' );
define ('BASE_URL','http://localhost/quanlydoan/'); 
$connect->set_charset('utf8');
defined('DS') || define('DS', DIRECTORY_SEPARATOR); 


defined('BASE_PATH') || define('BASE_PATH', dirname(dirname(dirname(__FILE__))));
defined('MEDIA_PATH') || define('MEDIA_PATH', BASE_PATH . '/upload');

$userService = !empty($_SESSION['userService']) ? $_SESSION['userService'] : [];
function vdump($data = null) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

function toNumber($number, $options = null) {
    $number = round($number, 2);
    if(!$number) {
        return '';
    }
    $decimal = '';
    if(strpos($number, ".")) {
        list($number, $decimal) = explode(".", $number);
    }
    $result = '';
    $sign = '';
    if($number < 0) {
        $sign = '-';
        $number = $number + ($number * (-2));
    }
    while(strlen($number) > 3) {
        $result = '.' . substr($number, strlen($number)-3, 3) . $result;
        $number = substr($number, 0, strlen($number)-3);
    }
    $return = $sign . $number . $result;
    if($decimal) {
        $return .= ','. $decimal;
    }
    return $return;
}

function isGiangvien($userService){
    if(!$userService){
        return false;
    }
    if (empty($userService['nhomquyen'])){
        return false;
    }
    if ($userService['nhomquyen'] == Model\User::ROLE_TEACHER){
        return true;
    }
    return false;
}

function isAdmin($userService){
    if(!$userService){
        return false;
    }
    if (empty($userService['nhomquyen'])){
        return false;
    }
    if ($userService['nhomquyen'] == Model\User::ROLE_ADMIN){
        return true;
    }
    return false;
}

function redirect_to($page = 'index.php', $params = null){
    
    $url = BASE_URL . $page;
    if($params){
        $url .= $params;
    }
    header("Location: $url");
    exit();
}

function getLink($page = 'index.php'){
    $url = BASE_URL . $page;
    return $url;
}
function getViewPath($path){
    $url = BASE_URL . $path;
    return $url;
}

function getSavePath($path = ''){
    return MEDIA_PATH .'/'. $path;
}

function isValidFormPost($value){
    return strip_tags(trim($value));
}

function isValidPhoneNumber($number)
{
    $regexPhone = "/[0-9-()+]{9,12}/";
    if ($number) {
        if (preg_match($regexPhone, trim($number))) {
            return true;
        }
    }
    return false;
}

function toCommonDate($d)
{
    if($d){
        $date = DateTime::createFromFormat('d/m/Y', $d);
        if($date){
            return $date->format('Y-m-d');
        }
    }
    return '';
}

function toDisplayDate($d)
{
    if($d){
        $date = DateTime::createFromFormat('Y-m-d', $d);
        if($date){
            return $date->format('d/m/Y');
        }
    }
    return '';
}
function toDisplayDateTime($d)
{
    if($d){
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $d);
        if($date){
            return $date->format('d/m/Y H:i:s');
        }

    }
    return '';
}
function getCurrentDate(){
      return date('Y-m-d');
}

function getCurrentDateTime()
{
    return date('Y-m-d H:i:s');
}
