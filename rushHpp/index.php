<?php

$request = $_SERVER['REQUEST_URI'];

$request = substr($request, strlen('/'));
if (!$_SESSION)
    session_start();
switch ($request) {
    case '' :
        require __DIR__ . '/views/index.php';
        break;
    case '/' :
        break;
    case 'home':
        require __DIR__ . '/views/index.php';
        break;
    case (preg_match('/cart\/add\/.*/', $request)? true : false):
        require __DIR__ . '/views/cart.php';
        break;
    case 'cart/show':
        require __DIR__ . '/views/cart.php';
        break;
    case 'cart/confirm':
        require __DIR__ . '/views/cart.php';
        break;
    case 'login' :
        require __DIR__ . '/views/login.php';
        break;
    case 'register' :
        require __DIR__ . '/views/reg_create.php';
        break;
    case 'login/confirm' :
        require __DIR__ . '/views/login_confirm.php';
        break;
    case 'signout' :
        require __DIR__ . '/controllers/logoutController.php';
        break;
    case (preg_match('/admin.*/', $request)? true : false):
        if (!$_SESSION['is_admin']){
            require __DIR__ . '/views/login.php';
            break;
        }else{
            switch ($request){
                case 'admin' :
                    require __DIR__ . '/views/admin/admin.php';
                    break;
                case (preg_match('/admin\/add\/user.*/', $request)? true : false):
                    require __DIR__ . '/views/admin/create.php';
                    break;
                case (preg_match('/admin\/add\/product.*/', $request)? true : false):
                    require __DIR__ . '/views/admin/create.php';
                    break;
                case (preg_match('/admin\/add\/category.*/', $request)? true : false):
                    require __DIR__ . '/views/admin/create.php';
                    break;
                case (preg_match('/admin\/add\/order.*/', $request)? true : false):
                    require __DIR__ . '/views/admin/create.php';
                    break;
                case (preg_match('/admin\/delete.*/', $request)? true : false):
                    require __DIR__ . '/views/admin/delete.php';
                    break;
            }
            break;
        }
    default :
        require __DIR__ . '/views/404.php';

}

