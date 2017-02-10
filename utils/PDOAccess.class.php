<?php 
require_once __DIR__."/Settings.class.php";

class PDOAccess {
	
	private $error_msg     = '';
	private $connection;
	private static $instance = null;
	
	
	private function __construct() {
		$this->openConnection();
	}
	
	public static function getInstance() {
        if (!is_null(PDOAccess::$instance)) {
            return PDOAccess::$instance;
        } else {
            PDOAccess::$instance = new PDOAccess();
            return PDOAccess::$instance;
        }
    }
	
    private function openConnection() {
		$conn = false;
		$ret = false;
        
        $dbName = Settings::get('database.database');
        $server = Settings::get('database.server');
        $server_port = Settings::get('database.server_port');
        $username = Settings::get('database.username');
        $password = Settings::get('database.password');
        
		$conn = new PDO("mysql:host=$server;dbname=$dbName;port=$server_port", $username, $password);
		unset($password); unset($dbName); unset($server); unset($server_port);     unset($username);
		if (!$conn) {
            $this->error_msg = "\r\n" . "Unable to connect to database - " . date('H:i:s');
            $ret = false;
        } else {
            $this->connection = $conn;
            $ret = true;
        }
        return $ret;
	}
	
	public static function call($procedure, $procArgs) {
        $db = PDOAccess::getInstance();
        
        if (!is_array($procArgs)) {
            $sql = "CALL $procedure ($procArgs)";
        } else {
            $sql = "CALL $procedure (".implode(', ', $procArgs).")";
        }
        
        if ((empty($sql)) || (empty($db->connection))) {
            $db->error_msg = "\r\n" . "SQL Statement or connect is <code>null</code>" . date('H:i:s');
            return false;
        }
        
        $conn = $db->connection;
        $data = array();
        if ($result = $conn->query($sql)) {
            foreach ($result as $row) {
                $data[] = $row;
            }
        }
        return empty($data) ? false : $data;
    }
	
	public static function prepareString($string) {
		$db = PDOAccess::getInstance();
		$conn = $db->connection;
		return $conn->quote($string);
	}
} 
?>

