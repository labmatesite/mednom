<?php

function et_products_delete_attributes($mysqli, $product_id)
{
    $rows = et_get_all($mysqli, 'product_attribute', array('where' => array('product_id' => $product_id)));

    if (!empty($rows)) {
        //delete all
        et_delete_by_identifier($mysqli, 'product_attribute', 'product_id', $product_id);

        foreach ($rows as $row) {
            $pas = et_get_all($mysqli, 'product_attribute', array('where' => array('attribute_id' => $row['attribute_id'])));
            if (empty($pas)) {
                et_delete_by_identifier($mysqli, 'attributes', 'id', $row['attribute_id']);
            }
        }
    }
}

function et_products_add_attributes($mysqli, $attrs, $product_id, $prefix = '')
{
    foreach ($attrs as $key => $value) {
        $name = $prefix . ' ' . $key;

        if (is_array($value)) {
            et_products_add_attributes($mysqli, $value, $product_id, $name);
        } else {
            $res_rows = et_get_all($mysqli, 'attributes', array('where' => array('name' => $name, 'value' => $value)));
            if (!empty($res_rows)) {
                $attribute_id = $res_rows[0]['id'];
            } else {
                $attribute_id = et_add($mysqli, 'attributes', array('name' => $name, 'value' => $value));
            }
            // enter into product_attribute
            $res_rows = et_get_all($mysqli, 'product_attribute', array('where' => array('product_id' => $product_id, 'attribute_id' => $attribute_id)));
            if (empty($res_rows)) {
                et_add($mysqli, 'product_attribute', array('product_id' => $product_id, 'attribute_id' => $attribute_id));
            }
        }
    }
}

