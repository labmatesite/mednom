<?php
require_once 'config/config.php';

$config = get_config();
require_once $config['includes_dir'] . '/commons.php';
require_once $config['includes_dir'] . '/encoding.php';
require_once $config['includes_dir'] . '/PHPExcel.php';
require_once $config['includes_dir'] . '/SlowAES.php';
require_once $config['models_dir'] . '/admin_general.php';
require_once $config['models_dir'] . '/admin_users.php';
require_once $config['models_dir'] . '/admin_products_categories.php';
require_once $config['models_dir'] . '/admin_dm.php';
