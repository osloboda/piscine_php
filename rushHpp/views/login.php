

require_once dirname(__DIR__, 1) . "/controllers/loginController.php";

function generateLoginPage()
{
    $html = file_get_contents(dirname(__DIR__, 1) . "/html/login.html");
    echo $html;
}

generateLoginPage();