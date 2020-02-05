<?php
    require_once 'db_connector.php';
error_reporting(E_ALL); ini_set('display_errors', 1);
    function createOrder($params){
        $stmt = mysqli_prepare($GLOBALS['mysqli'], "INSERT INTO Orders(User_id, Products, Status, Phone, Address) VALUES(?, ?, ?, ?, ?)");

        if (!$stmt) {
            echo "Error insert into Orders table" . mysqli_error($GLOBALS['mysqli'])."\n";
            return ;
        }
        mysqli_stmt_bind_param($stmt, 'isiss', ...$params);
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error insert into Orders table" . mysqli_stmt_error($stmt) . "\n";
        }
        mysqli_stmt_error($stmt);
    }

    function deleteOrderById($id) {
        $stmt = mysqli_prepare($GLOBALS['mysqli'], "DELETE FROM Orders WHERE Id = ?");

        if (!$stmt) {
            echo "Error delete in Orders table" . mysqli_error($GLOBALS['mysqli'])."\n";
            return ;
        }
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error delete in Orders table" . mysqli_stmt_error($stmt) . "\n";
        }
        mysqli_stmt_error($stmt);
    }

    function getOrderById($id = null){
        $stmt = mysqli_prepare($GLOBALS['mysqli'], "SELECT * FROM Orders WHERE Id = ?");

        if (!$stmt) {
            echo "Error get in Orders table" . mysqli_error($GLOBALS['mysqli'])."\n";
            return null;
        }
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error get in Orders table" . mysqli_stmt_error($stmt) . "\n";
        }
        mysqli_stmt_error($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $ret = $tmp = mysqli_fetch_array($res,MYSQLI_ASSOC);
        return ($ret);
    }

    function getOrdersGroupedByStatus(){
        $statuses = getAllStatuses();
        $ret = [];
        foreach ($statuses as $status){
            $stmt = mysqli_prepare($GLOBALS['mysqli'], "SELECT * FROM Orders WHERE Status = {$status['Status']}");
        if (!$stmt) {
            echo "Error get in Orders table" . mysqli_error($GLOBALS['mysqli'])."\n";
            return null;
        }
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error get in Orders table" . mysqli_stmt_error($stmt) . "\n";
        }
        mysqli_stmt_error($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $ret[$status['Status']] = [];
        while($tmp = mysqli_fetch_array($res,MYSQLI_ASSOC))
            $ret[$status['Status']][] = $tmp;
        }
        return ($ret);
    }

    function getAllStatuses(){
        $stmt = mysqli_prepare($GLOBALS['mysqli'], "SELECT DISTINCT Status FROM Orders");

        if (!$stmt) {
            echo "Error get in Orders table" . mysqli_error($GLOBALS['mysqli'])."\n";
            return null;
        }
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error get in Orders table" . mysqli_stmt_error($stmt) . "\n";
        }
        mysqli_stmt_error($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $ret = [];
        while($tmp = mysqli_fetch_array($res,MYSQLI_ASSOC))
            $ret[] = $tmp;
        return ($ret);
    }

    function updateOrderById($params) {
        $update = "";
        $typesString = "";
        $types = [
            'user_id' => 'i',
            'products' => 's',
            'status' => 'i',
            'phone' => 's',
            'address'=> 's'
        ];
        foreach ($params as $k => $v){
            if ($k === "id")
                continue;
            $update .= "$k = ?,";
            $typesString .= $types[$k];
        }
        $update= rtrim($update,',');
        $id = $params['id'];
        unset($params['id']);
        $params['id'] = $id;
        $typesString .='i';
        $stmt = mysqli_prepare($GLOBALS['mysqli'], "UPDATE Orders SET $update WHERE id = ? ");
        if (!$stmt) {
            echo "Error update in Orders table" . mysqli_error($GLOBALS['mysqli'])."\n";
            return ;
        }
        mysqli_stmt_bind_param($stmt, $typesString, ...array_values($params));
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error update in Orders table" . mysqli_stmt_error($stmt) . "\n";
        }
        mysqli_stmt_error($stmt);
    };