function et_products_gen_extras($mysqli, $entity_attr, $rows)
{

    $config = get_config();
    $identifier_name = $entity_attr['excel_identifier'];

    $product_images_src_dir = $config['product_images_src'];
    $product_images_dest_dir = $config['product_images_dest'];
    $product_images_dest_url = $config['product_images_url'];
    $small_image_res = $config['product_small_image_res'];
    $medium_image_res = $config['product_medium_image_res'];
    $small_image_extension = $config['product_small_image_ext'];
    $medium_image_extension = $config['product_medium_image_ext'];
    $catalogs_dest_dir = $config['product_catalogs_dir'];
    $catalogs_url = $config['product_catalogs_url'];
    $catalogs_ext = $config['product_catalogs_ext'];
    $product_image_compression = $config['product_image_compression'];
    $product_image_squared = $config['product_image_squared'];

    foreach ($rows as $row) {

        $edit_row = array();
        $meta = array();
        if (!empty($row['meta'])) {
            json_decode($row['meta'], true);
        }

        if (empty($meta['page_title'])) {
            $edit_row['page_title'] = $row['name'];
        } else {
            $edit_row['page_title'] = $meta['page_title'];
        }

        $subcat = et_get_by_identifier($mysqli, 'categories', 'id', $row['category_id']);
        if (!empty($subcat)) {
            $maincat = et_get_by_identifier($mysqli, 'categories', 'id', $subcat['parent_id']);
        } else {
            echo 'No category found for the product ' . $row['sku'];
        }
        if (empty($meta['head_title'])) {
            $edit_row['head_title'] = $row['name'];
            if (!empty($maincat)) {
                $edit_row['head_title'] = $maincat['name'] . ' | ' . $row['name'];
            }
        } else {
            $edit_row['head_title'] = $meta['head_title'];
        }

        if (empty($meta['url_title'])) {
            $edit_row['url_title'] = url_title($row['sku']);
            $url_title = $edit_row['url_title'];
        } else {
            $edit_row['url_title'] = url_title($meta['url_title']);
            $url_title = $edit_row['url_title'];
        }

        if (empty($meta['meta_description'])) {
            $edit_row['meta_description'] = $row['description'];
        } else {
            $edit_row['meta_description'] = $meta['meta_description'];
        }
        if (strlen($edit_row['meta_description']) > 1000) {
            $edit_row['meta_description'] = substr($edit_row['meta_description'], 0, 1000);
        }

        if (empty($meta['image_title'])) {
            $edit_row['image_title'] = $row['name'];
            $image_title = $edit_row['image_title'];
        } else {
            $edit_row['image_title'] = $meta['image_title'];
            $image_title = $edit_row['image_title'];
        }
        if (empty($meta['image_alt'])) {
            $edit_row['image_alt'] = $row['name'];
        } else {
            $edit_row['image_alt'] = $meta['image_alt'];
        }


        //generating page_url
        $page_url = $url_title;
        $cat_ok = true;
        $next_cat_id = $row['category_id'];
        do {
            $cat = et_get_by_identifier($mysqli, 'categories', 'id', $next_cat_id);
            if (!empty($cat)) {
                $page_url = $cat['url_title'] . "/" . $page_url;
                $next_cat_id = $cat['parent_id'];
            } else {
                $cat_ok = false;
                echo "<br>category link missing " . $row['sku'];
                break;
            }
        } while ($cat['level']);
        if ($cat_ok) {
            $edit_row['page_url'] = $page_url;
        }

        // generating images for products

        $small_image_dest = $product_images_dest_dir . "/" . url_title($image_title) . $small_image_extension . ".jpg";
        $medium_image_dest = $product_images_dest_dir . "/" . url_title($image_title) . $medium_image_extension . ".jpg";

        $image_src = '';
        if (!file_exists($small_image_dest) || !file_exists($medium_image_dest)) {
            if (file_exists($product_images_src_dir . "/" . $row['sku'] . ".png")) {
                $image_src = $product_images_src_dir . "/" . $row['sku'] . ".png";
            } elseif (file_exists($product_images_src_dir . "/" . $row['sku'] . ".jpg")) {
                $image_src = $product_images_src_dir . "/" . $row['sku'] . ".jpg";

            }
            if (!empty($image_src)) {
                conv_image($image_src, $small_image_dest, $small_image_res[0], $small_image_res[1], $product_image_compression, $product_image_squared);
                conv_image($image_src, $medium_image_dest, $medium_image_res[0], $medium_image_res[1], $product_image_compression, $product_image_squared);
            } else {
                echo "<br>no source image " . $row['sku'];
            }
        }
        if (file_exists($small_image_dest) && file_exists($medium_image_dest)) {
            $edit_row['image_urls'] = array();
            $edit_row['image_urls']['small'] = $product_images_dest_url . "/" . url_title($image_title) . $small_image_extension . ".jpg";
            $edit_row['image_urls']['medium'] = $product_images_dest_url . "/" . url_title($image_title) . $medium_image_extension . ".jpg";
            $edit_row['image_urls'] = json_encode($edit_row['image_urls']);
        } else {
            echo "<br>no image " . $row['sku'];
        }

        // generating catalog and its url
        // check if destination  exist
        $exists = false;

        if (file_exists_case_sensitive($catalogs_dest_dir . '/' . url_title($row['name']) . $catalogs_ext . '.pdf')) {
            $exists = true;
            $filename = url_title($row['name']) . $catalogs_ext . '.pdf';
        } else {
            $next_cat_id = $row['category_id'];
            $cat = et_get_by_identifier($mysqli, 'categories', 'id', $next_cat_id);
            if (!empty($row['series']) && file_exists_case_sensitive($catalogs_dest_dir . '/' . url_title($cat['name']) . '-' . $row['series'] . $catalogs_ext . '.pdf')) {
                $exists = true;
                $filename = url_title($cat['name']) . '-' . $row['series'] . $catalogs_ext . '.pdf';
            } else {
                $next_cat_id = $row['category_id'];
                while (!empty($next_cat_id)) {
                    $cat = et_get_by_identifier($mysqli, 'categories', 'id', $next_cat_id);
                    if (file_exists_case_sensitive($catalogs_dest_dir . '/' . url_title($cat['name']) . $catalogs_ext . '.pdf')) {
                        $exists = true;
                        $filename = url_title($cat['name']) . $catalogs_ext . '.pdf';
                        break;
                    }
                    $next_cat_id = $cat['parent_id'];
                }

            }
        }
        if ($exists && file_exists($catalogs_dest_dir . '/' . $filename)) {

            $edit_row['catalog_url'] = $catalogs_url . '/' . $filename;
        } else {
            echo "<br>no catalog " . $row['sku'] . '<br>';
        }

        $edited = false;
        foreach ($edit_row as $key => $value) {
            if (!isset($row[$key]) || $row[$key] != $value) {
                $edited = true;
                break;
            }
        }
        if ($edited) {
            et_edit_by_identifier($mysqli, $entity_attr['name'], $edit_row, $identifier_name, $row[$identifier_name]);
        }

        $product_id = $row['id'];
        et_products_delete_attributes($mysqli, $product_id);
        $specs = json_decode($row['specifications'], true);
        et_products_add_attributes($mysqli, $specs, $product_id);
    }
}

function et_products_delete_extras($mysqli, $entity_attr, $rows)
{
    foreach ($rows as $row) {
        et_products_delete_attributes($mysqli, $row['id']);
    }
}

