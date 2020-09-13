<?
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/Registration.php');

$user = new Registration($_POST["name"], $_POST["login"], $_POST["email"], $_POST["password"], $_POST["confirm-password"], $_POST["address"], $_POST["check"]);

if($user->addUser())
	echo json_encode("ok");
else
	echo json_encode($user->error);
?>