<?php
class DB {
	private static $instance;
	private $PDO;
	
	private function __construct(array $dbOptions) {
		try {
			$this->PDO = @ new PDO(	 $dbOptions['db_host'],
										$dbOptions['db_user'],
										$dbOptions['db_pass'],
										$dbOptions['db_name']);
		}
		catch( PDOException $e ) {
			echo 'Connection failed: ' . $e->getMessage();
			exit;
		}	
	}
	
	public static function init(array $dbOptions) {
		if ( self::$instance instanceof self ) {
			return false;	
		}
		
		self::$instance = new self($dbOptions);
	}
	
	public static function getPDOObject() {
		return self::$instance->PDO;	
	}
	
	public static function query($q) {
	 	return self::$instance->PDO->query($q);
	}
	
	public static function esc($str) {
		return self::$instance->PDO->real_escape_string(htmlspecialchars($str));	
	}
}
?>