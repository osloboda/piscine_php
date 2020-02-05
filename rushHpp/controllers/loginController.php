<?php
	require_once dirname(__DIR__, 1). "/models/users.php";
	require_once dirname(__DIR__, 1) . "/controllers/utills/iradchen_utills.php";
	require_once __DIR__ . "/utills/loginRegisterUtills.php";

	
	checkAlreadyLoggin();

	$KEYS = ['E-mail', 'Password'];

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
		$user = gerUserByEmailAndPassword($_POST['E-mail'], $pass);

		if ($user) {
			$_SESSION['user_email'] = $user['Email'];
			$_SESSION['is_admin'] = $user['Is_admin'];
			redirectToLocation('/home');
		}
		else {
			redirectToLocation('/login');
		}
	}
