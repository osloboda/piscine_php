#!/usr/bin/php
<?php
    function create_categories_table($conn){
        $sql = "CREATE TABLE Categories (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                Name VARCHAR(255) NOT NULL)";
        if (mysqli_query($conn, $sql)) {
            echo "Table Categories created successfully\n";
        } else {
            echo "Error creating Categories table: " . mysqli_error($conn)."\n";
        }
    }

    function create_products_table($conn){
        $sql = "CREATE TABLE Products (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                Name VARCHAR(255) NOT NULL,
                Description TEXT NOT NULL,
                Price DOUBLE NOT NULL,
                Stack_count INT NOT NULL,
                Image_url VARCHAR(255),
                Category_id INT(6) REFERENCES Categories(id))";
        if (mysqli_query($conn, $sql)) {
            echo "Table Products created successfully\n";
        } else {
            echo "Error creating Products table: " . mysqli_error($conn)."\n";
        }
    }

    function create_users_table($conn){
        $sql = "CREATE TABLE Users (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                Email VARCHAR(320) NOT NULL,
                Password_hash VARCHAR(255) NOT NULL,
                Is_admin BOOLEAN NOT NULL)";
        if (mysqli_query($conn, $sql)) {
            echo "Table Users created successfully\n";
        } else {
            echo "Error creating Users table: " . mysqli_error($conn)."\n";
        }
    }

    function create_orders_table($conn){
        $sql = "CREATE TABLE Orders (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                User_id INT(6) REFERENCES Users(id),
                Products JSON NOT NULL,
                Status INT(6) NOT NULL,
                Phone VARCHAR(20) NOT NULL,
                Address VARCHAR(255) NOT NULL)";
        if (mysqli_query($conn, $sql)) {
            echo "Table Orders created successfully\n";
        } else {
            echo "Error creating Orders table: " . mysqli_error($conn)."\n";
        }
    }
    
    $config = include __DIR__ . '/config.php';
    $conn = mysqli_connect($config['host'], $config['user'], $config['passwd']);
    $sql = "CREATE DATABASE ".$config['database'];
    if ($conn->query($sql) === true) {
        echo "Database created successfully with the name ".$config['database']."\n";
    } else {
        echo "Database already exists\n";
    }
    require_once 'models/db_connector.php';
    $conn = $mysqli;
    create_categories_table($conn);
    create_products_table($conn);
    create_users_table($conn);
    create_orders_table($conn);