<?php

class Db
{
static $db = "";
    public function __construct()
    {
       // echo "<p>Class X</p>";
		//$this->db = new EasyPDO('mysql:dbname='.DB_NAME.';host='.DB_HOST.';charset=UTF8', DB_USER, DB_PASSWORD);
    }
	static function getInstance()
    {
       // echo "<p>Class X</p>";
		self::$db = new EasyPDO('mysql:dbname='.DB_NAME.';host='.DB_HOST.';charset=UTF8', DB_USER, DB_PASSWORD);
		return self::$db;
    }
}