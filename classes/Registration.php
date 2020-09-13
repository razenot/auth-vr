<?
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/Users.php');

class Registration extends Users
{
	public $name, $login, $email, $password, $conf_password, $address, $check;

	function __construct($name, $login, $email, $password, $conf_password, $address, $check)
	{
		$this->name = trim($name);
		$this->login = htmlspecialchars($login);
		$this->email = htmlspecialchars(trim($email));
		$this->password = $password;
		$this->conf_password = $conf_password;
		$this->address = htmlspecialchars(trim($address));
		$this->check = $check;
	}

	public function addUser()
	{
		if ($this->validation()) {

			if($this->checkConfirmPassword() && $this->checkLogin()){

				$salt = "example";
				$crypt_password = md5($this->password.$this->$salt);

				$connect = new ConnectDB();
				$connect->connect();
				$add = $connect->pdo->prepare("INSERT INTO users (name,login,email,password,address) VALUES (?,?,?,?,?)");
				$add->execute(array($this->name, $this->login, $this->email, $crypt_password, $this->address));
				$connect->closeConnect();
				if ($add)
					return true;
				else {
					$this->errorsCollector("Ошибка регистрации", "Произошла ошибка записи в базу данных");
					return false;
				}

			}else return false;

		}else return false;
	}


	private function validation()
	{
		// Имя
		if(!(strlen($this->name) >= 2 && strlen($this->name) <= 128)){
			$this->errorsCollector("Имя", "Длина имени может быть от 2 до 128 символов");
		}
		if(!(preg_match("#[а-яА-Яa-zA-Z0-9\s]#", $this->name))){
			$this->errorsCollector("Имя", "Имя может состоять из цифр, латиницы, кириллицы и пробелов");
		}

		// Логин
		if(!(strlen($this->login) >= 2 && strlen($this->login) <= 64)){
			$this->errorsCollector("Логин", "Длина логина может быть от 2 до 64 символов");
		}
		if(!(preg_match("#^[a-zA-Z0-9]+$#", $this->login))){
			$this->errorsCollector("Логин", "Логин может состоять из цифр и латинских букв");
		}

		// Email
		if(!(strlen($this->email) >= 5 && strlen($this->email) <= 128)){
			$this->errorsCollector("Email", "Длина имени может быть от 5 до 128 символов");
		}
		if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
			$this->errorsCollector("Email", "Адрес электонной почты является некорректным");
		}

		// Пароль
		if(!(strlen($this->password) >= 8 && strlen($this->password) <= 64)){
			$this->errorsCollector("Пароль", "Длина пароля может быть от 8 до 64 символов");
		}
		if(!(preg_match("#(?=^\S.{7,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).\S*$#", $this->password))){
			$this->errorsCollector("Пароль", "Пароль должен состоять из строчных и прописных латинских букв и цифр (могут использоваться спецсимволы).");
		}

		// Адрес
		if(!(strlen($this->address) <= 256)){
			$this->errorsCollector("Пароль", "Длина адресса может быть до 256 символов");
		}

		// Соглашение
		if(!$this->check){
			$this->errorsCollector("Согласие на обработку данных", "Согласие не получено");
		}

		if(count($this->error) == 0)
			return true;
		else
			return false;
	}

	private function checkConfirmPassword()
	{
		if($this->password == $this->conf_password)
			return true;
		else{
			$this->errorsCollector("Подтверждение пароля", "Пароли не совпадают");
			return false;
		}
	}

	private function checkLogin()
	{
		$connect = new ConnectDB();
		$connect->connect();
		$query = $connect->pdo->prepare("SELECT * FROM users WHERE login = ?");
		$query->execute(array($this->login));
		if (($row = $query->fetch()) > 0){
			$this->errorsCollector("Логин", "Такой логин уже существует");
			return false;
		}
		else
			return true;

		$connect->closeConnect();
	}

}

?>