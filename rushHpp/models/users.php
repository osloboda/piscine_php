<?php
    require_once 'db_connector.php';
    error_reporting(E_ALL); ini_set('display_errors', 1);
    function createUser($params){
        $stmt = mysqli_prepare($GLOBALS['mysqli'], "INSERT INTO Users(Email, Password_hash, Is_admin) VALUES(?, ?, ?)");

        if (!$stmt) {
            echo "Error insert into Users table" . mysqli_error($GLOBALS['mysqli'])."\n";
            return ;
        }
        mysqli_stmt_bind_param($stmt, 'ssi', ...array_values($params));
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error insert into Users table" . mysqli_stmt_error($stmt) . "\n";
        }
        mysqli_stmt_error($stmt);
    }

    function deleteUserById($id) {
        $stmt = mysqli_prepare($GLOBALS['mysqli'], "DELETE FROM Users WHERE Id = ?");

        if (!$stmt) {
            echo "Error delete in Users table" . mysqli_error($GLOBALS['mysqli'])."\n";
            return ;
        }
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error delete in Users table" . mysqli_stmt_error($stmt) . "\n";
        }
        mysqli_stmt_error($stmt);
    }

    function getUser($id = null, $email = null, $all = false){
        if ($all)
            $stmt = mysqli_prepare($GLOBALS['mysqli'], "SELECT * FROM Users");
        elseif ($id)
            $stmt = mysqli_prepare($GLOBALS['mysqli'], "SELECT * FROM Users WHERE Id = ?");
        else
            $stmt = mysqli_prepare($GLOBALS['mysqli'], "SELECT * FROM Users WHERE Email = ?");
        if (!$stmt) {
            echo "Error get in Users table" . mysqli_error($GLOBALS['mysqli'])."\n";
            return null;
        }
        if (!$all){
            $val = ($id) ? $id : $email;
            mysqli_stmt_bind_param($stmt, 's', $val);
        }
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error get in Users table" . mysqli_stmt_error($stmt) . "\n";
        }
        mysqli_stmt_error($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $ret = [];
        while($tmp = mysqli_fetch_array($res,MYSQLI_ASSOC))
            if ($id || $email)
                $ret = $tmp;
            else
                $ret[] = $tmp;
        return ($ret);
    }

    function gerUserByEmailAndPassword($email, $password) {

            $stmt = mysqli_prepare($GLOBALS['mysqli'], "SELECT * FROM Users WHERE Email = ? AND Password_hash=?");
            if (!$stmt) {
                echo "Error get in Users table" . mysqli_error($GLOBALS['mysqli'])."\n";
                return null;
            }
            mysqli_stmt_bind_param($stmt, 'ss', $email, $password);
            if (!mysqli_stmt_execute($stmt)) {
                echo "Error get in Users table" . mysqli_stmt_error($stmt) . "\n";
            }
            mysqli_stmt_error($stmt);
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            return ($row);
        }

    function updateUserById($params) {
        $update = "";
        $typesString = "";
        $types = [
            'Email' => 's',
            'Password_hash' => 's',
            'Is_admin' => 'i'
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
        $stmt = mysqli_prepare($GLOBALS['mysqli'], "UPDATE Users SET $update WHERE id = ? ");
        if (!$stmt) {
            echo "Error update in Users table" . mysqli_error($GLOBALS['mysqli'])."\n";
            return ;
        }
        mysqli_stmt_bind_param($stmt, $typesString, ...array_values($params));
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error update in Users table" . mysqli_stmt_error($stmt) . "\n";
        }
        mysqli_stmt_error($stmt);
    };