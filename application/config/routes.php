<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";

$route['admin'] = "accounts/login";
$route['accounts/login'] = "accounts/login";
$route['accounts/do_login'] = "accounts/do_login";
$route['admin/home'] = "admin/home";
$route['admin/page/home'] = "admin/page/home";
$route['admin/requestuser'] = "admin/requestuser/home";
$route['admin/printer_list'] = "admin/printer/home";
$route['admin/printer_list/entry'] = "admin/printer/entry";
$route['admin/page/entry'] = "admin/page/entry";
$route['admin/page/save_photo'] = "admin/page/save_photo";
$route['admin/printer_list/save_photo'] = "admin/printer/save_photo";
$route['admin/page/delete_photo'] = "admin/page/delete_photo";
$route['admin/printer_list/delete_photo'] = "admin/printer/delete_photo";
$route['admin/page/set_banner_photo'] = "admin/page/set_banner_photo";
$route['admin/page/set_primary_photo'] = "admin/page/set_primary_photo";
$route['admin/page/set_pri_sort_title'] = "admin/page/set_pri_sort_title";
$route['admin/printer_list/set_pri_sort_title'] = "admin/printer/set_pri_sort_title";
$route['admin/page/pri_sort_description'] ="admin/page/pri_sort_description";
$route['admin/printer_list/pri_sort_description'] ="admin/printer/pri_sort_description";
$route['admin/page/save'] = "admin/page/save";
$route['admin/printer/save'] = "admin/printer/save";
$route['admin/page/page_self_rel'] = "admin/page/page_self_rel";
$route['admin/page/set_page_gallery_rel'] = "admin/page/set_page_gallery_rel";
$route['admin/page/set_page_printer_rel'] = "admin/page/set_page_printer_rel";
$route['admin/page/remove_page_gallery_relation'] = "admin/page/remove_page_gallery_relation";
$route['admin/page/remove_page_rel'] = "admin/page/remove_page_rel";
$route['admin/page/remove_printer_rel'] = "admin/page/remove_printer_rel";
$route['admin/page/delete'] = "admin/page/delete";
$route['admin/printer/delete'] = "admin/printer/delete";
$route['admin/page/all'] = "admin/page/all";
$route['admin/printer_list/all'] = "admin/printer/all";
$route['admin/printer_list/more/(:any)'] = "admin/printer/more";
$route['admin/page/all/(:any)'] = "admin/page/all";
$route['admin/page/entry/(:any)'] = "admin/page/entry";
$route['admin/printer_list/entry/(:any)'] = "admin/printer/entry";
$route['admin/gallery'] = "admin/gallery";
$route['admin/gallery/entry'] = "admin/gallery/entry";
$route['admin/gallery/save_photo'] = "admin/gallery/save_photo";
$route['admin/gallery/delete_photo/(:any)'] = "admin/gallery/delete_photo";
$route['admin/gallery/save'] = "admin/gallery/save";
$route['admin/gallery/set_page_gallery_rel'] = "admin/gallery/set_page_gallery_rel";
$route['admin/gallery/remove_page_rel'] = "admin/gallery/remove_page_rel";
$route['admin/gallery/all'] = "admin/gallery/all";
$route['admin/gallery/entry/(:any)'] = "admin/gallery/entry";
$route['logout'] = "logout";
$route['admin/gallery/remove_page_rel'] = "admin/gallery/remove_page_rel";
$route['admin/gallery/remove_page_rel'] = "admin/gallery/remove_page_rel";
$route['admin/page/duplicate/(:any)'] = "admin/page/duplicate";
$route['admin/printer_list/duplicate/(:any)'] = "admin/printer/duplicate";
$route['admin/page/update_sort_order'] = "admin/page/update_sort_order";
$route['admin/printer/update_sort_order'] = "admin/printer/update_sort_order";
$route['admin/page/set_page_menu_rel'] = "admin/page/set_page_menu_rel";
$route['admin/page/set_page_is_published'] = "admin/page/set_page_is_published";
$route['admin/page/set_page_is_product_list_l'] = "admin/page/set_page_is_product_list_l";
$route['admin/menu'] = "admin/menu";
$route['admin/menu/all'] = "admin/menu/all";
$route['admin/menu/entry'] = "admin/menu/entry";
$route['admin/menu/entry(:any)'] = "admin/menu/entry";
$route['admin/menu/save'] = "admin/menu/save";

$route['admin/requestuser/order'] = "admin/requestuser/order";
$route['admin/requestuser/shipped'] = "admin/requestuser/shipped";
$route['admin/requestuser/order_delete_request'] = "admin/requestuser/order_delete_request";
$route['admin/requestuser/archieve_request'] = "admin/requestuser/archieve_request";
$route['admin/requestuser/all_shipped'] = "admin/requestuser/all_shipped";
$route['admin/requestuser/all_archieve'] = "admin/requestuser/all_archieve";
$route['admin/requestuser/generate_excel'] = "admin/requestuser/generate_excel";
$route['admin/requestuser/show_excel_result'] = "admin/requestuser/generate_excel";

// $route['products/(:any)'] = "product";
$route['checout/addtocart'] = "checkout/addtocart";
$route['checout/remove_addtocart'] = "checkout/remove_addtocart";
$route['checout/remove_logout'] = "checkout/remove_logout";
$route['checkout/address'] = "checkout/address";
$route['checkout/login'] = "checkout/login";
$route['checkout/register'] = "checkout/register";
$route['checkout/logged_check'] = "checkout/logged_check";
$route['checkout/shoppingcart'] = "checkout/shoppingcart";
$route['checkout/forgot_password'] = "checkout/forgot_password";
$route['checkout/send_forgot_password'] = "checkout/send_forgot_password";
$route['checkout/recover_password(:any)'] = "checkout/recover_password";
$route['checkout/send_recover_password'] = "checkout/send_recover_password";
$route['checkout/save_address'] = "checkout/save_address";
$route['checkout/save_register'] = "checkout/save_register";
$route['checkout/revieworder_info'] = "checkout/revieworder_info";
$route['checkout/pay_now'] = "checkout/pay_now";
$route['checkout/success'] = "checkout/success";
$route['checkout/paynow'] = "checkout/paynow";
$route['checkout/shipping_info'] = "checkout/shipping_info";
$route['checkout/paymentmethod_info'] = "checkout/paymentmethod_info";
$route['search_by_productno'] = "product/search_by_productno";
$route['search_by_printer'] = "product/search_by_printer";
$route['search_by_cartridge_number'] = "product/search_by_cartridge_number";
$route['contact_post'] = "checkout/contact_post";
$route['ink(:any)'] = "product/inktoner";
$route['toner(:any)'] = "product/inktoner";
$route['details(:any)'] = "product/details";
$route['pages(:any)'] = "errorhandling/index";
$route['pages'] = "errorhandling/index";
$route['test'] = "home/test";
$route['(:any)/(:any)'] = "product/printer_details";
$route['(:any)'] = "product/pages";
$route['update_shopping_cart'] = "product/update_shopping_cart";
$route['updateqty_shopping_cart'] = "product/updateqty_shopping_cart";
$route['add_related_product'] = "product/add_related_product";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */