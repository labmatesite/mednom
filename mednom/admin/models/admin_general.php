<?php


//*******************************  QUERY FUNCTIONS  **********************************


function et_get_by_identifier($mysqli, $entity, $identifier_name, $identifier_value)
{
    //echo "SELECT * FROM " . query_escape_identifier($entity) . " WHERE " . query_escape_identifier($identifier_name) . " = ? ";
    //echo "value :" . $identifier_value;
    //if(empty($identifier_value)) {
    //    throw new Exception('err');
    //}

    $stmt = $mysqli->prepare("SELECT * FROM " . query_escape_identifier($entity) . " WHERE " . query_escape_identifier($identifier_name) . " = ? ");
    if (empty($stmt)) {
        throw new Exception('Statement could not prepare on get');
    }
    $stmt->bind_param('s', $identifier_value);
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
        foreach ($row as $key => $val) {
            $c[$key] = $val;
        }
        $rows[] = $c;
    }
    if (!empty($rows)) {
        return $rows[0];
    }
}

function et_get_all($mysqli, $entity, $query_attr = array())
{
    $values = array();
    $values_pt = '';
    $where = '';
    if (!empty($query_attr['where'])) {
        $where .= " WHERE";
        $where_conditions = '';
        foreach ($query_attr['where'] as $column => $value) {
            $where_conditions .= (($where_conditions) ? " AND " : " ") . query_escape_identifier($column) . " = ?";
            $values[] = $value;
            $values_pt .= 's';
        }
        $where .= $where_conditions;
    }
    $group_by = '';
    if (!empty($query_attr['group_by'])) {
        $group_by .= " GROUP BY";
        foreach ($query_attr['group_by'] as $index => $column) {
            $group_by .= (($index) ? "," : "") . " " . query_escape_identifier($column);
        }
    }
    $order_by = '';
    $order_type = '';
    if (!empty($query_attr['order_by'])) {
        $order_by .= " ORDER BY";
        foreach ($query_attr['order_by'] as $index => $column) {
            $order_by .= (($index) ? "," : "") . " " . query_escape_identifier($column);
        }
        if (!empty($query_attr['order_type']) && ($query_attr['order_type'] == 'ASC' || $query_attr['order_type'] == 'DESC')) {
            $order_type = " " . $query_attr['order_type'];
        }
    }
    $limit = '';
    if (!empty($query_attr['limit'])) {
        $limit .= " LIMIT ";
        if (!empty($query_attr['limit']['offset'])) {
            $limit .= (int)$query_attr['limit']['offset'];
        }
        $limit .= (int)$query_attr['limit']['no_of_rows'];
    }
    //echo "SELECT * FROM " . query_escape_identifier($entity) . $where . $order_by . $order_type . $limit;
    $stmt = $mysqli->prepare("SELECT * FROM " . query_escape_identifier($entity) . $where . $group_by . $order_by . $order_type . $limit);
    if (empty($stmt)) {
        throw new Exception('Statement could not prepare on get_all ' . $mysqli->error);
    }
    if (!empty($values)) {
        $params = array_merge(
            array($values_pt),
            $values
        );
        call_user_func_array(array($stmt, 'bind_param'), refValues($params));
    }
    $stmt->execute();
    //$res = $stmt->get_result();
    //$rows = array();
    //while($row = $res->fetch_assoc()) {
    //    $rows[] = $row;
    //}
    //return $rows;
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
        foreach ($row as $key => $val) {
            $c[$key] = $val;
        }
        $rows[] = $c;
    }
    return $rows;
}


function et_edit_by_identifier($mysqli, $entity, $row, $identifier_name, $identifier_value, $ignore_unchanged = false)
{
    $qv = get_query_vars($row);
    $qv['values'][] = $identifier_value; // for where condition;
    $qv['values_pt'] .= 's';
    //echo "UPDATE " . query_escape_identifier($entity) . " SET " . $qv['assignments'] . " WHERE " . query_escape_identifier($identifier_name) . " = ? ";
    //if($entity == 'et_excel_files') {
    //    echo "<br>UPDATE " . query_escape_identifier($entity) . " SET " . $qv['assignments'] . " WHERE " . query_escape_identifier($identifier_name) . " = ? ";
    //    if(isset($row['status'])) {
    //        throw new Exception('status error');
    //    }
    //}
    $stmt = $mysqli->prepare("UPDATE " . query_escape_identifier($entity) . " SET " . $qv['assignments'] . " WHERE " . query_escape_identifier($identifier_name) . " = ? ");
    if (empty($stmt)) {
        throw new Exception('Statement could not prepare on update');
    }
    if (!empty($qv['values'])) {
        $params = array_merge(
            array($qv['values_pt']),
            $qv['values']
        );
        call_user_func_array(array($stmt, 'bind_param'), refValues($params));
    }
    $stmt->execute();
    if ($mysqli->affected_rows == -1) {
        throw new Exception('Error occured on update');
    } elseif ($mysqli->affected_rows < 1 && !$ignore_unchanged) {
        throw new Exception('No rows affected on update');
    }
}


function et_add($mysqli, $entity, $row)
{
    $qv = get_query_vars($row);
    //echo "INSERT INTO " . query_escape_identifier($entity) . " (" . $qv['keys'] . ") VALUES(" . $qv['values_qm'] . ")  ";
    $stmt = $mysqli->prepare("INSERT INTO " . query_escape_identifier($entity) . " (" . $qv['keys'] . ") VALUES(" . $qv['values_qm'] . ")  ") or print($mysqli->error);
    if (empty($stmt)) {
        throw new Exception('Statement could not prepare on add ' . $mysqli->error);
    }
    if (!empty($qv['values'])) {
        $params = array_merge(
            array($qv['values_pt']),
            $qv['values']
        );
        call_user_func_array(array($stmt, 'bind_param'), refValues($params));
    }
    $stmt->execute();
    if ($mysqli->affected_rows == -1) {
        throw new Exception('Error occured on add');
    } elseif ($mysqli->affected_rows < 1) {
        throw new Exception('No rows affected on add');
    } else {
        return $mysqli->insert_id;
    }
}


function et_delete_by_identifier($mysqli, $entity, $identifier_name, $identifier_value)
{
    $stmt = $mysqli->prepare("DELETE FROM " . query_escape_identifier($entity) . " WHERE " . query_escape_identifier($identifier_name) . " = ? ");
    if (empty($stmt)) {
        throw new Exception('Statement could not prepare on delete');
    }
    $stmt->bind_param('s', $identifier_value);
    $stmt->execute();
    if ($mysqli->affected_rows == -1) {
        throw new Exception('Error occured on delete ' . $mysqli->error);
    } elseif ($mysqli->affected_rows < 1) {
        throw new Exception('No rows affected on delete ' . $mysqli->error);
    }
}


function et_get_table_fields($mysqli, $entity)
{
    $stmt = $mysqli->prepare("SHOW FIELDS FROM " . query_escape_identifier($entity));
    $stmt->execute();
    //$res = $stmt->get_result();
    //$rows = array();
    //while($row = $res->fetch_assoc()) {
    //    $rows[] = $row;
    //}
    //return $rows;
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
        foreach ($row as $key => $val) {
            $c[$key] = $val;
        }
        $rows[] = $c;
    }
    return $rows;
}


//*******************************  NON QUERY FUNCTIONS  **********************************


function et_get_combined_by_identifier($mysqli, $entity_attr, $identifier_name, $identifier_value)
{
    $table_row = array();
    $excel_row = array();
    $combined_row = array();
    $excel_identifier_value = $identifier_value;

    $table_row = et_get_by_identifier($mysqli, $entity_attr['name'], $identifier_name, $identifier_value);

    if (!empty($entity_attr['use_excels'])) {
        if ($entity_attr['excel_identifier'] == '') {
            $excel_identifier_value = $table_row['excel_identifier_value'];
        } elseif (!empty($table_row)) {
            $excel_identifier_value = $table_row[$entity_attr['excel_identifier']];
        } else {
            $excel_identifier_value = $identifier_value;
        }
        $excel_entry = et_get_by_identifier($mysqli, 'et_excel_entries', 'unique_value', $entity_attr['name'] . '_' . $excel_identifier_value);
        $excel_row = json_decode($excel_entry['entry'], true);
    }

    foreach ($entity_attr['columns_attributes'] as $column_name => $column_attr) {
        if (isset($table_row[$column_name])) {
            $combined_row[$column_name] = $table_row[$column_name];
        } elseif (isset($excel_row[$column_name])) {
            $combined_row[$column_name] = $excel_row[$column_name];
        }
    }

    return $combined_row;
}

function et_delete_combined_by_identifier($mysqli, $entity_attr, $identifier_name, $identifier_value, $save_excel = true, $excel_file_id = false)
{

    $table_row = et_get_by_identifier($mysqli, $entity_attr['name'], $identifier_name, $identifier_value);
    if (empty($table_row)) {
        throw new Exception('row to delete does not exists');
    }
    if (!empty($entity_attr['use_excels'])) {
        if ($entity_attr['excel_identifier'] == '') {
            $excel_identifier_value = $table_row['excel_identifier_value'];
        } else {
            $excel_identifier_value = $identifier_value;
        }
        if (!empty($save_excel) && empty($excel_file_id)) {
            $excel_entry = et_get_by_identifier($mysqli, 'et_excel_entries', 'unique_value', $entity_attr['name'] . '_' . $excel_identifier_value);
            $excel_file_id = $excel_entry['excel_file_id'];
        }
    }
    et_delete_by_identifier($mysqli, $entity_attr['name'], $identifier_name, $identifier_value);

    if (!empty($entity_attr['use_excels'])) {
        et_delete_by_identifier($mysqli, 'et_excel_entries', 'unique_value', $entity_attr['name'] . '_' . $excel_identifier_value);
        if (!empty($save_excel)) {
            et_save_excel_file_by_idenitifier($mysqli, $entity_attr, 'id', $excel_file_id);
        }
    }
}

