<?
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/Login.php');

$user = new Login($_POST["login"], $_POST["password"]);

if($user->auth())
	echo json_encode("ok");
else
	echo json_encode($user->error);
?>