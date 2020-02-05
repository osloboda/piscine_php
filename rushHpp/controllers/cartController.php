<?php
    require_once dirname(__DIR__, 1) . "/models/product.php";
    require_once dirname(__DIR__, 1) . "/models/orders.php";
require_once dirname(__DIR__, 1) . "/models/users.php";
    function getProductController($id){
        $product = getProductById($id);
        return ($product);
    }

    function createOrderController($params){
        createOrder([$params['User_id'],$params['Products'],$params['Status'],$params['Phone'],$params['Address']]);
    }

    function addToCartController($id){
        if(!isset($_SESSION['cart']))
            $_SESSION['cart'] = '';

        $product = getProductById($id);
        $cartOld = json_decode($_SESSION['cart'],true);
        if (isset($cartOld[$product['Name']])){
            $cartOld[$product['Name']] += 1;
        } else{
            $cartOld[$product['Name']] = 1;
        }
        $_SESSION['cart'] = json_encode($cartOld);

    }

    function removeFromCart($name = ''){
        $cartOld = json_decode($_SESSION['cart'],true);
        if (isset($cartOld[$name])){
           unset($cartOld[$name]);
        }
        $_SESSION['cart'] = json_encode($cartOld);
    }

    function changeCountInCart($count,$name = ''){
        if ($count <= 0)
            return;
        $cartOld = json_decode($_SESSION['cart'],true);
        if ($cartOld[$name]){
            $cartOld[$name] = $count;
        }
        $_SESSION['cart'] = json_encode($cartOld);
    }

    function confirmCart($params){
        $params['User_id'] = getUser(null, $_SESSION['user_email'])['id'];
        $params['Status'] = 0;
        createOrder([$params['User_id'],$params['Products'],$params['Status'],$params['Phone'],$params['Address']]);
        header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/home');
        unset($_SESSION['cart']);

    }