function et_get_combined_all($mysqli, $entity_attr, $query_attr = array())
{

    // NEEDS PROPER IMPLEMENTATION

    $table_rows = et_get_all($mysqli, $entity_attr['name'], $query_attr);
    if (!empty($entity_attr['use_excels'])) {
        $combined_rows = array();
        foreach ($table_rows as $table_row) {
            $combined_row = array();
            if ($entity_attr['excel_identifier'] == '') {
                $excel_identifier_value = $table_row['excel_identifier_value'];
            } else {
                $excel_identifier_value = $table_row[$entity_attr['excel_identifier']];
            }
            $excel_entry = et_get_by_identifier($mysqli, 'et_excel_entries', 'unique_value', $entity_attr['name'] . '_' . $excel_identifier_value);
            $excel_row = json_decode($excel_entry['entry'], true);
            foreach ($entity_attr['columns_attributes'] as $column_name => $column_attr) {
                if (isset($table_row[$column_name])) {
                    $combined_row[$column_name] = $table_row[$column_name];
                } elseif (isset($excel_row[$column_name])) {
                    $combined_row[$column_name] = $excel_row[$column_name];
                }
            }
            $combined_rows[] = $combined_row;
        }
        return $combined_rows;

    } else {
        return $table_rows;
    }

}

function et_add_combined($mysqli, $entity_attr, $row, $excel_file_id = false, $excel_order = false, $save_excel = true)
{

    $ret_array = array();
    $columns_attr = $entity_attr['columns_attributes'];

    if (!empty($entity_attr['use_excels'])) {

        if (empty($excel_file_id)) {
            $excel_files = et_get_all($mysqli, 'et_excel_files', array('where' => array('name' => $entity_attr['name'], 'entity' => $entity_attr['name'])));
            if (empty($excel_files)) {
                throw new Exception('Default Excel file does not exist on add');
            }
            $excel_file_row = $excel_files[0];
            $excel_file_id = $excel_file_row['id'];
        } else {
            $excel_file_row = et_get_by_identifier($mysqli, 'et_excel_files', 'id', $excel_file_id);
            if (empty($excel_file_row)) {
                throw new Exception('Excel file does not exist on add');
            }
        }

        if (empty($excel_order)) {
            $last_entries = et_get_all($mysqli, 'et_excel_entries', array('where' => array('excel_file_id' => $excel_file_id), 'order_by' => array('excel_order'), 'order_type' => 'DESC', 'limit' => array('no_of_rows' => '1')));
            if (empty($last_entries)) {
                $excel_order = 1;
            } else {
                $excel_order = ((int)$last_entries[0]['excel_order']) + 1;
            }
        }

        if ($entity_attr['excel_identifier'] == '') {
            $excel_identifier_value = $excel_file_id . '_' . $excel_order;
        } else {
            $excel_identifier_value = $row[$entity_attr['excel_identifier']];
        }

    }


    $table_row = array();
    foreach ($row as $key => $value) {
        if (!empty($columns_attr[$key]['table_column'])) {
            $table_row[$key] = $value;
        }
    }


    if (!empty($entity_attr['use_excels']) && $entity_attr['excel_identifier'] == '') {
        $table_row['excel_identifier_value'] = $excel_identifier_value;
    }

    $ret_array['table_row_id'] = et_add($mysqli, $entity_attr['name'], $table_row);

    if (!empty($entity_attr['use_excels'])) {

        $excel_file_attr = json_decode($excel_file_row['attributes'], true);
        $excel_file_columns_attr = $excel_file_attr['columns_attr'];
        $excel_row = array();
        foreach ($row as $key => $value) {
            if (!empty($columns_attr[$key]['excel_column'])) {
                if (isset($excel_file_columns_attr[$key]) || isset($excel_row[$key])) {
                    $excel_row[$key] = $value;
                } elseif ($value != '' && (($columns_attr[$key]['data_type_details']['type'] != 'json_array' && $columns_attr[$key]['data_type_details']['type'] != 'json_object') || ($value != '[]' && $value != '{}'))) {
                    $excel_row[$key] = $value;
                }
            }
        }


        $ret_array['excel_entry_id'] = et_add($mysqli, 'et_excel_entries', array(
            'unique_value' => $entity_attr['name'] . '_' . $excel_identifier_value,
            'identifier_value' => $excel_identifier_value,
            'entity' => $entity_attr['name'],
            'entry' => json_encode($excel_row),
            'last_modified' => datetime_int_to_str(time()),
            'excel_order' => $excel_order,
            'excel_file_id' => $excel_file_id
        ));
        if (!empty($save_excel)) {
            et_save_excel_file_by_idenitifier($mysqli, $entity_attr, 'id', $excel_file_id);
        }
    }

    return $ret_array;
}


function et_edit_combined_by_identifier($mysqli, $entity_attr, $row, $identifier_name, $identifier_value, $excel_file_id = false, $save_excel = true, $complete_row = false)
{

    // silent, does not error on unchanged rows

    $columns_attr = $entity_attr['columns_attributes'];
    $table_row = array();
    foreach ($columns_attr as $column_name => $column_attr) {
        if (!empty($column_attr['table_column'])) {
            if (isset($row[$column_name])) {
                $table_row[$column_name] = $row[$column_name];
            } elseif ($complete_row && !empty($column_attr['excel_column'])) {
                if ($column_attr['data_type_details']['type'] == 'json_array') {
                    $table_row[$column_name] = '[]';
                } elseif ($column_attr['data_type_details']['type'] == 'json_object') {
                    $table_row[$column_name] = '{}';
                } else {
                    $table_row[$column_name] = '';
                }
            }
        }
    }
    et_edit_by_identifier($mysqli, $entity_attr['name'], $table_row, $identifier_name, $identifier_value, true); // ignore unchanged, as ther could be changes in gen extra functions

    if (!empty($entity_attr['use_excels'])) {

        if ($entity_attr['excel_identifier'] == '') {
            $tab_row = et_get_by_identifier($mysqli, $entity_attr['name'], $identifier_name, $identifier_value);
            $excel_identifier_value = $tab_row['excel_identifier_value'];
        } else {
            $excel_identifier_value = $row[$entity_attr['excel_identifier']];
        }


        if (empty($excel_file_id) || !$complete_row) {
            $excel_entry = et_get_by_identifier($mysqli, 'et_excel_entries', 'unique_value', $entity_attr['name'] . '_' . $excel_identifier_value);
            $excel_file_id = $excel_entry['excel_file_id'];
        }

        $excel_file_row = et_get_by_identifier($mysqli, 'et_excel_files', 'id', $excel_file_id);
        if (empty($excel_file_row)) {
            throw new Exception('Excel file does not exist on edit');
        }


        $excel_row = array();
        if (!$complete_row) {
            $excel_row = json_decode($excel_entry['entry'], true);
            foreach ($row as $key => $value) {
                if (!empty($columns_attr[$key]['excel_column'])) {
                    $excel_row[$key] = $value;
                }
            }
        }
        $excel_file_attr = json_decode($excel_file_row['attributes'], true);
        $excel_file_columns_attr = $excel_file_attr['columns_attr'];
        foreach ($row as $key => $value) {
            if (!empty($columns_attr[$key]['excel_column'])) {
                if (isset($excel_file_columns_attr[$key]) || isset($excel_row[$key])) {
                    $excel_row[$key] = $value;
                } elseif ($value != '' && (($columns_attr[$key]['data_type_details']['type'] != 'json_array' && $columns_attr[$key]['data_type_details']['type'] != 'json_object') || ($value != '[]' && $value != '{}'))) {
                    $excel_row[$key] = $value;
                }
            }
        }

        $excel_entry_row = array(
            'entry' => json_encode($excel_row),
            'last_modified' => datetime_int_to_str(time())
        );

        et_edit_by_identifier($mysqli, 'et_excel_entries', $excel_entry_row, 'unique_value', $entity_attr['name'] . '_' . $excel_identifier_value, true);

        if (!empty($save_excel)) {
            et_save_excel_file_by_idenitifier($mysqli, $entity_attr, 'id', $excel_file_id);
        }
    }

}


function et_fill_default_column_attr($column_attr)
{
    $config = get_config();
    $default_column_attribute = $config['default_column_attribute'];
    foreach ($default_column_attribute as $key => $value) {
        if (!isset($column_attr[$key])) {
            $column_attr[$key] = $value;
        }
    }
    return $column_attr;
}


