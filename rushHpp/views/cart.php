<?php
    require_once dirname(__DIR__, 1) . "/controllers/cartController.php";

    function addToCart($id){
        addToCartController($id);
    }

    function generatePage(){
        $orderTemplate = file_get_contents(dirname(__DIR__, 1) . "/html/cart.html");
        if (isset($_SESSION['cart']))
            $orderTemplate = str_replace('{{PRODUCTS}}', $_SESSION['cart'], $orderTemplate);
        else
            $orderTemplate = str_replace('{{PRODUCTS}}', '', $orderTemplate);

        echo $orderTemplate;
    }

    if($_POST){
        confirmCart($_POST);

    } else {
        if (basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) == 'show') {
            generatePage();
        } else {
            addToCart(basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
            header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/home');

        }
    }
