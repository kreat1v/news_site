<?php

namespace App\Core\DB;

use \mysqli;

class ConnectionMysqli implements IConnection
{
	protected $conn;

	public function __construct($host, $user, $pass, $dbName)
	{
		$this->conn = new mysqli($host, $user, $pass, $dbName);

		$this->query("SET NAMES UTF8");

		if (!$this->conn) {
			throw new \Exception('Could not connect to DB');
		}
	}

	public function query($sql, $data = [])
	{
		if (!$this->conn) {
			return false;
		}

		$result = $this->conn->query($sql);

		if (mysqli_error($this->conn)) {
			throw new \Exception(mysqli_error($this->conn));
		}

		if (is_bool($result)) {
			return $result;
		}

		while ($row = mysqli_fetch_assoc($result)) {
			$data[] = $row;
		}

		mysqli_free_result($result);

		return $data;
	}

	public function escape($data)
	{
		return mysqli_escape_string($this->conn, $data);
	}
}