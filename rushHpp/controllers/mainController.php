<?php
require_once dirname(__DIR__, 1) . "/models/product.php";
require_once dirname(__DIR__, 1) . "/models/category.php";

//session_start();

function getAdminHref() {
	return '/admin';
}

function getIsAdmin() {
	return $_SESSION['is_admin'];
}

function isLogin() {
	return isset($_SESSION['user_email']);
}
function getUserEmail() {
	return $_SESSION['user_email'] ?? '';
}

function getLoginLogoutHref() {
	
	return '/' . getLoginLogoutContent();
}

function getLoginLogoutContent() {
	$link = isLogin() ? 'logout' : 'login';

	return $link;	
}

function getUserEmailLinkHref() {
	return '#';
}

function getProducts() {
	if (count($_POST) > 0) {
		$products =  getProductsByCategories(array_keys($_POST));
		return $products;
	}
	return getAllProducts();
}

function getAllCategoriesController(){
    return (getAllCategories());
}

function getAllProductsController(){
    return (getAllProducts());
}