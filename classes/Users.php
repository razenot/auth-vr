<?
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/ConnectDB.php');

abstract class Users
{
	protected $salt = "example";
	public $error = array();

	protected function errorsCollector($errorInput, $errorMessage)
	{
		$index = count($this->error);
		$this->error[$index]["input"] = $errorInput;
		$this->error[$index]["message"] = $errorMessage;
	}

}
?>