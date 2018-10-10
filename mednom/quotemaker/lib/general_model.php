<?php

/* All common and read functions */

function pdo_db() {
    $config = get_config();
    $pdo = new PDO('mysql:host='.$config['db_host'].';dbname='.$config['db_name'].';charset=utf8', $config['db_user'], $config['db_pass']);
    return $pdo;
}

function datetime_str_to_int($datetime) {
    $datetime = str_replace('0000-00-00', '1970-01-01', $datetime); // mysql can have dates as 0 zero but php min date is  1970-01-01
    return strtotime($datetime);
}

function datetime_int_to_str($datetime) {
    $strtime = date('Y-m-d H:i:s', $datetime);
    return str_replace('1970-01-01', '0000-00-00', $strtime); // mysql can have dates as 0 zero but php min date is  1970-01-01
}

function date_str_to_int($date) {
    $date = str_replace('0000-00-00', '1970-01-01', $date); 
    return strtotime($date);
}

function date_int_to_str($date) {
    $strdate = date('Y-m-d', $date);
    return str_replace('1970-01-01', '0000-00-00', $strdate);
}

function time_str_to_int($time) {
    $strtime = '1970-01-01 ' . date('H:i:s', strtotime($time)); 
    return strtotime($time);
}

function time_int_to_str($time) {
    $strtime = date('H:i:s', $time);
    return $strtime;
}



//*******************************  PRODUCTS  **********************************


