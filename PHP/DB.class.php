<?php
class DB extends PDO {
	
	private function __construct(array $dbOptions) {
		$dns = $dbOptions['engine'] . ':dbname=' . $dbOptions['database'] . ";host=" . $dbOptions['host'];
		parent::__construct($dns, $dbOptions['user'], $dbOptions['pass']);
	}
}
?>