function et_get_entity_attributes($mysqli, $entity)
{

    $config = get_config();
    $default_column_attribute_by_name = $config['default_column_attribute_by_name'];
    $default_column_attribute = $config['default_column_attribute'];

    $data_types = array();
    $data_type_rows = et_get_all($mysqli, 'et_data_types');
    foreach ($data_type_rows as $data_type_row) {
        $data_types[$data_type_row['name']] = $data_type_row;
    }


    $entity_attr = et_get_by_identifier($mysqli, 'et_entities', 'name', $entity);


    $entity_attr['views'] = json_decode($entity_attr['views'], true);


    $entity_attr['columns_attributes'] = json_decode($entity_attr['columns_attributes'], true);

    $columns_attr = $entity_attr['columns_attributes'];

    $table_columns = array();
    $to_update = false;

    $fields_rows = et_get_table_fields($mysqli, $entity_attr['name']);

    $fields_names = array();
    $columns_attr_to_merge = array();

    foreach ($fields_rows as $fields_row) {

        $fields_names[$fields_row['Field']] = '';
        $table_columns[] = $fields_row['Field'];
        $this_column_attr = array('name' => $fields_row['Field']);

        // pick columns that exists in entity
        if (empty($columns_attr[$this_column_attr['name']])) {

            // find suitable attribute
            $found_attribute = false;
            // check for column name defaults, add all properties that dont exist
            if (!empty($default_column_attribute_by_name[$this_column_attr['name']])) { // column name defaults
                foreach ($default_column_attribute_by_name[$this_column_attr['name']] as $key => $value) {
                    if (!isset($this_column_attr[$key])) {
                        $this_column_attr[$key] = $value;
                    }
                }
                $found_attribute = true;
            }

            // check for empty data_type
            if (empty($this_column_attr['data_type'])) {
                $data_type_found = false;
                foreach ($data_types as $data_type) {
                    if ($data_type['table_column_type'] == $fields_row['Type']) {
                        $this_column_attr['data_type'] = $data_type['name'];
                        $data_type_found = true;
                        break;
                    }
                }
                if (!$data_type_found) {
                    $this_column_attr['data_type'] = 'text';
                }
            }

            // apply defaults
            if (!$found_attribute) { // column name defaults
                $this_column_attr = et_fill_default_column_attr($this_column_attr);
            }

            if (empty($this_column_attr['display_name'])) {
                $this_column_attr['display_name'] = $this_column_attr['name'];
            }


            $columns_attr_to_merge[$this_column_attr['name']] = $this_column_attr;
        }


    }

    // merge attrs
    if (!empty($columns_attr_to_merge)) {
        $to_update = true;
        $all_column_names_in_order = array_keys(et_merge_arrays_in_order(array($fields_names, $columns_attr_to_merge), 2, true));
        $columns_attr_in_order = array();
        foreach ($all_column_names_in_order as $column_name) {
            if (isset($columns_attr[$column_name])) {
                $columns_attr_in_order[$column_name] = $columns_attr[$column_name];
            } elseif (isset($columns_attr_to_merge[$column_name])) {
                $columns_attr_in_order[$column_name] = $columns_attr_to_merge[$column_name];
            }
        }
        $columns_attr = $columns_attr_in_order;
    }


    // update table columns
    foreach ($columns_attr as $column_name => $column_attr) {
        if (in_array($column_name, $table_columns)) {
            if ($columns_attr[$column_name]['table_column'] != '1') {
                $columns_attr[$column_name]['table_column'] = '1';
                $to_update = true;
            }
        } else {
            if ($columns_attr[$column_name]['table_column'] != '0') {
                $columns_attr[$column_name]['table_column'] = '0';
                $to_update = true;
            }
        }
    }

    if ($to_update) {
        et_edit_by_identifier($mysqli, 'et_entities', array('columns_attributes' => json_encode($columns_attr)), 'name', $entity);
    }

    // put data_type_details
    $columns_attr = et_insert_data_type_details($columns_attr, $data_types);

    $entity_attr['columns_attributes'] = $columns_attr;
    return $entity_attr;
}


function et_update_columns_attributes($mysqli, $entity_attr, $excel_columns_attr)
{
    // updatting columns_attr
    $config = get_config();
    $default_column_attribute = $config['default_column_attribute'];
    $entity_attr_row = et_get_by_identifier($mysqli, 'et_entities', 'name', $entity_attr['name']);
    $existing_columns_attr = json_decode($entity_attr_row['columns_attributes'], true);
    $new_columns_attr = array();

    $to_update = false;
    foreach ($excel_columns_attr as $column_name => $column_attr) {
        if (isset($existing_columns_attr[$column_name])) {
            if (!empty($excel_columns_attr[$column_name]['is_column_wise_json'])) {
                $merged_json_structure = et_merge_arrays_in_order(array($existing_columns_attr[$column_name]['column_wise_json_structure'], $excel_columns_attr[$column_name]['column_wise_json_structure']), 2, true);
                //var_dump($merged_json_structure);var_dump($excel_columns_attr[$column_name]['column_wise_json_structure']);
                if ($merged_json_structure != $existing_columns_attr[$column_name]['column_wise_json_structure']) {
                    $existing_columns_attr[$column_name]['column_wise_json_structure'] = $merged_json_structure;
                    $to_update = true;
                    echo $to_update;
                }
            }
            if ($existing_columns_attr[$column_name]['excel_column'] != '1') {
                $existing_columns_attr[$column_name]['excel_column'] = '1';
                $existing_columns_attr[$column_name]['display_name'] = $excel_columns_attr[$column_name]['display_name'];
                foreach ($column_attr as $key => $value) {
                    $existing_columns_attr[$column_name][$key] = $value;
                }
                $existing_columns_attr[$column_name]['excel_column'] = '1';
                if ((!empty($existing_columns_attr[$column_name]['is_four_spaced_json']) || !empty($existing_columns_attr[$column_name]['is_column_wise_json']) && ($existing_columns_attr[$column_name]['data_type'] != 'json_array' || $existing_columns_attr[$column_name]['data_type'] != 'json_object'))) {
                    $existing_columns_attr[$column_name]['data_type'] = 'json_object';
                }
                $to_update = true;
            }
        } else {
            $new_columns_attr[$column_name] = $default_column_attribute;
            foreach ($column_attr as $key => $value) {
                $new_columns_attr[$column_name][$key] = $value;
            }
            $new_columns_attr[$column_name]['excel_column'] = '1';
            if (!empty($new_columns_attr[$column_name]['is_four_spaced_json']) || !empty($new_columns_attr[$column_name]['is_column_wise_json'])) {
                $new_columns_attr[$column_name]['data_type'] = 'json_object';
            }
            $to_update = true;
        }
    }


    if ($to_update) {
        $merged_columns_attr = array_merge($existing_columns_attr, $new_columns_attr);
        $updated_columns_attr = array();
        $columns_names_in_order = et_merge_arrays_in_order(array($existing_columns_attr, $excel_columns_attr), 2, true);
        $merged_columns_attr = et_remove_data_type_details($merged_columns_attr);
        foreach ($columns_names_in_order as $column_name => $value) {
            $updated_columns_attr[$column_name] = $merged_columns_attr[$column_name];
        }

        // update it
        et_edit_by_identifier($mysqli, 'et_entities', array('columns_attributes' => json_encode($updated_columns_attr)), 'name', $entity_attr['name']);

    }
}


function et_insert_data_type_details($columns_attr, $data_types)
{
    foreach ($columns_attr as $column_name => $column_attr) {
        $columns_attr[$column_name]['data_type_details'] = $data_types[$column_attr['data_type']];
        if (!empty($columns_attr[$column_name]['structure_attributes'])) {
            foreach ($columns_attr[$column_name]['structure_attributes'] as $attr_name => $attr_value) {
                $columns_attr[$column_name]['structure_attributes'][$attr_name]['data_type_details'] = $data_types[$attr_value['data_type']];
            }
        }
    }
    return $columns_attr;
}

function et_remove_data_type_details($columns_attr)
{
    foreach ($columns_attr as $column_name => $column_attr) {
        if (!empty($columns_attr[$column_name]['data_type_details'])) {
            unset($columns_attr[$column_name]['data_type_details']);
            if (!empty($columns_attr[$column_name]['structure_attributes'])) {
                foreach ($columns_attr[$column_name]['structure_attributes'] as $key => $value) {
                    if (!empty($columns_attr[$column_name]['structure_attributes'][$key]['data_type_details'])) {
                        unset($columns_attr[$column_name]['structure_attributes'][$key]['data_type_details']);
                    }
                }
            }
        }
    }
    return $columns_attr;
}

