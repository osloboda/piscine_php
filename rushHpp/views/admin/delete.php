<?php
require_once dirname(__DIR__, 2) . "/controllers/adminController.php";
if(isset($_GET['kind'])){
    switch ($_GET['kind']){
        case ('category'):
            deleteCategoryController($_GET['id']);
            break;
        case ('product'):
            deleteProductController($_GET['id']);
            break;
        case ('order'):
            deleteOrderController($_GET['id']);
            break;
        case ('user'):
            deleteUserController($_GET['id']);
            break;
    }
}