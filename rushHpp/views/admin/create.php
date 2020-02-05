<?php
require_once dirname(__DIR__, 2) . "/controllers/adminController.php";

function generateOrder($id=null) {
    $orderTemplate = file_get_contents(dirname(__DIR__, 2) . "/html/admin/forms/order.html");
    if (!$id)
        $orderTemplate = preg_replace('/{{.*}}/','', $orderTemplate);
    else if ($order = getItemByID($id, 'order')) {
        $orderTemplate = str_replace('{{ID}}',$order['id'], $orderTemplate);
        $orderTemplate = str_replace('{{USER_ID}}',$order['User_id'], $orderTemplate);
        $orderTemplate = str_replace('{{PRODUCTS}}',$order['Products'], $orderTemplate);
        $orderTemplate = str_replace('{{STATUS}}',$order['Status'], $orderTemplate);
        $orderTemplate = str_replace('{{PHONE}}',$order['Phone'], $orderTemplate);
        $orderTemplate = str_replace('{{ADDRESS}}',$order['Address'], $orderTemplate);

    }
    return $orderTemplate;
}

function generateUser($id=null) {
    $userTemplate = file_get_contents(dirname(__DIR__, 2) . "/html/admin/forms/user.html");
    if (!$id)
        $userTemplate = preg_replace('/{{.*}}/','', $userTemplate);
    else if ($user = getItemByID($id, 'user')) {
        $userTemplate = str_replace('{{ID}}',$user['id'], $userTemplate);
        $userTemplate = str_replace('{{EMAIL}}',$user['Email'], $userTemplate);
        $userTemplate = str_replace('{{PASSWORD}}',$user['Password_hash'], $userTemplate);
        if ($user['Is_admin'])
            $userTemplate = str_replace('{{CHECKED}}','checked', $userTemplate);
        else
            $userTemplate = str_replace('{{CHECKED}}','', $userTemplate);


    }
    return $userTemplate;
}

function generateProduct($id=null) {
    $productTemplate = file_get_contents(dirname(__DIR__, 2) . "/html/admin/forms/product.html");
    if (!$id)
        $productTemplate = preg_replace('/{{.*}}/','', $productTemplate);
    else if ($product = getItemByID($id, 'product')) {
        $productTemplate = str_replace('{{ID}}',$product['id'], $productTemplate);
        $productTemplate = str_replace('{{NAME}}',$product['Name'], $productTemplate);
        $productTemplate = str_replace('{{DESCRIPTION}}',$product['Description'], $productTemplate);
        $productTemplate = str_replace('{{PRICE}}',$product['Price'], $productTemplate);
        $productTemplate = str_replace('{{STACK_COUNT}}',$product['Stack_count'], $productTemplate);
        $productTemplate = str_replace('{{IMAGE_URL}}',$product['Image_url'], $productTemplate);
        $productTemplate = str_replace('{{CATEGORY_ID}}',$product['Category_id'], $productTemplate);


    }
    return $productTemplate;
}

function generateCategory($id=null) {
    $categoryTemplate = file_get_contents(dirname(__DIR__, 2) . "/html/admin/forms/category.html");
    if (!$id)
        $categoryTemplate = preg_replace('/{{.*}}/','', $categoryTemplate);
    else if ($category = getItemByID($id, 'category')) {
        $categoryTemplate = str_replace('{{ID}}',$category['id'], $categoryTemplate);
        $categoryTemplate = str_replace('{{NAME}}',$category['Name'], $categoryTemplate);

    }
    return $categoryTemplate;
}

function generatePage($id = null) {
    $html = file_get_contents(dirname(__DIR__, 2) . "/html/admin/forms/base.html");
    $kind = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $replace = '';
    switch ($kind){
        case ('category'):
            $replace = generateCategory($id);
            break;
        case ('product'):
            $replace = generateProduct($id);
            break;
        case ('user'):
            $replace = generateUser($id);
            break;
        case ('order'):
            $replace = generateOrder($id);
            break;
    }
    $html = str_replace("{{FORM}}", $replace, $html);

    echo $html;
}
if ($_POST){
    switch ($_POST['kind']){
        case ('category'):
            if (!$_POST['id'])
                addCategoryController($_POST);
            else
                updateCategoryController($_POST['id'], $_POST);
            break;
        case ('product'):
            if (!$_POST['id'])
                addProductController($_POST);
            else
                updateProductController($_POST['id'], $_POST);
            break;
        case ('user'):
            if (!$_POST['id'])
                addUserController($_POST);
            break;
        case ('order'):
            if (!$_POST['id'])
                addOrderController($_POST);
            else
                updateOrderController($_POST['id'], $_POST);
            break;
    }
} else {
    if ($_GET && $_GET['id'])
        generatePage($_GET['id']);
    else
        generatePage();
}
