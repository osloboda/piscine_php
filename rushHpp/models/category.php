<?php

require_once "db_connector.php";

function createCategory($params){
	global $mysqli;

    $stmt = mysqli_prepare($mysqli, "INSERT INTO Categories(Name) VALUES(?)");

	if (!$stmt) {
        error("Error insert into Categories table: ", mysqli_stmt_error($stmt));
    }

    mysqli_stmt_bind_param($stmt, 's', $params['name']);

	if (!mysqli_stmt_execute($stmt)) {
		error("Error insert into Categories table: ", mysqli_stmt_error($stmt));
	}

    
    return ;
}

function getAllCategories() {
    global $mysqli;

    $stmt = mysqli_prepare($mysqli, "SELECT Name, id FROM Categories");

    if (!$stmt) {
        error("Error get Category", mysqli_stmt_error($stmt));
    }

    if (!mysqli_stmt_execute($stmt)) {
        echo "Error get Category" . mysqli_stmt_error($stmt)."\n";
    }

    $res = mysqli_stmt_get_result($stmt);
    $ret = [];
    while($tmp = mysqli_fetch_array($res,MYSQLI_ASSOC))
        $ret[] = $tmp;
    return ($ret);
}

function getCategoryByName($name) {
    global $mysqli;

    $stmt = mysqli_prepare($mysqli, "SELECT id , Name FROM Categories WHERE name=?");

    if (!$stmt) {
        error("Error get Category", mysqli_stmt_error($stmt));
    }

    mysqli_stmt_bind_param($stmt, 's', $name);
    if (!mysqli_stmt_execute($stmt)) {
        echo "Error get Category" . mysqli_stmt_error($stmt)."\n";
    }

    $result = [
        'id' => null,
        'Name' => null
    ];

    mysqli_stmt_bind_result($stmt,
        $result['id'], $result['Name']);
    mysqli_stmt_fetch($stmt);

    return $result;
}

function getCategoryById($id) {
	global $mysqli;

	$stmt = mysqli_prepare($mysqli, "SELECT id , Name FROM Categories WHERE id=?");

	if (!$stmt) {
        error("Error get Category", mysqli_stmt_error($stmt));
    }

    mysqli_stmt_bind_param($stmt, 'i', $id);
	if (!mysqli_stmt_execute($stmt)) {
		echo "Error get Category" . mysqli_stmt_error($stmt)."\n";
	}

	$result = [
		'id' => null,
		'Name' => null
	];

	mysqli_stmt_bind_result($stmt,
		$result['id'], $result['Name']);
	mysqli_stmt_fetch($stmt);

    return $result;
}

function updateCategoryById($id, $fieldName, $value) {
	global $mysqli;

	$stmt = mysqli_prepare($mysqli, "UPDATE Categories SET $fieldName = ? WHERE id=?");

	if (!$stmt) {
        error("Error get Category", mysqli_stmt_error($stmt));
    }

    $paramType = gettype($value)[0];

    mysqli_stmt_bind_param($stmt, $paramType . 'i', $value, $id);
	if (!mysqli_stmt_execute($stmt)) {
		echo "Error get Category" . mysqli_stmt_error($stmt)."\n";
	}
	mysqli_stmt_fetch($stmt);

}

function deleteCategoryById($id) {
	global $mysqli;
    $stmt = mysqli_prepare($mysqli, "DELETE FROM Categories WHERE Id = ?");

    if (!$stmt) {
    	error("error delete Category", mysqli_stmt_error($stmt));
    }
    mysqli_stmt_bind_param($stmt, 'i', $id);
    if (!mysqli_stmt_execute($stmt)) {
        error("error delete Category", mysqli_stmt_error($stmt));
    }
    mysqli_stmt_error($stmt);
}