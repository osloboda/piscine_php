<?php
  $parentDir = dirname(__DIR__, 1);
  
  $mysqli = connect_to_db();
     function connect_to_db(){
         $config = include($GLOBALS['parentDir'].'/config.php');
         $link = mysqli_connect($config['host'], $config['user'], $config['passwd'], $config['database']);
         if (mysqli_connect_errno()) {
             echo "Не удалось подключиться к MySQL: " . mysqli_connect_error();
             return null;
         }
         return $link;
     }

 function disconnect_from_db($link){
     mysqli_close($link);
 }
 
function error($action, $message) {
	global $mysqli;

	echo mysqli_error($mysqli) . "\n";
	echo " $action " . $message ."\n";
	exit ;
}