function et_print_field($mysqli, $field, $mode, $parent_variable = '', $field_value = '')
{

    $field_name = $field['name'];
    if (!empty($parent_variable)) {
        $field_name = $parent_variable . '[' . $field['name'] . ']';
    }


    $validation = '';
    if (!empty($field['validation'])) {
        $validation = ' data-validation="' . $field['validation'] . '"';
    }
    //$lock = '';
    $readonly = '';
    if (($mode == 'edit' && !empty($field['lock_on_edit'])) || ($mode == 'add' && !empty($field['lock_on_add']))) {
        //$lock = ' <label><input type="checkbox" value="1" checked onclick="toggle_input_lock(\'' . $field['name'] . '\')" />lock</label>';
        $readonly = ' readonly';
    }

    $value = '';
    $textarea_value = '';
    $value_value = '';
    if ($field_value !== '') {
        $value = ' value="' . htmlspecialchars($field_value) . '"';
        $textarea_value = htmlspecialchars($field_value);
        $value_value = $field_value;
    } elseif ($mode == 'add' && $field['default_value'] !== '') {
        $value = ' value="' . htmlspecialchars($field['default_value']) . '"';
        $textarea_value = htmlspecialchars($field['default_value']);
        $value_value = $field['default_value'];
    }

    $hidden = false;
    $after_field = '';
    if ($field['data_type_details']['type'] == 'boolean') {
        $hidden = true;
        $after_field = '<input type="checkbox" onchange="field_onchange_update(this, \'' . $field_name . '\')"' . ((!empty($value_value)) ? ' checked' : '') . ' value="1" />';
    } elseif (!empty($field['selection_data']['data']) || !empty($field['selection_data']['data_function'])) {
        $hidden = true;
        if (!empty($field['selection_data']['data_function'])) {
            $selection_data = call_user_func_array($field['selection_data']['data_function'], array_merge(array($mysqli), $field['selection_data']['data_function_args']));
        } else {
            $selection_data = $field['selection_data']['data'];
        }
        if (!empty($selection_data['configs']['allow_new_value'])) {
            $hidden = false;
        }
        $after_field .= '<select onchange="field_onchange_update(this, \'' . $field_name . '\')">';
        if (empty($selection_data['configs']['no_blank_value'])) {
            $after_field .= '<option value=""></option>';
        }
        foreach ($selection_data['options'] as $option) {
            $after_field .= '<option value="' . $option['value'] . '"' . (($option['value'] == $value_value) ? " selected" : "") . '>' . ((!empty($selection_data['configs']['show_value_on_display'])) ? $option['value'] . ' : ' : '') . $option['display'] . '</option>';
        }
        $after_field .= '</select>';

    } elseif ($field['data_type_details']['type'] == 'csv' || $field['data_type_details']['type'] == 'json_array' || $field['data_type_details']['type'] == 'json_object') {
        $hidden = true;
        $je_value = '{}';
        if ($value_value !== '') {
            $je_value = $value_value;
            if ($field['data_type_details']['type'] == 'csv') {
                $je_value = json_encode(csvline_decode($value_value));
            }
        } elseif ($field['data_type_details']['type'] == 'csv' || $field['data_type_details']['type'] == 'json_array') {
            $je_value = '[]';
        }
        $je_schema = '';
        if (!empty($field['structure_nodes'])) {
            $je_schema = json_encode($field);
        }
        $after_field = '<div class="je_main_container"><textarea class="je_json_data" style="display: none" data-onchange-update-field="' . $field_name . '" >' . $je_value . '</textarea><textarea class="je_json_schema" placeholder="value" style="display: none">' . $je_schema . '</textarea></div>';

    } elseif ($field['validation'] == 'encrypted_password') {
        $password_aliases = et_get_all($mysqli, 'dm_password_alias');
        $password_aliases_data = array();
        foreach ($password_aliases as $password_alias) {
            $password_aliases_data[$password_alias['name']] = $password_alias;
        }
        $after_field = '<br> <div class="encrypted_password_main_container"  data-field-parent="' . $parent_variable . '" data-field-name="' . $field['name'] . '"><input type="password" class="encrypted_password_password field_text" placeholder="Password" onchange="encrypted_password_change(this)"> <br><input type="password" class="encrypted_password_master_password field_text" placeholder="Master Password" onchange="encrypted_password_change(this)"> <input type="hidden" class="encrypted_password_password_aliases_data" value="' . htmlspecialchars(json_encode($password_aliases_data)) . '"> <br> <label><input type="checkbox" onclick="encrypted_password_show_toggle(this)">Show</label> </div>';
    } elseif ($field['validation'] == 'password_check_hash') {
        $after_field = '<br> <div class="password_check_hash_main_container" data-onchange-update-field="' . $field_name . '" ><input type="password" class="password_check_hash_password field_text" placeholder="Password" onchange="password_check_hash_change(this)"> <br><input type="password" class="password_check_hash_password_confirm field_text" placeholder="Password Confirm" onchange="password_check_hash_change(this)"> <br> <label><input type="checkbox" onclick="password_check_hash_show_toggle(this)">Show</label> </div>';
    }


    if ($field['data_type_details']['type'] == 'number' || $field['data_type_details']['type'] == 'boolean') {
        echo '<input type="' . (($hidden) ? 'hidden' : 'number') . '" class="field_number" name="' . $field_name . '"' . $value . ' min="' . $field['data_type_details']['lowest_limit'] . '" max="' . $field['data_type_details']['highest_limit'] . '" data-decimal-places="' . $field['data_type_details']['decimal_places'] . '"' . $validation . $readonly . ' />';
    } else { // all others
        if ($field['validation'] == 'html') {
            echo '<textarea type="text" class="ckeditor" name="' . $parent_variable . '[' . $field['name'] . ']" maxlength="' . $field['data_type_details']['length'] . '"' . $validation . $readonly . '>' . $textarea_value . '</textarea>';
        } elseif ($field['data_type_details']['length'] <= 2000 || $hidden) {
            echo '<input type="' . (($hidden) ? 'hidden' : 'text') . '" class="field_text" name="' . $field_name . '"' . $value . ' maxlength="' . $field['data_type_details']['length'] . '"' . $validation . $readonly . ' />';
        } else {
            echo '<textarea type="text" class="field_text_long" name="' . $field_name . '" maxlength="' . $field['data_type_details']['length'] . '"' . $validation . $readonly . '>' . $textarea_value . '</textarea>';
        }
    }
    echo $after_field;
}


function et_validate_data($data, $data_type)
{

    $review = array(
        'object' => '',
        'errors' => array(),
        'notices' => array(),
        'prompts' => array(),
        'prompt_args' => array(),
        'args' => array()
    );

    if ($data_type['type'] == 'text') {
        if (strlen($data) > (int)$data_type['length']) {
            $review['errors'][] = 'length of string is more than ' . $data_type['length'] . ' characters';
        }
    } elseif ($data_type['type'] == 'number') { // number
        if (((int)$data) < ((int)$data_type['lowest_limit'])) {
            $review['errors'][] = 'the number is less than ' . $data_type['lowest_limit'];
        } elseif (((int)$data) > ((int)$data_type['highest_limit'])) {
            $review['errors'][] = 'the number is greater than ' . $data_type['highest_limit'];
        }
        if ((strlen(strrchr($data, '.')) - 1) > ((int)$data_type['decimal_places'])) {
            $review['notices'][] = 'the number has decimal places more than ' . $data_type['decimal_places'] . ' digits, the value maybe rounded';
        }
    } elseif ($data_type['type'] == 'datetime') {
        $datetime = str_replace('0000-00-00', '1970-01-01', $data);
        $datetimeint = datetime_str_to_int($datetime);
        if ($datetimeint === false || $datetime != datetime_int_to_str($datetimeint)) {
            $review['errors'][] = 'invalid datetime';
        }
    } elseif ($data_type['type'] == 'date') {
        $datetime = str_replace('0000-00-00', '1970-01-01', $data);
        $datetimeint = date_str_to_int($datetime);
        if ($datetimeint === false || $datetime != date_int_to_str($datetimeint)) {
            $review['errors'][] = 'invalid date';
        }
    } elseif ($data_type['type'] == 'time') {
        $datetime = str_replace('0000-00-00', '1970-01-01', $data);
        $datetimeint = time_str_to_int($datetime);
        if ($datetimeint === false || $datetime != time_int_to_str($datetimeint)) {
            $review['errors'][] = 'invalid time';
        }
    }
    // to add time

    // validations
    if ($data_type['validation'] == 'varname') {
        if (!preg_match("/^[_a-z0-9]*$/", $data)) {
            $review['errors'][] = 'the string can only have a-z (small case), 0-9 and \'_\' (underscore)';
        }
        if (!preg_match("/^[a-z]*$/", $data[0])) {
            $review['errors'][] = 'the string should start with an aplhabet a-z (small case)';
        }
    } elseif ($data_type['validation'] == 'csv') {
        $values = explode(',', $data);
        foreach ($values as $value) {
            $val = trim($value);
            $quote_count = substr_count($val, '"');
            if ($quote_count > 0 && $quote_count != (2 + (substr_count(substr($val, 1, strlen($val) - 2), '""') * 2))) {
                $review['errors'][] = 'invalid csv, if the string has \',\' or \'"\', enclose the string with \'"\' and replace \'"\' in the string with \'""\'';
            }
        }
    } elseif ($data_type['validation'] == 'json') {
        // to validate json ----------------------------- array should contain only values and no object or array
        if (json_decode($data) == null) {
            $review['errors'][] = 'invalid json';
        }
    }

    return $review;
}


function et_selection_data($mysqli, $table, $value_column, $display_column, $query_attr = array(), $configs = array())
{

    $data['configs'] = $configs;
    $rows = et_get_all($mysqli, $table, $query_attr);
    if (empty($rows)) {
        throw new Exception('no results returned');
    }

    $options = array();
    foreach ($rows as $row) {
        $option = array();
        $option['value'] = $row[$value_column];
        $option['display'] = $row[$display_column];
        $options[] = $option;
    }

    $data['options'] = $options;

    return $data;
}

//*******************************   EXCEL  **********************************


