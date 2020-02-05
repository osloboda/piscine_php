<?php
require_once dirname(__DIR__, 1). "/models/users.php";
require_once dirname(__DIR__, 1) . "/controllers/utills/iradchen_utills.php";
require_once __DIR__ . "/utills/loginRegisterUtills.php";

//session_start();

unset($_SESSION['user_email']);
unset($_SESSION['is_admin']);
unset($_SESSION['Password_hash']);


header("Location: home");
return ;