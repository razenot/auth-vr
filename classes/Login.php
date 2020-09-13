<?
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/Users.php');

class Login extends Users
{
	public $id, $name, $password;

	function __construct($name, $password)
	{
		$this->login = htmlspecialchars(trim($name));
		$this->password = $password;
	}

	public function auth()
	{
		if($this->isUserData()){

			if($this->checkUser()){

				$hash = md5(time()*rand(99,999));

				$connect = new ConnectDB();
				$connect->connect();
				$add = $connect->pdo->prepare("UPDATE users SET hash = ? WHERE id = ?");
				$add->execute(array($hash, $this->id));
				$connect->closeConnect();

				setcookie("id", $this->id, time()+60*60*24*30, "/");
				setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true);

				return true;

			}else{
				$this->errorsCollector("Логин / Пароль", "Неверный логин или пароль");
				return false;
			}

		}else{
			$this->errorsCollector("Логин / Пароль", "Заполните данные поля");
			return false;
		}
	}

	private function isUserData()
	{
		if($this->login && $this->password)
			return true;
		else
			return false;
	}

	private function checkUser()
	{
		$connect = new ConnectDB();
		$connect->connect();
		$query = $connect->pdo->prepare("SELECT * FROM users WHERE login = ? LIMIT 0,1");
		$query->execute(array($this->login));
		$connect->closeConnect();
		if (($row = $query->fetch()) == 0){
			return false;
		}else{
			if($row["login"] == $this->login && $row["password"] == md5($this->password.$this->$salt)){
				$this->id = $row["id"];
				return true;
			}else{
				return false;
			}
		}

	}

	public static function isAuth($id, $hash)
	{
		$connect = new ConnectDB();
		$connect->connect();
		$query = $connect->pdo->prepare("SELECT * FROM users WHERE id = ? LIMIT 0,1");
		$query->execute(array($id));
		$connect->closeConnect();
		if (($row = $query->fetch()) == 0){
			return false;
		}else{
			if($row["hash"] == $hash)
				return true;
			else
				return false;
		}
	}


}

?>