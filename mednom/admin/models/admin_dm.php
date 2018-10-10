<?php

function et_get_password_start_word($mysqli, $word_length){
    
    $stmt = $mysqli->prepare("SELECT `word` FROM `wn_synset` WHERE word REGEXP '^[a-z]{1}[asic]{1}[a-z]{" . (intval($word_length)-2) . "}$' AND tag_count > 0 ORDER BY RAND() LIMIT 1");
    if(empty($stmt)) {
        throw new Exception('Statement could not prepare on get');
    }
    $stmt->execute();
    //$res = $stmt->get_result();
    //return $res->fetch_assoc();
    // above works only if mysqlnd is supported, below is a workaround
    $stmt->store_result();
    $meta = $stmt->result_metadata();
    $params = array();
    while ($field = $meta->fetch_field()) { 
        $params[] = &$row[$field->name]; 
    }
    call_user_func_array(array($stmt, 'bind_result'), $params);
    $rows = array();
    while ($stmt->fetch()) {
        foreach($row as $key => $val) { 
            $c[$key] = $val; 
        } 
        $rows[] = $c; 
    }
    if(!empty($rows)) {
        return $rows[0]['word'];
    } else {
		return '';
	}
}

function et_get_password_end_word($mysqli, $word_length){
    
    $stmt = $mysqli->prepare("SELECT `word` FROM `wn_synset` WHERE word REGEXP '^[a-z]{" . (intval($word_length)-1) . "}[oeizs]{1}$' AND tag_count > 0 ORDER BY RAND() LIMIT 1");
    if(empty($stmt)) {
        throw new Exception('Statement could not prepare on get');
    }
    $stmt->execute();
    //$res = $stmt->get_result();
    //return $res->fetch_assoc();
    // above works only if mysqlnd is supported, below is a workaround
    $stmt->store_result();
    $meta = $stmt->result_metadata();
    $params = array();
    while ($field = $meta->fetch_field()) { 
        $params[] = &$row[$field->name]; 
    }
    call_user_func_array(array($stmt, 'bind_result'), $params);
    $rows = array();
    while ($stmt->fetch()) {
        foreach($row as $key => $val) { 
            $c[$key] = $val; 
        } 
        $rows[] = $c; 
    }
    if(!empty($rows)) {
        return $rows[0]['word'];
    } else {
		return '';
	}
}

function et_get_password_start_end_word($mysqli, $word_length){
    
    $stmt = $mysqli->prepare("SELECT `word` FROM `wn_synset` WHERE word REGEXP '^[a-z]{1}[asic]{1}[a-z]{" . (intval($word_length)-3) . "}[oeizs]{1}$' AND tag_count > 0 ORDER BY RAND() LIMIT 1");
    if(empty($stmt)) {
        throw new Exception('Statement could not prepare on get');
    }
    $stmt->execute();
    //$res = $stmt->get_result();
    //return $res->fetch_assoc();
    // above works only if mysqlnd is supported, below is a workaround
    $stmt->store_result();
    $meta = $stmt->result_metadata();
    $params = array();
    while ($field = $meta->fetch_field()) { 
        $params[] = &$row[$field->name]; 
    }
    call_user_func_array(array($stmt, 'bind_result'), $params);
    $rows = array();
    while ($stmt->fetch()) {
        foreach($row as $key => $val) { 
            $c[$key] = $val; 
        } 
        $rows[] = $c; 
    }
    if(!empty($rows)) {
        return $rows[0]['word'];
    } else {
		return '';
	}
}


function et_get_password_word($mysqli, $word_length){
    
    $stmt = $mysqli->prepare("SELECT `word` FROM `wn_synset` WHERE word REGEXP '^[a-z]{" . (intval($word_length)) . "}$' AND tag_count > 0 ORDER BY RAND() LIMIT 1");
    if(empty($stmt)) {
        throw new Exception('Statement could not prepare on get');
    }
    $stmt->execute();
    //$res = $stmt->get_result();
    //return $res->fetch_assoc();
    // above works only if mysqlnd is supported, below is a workaround
    $stmt->store_result();
    $meta = $stmt->result_metadata();
    $params = array();
    while ($field = $meta->fetch_field()) { 
        $params[] = &$row[$field->name]; 
    }
    call_user_func_array(array($stmt, 'bind_result'), $params);
    $rows = array();
    while ($stmt->fetch()) {
        foreach($row as $key => $val) { 
            $c[$key] = $val; 
        } 
        $rows[] = $c; 
    }
    if(!empty($rows)) {
        return $rows[0]['word'];
    } else {
		return '';
	}
}