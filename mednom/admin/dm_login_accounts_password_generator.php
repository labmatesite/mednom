<?php
require_once("header.php");
?>

<?php

// need to display names, search by any value on fields
$entity_name = $_GET['en'];
$view_name = $_GET['vn'];
$entity_attr = et_get_entity_attributes($mysqli, $entity_name);




$letter_symbol = array(
    'a' => '@',
    's' => '$',
    'i' => '!',
    'c' => '('
);
$letter_number = array(
    'o' => '0',
    'e' => '3',
    'i' => '1',
    'z' => '2',
    's' => '5'
);


$length = 10;
$words = 2;
$min_word_length  = 4;
$max_word_length  = 10;
$no_capital = 0;
$no_symbol = 0;
$no_number = 0;

if(!empty($_POST['length'])) {
    $length = $_POST['length'];
}
if(!empty($_POST['words'])) {
    $words = $_POST['words'];
}
if(!empty($_POST['min_word_length'])) {
    $min_word_length = $_POST['min_word_length'];
}
if(!empty($_POST['length'])) {
    $max_word_length = $_POST['max_word_length'];
}
if(!empty($_POST['no_capital'])) {
    $no_capital = $_POST['no_capital'];
}
if(!empty($_POST['no_symbol'])) {
    $no_symbol = $_POST['no_symbol'];
}
if(!empty($_POST['no_number'])) {
    $no_number = $_POST['no_number'];
}


?>


<div class="main-title"><?php echo $entity_attr['views'][$view_name]['display_name']; ?></div><br><br><br><br>
<?php
echo '<form action="' . $entity_attr['views'][$view_name]['view_file'] . '.php?en=' . $entity_name . '&vn='.$view_name . '" method="post">';

echo 'length: <input type="number" name="length" min="3" value="' . $length . '" style="width:40px"> &nbsp;&nbsp;&nbsp;';
echo 'words:  <input type="number" name="words" min="1" value="' . $words . '"  style="width:40px">  &nbsp;&nbsp;&nbsp;';
echo 'min word length:  <input type="number" name="min_word_length" min="3" value="' . $min_word_length . '"  style="width:40px"> &nbsp;&nbsp;&nbsp;';
echo 'max word length:  <input type="number" name="max_word_length" min="3" value="' . $max_word_length . '"  style="width:40px"> &nbsp;&nbsp;&nbsp;';
echo '<label><input type="checkbox" name="no_capital" value="1" ' . (($no_capital)? 'checked' : '') . '> no capital</label> &nbsp;&nbsp;&nbsp;';
echo '<label><input type="checkbox" name="no_symbol" value="1" ' . (($no_symbol)? 'checked' : '') . '> no symbol</label> &nbsp;&nbsp;&nbsp;';
echo '<label><input type="checkbox" name="no_number" value="1" ' . (($no_number)? 'checked' : '') . '> no number</label> &nbsp;&nbsp;&nbsp;';


echo '<br><br><input type="submit" name="submit" value="GENERATE"><br>';
echo '</form>';
//length
//words
//no caps
//no Symbol
//no number


$est_words = ceil($length / $min_word_length);
if($est_words > $words) {
    $est_words = $words;
}
$est_length = $length;
$min_est_length = $est_words * $min_word_length;
$max_est_length = $est_words * $max_word_length;
if($est_length < $min_est_length) {
    $est_length = $min_est_length;
}
if($est_length > $max_est_length) {
    $est_length = $max_est_length;
}

//var_dump($est_words);
//var_dump($est_length);

for($i = 0; $i < 5; $i++){
    $password = '';
    $words_arr = array();
    $tries = 5;
    while(empty($password) && !empty($tries)) {
        $tries--;
        $new_password = '';
        
        // FIRST WORD
        if(empty($no_symbol)) {
            if($est_words > 1) {
                $min = $min_word_length;
                $max = $est_length - (($est_words - 1) * $min_word_length);
                $word_length = rand($min,$max);
                $word = et_get_password_start_word($mysqli, $word_length);
            } else {
                $word_length = $est_length;
                $word = et_get_password_start_end_word($mysqli, $word_length);
            }
        } else {
            if($est_words > 1) {
                $min = $min_word_length;
                $max = $est_length - (($est_words - 1) * $min_word_length);
                $word_length = rand($min,$max);
                $word = et_get_password_word($mysqli, $word_length);
            } else {
                $word_length = $est_length;
                $word = et_get_password_word($mysqli, $word_length);
            }
        }
        //BREAKER
        if(!empty($word)){
            $new_password .= $word;
            $words_arr[] = $word;
            //echo '<br>' . $word;
        } else {
            break; // try again
        }
        //echo $new_password;
        
        
        // MID WORDS
        if($est_words-2 > 0) {
            $mid_words = '';
            for($j = 0; $j < $est_words-2 ; $j++){
                $min = $min_word_length;
                $max = ($est_length - strlen($new_password)) - (($est_words - (2 + $j)) * $min_word_length);
                $word_length = rand($min,$max);
                $word = et_get_password_word($mysqli, $word_length);
                
                //BREAKER
                if(!empty($word)){
                    $mid_words .= $word;
                    $new_password .= $word;
                    $words_arr[] = $word;
                } else {
                    break; // try again
                }
            }
            //BREAKER
            if(empty($mid_words)){
                break; // try again
            }
        }
        
        
        //LAST WORD
        if($est_words > 1) {
            if(empty($no_number)) {
                $word_length = ($est_length - strlen($new_password));
                $word = et_get_password_end_word($mysqli, $word_length);
            } else {
                $word_length = ($est_length - strlen($new_password));
                $word = et_get_password_word($mysqli, $word_length);
            }
            //BREAKER
            if(!empty($word)){
                $new_password .= $word;
                $words_arr[] = $word;
                //echo '<br>' . $word;
            } else {
                break; // try again
            }
        }
        
        //var_dump($new_password);
        //OPERATIONS
        $new_password = strtolower($new_password);
        if(empty($no_capital)){
            $new_password = strtoupper(substr($new_password, 0, 1)) . substr($new_password, 1);
        }
        if(empty($no_symbol)){
            $new_password = substr($new_password, 0, 1) . $letter_symbol[substr($new_password, 1, 1)] . substr($new_password, 2);
        }
        if(empty($no_number)){
            $new_password = substr($new_password, 0, strlen($new_password) - 1) . $letter_number[substr($new_password, strlen($new_password) - 1, 1)];
        }
        
        
        //DONE
        $password = $new_password;
    }
    
    echo '<br><br><input type="text" value="' . htmlspecialchars($password) . '"> ' . implode(' ', $words_arr);
}



?>


<?php
require_once("footer.php");
