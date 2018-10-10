<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home';
$route['404_override'] = 'Home/page_not_found';
$route['translate_uri_dashes'] = FALSE;
$route['catalogs/(:any)'] = 'Home/catalogs';
$route['(:any)'] = 'Home/routes';
$route['(:any)/(:any)'] = 'Home/routes';
$route['(:any)/(:any)/(:any)'] = 'Home/routes';
$route['(:any)/(:any)/(:any)/(:any)'] = 'Home/routes';

$route['register'] = 'Home/register';
$route['search'] = 'Home/search_products';
$route['send-enquiry'] = 'Home/send_enquiry';
$route['get-sub-cat'] = 'Home/get_subcat';
// $route['login'] = 'Home/login';
// $route['insert-user-data'] = 'Home/insert_user_data';
// $route['check-login'] = 'Home/check_login';
$route['logout'] = 'Home/logout';
$route['contact-us'] = 'Home/contact_us';
$route['about-us'] = 'Home/about_us';
$route['send-quote'] = 'Home/send_quote';
$route['compare'] = 'Home/compare';
$route['all-products'] = 'Home/all_products';

// $route['category/(:any)'] = 'Home/category';
// $route['(:any)/(:any)/(:any)'] = 'Home/description';
// $route['sub-cat-list'] = 'Home/sub_cat_list';
// $route['about-us'] = 'Home/about_us';
// $route['contact-us'] = 'Home/contact_us';
// $route['search-products'] = 'Home/search_data';
// $route['register-data'] = 'Home/register_data';
// $route['login-check'] = 'Home/login_check';
// $route['send-details'] = 'Home/send_details';
// $route['subscribe-msg'] = 'Home/subscribe_msg';
/* End of file routes.php */
/* Location: ./application/config/routes.php */
$route['disable'] = 'Distributor/disable';
$route['activate'] = 'Distributor/activate';
$route['email-check'] = 'Distributor/email_check';
$route['Distributor'] = 'Home/login';
$route['otp'] = 'Distributor/otp';
$route['verify-otp'] = 'Distributor/verify_otp';
$route['update-new-password'] = 'Distributor/update_new_password';
$route['forgot-password'] = 'Distributor/forgot_password';
$route['reset-password'] = 'Distributor/reset_password';
$route['dashboard'] = 'Distributor/dashboard';
$route['insert-user-data'] = 'Distributor/insert_user_data';
$route['check-login'] = 'Distributor/check_login';
$route['logout'] = 'Distributor/logout';
$route['sign-out'] = 'Distributor/sign_out';
$route['account'] = 'Distributor';
$route['register'] = 'Home/register';
$route['a-z-products'] = 'Home/a_z_products';