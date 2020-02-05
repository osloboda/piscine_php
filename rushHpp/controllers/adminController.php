<?php
$parentDir = dirname(__DIR__, 1);
require_once $parentDir . "/models/users.php";
require_once $parentDir . "/models/category.php";
require_once $parentDir . "/models/product.php";
require_once $parentDir . "/models/orders.php";

    function getAllUsersController(){
        return (getUser(false,false,true));
    }

    function getAllCategoriesController(){
        return (getAllCategories());
    }

    function getAllProductsController(){
        return (getAllProducts());
    }

    function getAllOrdersByStatusController() {
        return (getOrdersGroupedByStatus());
    }

    function getUserByIdController($id) {
        return (getUser($id));
    }

    function addCategoryController($params) {
        if (isset($params['name']) && strlen($params['name']) > 0){
            createCategory($params);
            header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/admin');
        }
        else
            echo "Error adding category";
    }

    function addUserController($params) {
        if (isset($params['email']) && strlen($params['email']) > 0 &&
            preg_match('/\S*@{1}\S*\.\S*/', $params['email']) &&
            isset($params['password']) && strlen($params['password']) > 0){
            if (isset($params['is_admin']))
                $params['is_admin'] = true;
            else
                $params['is_admin'] = false;
            createUser([$params['email'], hash('whirlpool', $params['password']), $params['is_admin']]);
            header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/admin');
        }
        else
            echo "Error adding user";
    }


    function addProductController($params) {
        if (
            isset($params['name']) && strlen($params['name']) > 0 &&
            isset($params['description']) && strlen($params['description']) > 0 &&
            isset($params['price']) && floatval($params['price']) > 0 &&
            isset($params['stack_count']) &&
            isset($params['category_id']) && getCategoryById($params['category_id'])) {
            createProduct([$params['name'], $params['description'], floatval($params['price']),
                intval($params['stack_count']),$params['category_id'], $params['image_url']]);
            header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/admin');
        }
        else
            echo "Error adding product";
    }

    function addOrderController($params) {
        if (
            //User_id, Products, Status, Phone, Address
            isset($params['user_id']) &&
            isset($params['products']) && strlen($params['products']) > 0 &&
            isset($params['status']) && floatval($params['status']) > 0 &&
            isset($params['phone']) &&
            isset($params['address'])) {
            createOrder([$params['user_id'],$params['products'],$params['status'],$params['phone'],$params['address']]);
            header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/admin');
        }
        else
            echo "Error adding product";
    }


    function getItemByID($id, $kind){
        switch ($kind){
            case 'order':
                return (getOrderById($id));
            case 'user':
                return (getUser($id));
            case 'product':
                $ret = getProductById($id);
                return ($ret);
            case 'category':
                return (getCategoryById($id));
        };
        echo "Error";
        return null;
    }

    function updateProductController($id, $params){
        print_r($params);
        if (!((isset($params['Name']) && strlen($params['Name']) <= 0) ||
            (isset($params['Description']) && strlen($params['Description']) <= 0) ||
            (isset($params['Price']) && floatval($params['Price']) <= 0) ||
            ( isset($params['Image_url']) && strlen($params['Image_url']) <= 0) ||
            (isset($params['Category']) && !getCategoryByName($params['Category'])['id']))){
            if (isset($params['Category'])){
                $params['Category_id'] = getCategoryByName($params['Category'])['id'];
                unset($params['Category']);
            }
            if (isset($params['kind'])){
                unset($params['kind']);
            }
            if (isset($params['submit'])){
                unset($params['submit']);
            }
            $params['id'] = $id;
            updateProduct($params);
            header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/admin');

        }
        else
            echo "Error updating product";

    }

    function updateCategoryController($id, $params){
        if (!(isset($params['name']) && strlen($params['name']) <= 0)) {
            if (isset($params['kind'])){
                unset($params['kind']);
            }
            $params['id'] = $id;
            updateCategoryById($id,'Name', $params['name']);
            header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/admin');
        }
        else
            echo "Error updating category";
    }

    function updateOrderController($id, $params){
        if((getUser($params['user_id'])) && isset($params['phone'])){
            if (isset($params['kind'])){
                unset($params['kind']);
            }
            if (isset($params['submit'])){
                unset($params['submit']);
            }
            $params['id'] = $id;
            updateOrderById($params);
            header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/admin');

        }
        else
            echo "Error updating Order";
    }

    function updateUserController($id, $params){
        if (!((isset($params['Email']) && !preg_match('/\S*@{1}\S*\.\S*/', $params['Email'])) ||
            (isset($params['Password']) && strlen($params['Password']) <= 0))){
            if (isset($params['Is_admin']))
                $params['Is_admin'] = true;
            if (isset($params['kind'])){
                unset($params['kind']);
            }
            $params['Password_hash'] = hash('whirlpool', $params['Password']);
            unset($params['Password']);
            $params['id'] = $id;
            updateUserById($params);

            header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/admin');
        }
        else
            echo "Error updating User";
    }

    function deleteCategoryController($id){
        if ($id && getCategoryById($id)){
            deleteCategoryById($id);
            header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/admin');

        }
        else
            echo "Error deleting Category";
    }
    function deleteProductController($id){
        if ($id && getProductById($id)){
            deleteProductById($id);
                        header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/admin');

        }
        else
            echo "Error deleting Product";
    }
    function deleteOrderController($id){
        if ($id && getOrderById($id)){
            deleteOrderById($id);
            header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/admin');

        }
        else
            echo "Error deleting Order";
    }
    function deleteUserController($id){
        if ($id && getUser($id)){
            deleteUserById($id);
            header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/admin');

        }
        else
            echo "Error deleting User";
    }