<?php
if (!empty($_POST['add_excel_files']) && !empty($_POST['new_excel_files'])) {

    foreach ($_POST['new_excel_files'] as $file) {

        try {
            $mysqli->autocommit(FALSE);
            et_add_excel_file($mysqli, $entity_attr, $file);
            $entity_attr = et_get_entity_attributes($mysqli, $entity_attr['name']);
            $mysqli->commit();
        } catch (Exception $e) {
            echo 'Error while adding excel file >> ', $e->getMessage(), "\n";
            debug($e->getTrace());
        }

    }
} elseif (!empty($_POST['update_excel_files']) && !empty($_POST['excel_files'])) {
    foreach ($_POST['excel_files'] as $file) {
        try {
            $mysqli->autocommit(FALSE);
            et_update_excel_file($mysqli, $entity_attr, $file);
            $entity_attr = et_get_entity_attributes($mysqli, $entity_attr['name']);
            $mysqli->commit();
        } catch (Exception $e) {
            echo 'Error while updating excel file >> ', $e->getMessage(), "\n";
            debug($e->getTrace());
        }

    }
} elseif (!empty($_POST['remove_excel_files']) && !empty($_POST['excel_files'])) {
    foreach ($_POST['excel_files'] as $file) {

        try {
            $mysqli->autocommit(FALSE);
            et_remove_excel_file($mysqli, $entity_attr, $file);
            $mysqli->commit();
        } catch (Exception $e) {
            echo 'Error while removing excel file >> ', $e->getMessage(), "\n";
            debug($e->getTrace());
        }

    }
}