<?php

function csvline_encode($arr) {
    $str = '';
    $arr2 = array();
    foreach($arr as $value) {
        $val = trim($value);
        if(strpos($val,'"') !== false || strpos($val,',') !== false) {
            $val = str_replace('"','""',$val);
            $val = '"' . $val . '"';
        }
        $arr2[] = $val;
    }
    return implode(', ', $arr2);
}

function csvline_decode($str) {
    return str_getcsv($str);
}

function url_dir_encode($str) {
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
            $new_str.= $replace_arr[$loc];
        } else {
            $new_str.= $char;
        }
    }
    $str = $new_str;
    $str = rawurlencode($str);
    return $str;
}

function url_dir_decode($str) {
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
                $new_str.= $replace_arr[$loc];
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
function url_title($str, $separator = '-', $lowercase = FALSE) {
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



// taken from codeigniter // modified
function str_to_varname($str) {

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

function clear_data($str) {
    $str = ForceUTF8\Encoding::toUTF8($str);
    return $str;
}

function conv_image($source, $destination, $width, $height) {
    $pic = new Imagick($source);
    $pic->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1, true);
    $pic->extentImage($width, $height, -($width - $pic->getImageWidth()) / 2, -( $height - $pic->getImageHeight()) / 2);
    $pic->setImageCompression(Imagick::COMPRESSION_JPEG);
    $pic->setImageCompressionQuality(90);
    $pic->writeImage($destination);
    $pic->destroy();
}

/*
  function to_key($str) { //used for column names
  return preg_replace('/[^A-Za-z0-9]/', '_', strtolower(trim($str)));  //convert all chars except alphanumeric to '_'
  }

  function to_filename($str) { //used for image names
  return preg_replace('/[^A-Za-z0-9]/', '-', trim($str));  //convert all chars except alphanumeric to '-'
  }

  function to_filename_lower($str) { //used for pdf names
  return preg_replace('/[^A-Za-z0-9]/', '-', strtolower(trim($str)));  //convert all chars except alphanumeric to '-'
  }
 */

function get_query_vars($row) {
    $keys = '';
    $assignments = '';
    $values_qm = '';
    $values = array();
    foreach ($row as $key => $value) {
        $keys .= ($keys != '' ? ', ' : '') . '`' . $key . '`';
        $values_qm .= ($values_qm != '' ? ', ' : '') . '?';
        $assignments .= ($assignments != '' ? ', ' : '') . '`' . $key . '` = ?';
        $values[] = $value;
    }
    return array('keys' => $keys, 'values_qm' => $values_qm, 'values' => $values, 'assignments' => $assignments);
}
