<?
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/ConnectDB.php');


$connect = new ConnectDB();
$connect->connect();

$sql = "CREATE TABLE users (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(128) NOT NULL,
	login VARCHAR(64) NOT NULL,
	email VARCHAR(128) NOT NULL,
	password VARCHAR(32) NOT NULL,
	address VARCHAR(256) NULL,
	hash VARCHAR(32) NULL
)";
$add = $connect->pdo->prepare($sql);
$add->execute();
$connect->closeConnect();
echo "Таблица users создана успешно";

?>