function et_add_excel_file($mysqli, $entity_attr, $file)
{
    $config = get_config();
    $excel_file_path = $config['excels_dir'] . '/' . $entity_attr['name'] . '/' . $file . '.xls';
    $excel_file = et_read_excel_file($excel_file_path);
    $excel_attributes = array();
    $excel_attributes['size'] = filesize($excel_file_path);
    $excel_attributes['sha1'] = sha1_file($excel_file_path);
    $excel_attributes['last_modified'] = filemtime($excel_file_path);
    $excel_attributes['columns_attr'] = $excel_file['columns_attr'];
    $excel_file_id = et_add($mysqli, 'et_excel_files', array('unique_value' => $entity_attr['name'] . '_' . $file, 'name' => $file, 'entity' => $entity_attr['name'], 'attributes' => json_encode($excel_attributes)));

    et_update_columns_attributes($mysqli, $entity_attr, $excel_file['columns_attr']);
    $entity_attr = et_get_entity_attributes($mysqli, $entity_attr['name']);
    $rows = $excel_file['rows'];
    $excel_order = 1;
    $added_rows = array();

    if ($entity_attr['excel_identifier'] == '') {
        $excel_identifier = 'excel_identifier_value';
    } else {
        $excel_identifier = $entity_attr['excel_identifier'];
    }

    foreach ($rows as $index => $row) {

        if ($entity_attr['excel_identifier'] == '') {
            $excel_identifier_value = $excel_file_id . '_' . $excel_order;
        } else {
            $excel_identifier_value = $row[$entity_attr['excel_identifier']];
        }

        et_add_combined($mysqli, $entity_attr, $row, $excel_file_id, $excel_order, false);
        $added_rows[] = et_get_combined_by_identifier($mysqli, $entity_attr, $excel_identifier, $excel_identifier_value);
        $excel_order++;
    }
    if (!empty($entity_attr['function_after_add'])) {
        $entity_attr['function_after_add']($mysqli, $entity_attr, $added_rows);
    }
    et_save_excel_file_by_idenitifier($mysqli, $entity_attr, 'name', $file);
}

function et_update_excel_file($mysqli, $entity_attr, $file)
{
    $config = get_config();
    $excel_file_path = $config['excels_dir'] . '/' . $entity_attr['name'] . '/' . $file . '.xls';
    $excel_file = et_read_excel_file($excel_file_path);
    $excel_attributes = array();
    $excel_attributes['size'] = filesize($excel_file_path);
    $excel_attributes['sha1'] = sha1_file($excel_file_path);
    $excel_attributes['last_modified'] = filemtime($excel_file_path);
    $excel_attributes['columns_attr'] = $excel_file['columns_attr'];
    $excel_file_row = et_get_by_identifier($mysqli, 'et_excel_files', 'unique_value', $entity_attr['name'] . '_' . $file);
    if (empty($excel_file_row)) {
        throw new Exception('Excel file not found');
    }
    et_edit_by_identifier($mysqli, 'et_excel_files', array('unique_value' => $entity_attr['name'] . '_' . $file, 'name' => $file, 'entity' => $entity_attr['name'], 'attributes' => json_encode($excel_attributes)), 'unique_value', $entity_attr['name'] . '_' . $file, true);

    et_update_columns_attributes($mysqli, $entity_attr, $excel_file['columns_attr']);
    $entity_attr = et_get_entity_attributes($mysqli, $entity_attr['name']);
    $rows = $excel_file['rows'];
    $excel_file_id = $excel_file_row['id'];
    $existing_entries = et_get_all($mysqli, 'et_excel_entries', array('where' => array('excel_file_id' => $excel_file_id)));
    $done_identifier_values = array();
    $added_rows = array();
    $edited_rows = array();
    $deleted_rows = array();
    $excel_order = 1;

    if ($entity_attr['excel_identifier'] == '') {
        $excel_identifier = 'excel_identifier_value';
    } else {
        $excel_identifier = $entity_attr['excel_identifier'];
    }

    foreach ($rows as $index => $row) {
        if ($entity_attr['excel_identifier'] == '') {
            $excel_identifier_value = $excel_file_id . '_' . $excel_order;
        } else {
            $excel_identifier_value = $row[$entity_attr['excel_identifier']];
        }
        $done_identifier_values[] = $excel_identifier_value;
        $combined_row = et_get_combined_by_identifier($mysqli, $entity_attr, $excel_identifier, $excel_identifier_value);
        if (empty($combined_row)) {
            // add
            et_add_combined($mysqli, $entity_attr, $row, $excel_file_id, $excel_order, false);
            $combined_row = et_get_combined_by_identifier($mysqli, $entity_attr, $excel_identifier, $excel_identifier_value);
            $added_rows[] = $combined_row;
        } else {
            // edit
            et_edit_combined_by_identifier($mysqli, $entity_attr, $row, $excel_identifier, $excel_identifier_value, $excel_file_id, false, true);
            et_get_by_identifier($mysqli, $entity_attr['name'], $excel_identifier, $excel_identifier_value);
            $combined_row = et_get_combined_by_identifier($mysqli, $entity_attr, $excel_identifier, $excel_identifier_value);
            $edited_rows[] = $combined_row;
        }

        $excel_order++;
    }

    // delete
    foreach ($existing_entries as $entry) {
        if (!in_array($entry['identifier_value'], $done_identifier_values)) {
            $combined_row = et_get_combined_by_identifier($mysqli, $entity_attr, $excel_identifier, $entry['identifier_value']);
            et_delete_combined_by_identifier($mysqli, $entity_attr, $excel_identifier, $entry['identifier_value'], false);
            $deleted_rows[] = $combined_row;
        }
    }

    if (!empty($entity_attr['function_after_add'])) {
        $entity_attr['function_after_add']($mysqli, $entity_attr, $added_rows);
    }
    if (!empty($entity_attr['function_after_edit'])) {
        $entity_attr['function_after_edit']($mysqli, $entity_attr, $edited_rows);
    }
    if (!empty($entity_attr['function_after_delete'])) {
        $entity_attr['function_after_delete']($mysqli, $entity_attr, $deleted_rows);
    }

    echo '<br><br> edited rows: ' . count($edited_rows) . '<br> added rows: ' . count($added_rows) . '<br> deleted rows: ' . count($deleted_rows);
    et_save_excel_file_by_idenitifier($mysqli, $entity_attr, 'name', $file);
}

function et_remove_excel_file($mysqli, $entity_attr, $file)
{
    $config = get_config();
    $excel_file = et_get_by_identifier($mysqli, 'et_excel_files', 'unique_value', $entity_attr['name'] . '_' . $file);
    if (empty($excel_file)) {
        throw new Exception('Excel file not found');
    }

    et_save_excel_file_by_idenitifier($mysqli, $entity_attr, 'name', $file);

    $excel_entries = et_get_all($mysqli, 'et_excel_entries', array('where' => array('excel_file_id' => $excel_file['id'])));
    if ($entity_attr['excel_identifier'] == '') {
        $excel_identifier_name = 'excel_identifier_value';
    } else {
        $excel_identifier_name = $entity_attr['excel_identifier'];
    }
    $deleted_rows = array();
    foreach ($excel_entries as $excel_entry) {
        $combined_row = et_get_combined_by_identifier($mysqli, $entity_attr, $excel_identifier_name, $excel_entry['identifier_value']);
        et_delete_combined_by_identifier($mysqli, $entity_attr, $excel_identifier_name, $excel_entry['identifier_value'], false);
        $deleted_rows[] = $combined_row;
    }

    if (!empty($entity_attr['function_after_delete'])) {
        $entity_attr['function_after_delete']($mysqli, $entity_attr, $deleted_rows);
    }

    et_delete_by_identifier($mysqli, 'et_excel_files', 'unique_value', $entity_attr['name'] . '_' . $file);
}