function et_categories_gen_extras($mysqli, $entity_attr, $rows)
{

    $config = get_config();
    $category_head_title_ext = $config['category_head_title_ext'];
    $identifier_name = $entity_attr['excel_identifier'];

    $category_images_src_dir = $config['category_images_src'];
    $category_images_dest_dir = $config['category_images_dest'];
    $category_images_dest_url = $config['category_images_url'];
    $small_image_res = $config['category_small_image_res'];
    $medium_image_res = $config['category_medium_image_res'];
    $small_image_extension = $config['category_small_image_ext'];
    $medium_image_extension = $config['category_medium_image_ext'];
    $product_image_compression = $config['product_image_compression'];
    $product_image_squared = $config['product_image_squared'];

    foreach ($rows as $row) {

        $edit_row = array();
        $meta = array();
        if (!empty($row['meta'])) {
            json_decode($row['meta'], true);
        }

        if (empty($meta['page_title'])) {
            $edit_row['page_title'] = $row['name'];
        } else {
            $edit_row['page_title'] = $meta['page_title'];
        }

        $maincat = et_get_by_identifier($mysqli, 'categories', 'id', $row['parent_id']);
        if (empty($meta['head_title'])) {
            $edit_row['head_title'] = $row['name'] . $category_head_title_ext;
            if ($maincat) {
                $edit_row['head_title'] = $maincat['name'] . ' | ' . $row['name'] . $category_head_title_ext;
            }
        } else {
            $edit_row['head_title'] = $meta['head_title'];
        }
        if (empty($meta['url_title'])) {
            $edit_row['url_title'] = url_title($row['name']);
        } else {
            $edit_row['url_title'] = url_title($meta['url_title']);
        }

        if (empty($meta['meta_description'])) {
            $edit_row['meta_description'] = $row['description'];
        } else {
            $edit_row['meta_description'] = $meta['meta_description'];
        }
        if (strlen($edit_row['meta_description']) > 1000) {
            $edit_row['meta_description'] = substr($edit_row['meta_description'], 0, 1000);
        }

        if (empty($meta['image_title'])) {
            $edit_row['image_title'] = $row['name'];
            $image_title = $edit_row['image_title'];
        } else {
            $edit_row['image_title'] = $meta['image_title'];
            $image_title = $edit_row['image_title'];
        }
        if (empty($meta['image_alt'])) {
            $edit_row['image_alt'] = $row['name'];
        } else {
            $edit_row['image_alt'] = $meta['image_alt'];
        }


        // images

        $small_image_dest = $category_images_dest_dir . "/" . url_title($image_title) . $small_image_extension . ".jpg";
        $medium_image_dest = $category_images_dest_dir . "/" . url_title($image_title) . $medium_image_extension . ".jpg";
        if (!file_exists($small_image_dest) || !file_exists($medium_image_dest)) {
            if (file_exists($category_images_src_dir . "/" . url_title($row['name']) . ".png")) {
                $image_src = $category_images_src_dir . "/" . url_title($row['name']) . ".png";
            } elseif (file_exists($category_images_src_dir . "/" . url_title($row['name']) . ".jpg")) {
                $image_src = $category_images_src_dir . "/" . url_title($row['name']) . ".jpg";
            }
            if (!empty($image_src)) {
                conv_image($image_src, $small_image_dest, $small_image_res[0], $small_image_res[1], $product_image_compression, $product_image_squared);
                conv_image($image_src, $medium_image_dest, $medium_image_res[0], $medium_image_res[1], $product_image_compression, $product_image_squared);
            } else {
                //echo "<br>no source image " . $row['name'];
            }
        }
        if (file_exists($small_image_dest) && file_exists($medium_image_dest)) {
            $edit_row['image_urls'] = array();
            $edit_row['image_urls']['small'] = $category_images_dest_url . "/" . url_title($image_title) . $small_image_extension . ".jpg";
            $edit_row['image_urls']['medium'] = $category_images_dest_url . "/" . url_title($image_title) . $medium_image_extension . ".jpg";
            $edit_row['image_urls'] = json_encode($edit_row['image_urls']);
        } else {
            //echo "<br>no image " . $row['name'];
        }

        try {
            //echo $edit_row;
            et_edit_by_identifier($mysqli, $entity_attr['name'], $edit_row, $identifier_name, $row[$identifier_name]);
        } catch (Exception $e) {
            //ignore update errors
        }
    }


    $rows = et_get_all($mysqli, $entity_attr['name']);
    $changed_ids = array();

    // setting page_urls and level

    if (!function_exists('et_categories_traverse_children')) {

        function et_categories_traverse_children($id, $level, $parent_page_url, &$rows, &$changed_ids)
        {
            for ($i = 0; $i < count($rows); $i++) {
                if ($rows[$i]['parent_id'] == $id) {
                    $level_before = $rows[$i]['level'];
                    $page_url_before = $rows[$i]['page_url'];
                    $rows[$i]['level'] = $level;
                    $rows[$i]['page_url'] = $parent_page_url . "/" . $rows[$i]['url_title'];
                    if ($page_url_before != $rows[$i]['page_url'] || $level_before != $rows[$i]['level']) {
                        $changed_ids[] = $i;
                    }
                    et_categories_traverse_children($rows[$i]['id'], $level + 1, $rows[$i]['page_url'], $rows, $changed_ids);
                }
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
            et_categories_traverse_children($rows[$i]['id'], 1, $rows[$i]['page_url'], $rows, $changed_ids);
        }
    }


    foreach ($changed_ids as $changed_id) {
        try {
            et_edit_by_identifier($mysqli, $entity_attr['name'], $rows[$changed_id], $identifier_name, $rows[$changed_id][$identifier_name]);
        } catch (Exception $e) {
            //ignore update errors
        }
    }

    /*
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
     */
}
