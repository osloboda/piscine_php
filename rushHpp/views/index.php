<?php

require_once dirname(__DIR__, 1) . "/controllers/mainController.php";

function generateLogin() {
    $categoryTemplate = file_get_contents(dirname(__DIR__, 1) . "/html/Login.html");
    $categories = getAllCategoriesController();
    $html = "";
    foreach ($categories as $c) {
        $html .= str_replace("{{LINK}}", $c["Name"], $categoryTemplate);
        $html = str_replace("{{TITLE}}", $c["Name"], $html);
        $html = str_replace("{{ID}}", $c["id"], $html);
    }
    return $html;
}

function generateCategories() {
    $categoryTemplate = file_get_contents(dirname(__DIR__, 1) . "/html/categoryItem.html");
    $categories = getAllCategoriesController();
    $html = "";
    foreach ($categories as $c) {
        $html .= str_replace("{{LINK}}", $c["Name"], $categoryTemplate);
        $html = str_replace("{{TITLE}}", $c["Name"], $html);
        $html = str_replace("{{ID}}", $c["id"], $html);
    }
    return $html;
}

function generateProducts() {
    $productTemplate = file_get_contents(dirname(__DIR__, 1) . "/html/productItem.html");
    $products = getAllProductsController();
    $html = "";
    foreach ($products as $p) {
        $html .= str_replace("{{IMG_SRC}}", $p["Image_url"], $productTemplate);
        $html = str_replace("{{NAME}}", $p["Name"], $html);
        $html = str_replace("{{DESCRIPTION}}", strlen($p["Description"]) > 100 ?
            mb_substr($p["Description"], 0, 100)."..." : $p["Description"], $html);
        $html = str_replace("{{ID}}", $p["id"], $html);
        $html = str_replace("{{CATEGORY_ID}}", $p["Category_id"], $html);
        $html = str_replace("{{PRICE}}", $p["Price"].'$', $html);
    }
    return $html;
}

function generatePage() {
    $html = file_get_contents(dirname(__DIR__, 1) . "/html/base.html");
    $html = str_replace("{{CATEGORIES}}", generateCategories(), $html);
    $html = str_replace("{{PRODUCTS}}", generateProducts(), $html);
    echo $html;
}

generatePage();