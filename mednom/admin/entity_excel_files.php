<?php
require_once("header.php");
?>


<?php
$entity_name = $_GET['en'];
$view_name = $_GET['vn'];
$entity_attr = et_get_entity_attributes($mysqli, $entity_name);

require_once 'entity_excel_files_process.php';

//et_entity_add_excel_file($mysqli, $entity_attr, 'categories');
//et_entity_edit_by_identifier($mysqli, 'et_excel_files', array('status' => '1'), 'id', '1');

$new_excel_files = array();
$new_excel_files_statuses = array();
$excel_files = array();
$excel_files_statuses = array();
$excel_file_rows = et_get_all($mysqli, 'et_excel_files', array('where' => array('entity' => $entity_name)));
foreach ($excel_file_rows as $excel_file_row) {
    $excel_files[] = $excel_file_row['name'];
    $file_attr = json_decode($excel_file_row['attributes'], true);
    $file_path = $config['excels_dir'] . '/' . $entity_name . '/' . $excel_file_row['name'] . '.xls';
    $status = '';
    if (!et_check_file_access($file_path)) {
        $status = '[no access]';
    } elseif (sha1_file($file_path) != $file_attr['sha1']) {
        $status = '[modified]';
    }
    $excel_files_statuses[] = $status;
}

$files = scandir($config['excels_dir'] . '/' . $entity_name);
foreach ($files as $file) {
    $splits = explode(".", $file);
    $file_name = substr($file, 0, strlen($file) - 4);
    if (strlen($file) > 4 && end($splits) == "xls" && !in_array($file_name, $excel_files)) {
        $file_name = substr($file, 0, strlen($file) - 4);
        $new_excel_files[] = $file_name;
        $file_path = $config['excels_dir'] . '/' . $entity_name . '/' . $file_name . '.xls';
        $status = '';
        if (!et_check_file_access($file_path)) {
            $status = '[no access]';
        }
        $new_excel_files_statuses[] = $status;
    }
}
?>


    <div class="main-title"><?php echo $entity_attr['views'][$view_name]['display_name']; ?></div><br><br><br><br>

<?php


if ($_GET['en'] == 'price_list' && $_GET['vn'] = 'excel_files') {
    echo '<p  style="color: red;"><strong>Note!</strong> Excel file must be ".xls" format</p>';
    echo '<h5>Upload a File:</h5><br>';
    echo '<form action="' . $_SERVER['REQUEST_URI'] . '&module=upload_file" method="post" enctype="multipart/form-data">';
    echo '<input type="file" name="excel_file" required/>';
    echo '<input type="submit" value="upload">';
    echo '</form><hr>';

    if (isset($_GET['module']) && $_GET['module'] == 'upload_file' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = pathinfo($_FILES['excel_file']['name'])['filename'];
        $inputFileName = $config['excels_dir'] . '/price_list/' . $_FILES['excel_file']['name'];
        try {
            if ($name) {
                if (pathinfo($_FILES['excel_file']['name'])['extension'] != 'xls') {
                    throw new Exception('file name must be .xls format');
                }
            }
            if (move_uploaded_file($_FILES['excel_file']['tmp_name'], $config['excels_dir'] . '/price_list/' . $_FILES['excel_file']['name'])) {
                echo 'File Uploaded Successfully<br>';
            }
        } catch (Exception $e) {
            debug('<b>Error! ' . $e->getMessage() . '</b>');
            exit;
        }

        include_once 'includes/PHPExcel/IOFactory.php';

        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
        $generated_row = merge_price_sku($inputFileName);
        $generated_row = array_slice($generated_row, 0);
        $newArray = array();
        foreach ($generated_row as $item) {
            if ($item[0] && $item[1]) {
                $newArray[] = $item;
            }
        }

        //writing these $generated_roe to new excel
        if (createExcel($newArray, $name)) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }

    }
}


if (!empty($new_excel_files)) {

    echo ' <form action = "entity_excel_files.php?en=' . $entity_name . '&vn=' . $view_name . '" method = "post">';
    echo '<br><br><br> New Excel files: <br>';

    foreach ($new_excel_files as $index => $excel_file) {
        $file_status = $new_excel_files_statuses[$index];
        echo '<br><label style = "color:green"><input type = "checkbox" name = "new_excel_files[' . $excel_file . ']" value = "' . $excel_file . '" ' . '>' . $excel_file . ' ' . $file_status . ' </label>';
    }
    echo '<br><br><input type="submit" name="add_excel_files" value="Add">';
    echo '</form>';
}


if (!empty($excel_files)) {
    echo '<form action = "entity_excel_files.php?en=' . $entity_name . '&vn=' . $view_name . '" method = "post">';
    echo '<br><br><br> Excel files: <br> ';
    foreach ($excel_files as $index => $excel_file) {
        $file_status = $excel_files_statuses[$index];
        echo '<br><label><input type = "checkbox" name = "excel_files[' . $excel_file . ']" value = "' . $excel_file . '" ' . '>' . $excel_file . ' ' . $file_status . ' </label>';
    }
    echo '<br><br> <input type = "submit" name = "update_excel_files" value = "Update">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type = "submit" name = "remove_excel_files" value = "Remove">';
    echo '</form>';
}

//price List excel file process
function merge_price_sku($inputFileName)
{
    $all_working_sheets = _getSheets($inputFileName);
    $sku_price = array(array('SKU', 'Final_inr'));
    foreach ($all_working_sheets as $k => $sheets) {
        //remove header from each sheet
        array_splice($sheets, 0, 1);
        foreach ($sheets as $sheet) {
            $sku_price[] = array($sheet[3], $sheet[7]);
        }
    }
    return $sku_price;
}

function _getSheets($fileName)
{
    try {
        $fileType = PHPExcel_IOFactory::identify($fileName);
        $objReader = PHPExcel_IOFactory::createReader($fileType);
        $objPHPExcel = $objReader->load($fileName);
        $sheets = [];
        foreach ($objPHPExcel->getAllSheets() as $sheet) {
            $title = str_replace(' ', '_', trim($sheet->getTitle()));
            $sheets[$title] = $sheet->toArray();
        }
        return $sheets;
    } catch (Exception $e) {
        die($e->getMessage());
    }
}


function createExcel($array, $filename)
{
    date_default_timezone_set('Asia/Kolkata');
    $doc = new PHPExcel();
    $doc->setActiveSheetIndex(0);
    $doc->getActiveSheet()->fromArray($array, null, 'A1');
    $doc->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $doc->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');

    try {
        $objWriter->save(get_config()['excels_dir'] . '/price_list/' . $filename . '.xls');
        echo "File successfully Modified to new format";
        return true;
    } catch (Exception $e) {
        echo 'ERROR: ', $e->getMessage();
        die();
    }

}

?>

<?php
require_once("footer.php");
