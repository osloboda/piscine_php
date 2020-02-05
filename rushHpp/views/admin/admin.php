<?php
    require_once dirname(__DIR__, 1) . "/../controllers/adminController.php";
//    require_once dirname(__DIR__, 1) . "/utils/base.php";
//    require_once dirname(__DIR__, 1) . "/utils/listUtil.php";
//    generatePage();
//
//    function generatePage(){
//        $content = generateUsersSection();
//        $content .= generateCategoriesSection();
//        $content .= generateProductsSection();
//        $content .= generateOrdersSection();
//        echo (getBaseTemplate(true,true, $content));
//    }
//
//    function generateUsersSection(){
//        $users = getAllUsersController();
//        return (getListSection($users, 'Users', 'user',['Password_hash']));
//    }
//
//    function generateCategoriesSection(){
//        $categories = getAllCategoriesController();
//        return (getListSection($categories, 'Categories', 'category',['id']));
//    }
//
//    function generateProductsSection(){
//
//        $products= getAllProductsController();
//        foreach ($products as $k =>$v){
//            $products[$k]['Category_id'] = getCategoryById($products[$k]['Category_id'])['Name'];
//        }
//        return (getListSection($products, 'Products', 'product', ['Image_url', 'Description']));
//    }
//
//    function generateOrdersSection(){
//        $orders = getAllOrdersByStatusController();
//        $subContent = "";
//        foreach ($orders as $k => $v){
//          $subContent .= getListSection($v, 'Status: '.parseStatus($k), 'order',[], false) ;
//        }
//        return (getListSectionWithoutDataParse($subContent, 'Orders', 'order', false));
//    }
//
//    function parseStatus($status){
//        switch ($status){
//            case 0:
//                return ("New");
//                break;
//            case 1:
//                return ("Waiting for delivering");
//                break;
//            case 2:
//                return ("Done");
//                break;
//            default:
//                return ("Error!");
//        }
//    }
function parseProductsInOrder($order) {
    $products = json_decode($order);
    $res = "";
    foreach ($products as $name => $count){
        $res .= '<div>'.$name.': '.$count.'</div>';
    }
    return $res;
}

function generateOrders() {
    $ordersTemplate = file_get_contents(dirname(__DIR__, 2) . "/html/admin/tables/orders.html");
    $orders = getAllOrdersByStatusController();
    $html = "";
    foreach ($orders as $status) {
        foreach ($status as $o){
            $html .= str_replace("{{USER}}",(getUserByIdController($o["User_id"])["Email"]), $ordersTemplate);
            $html = str_replace("{{ID}}",$o["id"], $html);
            $html = str_replace("{{PRODUCTS}}",parseProductsInOrder($o["Products"]), $html);
            $html = str_replace("{{STATUS}}",$o["Status"], $html);
            $html = str_replace("{{PHONE}}",$o["Phone"], $html);
            $html = str_replace("{{ADDRESS}}",$o["Address"], $html);
        }
    }
    return $html;
}

function generateProducts() {
    $productsTemplate = file_get_contents(dirname(__DIR__, 2) . "/html/admin/tables/products.html");
    $products = getAllProductsController();
    $html = "";
    foreach ($products as $p) {
        $html .= str_replace("{{ID}}", $p["id"], $productsTemplate);
        $html = str_replace("{{NAME}}",$p["Name"], $html);
        $html = str_replace("{{DESCRIPTION}}",$p["Description"], $html);
        $html = str_replace("{{PRICE}}",$p["Price"], $html);
        $html = str_replace("{{STACK_COUNT}}",$p["Stack_count"], $html);
        $html = str_replace("{{IMAGE_URL}}",$p["Image_url"], $html);
        $html = str_replace("{{Category}}",getItemByID($p["Category_id"], 'category')['Name'], $html);

    }
    return $html;
}

function generateUsers() {
    $usersTemplate = file_get_contents(dirname(__DIR__, 2) . "/html/admin/tables/users.html");
    $users = getAllUsersController();
    $html = "";
    foreach ($users as $u) {
        $html .= str_replace("{{ID}}", $u["id"], $usersTemplate);
        $html = str_replace("{{EMAIL}}", $u["Email"], $html);
        $html = str_replace("{{IS_ADMIN}}", $u["Is_admin"], $html);
    }
    return $html;
}

function generateCategories() {
    $categoryTemplate = file_get_contents(dirname(__DIR__, 2) . "/html/admin/tables/category.html");
    $categories = getAllCategoriesController();
    $html = "";
    foreach ($categories as $c) {
        $html .= str_replace("{{NAME}}", $c["Name"], $categoryTemplate);
        $html = str_replace("{{ID}}", $c["id"], $html);
    }
    return $html;
}
function generatePage() {
    $html = file_get_contents(dirname(__DIR__, 2) . "/html/admin/admin.html");
    $html = str_replace("{{CATEGORIES}}", generateCategories(), $html);
    $html = str_replace("{{ORDERS}}", generateOrders(), $html);
    $html = str_replace("{{USERS}}", generateUsers(), $html);
    $html = str_replace("{{Products}}", generateProducts(), $html);


    echo $html;
}

generatePage();
