<?php

require_once "db_connector.php";

function createProduct($params){
	global $mysqli;

    $stmt = mysqli_prepare($mysqli, "INSERT INTO Products(Name, Description, Price, Stack_count, Category_id, Image_url) VALUES(?, ?, ?, ?, ?, ?)");

	if (!$stmt) {
        error("Error insert into Products table: ", mysqli_stmt_error($stmt));
    }

    mysqli_stmt_bind_param($stmt, 'ssdiis', ...array_values($params));

	if (!mysqli_stmt_execute($stmt)) {
		error("Error insert into Products table: ", mysqli_stmt_error($stmt));
	}

    
    return ;
}

function getProductsByCategories($categories) {
    global $mysqli;

    $sql = "SELECT products.id, products.Name, products.Description, products.Price, products.Stack_count, products.Image_url, products.Category_id
    FROM products JOIN Categories ON categories.id = products.Category_id";

    $isFirst = true;

    $paramsTypes = '';

    foreach($categories as $category) {
        if ($isFirst) {
            $sql .= " WHERE categories.name = ?";
            $isFirst = false;
            $paramsTypes = 's';
            continue ;
        }
        $sql .= " OR categories.name = ?";
        $paramsTypes .= 's';
    }
    $stmt = mysqli_prepare($mysqli, $sql);

    mysqli_stmt_bind_param($stmt, $paramsTypes, ...$categories);
    if (!$stmt) {
        error("Error get product", mysqli_stmt_error($stmt));
    }

    if (!mysqli_stmt_execute($stmt)) {
        echo "Error get product" . mysqli_stmt_error($stmt)."\n";
    }

    mysqli_stmt_error($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $ret = [];
    while($tmp = mysqli_fetch_array($res,MYSQLI_ASSOC))
        $ret[] = $tmp;
    return ($ret);
}

function getAllProducts() {
    global $mysqli;

    $stmt = mysqli_prepare($mysqli, "SELECT id , Name , Description , Price , Stack_count , Category_id , Image_url FROM Products");

    if (!$stmt) {
        error("Error get product", mysqli_stmt_error($stmt));
    }

    if (!mysqli_stmt_execute($stmt)) {
        echo "Error get product" . mysqli_stmt_error($stmt)."\n";
    }

    mysqli_stmt_error($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $ret = [];
    while($tmp = mysqli_fetch_array($res,MYSQLI_ASSOC))
        $ret[] = $tmp;
    return ($ret);
}

function getProductById($id) {
	global $mysqli;

	$stmt = mysqli_prepare($mysqli, "SELECT id , Name , Description , Price , Stack_count , Category_id , Image_url FROM Products WHERE id=?");

	if (!$stmt) {
        error("Error get product", mysqli_stmt_error($stmt));
    }

    mysqli_stmt_bind_param($stmt, 'i', $id);
	if (!mysqli_stmt_execute($stmt)) {
		echo "Error get product" . mysqli_stmt_error($stmt)."\n";
	}

	$result = [
		'id' => null,
		'Name' => null,
		'Description' => null,
		'Price' => null,
		'Stack_count' => null,
		'Image_url' => null,
		'Category_id' => null,
	];

	mysqli_stmt_bind_result($stmt, 
		$result['id'], $result['Name'], 
		$result['Description'], $result['Price'],
		$result['Stack_count'], $result['Category_id'], $result['Image_url']);
	mysqli_stmt_fetch($stmt);

    return $result;
}

function updateProduct($params) {
	global $mysqli;

    $update = "";
    $typesString = "";
    $types = [
    	'name' => 's',
    	'description' => 's',
    	'price' => 'd',
    	'stack_count' => 'i',
    	'category_id' => 'i',
    	'image_url' => 's'
    ];

    foreach ($params as $k => $v){
    	if ($k === 'id') {
    		continue ;
    	}

        $update .= "$k = ?,";
        $typesString .= $types[$k];
    }
    $typesString .= 'i';
    $update= rtrim($update,',');

	$stmt = mysqli_prepare($mysqli, "UPDATE products SET $update WHERE id=?");

	$id = $params['id'];
	unset($params['id']);
	$params['id'] = $id;
	if (!$stmt) {
        error("Error get product", mysqli_stmt_error($stmt));
    }

    mysqli_stmt_bind_param($stmt, $typesString, ...array_values($params));
	if (!mysqli_stmt_execute($stmt)) {
		echo "Error get product" . mysqli_stmt_error($stmt)."\n";
	}
	mysqli_stmt_fetch($stmt);
}

function deleteProductById($id) {
	global $mysqli;
    $stmt = mysqli_prepare($mysqli, "DELETE FROM Products WHERE Id = ?");

    if (!$stmt) {
    	error("error delete product", mysqli_stmt_error($stmt));
    }
    mysqli_stmt_bind_param($stmt, 'i', $id);
    if (!mysqli_stmt_execute($stmt)) {
        error("error delete product", mysqli_stmt_error($stmt));
    }
    mysqli_stmt_error($stmt);
}