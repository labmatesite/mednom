<?php
// commons.php v1.0


function get_mysqli()
{
    $config = get_config();
    $mysqli = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    return $mysqli;
}

function pdo_db()
{
    $config = get_config();
    $pdo = new PDO('mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'] . ';charset=utf8', $config['db_user'], $config['db_pass']);
    return $pdo;
}

function gen_password_salt()
{
    return hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
}

function csvline_encode($arr)
{
    $str = '';
    $arr2 = array();
    foreach ($arr as $value) {
        $val = trim($value);
        if (strpos($val, '"') !== false || strpos($val, ',') !== false) {
            $val = str_replace('"', '""', $val);
            $val = '"' . $val . '"';
        }
        $arr2[] = $val;
    }
    return implode(', ', $arr2);
}

function csvline_decode($str)
{
    return str_getcsv($str);
}


function refValues($arr)
{
    if (strnatcmp(phpversion(), '5.3') >= 0) //Reference is required for PHP 5.3+
    {
        $refs = array();
        foreach ($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }
    return $arr;
}

function datetime_str_to_int($datetime)
{
    $datetime = str_replace('0000-00-00', '1970-01-01', $datetime); // mysql can have dates as 0 zero but php min date is  1970-01-01
    return strtotime($datetime);
}

function datetime_int_to_str($datetime)
{
    $strtime = date('Y-m-d H:i:s', $datetime);
    return str_replace('1970-01-01', '0000-00-00', $strtime); // mysql can have dates as 0 zero but php min date is  1970-01-01
}

function date_str_to_int($date)
{
    $date = str_replace('0000-00-00', '1970-01-01', $date);
    return strtotime($date);
}

function date_int_to_str($date)
{
    $strdate = date('Y-m-d', $date);
    return str_replace('1970-01-01', '0000-00-00', $strdate);
}

function time_str_to_int($time)
{
    $strtime = '1970-01-01 ' . date('H:i:s', strtotime($time));
    return strtotime($time);
}

function time_int_to_str($time)
{
    $strtime = date('H:i:s', $time);
    return $strtime;
}


function get_query_vars($row)
{
    $keys = '';
    $assignments = '';
    $values_qm = '';
    $values_pt = ''; // param type used in myqsli 'ssss'
    $values = array();
    foreach ($row as $key => $value) {
        $keys .= ($keys != '' ? ', ' : '') . query_escape_identifier($key);
        $values_qm .= ($values_qm != '' ? ', ' : '') . '?';
        $values_pt .= 's';
        $assignments .= ($assignments != '' ? ', ' : '') . query_escape_identifier($key) . ' = ?';
        $values[] = $value;
    }
    return array('keys' => $keys, 'values_qm' => $values_qm, 'values_pt' => $values_pt, 'values' => $values, 'assignments' => $assignments);
}

function query_escape_identifier($value)
{
    return "`" . str_replace("`", "``", $value) . "`";
}


function url_dir_encode($str)
{
    /*
      tests to encode a string as a url path directory

      !"#$%&'()*+,-./:;<=>?@[\]^_`{|}~

      conclusion:

      not alowed even encoded (codeigniter)
      / - %2F
      \ - %5C
      . - %2E (dot should not be last character - browser issue)

      allowed without encoding, not encoded using rawurlencode (chrome RFC 3986, it decodes if put in encoded form except dot)
      -
      _
      ~
      . (dot if its not the last char)


      solution:

      replacements:
      <space> w -
      - w ~

      custom encoding:
      ` w `0
      ~ w `1
      _ w `2
      / w `3
      \ w `4
      . w `5 (for last character cases)

      possible bugs:

     */

    $find_arr = array(".", " ", "-", "`", rawurldecode("%E2%80%A4"), "~", "_", "/", "\\");
    $replace_arr = array(rawurldecode("%E2%80%A4"), "-", "~", "`0", "`1", "`2", "`3", "`4", "`5");

    $new_str = '';
    for ($i = 0, $n = strlen($str); $i < $n; $i++) {
        $char = $str[$i];
        $loc = array_search($char, $find_arr);
        if ($loc !== false) {
            $new_str .= $replace_arr[$loc];
        } else {
            $new_str .= $char;
        }
    }
    $str = $new_str;
    $str = rawurlencode($str);
    return $str;
}

function url_dir_decode($str)
{
    //$str = iconv("UTF-8", "UTF-8//IGNORE", $str);
    $str = str_replace("%E2%80%A4", '.', $str);  // temporary fix
    $str = html_entity_decode(rawurldecode($str)); // html entity temp fix
    //echo "<br>" .$str;
    $replace_arr = array(".", " ", "-", "`", rawurldecode("%E2%80%A4"), "~", "_", "/", "\\");
    $find_arr = array(rawurldecode("%E2%80%A4"), "-", "~", "`0", "`1", "`2", "`3", "`4", "`5");

    $new_str = '';
    $chars = '';
    $chars_window = 2;
    for ($i = 0, $n = strlen($str); $i < $n; $i++) {
        if (strlen($chars) >= $chars_window) {
            $new_str .= $chars[0];
            $chars = substr($chars, 1);
        }
        $chars .= $str[$i];
        for ($j = strlen($str) - 1; $j >= 0; $j--) {
            $loc = array_search(substr($chars, $j), $find_arr);
            if ($loc !== false) {
                $new_str .= substr($chars, 0, $j);
                $new_str .= $replace_arr[$loc];
                $chars = '';
            }
        }
    }
    $new_str .= $chars;
    $str = $new_str;
    //echo "<br>" .$str;
    return $str;
}

// taken from codeigniter
function url_title($str, $separator = '-', $lowercase = FALSE)
{
    if ($separator == 'dash') {
        $separator = '-';
    } else if ($separator == 'underscore') {
        $separator = '_';
    }

    $q_separator = preg_quote($separator);

    $trans = array(
        '&.+?;' => '',
        '[^a-z0-9 _-]' => '',
        '\s+' => $separator,
        '(' . $q_separator . ')+' => $separator
    );

    $str = strip_tags($str);

    foreach ($trans as $key => $val) {
        $str = preg_replace("#" . $key . "#i", $val, $str);
    }

    if ($lowercase === TRUE) {
        $str = strtolower($str);
    }

    return trim($str, $separator);
}

function file_exists_case_sensitive($file)
{
    if (!is_file($file)) return false;
    $directoryName = dirname($file);
    if (!is_dir($directoryName)) return false;
    $file = basename($file);
    $d = dir($directoryName);
    while (false !== ($entry = $d->read())) {
        if ($entry === $file) return true;
    }
    return false;
}

// taken from codeigniter // modified
function str_to_varname($str)
{

    $str = trim($str);

    $separator = '_';

    $q_separator = preg_quote($separator);

    $trans = array(
        '[^a-z0-9 _]' => $separator,
        '\s+' => $separator
    );

    $str = strtolower($str);

    foreach ($trans as $key => $val) {
        $str = preg_replace("#" . $key . "#i", $val, $str);
    }

    return $str;
}

function clear_data($str)
{
    $str = ForceUTF8\Encoding::toUTF8($str);
    return $str;
}

function conv_image($source, $destination, $width = 0, $height = 0, $compression = 90, $squared = false, $transparent_bg = true)
{
    $pic = new Imagick($source);
    if (empty($width) || empty($height)) {
        $width = $pic->getImageWidth();
        $height = $pic->getImageHeight();
    }
    if ($squared) {
        if ($width > $height) {
            $height = $width;
        } else {
            $width = $height;
        }
    }
    $pic->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1, true);
    $file_parts = pathinfo($destination);
    if ($file_parts['extension'] == 'png' && $transparent_bg) {
        $pic->setImageBackgroundColor('None');
    } else {
        $pic->setImageBackgroundColor(new ImagickPixel('#FFFFFF'));
        $pic = $pic->flattenImages();
    }
    if ($squared) {
        $pic->extentImage($width, $height, -($width - $pic->getImageWidth()) / 2, -($height - $pic->getImageHeight()) / 2);
    }
    if (!empty($compression)) {
        $pic->setImageCompression(Imagick::COMPRESSION_JPEG);
        $pic->setImageCompressionQuality($compression);
    }
    $pic->writeImage($destination);
    $pic->destroy();
}

