<?php
	function checkAlreadyLoggin() {
		if (isset($_SESSION['user_email'])) {
			header('location: home');
			exit ;
		}	
	}