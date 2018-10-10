<?php

require_once 'header_includes.php';
et_sec_session_start();
$mysqli = get_mysqli();
if (!et_login_check($mysqli)) {
    header("Location: login.php");
}
$parts = explode('/', $_SERVER["SCRIPT_NAME"]);
$file = $parts[count($parts) - 1];
if ($file != 'index.php' && !et_user_privileges_check($mysqli, $_GET['en'], $_GET['vn'])) {
    header("Location: index.php");
}

$menu_html = '';
$entity_rows = et_get_all($mysqli, 'et_entities', array('order_by' => array('order')));
$menu_items = array();
foreach ($entity_rows as $k => $v) {
    if (in_array($v['name'], array('categories', 'products', 'price_list', 'pages'))) {
        $menu_items[$k] = $v;
    }
}
foreach ($menu_items as $entity_row) {
    $entity_views = json_decode($entity_row['views'], true);
    $views = array();
    if (!empty($entity_views)) {
        foreach ($entity_views as $view) {
            if (et_user_privileges_check($mysqli, $entity_row['name'], $view['name'])) {
                $views[] = $view;
            }
        }
        if (!empty($views)) {
            $menu_html .= '<li><a href="#">' . $entity_row['display_name'] . '</a><ul>';
            foreach ($views as $view) {
                if (!empty($view['show_in_menu'])) {
                    $menu_html .= '<a href="' . $view['view_file'] . '.php?en=' . $entity_row['name'] . '&vn=' . $view['name'] . '"><li>' . $view['display_name'] . '</li></a>';
                }
            }
            $menu_html .= '</ul></li>';
        }
    }
}


?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="assets/css/json_editor.css">
    <link type="text/css" rel="stylesheet" href="assets/css/dashboard.css"/>

    <script src="assets/js/jquery-2.1.1.min.js"></script>
    <script src="assets/js/jquery-html5sortable.js"></script>
    <script src="assets/js/commons.js"></script>
    <script src="assets/js/ckeditor/ckeditor.js"></script>
    <script src="assets/js/slowaes.js"></script>
    <script src="assets/js/slowaes_aes.js"></script>
    <script src="assets/js/slowaes_cryptoHelpers.js"></script>
    <script src="assets/js/slowaes_jsHash.js"></script>
    <script src="assets/js/cryptojs_core.js"></script>
    <script src="assets/js/json_editor.js"></script>
    <script src="assets/js/admin_helper.js"></script>

</head>

<body>
<div class="dashboard-container">
    <div class="admin">Admin Panel</div>
    <a href="register.php">Register</a><br><br><a href="logout.php">Logout</a>
    <div class="navigation">
        <ul>
            <li><a href="index.php">Home</a></li>

            <?php echo $menu_html; ?>
            <!--<li>
                <a href="#">Product</a>
                <ul>
                    <a href="view_products.php"><li>View Products</li></a>
                   <a href="add_product.php"> <li>Add Product</li></a>

                </ul>
            </li>
            <li>
                <a href="#">Category</a>
                <ul>
                    <a href="view_categories.php"><li>View Categories</li></a>
                    <a href="add_category.php"><li>Add Category</li></a>

                </ul>
            </li>

            <li>
                <a href="#">Pages</a>
                <ul>
                    <a href="view_pages.php"><li>View Pages</li></a>
                    <a href="add_page.php"><li>Add Page</li></a>

                </ul>
            </li>
            <li>
                <a href="dbupdate.php">DB Update</a>
            </li>
            <li class="logout-r"><a href="logout.php">Logout</a></li>-->

        </ul>
    </div>
    <div class="main-container">