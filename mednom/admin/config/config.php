<?php
ini_set('max_execution_time', 30 * 60);

function get_config() {
    if(!in_array($_SERVER['REMOTE_ADDR'], array("127.0.0.1","::1"))){

        // for online
        $config['db_host'] = 'localhost';
        $config['db_user'] = 'biodeals_sunny';
        $config['db_pass'] = 'Sunny#110';
        $config['db_name'] = 'biodeals_new_labo';
        $config['base_url'] = ''; // can be blank

    } else {

        // for localhost
        $config['db_host'] = 'localhost';
        $config['db_user'] = 'biodeals_sunny';
        $config['db_pass'] = 'Sunny#110';
        $config['db_name'] = 'biodeals_new_labo';

        $config['base_url']	= ''; // can be blank
    }

    $config['development_mode'] = true;

    $config['lowercase_urls'] = false;


    if(empty($config['base_url'])){ // figure out base_url
        $self_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        $config['base_url'] = preg_replace('/index\.php$/', '', $self_url);
    }



    $config['admin_dir'] = getcwd(); // when included by admin/index.php


    $config['product_images_src'] = $config['admin_dir'] . '/../assets/resources/images/products';
    $config['product_images_dest'] = $config['admin_dir'] . '/../assets/images/products';
    $config['product_images_url'] = 'assets/images/products';
    $config['product_catalogs_dir'] = $config['admin_dir'] . '/../catalog';
    $config['product_catalogs_url'] = 'catalog';
    $config['product_catalogs_ext'] = '';
    $config['product_small_image_res'] = array(150, 150);
    $config['product_medium_image_res'] = array(250, 250);
    $config['product_small_image_ext'] = '-150x150';
    $config['product_medium_image_ext'] = '-250x250';
    $config['product_image_compression'] = 90;
    $config['product_image_squared'] = true;

    $config['category_images_src'] = $config['admin_dir'] . '/../assets/resources/images/categories';
    $config['category_images_dest'] = $config['admin_dir'] . '/../assets/images/categories';
    $config['category_images_url'] = 'assets/images/categories';
    $config['category_small_image_res'] = array(150, 150);
    $config['category_medium_image_res'] = array(250, 250);
    $config['category_small_image_ext'] = '-150x150';
    $config['category_medium_image_ext'] = '-250x250';
    $config['category_head_title_ext'] = ' | Lab Equipment';


    // ADMIN MODULE CONFIGS (Paths relative to admin index.php)


    $config['models_dir'] = "models";
    $config['includes_dir'] = "includes";
    $config['excels_dir'] = $config['admin_dir'] . "/../assets/resources/excels";


    $config['default_column_attribute_by_name'] = array(
        'id' => json_decode(
            "{\"name\":\"id\",\"display_name\":\"ID\",\"data_type\":\"int_11\",\"unique\":\"1\",\"not_empty\":\"0\",\"default_value\":\"\",\"validation\":\"\",\"table_column\":\"0\",\"excel_column\":\"0\",\"hide_on_add\":\"1\",\"hide_on_edit\":\"0\",\"lock_on_add\":\"0\",\"lock_on_edit\":\"1\",\"no_trim\":\"0\",\"selection_data\":{},\"is_four_spaced_json\":\"0\",\"is_column_wise_json\":\"0\",\"column_wise_json_structure\":{},\"structure_nodes\":[],\"structure_attributes\":{}}"
        , true)
    );

    $config['default_column_attribute'] = json_decode(
        "{\"name\":\"\",\"display_name\":\"\",\"data_type\":\"text\",\"unique\":\"0\",\"not_empty\":\"0\",\"default_value\":\"\",\"validation\":\"\",\"table_column\":\"0\",\"excel_column\":\"0\",\"hide_on_add\":\"0\",\"hide_on_edit\":\"0\",\"lock_on_add\":\"0\",\"lock_on_edit\":\"0\",\"no_trim\":\"0\",\"selection_data\":{},\"is_four_spaced_json\":\"0\",\"is_column_wise_json\":\"0\",\"column_wise_json_structure\":{},\"structure_nodes\":[],\"structure_attributes\":{}}"
    , true);


    return $config;
}

function debug($expression){
    echo '<pre>';
    print_r($expression);
    echo '</pre>';
    exit();
}