function et_save_excel_file_by_idenitifier($mysqli, $entity_attr, $identifier_name, $identifier_value)
{

    $config = get_config();

    $rows = et_get_all($mysqli, 'et_excel_files', array('where' => array('entity' => $entity_attr['name'], $identifier_name => $identifier_value)));
    if (empty($rows)) {
        throw new Exception('excel file not found');
    }
    $excel_file_row = $rows[0];
    $excel_file_path = $config['excels_dir'] . '/' . $entity_attr['name'] . '/' . $excel_file_row['name'] . '.xls';
    if (!et_check_file_access($excel_file_path)) {
        throw new Exception('No file access');
    }
    $file_attr = json_decode($excel_file_row['attributes'], true);
    if (sha1_file($excel_file_path) != $file_attr['sha1']) {
        //echo sha1_file($excel_file_path); echo "=" . $file_attr['sha1'];
        //echo 'hello';
        throw new Exception('Excel file is modified, please update.');
    }

    $excel_entries = et_get_all($mysqli, 'et_excel_entries', array('where' => array('excel_file_id' => $excel_file_row['id'])));

    $rows = array();
    foreach ($excel_entries as $excel_entry) {
        $rows[] = json_decode($excel_entry['entry'], true);
    }

    $columns_attr = $entity_attr['columns_attributes'];
    $attributes = json_decode($excel_file_row['attributes'], true);
    // create all_column_names  and $all_column_wise_json
    //if($args['update_columns_order_in_excel_file']) {
    //    $all_column_names = array_keys($columns_attr);
    //    $all_column_wise_json = array();
    //    foreach($columns_attr as $column_name => $column_attr) {
    //        if(isset($column_attr['column_wise_json_structure'])) {
    //            $all_column_wise_json[$column_name] = $column_attr['column_wise_json_structure'];
    //        }
    //    }
    //} else {
    $unordered_existing_column_names_keys = et_merge_arrays_in_order($rows, 2, true); // order should be 2 // wat if only one array
    //var_dump($unordered_existing_column_names_keys);
    $all_column_names = array_keys(et_merge_arrays_in_order(array($attributes['columns_attr'], $columns_attr, $unordered_existing_column_names_keys), 2, true));
    //$all_column_wise_json = array();
    //foreach($columns_attr as $column_name => $column_attr) {
    //    if(isset($column_attr['column_wise_json_structure'])) {
    //
    //        if(isset($attributes['columns_attr'][$column_name]['column_wise_json_structure'])) {
    //            $all_column_wise_json[$column_name] = et_merge_arrays_in_order(array($attributes['columns_attr'][$column_name]['column_wise_json_structure'], $column_attr['column_wise_json_structure']), 2, true);
    //        } else {
    //            $all_column_wise_json[$column_name] = $column_attr['column_wise_json_structure'];
    //        }
    //
    //    }
    //}
    //}


    // create $column_names
    $unordered_existing_column_names = array_keys($unordered_existing_column_names_keys);
    $column_names = array();
    foreach ($all_column_names as $all_column_name) {
        if (in_array($all_column_name, $unordered_existing_column_names)) {
            $column_names[] = $all_column_name;
        }
    }

    if (empty($column_names)) { // in cases whr it is an empty excel file
        if (!empty($attributes['columns_attr'])) {
            $column_names = array_keys(et_merge_arrays_in_order(array($attributes['columns_attr'], $unordered_existing_column_names_keys), 2, true));
        } else {
            $column_names = $unordered_existing_column_names;
        }
    }


    // create $column_wise_json
    $existing_column_wise_json = array();
    foreach ($column_names as $column_name) {
        if (!empty($columns_attr[$column_name]['is_column_wise_json'])) {
            $existing_column_wise_json[$column_name] = array();
            $this_column_json_arrays = array();
            foreach ($rows as $row) {
                if (!empty($row[$column_name])) {
                    $json = json_decode($row[$column_name], true);
                    if (!empty($json)) {
                        $this_column_json_arrays[] = $json;
                    }
                }
            }
            $existing_column_wise_json[$column_name] = et_merge_arrays_in_order($this_column_json_arrays, 0, true);
        }
    }

    // convert them into ordered json structure
    //$column_wise_json = et_intersect_arrays_in_order($all_column_wise_json, $existing_column_wise_json, true);
    $column_wise_json = $existing_column_wise_json;


    //echo '<pre>';
    //echo '<script>console.log(' . json_encode($columns_attr) . ');</script>';
    //echo '<script>console.log(' . json_encode($column_names) . ');</script>';
    //echo '<script>console.log(' . json_encode($all_column_names) . ');</script>';
    //echo '<script>console.log(' . json_encode($unordered_existing_column_names) . ');</script>';
    //echo '<script>console.log(' . json_encode($column_wise_json) . ');</script>';

    // create $excel_columns_attr and update excel column attributes
    $excel_columns_attr = array();
    $attributes_for_excel_file = array('name', 'display_name', 'is_column_wise_json', 'column_wise_json_structure', 'is_four_spaced_json');
    $attributes_not_to_update = array('column_wise_json_structure');
    foreach ($column_names as $column_name) {
        $excel_columns_attr[$column_name] = array();
        foreach ($attributes_for_excel_file as $attr_name) {
            if (isset($columns_attr[$column_name][$attr_name]) && !in_array($attr_name, $attributes_not_to_update)) {
                $excel_columns_attr[$column_name][$attr_name] = $columns_attr[$column_name][$attr_name];
            }
        }
        if (isset($column_wise_json[$column_name])) {
            $excel_columns_attr[$column_name]['column_wise_json_structure'] = $column_wise_json[$column_name];
        }
    }

    //echo '<script>console.log(' . json_encode($rows) . ');</script>';
    //echo '<script>console.log(' . json_encode($excel_columns_attr) . ');</script>';
    //var_dump($rows);
    //var_dump($excel_columns_attr);

    et_save_excel_file($excel_file_path, $rows, $excel_columns_attr);


    $new_attributes = array();
    $new_attributes['size'] = filesize($excel_file_path);
    $new_attributes['sha1'] = sha1_file($excel_file_path);
    $new_attributes['last_modified'] = filemtime($excel_file_path);
    $new_attributes['columns_attr'] = $excel_columns_attr;

    $excel_file_row['attributes'] = json_encode($new_attributes);
    et_edit_by_identifier($mysqli, 'et_excel_files', $excel_file_row, 'id', $excel_file_row['id'], true);
}


function et_save_excel_file($excel_file_path, $rows, $columns_attr = array())
{
    if (empty($columns_attr)) {
        $column_names = array_keys(et_merge_arrays_in_order($rows, 0, true));
        foreach ($column_names as $column_name) {
            $columns_attr[$column_name] = array('name' => $column_name, 'display_name' => $column_name);
        }
    }

    $excel_rows = array();
    for ($i = 0; $i < count($rows) + 1; $i++) {
        $excel_rows[] = array();
    }

    //var_dump($columns_attr);

    // create function for recursive fill
    if (!function_exists('et_save_excel_file_recursive_column_fill')) {
        function et_save_excel_file_recursive_column_fill($excel_rows, $column_index, $column_wise_json_structure, $json_arrays)
        {

            foreach ($column_wise_json_structure as $column_name => $value) {
                if (is_array($value)) {
                    $excel_rows[0][$column_index] = $column_name . ' [';
                    $column_index++;

                    $more_json_arrays = array();
                    foreach ($json_arrays as $json_array) {
                        if (isset($json_array[$column_name])) {
                            $more_json_arrays[] = $json_array[$column_name];
                        } else {
                            $more_json_arrays[] = array();
                        }
                    }
                    $ret_array = et_save_excel_file_recursive_column_fill($excel_rows, $column_index, $value, $more_json_arrays);
                    $column_index = $ret_array['column_index'];
                    $excel_rows = $ret_array['excel_rows'];

                    $excel_rows[0][$column_index] = ']';

                } else {
                    $excel_rows[0][$column_index] = et_encode_excel_column_str($column_name);
                    for ($i = 0; $i < count($json_arrays); $i++) {
                        if (isset($json_arrays[$i][$column_name])) {
                            $excel_rows[$i + 1][$column_index] = $json_arrays[$i][$column_name];/////////////
                        }
                    }

                }
                $column_index++;
            }

            return array(
                'column_index' => $column_index,
                'excel_rows' => $excel_rows
            );
        }
    }


    $column_index = 0;
    foreach ($columns_attr as $column_name => $column_attr) {
        if (!empty($column_attr['is_column_wise_json'])) {
            $excel_rows[0][$column_index] = $column_attr['display_name'] . ' [';
            $column_index++;

            $json_arrays = array();
            foreach ($rows as $row) {
                if (isset($row[$column_name])) {
                    $json_arrays[] = json_decode($row[$column_name], true);
                } else {
                    $json_arrays[] = array();
                }
            }
            $ret_array = et_save_excel_file_recursive_column_fill($excel_rows, $column_index, $column_attr['column_wise_json_structure'], $json_arrays);
            $column_index = $ret_array['column_index'];
            $excel_rows = $ret_array['excel_rows'];


            $excel_rows[0][$column_index] = ']';

        } elseif (!empty($column_attr['is_four_spaced_json'])) { // four space json
            $excel_rows[0][$column_index] = $column_attr['display_name'] . ' []';
            for ($i = 0; $i < count($rows); $i++) {
                if (isset($rows[$i][$column_name])) {
                    $excel_rows[$i + 1][$column_index] = et_encode_four_spaced_json(json_decode($rows[$i][$column_name], true));
                }
            }
        } else {
            $excel_rows[0][$column_index] = et_encode_excel_column_str($column_attr['display_name']);
            for ($i = 0; $i < count($rows); $i++) {
                if (isset($rows[$i][$column_name])) {
                    $excel_rows[$i + 1][$column_index] = $rows[$i][$column_name];
                }
            }
        }
        $column_index++;
    }
    $no_of_columns = $column_index;


    // set active sheet to 0 and set all cells blank
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objWorksheet = $objPHPExcel->getActiveSheet();
    if (file_exists($excel_file_path)) {
        $objReader = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $objReader->load($excel_file_path);
        $objPHPExcel->setActiveSheetIndex(0);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        foreach ($objWorksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            //$cellIterator->setIterateOnlyExistingCells(FALSE);
            foreach ($cellIterator as $cell) {
                $cell->setValue('');
            }
        }
    }

    $column_index = 0;
    $row_index = 1;
    foreach ($columns_attr as $column_name => $columns_attr) {
        $objWorksheet->setCellValueByColumnAndRow($column_index, $row_index, $column_name);
        $column_index++;
    }

    $row_index = 1;  //starts with 1, column index starts from 0
    foreach ($excel_rows as $excel_row) {
        //$row = json_decode($excel_entry['entry'], true);
        for ($column_index = 0; $column_index < $no_of_columns; $column_index++) {
            if (isset($excel_row[$column_index]) && $excel_row[$column_index] != '') {
                if ($excel_row[$column_index] == ' ') {
                    $objWorksheet->setCellValueByColumnAndRow($column_index, $row_index, '&nbsp;'); // substitute single space with htmlencoded space
                } else {
                    $objWorksheet->setCellValueByColumnAndRow($column_index, $row_index, $excel_row[$column_index]);
                }
            } else {
                $objWorksheet->setCellValueByColumnAndRow($column_index, $row_index, ' '); // appending spaces for cell overflow problem
            }
        }
        $row_index++;
    }

    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); // for .xls
    $objWriter->save($excel_file_path);


}


