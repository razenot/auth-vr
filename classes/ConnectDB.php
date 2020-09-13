<?
class ConnectDB
{
	public $pdo;
	private $host = "localhost";
	private $user = "vr";
	private $password = "12345678";
	private $db = "auth";
	private $charset = "utf8";
	private $opt = [
		PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	];

	function connect() 
	{
		$this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db;charset=$this->charset", $this->user, $this->password, $this->opt);
	}

	function closeConnect() 
	{
		$this->pdo = null;
	}
}
?>