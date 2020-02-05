<?php
$parentDir = dirname(__DIR__, 1);
require_once $parentDir . "/controllers/404.php";

?>
<!DOCTYPE html>
<html>
<head>
	<title>not found</title>
</head>
<body>
	not found
	<p><?= $request ?></p>
</body>
</html>