function et_read_excel_file($excel_file_path)
{
    $columns_attr = array();
    $column_names = array();
    $column_display_names = array();
    $column_wise_json = array();
    $four_spaced_json_columns = array();

    $objPHPExcel = new PHPExcel();
    $objReader = new PHPExcel_Reader_Excel5();
    $objPHPExcel = $objReader->load($excel_file_path);
    $objPHPExcel->setActiveSheetIndex(0);
    $objWorksheet = $objPHPExcel->getActiveSheet();


    // create excel rows and column row
    $excel_rows = array();
    $column_row_done = false;
    $column_row = array();
    $columns_count = -1;
    foreach ($objWorksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);
        if (!$column_row_done) {
            foreach ($cellIterator as $cell) {
                $value = trim(clear_data($cell->getValue()));
                if (is_null($value)) {
                    $value = '';
                }
                if ($value != "") {
                    $column_row[] = $value;//$values[$value_index];
                } else {
                    break;
                }
            }
            $column_row_done = true;
            $columns_count = count($column_row);
        } else {
            $values = array();
            $row_exists = false;
            $index = 0;
            foreach ($cellIterator as $cell) {
                $value = clear_data($cell->getValue()); // trim problem - do not trim here
                if (is_null($value)) {
                    $value = '';
                }
                if ($value == '&nbsp;') {
                    $value = ' '; // substitute with single space
                    $row_exists = true;
                }
                $values[] = $value;
                $index++;
                if ($index == $columns_count) {
                    break;
                }
            }
            foreach ($values as $value) {
                if (trim($value) != '') {
                    $row_exists = true;
                    break;
                }
            }
            if ($row_exists) {
                $excel_rows[] = $values;
            }
        }
    }


    // create column_names, column_wise_json and four_spaced_json_columns

    if (!function_exists('et_read_excel_file_get_column_wise_json_array')) {
        function et_read_excel_file_get_column_wise_json_array($column_row, $column_index)
        {
            $array = array();
            for ($column_index = $column_index; $column_index < count($column_row) && $column_row[$column_index] != ']'; $column_index++) {
                $value = $column_row[$column_index];
                if (substr($value, strlen($value) - 1) == '[') { // column wise json
                    $column_name = trim(substr($value, 0, strlen($value) - 1));

                    $column_index++;

                    $ret_array = et_read_excel_file_get_column_wise_json_array($column_row, $column_index);
                    $column_index = $ret_array['column_index'];
                    $array[$column_name] = $ret_array['array'];

                } else { //normal column
                    $array[$value] = '';
                }
            }

            $ret_array = array(
                'column_index' => $column_index,
                'array' => $array
            );

            return $ret_array;
        }
    }

    for ($column_index = 0; $column_index < count($column_row); $column_index++) {
        $value = $column_row[$column_index];
        if (substr($value, strlen($value) - 1) == '[') { // column wise json
            $column_display_name = trim(substr($value, 0, strlen($value) - 1));
            $column_name = str_to_varname($column_display_name);
            $columns_attr[$column_name] = array('name' => $column_name, 'display_name' => $column_display_name);

            $column_index++;

            $ret_array = et_read_excel_file_get_column_wise_json_array($column_row, $column_index);
            $column_index = $ret_array['column_index'];
            //$columns_attr[$column_name]['is_json'] = '1';
            $columns_attr[$column_name]['is_column_wise_json'] = '1';
            $columns_attr[$column_name]['column_wise_json_structure'] = $ret_array['array'];

        } elseif (substr($value, strlen($value) - 2) == '[]') { // fourspaced json
            $column_display_name = trim(substr($value, 0, strlen($value) - 2));
            $column_name = str_to_varname($column_display_name);
            $columns_attr[$column_name] = array('name' => $column_name, 'display_name' => $column_display_name);
            //$columns_attr[$column_name]['is_json'] = '1';
            $columns_attr[$column_name]['is_four_spaced_json'] = '1';
        } else { //normal column
            $column_display_name = $value;
            $column_name = str_to_varname($column_display_name);
            $columns_attr[$column_name] = array('name' => $column_name, 'display_name' => $column_display_name);
        }
    }


    // create rows, using the previous columns info


    if (!function_exists('et_read_excel_file_get_column_wise_data_array')) {
        function et_read_excel_file_get_column_wise_data_array($excel_row, $column_wise_json_structure, $column_index)
        {
            $array = array();

            foreach ($column_wise_json_structure as $column_wise_json_key => $column_wise_json_value) {
                if (is_array($column_wise_json_value)) {

                    $column_index++;

                    $ret_array = et_read_excel_file_get_column_wise_data_array($excel_row, $column_wise_json_value, $column_index);
                    $column_index = $ret_array['column_index'];
                    $array[$column_wise_json_key] = $ret_array['array'];
                } else {
                    $array[$column_wise_json_key] = trim($excel_row[$column_index]); // trim problem
                }
                $column_index++;
            }

            $ret_array = array(
                'column_index' => $column_index,
                'array' => $array
            );

            return $ret_array;
        }
    }

    $column_index = 0;
    $rows = array();
    for ($i = 0; $i < count($excel_rows); $i++) {
        $rows[] = array();
    }
    foreach ($columns_attr as $column_name => $column_attr) {
        if (!empty($column_attr['is_column_wise_json'])) {

            $column_index++;

            foreach ($excel_rows as $row_index => $excel_row) {
                $ret_array = et_read_excel_file_get_column_wise_data_array($excel_row, $column_attr['column_wise_json_structure'], $column_index);
                $rows[$row_index][$column_name] = json_encode(et_arrays_clear_data($ret_array['array']));
            }
            $column_index = $ret_array['column_index'];

        } elseif (!empty($column_attr['is_four_spaced_json'])) {
            foreach ($excel_rows as $row_index => $excel_row) {
                $rows[$row_index][$column_name] = json_encode(et_arrays_clear_data(et_decode_four_spaced_json($excel_row[$column_index])));
            }
        } else {
            foreach ($excel_rows as $row_index => $excel_row) {
                $rows[$row_index][$column_name] = trim(clear_data($excel_row[$column_index])); // trim  problem - some data may require extra spaces
            }
        }
        $column_index++;
    }


    $ret_array = array(
        'rows' => $rows,
        'columns_attr' => $columns_attr
    );
    return $ret_array;
}


function et_check_excel_file_by_identifier($mysqli, $entity, $identifier_name, $identifier_value)
{
    // returns true if file is all ok
    $config = get_config();
    $rows = et_get_all($mysqli, 'et_excel_files', array('where' => array('entity' => $entity, $identifier_name => $identifier_value)));
    if (empty($rows)) {
        return ('excel file not found');
    }
    $excel_file_row = $rows[0];
    $excel_file_path = $config['excels_dir'] . '/' . $entity . '/' . $excel_file_row['name'] . '.xls';
    if (!et_check_file_access($excel_file_path)) {
        return ('No file access');
    }
    $file_attr = json_decode($excel_file_row['attributes'], true);
    if (sha1_file($excel_file_path) != $file_attr['sha1']) {
        //echo sha1_file($excel_file_path); echo "=" . $file_attr['sha1'];
        //echo 'hello';
        return ('Excel file is modified, please update.');
    }
    return true;
}

//*******************************   HELPERS  **********************************


function et_get_object_having_indexes($objects, $indexes, $value = 'nothingnothingnothing')
{
    $object_found = false;
    if ($value == 'nothingnothingnothing') {
        foreach ($objects as $object) {
            $in_object = $object;
            foreach ($indexes as $index) {
                if (isset($in_object[$index])) {
                    $in_object = $in_object[$index];
                    //var_dump($in_object);
                } else {
                    $in_object = 'nothingnothingnothing';
                    break;
                }
            }
            if ($in_object != 'nothingnothingnothing' && !empty($in_object)) {
                $object_found = $object;
            }
        }
    } else {
        foreach ($objects as $object) {
            $in_object = $object;
            foreach ($indexes as $index) {
                if (isset($in_object[$index])) {
                    $in_object = $in_object[$index];
                } else {
                    $in_object = 'nothingnothingnothing';
                    break;
                }
            }
            if ($in_object != 'nothingnothingnothing' && $in_object == $value) {
                $object_found = $object;
            }
        }
    }
    return $object_found;
}


