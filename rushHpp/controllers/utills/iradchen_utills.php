<?php
	function redirectToLocation($location) {
		header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT']. $location);
		exit ;

	}
  	function not_found() {
		header("HTTP/1.1 404 Not Found");
  		exit ;
  	}
  	function conflict() {
		header("HTTP/1.1 409 Conflict");
  		exit ;

  	}
  	function bad() {
		header("HTTP/1.1 400 Bad Request");
  		exit ;
  	}

	function all_exist($array, $keys) {
		foreach ($keys as $key) {
			if (!isset($array[$key])) {
				return (false);
			}
		}
		return (true);
	}
	function no_empty_string_arr($array) {
		foreach($array as $val) {
			if (strlen($val) < 1)
				return (false);
		}
		return (true);
	}
	function check_admin($mysqli) {
		if (!isset($_SESSION['name']) || !isset($_SESSION['admin']))
			die('Acces denied');
		if ($_SESSION['admin'] !== true)
			die('Acces denied');
		$query =  "SELECT * FROM users WHERE user_id = '" . $_SESSION['user_id'] . "' AND admin='1'";

		$stmt = mysqli_query($mysqli, $query);
		$res = mysqli_fetch_all($stmt);
		if ($res == false) {
			unset($_SESSION['admin']);
			die('Acces denied');
		}

	}