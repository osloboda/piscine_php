<?php

$parentDir = dirname(__DIR__, 1);
require_once $parentDir . "/models/users.php";
require_once $parentDir . "/controllers/utills/iradchen_utills.php";
require_once __DIR__ . "/utills/loginRegisterUtills.php";


checkAlreadyLoggin();

$KEYS=['E-mail', 'Password'];

function valid() {
	if (!no_empty_string_arr($_POST)) {
		return ('All fields are required');
	}

	if (!filter_var($_POST['E-mail'], FILTER_VALIDATE_EMAIL)) {
		return ('invalid email');
	}


	return (true);
}

if (all_exist($_POST, $KEYS)) {
	$msg = valid();
	if (!is_bool($msg)) {
		redirectToLocation('/login');
	}
	$pass = hash('whirlpool', $_POST['Password']);
	$is_admin = false;
	createUser([
		'Email' => $_POST['E-mail'],
		'Password_hash' => $pass,
		'Is_admin' => false
	]);
	redirectToLocation('/login');
	return ;
}