// ordering: 0 - add to last | 1 - best place | 2 - best place using first array as initial merged array.
function et_merge_arrays_in_order($arrays, $ordering = 0, $array_of_keys = false)
{
    $merged_array = array();
    if (!$array_of_keys) {
        if ($ordering == 0) {
            if ($array_of_keys == 0) {
                foreach ($arrays as $array) {
                    if (!empty($merged_array)) {
                        foreach ($array as $value) {
                            if (!in_array($value, $merged_array)) {
                                $merged_array[] = $value;
                            }
                        }
                    } else {
                        $merged_array = $array;
                    }
                }
            }
        } elseif ($ordering == 1 || $ordering == 2) {

            if ($ordering == 2) {
                $merged_array = array_splice($arrays, 0, 1)[0];
            }
            foreach ($arrays as $array) {

                if ($ordering == 1 || !empty($merged_array)) {//////////////
                    foreach ($array as $value) {
                        if (!in_array($value, $merged_array)) {

                            // visit all array collect points for each word -ve for left of the target word, +ve for right of the target word
                            $word_points = array();
                            foreach ($arrays as $arr) {
                                $pos = array_search($value, $arr);
                                if ($pos !== false) {
                                    $pos_found = false;
                                    foreach ($arr as $key => $val) {
                                        if ($key == $pos) {
                                            $pos_found = true;
                                        } elseif (!$pos_found) {
                                            if (empty($word_points[$val])) {
                                                $word_points[$val] = 0;
                                            }
                                            $word_points[$val]--;
                                        } elseif ($pos_found) {
                                            if (empty($word_points[$val])) {
                                                $word_points[$val] = 0;
                                            }
                                            $word_points[$val]++;
                                        }
                                    }
                                }
                            }


                            // further improvement, while placing between words, check which word bonds are the weakest to place in between

                            // check each word in the array and place the target word where suitable
                            $highest_neg_pos = -1;
                            $lowest_non_neg_pos = -1;
                            foreach ($word_points as $word => $word_point) {
                                $pos = array_search($word, $merged_array);
                                if ($pos !== false) {
                                    if ($word_point < 0) {
                                        if ($highest_neg_pos == -1 || $highest_neg_pos < $pos + 1) {
                                            $highest_neg_pos = $pos + 1;
                                        }
                                    } else {
                                        if ($lowest_non_neg_pos == -1 || $pos < $lowest_non_neg_pos) {
                                            $lowest_non_neg_pos = $pos;
                                        }
                                    }
                                }
                            }

                            // place
                            if ($highest_neg_pos != -1) {
                                array_splice($merged_array, $highest_neg_pos, 0, $value);
                            } elseif ($lowest_non_neg_pos != -1) {
                                array_splice($merged_array, $lowest_non_neg_pos, 0, $value);
                            } else {
                                $merged_array[] = $value;
                            }


                        }
                    }
                } else {
                    $merged_array = $array;

                }
            }
        }


    } else { // array of keys

        // get merged keys array
        $keys_arrays = array();
        foreach ($arrays as $array) {
            $keys_arrays[] = array_keys($array);
        }
        $merged_keys = et_merge_arrays_in_order($keys_arrays, $ordering);
        // using the merged keys find which of the keys have further arrays and sort them too
        foreach ($merged_keys as $merged_key) {
            $merged_key_value_arrays = array();
            foreach ($arrays as $array) {
                if (isset($array[$merged_key]) && is_array($array[$merged_key])) {
                    $merged_key_value_arrays[] = $array[$merged_key];
                }
            }
            if (count($merged_key_value_arrays)) {
                $merged_array[$merged_key] = et_merge_arrays_in_order($merged_key_value_arrays, $ordering, true);
            } else {
                $merged_array[$merged_key] = '';
            }
        }
    }


    return $merged_array;
}

function et_check_arrays_keys_same_recursive($arrays)
{
    return false;
}

function et_intersect_arrays_in_order($complete_ordered_array, $other_array, $array_of_keys = false)
{
    $intersect_array = array();

    if (!$array_of_keys) {
        foreach ($complete_ordered_array as $value) {
            if (in_array($value, $other_array)) {
                $intersect_array[] = $value;
            }
        }
    } else {
        foreach ($complete_ordered_array as $key => $value) {
            if (isset($other_array[$key])) {
                if (is_array($value)) {
                    $intersect_array[$key] = et_intersect_arrays_in_order($value, $other_array[$key], true);
                } else {
                    $intersect_array[$key] = '';
                }
            }
        }
    }

    return $intersect_array;
}

function et_arrays_clear_data($array)
{
    $new_array = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $new_array[clear_data($key)] = et_arrays_clear_data($value);
        } else {
            $new_array[clear_data($key)] = clear_data($value);
        }
    }
    return $new_array;
}

function et_encode_excel_column_str($str)
{
    $str = '' . $str;
    if (substr($str, strlen($str) - 1) == '[') {
        return substr($str, 0, strlen($str) - 1) . '&#91;';
    } elseif (substr($str, strlen($str) - 1) == ']') {
        return substr($str, 0, strlen($str) - 1) . '&#93;';
    } else {
        return $str;
    }
}

function et_decode_excel_column_str($str)
{
    $str = '' . $str;
    if (substr($str, strlen($str) - 5) == '&#91;') {
        return substr($str, 0, strlen($str) - 5) . '[';
    } elseif (substr($str, strlen($str) - 5) == '&#93;') {
        return substr($str, 0, strlen($str) - 5) . ']';
    } else {
        return $str;
    }
}


function et_encode_four_spaced_json_data($str)
{
    $str = '' . $str;
    return str_replace(array("\n    ", "::"), array("\n&nbsp;   ", "&#58;&#58;"), $str);
}

function et_decode_four_spaced_json_data($str)
{
    $str = '' . $str;
    $str = str_replace(array("\n&nbsp;   ", "&#58;&#58;"), array("\n    ", "::"), $str);
    $str = trim($str);
    return $str;
}

function et_encode_four_spaced_json($array, $level = 0)
{
    $four_spaced_json = '';
    if (empty($array)) {
        return $four_spaced_json;
    }
    $do_key_value = false;
    if (array_keys($array) !== range(0, count($array) - 1)) { // if the array contains key value pair
        $do_key_value = true;
    } else { // check if it has arrays in values
        foreach ($array as $value) {
            if (is_array($value)) {
                $do_key_value = true;
                break;
            }
        }
    }

    if ($do_key_value) {
        $index = 0;

        // check if numerical keys are in order
        $numeric_order = true;
        $current_number = -1;
        foreach ($array as $key => $value) {
            if (is_numeric($key)) {
                if ($current_number == -1) {
                    if ($key == '0') {
                        $current_number = 0;
                    } else {
                        $numeric_order = false;
                        break;
                    }
                } else {
                    if ($key == '' . ($current_number + 1)) {
                        $current_number++;
                    } else {
                        $numeric_order = false;
                        break;
                    }
                }
            }
        }

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $four_spaced_json .= (($index) ? "\n" : '') . str_repeat('    ', $level + 1) . et_encode_four_spaced_json_data($key) . "\n" . et_encode_four_spaced_json($value, $level + 1);
            } elseif (is_numeric($key) && $numeric_order) {
                $four_spaced_json .= (($index) ? "\n" : '') . str_repeat('    ', $level + 1) . et_encode_four_spaced_json_data($value);
            } else {
                $four_spaced_json .= (($index) ? "\n" : '') . str_repeat('    ', $level + 1) . et_encode_four_spaced_json_data($key) . ':: ' . et_encode_four_spaced_json_data($value);
            }
            $index++;
        }
    } else {
        $index = 0;
        foreach ($array as $value) {
            $four_spaced_json .= (($index) ? "\n" : '') . str_repeat('    ', $level + 1) . et_encode_four_spaced_json_data($value);
            $index++;
        }
    }

    return $four_spaced_json;
}

// do the encode
function et_decode_four_spaced_json($four_spaced_json, $level = 0)
{

    $array = array();

    $no_of_spaces = (1 + $level) * 4;
    $splits = preg_split('/^ {' . $no_of_spaces . '}(?! )/m', $four_spaced_json); // /m allows ^ (start of line) and $ (end of line), {4} for four spaces, (?! ) for negative lookahead
    for ($i = 1; $i < count($splits); $i++) {

        $no_of_spaces = (1 + $level + 1) * 4;
        $split_in_two = preg_split('/^ {' . $no_of_spaces . '}(?! )/m', $splits[$i], 2);
        // var_dump($split_in_two);
        if (count($split_in_two) == 2) { // its an array
            $key = et_decode_four_spaced_json_data($split_in_two[0]);
            $value = et_decode_four_spaced_json(str_repeat(' ', $no_of_spaces) . $split_in_two[1], $level + 1);
            $array[$key] = $value;
        } else { // its a value or a key value
            $split_in_two = explode('::', $splits[$i], 2);
            if (count($split_in_two) == 2) { // its a key value pair
                $key = et_decode_four_spaced_json_data($split_in_two[0]);
                $value = et_decode_four_spaced_json_data($split_in_two[1]);
                $array[$key] = $value;
            } else { // its a value
                $value = et_decode_four_spaced_json_data($splits[$i]);
                $array[] = $value;
            }
        }
    }

    return $array;

}

function et_check_file_access($file)
{
    $fp = @fopen($file, "r+");
    if (empty($fp)) {
        return false;
    }
    if (flock($fp, LOCK_EX)) {  // acquire an exclusive lock
        flock($fp, LOCK_UN);    // release the lock
        fclose($fp);
        return true;
    } else {
        fclose($fp);
        return false;
    }
}