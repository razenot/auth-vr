<?
// Небольшое подобие MVC (представим, что попали сюда благодаря роутингу)

// Контроллер
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/Login.php');

$id = htmlspecialchars($_COOKIE["id"]);
$hash = htmlspecialchars($_COOKIE["hash"]);

if(Login::isAuth($id, $hash)){
	$user_data = getData($id);
	require_once($_SERVER['DOCUMENT_ROOT'].'/homeView.php'); // Представление
}else{
	header("Location: /");
}

// Модель
function getData($id){
	$connect = new ConnectDB();
	$connect->connect();
	$query = $connect->pdo->prepare("SELECT * FROM users WHERE id = ? LIMIT 0,1");
	$query->execute(array($id));
	$connect->closeConnect();
	$row = $query->fetch();
	return $row;
}

?>