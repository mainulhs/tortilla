<?php

class database
{
	private $server;
	private $username;
	private $password;
	private $database;

	function __construct($host, $user, $pass, $data)
	{
		$this->server = $host;
		$this->username = $user;
		$this->password = $pass;
		$this->database = $data;
	}

	function connect()
	{
		return mysqli_connect($this->server, $this->username, $this->password, $this->database);
	}
}

?>