function get_all_products() {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `products`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_product_by_id($id) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `products` WHERE  `id` = ? ");
    $stmt->execute(array($id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_products_by_category_id($category_id) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `products` WHERE  `category_id` = ? ");
    $stmt->execute(array($category_id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_products_by_sku_not_in($skus) {
    $pdo = pdo_db();
    $qv = get_query_vars($skus);
    $stmt = $pdo->prepare("SELECT * FROM `products` WHERE `sku` NOT IN (" . $qv['values_qm'] . ") ");
    $stmt->execute($qv['values']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insert_update_products_by_sku_get_id($row) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `products` WHERE  `sku` = ? ");
    $stmt->execute(array($row['sku']));
    $res_row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!empty($res_row)) {
        $qv = get_query_vars($row);
        $qv['values'][] = $row['sku']; // for where condition;
        $stmt = $pdo->prepare('UPDATE `products` SET ' . $qv['assignments'] . ' WHERE `sku` = ? ');
        $stmt->execute($qv['values']);
        $ret_id = $res_row['id'];
    } else {
        $qv = get_query_vars($row);
        $stmt = $pdo->prepare('INSERT INTO `products` (' . $qv['keys'] . ') VALUES(' . $qv['values_qm'] . ')  ');
        $stmt->execute($qv['values']);
        $ret_id = $pdo->lastInsertId('id');
    }
    return $ret_id;
}

function update_products_by_id($row) {
    $pdo = pdo_db();
    $qv = get_query_vars($row);
    $qv['values'][] = $row['id']; // for where condition;
    $stmt = $pdo->prepare('UPDATE `products` SET ' . $qv['assignments'] . ' WHERE `id` = ? ');
    $stmt->execute($qv['values']);
}

function delete_products_by_id($id) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("DELETE FROM `products` WHERE `id` = ? ");
    $stmt->execute(array($id));
}



//*******************************  CATEGORIES  **********************************



function get_all_categories() {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `categories`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_category_by_id($id) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `categories` WHERE  `id` = ? ");
    $stmt->execute(array($id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_categories_by_id_not_in($ids) {
    $pdo = pdo_db();
    $qv = get_query_vars($ids);
    $stmt = $pdo->prepare("SELECT * FROM `categories` WHERE `id` NOT IN (" . $qv['values_qm'] . ") ");
    $stmt->execute($qv['values']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insert_update_categories_by_id($row) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `categories` WHERE  `id` = ? ");
    $stmt->execute(array($row['id']));
    $res_row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!empty($res_row)) {
        $qv = get_query_vars($row);
        $qv['values'][] = $row['id']; // for where condition;
        $stmt = $pdo->prepare('UPDATE `categories` SET ' . $qv['assignments'] . ' WHERE `id` = ? ');
        $stmt->execute($qv['values']);
    } else {
        $qv = get_query_vars($row);
        $stmt = $pdo->prepare('INSERT INTO `categories` (' . $qv['keys'] . ') VALUES(' . $qv['values_qm'] . ')  ');
        $stmt->execute($qv['values']);
    }
}

function update_categories_by_id($row) {
    $pdo = pdo_db();
    $qv = get_query_vars($row);
    $qv['values'][] = $row['id']; // for where condition;
    $stmt = $pdo->prepare('UPDATE `categories` SET ' . $qv['assignments'] . ' WHERE `id` = ? ');
    $stmt->execute($qv['values']);
}

function delete_categories_by_id($id) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("DELETE FROM `categories` WHERE `id` = ? ");
    $stmt->execute(array($id));
}




//*******************************  PAGES  **********************************



function get_all_pages() {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `pages`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_page_by_id($id) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `pages` WHERE  `id` = ? ");
    $stmt->execute(array($id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_pages_by_name_not_in($names) {
    $pdo = pdo_db();
    $qv = get_query_vars($names);
    $stmt = $pdo->prepare("SELECT * FROM `pages` WHERE `name` NOT IN (" . $qv['values_qm'] . ") ");
    $stmt->execute($qv['values']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insert_update_pages_by_name($row) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `pages` WHERE  `name` = ? ");
    $stmt->execute(array($row['name']));
    $res_row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!empty($res_row)) {
        $qv = get_query_vars($row);
        $qv['values'][] = $row['name']; // for where condition;
        $stmt = $pdo->prepare('UPDATE `pages` SET ' . $qv['assignments'] . ' WHERE `name` = ? ');
        $stmt->execute($qv['values']);
    } else {
        $qv = get_query_vars($row);
        $stmt = $pdo->prepare('INSERT INTO `pages` (' . $qv['keys'] . ') VALUES(' . $qv['values_qm'] . ')  ');
        $stmt->execute($qv['values']);
    }
}

function delete_pages_by_id($id) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("DELETE FROM `pages` WHERE `id` = ? ");
    $stmt->execute(array($id));
}




//*******************************  XLS FILES  **********************************



function get_all_xls_files() {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `xls_files`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_xls_file_by_id($id) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `xls_files` WHERE  `id` = ? ");
    $stmt->execute(array($id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_xls_file_by_type($type) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `xls_files` WHERE  `type` = ? ");
    $stmt->execute(array($type));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_xls_files_by_type($type) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `xls_files` WHERE  `type` = ? ");
    $stmt->execute(array($type));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_xls_file_by_type_and_name($type, $name) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `xls_files` WHERE  `type` = ? AND `name` = ? ");
    $stmt->execute(array($type, $name));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insert_xls_file_get_id($xls_file) {
    $pdo = pdo_db();
    $qv = get_query_vars($xls_file);
    $stmt = $pdo->prepare('INSERT INTO `xls_files` (' . $qv['keys'] . ') VALUES(' . $qv['values_qm'] . ')  ');
    $stmt->execute($qv['values']);
    return $pdo->lastInsertId('id');
}

function update_xls_file_by_id($row) {
    $pdo = pdo_db();
    $qv = get_query_vars($row);
    $qv['values'][] = $row['id']; // for where condition;
    $stmt = $pdo->prepare('UPDATE `xls_files` SET ' . $qv['assignments'] . ' WHERE `id` = ? ');
    $stmt->execute($qv['values']);
}

function delete_xls_files_by_id($id) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("DELETE FROM `xls_files` WHERE `id` = ? ");
    $stmt->execute(array($id));
}

function truncate_xls_files() {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("TRUNCATE TABLE `xls_files`");
    $stmt->execute();
}





//*******************************  XLS ENTRIES  **********************************



function get_xls_entry_by_id($id) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `xls_entries` WHERE  `id` = ? ");
    $stmt->execute(array($id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_xls_entries_by_xls_id($xls_id) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `xls_entries` WHERE  `xls_id` = ? ");
    $stmt->execute(array($xls_id));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_xls_entries_by_type($type) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `xls_entries` WHERE  `type` = ? ");
    $stmt->execute(array($type));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_xls_entry_by_type_and_name($type, $name) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `xls_entries` WHERE  `type` = ? AND `name` = ? ");
    $stmt->execute(array($type, $name));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insert_xls_entries($xls_entry) {
    $pdo = pdo_db();
    $qv = get_query_vars($xls_entry);
    $stmt = $pdo->prepare('INSERT INTO `xls_entries` (' . $qv['keys'] . ') VALUES(' . $qv['values_qm'] . ')  ');
    $stmt->execute($qv['values']);
}

function update_xls_entries_by_id($row) {
    $pdo = pdo_db();
    $qv = get_query_vars($row);
    $qv['values'][] = $row['id']; // for where condition;
    $stmt = $pdo->prepare('UPDATE `xls_entries` SET ' . $qv['assignments'] . ' WHERE `id` = ? ');
    $stmt->execute($qv['values']);
}

function delete_xls_entries_by_id($id) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("DELETE FROM `xls_entries` WHERE `id` = ? ");
    $stmt->execute(array($id));
}

function delete_xls_entries_by_xls_id($xls_id) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("DELETE FROM `xls_entries` WHERE `xls_id` = ? ");
    $stmt->execute(array($xls_id));
}

function truncate_xls_entries() {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("TRUNCATE TABLE `xls_entries`");
    $stmt->execute();
}

// attributes

function insert_update_attributes_for_product_id($product_id, $row) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `attributes` WHERE  `name` = ? AND `value` = ? ");
    $stmt->execute(array($row['name'], $row['value']));
    $res_row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!empty($res_row)) {
        $attribute_id = $res_row['id'];
    } else {
        $qv = get_query_vars($row);
        $stmt = $pdo->prepare('INSERT INTO `attributes` (' . $qv['keys'] . ') VALUES(' . $qv['values_qm'] . ')  ');
        $stmt->execute($qv['values']);
        $attribute_id = $pdo->lastInsertId('id');
    }

    // enter into product_attribute
    $stmt = $pdo->prepare("SELECT * FROM `product_attribute` WHERE  `product_id` = ? AND `attribute_id` = ? ");
    $stmt->execute(array($product_id, $attribute_id));
    $res_row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($res_row)) {
        $stmt = $pdo->prepare('INSERT INTO `product_attribute` (`product_id`, `attribute_id`) VALUES(?, ?)');
        $stmt->execute(array($product_id, $attribute_id));
    }
}

function delete_attributes_by_product_id($product_id) {
    $pdo = pdo_db();
    $stmt = $pdo->prepare("SELECT * FROM `product_attribute` WHERE `product_id` = ? ");
    $stmt->execute(array($product_id));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($rows)) {
        //delete all
        $stmt = $pdo->prepare("DELETE FROM `product_attribute` WHERE `product_id` = ? ");
        $stmt->execute(array($product_id));

        foreach ($rows as $row) {
            $stmt = $pdo->prepare("SELECT * FROM `product_attribute` WHERE `attribute_id` = ? ");
            $stmt->execute(array($row['attribute_id']));
            $pas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($pas)) {
                $stmt = $pdo->prepare("DELETE FROM `attributes` WHERE `id` = ? ");
                $stmt->execute(array($row['attribute_id']));
            }
        }
    }
}

// non query
// products

function insert_update_product_from_xls_entry($row) {

    require 'config/xls_update_config.php';

    $attrs = array();
    $attr_keys = array();
    $filtered_row = array();
    foreach ($row as $key => $value) {
        if (in_array($key, $products_xls_columns)) {
            $filtered_row[$key] = $value;
        } elseif (!empty($value)) {
            $attrs[$key] = $value;
            $attr_keys[] = $key;
        }
    }
    $row = $filtered_row;

    $row['attributes'] = json_encode($attrs);
    $row['attributes_order'] = json_encode($attr_keys);


    if (empty($row['page_title'])) {
        $row['page_title'] = $row['name'];
    }

    $subcat = get_category_by_id($row['category_id']);
    if (!empty($subcat)) {
        $maincat = get_category_by_id($subcat['parent_id']);
    }
    if (empty($row['head_title'])) {
        $row['head_title'] = $row['name'];
        if ($maincat) {
            $row['head_title'] = $maincat['name'] . ' | ' . $row['name'];
        }
    }
    if (empty($row['url_title'])) {
        $row['url_title'] = url_title($row['name']);
    } else {
        $row['url_title'] = url_title($row['url_title']);
    }

    if (empty($row['meta_description'])) {
        $row['meta_description'] = $row['description'];
    }
    if (strlen($row['meta_description']) > 1000) {
        $row['meta_description'] = substr($row['meta_description'], 0, 1000);
    }


    if (empty($row['image_title'])) {
        $row['image_title'] = $row['name'];
    }
    if (empty($row['image_alt'])) {
        $row['image_alt'] = $row['name'];
    }

    $row['total_votes'] = 1;
    $row['total_points'] = 4;

    //generating page_url
    $page_url = $row['url_title'];
    $cat_ok = true;
    $next_cat_id = $row['category_id'];
    do {
        $cat = get_category_by_id($next_cat_id);
        if (!empty($cat)) {
            $page_url = $cat['url_title'] . "/" . $page_url;
            $next_cat_id = $cat['parent_id'];
        } else {
            $cat_ok = false;
            logger("<br>category link missing " . $row['sku']);
            break;
        }
    } while ($cat['level']);
    if ($cat_ok) {
        $row['page_url'] = $page_url;
    }

    // generating images for products
    $product_images_src_dir = $images_src_dir . "/products";
    $product_images_dest_dir = $images_dest_dir . "/products";
    $product_images_dest_url = $images_url . "/products";
    $image_src = $product_images_src_dir . "/" . $row['sku'] . ".jpg";
    $small_image_dest = $product_images_dest_dir . "/" . url_title($row['image_title']) . $small_image_extension . ".jpg";
    $medium_image_dest = $product_images_dest_dir . "/" . url_title($row['image_title']) . $medium_image_extension . ".jpg";

    if (!file_exists($small_image_dest) || !file_exists($medium_image_dest)) {
        if (file_exists($image_src)) {
            conv_image($image_src, $small_image_dest, $small_image_res[0], $small_image_res[1]);
            conv_image($image_src, $medium_image_dest, $medium_image_res[0], $medium_image_res[1]);
        } else {
            logger("<br>no source image " . $row['sku']);
        }
    }
    if (file_exists($small_image_dest) && file_exists($medium_image_dest)) {
        $row['small_image_url'] = $product_images_dest_url . "/" . url_title($row['image_title']) . $small_image_extension . ".jpg";
        $row['medium_image_url'] = $product_images_dest_url . "/" . url_title($row['image_title']) . $medium_image_extension . ".jpg";
    } else {
        logger("<br>no image " . $row['sku']);
    }

    // generating catalog and its url
    // check if destionation exist
    $exists = false;
    if (file_exists($catalogs_dest_dir . '/' . url_title($row['name']) . $catalogs_extension . '.pdf')) {
        $exists = true;
        $filename = url_title($row['name']) . $catalogs_extension . '.pdf';
    } else {
        $next_cat_id = $row['category_id'];
        while (!empty($next_cat_id)) {
            $cat = get_category_by_id($next_cat_id);
            if (file_exists($catalogs_dest_dir . '/' . url_title($cat['name']) . $catalogs_extension . '.pdf')) {
                $exists = true;
                $filename = url_title($cat['name']) . $catalogs_extension . '.pdf';
                break;
            }
            $next_cat_id = $cat['parent_id'];
        }
    }
    if (!$exists) {
        // check if source exist
        $exists = false;
        if (file_exists($catalogs_src_dir . '/' . url_title($row['name']) . '.pdf')) {
            $exists = true;
            $filename_src = url_title($row['name']) . '.pdf';
            $filename = url_title($row['name']) . $catalogs_extension . '.pdf';
        } else {
            $next_cat_id = $row['category_id'];
            while (!empty($next_cat_id)) {
                $cat = get_category_by_id($next_cat_id);
                if (file_exists($catalogs_src_dir . '/' . url_title($cat['name']) . '.pdf')) {
                    $exists = true;
                    $filename_src = url_title($cat['name']) . '.pdf';
                    $filename = url_title($cat['name']) . $catalogs_extension . '.pdf';
                    break;
                }
                $next_cat_id = $cat['parent_id'];
            }
        }
        if ($exists) {
            copy($catalogs_src_dir . '/' . $filename_src, $catalogs_dest_dir . '/' . $filename);
        }
    }
    if ($exists && file_exists($catalogs_dest_dir . '/' . $filename)) {
        $row['catalog_url'] = $catalogs_url . '/' . $filename;
    }



    $product_id = insert_update_products_by_sku_get_id($row);

    delete_attributes_by_product_id($product_id);

    //updating attributes
    foreach ($attrs as $key => $value) {
        insert_update_attributes_for_product_id($product_id, array('name' => $key, 'value' => $value));
    }
    
    logger('product updated '.$row['name']);
}

function insert_update_product_from_post($post) {


    require 'config/xls_update_config.php';
    $row = array();

    foreach ($post as $key => $value) {
        if (in_array($key, $products_xls_columns)) {
            $row[$key] = clear_data($value);
        }
    }

    foreach ($post['attrs'] as $attr) {
        $key = clear_data($attr[0]);
        $value = clear_data($attr[1]);
        if (!empty($key) && !in_array($key, $products_xls_columns)) {
            $row[$key] = $value;
        }
    }

    $xls_file_id = $post['xls_file_id'];

    // update xls_file
    $columns = array();
    foreach ($row as $key => $value) {
        $columns[] = $key;
    }
    $xls_file = array('id' => $xls_file_id, 'columns' => json_encode($columns));
    update_xls_file_by_id($xls_file);


    if (!empty($post['xls_entry_id'])) {
        $xls_entry_res = get_xls_entry_by_id($post['xls_entry_id']);
    }
    if (empty($xls_entry_res)) { //insert
        $xls_entry = array('name' => $row['sku'], 'type' => 'product', 'entry' => json_encode($row), 'xls_id' => $xls_file_id);
        insert_xls_entries($xls_entry);
    } else { // update
        $xls_entry = array('id' => $post['xls_entry_id'], 'name' => $row['sku'], 'type' => 'product', 'entry' => json_encode($row), 'xls_id' => $xls_file_id);
        update_xls_entries_by_id($xls_entry);
    }

    update_xls_file_from_xls_db_by_id($xls_file_id);

    insert_update_product_from_xls_entry($row);
}

function delete_product_from_db_and_xls_by_id($id) {
    $row = get_product_by_id($id);
    $xls_entry = get_xls_entry_by_type_and_name('product', $row['sku']);
    delete_xls_entries_by_id($xls_entry['id']);
    update_xls_file_from_xls_db_by_id($xls_entry['xls_id']);
    delete_products_by_id($row['id']);
    delete_attributes_by_product_id($row['id']);
}

// categories

function insert_update_category_from_xls_entry($row) {

    require 'config/xls_update_config.php';

    if (empty($row['page_title'])) {
        $row['page_title'] = $row['name'];
    }

    $maincat = get_category_by_id($row['parent_id']);
    if (empty($row['head_title'])) {
        $row['head_title'] = $row['name'] . ' | Lab Equipment';
        if ($maincat) {
            $row['head_title'] = $maincat['name'] . ' | ' . $row['name'] . ' | Lab Equipment';
        }
    }
    if (empty($row['head_title'])) {
        $row['head_title'] = $row['name'];
    }
    if (empty($row['url_title'])) {
        $row['url_title'] = url_title($row['name']);
    } else {
        $row['url_title'] = url_title($row['url_title']);
    }

    if (empty($row['meta_description'])) {
        $row['meta_description'] = $row['description'];
    }
    if (strlen($row['meta_description']) > 1000) {
        $row['meta_description'] = substr($row['meta_description'], 0, 1000);
    }

    if (empty($row['image_title'])) {
        $row['image_title'] = $row['name'];
    }
    if (empty($row['image_alt'])) {
        $row['image_alt'] = $row['name'];
    }

    // images
    $category_images_src_dir = $images_src_dir . "/categories";
    $category_images_dest_dir = $images_dest_dir . "/categories";
    $category_images_dest_url = $images_url . "/categories";

    $image_src = $category_images_src_dir . "/" . url_title($row['name']) . ".jpg";
    $small_image_dest = $category_images_dest_dir . "/" . url_title($row['image_title']) . $small_image_extension . ".jpg";
    $medium_image_dest = $category_images_dest_dir . "/" . url_title($row['image_title']) . $medium_image_extension . ".jpg";
    if (!file_exists($small_image_dest) || !file_exists($medium_image_dest)) {
        if (file_exists($image_src)) {
            conv_image($image_src, $small_image_dest, $small_image_res[0], $small_image_res[1]);
            conv_image($image_src, $medium_image_dest, $medium_image_res[0], $medium_image_res[1]);
        } else {
            logger("<br>no source image " . $row['name']);
        }
    }
    if (file_exists($small_image_dest) && file_exists($medium_image_dest)) {
        $row['small_image_url'] = $category_images_dest_url . "/" . url_title($row['image_title']) . $small_image_extension . ".jpg";
        $row['medium_image_url'] = $category_images_dest_url . "/" . url_title($row['image_title']) . $medium_image_extension . ".jpg";
    } else {
        logger("<br>no image " . $row['name']);
    }


    insert_update_categories_by_id($row);
}

function insert_update_category_from_post($post) {

    require 'config/xls_update_config.php';
    $row = array();

    foreach ($post as $key => $value) {
        if (in_array($key, $categories_xls_columns)) {
            $row[$key] = $value;
        }
    }

    if (!empty($post['xls_entry_id'])) {
        $xls_entry_res = get_xls_entry_by_id($post['xls_entry_id']);
    }
    if (empty($xls_entry_res)) { //insert
        $xls_file = get_xls_file_by_type('category');
        $xls_file_id = $xls_file['id'];
        $xls_entry = array('name' => $row['id'], 'type' => 'category', 'entry' => json_encode($row), 'xls_id' => $xls_file_id);
        insert_xls_entries($xls_entry);
    } else { // update
        $xls_file_id = $xls_entry_res['xls_id'];
        $xls_entry = array('id' => $post['xls_entry_id'], 'name' => $row['id'], 'type' => 'category', 'entry' => json_encode($row));
        update_xls_entries_by_id($xls_entry);
    }

    update_xls_file_from_xls_db_by_id($xls_file_id);

    insert_update_category_from_xls_entry($row);

    refresh_categories_page_urls_and_levels();
}

function refresh_categories_page_urls_and_levels() {
    $rows = get_all_categories();
    $changed_ids = array();

    // setting page_urls and level

    function traverse_children($id, $level, $parent_page_url, &$rows, &$changed_ids) {
        for ($i = 0; $i < count($rows); $i++) {
            if ($rows[$i]['parent_id'] == $id) {
                $level_before = $rows[$i]['level'];
                $page_url_before = $rows[$i]['page_url'];
                $rows[$i]['level'] = $level;
                $rows[$i]['page_url'] = $parent_page_url . "/" . $rows[$i]['url_title'];
                if ($page_url_before != $rows[$i]['page_url'] || $level_before != $rows[$i]['level']) {
                    $changed_ids[] = $i;
                }
                traverse_children($rows[$i]['id'], $level + 1, $rows[$i]['page_url'], $rows, $changed_ids);
            }
        }
    }

    for ($i = 0; $i < count($rows); $i++) {
        if (!$rows[$i]['parent_id']) { // this is a root , trace its childs and set their level and their page_urls
            $page_url_before = $rows[$i]['page_url'];
            $rows[$i]['page_url'] = $rows[$i]['url_title'];
            if ($page_url_before != $rows[$i]['page_url']) {
                $changed_ids[] = $i;
            }
            traverse_children($rows[$i]['id'], 1, $rows[$i]['page_url'], $rows, $changed_ids);
        }
    }


    foreach ($changed_ids as $changed_id) {
        update_categories_by_id($rows[$changed_id]);
    }

    foreach ($changed_ids as $changed_id) { // check if product exist on main db then check if its xls entry exist then update.
        $products = get_products_by_category_id($rows[$changed_id]['id']);
        if (!empty($products)) {
            foreach ($products as $product) {

                $xls_entry = get_xls_entry_by_type_and_name('product', $product['sku']);
                if (!empty($xls_entry)) {
                    insert_update_product_from_xls_entry(json_decode($xls_entry['entry'], true));
                }
            }
        }
    }
}

function delete_category_from_db_and_xls_by_id($id) {
    $row = get_category_by_id($id);
    $xls_entry = get_xls_entry_by_type_and_name('category', $row['id']);
    delete_xls_entries_by_id($xls_entry['id']);
    update_xls_file_from_xls_db_by_id($xls_entry['xls_id']);
    delete_categories_by_id($row['id']);
    refresh_categories_page_urls_and_levels();
}

//pages

function insert_update_page_from_xls_entry($row) {
    if (empty($row['page_title'])) {
        $row['page_title'] = $row['name'];
    }
    if (empty($row['head_title'])) {
        $row['head_title'] = $row['page_title'];
    }
    if (empty($row['url_title'])) {
        $row['url_title'] = url_title($row['page_title']);
    } else {
        $row['url_title'] = url_title($row['url_title']);
    }
    $row['page_url'] = $row['url_title'];


    insert_update_pages_by_name($row);
}

function insert_update_page_from_post($post) {

    require 'config/xls_update_config.php';
    $row = array();

    foreach ($post as $key => $value) {
        if (in_array($key, $pages_xls_columns)) {
            $row[$key] = $value;
        }
    }


    if (!empty($post['xls_entry_id'])) {
        $xls_entry_res = get_xls_entry_by_id($post['xls_entry_id']);
    }
    if (empty($xls_entry_res)) { //insert
        $xls_file = get_xls_file_by_type('page');
        $xls_file_id = $xls_file['id'];
        $xls_entry = array('name' => $row['name'], 'type' => 'page', 'entry' => json_encode($row), 'xls_id' => $xls_file_id);
        insert_xls_entries($xls_entry);
    } else { // update
        $xls_file_id = $xls_entry_res['xls_id'];
        $xls_entry = array('id' => $post['xls_entry_id'], 'name' => $row['name'], 'type' => 'page', 'entry' => json_encode($row));
        update_xls_entries_by_id($xls_entry);
    }

    update_xls_file_from_xls_db_by_id($xls_file_id);

    insert_update_page_from_xls_entry($row);
}

function delete_page_from_db_and_xls_by_id($id) {
    $row = get_page_by_id($id);
    $xls_entry = get_xls_entry_by_type_and_name('page', $row['name']);
    delete_xls_entries_by_id($xls_entry['id']);
    update_xls_file_from_xls_db_by_id($xls_entry['xls_id']);
    delete_pages_by_id($row['id']);
}

function update_xls_db_from_xls_file_by_type_and_name($type, $name) {

    require 'config/xls_update_config.php';

    $change_set = array('changed' => array(), 'unchanged' => array(), 'deleted' => array());
    $path = $excels_dir . '/' . ($type == 'product' ? 'products/' : '') . $name;

    $xls = get_xls($path);
    $details = array();
    $details['size'] = filesize($path);
    $details['last_modified'] = filemtime($path);
    $new_xls_file = array('name' => $name, 'type' => $type, 'columns' => json_encode($xls['keys']), 'details' => json_encode($details));

    $xls_file = get_xls_file_by_type_and_name($type, $name);
    $xls_entries = get_xls_entries_by_xls_id($xls_file['id']);
    delete_xls_files_by_id($xls_file['id']);
    delete_xls_entries_by_xls_id($xls_file['id']);

    $names = array();
    $xls_file_id = insert_xls_file_get_id($new_xls_file);
    foreach ($xls['rows'] as $row) {
        $new_xls_entry = array('name' => $row[$unique_column_names[$type]], 'type' => $type, 'entry' => json_encode($row), 'xls_id' => $xls_file_id);
        $found = false;
        foreach ($xls_entries as $xls_entry) {
            if ($new_xls_entry['name'] == $xls_entry['name']) {
                $found = true;
                if ($new_xls_entry['entry'] != $xls_entry['entry']) {
                    $change_set['changed'][] = $new_xls_entry;
                } else {
                    $change_set['unchanged'][] = $new_xls_entry;
                }
                break;
            }
        }
        if (!$found) {
            $change_set['changed'][] = $new_xls_entry;
        }
        $names[] = $new_xls_entry['name'];
        insert_xls_entries($new_xls_entry);
    }
    foreach ($xls_entries as $xls_entry) {
        if (!in_array($xls_entry['name'], $names)) {
            $change_set['deleted'][] = $xls_entry;
        }
    }

    return $change_set;
}

function get_xls($xls_path) {

    require_once 'helpers/PHPExcel_helper.php';

    $keys = array();
    $rows = array();
    $keys_done = false;

    $objPHPExcel = new PHPExcel();
    $objReader = new PHPExcel_Reader_Excel5();
    $objPHPExcel = $objReader->load($xls_path);
    $objPHPExcel->setActiveSheetIndex(0);
    $objWorksheet = $objPHPExcel->getActiveSheet();

    foreach ($objWorksheet->getRowIterator() as $xls_row) {
        $cellIterator = $xls_row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);
        $values = array();
        foreach ($cellIterator as $cell) {
            $values[] = clear_data($cell->getValue());
        }
        if (!$keys_done) {
            foreach ($values as $value) {
                if ($value != "") {
                    $keys[] = $value;
                } else {
                    break;
                }
            }
            $keys_done = true;
        } else {
            $row_exists = false;
            foreach ($values as $value) {
                if ($value != '') {
                    $row_exists = true;
                    break;
                }
            }
            if ($row_exists) {
                $row = array();
                for ($i = 0; $i < count($keys); $i++) {
                    $row[$keys[$i]] = $values[$i];
                }
                $rows[] = $row;
            }
        }
    }

    $xls = array(
        'keys' => $keys,
        'rows' => $rows,
        'column_count' => count($keys),
        'row_count' => count($rows)
    );
    return $xls;
}

// misc

function update_from_xls_db_by_type_and_change_set($type, $change_set, $config = array()) {

    require 'config/xls_update_config.php';

    $config_defaults = array(
        'delete_action' => false,
        'force_update' => false
    );
    // setting defaults
    foreach ($config_defaults as $key => $value) {
        if (!isset($config[$key])) {
            $config[$key] = $value;
        }
    }


    if ($type == 'page') {

        foreach ($change_set['changed'] as $xls_entry) {
            $row = json_decode($xls_entry['entry'], true);
            insert_update_page_from_xls_entry($row);
        }
        if ($config['force_update']) {
            foreach ($change_set['unchanged'] as $xls_entry) {
                $row = json_decode($xls_entry['entry'], true);
                insert_update_page_from_xls_entry($row);
            }
        }
        if ($config['delete_action']) {
            foreach ($change_set['deleted'] as $xls_entry) {
                delete_pages_by_id($xls_entry['id']);
            }
        }
    } elseif ($type == 'category') {

        foreach ($change_set['changed'] as $xls_entry) {
            $row = json_decode($xls_entry['entry'], true);
            insert_update_category_from_xls_entry($row);
        }
        if ($config['force_update']) {
            foreach ($change_set['unchanged'] as $xls_entry) {
                $row = json_decode($xls_entry['entry'], true);
                insert_update_category_from_xls_entry($row);
            }
        }
        if ($config['delete_action']) {
            foreach ($change_set['deleted'] as $xls_entry) {
                delete_categories_by_id($xls_entry['id']);
            }
        }
        refresh_categories_page_urls_and_levels();
    } elseif ($type == 'product') {

        foreach ($change_set['changed'] as $xls_entry) {
            $row = json_decode($xls_entry['entry'], true);
            insert_update_product_from_xls_entry($row);
        }
        if ($config['force_update']) {
            foreach ($change_set['unchanged'] as $xls_entry) {
                $row = json_decode($xls_entry['entry'], true);
                insert_update_product_from_xls_entry($row);
            }
        }
        if ($config['delete_action']) {
            foreach ($change_set['deleted'] as $xls_entry) {
                delete_products_by_id($xls_entry['id']);
                delete_attributes_by_product_id($xls_entry['id']);
            }
        }
    }
}

function update_xls_file_from_xls_db_by_id($id) {

    require_once 'helpers/PHPExcel_helper.php';
    require 'config/xls_update_config.php';

    $xls_file = get_xls_file_by_id($id);
    $xls_entries = get_xls_entries_by_xls_id($xls_file['id']);
    $column_names = json_decode($xls_file['columns'], true);
    $xls_path = $excels_dir . ($xls_file['type'] == 'product' ? "/products" : "") . '/' . $xls_file['name'];

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objWorksheet = $objPHPExcel->getActiveSheet();
    if (file_exists($xls_path)) {
        $objReader = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $objReader->load($xls_path);
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
    $row_index = 1; //starts with 1
    foreach ($column_names as $column_name) {
        $objWorksheet->setCellValueByColumnAndRow($column_index, $row_index, $column_name);
        $column_index++;
    }

    $column_index = 0;
    $row_index++;
    foreach ($xls_entries as $xls_entry) {
        $row = json_decode($xls_entry['entry'], true);
        foreach ($column_names as $column_name) {
            if (!empty($row[$column_name])) {
                $objWorksheet->setCellValueByColumnAndRow($column_index, $row_index, $row[$column_name]);
            } else {
                $objWorksheet->setCellValueByColumnAndRow($column_index, $row_index, ' '); // appending spaces for cell overflow problem
            }
            $column_index++;
        }
        $column_index = 0;
        $row_index++;
    }

    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); // for .xls 
    $objWriter->save($xls_path);

    $details = array();
    $details['size'] = filesize($xls_path);
    $details['last_modified'] = filemtime($xls_path);

    $xls_file['details'] = json_encode($details);
    update_xls_file_by_id($xls_file);
}
